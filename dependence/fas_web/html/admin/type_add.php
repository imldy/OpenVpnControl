<?php
 	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('app_daili_type');
		if($db->where(array('id'=>$_GET['id']))->update(array(
			'name'=>$_POST['name'],
			'per'=>$_POST['per']
		))){
			tip_success("修改成功",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
		
	}elseif($_GET['act'] == 'add'){
		$db = db('app_daili_type');
		if($db->insert(array(
			'name'=>$_POST['name'],
			'per'=>$_POST['per']
		))){
			tip_success("操作成功！",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
		
	}else{
	
	$action = '?act=add';
	if($_GET['act'] == 'mod'){
		$info = db('app_daili_type')->where(array('id'=>$_GET['id']))->find();
		$action = "?act=update&id=".$_GET['id'];
	}
		
 ?>
<div class="box">
<div class="main">
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">等级名称 <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="如：VIP1" value="<?php echo $info['name'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">折扣比(0-100 80就代表原件的80%拿货) <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="per" placeholder="如：80" value="<?php echo $info['per'] ?>">
        </div>
    </div>
    
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-default">提交数据</button>
        </div>
    </div>
	</form> 
</div>
</div>
	<script>
	function checkStr(){
		var title = $('[name="title"]').val();
		var content = $('[name="per"]').val();
		if(title == "" || content ==　""){
			alert("参数不完整");
			return false;
		}
		return true;
	}
	</script>
<?php
	}
	include('footer.php');
	
?>
