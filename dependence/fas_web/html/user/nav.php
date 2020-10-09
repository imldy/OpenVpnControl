<?php $dir = dirname(__FILE__);
$admindir = str_replace(R,"",$dir)."/";
define("ADMINDIR",$admindir);
	function checkIfActive($string) {
	if(is_array($string)){
		$array = $string;
	}else{
		$array=explode(',',$string);
	}
	//$php_self=substr($_SERVER['PHP_SELF'],strrpos($_SERVER['PHP_SELF'],'/')+1);
	$php_self=str_replace(ADMINDIR,'', $_SERVER['PHP_SELF']);
	$php_self=str_replace('.php','',$php_self);
	
	
	//echo $_SERVER['PHP_SELF'];
	//var_dump($array);
	if (in_array($php_self,$array)){
		return 'active';
	}else
		return null;
	}
?>
<nav class="navbar navbar-default" role="navigation" style="margin-bottom:0px;">
    <div class="container-fluid">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse"
                data-target="#example-navbar-collapse">
            <span class="sr-only">切换导航</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">用户中心</a>
    </div>
    <div class="collapse navbar-collapse" id="example-navbar-collapse">
        <ul class="nav navbar-nav">
            <li class="<?php echo checkIfActive("index")?>"><a href="index.php">详情与充值</a></li>
            <li class="<?php echo checkIfActive("mod")?>"><a href="mod.php">密码修改</a></li>
            <li class="<?php echo checkIfActive("iosline")?>"><a href="iosline.php">线路安装</a></li>
            <li ><a href="login.php?act=logout">退出账号</a></li>
   
        </ul>
    </div>
    </div>
</nav>
<div style="background:#fff;padding:10px;margin:10px;">