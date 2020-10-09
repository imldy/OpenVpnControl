<?php	
 	include('head.php');
	include('nav.php');
	$m = new Map();
 	if($_GET['act'] == 'update'){
		$m->type("cfg_app")->update("reg_type",$_POST["reg_type"]);
		$m->type("cfg_app")->update("connect_unlock",$_POST["connect_unlock"]);
		$m->type("cfg_app")->update("content",$_POST["content"]);
		$m->type("cfg_app")->update("max_limit",$_POST["max_limit"]);
		
		$m->type("cfg_app")->update("SMS_T",$_POST["SMS_T"]);
		$m->type("cfg_app")->update("SMS_L",$_POST["SMS_L"]);
		$m->type("cfg_app")->update("SMS_I",$_POST["SMS_I"]);
		$m->type("cfg_app")->update("Auth_Token",$_POST["Auth_Token"]);
		$m->type("cfg_app")->update("Account_Sid",$_POST["Account_Sid"]);
		$m->type("cfg_app")->update("APP_ID",$_POST["APP_ID"]);
		$m->type("cfg_app")->update("Template_ID",$_POST["Template_ID"]);
		$m->type("cfg_app")->update("APP_NAME",$_POST["APP_NAME"]);
		$m->type("cfg_app")->update("LINE",$_POST["LINE"]);
		
		
		tip_success("修改成功",'qq_admin.php');
		
	}else{
	$action = '?act=update';
	$info["reg_type"] = $m->type("cfg_app")->getValue("reg_type");
	$info["connect_unlock"] = $m->type("cfg_app")->getValue("connect_unlock",0);
	$info["content"] = $m->type("cfg_app")->getValue("content");
	$info["max_limit"] = $m->type("cfg_app")->getValue("max_limit",100);
	$info["SMS_T"] = $m->type("cfg_app")->getValue("SMS_T",3);
	$info["SMS_L"] = $m->type("cfg_app")->getValue("SMS_L",100);
	$info["SMS_I"] = $m->type("cfg_app")->getValue("SMS_I",0);
	
	$info["Auth_Token"] = $m->type("cfg_app")->getValue("Auth_Token",0);
	$info["Account_Sid"] = $m->type("cfg_app")->getValue("Account_Sid",0);
	$info["APP_ID"] = $m->type("cfg_app")->getValue("APP_ID",0);
	$info["Template_ID"] = $m->type("cfg_app")->getValue("Template_ID",0);
	$info["APP_NAME"] = $m->type("cfg_app")->getValue("APP_NAME",0);
	$info["LINE"] = $m->type("cfg_app")->getValue("LINE",0);
		
 ?>
<div class="box">
	<div class="main">
	<div style="clear:both;height:10px;"></div>
	
		<form class="form-horizontal" role="form" method="POST" action="<?php echo $action?>" onsubmit="return checkStr()">
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">注册通道</label>
				<div class="col-sm-10">
						<select name="reg_type" class="form-control">
							<option value="default">普通注册</option>
							<option value="sms" <?php echo $info["reg_type"]=="sms" ? "selected" :"";?>>短信注册</option>
						</select>
						<br><a href="http://www.dingd.cn/doc/index.php?doc=fas#sms" target="_blank" class="btn btn-default"><i class=" icon-book"></i>&nbsp;&nbsp;短信配置方法</a>		
				</div>
			</div>

			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">线路定位</label>
				<div class="col-sm-10">
					<select name="LINE" class="form-control">
						<option value="abs">开启</option>
						<option value="no_abs" <?php echo $info["LINE"]=="no_abs" ? "selected" :"";?>>关闭</option>
					</select>		
				</div>
			</div>
	
			<div class="form-group">
				<label for="firstname" class="col-sm-2 control-label">连接激活</label>
				<div class="col-sm-10">
					<select name="connect_unlock" class="form-control">
						<option value="0">关闭</option>
						<option value="1" <?php echo $info["connect_unlock"]=="1" ? "selected" :"";?>>开启</option>
						
					</select>		
				</div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">注册赠送时长(单位:天)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="SMS_T" value="<?php echo $info['SMS_T'] ?>"></div>
			</div>

				<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">注册赠送流量(单位：MB)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="SMS_L" value="<?php echo $info['SMS_L'] ?>"></div>
			</div>

				<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">注册状态</label>
				<div class="col-sm-10">
						<select name="SMS_I" class="form-control">
						<option value="0">禁用</option>
						<option value="1" <?php echo $info["SMS_I"]=="1" ? "selected" :"";?>>激活</option>
						</select>		
				</div>
			</div>

			
			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">短信注册 Account Sid(短信注册则必填)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="Account_Sid" value="<?php echo $info['Account_Sid'] ?>"></div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">短信注册 Auth Token(短信注册则必填)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="Auth_Token" value="<?php echo $info['Auth_Token'] ?>"></div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">短信注册 APP ID(短信注册则必填)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="APP_ID" value="<?php echo $info['APP_ID'] ?>"></div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">短信模板ID(短信注册则必填)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="Template_ID" value="<?php echo $info['Template_ID'] ?>"></div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">您的APP名称(短信注册则必填)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="APP_NAME" value="<?php echo $info['APP_NAME'] ?>"></div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">客服页面内容（支持HTML）</label>
				<div class="col-sm-10">
					<textarea class="form-control" rows="10" name="content" id="myEditor"><?php echo $info['content'] ?></textarea>
				</div>
			</div> 

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">请设置无限套餐封底(流量达到这个数值自动识别为无限/单位：GB)</label>
				<div class="col-sm-10"><input class="form-control" rows="10" name="max_limit" value="<?php echo $info['max_limit'] ?>"></div>
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
