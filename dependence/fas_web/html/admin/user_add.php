<?php
 	include('head.php');
	include('nav.php');
	if($_GET['act'] == 'add'){
		$db = db(_openvpn_);
		if($db->where(array("iuser"=>$_POST['username']))->find()){ 
			tip_failed("用户名重复了,请换一个试一试",'?');
			exit;
		}
		if($db->insert(array(
			'iuser'=>$_POST['username'],
			'pass'=>$_POST['password'],
			'isent'=>0,
			'irecv'=>0,
			'maxll'=>$_POST['rate']*1024*1024,
			'starttime'=>time(),
			'i'=>$_POST['i'],
			'endtime'=>time()+$_POST['days']*24*60*60
		))){
			tip_success("新增消息【".$_POST['username']."】成功！",'?');
		}else{
			tip_failed("十分抱歉修改失败",'?');
		}
		
	}else{
		$action = "?act=add";
		
 ?>
<div class="box">
<div class="main">
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名 (英文和数字)<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="username" placeholder="用户名" value="<?php echo $info['name'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">密码(英文和数字)<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="password" placeholder="10" value="<?php echo $info['jg'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">流量（0-999999/M）<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="rate" placeholder="1024" value="<?php echo $info['limit'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">有效期（0-999999/天） <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="days" placeholder="30" value="<?php echo $info['rate'] ?>">
        </div>
    </div>
	<div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">状态 <font style="color:red">*</font></label>
        <div class="col-sm-10">
           <select name="i">
				<option value="0">禁用</option>
				<option value="1">启用</option>
		   </select>
        </div>
    </div>
	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
		<button type="submit" class="btn btn-info btn-block">添加用户</button>  
		</div>
		</div>
	</form> 
</div>
</div>
	<script>
	function checkStr(){
		var username = $('[name="username"]').val();
		var password = $('[name="password"]').val();
		var rate = $('[name="rate"]').val();
		var days = $('[name="days"]').val();
		var bz = $('[name="bz"]').val();
		
		if(username == "" || password ==　""|| rate ==　""|| days ==　""){
			alert("用户名 密码 流量 与 期限 均不能为空");
			return false;
		}
		return true;
	}
	</script>
<?php
	}
	include('footer.php');
	
?>
