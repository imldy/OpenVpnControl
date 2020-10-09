<?php
	include('head.php');
	include('nav.php');
	$m = new Map();
 	if($_GET['act'] == 'update'){
		
 		
 		$m->type("cfg_zs")->update("ca",$_POST["ca"]);
 		$m->type("cfg_zs")->update("tls",$_POST["tls"]);
 		$m->type("cfg_zs")->update("domain",$_POST["domain"]);
 		$m->type("cfg_zs")->update("onoff",$_POST["onoff"]);
 		
		tip_success("修改成功",$_SERVER['HTTP_REFERER']);
		
	}else{
		$action = "?act=update";
		$info = $m->type("cfg_zs")->getAll();
		
 ?>
<div class="main">
	<div class="box">
		<div style="clear:both;height:10px;"></div>	如果开启此功能，用户安装线路时，会强制修正线路证书为如下内容。如果关闭，则按线路中的证书安装。此功能仅仅影响线路，不会修改openvpn本身的证书。如果你需要替换证书，请替换/etc/openvpn/easy-rsa/
		<div style="clear:both;height:10px;"></div>
		<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>">
		
		<div class="form-group" >
			<label for="name" class="col-sm-2 control-label">域名/IP(线路中 [domain] 会被替换成域名)</label>
			 <div class="col-sm-10">
			 
			 <input class="form-control" rows="10" name="domain" value="<?php echo $info['domain'] ?>"></div>
		</div>
		
		<div class="form-group" >
			<label for="name" class="col-sm-2 control-label">CA证书</label>
			 <div class="col-sm-10">
			 
			 <textarea class="form-control" rows="10" name="ca"><?php echo $info['ca'] ?></textarea></div>
		</div>
		
		<div class="form-group" >
			<label for="name" class="col-sm-2 control-label">tls-auth</label>
			 <div class="col-sm-10">
			 
			 <textarea class="form-control" rows="10" name="tls"><?php echo $info['tls'] ?></textarea></div>
		</div>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">
					<label>
						<input type="checkbox" name="onoff" value="1" <?php echo $info["onoff"]==1?" checked " : "";?>>是否启用
					</label>
				</div>
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
