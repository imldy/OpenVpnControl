<?php
$mod='blank';
$title = "叮咚云控系统";
include('head.php');
include('nav.php');
?>

<?php

if($_GET["act"]=='del'){
	if(db("app_daili_type")->where(array("id"=>$_GET['id']))->delete()){
		tip_success("操作成功！",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
	}
}else{

	$rs=db("app_daili_type")->where()->order("id DESC")->select();
	$i = 1;
	if($rs){
	foreach($rs as $res)
	{ 
		echo "<div class=\"box\" style=\"margin-bottom:15px;\"><h4>名称：".$res["name"]." 折扣：".$res["per"]."%";
		echo '&nbsp;<a type="submit" href="type_add.php?act=mod&id='.$res["id"].'" class="btn btn-default">编辑</a>';
		echo '&nbsp;<a type="submit" class="btn btn-default" href="?act=del&id='.$res["id"].'" onclick="if(confirm(\'确认删除？\')){return true}else{return false;}">删除</a></h4></div>';
	}
	}else{
		echo '<div class="box">暂无数据</div>';
	}
}
?>
</div>
<?php
include("footer.php");
?>
