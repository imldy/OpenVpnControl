<style>
html,body{
	background:#eaedf1;
	height:100%;
	min-height:400px;
}
a:link{
text-decoration:none;
}
a:visited{
text-decoration:none;
}
a:hover{
text-decoration:none;
}
a:active{
text-decoration:none;
}
.sile{
	width:180px;
	height:100%;
	background:#333744;
	position:fixed;
	left:0px;
	top:0px;
	min-height:550px;
	z-index:999;
}
.section{
	width:100%;
	padding:10px 0px;
}
.section>li{
	padding:0px 0px;
	margin-bottom:4px;
}
.icon{
	margin-right:10px;
	font-size:16px;
}
.angle{
	float:right;
	height:35px;
	line-height:35px;
}
.section>li>a{
	color:#aeb9c2;
	font-size:14px;
	display:block;
	padding:0px 20px;
	height:35px;
	line-height:35px;	
}
.section .section-sub{
	display:none;
	margin-top:10px;
}
.section .active>a{
	background:#42485b;
	border-right:4px solid #328cc9;
}
.section>li>a:hover{
	background:#42485b;
}
.section .active .section-sub{
	display:block;
}
.section .section-sub>li{
	margin:0px;
}
.section-sub>li>a{
	color:#999;
	font-size:14px;
	padding:0px 20px 0px 40px;
	width:100%;
	height:30px;
	line-height:30px;
	display:block;
}
.content-box{
	padding:0px;
	margin-left:180px;
	
}
.admin-logo{
	height:40px;
}
.main-top{
	background:#333744;
	height:40px;
	border-bottom:1px solid #efefef;
}
.nav-left{
	float:left;
	line-height:40px;
	height:40px;
	margin-left:20px;
}
.nav-right{
	float:right;
	line-height:40px;
	height:40px;
	margin-right:20px;
}
.nav-right a{
	color:#fff;
}
.main-gg{
	height:30px;
	line-height:30px;
	padding:0px 20px;
	margin-bottom:20px;
	background:#fff;
}
.main-gg i{
	margin-right:10px;
}
.main-gg a{
	font-size:12px;
	color:#666;
}
.content-in{
	margin:20px;
}
.icon-reorders{
		display:none;
}	
@media screen and (max-width:768px){
      /*不大于768px的设备尺寸中 响应式布局的特定样式*/
	.content-box{
		padding:0px;
		margin-left:0px;
	}
	.sile{
		display:none;
	}
	.icon-reorders{
		display:block;
	}	
}
</style>

		<div class="sile" >
		<div class="admin-logo">
		<div class="nav-left hidden-xs">
			<img src="logo.png">
		</div>
		<div class="nav-left icon-reorders">
			<i class="icon-reorder shows" style="color:#fff" ></i>	
		</div>
		</div>
<?php
function checkIfActive($string) {
	if(is_array($string)){
		$array = $string;
	}else{
		$array=explode(',',$string);
	}
	$php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	$php_self=str_replace('.php','',$php_self);
	//var_dump($array);
	if (in_array($php_self,$array)){
		return 'active';
	}else
		return null;
}

$section[] =	["name"=>"整体概览","item"=>"admin.php","icon"=>"icon-dashboard"];
$section[] =	["name"=>"用户管理","item"=>[
					["name"=>"用户列表","item"=>"user_list.php","icon"=>""]
				],"icon"=>"icon-user"];
$section[] =	["name"=>"卡密管理","item"=>"km_list.php","icon"=>"icon-shopping-cart"];
$section[] =	["name"=>"上次生成","item"=>"km_last.php","icon"=>"icon-shopping-cart"];
$section[] =	["name"=>"客服修改","item"=>"kf.php","icon"=>"icon-edit"];
$section[] =	["name"=>"消息管理","item"=>[
					["name"=>"公告管理","item"=>"list_gg.php","icon"=>""],
					["name"=>"发布公告","item"=>"add_gg.php","icon"=>""]					
				],"icon"=>"icon-comment"];
				
$section[] =	["name"=>"密码修改","item"=>"user.php","icon"=>"icon-wrench"];

	echo '<ul class="section">';
	foreach($section as $item){
		$s = explode(".",$item["item"]);
		$f[] = $s[0];
		if(is_array($item["item"])){
			foreach($item["item"] as $vo){
				$s = explode(".",$vo["item"]);
				$f[] = $s[0];
			}
		}
		
		echo '<li class="item '.checkIfActive($f).'">';
		$f = array();
		if(is_array($item["item"])){
			echo '<a href="javascript:void(0)" class="onclick-item"><i class="icon '.$item["icon"].'"> </i>'.$item["name"].'<i class="angle icon-angle-right"></i></a>';
			echo '<ul class="section-sub">';
			foreach($item["item"] as $vo){
				echo '<li><a href="'.$vo["item"].'">'.$vo["name"].'</a></li>';
			}
			echo '</ul>';
		}else{
			echo '<a href="'.$item["item"].'"><i class="icon '.$item["icon"].'"> </i>'.$item["name"].'</a>';
		}
		echo '</li>';
	}
	echo '</ul>';
?>
</div>
<div class="content-box">
	<div class="main-top">
		<div class="nav-left icon-reorders">
			<i class="icon-reorder shows" style="color:#fff" ></i>	
		</div>
		<div class="nav-right">
			<a href="login.php?act=logout">退出账号</a>
		</div>
	</div>
	<div class="main-gg">
		<i class="icon-volume-up"></i><span class="gg"><a href="#">流量卫士流控</a></span>
	</div>
	<div class="content-in">
<script>
$(function(){
	$(".onclick-item").click(function(){
		var n = $(".onclick-item").index(this);
			$(".section-sub").hide();
			$(".section-sub").eq(n).show();
	});
	$(".section>li").click(function(){
			var n = $(".section>li").index(this);
			$(".section>li").removeClass("active");
			$(".section>li").eq(n).addClass("active");
	});
	$(".shows").click(function(){
		
		$(".sile").toggle();
	});
});
</script>
<script src="js/amcharts.js" type="text/javascript"></script>
<script src="js/serial.js" type="text/javascript"></script>
<script src="js/pie.js" type="text/javascript"></script>
