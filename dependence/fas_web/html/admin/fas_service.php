<?php
require("system.php");
function fas_service($cmd){
//;


//cmd 注册表

$cmd = explode("&&",trim($cmd));
$cmdexp = explode(" ",trim($cmd[0]));

$cmds["vpn"]["params"] = 1;
$cmds["service"]["params"] = 2;
$cmds["service"]["params"] = 2;
$cmds["reboot"]["params"] = 0;
$cmds["/var/www/html/admin/lib/addport.sh"]["params"] = 2;
$cmds["/var/www/html/admin/lib/modWebPort.sh"]["params"] = 1;
$cmds["/var/www/html/admin/lib/make_app.sh"]["params"] = 4;
$cmds["/root/res/sha"]["params"] = 2;

if(!isset($cmds[$cmdexp[0]])){
	return ["status"=>"error","msg"=>"命令未注册 不可执行"];
}
$paramsn = $cmds[$cmdexp[0]]["params"];
for($i=0;$i<$paramsn;$i++){
	$params .= ' "'.$cmdexp[$i+1].'"';
}

$line = html_decode($cmdexp[0]).$params;
//die($line);
	return systemi($line);
}

die(json_encode(fas_service($_POST["cmd"])));