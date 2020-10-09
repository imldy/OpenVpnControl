<?php
	include('head.php');
	include('nav.php');
	$m = new Map();
 	if($_GET['act'] == 'del'){
		$port = file_get_contents("/root/res/portlist.conf");
		$p = '/port\s*([0-9]*)\s*tcp/';
		preg_match_all($p,$port,$m);
		echo '<span class="label label-default">代理端口</span>';
		foreach($m[1] as $vo){
			if($vo!=$_GET["port"]){
				$line[] = "port $vo tcp";
			}
		}
		$content = implode("\n",$line);
		file_put_contents("/root/res/portlist.conf",$content);
		tip_success("修改成功",$_SERVER['HTTP_REFERER']);
	}elseif($_GET['act'] == 'update'){
		
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
		<span class="label label-default">高级管理</span>
		<div style="clear:both;height:10px;"></div>
		<hr>
		<h3>代理端口管理</h3>
		<?php
			$port = file_get_contents("/root/res/portlist.conf");
			$p = '/port\s*([0-9]*)\s*tcp/';
			preg_match_all($p,$port,$m);
			echo '<span class="label label-default">代理端口</span>';
			foreach($m[1] as $vo){
				echo $vo.'[<a href="?act=del&port='.$vo.'" onclick="if(confirm(\'删除后重启VPN生效\')){return true;}else{return false;}">删除</a>]&nbsp;';
			}
		?>
		<div style="clear:both;height:10px;"></div>
		<a class="btn ui-button-primary" data-toggle="modal" data-target="#myModal" id="setting">
		添加端口
		</a>
		<hr>
		<div style="clear:both;height:10px;"></div>
		<a class="btn ui-button-primary" data-toggle="modal" data-target="#myModal2" id="setting">
		修改WEB端口
		</a>
	
		<hr>
		<h3>更多操作</h3>
		<button type="submit" class="btn btn-primary" onclick="cmds('vpn restartvpn')">重启VPN（重启全部）</button>
		<button type="submit" class="btn btn-primary" onclick="cmds('service mariadb restart')">重启数据库</button>
		<button type="submit" class="btn btn-primary" onclick="cmds('service httpd restart')">重启Apache</button>
		<button type="submit" class="btn btn-primary" onclick="cmds('service iptables restart')">重启防火墙</button>	
		<button type="submit" class="btn btn-primary" onclick="cmds('service dnsmasq restart')">重启dnsmasq</button>
	</div>
</div>
	<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
				</button>
				<h4 class="modal-title" id="myModalLabel">
					添加代理端口
				</h4>
			</div>
			<div class="modal-body">
				
				 <div class="form-group">
					<label for="name">请您注意</label>
					本功能正处于试验阶段，添加端口前 请在后台首页查看端口是否已经监听或者占用！本功能暂时只能添加TCP端口</div>
				  <div class="form-group">
					<label for="name">请输入端口</label>
				<input type="text" class="form-control" id="port" placeholder=""  value="7788">
					
				  </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					关闭
				</button>
				<button type="button" class="btn ui-button-primary save">
					提交更改
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->	

<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
				</button>
				<h4 class="modal-title" id="myModalLabel">
					修改WEB端口
					</h4>
			</div>
			<div class="modal-body">
				
				 <div class="form-group">
					<label for="name">请您注意</label>
					请保证端口没有被占用，否则，流控可能无法启动</div>
				  <div class="form-group">
					<label for="name">请输入端口</label>
						<input type="text" class="form-control" id="webport" placeholder=""  value="80">
					
				  </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					关闭
				</button>
				<button type="button" class="btn ui-button-primary save2" data-dismiss="modal">
					提交更改
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
$(function(){   
	   $(".save").click(function(){
		   var nums = $("#port").val();
		   if(nums == ""){
			   alert("请输入端口号");
		   } 
		   $.post('fas_service.php',{
			   "cmd":'/var/www/html/admin/lib/addport.sh tcp '+nums
			  
			},function(data){
				if(data.status == "success"){
					alert("执行完毕。请在后台首页查看是否已经添加成功");
					location.reload();
				}else{
					alert(data.msg);
				}
			},"JSON");
	   });
	   
	   $(".save2").click(function(){
		   var nums = $("#webport").val();
		   if(nums == ""){
			   alert("请输入端口号");
		   } 
		   $.post('fas_service.php',{
			   "cmd":'/var/www/html/admin/lib/modWebPort.sh '+nums
			  
			},function(data){
				if(data.status == "success"){
					alert("执行完毕。请尝试以新端口访问流控。");
					<?php
						$HOST = explode(":",$_SERVER["HTTP_HOST"]);
						$domain = $HOST[0];
						$port = $HOST[1];
					?>
					location.href="http://<?= $domain?>:"+nums+"/admin/";
				}else{
					alert(data.msg);
				}
			},"JSON");
	   });
	});
function cmds(line){
	if(confirm("确认执行此命令？部分命令执行后可能没有结果反馈")){
		$.post('fas_service.php',{
			  "cmd":line  
		},function(data){
			if(data.status == "success"){
				alert("执行完毕");
				//location.reload();
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
