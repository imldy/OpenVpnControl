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

		$data["name"] = trim($u);
		$data["pass"] = trim($p);
		$data["endtime"] = time();
		$data["time"] = time();
		$data["balance"] = 0;
		$data["type"] = 0;
		$data["qq"] = $_POST["qq"];
		$data["lock"] = 0;
		$data["content"] = "";
		if(!db("app_daili")->where(["name"=>trim($u)])->find()){
			if(db("app_daili")->insert($data)){
					echo "<script>alert(\"注册成功 请联系客服激活\");</script>";
			}else{
					echo "<script>alert(\"注册失败\");</script>";
			}
		}else{
			echo "<script>alert(\"用户名重复\");</script>";
		}
	}
}


?>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
  <div class="container aside-xxl"> <a class="navbar-brand block" href="admin.php">叮咚云控系统登录页面</a>
    <section class="panel panel-default bg-white m-t-lg">
      <header class="panel-heading text-center"> <strong>登录</strong> </header>
	   <form action="?" method="POST" class="panel-body wrapper-lg" role="form">
        <div class="form-group">
          <label class="control-label">用户名(英文或者数字 3到12位)</label>
          <input type="text" placeholder="用户名" class="form-control input-lg" name="user">
        </div>
        <div class="form-group">
          <label class="control-label">QQ</label>
          <input type="text" id="qq" placeholder="联系QQ" class="form-control input-lg" name="qq">
        </div> 
		<div class="form-group">
          <label class="control-label">密码</label>
          <input type="password" id="inputPassword" placeholder="请设置密码" class="form-control input-lg" name="pass">
        </div>     
        <button type="submit" class="btn btn-primary">注册代理</button>
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