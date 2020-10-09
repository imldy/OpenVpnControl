<?php
 	include('head.php');
	include('nav.php');
	if($_GET['act'] == 'add'){
		$pass = trim($_POST["password"]);
		if($pass == ""){
			tip_failed("密码长度不能为空",'?');
		}else{
			$db = db(_openvpn_);
			$n = 0;
			for($i=0;$i<$_POST["nums"];$i++){
				$passstr = null;
				for($i2=0;$i2<$pass;$i2++){
					$passstr .= rand(0,9);
				}
				$username = $_POST['username'].rand(10000,99999).$i;
				if(!$db->where(array("iuser"=>$username))->find()){ //禁止重复添加 
					if($db->insert(array(
						'iuser'=>$username,
						'pass'=>$passstr,
						'i'=>$_POST['i'],
						'isent'=>0,
						'irecv'=>0,
						'maxll'=>$_POST['rate']*1024*1024,
						'starttime'=>time(),
						'endtime'=>time()+$_POST['days']*24*60*60
					))){
						$kms[] = '$data['.$n.']["user"]="'.$username.'";';
						$kms[] = '$data['.$n.']["pass"]="'.$passstr.'";';
						$n++;
					}
				}
			}
		}
			
			file_put_contents("lastkm/userdata.php",'<?php'."\n".implode("\n",$kms));
			tip_success("成功！",'lastkm/user.php');

	}else{
	$action = "?act=add";
		
 ?>
<div class="box">
<div class="main">
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">数量(数字)<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="nums" placeholder="10" value="10">
        </div>
    </div><div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名开头(英文和数字)<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="username" placeholder="用户名" value="user">
        </div>
    </div>
  
	<div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">密码长度<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="password" placeholder="10" value="6">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">流量（0-999999/M）<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="rate" placeholder="1024" value="1024">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">有效期（0-999999/天） <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="days" placeholder="30" value="30">
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
		<button type="submit" class="btn btn-info btn-block">批量生成用户</button>
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
