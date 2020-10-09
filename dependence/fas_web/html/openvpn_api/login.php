<?php
error_reporting(0);
include(dirname(dirname(__FILE__))."/system.php");
$db_host = _host_; //数据库地址（本机请输入localhsot 如果您想写 ip:端口/phpmyadmin 请速联系附近大神指导安装） 
$db_user = _user_; //数据库用户
$db_pass = _pass_; //数据库密码
$db_port = _port_; //数据库端口
$db_data = _ov_; //数据库名称

function addLog($username,$msg){
	$db = db("app_log");
	$db->insert(["user"=>$username,"value"=>$msg,"time"=>time()]);
}

function addslashesi($str){
	$tmp = explode(" ",$str);
	if(count($tmp)>1){
		die("Access die");//包含空格直接禁止登陆
	}

	$tmp2 = explode(";",$str);
	if(count($tmp2)>1){
		die("Access die");
	}

	$str = html_encode($str); //为特殊符号添加转义符号
	return $str;
}
$parm = $argv;
$username = addslashesi($parm[1]);
$password = addslashesi($parm[2]);
$remote_port = addslashesi($parm[3]);
$remote_ip = addslashesi($parm[4]);
$local_port = addslashesi($parm[5]);
$local_ip = addslashesi($parm[6]);
$proto = addslashesi($parm[7]);
$daemon_pid = addslashesi($parm[8]);

#用户名 密码 远端端口（服务器） 远端IP 本机端口 本机ip 协议
$nums = count($parm);
if($nums != 9){
	die("error parms"); //用户名或者密码为空时 禁止登录
}

if(trim($username) == "" || trim($password) == "")
{
	die("error parms"); //用户名或者密码为空时 禁止登录
}
	$db = db("openvpn");
	$info = $db->where("binary `iuser`=:username AND `pass`=:password AND irecv+isent < maxll",[":username"=>$username,":password"=>$password])->find();
	if($info){
		$m = new Map();
		$connect_unlock = $m->type("cfg_app")->getValue("connect_unlock",0);
		if($connect_unlock == 1 && $info["old"] == 0 && !$info['irecv'] && !$info['isent']){
			$cy = $info["endtime"] - $info["starttime"];
			if($info["i"] != 1){
				db(_openvpn_)->where(["id"=>$info["id"]])->update(["i"=>1,"old"=>1,"endtime"=>time()+$cy,"starttime"=>time()]);
			}
			goto SUCCESS;
			
		}
		if($info["endtime"] < time())
		{
			goto ERROR;
		}
		if($info["i"] == 1){
			goto SUCCESS;
		}else{
			goto ERROR;
		}
		
	}
	else
	{
		goto ERROR;
	}
SUCCESS:
	$db->where(["id"=>$info["id"]])->update(["online"=>1,"last_ip"=>$remote_ip,"login_time"=>time(),"remote_port"=>$remote_port,"proto"=>$proto]);
	die("success");
exit;
ERROR:
exit;