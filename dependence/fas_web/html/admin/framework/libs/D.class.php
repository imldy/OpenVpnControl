<?php
namespace framework\libs;

use \framework\conf\Config;
use \PDO;

class D
{
    static $pdo;
    private $table;
    private $where;
    private $limit;
    private $order;
    private $sql;
    private $data;
    private $field = " * ";
    private $debug = false;

    public function __construct($table = null)
    {
        try {
            if (!self::$pdo) {
                $dsn = 'mysql:host=' . Config::$db_host . ';port=' . Config::$db_port . ';dbname=' . Config::$db_name . ';charset=' . Config::$db_charset;
                self::$pdo = new PDO($dsn, Config::$db_user, Config::$db_pass);
                self::$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
            }
            if ($table) {
                $this->table = $table;
            }
        } catch (PDOException $e) {
            $this->error($e->getMessage());
        };
    }
	public function pdo()
	{
		return self::$pdo;
	}
    public function debug()
    {
        $this->debug = true;
        return $this;
    }

    public function free()
    {
        $this->table = null;
        $this->where = null;
        $this->data = null;
        $this->field = " * ";
        $this->sql = null;
        $this->limit = null;
        $this->order = null;
    }

    private function error($msg)
    {
        die($msg);
    }

    public function getSql()
    {
        return $this->sql;
    }

    public function table($table)
    {
        if (!is_string($table)) {
            $this->error("数据库名称格式错误");
            return false;
        }
        $this->table = $table;
        return $this;
    }

    public function limit($offset, $limit = NULL)
    {
        if ($limit) {
            $this->limit = " LIMIT " . $offset . "," . $limit;
        } else {
            $this->limit = " LIMIT " . $offset;
        }
        return $this;
    }

    public function order($str)
    {
        if ($str != NULL) {
            $this->order = " ORDER BY {$str} ";
        }
        return $this;
    }

    public function fpage($page, $limit)
    {
        $npage = $page <= 0 ? 1 : $page;
        $start = ($npage - 1) * $limit;
        $this->limit = " LIMIT {$start},{$limit} ";
        return $this;
    }

    public function where($where = null, $data = [])
    {
        if ($where) {
            if (is_array($where)) {
                foreach ($where as $key => $value) {
                    $keys[] = '`' . $key . '` = :' . $key;
                    $values[':' . $key] = $value;
                }
                $this->where = ' WHERE ' . implode(" AND ", $keys) . " ";
                $this->data = $values;
            } elseif (is_string($where) && trim($where) != "") {
                $this->where = ' WHERE ' . $where;
                $this->data = $data;
            }
        }
        return $this;
    }

    public function data($data)
    {
        $this->data = $data;
        return $this;
    }

    public function select()
    {
        $this->sql = "SELECT " . $this->field . " FROM `" . $this->table . '`' . $this->where . $this->order . $this->limit;
        return $this->getRows($this->sql, $this->data);
    }

    public function update($arr, $data = [])
    {
        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                $field[] = " `{$key}`= :value_{$key}";
                $this->data[':value_' . $key] = $value;
            }
            $zd = implode(",", $field);
            $this->sql = "UPDATE {$this->table} SET {$zd}{$this->where}{$this->order}{$this->limit}";
            return $this->pdoExecSqn($this->sql, $this->data);
        } else {
            $this->sql = "UPDATE {$this->table} SET {$arr}{$this->where}{$this->order}{$this->limit}";
            return $this->pdoExecSqn($this->sql, $data);
        }
        return false;

    }

    /*
    *	add方法的别名
    */
    public function insert($data, $auto = false)
    {
        return $this->add($data, $auto);
    }

    /*
   *	数据插入的执行方法 当auto为true时，会自动补全缺失的字段，并且过滤多余的数据。
   */
    public function add($data, $auto = false)
    {
        if ($auto) {
            $fielda = $this->getfield();
            $i = 0;
            foreach ($fielda as $f) {
                $keys[] = '`' . $f['Field'] . '`';
                $fe = $f['Field'];
                $typei = explode('\(', $f[$fe]['Type']);
                $type = $typei[0]; //获取数据库字段类型
                if ($data[$fe] != NULL) {
                    $values[] = ':' . $fe . '';
                    $dataArr[':' . $fe] = $data[$fe];
                } else {
                    if ($i == 0) {
                        $values[] = 'NULL';
                    } else {
                        if ($type == 'int') {
                            $values[] = '0';
                        } else {
                            $values[] = '\'\'';
                        }
                    }
                }
                $i++;
            }
        } else {
            foreach ($data as $key => $value) {
                $keys[] = '`' . $key . '`';
                $values[] = ':' . $key;
                $dataArr[':' . $key] = $value;
            }
        }

        $dataStr = ' (' . implode(",", $keys) . ') ';
        $valueStr = ' (' . implode(",", $values) . ') ';
        $this->sql = "INSERT INTO `" . $this->table . '`' . $dataStr . ' VALUES ' . $valueStr;
        return $this->pdoExecSqn($this->sql, $dataArr);
    }

    public function getfield($name = null)
    {
        $table_name = $name == null ? $this->table : $name;
        $res = $this->pdoExecSq("SHOW FULL COLUMNS FROM {$table_name}", null, 1);
        foreach ($res as $meta) {
            $key = $meta['Field'];
            $fields[$key] = $meta;
        }
        return $fields;
    }

    public function del()
    {
        $this->sql = 'DELETE FROM `' . $this->table . '`' . $this->where . $this->order . $this->limit;
        return $this->pdoExecSqn($this->sql, $this->data);
    }

    public function delete()
    {
        return $this->del();
    }

    //public
    public function find()
    {
        $this->sql = 'SELECT ' . $this->field . ' FROM `' . $this->table . '`' . $this->where . $this->order . " LIMIT 1";
        return $this->getRow($this->sql, $this->data);
    }

    public function getRow($sql, $data = null)
    {
        if (empty($sql) || !is_string($sql)) {
            return false; //杩斿洖 false
        }
        return $this->pdoExecSq($sql, $data, 0);
    }

    public function getRows($sql, $data = null)
    {
        if (empty($sql) || !is_string($sql)) {
            return false; //杩斿洖false
        }
        return $this->pdoExecSq($sql, $data, 1);
    }

    public function field($str)
    {
        return $this->f($str);
    }

    public function f($str = null)
    {
        $zd = $str == null ? ' * ' : $str;
        $this->field = $zd;
        return $this;
    }

    public function getnums()
    {
        return $this->getCount();
    }

    //统计记录总数 常用于分页
    public function getCount()
    {
        $this->sql = 'SELECT count(*) AS count FROM ' . $this->table . $this->where;
        if ($num = $this->getRow($this->sql, $this->data)) {
            return $num['count'];
        }
        return 0;
    }

    public function showTable($type = 'Table', $from)
    {
        if ($type == 'Table') {
            $sql = 'SHOW TABLES';
        } elseif ($type == 'Field') {
            $sql = "SHOW FULL COLUMNS FROM " . $from . "";
        }
        $res = $this->pdoExecSq($sql, null, 1);
        return $res;
    }

    public function pdoExecSq($sql, $data, $one = 0)
    {
        if ($this->debug) {
            die($sql);
        }
        try {
            $stm = self::$pdo->prepare($sql);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($data as $key => $value) {
                $stm->bindValue($key, $value);
            }
            $stm->execute();
            if ($one == 0) {
                $result_arr = $stm->fetch();
            } else {
                $result_arr = $stm->fetchAll();
            }
            $row_count = $stm->rowCount();
            if ($row_count > 0) {
                return $result_arr;
            }
            return false;
        } catch (PDOException $e) {
            echo 'PDO Exception Caught: ';
            echo "Error with the database:<br>";
            echo 'SQL Query:' . sql;
            echo '<pre>';
            echo "ERROR:" . $e->getMessage() . '<br>';
            echo "Code:" . $e->getCode() . '<br>';
            echo "File:" . $e->getFile() . '<br>';
            echo "Line:" . $e->getLine() . '<br>';
            echo "Trace:" . $e->getTraceAsString() . '<br>';
            echo '</pre>';
        }

    }

    public function pdoExecSqn($sql, $data)
    {

        try {
            $stm = self::$pdo->prepare($sql);
            $stm->setFetchMode(PDO::FETCH_ASSOC);
            foreach ($data as $key => $value) {
                $stm->bindValue($key, $value);
            }
            $stm->execute();
            return $stm->rowCount();
        } catch (PDOException $e) {
            echo 'PDO Exception Caught: ';
            echo "Error with the database:<br>";
            echo 'SQL Query:' . $sql;
            echo '<pre>';
            echo "ERROR:" . $e->getMessage() . '<br>';
            echo "Code:" . $e->getCode() . '<br>';
            echo "File:" . $e->getFile() . '<br>';
            echo "Line:" . $e->getLine() . '<br>';
            echo "Trace:" . $e->getTraceAsString() . '<br>';
            echo '</pre>';
        }

    }

    public function auto_id()
    {
        return self::$pdo->lastInsertId();
    }
}