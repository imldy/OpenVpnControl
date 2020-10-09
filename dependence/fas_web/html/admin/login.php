<?php
//本FAS系统由何以潇破解QQ1744744000  
//后台开关检测
$file = "../../FAS.lock";

if(file_exists($file))
{
    require ("error.php");
	return;
}
else
{
    echo "";
}
?>
<?php
$display_login = true;
function getClientIP()  
{  
    global $ip;  
    if (getenv("HTTP_CLIENT_IP"))  
        $ip = getenv("HTTP_CLIENT_IP");  
    else if(getenv("HTTP_X_FORWARDED_FOR"))  
        $ip = getenv("HTTP_X_FORWARDED_FOR");  
    else if(getenv("REMOTE_ADDR"))  
        $ip = getenv("REMOTE_ADDR");  
    else $ip = "Unknow";  
    return $ip;  
}  
$cip = getClientIP();
if($_GET["act"] == "do_login"){
	require("system.php");
	$last_ip_file = R."/cache/last_ip.log";
	if(isset($_POST["user"]) && isset($_POST["pass"])){
	$u = $_POST["user"];
	$p = $_POST["pass"];
	if(trim($u) == "" || trim($p) == ""){
		die(json_encode(["status"=>"error","msg"=>"信息不完整"]));
	}else{
		$last_ip = file_get_contents($last_ip_file);
		if($cip != $last_ip){
			$auth_key = trim($_POST["auth_key"]);
			$local_key = file_get_contents("/var/www/auth_key.access");
			if($auth_key == "" || $auth_key != trim($local_key)){
				die(json_encode(["status"=>"error","msg"=>"口令错误"]));
			}
		}
		$admin = db("app_admin")->where(array("username"=>$u,"password"=>$p))->find();
		if($admin){
			$_SESSION["dd"]["username"] = $u;
			$_SESSION["dd"]["password"] = $p;
			file_put_contents($last_ip_file,$cip);
			die(json_encode(["status"=>"success","msg"=>""]));
		}else{
			die(json_encode(["status"=>"error","msg"=>"密码错误"]));
		}
	}
}
}elseif($_GET["act"] == "logout"){
	require("system.php");
	unset($_SESSION["dd"]);
	header("location:admin.php");
}else{
$title="FAS后台管理登录验证";
include("head.php");
$last_ip_file = R."/cache/last_ip.log";
$last_ip = file_get_contents($last_ip_file);
?>
<style>
.login-top{
	height:280px;
	line-height:280px;
	background:#ccc;
	background-image:url("/public/images/login_top_bg.jpg");
	color:#fff;
	font-size:60px;
	padding-top:80px;
}
.login-top img{
	display:block;
	margin:auto;
}
.login-box{
	margin-left:auto;
	margin-right:auto;
	width:450px;
}
@media screen and (max-width:768px){
	.login-top{
		height:auto;
		padding-top:0px;
	}
	.login-box{
		width:auto;
		padding:10px;
	}
}
</style>
<div class="login-top text-center">
	<img src="login_logo.png" class="img-responsive">
</div>
    <section class="login-box">
        <div class="form-group">
          <input type="text" placeholder="管理员账户" class="form-control input-lg" name="user">
        </div>
        <div class="form-group">
          <input type="password" id="inputPassword" placeholder="管理员密码" class="form-control input-lg" name="pass">
        </div> 
		<?php if($cip != $last_ip){ ?>
		<div class="form-group">
          <input type="password" id="inputPassword" placeholder="请输入位于/var/www/auth_key.access处的本地口令" class="form-control input-lg" name="auth_key">
        </div>
		<p><button type="button" class="btn btn-link" onclick="javascript:$('.dbkl').toggle()">什么是本地口令？</button>
		<div class="dbkl" style="display:none;color:#222;font-size:14px;">
			本地口令，是一种不存储在数据库的本地密码。存储在<b>/var/www/auth_key.access</b>,修改文件内容本地口令也会随之更改。首次登录以及登录IP与上次不同时，会要求您输入!其目的是为了防止当数据库泄露或者密码被爆破黑客可以轻松入侵您的后台！因为本地口令不存在于数据库，所以不会被黑客截取！所以，我们强烈建议您，将本地口令与登录密码设置为不同的密码。<br>
			您可以随时通过以下方式查看：<br>
			命令行:<b>cat /var/www/auth_key.access</b><br>
			或者直接登录sftp或者ftp查看!
		</div>
		</p>
		<?php } ?>
        <button type="submit" class="btn btn-info btn-block do_login">登录</button>
	  <div class="text-center">
	  <br>
	  <br>
	  <br>
		聚力网络科技技术支持
	  </div>
    </section>
	<script>
	$(function(){
		$(".do_login").click(function(){
			var username = $("[name='user']").val();
			var password = $("[name='pass']").val();
			var auth_key = $("[name='auth_key']").val();
			if(username == "" || password == ""){
				alert("信息不完整");
			}else{
				$.post("?act=do_login",
				{
					"user":username,
					"pass":password,
					"auth_key":auth_key
				},function(data){
					if(data.status == "success"){
						window.location.href="admin.php";
					}else{
						alert(data.msg);
					}
				},"JSON");
			}
		});
	});
	</script>
<?php 
include("footer.php");
}
?>