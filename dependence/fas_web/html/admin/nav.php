<div class="sile" >
		<div class="admin-logo  hidden-xs">
		<div class="nav-left hidden-xs">
			<img src="/admin/logo.png" class="admin-logo" style="margin-top:0px;width:130px;">
		</div>
		</div>	<div class="nav-left icon-reorders">
			<i class="icon-reorder shows" style="color:#fff;margin-left:15px;" ></i>	
		</div>
<?php

$dir = dirname(__FILE__);
$admindir = str_replace(str_replace('\\','/',R),"",str_replace('\\','/',$dir))."/";
define("ADMINDIR",$admindir);


function checkIfActive($string) {
	if(is_array($string)){
		$array = $string[0];
	}else{
		$array=explode(',',$string);
	}
	$php_self=str_replace(ADMINDIR,'', $_SERVER['PHP_SELF']);
	$php_self=str_replace('.php','',$php_self);
	if (in_array($php_self,$array)){
		return $string[1][$php_self] ;
	}
	return false;
}

$section[] =	["name"=>"整体概览","item"=>"admin.php","icon"=>"icon-dashboard"];
$section[] =	["name"=>"用户管理","item"=>[
					["name"=>"账号批量生成","item"=>"user_create.php","icon"=>""],
					["name"=>"上次生成","item"=>"lastkm/user.php","icon"=>""],
					["name"=>"新增用户","item"=>"user_add.php","icon"=>""],
					["name"=>"用户列表","item"=>"user_list.php","icon"=>""],
					["name"=>"在线用户","item"=>"online.php","icon"=>""]
				],"icon"=>"icon-user"];
$section[] =	["name"=>"线路管理","item"=>[
					["name"=>"证书管理","item"=>"zs.php","icon"=>""],
					["name"=>"线路列表","item"=>"line_list.php","icon"=>""],
					["name"=>"新增线路","item"=>"line_add.php","icon"=>""],
					["name"=>"分类管理","item"=>"cat_add.php","icon"=>""]
				],"icon"=>"icon-reorder"];
$section[] =	["name"=>"套餐管理","item"=>[
					["name"=>"套餐管理","item"=>"list_tc.php","icon"=>""],
					["name"=>"新增套餐","item"=>"add_tc.php","icon"=>""],
					["name"=>"卡密管理","item"=>"km_list.php","icon"=>""],
					["name"=>"上次生成","item"=>"lastkm/index.php","icon"=>""]
				],"icon"=>"icon-shopping-cart"];
		
$section[] =	["name"=>"负载管理","item"=>[
					["name"=>"宽带监控","item"=>"net.php","icon"=>""],
					["name"=>"添加节点","item"=>"note_add.php","icon"=>""],
					["name"=>"节点管理","item"=>"note_list.php","icon"=>""],
					["name"=>"添加服务器","item"=>"fwq_add.php","icon"=>""],
					["name"=>"服务器列表","item"=>"fwq_list.php","icon"=>""]
				],"icon"=>"icon-sitemap"];
$section[] =	["name"=>"消息管理","item"=>[
					["name"=>"反馈管理","item"=>"feedback.php","icon"=>""],
					["name"=>"公告管理","item"=>"list_gg.php","icon"=>""],
					["name"=>"发布公告","item"=>"add_gg.php","icon"=>""]					
				],"icon"=>"icon-comment"];
$section[] =	["name"=>"APP管理","item"=>[
					["name"=>"APP生成","item"=>"create_app.php","icon"=>""],
					["name"=>"APP设置","item"=>"qq_admin.php","icon"=>""],
					["name"=>"升级与推送","item"=>"AdminShengji.php","icon"=>""]
				],"icon"=>"icon-group"];
$section[] =	["name"=>"代理管理","item"=>[
					["name"=>"新增等级","item"=>"type_add.php","icon"=>""],
					["name"=>"等级列表","item"=>"type_list.php","icon"=>""],
					["name"=>"新增代理","item"=>"dl_add.php","icon"=>""],
					["name"=>"代理列表","item"=>"dl_list.php","icon"=>""]
				],"icon"=>"icon-tags"];
$section[] =	["name"=>"交易管理","item"=>[
					["name"=>"收支管理","item"=>"pay_user.php","icon"=>""],
					["name"=>"商品管理","item"=>"goods.php","icon"=>""],
					["name"=>"参数配置","item"=>"pay.php","icon"=>""]
				],"icon"=>"icon-shopping-cart"];

$section[] =	["name"=>"安全管理","item"=>[
					["name"=>"数据备份","item"=>"mysql.php","icon"=>""],
					["name"=>"DNS拦截","item"=>"hosts.php","icon"=>""],
					["name"=>"密码修改","item"=>"user.php","icon"=>""],
				],"icon"=>"icon-lock"];
$section[] =	["name"=>"高级设置","item"=>[
					["name"=>"高级管理","item"=>"safe.php","icon"=>""],
					["name"=>"限速管理","item"=>"float.php","icon"=>""]
				],"icon"=>"icon-wrench"];

	echo '<ul class="section">';
	
	$nav_name = "";
	foreach($section as $item){
		$s = explode(".",$item["item"]);
		$f[0][] = $s[0];
		$f[1][$s[0]] = $item["name"];
		if(is_array($item["item"])){
			foreach($item["item"] as $vo){
				$s = explode(".",$vo["item"]);
				$f[0][] = $s[0];
				$f[1][$s[0]] = $vo["name"];
			}
		}
		$active = "";
		if($isact = checkIfActive($f))
		{	
			$nav_name = $isact;
			$active = "active";
		}
		echo '<li class="item '.$active.'">';
		$f = [];
		if(is_array($item["item"])){
			echo '<a href="javascript:void(0)" class="onclick-item"><i class="icon '.$item["icon"].' nav-icon"> </i>'.$item["name"].'<i class="angle icon-angle-right"></i></a>';
			echo '<ul class="section-sub">';
			foreach($item["item"] as $vo){
				echo '<li><a href="'.$admindir.$vo["item"].'" class="nav-item">'.$vo["name"].'</a></li>';
			}
			echo '</ul>';
		}else{
			echo '<a href="'.$admindir.$item["item"].'" class="nav-item"><i class="icon '.$item["icon"].' nav-icon"> </i>'.$item["name"].'</a>';
		}
		echo '</li>';
	}
	echo '</ul>';
?>
</div>
<div class="content-box">
	<div class="main-top-box">
		<div class="main-top">
			<div>
				<div class="nav-left icon-reorders">
					<i class="icon-reorder shows" style="color:#fff;" ></i>	
				</div>
				<div class="text-center top-tips"><i class="icon-volume-up  hidden-xs"></i>&nbsp;&nbsp;<span></span></div>
				<div class="nav-right hidden-xs">
					<a href="mysql.php" class="btn btn-info"><i class="icon-hdd"></i>&nbsp;&nbsp;数据备份</a>
					<a href="line_list.php" class="btn btn-info"><i class="icon-reorder"></i>&nbsp;&nbsp;线路管理</a>
					<a href="login.php?act=logout" class="btn btn-success"><i class="icon-signout"></i>&nbsp;&nbsp;退出账号</a>
				</div>
				<div style="clear:both"></div>
				<div class="gonggao"><p>公告测试</p>
				<div class="text-right">
					点击以后此公告不再提醒&nbsp;>>&nbsp;&nbsp;&nbsp;<button href="login.php?act=logout" class="btn btn-default btn-sm gonggao-ok">我知道了</button>
				</div></div>
				
			</div>
		</div>
	</div>
	<div class="content-in">
	<div class="box-title">
		<i class="icon-dashboard"></i>&nbsp;控制台首页&nbsp;&nbsp;<i class=" icon-angle-right"></i>&nbsp;&nbsp;<?=$nav_name?>
	</div>
