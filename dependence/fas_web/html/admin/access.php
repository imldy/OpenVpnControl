<?php
 //去你妈的官网验证
 require("system.php");
   /* 获取远程服务器的公告 */
 $opts = array(
	 'http'=>array(
		 'method'=>"GET",
	 'timeout'=>10
	 )
 );
 $do = $_POST["do"];
 $cache=R."/cache/access.tmp";

 if($do == "getMsg" ){
	 if(is_file($cache) && time()-filemtime ($cache)<3*60){
		 $json = file_get_contents($cache);
	 }else{
		 $json = file_get_contents($cache);
	 }
	 if($json){
		 die($json);
	 }
	 die(json_encode(["status"=>"error"]));
 }else{
	 $json = file_get_contents($cache);
 }