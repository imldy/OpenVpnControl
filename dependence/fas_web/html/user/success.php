<?php
require("api_head.php");
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
    <span class="glyphicon glyphicon-ok" style="color: rgb(159, 219, 60); font-size: 38px;"> 注册成功</span>
	<hr>
	<div class="alert alert-success">
		恭喜您，您已经成功的完成了账户申请！赶快用您申请的账户登录吧！
	</div>

    <a type="submit" class="btn btn-success btn-block" href="login.php" >马上登陆</a> <br>
</div>

<script>
function sysC(){
	window.myObj.colsePage();
}
$(function() { 
        $('#myModal').modal({ 
            keyboard: true 
        }) 
    }); 
</script>