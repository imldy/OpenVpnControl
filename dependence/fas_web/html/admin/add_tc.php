<?php
 	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('app_tc');
		if($db->where(array('id'=>$_GET['id']))->update(array(
			'name'=>$_POST['name'],
			'content'=>$_POST['content'],
			'jg'=>$_POST['jg'],
			'limit'=>$_POST['limit'],
			'rate'=>$_POST['rate'],
			'url'=>$_POST['url']
		))){
			tip_success("公告修改成功",'add_tc.php?act=mod&id='.$_GET['id']);
		}else{
			tip_failed("十分抱歉修改失败",'add_tc.php?act=mod&id='.$_GET['id']);
		}
		
	}elseif($_GET['act'] == 'add'){
		$db = db('app_tc');
		if($db->insert(array(
			'name'=>$_POST['name'],
			'content'=>$_POST['content'],
			'jg'=>$_POST['jg'],
			'limit'=>$_POST['limit'],
			'rate'=>$_POST['rate'],
			'url'=>$_POST['url'],
		
			'time'=>time()
		))){
			tip_success("新增消息【".$_POST['name']."】成功！",'add_tc.php');
		}else{
			tip_failed("十分抱歉修改失败",'add_tc.php');
		}
		
	}else{
	
	$action = '?act=add';
	if($_GET['act'] == 'mod'){
		$info = db('app_tc')->where(array('id'=>$_GET['id']))->find();
		$action = "?act=update&id=".$_GET['id'];
	}
		
 ?>
<div class="box">
<div class="main">
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">套餐名称 <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="标题" value="<?php echo $info['name'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">套餐价格(元) <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="jg" placeholder="10" value="<?php echo $info['jg'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">有效期(天) <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="limit" placeholder="30" value="<?php echo $info['limit'] ?>">
        </div>
    </div>
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">流量限额(M) <font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="rate" placeholder="1024" value="<?php echo $info['rate'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">购买连接</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="url" placeholder="http://abc.cn/buy/122" value="<?php echo $info['url'] ?>">
        </div>
    </div>
	
    <div class="form-group" >
        <label for="name" class="col-sm-2 control-label">套餐描述</label>
         <div class="col-sm-10"><textarea class="form-control" rows="10" name="content"><?php echo $info['content'] ?></textarea></div>
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
		var title = $('[name="title"]').val();
		var content = $('[name="content"]').val();
		if(title == "" || content ==　""){
			alert("标题与内容不得为空");
			return false;
		}
		return true;
	}
	</script>
<?php
	}
	include('footer.php');
	
?>
