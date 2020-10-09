<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Cache\Adapter;

use Psr\Cache\CacheItemInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\Cache\Exception\InvalidArgumentException;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractAdapter implements AdapterInterface, LoggerAwareInterface
{
    use LoggerAwareTrait;

    private static $apcuSupported;
    private static $phpFilesSupported;

    private $namespace;
    private $deferred = array();
    private $createCacheItem;
    private $mergeByLifetime;

    /**
     * @var int|null The maximum length to enforce for identifiers or null when no limit applies
     */
    protected $maxIdLength;

    protected function __construct($namespace = '', $defaultLifetime = 0)
    {
        $this->namespace = '' === $namespace ? '' : $this->getId($namespace).':';
        if (null !== $this->maxIdLength && strlen($namespace) > $this->maxIdLength - 24) {
            throw new InvalidArgumentException(sprintf('Namespace must be %d chars max, %d given ("%s")', $this->maxIdLength - 24, strlen($namespace), $namespace));
        }
        $this->createCacheItem = \Closure::bind(
            function ($key, $value, $isHit) use ($defaultLifetime) {
                $item = new CacheItem();
                $item->key = $key;
                $item->value = $value;
                $item->isHit = $isHit;
                $item->defaultLifetime = $defaultLifetime;

                return $item;
            },
            null,
            CacheItem::class
        );
        $this->mergeByLifetime = \Closure::bind(
            function ($deferred, $namespace, &$expiredIds) {
                $byLifetime = array();
                $now = time();
                $expiredIds = array();

                foreach ($deferred as $key => $item) {
                    if (null === $item->expiry) {
                        $byLifetime[0 < $item->defaultLifetime ? $item->defaultLifetime : 0][$namespace.$key] = $item->value;
                    } elseif ($item->expiry > $now) {
                        $byLifetime[$item->expiry - $now][$namespace.$key] = $item->value;
                    } else {
                        $expiredIds[] = $namespace.$key;
                    }
                }

                return $byLifetime;
            },
            null,
            CacheItem::class
        );
    }

    public static function createSystemCache($namespace, $defaultLifetime, $version, $directory, LoggerInterface $logger = null)
    {
        if (null === self::$apcuSupported) {
            self::$apcuSupported = ApcuAdapter::isSupported();
        }

        if (!self::$apcuSupported && null === self::$phpFilesSupported) {
            self::$phpFilesSupported = PhpFilesAdapter::isSupported();
        }

        if (self::$phpFilesSupported) {
            $opcache = new PhpFilesAdapter($namespace, $defaultLifetime, $directory);
            if (null !== $logger) {
                $opcache->setLogger($logger);
            }

            return $opcache;
        }

        $fs = new FilesystemAdapter($namespace, $defaultLifetime, $directory);
        if (null !== $logger) {
            $fs->setLogger($logger);
        }
        if (!self::$apcuSupported) {
            return $fs;
        }

        $apcu = new ApcuAdapter($namespace, (int) $defaultLifetime / 5, $version);
        if (null !== $logger) {
            $apcu->setLogger($logger);
        }

        return new ChainAdapter(array($apcu, $fs));
    }

    /**
     * Fetches several cache items.
     *
     * @param array $ids The cache identifiers to fetch
     *
     * @return array|\Traversable The corresponding values found in the cache
     */
    abstract protected function doFetch(array $ids);

    /**
     * Confirms if the cache contains specified cache item.
     *
     * @param string $id The identifier for which to check existence
     *
     * @return bool True if item exists in the cache, false otherwise
     */
    abstract protected function doHave($id);

    /**
     * Deletes all items in the pool.
     *
     * @param string The prefix used for all identifiers managed by this pool
     *
     * @return bool True if the pool was successfully cleared, false otherwise
     */
    abstract protected function doClear($namespace);

    /**
     * Removes multiple items from the pool.
     *
     * @param array $ids An array of identifiers that should be removed from the pool
     *
     * @return bool True if the items were successfully removed, false otherwise
     */
    abstract protected function doDelete(array $ids);

    /**
     * Persists several cache items immediately.
     *
     * @param array $values   The values to cache, indexed by their cache identifier
     * @param int   $lifetime The lifetime of the cached values, 0 for persisting until manual cleaning
     *
     * @return array|bool The identifiers that failed to be cached or a boolean stating if caching succeeded or not
     */
    abstract protected function doSave(array $values, $lifetime);

    /**
     * {@inheritdoc}
     */
    public function getItem($key)
    {
        if ($this->deferred) {
            $this->commit();
        }
        $id = $this->getId($key);

        $f = $this->createCacheItem;
        $isHit = false;
        $value = null;

        try {
            foreach ($this->doFetch(array($id)) as $value) {
                $isHit = true;
            }
        } catch (\Exception $e) {
            CacheItem::log($this->logger, 'Failed to fetch key "{key}"', array('key' => $key, 'exception' => $e));
        }

        return $f($key, $value, $isHit);
    }

    /**
     * {@inheritdoc}
     */
    public function getItems(array $keys = array())
    {
        if ($this->deferred) {
            $this->commit();
        }
        $ids = array();

        foreach ($keys as $key) {
            $ids[] = $this->getId($key);
        }
        try {
            $items = $this->doFetch($ids);
        } catch (\Exception $e) {
            CacheItem::log($this->logger, 'Failed to fetch requested items', array('keys' => $keys, 'exception' => $e));
            $items = array();
        }
        $ids = array_combine($ids, $keys);

        return $this->generateItems($items, $ids);
    }

    /**
     * {@inheritdoc}
     */
    public function hasItem($key)
    {
        $id = $this->getId($key);

        if (isset($this->deferred[$key])) {
            $this->commit();
        }

        try {
            return $this->doHave($id);
        } catch (\Exception $e) {
            CacheItem::log($this->logger, 'Failed to check if key "{key}" is cached', array('key' => $key, 'exception' => $e));

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function clear()
    {
        $this->deferred = array();

        try {
            return $this->doClear($this->namespace);
        } catch (\Exception $e) {
            CacheItem::log($this->logger, 'Failed to clear the cache', array('exception' => $e));

            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItem($key)
    {
        return $this->deleteItems(array($key));
    }

    /**
     * {@inheritdoc}
     */
    public function deleteItems(array $keys)
    {
        $ids = array();

        foreach ($keys as $key) {
            $ids[$key] = $this->getId($key);
            unset($this->deferred[$key]);
        }

        try {
            if ($this->doDelete($ids)) {
                return true;
            }
        } catch (\Exception $e) {
        }

        $ok = true;

        // When bulk-delete failed, retry each item individually
        foreach ($ids as $key => $id) {
            try {
                $e = null;
                if ($this->doDelete(array($id))) {
                    continue;
                }
            } catch (\Exception $e) {
            }
            CacheItem::log($this->logger, 'Failed to delete key "{key}"', array('key' => $key, 'exception' => $e));
            $ok = false;
        }

        return $ok;
    }

    /**
     * {@inheritdoc}
     */
    public function save(CacheItemInterface $item)
    {
        if (!$item instanceof CacheItem) {
            return false;
        }
        $this->deferred[$item->getKey()] = $item;

        return $this->commit();
    }

    /**
     * {@inheritdoc}
     */
    public function saveDeferred(CacheItemInterface $item)
    {
        if (!$item instanceof CacheItem) {
            return false;
        }
        $this->deferred[$item->getKey()] = $item;

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function commit()
    {
        $ok = true;
        $byLifetime = $this->mergeByLifetime;
        $byLifetime = $byLifetime($this->deferred, $this->namespace, $expiredIds);
        $retry = $this->deferred = array();

        if ($expiredIds) {
            $this->doDelete($expiredIds);
        }
        foreach ($byLifetime as $lifetime => $values) {
            try {
                $e = $this->doSave($values, $lifetime);
            } catch (\Exception $e) {
            }
            if (true === $e || array() === $e) {
                continue;
            }
            if (is_array($e) || 1 === count($values)) {
                foreach (is_array($e) ? $e : array_keys($values) as $id) {
                    $ok = false;
                    $v = $values[$id];
                    $type = is_object($v) ? get_class($v) : gettype($v);
                    CacheItem::log($this->logger, 'Failed to save key "{key}" ({type})', array('key' => substr($id, strlen($this->namespace)), 'type' => $type, 'exception' => $e instanceof \Exception ? $e : null));
                }
            } else {
                foreach ($values as $id => $v) {
                    $retry[$lifetime][] = $id;
                }
            }
        }

        // When bulk-save failed, retry each item individually
        foreach ($retry as $lifetime => $ids) {
            foreach ($ids as $id) {
                try {
                    $v = $byLifetime[$lifetime][$id];
                    $e = $this->doSave(array($id => $v), $lifetime);
                } catch (\Exception $e) {
                }
                if (true === $e || array() === $e) {
                    continue;
                }
                $ok = false;
                $type = is_object($v) ? get_class($v) : gettype($v);
                CacheItem::log($this->logger, 'Failed to save key "{key}" ({type})', array('key' => substr($id, strlen($this->namespace)), 'type' => $type, 'exception' => $e instanceof \Exception ? $e : null));
            }
        }

        return $ok;
    }

    public function __destruct()
    {
        if ($this->deferred) {
            $this->commit();
        }
    }

    /**
     * Like the native unserialize() function but throws an exception if anything goes wrong.
     *
     * @param string $value
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected static function unserialize($value)
    {
        if ('b:0;' === $value) {
            return false;
        }
        $unserializeCallbackHandler = ini_set('unserialize_callback_func', __CLASS__.'::handleUnserializeCallback');
        try {
            if (false !== $value = unserialize($value)) {
                return $value;
            }
            throw new \DomainException('Failed to unserialize cached value');
        } catch (\Error $e) {
            throw new \ErrorException($e->getMessage(), $e->getCode(), E_ERROR, $e->getFile(), $e->getLine());
        } finally {
            ini_set('unserialize_callback_func', $unserializeCallbackHandler);
        }
    }

    private function getId($key)
    {
        CacheItem::validateKey($key);

        if (null === $this->maxIdLength) {
            return $this->namespace.$key;
        }
        if (strlen($id = $this->namespace.$key) > $this->maxIdLength) {
            $id = $this->namespace.substr_replace(base64_encode(hash('sha256', $key, true)), ':', -22);
        }

        return $id;
    }

    private function generateItems($items, &$keys)
    {
        $f = $this->createCacheItem;

        try {
            foreach ($items as $id => $value) {
                $key = $keys[$id];
                unset($keys[$id]);
                yield $key => $f($key, $value, true);
            }
        } catch (\Exception $e) {
            CacheItem::log($this->logger, 'Failed to fetch requested items', array('keys' => array_values($keys), 'exception' => $e));
        }

        foreach ($keys as $key) {
            yield $key => $f($key, null, false);
        }
    }

    /**
     * @internal
     */
    public static function handleUnserializeCallback($class)
    {
        throw new \DomainException('Class not found: '.$class);
    }
}
