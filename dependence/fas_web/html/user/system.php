<?php

require dirname(dirname( __FILE__))."/system.php";
if(!$not_to_login)
{
	$username = $_SESSION["user"]["username"];
	$password = $_SESSION["user"]["password"];
	$userinfo = db("openvpn")->where([_iuser_=>$username,_ipass_=>$password])->find();
	if(!$username)
	{
		header("location:login.php?head=no");	
		exit;
	}
}
