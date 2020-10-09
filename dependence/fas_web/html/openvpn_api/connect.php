<?php
require(dirname(dirname(__FILE__))."/system.php");
$username = $argv[1];
$pool_ip = $argv[2];
$pid = $argv[3];
//sdb = db("session");
//$sdb->where(["username"=>$username,"pid"=>$pid])
	->update(["pool_ip"=>$pool_ip]);