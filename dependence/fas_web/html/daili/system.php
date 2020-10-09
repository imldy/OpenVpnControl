<?php
require dirname(dirname( __FILE__))."/system.php";
if(!$login_allow)
{
	$where[] = 'name=:name'; $data[":name"]=$_SESSION["dl"]["username"];
	$where[] = 'pass=:pass'; $data[":pass"]=$_SESSION["dl"]["password"];
	$where[] = 'endtime>:time'; $data[":time"]=time();
	$admin = db("app_daili")->where(implode(" AND ",$where),$data)->find();
	if(!$admin)
	{
		header("location:login.php?head=no");	
		exit;
	}
	$data = null;
	$where = null;
	$admin_ext = db("app_daili_type")->where(["id"=>$admin["type"]])->find();
	define("DID",$admin["id"]);	
}
