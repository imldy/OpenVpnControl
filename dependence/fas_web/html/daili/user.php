<?php
	if($_GET["act"] == "mod"){
		include("system.php");
		if($_POST["p2"] == $_POST["p3"]){
			die(json_encode(array("status"=>"error","msg"=>"不能修改为重复的密码")));
		}else{
			if($_POST["p2"] == $admin["pass"]){
				if(trim($_POST["p3"]) == ""){
					die(json_encode(array("status"=>"error","msg"=>"密码不得为空")));
				}else{
					if(db("app_daili")->where(["id"=>$admin["id"]])->update(["pass"=>$_POST["p3"]])){
						die(json_encode(["status"=>"success","msg"=>"密码修改成功"]));
					}
					die(json_encode(["status"=>"error","msg"=>"无法更新数据到数据库"]));
				}
			}
			die(json_encode(["status"=>"error","msg"=>"当前密码错误"]));
		}
	}else{
		include('head.php');
	include('nav.php');
 ?>
   
<div class="panel panel-success">
   <div class="panel-heading">
      <h3 class="panel-title">修改信息</h3>
   </div>
	<div class="panel-body">
	<!--表单内容-->

  <div class="form-group">
    <label for="inputPassword" >当前密码</label>
   
      <input type="password" class="form-control" id="password" 
         placeholder="请输入密码">

  </div> 
  <hr>
  <div class="form-group">
    <label for="inputPassword" >新密码</label>
    
      <input type="password" class="form-control" id="password_new" 
         placeholder="请输入密码">
  
  </div>
  <button type="button" class="btn btn-danger mod">确认修改</button>
	</div>
</div>
<script>
$(function(){
	$(".mod").click(function(){
		$.post(
			"?act=mod",{
				"p2":$("#password").val(),
				"p3":$("#password_new").val()
			},function(data){
				if(data.status == "success"){
					alert("密码修改成功");
				}else{
					alert(data.msg);
				}
			},"JSON"
		);
	});
});
</script>


	<?php include('footer.php'); };?>