<?php
include("../head.php");
include("../nav.php");
echo '<div class="box">';
if(is_file("kmdata.php")){
	include("kmdata.php");
	$time = filemtime("kmdata.php");
	$count = count($km);
	echo "<h3>记录时间 ".date("Y/m/d H:i:s",$time)." 共".$count."条</h3><hr>";
	foreach($km as $vo){
		echo $vo."<br>";
	}
	echo "<hr>";
}else{
	echo "您还没有生成记录哦";
}
echo "</div>";
include("../footer.php");