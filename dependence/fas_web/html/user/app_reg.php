<?php

	//上次短信发送时间
	$system_time = time();
	$last_time = $_SESSION["last_send"] == "" ? 0 : $_SESSION["last_send"];
	$al_time = $system_time - $last_time;
?>

<div class="main">
    <div class="form-group"> 
        <label for="name"><span class="glyphicon glyphicon-user"></span>&nbsp;用户名</label> 
        <input type="text" class="form-control" id="name" placeholder="请输入您要注册的账号或者手机号码"> 
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
		<div class=" col-sm-4;width:40%;" style="float:right"><img src="/app_api/mode/check_code.php?t=<?php echo time()?>" class="ccode" onclick='$(".ccode").attr({"src":"/app_api/mode/check_code.php?t="+Date.parse(new Date())});'> </div>
		<div style="clear:both"></div>
	</div> 
    <button type="submit" class="btn btn-info btn-block" onclick="reg()"  >注册</button> <br>
	    <a type="button" href="login.php" class="btn btn-default btn-block"  >已有账号</a> <br>
</div>

<script>


function reg(){
	if($("#name").val() == ""|| $("#pass").val() == "" || $("#code").val() == ""){
		alert("任何一项均不能为空");
	}else if($("#name").val() == ""){
		alert("用户名不得为空哦");
		return;
	}else if($("#pass").val() != $("#pass2").val()){
		alert("两次密码不一致");
		return;
	}else{
		$.post(
			'reg.php?act=reg_in',{
				"username":$("#name").val(),
				"password":$("#pass").val(),
				"code":$("#code").val()
			},function(data){
				if(data.status == "success"){
					window.location.href="success.php";
				}else{
					$(".ccode").attr({"src":"/app_api/mode/check_code.php?t="+Date.parse(new Date())});
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