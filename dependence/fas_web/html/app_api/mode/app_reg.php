<?php

	//上次短信发送时间
	$system_time = time();
	$last_time = $_SESSION["last_send"] == "" ? 0 : $_SESSION["last_send"];
	$al_time = $system_time - $last_time;
?>
<html>
<head>
<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
<meta charset="utf-8"/>
<link href="/css/bootstrap.min.css" rel="stylesheet"/>
<script src="/css/bootstrap-theme.min.css"></script>
<script src="/css/jquery.min.js"></script>
<script src="/css/bootstrap.min.js"></script>
<title>新用户注册</title>
<style>
body,html{
	background:#efefef;
	padding:0px;
	margin:0px;
	overflow-x:hidden;
}
.main{
	margin:10px;
}
.list-group-item a{
	display:block;
}
.label-t{
	margin-bottom:20px;
}
.line{
	height:1px;
	background:#ccc;
}
</style></head>
<body></br>
<div class="main">
<div style="height:50px">
    <div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-user"></span>&nbsp;账号</label> 
        <input type="text" class="form-control" id="name" placeholder="请输入您要注册的账号"> 
    </div> 
	
	<div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-lock"></span>&nbsp;密码</label> 
        <input type="password" class="form-control" id="pass" placeholder="请输入密码"> 
    </div>
	
	<div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-lock"></span>&nbsp;确认密码</label> 
        <input type="password" class="form-control" id="pass2" placeholder="请重复输入密码"> 
    </div>
	
	<!--  此两项QQ和手机功能管理员可自行更改或开发
	<div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-envelope"></span>&nbsp;QQ</label> 
        <input type="qq" class="form-control" id="qq" placeholder="用于显示头像和密码丢失找回"> 
    </div>
	
	<div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-phone-alt"></span>&nbsp;手机号</label> 
        <input type="shouji" class="form-control" id="shouji" placeholder="用于密码丢失找回"> 
    </div>
	-->
	<div class="form-group"> 
        <div style="float:left;width:150px"><input type="text" class="form-control" id="code" placeholder="请输入验证码"></div>
		<div class=" col-sm-4;width:40%;" style="float:right"><img src="mode/check_code.php?t=<?php echo time()?>" class="ccode" onclick='$(".ccode").attr({"src":"mode/check_code.php?t="+Date.parse(new Date())});'> </div>
		<div style="clear:both"></div>
	</div> 
    <button type="submit" class="btn btn-info btn-block" onclick="reg()"  >立即注册</button> <br>
	<button type="submit" class="btn btn-warning btn-block" onclick="sysC()"  >返回登录</button> <br>
	<!--找回密码功能请自行开发！-->
	<!-- <button type="submit" class="btn btn-success btn-block" onclick="sysC()"  >找回密码</button> <br> -->
</div>

<script>


function reg(){
	if($("#name").val() == ""|| $("#pass").val() == "" || $("#code").val() == ""|| $("#pass2").val() == ""){
		alert("任何一项均不能为空哦");
		//手机和QQ写入数据库功能请自行开发！
	//}else if($("#qq").val() == ""){
	//	alert("QQ不得为空哦");
	//	return;
	//}else if($("#shouji").val() == ""){
	//	alert("手机不得为空哦");
	//	return;
	}else if($("#name").val() == ""){
		alert("账号不得为空哦");
		return;
	}else if($("#pass").val() != $("#pass2").val()){
		alert("两次密码不一致");
		return;
	}else{
		$.post(
			//'regconfig.php?act=reg_in',{
				'?act=reg_in',{
				"username":$("#name").val(),
				"password":$("#pass").val(),
				//手机和QQ写入数据库功能请自行开发！
				//"qq":$("#qq").val(),
				//"shouji":$("#shouji").val(),
				"app_key":"<?=$_GET["app_key"]?>",
				"code":$("#code").val()
			},function(data){
				if(data.status == "success"){
					window.location.href="mode/success.php";
				}else{
					$(".ccode").attr({"src":"mode/check_code.php?t="+Date.parse(new Date())});
					alert(data.msg);
				}
			},"JSON"
		)
	}
}
function sysC(){
	window.myObj.colsePage();
}
$(function() { 
        $('#myModal').modal({ 
            keyboard: true 
        }) 
    }); 
</script>
