<?php
use \framework\libs\T;
class C extends T
{

    public $c; //类选择 指定某模块下的某类
    public $a; //操作选择 某类下的某操作
    public $path = 0;


    /*
    *---------------------------------------------
    *		构造函数 执行地址编码的预处理
    *---------------------------------------------
    */
    function __construct()
    {

    }


    public function setPathType($type)
    {
        $this->path = $type;
    }
	
	

}
