<?php
	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'update'){
		$db = db('line');
		
		if($db->where(array('id'=>$_GET['id']))->update(array(
			'name'=>$_POST['name'],
			'type'=>$_POST['type'],
			'label'=>$_POST['label'],
			'content'=>$_POST['content'],
			'group'=>$_POST['group'],
			'show'=>$_POST['show'] == '1' ? '1':'0'
		))){
			tip_success("修改线路【".$_POST['name']."】成功！",'line_add.php?act=mod&id='.$_GET['id']);
		}else{
			tip_failed("十分抱歉修改失败",'line_add.php?act=mod&id='.$_GET['id']);
		}
		
	}elseif($_GET['act'] == 'add'){
		$db = db('line');
		if($_POST["kuai"] == 1){
			$line[] = '# Enables connection to GUI';
			$line[] = '# 开源OpenVpnControl流控，项目仓库：https://github.com/imldy/OpenVpnControl';
			$line[] = '# quote-configuration';
			$line[] = 'setenv IV_GUI_VER "de.blinkt.openvpn 0.6.17"';
			$line[] = 'machine-readable-output';
			$line[] = 'resolv-retry infinite';
			$line[] = 'client';
			$line[] = 'verb 3';
			$line[] = 'connect-retry-max 5';
			$line[] = 'connect-retry 5';
			$line[] = 'resolv-retry 60';
			$line[] = 'persist-key';
			$line[] = 'persist-tun';
			$line[] = 'nobind';
			$line[] = 'proto '.$_POST['k_xieyi'];
			$line[] = 'dev tun';
			$line[] = '';
			$line[] = $_POST['k_content'];
			$line[] = '';
			$line[] = '# Setting Upinstall "Domain Name System"';
			$line[] = '';
			$line[] = '# 请设置下方DNS服务器地址为您的地区DNS可为线路加速。';
			$line[] = '';
			$line[] = '# 默认全国通用 180.76.76.76 / 119.29.29.29,如效果不佳请删除。';
			$line[] = '';
			$line[] = 'push route '.$_POST['k_dns'];
			$line[] = '';
			$line[] = 'auth-user-pass';
			$line[] = '';
			$line[] = 'ns-cert-type server';
			$line[] = '';
			$line[] = 'comp-lzo';
			$line[] = '## 证书';
			$line[] = '<ca>';
			$line[] = '[证书]';
			$line[] = '</ca>';
			$line[] = 'key-direction 1';
			$line[] = '<tls-auth>';
			$line[] = '[证书]';
			$line[] = '</tls-auth>';
			$_POST['content'] = implode("\n",$line);
			
		}
		if($db->insert(array(
			'name'=>$_POST['name'],
			'type'=>$_POST['type'],
			'label'=>$_POST['label'],
			'content'=>$_POST['content'],
			'group'=>$_POST['group'],
			'time'=>time(),
			'show'=>$_POST['show'] == '1' ? '1':'0'
		))){
			tip_success("新增线路【".$_POST['name']."】成功！",'line_add.php');
		}else{
			tip_failed("十分抱歉修改失败",'line_add.php');
		}
		
	}else{
	
	$action = '?act=add';
	if($_GET['act'] == 'mod'){
		$info = db('line')->where(array('id'=>$_GET['id']))->find();
		$action = "?act=update&id=".$_GET['id'];
	}
		
 ?>
<div class="main">
	
	<div class="box">
		<span class="label label-default">线路管理</span>
		<div style="clear:both;height:10px;"></div>
		<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>">
		<div class="form-group">
			<label for="firstname" class="col-xs-12 col-sm-2 control-label">线路名称</label>
			<div class="col-xs-12 col-sm-10">
				<input type="text" class="form-control" name="name" placeholder="线路名称" value="<?php echo $info['name'] ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="lastname" class="col-xs-12 col-sm-2 control-label">线路类型</label>
			<div class="col-xs-12 col-sm-10">
				<input type="text" class="form-control" name="type" placeholder="线路类型" value="<?php echo $info['type'] ?>">
			</div>
		</div>
		  <div class="form-group">
			<label for="lastname" class="col-xs-12 col-sm-2 control-label">线路描述</label>
			<div class="col-xs-12 col-sm-10">
				<input type="text" class="form-control" name="label" placeholder="显示标签" value="<?php echo $info['label'] ?>">
			</div>
		</div>
		  <div class="form-group" >
			<label for="name" class="col-sm-2 control-label">分组选择</label>
			 <div class="col-sm-10"><select class="form-control" name="group">
				<?php
					$list = db('line_grop')->order('id ASC')->select();
					foreach($list as $vo){
						$selected = "";
						if((int)$info['group'] == (int)$vo['id']){
							$selected = 'selected';
						}
						
						echo '<option value="'.$vo['id'].'" '.$selected.'>'.$vo['name'].'</option>';
					}
				
				?>
			</select></div>
		</div><div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<div class="checkbox">	
			<?php 
			if($_GET['act'] != 'mod'){
				?><label><input type="checkbox" name="kuai" value="1" onclick="kuaijie()" >快捷添加（勾选后只需要写伪装与指向代码即可）	</label><?php } ?>
					<label>
					<input type="checkbox" name="show" value="1" <?php if($info["show"]!==0){ ?> checked <?php } ?>>是否启用
					</label>
					</div>
					</div>
				</div>
		<div class="form-group" >
			<label for="name" class="col-xs-12 col-sm-2 control-label">线路内容(<span style="color:red">请直接添加线路的全部内容 证书会自动替换</span>)</label>
			 <div class="col-xs-12 col-sm-10 box1">
			  <a type="submit" class="btn btn-default" onclick="autoGs()" href="javascript:void(0);">自动换行</a>&nbsp;
			  标签：[domain] 会替换成您的IP或者域名  [time] 当前的UNIX时间戳(秒) <br>
			  	
			 <textarea class="form-control" rows="10" name="content" placeholder="如果证书管理开启，那么线路的证书会被自动替换。"><?php echo $info['content'] ?></textarea>
			 </div>
			 <div class="col-xs-12 col-sm-10 box2" style="display:none;background:#f8f8f8;padding:20px 10px;">
				<div class="form-group">
					<label for="lastname" class="col-sm-1 control-label">协议</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" name="k_xieyi" placeholder="TCP" value="tcp">
					</div>
				</div>
				<div class="form-group">
					<label for="lastname" class="col-sm-1 control-label">DNS</label>
					<div class="col-sm-11">
						<input type="text" class="form-control" name="k_dns" placeholder="180.76.76.76 119.29.29.29" value="180.76.76.76 119.29.29.29">
					</div>
				</div>
				 <textarea class="form-control" rows="10" name="k_content" placeholder="代码"><?php echo $info['content'] ?></textarea>
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
	var k = 0;
	function kuaijie(){
		$(".box1").toggle();
		$(".box2").toggle();
		
		if(k == 0){k=1}else{k=0}
	}
	function autoGs(){
		var content = $("[name=content]").val();
		content = content.replace("\n\r","\n");  
		content = content.replace("\n","\n\r");
		$("[name=content]").val(content);
	}
	</script>
<?php
	}
	include('footer.php');
?>
