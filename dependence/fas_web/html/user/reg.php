<?php
$not_to_login = true;
include("system.php");
function checkUsername($str)
{
	$output='';
	$a=preg_match('/['.chr(0xa1).'-'.chr(0xff).']/', $str);
	$b=preg_match('/[0-9]/', $str);
	$c=preg_match('/[a-zA-Z]/', $str);
	if($a && $b && $c){
		$output='汉字数字英文的混合字符串';
	}elseif($a && $b && !$c){
		$output='汉字数字的混合字符串';
	}elseif($a && !$b && $c){
		$output='汉字英文的混合字符串';
	}elseif(!$a && $b && $c){
		$output='数字英文的混合字符串';
		return true;
	}elseif($a && !$b && !$c){
		$output='纯汉字';
	}elseif(!$a && $b && !$c){
		$output='纯数字';
		return true;
	}elseif(!$a && !$b && $c){
		$output='纯英文';
		return true;
	}
	//return $output;
	return false;
}
if($_GET['act'] == 'reg_in'){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$code = strtolower($_POST['code']);

		if(strtolower($_SESSION['code']) != $code){
			die(json_encode(array('status'=>'error','msg'=>'验证码错误')));
		}
		$type = @file_get_contents("data/reg_type.txt");
		if($type == "sms"){
			if(trim($_SESSION['phone']) != trim($_POST['username'])){
				die(json_encode(array('status'=>'error','msg'=>'信息不一致')));
			}
		}
		if(trim($username) == '' || trim($password) == '' ){
			die(json_encode(array('status'=>'error','msg'=>'用户密码不能为空')));
		}

		if(!checkUsername($username)){
			die(json_encode(array('status'=>'error','msg'=>'用户名只能是英文和数字')));
		}
		if(!checkUsername($password)){
			die(json_encode(array('status'=>'error','msg'=>'密码只能是英文和数字')));
		}

		$db= db(_openvpn_);
		
		if($db->where(array(_iuser_=>$username))->find()){
			
			die(json_encode(array('status'=>'error','msg'=>'已经注册过了哦')));
		}else{
			$m =  new Map();
			$info["SMS_T"] = $m->type("cfg_app")->getValue("SMS_T",3);
			$info["SMS_L"] = $m->type("cfg_app")->getValue("SMS_L",100);
			$info["SMS_I"] = $m->type("cfg_app")->getValue("SMS_I",0);
			
			$date[_iuser_] = $username;
			$date[_ipass_] = $password;
			$date[_maxll_] = $info["SMS_L"]*1024*1024;
			$date[_isent_] = '0';
			$date[_irecv_] = '0';
			$date["daili"] = '0';
			$date[_i_] = $info["SMS_I"];
			$date[_starttime_] = time();
			$date[_endtime_] = time()+($info["SMS_T"]*24*60*60);
			
			$arr = explode(",",_other_);
			foreach($arr as  $v){
				$date[$v] = "";
			}
			if($db->insert($date,true)){
				$_SESSION['code'] = '';
				die(json_encode(array('status'=>'success','msg'=>'100')));
			
			}else{
				die(json_encode(array('status'=>'error','msg'=>'无法正常注册用户 请检查数据库')));
				
			}
			
		}
	}else{
		include("api_head.php");
		$m =  new Map();
			$type = $m->type("cfg_app")->getValue("reg_type");
			?>
			<style>
body,html{
	background:#fff;
	padding:0px;
	margin:0px;
	font-family:"微软雅黑"
}
*{
	font-family:"微软雅黑"
}

.login-view{
	height:100%;
	background:url("images/bg.jpg");
}
.login-box{
	width:400px;
	margin-top:200px;
	background:#fff;
	margin-left:auto;
	margin-right:auto;
}
.login-title{
	padding:18px 15px;
	font-size:18px;
	color:#fff;
	background:#30b1d5;
	border-bottom:1px solid #efefef;
}

.login-bottom{
	padding:15px 15px;
	font-size:18px;
	color:#333;
	border-top:1px solid #efefef;
	background:#f8f8f8;
	text-align:right;
}
@media screen and (max-width:768px){
	.login-box{
		width:100%;
		margin-top:10px;
		background:#fff;
		float:none;
	}
}
</style>
<div class="login-view ">
	<div class="container ">
	  <div class="login-box">
			<div class="login-title">
				用户注册
			</div>
			<?php
			if($type == "sms"){
				include("dx_reg.php");
			}else{
				include("app_reg.php");
			}
			?>
			 </div>
	</div>
</div>
			<?php
		include("api_footer.php");
	}