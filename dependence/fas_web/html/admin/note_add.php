<?php
 	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('app_note');
		if($db->where(array('id'=>$_GET['id']))->update([
			'name'=>$_POST['name'],
			'ipport'=>$_POST['ipport'],
			'description'=>$_POST['description'],
			'count'=>$_POST['count'],
			'order'=>$_POST['order']
		])){
			tip_success("公告修改成功",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
		
	}elseif($_GET['act'] == 'add'){
		
		$db = db("app_note");
		if($db->insert(array(
			'name'=>$_POST['name'],
			'ipport'=>$_POST['ipport'],
			'description'=>$_POST['description'],
			'count'=>$_POST['count'],
			'order'=>$_POST['order']
		))){
			tip_success("新增节点【".$_POST['name']."】成功！",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
		
	}else{
		if($_GET["act"] == "mod"){
			$action = "?act=update&id=".$_GET["id"];
			$info=db("app_note")->where(["id"=>$_GET["id"]])->find();
		}else{
			$action = "?act=add";
			$nums = (db("app_note")->getnums())+1;
		}
		
 ?>
 <div class="row">
 <div class="col-xs-12 col-sm-7">
<div class="box">
<div class="main">
	<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
    <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">节点名称<font style="color:red">*</font></label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="name" placeholder="节点1" value="<?php echo $info['name']?:"极速节点".$nums ?>">
        </div>
    </div>
     <div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">节点域名或者IP<font style="color:red">*</font></label>
        <div class="col-sm-10">
			<input type="text" class="form-control" name="ipport" placeholder="10.8.0.1" value="<?php echo $info['ipport'] ?>">
			
        </div>
    </div>  
	<div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">节点描述<font style="color:red">*</font></label>
        <div class="col-sm-10">
			<input type="text" class="form-control" name="description" placeholder="不限速/看视频/聊天/刷网页" value="<?php echo $info['description'] ?: "不限速/看视频/聊天/刷网页" ?>">
        </div>
    </div>
	
	<div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">满载人数<font style="color:red">*</font></label>
        <div class="col-sm-10">
			<input type="text" class="form-control" name="count" placeholder="140" value="<?php echo $info['count'] ?: "140"; ?>">
        </div>
    </div>
	<div class="form-group">
        <label for="firstname" class="col-sm-2 control-label">序号（越大越靠前）<font style="color:red">*</font></label>
        <div class="col-sm-10">
			<input type="text" class="form-control" name="order" placeholder="0" value="<?php echo $info['order'] ?: "0"; ?>">
        </div>
    </div>
    <div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-info btn-block">添加节点</button>
		</div>
	</div>
	</form> 
</div>
</div>
</div>
<div class="col-xs-12 col-sm-5">
	<div class="box">
	<p class="text-warning">
	<h3><b>节点填写域名和IP的区别</b></h3>
	因为用户的登录信息是以IP为标记，所以如果填写域名（无论域名你是否负载）都将无法统计单个节点的负载信息（也就是系统无法判断一个节点在线多少人）。
	<b>但是其他功能一切正常！</b>
	<h3><b>满载人数什么意思？</b></h3>
	满载人数是为了计算节点负荷显示给用户使用的。默认140。此数值只是为了线路页面统计使用，计算规则如下:<br>
	<b>负荷百分比=在线人数/满载人数*100</b>最大为100%，最低为1%（即便是一个人在线也是1%）。例如当140或者更多人在线时，140/140*100  = 100。即为100%负荷。再如70人在线，即为70/140*100=50，即为负荷程序为50%。0人在线或者没有数据即为[空闲]。
	<br>
	<b>人数设置为0则关闭负载计算。推荐节点填写域名时关闭负载计算。不影响正常使用！</b>
	</p>
	</div>

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
