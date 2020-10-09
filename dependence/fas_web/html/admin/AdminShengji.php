<?php
 	include('head.php');
	include('nav.php'); 
	$require = true;
	$m = new Map();
	
 	if($_GET['act'] == 'update'){
 		
 		
 		$m->type("cfg_sj")->update("versionCode",$_POST["versionCode"]);
 		$m->type("cfg_sj")->update("url",$_POST["url"]);
 		$m->type("cfg_sj")->update("content",$_POST["content"]);
 		$m->type("cfg_sj")->update("opens",$_POST["opens"]);
 		$m->type("cfg_sj")->update("spic",$_POST["spic"]);
 		
		tip_success("修改成功",'AdminShengji.php?act=mod&id='.$_GET['id']);
		
	}else{
	$data = $m->type("cfg_sj")->getAll();
	$action = '?act=update';
	
		
 ?>
<div class="main">
<div class="box">
<span class="label label-default">升级推送设置</span>
<div style="clear:both;height:10px;"></div>
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">版本号(大于APP时才能检测到更新)</label>
        <div class="col-sm-10">
            <div class="col-sm-10"><input class="form-control" rows="10" name="versionCode" value="<?php echo $data["versionCode"] ?>"></div>
        </div>
    </div>
    
    
    
    <div class="form-group" >
        <label for="firstname" class="col-sm-2 control-label">更新说明</label>
        <div class="col-sm-10">
            <div class="col-sm-10"><textarea class="form-control" rows="10" name="content"><?php echo $data["content"] ?></textarea></div>
        </div>
    </div> 
    <div class="form-group" >
        <label for="firstname" class="col-sm-2 control-label">APP下载连接</label>
        <div class="col-sm-10">
            <div class="col-sm-10"><input class="form-control" rows="10" name="url" value="<?php echo $data["url"] ?>"></div>
        </div>
    </div>
    
        <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">功能开关</label>
        <div class="col-sm-10">
            <div class="col-sm-10">
			<select name="opens">
				<option value="error">关闭</option>
				<option value="success" <?php echo $data["opens"]=="success" ? " selected " :"";?>>开启</option>
			</select>
		
        </div>
        </div>
    </div>
    
       <div class="form-group" >
        <label for="firstname" class="col-sm-2 control-label">启动图地址</label>
        <div class="col-sm-10">
            <div class="col-sm-10"><input class="form-control" rows="10" name="spic" value="<?php echo $data["spic"] ?>"></div>
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
