<?php
namespace framework\libs;

class T
{
    private $DirName = '';
    private $leftLimit = '{';
    private $rightLimit = '}';
    private $vars = array();

    public function load($filename)
    {
        if (!defined('INCLUDE_PATH')) {
            define('INCLUDE_PATH', 'DDCMS');
        }
        $TplFile = R . '/' . Application . '/Views/Templates/' . $filename . '.html';
        $ComFile = R . '/' . Application . '/Cache/' . md5($filename) . '.cache.php';

        if (!file_exists($TplFile)) {
            die("Template file does not exist" . $TplFile);
        }

        if (!file_exists($ComFile) || filemtime($TplFile) > filemtime($ComFile)) {
            $content = file_get_contents($TplFile);
            $cache = $this->base($content);
            $check_path = '<?php if(!defined(\'INCLUDE_PATH\')){die(\'error!this is a cache file!\');};?>';
            if (!file_put_contents($ComFile, $check_path . $cache)) {
                die($ComFile . ":Cache write failed!" . $cache);
            };
        };
        //执行编译后的文件
        //单独放置一个函数 是为了不让控制器的变量和内容的变量冲突
        $this->includeIn($ComFile);
    }



    private function includeIn($ComFile)
    {
        extract($this->vars);
        include($ComFile);
    }
	
	public function template($str)
	{
		$this->load($str);
	}

    public function set($var, $value = '')
    {
        if (is_array($var)) {
            $this->vars = $var;
        } else {
            $this->vars[$var] = $value;
        }
    }

    /*
    * 一些预定义的模板
    */
    public function tips($content)
    {
        $this->set('content', $content);
        $this->load('public_html/tips');
        exit;
    }

    public function tip($content, $url)
    {
        $this->set('content', $content);
        $this->set('url', $url);
        $this->load('public_html/tip');
        exit;
    }

    public function error($content, $url)
    {
        $this->set('content', $content);
        $this->set('url', $url);
        $this->load('public_html/error');
        exit;
    }

    private function base($str = '')
    {
        //执行PHP模板编译

        $left = preg_quote($this->leftLimit);
        $right = preg_quote($this->rightLimit);

        $left = '(\<\!\-\-)?' . $left;
        $right = $right . '(\-\-\>)?';
        $str = preg_replace_callback(  '/' . $left . '\$([a-zA-Z_\x7f-\xff])([^\}]*)\s*' . $right . '/i', function($m)
		{
			//$varName = ;
			$exp = explode(".",$m[2].$m[3]);
			$num = count($exp);
			$varName = $exp[0];
			for($i = 1;$i < $num;$i++)
			{
				$varName .= '[\''.$exp[$i].'\']';
			}
			return '<?= $'.$varName.'; ?>';
		}, $str);
        $tagArr = array(
            //'/' . $left . '\$([a-zA-Z_\x7f-\xff])([^\}]*)\s*' . $right . '/i',
            '/' . $left . '=\s*(.+?)\s*' . $right . '/i',
            '/' . $left . 'php\s*\s\s*(.+?)\s*' . $right . '/i',
            '/' . $left . ':\s*\s\s*(.+?)\s*' . $right . '/i',
            '/' . $left . '\s*if\s*\s\s*(.+?)\s*' . $right . '/i',
            '/' . $left . '\s*\/if\s*' . $right . '/i',
            '/' . $left . '\s*else\s*' . $right . '/i',
            '/' . $left . '\s*elseif\s(.+?)\s*' . $right . '/i',
            '/' . $left . '\s*loop\s(.+?)\s(.+?)\s=>\s(.+?)\s*' . $right . '/i',
            '/' . $left . '\s*loop\s(.+?)\s(.+?)\s*' . $right . '/i',
            '/' . $left . '\s*\/loop\s*' . $right . '/i',
            '/' . $left . '\s*template\((.+?)\)\s*' . $right . '/i'
        );
        $phpArr = array(
           /* '<?php echo \$$2$3;?>',*/
            '<?php echo $2;?>',
            '<?php $2;?>',
            '<?php $2;?>',
            '<?php if($2){;?>',
            '<?php }; ?>',
            '<?php }else{ ?>',
            '<?php }elseif($2){; ?>',
            '<?php unset($i);unset($n);foreach($2 as $3 => $4){$n = $i%2; ?>',
            '<?php unset($i);unset($n);foreach($2 as $3){ $n = $i%2; ?>',
            '<?php $i++;}; ?>',
            '<?php $this->template($2); ?>'
        );
       
        $str = preg_replace($tagArr, $phpArr, $str);

        /*去除多余空格 出错请注释*/
        //$str = trim($str);// 首先去掉头尾空格
        //$str = preg_replace('/\s+/',' ', $str);// 接着去掉两个空格以上的
        //$str = preg_replace('/[\n\r\t]/', ' ', $str);// 最后将非空格替换为一个空格
        //$arr = explode(" ",$str);
        //$res = $arr[0]." ".$arr[1];
        //$str = strtotime($str);

        return $str;
    }

    function systemVars()
    {

        //$this->set('_DDCMS');
    }
}

?>
