<?php
include("head.php");
include("nav.php");
echo '<div class="box">';
$km = db("app_kms");
$order = $km->where(["daili"=>$admin["id"]])->order("id DESC")->find();
if($order){
	$list = $km->where(["daili"=>$admin["id"],"addtime"=>$order["addtime"]])->order("id DESC")->select();
	echo "<h3>生成时间：".date("Y/m/d H:i:s",$order["addtime"])."</h3><br>";
	foreach($list as $vo){
		echo $vo["km"]."<br>";
	}
}
echo "</div>";
include("../footer.php");