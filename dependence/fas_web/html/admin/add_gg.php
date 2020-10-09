<?php
 	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('app_gg');
		if($db->where(array('id'=>$_GET['id']))->update(array(
			'name'=>$_POST['name'],
			'content'=>$_POST['content'],
		))){
			tip_success("公告修改成功",'add_gg.php?act=mod&id='.$_GET['id']);
		}else{
			tip_failed("十分抱歉修改失败",'add_gg.php?act=mod&id='.$_GET['id']);
		}
		
	}elseif($_GET['act'] == 'add'){
		$db = db('app_gg');
		if($db->insert(array(
			'name'=>$_POST['name'],
			'content'=>$_POST['content'],
			'time'=>time()
		))){
			tip_success("新增消息【".$_POST['name']."】成功！",'add_gg.php');
		}else{
			tip_failed("十分抱歉修改失败",'add_gg.php');
		}
		
	}else{
	
	$action = '?act=add';
	if($_GET['act'] == 'mod'){
		$info = db('app_gg')->where(array('id'=>$_GET['id']))->find();
		$action = "?act=update&id=".$_GET['id'];
	}
		
 ?>
<div class="box">
<div class="main">
<span class="label label-default">公告/消息推送</span>
<div style="clear:both;height:10px;"></div>
<div class="alert alert-danger">公告只会在用户登录时、连接时和切换账号时才会更新。</div>
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">标题</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="标题" value="<?php echo $info['name'] ?>">
        </div>
    </div> 
    <div class="form-group" >
        <label for="name" class="col-sm-2 control-label">主要内容</label>
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
