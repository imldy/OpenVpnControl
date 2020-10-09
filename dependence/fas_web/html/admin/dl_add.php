<?php
 	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('app_daili');
		$endtime = strtotime($_POST['days']);
		if($db->where(array('id'=>$_GET['id']))->update(array(
			'name'=>$_POST['name'],
			'pass'=>$_POST['pass'],
			'type'=>$_POST["type"],
			'balance'=>$_POST['balance'],
			'qq'=>$_POST['qq'],
			'lock'=>$_POST['lock'],
			'endtime'=>$endtime
		))){
			tip_success("修改成功",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
		
	}elseif($_GET['act'] == 'add'){
		$db = db("app_daili");
		$endtime = strtotime($_POST['days']);
		if($db->insert(array(
			'name'=>$_POST['name'],
			'pass'=>$_POST['pass'],
			'type'=>$_POST["type"],
			'balance'=>$_POST['balance'],
			'qq'=>$_POST['qq'],
			'lock'=>$_POST['lock'],
			'endtime'=>$endtime,
			'time'=>time()
		))){
			tip_success("操作成功！",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
		
	}else{
		$action = '?act=add';
		if($_GET['act'] == 'mod'){
			$info = db('app_daili')->where(array('id'=>$_GET['id']))->find();
			$action = "?act=update&id=".$_GET['id'];
		}
		
 ?>
<div class="box">
<div class="main">
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
	
	 <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">代理等级 <font style="color:red">*</font></label>
        <div class="col-sm-10">
           <select name="type">
				<?php $res = db("app_daili_type")->select();if($res){
					foreach($res as $vo){?>
						<option value="<?php echo $vo["id"]?>" <?php if($vo["id"] == $info["type"]){ echo " selected ";}?>><?php echo $vo["name"]?> 折扣<?php echo $vo["per"]?>%</option>
					<?php }
				}else{
					die("请先增加等级");
				}
				?>
		   </select>
        </div>
    </div>
	
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">用户名 (英文和数字)<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="用户名" value="<?php echo $info['name'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">密码(英文和数字)<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="pass" placeholder="10" value="<?php echo $info['pass'] ?>">
        </div>
    </div>
   
	<div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">可用金额（元）<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="balance" placeholder="1024" value="<?php echo $info['balance'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">有效期（0-999999/天） <font style="color:red">*</font></label>
        <div class="col-sm-10">
	<input type="text" class="form-control Wdate" name="days" placeholder="30" value="<?php if($_GET['act'] == 'mod'){echo date("Y-m-d",$info['endtime']);}else{echo date("Y-m-d",time());} ?>">
        </div>
    </div>
	
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">联系方式 <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="qq" placeholder="QQ" value="<?php echo $info['qq'] ?>">
        </div>
    </div>
    
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">状态 <font style="color:red">*</font></label>
        <div class="col-sm-10">
           <select name="lock">
				<option value="0">禁用</option>
				<option value="1" <?php if($info["lock"] == 1){ echo " selected ";}?>>启用</option>
		   </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info btn-block">提交数据</button>
        </div>
    </div>
	</form> 
</div>
</div>
	<script>
	function checkStr(){
		var username = $('[name="name"]').val();
		var password = $('[name="pass"]').val();
		var balance = $('[name="balance"]').val();
		var days = $('[name="days"]').val();
		var qq = $('[name="qq"]').val();
		
		if(username == "" || password ==　""|| balance ==　""|| days ==　""){
			alert("资料不完整");
			return false;
		}
		return true;
	}
	</script>
<?php
	}
	include('footer.php');
	
?>
