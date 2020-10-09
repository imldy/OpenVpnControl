<?php
/*
	筑梦工作室
	Author ： 2207134109
*/
set_time_limit(0);
error_reporting(0);
//强制使用中国（上海）时区
date_default_timezone_set('Asia/Shanghai');
define('R',dirname( __FILE__));
define('RI',dirname( __FILE__).'/Core');
define('RT',dirname( __FILE__).'/Core/templates/tpl');
require(R.'/config.php');
require(R.'/full_config.php');
require(RI.'/fun/html.fun.php');
require(RI.'/fun/function.fun.php');
require(RI.'/class/T.class.php');
require(RI.'/class/D.class.php');
require(RI.'/class/C.class.php');
require(RI.'/class/F.class.php');
require(RI.'/class/U.class.php');
require(RI.'/class/File.class.php');
require(RI.'/class/Map.class.php');
require(RI.'/class/Page.class.php');
require(RI.'/class/Base.class.php');
require(RI.'/class/cInfo.class.php');
session_start();
//全局SQL注入
SqlBase::_deal();
define("_MAX_LIMIT_",(new Map())->type("cfg_app")->getValue("max_limit",100));

$action = trim(@$_GET["act"]);
define("ACT",$action);

function tip_success($msg,$url){
			echo '<div class="tip tip-success">
            
            '.$msg.',系统将在3秒后跳转。<a href="'.$url.'">等不及了！</a>
        </div> ';
        echo '<script>setTimeout(function(){
        	window.location.href="'.$url.'";
        },3000)</script>';
}
		
function tip_failed($msg,$url){
			echo '<div class="tip tip-error">
           
            '.$msg.',系统将在3秒后跳转。<a href="'.$url.'">等不及了！</a>
        </div> ';
        echo '<script>setTimeout(function(){
        	window.location.href="'.$url.'";
        },3000)</script>';

}

function systemi($line){
	$service_port = 8989;
	$address = '127.0.0.1';
	$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
	if ($socket === false) {
		$status = "error";
		$msg = "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
	}else{
	socket_set_option($socket,SOL_SOCKET,SO_RCVTIMEO,array("sec"=>10, "usec"=>0 ) );
	socket_set_option($socket,SOL_SOCKET,SO_SNDTIMEO,array("sec"=>10, "usec"=>0 ) );
	$result = socket_connect($socket, $address, $service_port);
	if($result === false) {
		$status = "error";
		$msg =  "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
	} else {
		$status = "success";
		socket_write($socket, $line, strlen($line));
		$out = socket_read($socket, 8192);
		$msg = $out;
	}
	socket_close($socket);
	return ["status"=>$status,"msg"=>$msg];
	}
}

		
		
