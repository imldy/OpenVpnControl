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
			tip_success("公告修改成功",'?act=mod&id='.$_GET['id']);
		}else{
			tip_failed("十分抱歉修改失败",'?act=mod&id='.$_GET['id']);
		}
		
	}elseif($_GET['act'] == 'add'){
		
		$db = db("auth_fwq");
		if($db->insert(array(
			'name'=>$_POST['name'],
			'ipport'=>$_POST['ipport']
		))){
			tip_success("新增服务器【".$_POST['name']."】成功！",'?');
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
        <label for="firstname" class="col-sm-2 control-label">服务器名字<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="节点1" value="<?php echo $info['name'] ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">IP与端口<font style="color:red">*</font></label>
        <div class="col-sm-10">
           <div class="input-group">
			<span class="input-group-addon">http://</span><input type="text" class="form-control" name="ipport" placeholder="10.8.0.1:4190" value="<?php echo $info['ipport'] ?>">
			</div>
        </div>
    </div>
    
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info btn-block">添加服务器</button>
        </div>
    </div>
	</form> 
</div>
</div>
	<script>
	function checkStr(){
		var name = $('[name="name"]').val();
		var ip = $('[name="ipport"]').val();

		if(name == "" || ip ==　""){
			alert("参数填写不完整");
			return false;
		}
		return true;
	}
	</script>
<?php
	}
	include('footer.php');
	
?>
