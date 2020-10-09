<?php
require dirname(dirname( __FILE__))."/system.php";
if(db("app_admin")->getnums()>1){
	die("Sorry，you admin user has more than one.Please check you Mysql for app_admin table.");
};	
if(!$display_login)
{
	$admin = db("app_admin")->where(["username"=>$_SESSION["dd"]["username"],"password"=>$_SESSION["dd"]["password"]])->find();
	if(!$admin)
	{
		header("location:login.php");	
		exit;
	}
}