<?php
if (version_compare("5.4", PHP_VERSION, ">")) {
    die("<b>PHP version must be 5.4 or later version</b>"); //PHP版本至少为5.4 否则会出现功能异常
}

use \framework\libs\Base;
set_time_limit(0);
error_reporting(0);
session_start();

define('R', dirname(dirname(__FILE__)));
define('RI', dirname(dirname(__FILE__)) . '/framework');
require(RI . '/conf/Config.php');
require(RI . '/fun/html.fun.php');
require(RI . '/fun/function.fun.php');
require(R .DIRECTORY_SEPARATOR . Application.'/comm/fun/comm.fun.php');

function __autoload($className = null)
{
	$className = explode("\\",$className);
	$className = array_pop($className);
    $systemDir = RI .DIRECTORY_SEPARATOR .'libs';
    $appDir = R .DIRECTORY_SEPARATOR .Application .DIRECTORY_SEPARATOR .'comm/libs';
    set_include_path(get_include_path() . PATH_SEPARATOR . $systemDir.PATH_SEPARATOR . $appDir);
    $className = $systemDir . DIRECTORY_SEPARATOR  . $className . '.class.php';
    if (file_exists($className))
    {
        require_once($className);
    }
    else
    {
        //die('class file' . $className . ' not found!');
    }

}
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
     //echo "<b>Custom error:</b> [$errno] $errstr<br>";
    // echo " Error on line $errline in $errfile<br>";
}
set_error_handler("myErrorHandler");
Base::_deal();