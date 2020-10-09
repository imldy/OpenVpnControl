<?php

	//上次短信发送时间
	$system_time = time();
	$last_time = $_SESSION["last_send"] == "" ? 0 : $_SESSION["last_send"];
	$al_time = $system_time - $last_time;
?>
<style>
.main{
	background:#fff;
	padding:15px;
	border-right:1px solid #ccc;
	border-bottom:1px solid #ccc;
	border-top:1px solid #dfdfdf;
	border-left:1px solid #dfdfdf;
}
</style>
<div class="main">
<div style="height:50px"></div>
    <div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-user"></span>&nbsp;您的手机号码</label> 
        <input type="text" class="form-control" id="name" placeholder="请输入您的手机号码"> 
    </div> 
	
	<div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-lock"></span>&nbsp;密码</label> 
        <input type="password" class="form-control" id="pass" placeholder="请输入密码"> 
    </div>
	
	<div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-lock"></span>&nbsp;确认密码</label> 
        <input type="password" class="form-control" id="pass2" placeholder="请输入密码"> 
    </div>
	<div class="form-group"> 
        
        <div style="float:left;width:150px"><input type="text" class="form-control" id="code" placeholder="请输入验证码"></div>
		<div class=" col-sm-4;width:40%;" style="float:right"><button type="button" class="btn btn-primary sms" onclick="sms()" >获取验证码</button> </div>
		<div style="clear:both"></div>
	</div> 
    <button type="submit" class="btn btn-success btn-block" onclick="reg()" >注册</button> <br>
</div>

<script>
<?php
	if($al_time > 60){
		echo "var t = 60;
var allow = true;";
	}else{
		$ac = 60 - $al_time;
		echo "var t = ".$ac.";
var allow = false;
alert(\"骚等\"+t+\"秒哦\");
jsq();
";
	}
?>

function sms(){
	if($("#name").val() == ""){
		alert("请的手机号码忘记写喽！");
		return;
	}
	if($("#pass").val() != $("#pass2").val()){
		alert("两次密码输入不一致");
		return;
	}
		if(allow){
			allow = false;
		$('.sms').html('发送中...');
		
		$.post(
			'api.php?act=login_sms',{
				"username":$("#name").val(),
			},function(data){
				if(data.status == "success"){
					$('.sms').html('60s后重新获取');
					jsq();
				}else{
					$('.sms').html("获取验证码");
					allow = true;
					alert(data.msg);
				}
			
			},"JSON"
		);
		}else{
			alert("骚等"+t+"秒哦");
		}
}
function jsq(){
	setTimeout(function(){
		t--;
		$('.sms').html(""+t+'s后重新获取');
		if(t != 0){
			jsq();
		}else{
			allow = true;
			t=60;
			$('.sms').html("获取验证码");
		}
	},1000);
}
function reg(){
	if($("#name").val() == ""|| $("#pass").val() == "" || $("#code").val() == ""){
		alert("任何一项均不能为空");
	}else{
		$.post(
			'?act=reg_in',{
				"username":$("#name").val(),
				"app_key":"<?=$_GET["app_key"]?>",
				"password":$("#pass").val(),
				"code":$("#code").val()
			},function(data){
				if(data.status == "success"){
					window.location.href="mode/success.php";
				}else{
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