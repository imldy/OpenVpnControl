<?php
include('system.php');
include('api_head.php');
//include('nav.php');
function get_device_type()
{
 //全部变成小写字母
 $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
 $type = 'other';
 //分别进行判断
 if(strpos($agent, 'iphone') || strpos($agent, 'ipad'))
{
 $type = 'ios';
 } 
  
 if(strpos($agent, 'android'))
{
 $type = 'android';
 }
 return $type;
}
if(get_device_type() == "ios")
{
	include('line.php');
}else{
	echo '暂时不允许非IOS用户访问哦';
}