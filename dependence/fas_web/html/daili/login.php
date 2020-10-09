<?php
$login_allow = true;
require("system.php");
if(ACT == "logout"){
	unset($_SESSION["dl"]);
	header("location:admin.php");
}else{

?>
<!DOCTYPE html>
<html lang="cn" class="bg-dark">
<head>
<meta charset="utf-8" />
<title>登录到系统</title>
<meta name="description" content="app, web app, responsive, admin dashboard, admin, flat, flat ui, ui kit, off screen nav" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="/css/app.v2.css" type="text/css" />
<link rel="stylesheet" href="/css/font.css" type="text/css" cache="false" />
<!--[if lt IE 9]> <script src="/js/ie/html5shiv.js" cache="false"></script> <script src="/js/ie/respond.min.js" cache="false"></script> <script src="/js/ie/excanvas.js" cache="false"></script> <![endif]-->
</head>
<body>
<?php
if(isset($_POST["user"]) && isset($_POST["pass"])){
	$u = $_POST["user"];
	$p = $_POST["pass"];
	if(trim($u) == "" || trim($p) == ""){
		echo "<script>alert(\"账户密码不能为空\");</script>";
	}else{
	$admin = db("app_daili")->where(array("name"=>$u,"pass"=>$p,"lock"=>1))->find();
		if($admin){
			if($admin["endtime"] > time()){
				$_SESSION["dl"]["username"] = $u;
				$_SESSION["dl"]["password"] = $p;
				header("location:admin.php");
			}else{
				echo "<script>alert(\"代理身份已经过期\");</script>";
			}
		}else{
			echo "<script>alert(\"密码错误或者尚未激活\");</script>";
		}
	}
}


?>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
  <div class="container aside-xxl"> <a class="navbar-brand block" href="admin.php">叮咚云控系统登录页面</a>
    <section class="panel panel-default bg-white m-t-lg">
      <header class="panel-heading text-center"> <strong>登录</strong> </header>
	   <form action="./login.php" method="POST" class="panel-body wrapper-lg" role="form">
        <div class="form-group">
          <label class="control-label">用户名</label>
          <input type="text" placeholder="example" class="form-control input-lg" name="user">
        </div>
        <div class="form-group">
          <label class="control-label">密码</label>
          <input type="password" id="inputPassword" placeholder="Password" class="form-control input-lg" name="pass">
        </div>
        <!--<div class="checkbox">
          <label>
            <input type="checkbox">
            Keep me logged in </label>
        </div>-->
        <a href="reg.php" class="pull-right m-t-xs"><small>注册</small></a>
        <button type="submit" class="btn btn-primary">登录到系统</button>
        <!--<div class="line line-dashed"></div>
        <a href="#" class="btn btn-facebook btn-block m-b-sm"><i class="fa fa-facebook pull-left"></i>Sign in with Facebook</a> <a href="#" class="btn btn-twitter btn-block"><i class="fa fa-twitter pull-left"></i>Sign in with Twitter</a>
        <div class="line line-dashed"></div>
        <p class="text-muted text-center"><small>Do not have an account?</small></p>
        <a href="signup.html" class="btn btn-default btn-block">Create an account</a>-->
      </form>
    </section>
  </div>
</section>
<!-- footer -->
<footer id="footer">
  <div class="text-center padder">
    <p> <small>筑梦科技版权所有<br>
      &copy; 2016</small> </p>
  </div>
</footer>
<!-- / footer --> <script src="js/app.v2.js"></script> <!-- Bootstrap --> <!-- App -->
</body>
</html>
<?php 
}
include("footer.php");
 ?>