<?php
include("../head.php");
include("../nav.php");
echo '<div class="box">';
if(is_file("userdata.php")){
	include("userdata.php");
	$time = filemtime("userdata.php");
	$count = count($data);
	echo "<h3>记录时间 ".date("Y/m/d H:i:s",$time)." 共".$count."条</h3><hr>";
	foreach($data as $vo){
		echo "用户名:".$vo["user"]." 密码:".$vo["pass"]."<br>";
	}
	echo "<hr>";
}else{
	echo "您还没有生成记录哦";
}
echo "</div>";
include("../footer.php");