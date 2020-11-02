<?php
$not_to_login = true;
require("system.php");
if(ACT == "logout"){
	unset($_SESSION["user"]);
	header("location:index.php");
}else{
include("api_head.php");
if(isset($_POST["username"]) && isset($_POST["password"]))
{
	$u = $_POST["username"];
	$p = $_POST["password"];
	if(trim($u) == "" || trim($p) == ""){
		echo "<script>alert(\"账户密码不能为空\");</script>";
	}else{
		$admin = db(_openvpn_)->where(array("iuser"=>$u,"pass"=>$p))->find();
		if($admin){
			$_SESSION["user"]["username"] = $u;
			$_SESSION["user"]["password"] = $p;
			header("location:index.php");
		}else{
			echo "<script>alert(\"密码错误请重新输入\");</script>";
		}
	}
}


?>
<style>
body,html{
	background:#fff;
	padding:0px;
	margin:0px;
	font-family:"微软雅黑"
}
*{
	font-family:"微软雅黑"
}

.login-view{
	height:100%;
	background:url("images/bg.jpg");
}
.login-box{
	width:400px;
	margin-top:250px;
	background:#fff;
	margin-left:auto;
	margin-right:auto;
}
.login-title{
	padding:18px 15px;
	font-size:18px;
	color:#fff;
	background:#30b1d5;
	border-bottom:1px solid #efefef;
}

.login-bottom{
	padding:15px 15px;
	font-size:18px;
	color:#333;
	border-top:1px solid #efefef;
	background:#f8f8f8;
	text-align:right;
}
@media screen and (max-width:768px){
	.login-box{
		width:100%;
		margin-top:10px;
		background:#fff;
		float:none;
	}
}
</style>
<div class="login-view ">
	<div class="container ">
	  <div class="login-box">
			<div class="login-title">
				用户登录
			</div>
		   <form action="./login.php" method="POST" class="panel-body wrapper-lg" role="form">
			<div class="input-group">
				<span class="input-group-addon"> <span class="glyphicon glyphicon-user"></span></span>
				<input type="text" placeholder="用户名" class="form-control input-lg" name="username">
			</div>
			<br>
			<div class="input-group">
			  <label class="input-group-addon"><span class="glyphicon glyphicon-eye-open"></label>
			  <input type="password" id="inputPassword" placeholder="密码" class="form-control input-lg" name="password">
			</div>
		<br>
			<button type="submit" class="btn btn-info btn-block">登录到会员中心</button>
		
		  </form>
		  	<div class="login-bottom">	
				<a href="reg.php" class=" m-t-xs"><small>注册用户</small></a>
			</div>
	  </div>
	</div>
</div>

<?php 
}
include("footer.php");
 ?>
