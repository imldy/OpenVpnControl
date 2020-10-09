<?php

/**
 * Created by PhpStorm.
 * User: asus
 * Date: 2017/8/2
 * Time: 3:17
 */

class Route
{
    public static  $c; //类选择 指定某模块下的某类
    public static $a; //操作选择 某类下的某操作
    public static $path = 0;
    public static $params = [];
    public static $realDo = null;

    public static $Controller_dir;
    public static $Template_dir;
    public static $ComFile_dir;

    private static function init()
    {

        self::$Controller_dir = R . "/" . Application . "/Controller";
        self::$Template_dir = R . "/" . Application . "/Views/Templates/Home";
        self::$ComFile_dir = R . "/" . Application . "/Cache";

        $route = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : $_GET["r"];
        $params = explode(".", $route);
        $params = explode("/", ltrim($params[0],"/"));
        self::$c = !$params[0] ? "Index" : ucfirst($params[0]);
        self::$a = !isset($params[1]) ? "index" : $params[1];
        $nums = count($params);

        if ($nums > 2)
        {
            for ($i = 2; $i <= $nums; $i++) {
                self::$params[] = $params[$i];
            }
        }
    }

    public static function run()
    {
        self::init();
        self::loadModule();
    }
    public static function redirect($form,$Action)
    {
        if($form== self::$a){
            self::$realDo = self::$a;
            self::$a = $Action;
        }
    }

    private static function loadModule()
    {
        $Controller = self::$c;
        $modulePath = R . '/' . Application . '/Controller/';
        $moduleClass = $modulePath . $Controller . '.php';
        if (!file_exists($moduleClass)) {
            die('模块文件不存在！' . $moduleClass);
        } else {
            include($moduleClass);
            $Controller = $Controller . "Controller";
            if (!class_exists($Controller)) {
                die('指定的类不存在' . $modulePath . '/' . $Controller);
            }
            $system = new $Controller;
            $function =  self::$a;
            if (!method_exists($system, $function))
            {
                header("HTTP/1.1 404 Not Found");
                header("Status: 404 Not Found");
                exit;
                //die('找不到您要执行的操作'.$Controller.'->'.$function);
            }
            call_user_func_array([$system, $function],self::$params);
        }
    }
}