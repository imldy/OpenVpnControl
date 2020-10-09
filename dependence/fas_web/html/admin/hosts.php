<?php
	include('head.php');
	include('nav.php');
	$m = new Map();
 	if($_GET['act'] == 'update'){
		

		$info = file_put_contents("/etc/fas_host",$_POST["content"]);
 		
		tip_success("修改成功",$_SERVER['HTTP_REFERER']);
		
	}else{
		$action = "?act=update";
		
		$info = file_get_contents("/etc/fas_host");
		//$p = '/default\s([0-9]*)/';
	//preg_match($p,$info,$m);
		
 ?>
<div class="main">
	<div class="box">
		<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>">
			<div class="form-group">
				<p>
					示例:127.0.0.1 www.baidu.com 则用户访问百度会被屏蔽<br>
					10.8.0.1（或者你的IP） a.com 则访问a.com会进入你的流控
				</p>
				
			
			</div>
			<textarea class="form-control" rows="20" name="content"><?php echo $info ?></textarea>
			<br>
			<button type="submit" class="btn btn-info btn-block">保存</button>
			<input type="button" class="btn btn-success btn-block" onclick="cmds('service dnsmasq restart')" value="立即生效（保存后再执行）">
	
	</form> 
	</div>
</div>
<script>
function cmds(line){
	if(confirm("立即使HOST表生效？")){
		$.post('fas_service.php',{
			  "cmd":line  
		},function(data){
			if(data.status == "success"){
				alert("执行完毕");
				 location.reload();
			}else{
				alert(data.msg);
					}
		},"JSON");
	}
	
}
</script>
<?php
	}
	include('footer.php');
?>
