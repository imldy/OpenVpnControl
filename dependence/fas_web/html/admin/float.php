<?php
	include('head.php');
	include('nav.php');
	$m = new Map();
 	if($_GET['act'] == 'update'){
		
 		$limit = $_POST["limit"];
 		$content = "default {$limit}
		total 1000";
		$info = file_put_contents("/etc/openvpn/bwlimitplugin.cnf",$content);
 		
		tip_success("修改成功",$_SERVER['HTTP_REFERER']);
		
	}else{
		$action = "?act=update";
		
		$info = file_get_contents("/etc/openvpn/bwlimitplugin.cnf");
		$p = '/default\s([0-9]*)/';
		preg_match($p,$info,$m);
		
 ?>
<div class="main">
	<div class="box">
		<span class="label label-default">速度管理</span>
		<div style="clear:both;height:10px;"></div>
		<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>">
		
		<div class="form-group" >
			<label for="name" class="col-sm-2 control-label">速度限制（Kbps 1000Kps = 1Mbps宽带 即0.128m/s ）</label>
			 <div class="col-sm-10">
			 
			 <input class="form-control" rows="10" name="limit" value="<?php echo $m[1] ?>">
			 <br>
				<p>
				此功能可以限制每个用户的下行速度，设置完成后请重启VPN。限速只是限制下载速度，而且只是大概数值，会与手机统计有所偏差。
				</p>
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
<?php
	}
	include('footer.php');
?>
