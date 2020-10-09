<?php
	require('../system.php');
	
	$m = explode("_",$_GET['app_key']);
	
	$DID = 0;
	
	if(count($m) == 2){
		if(db("app_daili")->where(["id"=>$m[1]])->find()){
			$DID = $m[1];
		}
	}
	define("DID",$DID);
	
	function get_millisecond(){  
		list($usec, $sec) = explode(" ", microtime());   
		$msec=round($usec*1000);  
		return $msec;
	}
	function senddx($t,$c){
		$m = new Map();
		$info["Auth_Token"] = $m->type("cfg_app")->getValue("Auth_Token");
		$info["Account_Sid"] = $m->type("cfg_app")->getValue("Account_Sid");
		$info["APP_ID"] = $m->type("cfg_app")->getValue("APP_ID");
		$info["Template_ID"] = $m->type("cfg_app")->getValue("Template_ID");
		$info["APP_NAME"] = $m->type("cfg_app")->getValue("APP_NAME");
		$tid = $info["Auth_Token"];
		$sid = $info["Account_Sid"];
		$time = date("YmdHis");
		$to = $t;
		$sign = strtoupper(md5($sid.$tid.$time));
		//file_put_contents("d.txt",file_get_contents("d.txt")."\n".$sid.$tid.$time." = " .$sign);
		$appid = $info["APP_ID"];
		
		
		$data["templateSMS"]["appId"] = $appid;  //定义参数  
		$data["templateSMS"]["templateId"] = $info["Template_ID"];  //定义参数  
		$data["templateSMS"]["param"] = $info["APP_NAME"].','.$c.',60';  //定义参数  
		$data["templateSMS"]["to"] = $to;  //定义参数  
		
		
		$data = json_encode($data);  //把参数转换成URL数据  

		$url  = 'https://api.ucpaas.com/2014-06-30/Accounts/'.$sid.'/Messages/templateSMS?sig='.$sign;
		
		//file_put_contents("d.txt",file_get_contents("d.txt")."\n".$url);
		$header = array(
             'Accept: application/json',
             'Content-Type: application/json;charset=utf-8',
             'Authorization:' .base64_encode($sid.":".$time)
         );
        //file_put_contents("d.txt",file_get_contents("d.txt")."\n".'Authorization:' .base64_encode($sid+":"+$time));
       // file_put_contents("d.txt",file_get_contents("d.txt")."\n".'数据:' .$data);
		
		$ch = curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        $result = curl_exec($ch);
        curl_close($ch);
		return $result;
	}
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
	if($_GET['act'] == 'line'){
		include('api_head.php');
		include('mode/line.php');
		include("api_footer.php");
	//=========================================
	}elseif($_GET['act'] == 'app_check'){
		include("shengji.php");
	}elseif($_GET['act'] == 'login_sms'){
		if(trim($_POST['username']) == ''){
			die(json_encode(array('status'=>'error','msg'=>'手机号码尚未填写')));
		}
		$db= db(_openvpn_);
		if($db->where(array(_iuser_=>$_POST['username']))->find()){	
			die(json_encode(array('status'=>'error','msg'=>'此手机号码已经被注册！无法再次注册！')));
		}else{
			$code = rand(1000,9999);
			$_SESSION['code'] = $code;
			$_SESSION['phone'] = $_POST['username'];
			$_SESSION["last_send"] = time();
			$c = senddx($_POST['username'],$code);
			$resp = json_decode($c,true);
			if($resp['resp']['respCode'] == "000000"){
				die(json_encode(array('status'=>'success')));
			}else{
				die(json_encode(array('status'=>'error','msg'=>"短信发送失败 错误代码：".$resp["resp"]["respCode"],'time'=>date("YmdHis",SYSTEM_T))));
				//die(json_encode(array('status'=>'error','msg'=>"短信发送失败")));
			}
		}
	}elseif($_GET['act'] == 'reg_in'){
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
			$date["daili"] = DID;
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
	}elseif($_GET['act'] == 'app_reg'){
		include("mode/app_reg.php");
	}elseif($_GET['act'] == 'dx_reg'){
		include("api_head.php");
		
		$m =  new Map();
		$type = $m->type("cfg_app")->getValue("reg_type");
		
		if($type == "sms"){
			include("mode/dx_reg.php");
		}else{
			include("mode/app_reg.php");
		}
		include("api_footer.php");
	}elseif($_GET['act'] == 'info'){
		include("api_head.php");
		include("mode/llog.php");
		include("api_footer.php");
	}elseif($_GET['act'] == 'user_info'){
		header("location:user/index.php?user=".$_GET['username'].'&pass='.$_GET['password']);
	}elseif($_GET['act'] == 'Shop'){
	//流量购买
		include("api_head.php");
		include("mode/ad.php");
		include("api_footer.php");
	}elseif($_GET['act'] == 're_bbs'){
		$u = $_GET['username'];
		$p = $_GET['password'];
		$db = db("app_bbs");
		if($db->insert(array("username"=>$u,"content"=>$_POST["content"],"time"=>time(),"to"=>$_POST["to"]))){
			die(json_encode(array("status"=>"success")));
		}else{
			die(json_encode(array("status"=>"error")));
		}
		
	}elseif($_GET['act'] == 'feedback'){
		$u = $_GET['username'];
		$p = $_GET['password'];
		$user = db(_openvpn_)->where([_iuser_=>$u])->find();
		if($user){
			$db = db("app_feedback");
			$old = $db->where(["user_id"=>$user["id"],"line_id"=>$_POST["line_id"]])->order("id DESC")->find();
			if($old){
				if(time()-$old["time"] < 60*15){
					die(json_encode(array("status"=>"old")));
				}
			}
			foreach($config["Feedback"]["Field"] as $key=>$vo){
				$data[$key] = $_POST[base64_encode($key)];
			} 
			if($db->insert(array("user_id"=>$user["id"],"content"=>base64_encode(json_encode($data)),"time"=>time(),"line_id"=>$_POST["line_id"]))){
				die(json_encode(array("status"=>"success")));
			}else{
				die(json_encode(array("status"=>"error")));
			}
		}
		
	}elseif($_GET['act'] == 'list_bbs'){
		include('api_head.php');
		include('mode/list_bbs.php');
		include("api_footer.php");
	}elseif($_GET['act'] == 'bbs'){
		include('api_head.php');
		include('mode/bbs_view.php');
		include("api_footer.php");
	}elseif($_GET['act'] == 'list_gg'){
		include('api_head.php');
		//include('list_gg.php');
		$u = $_GET['username'];
		$p = $_GET['password'];
		$db = db('app_gg');
		$list = $db->where(["daili"=>DID])->order('id DESC')->select();
		echo '<div style="margin:10px 10px;">';
			echo '<div class="alert alert-warning">您可以在这看到最近30条消息通知</div>';
		
			echo '</div>';
		if($list){
			echo '<ul class="list-group">';
			foreach($list as $v){
				$is_read = db("app_read")->where(array("readid"=>$v["id"],"username"=>$_GET["username"]))->find();
				$pre = $is_read ? '' :'<span class="badge">未读</span>'; 
				echo '<li class="list-group-item"><a href="?act=gg&id='.$v['id'].'&username='.$_GET['username'].'&app_key='.$_GET['app_key'].'">'.$pre.$v['name'].'</a></li>
				';
			}
		echo '</ul>';
		}else{
			echo '消息已经删除或者不存在！';
		}
		
		include("api_footer.php");
	}elseif($_GET['act'] == 'gg'){
		include('api_head.php');
		include('mode/gg_view.php');
		include("api_footer.php");
		
	}elseif($_GET['act'] == 'load_gg'){
		$u = $_POST['username'];
		$p = $_POST['password'];
		$db = db('app_gg');
		$vo = $db->where(["daili"=>DID])->order('id DESC')->find();
		$is_read = db("app_read")->where(array("readid"=>$vo["id"],"username"=>$u))->find();
		if($vo && !$is_read){
			die(json_encode(array('status'=>'success','url'=>'http://'.$_SERVER["HTTP_HOST"].'/app_api/api.php?act=gg&id='.$vo['id'].'&username='.$u.'&','title'=>$vo['name'],'content'=>$vo['content'])));
		}else{
			die(json_encode(array('status'=>'error','url'=>'no data','title'=>'no data')));
		}
		
	}elseif($_GET['act'] == 'load_info'){
		$u = @$_POST['username'];
		$p = @$_POST['password'];
		$ud = new U($u,$p,true);
		$u = db(_openvpn_)->where(array(_iuser_=>$u,_ipass_=>$p))->find();
		if($u){
			#$now = getInfo_i($_POST['username']);
			$uinfo = $u;
			
			$count =  printmb($uinfo[_maxll_]);	
			$isuse = printmb($uinfo[_irecv_]+$uinfo[_isent_]);	
			$sy = printmb($uinfo[_maxll_]-($uinfo[_irecv_]+$uinfo[_isent_]));
		
			
			$upload = printmb($uinfo[_irecv_]);
			$download = printmb($uinfo[_isent_]);
			//system("/home/wwwroot/default/res/sha ".$u[_iuser_]);
			if($sy['n'] <= 0 && $sy['p'] == 'M'){
				$t = 'tips_user';
				$s = round($sy['n'],1).$sy['p'];
			}elseif($sy['n'] <= 100 && $sy['p'] == 'M'){
				$t = 'tips_user';
				$s = round($sy['n'],1).$sy['p'];
			}else{
				$t = 'success';
				$s = round($sy['n'],1).$sy['p'];
			}
			$_sy = $ud->getDatadays();
			$_all = $uinfo[_maxll_] >= _MAX_LIMIT_*1024*1024*1024 ? "NO_LIMIT" : $s;
			die(json_encode(array('status'=>$t,'all'=>$uinfo[_maxll_]-($uinfo[_irecv_]+$uinfo[_isent_]),'sy'=>$_all,'stime'=>'2','etime'=>'2','bl'=>$_sy."天")));
			exit;
		}else{
			
			die(json_encode(array('status'=>'success','all'=>'0','sy'=>'未知','stime'=>'2','etime'=>'2','bl'=>$_sy."天")));
			exit;
		}
		
	//=======================================
	}elseif($_GET['act'] == 'top'){
		include('api_head.php');
		include('mode/top.php');
		include("api_footer.php");
	}elseif($_GET['act'] == 'log'){
		include('api_head.php');
		include('mode/log.php');
		include("api_footer.php");
	}elseif($_GET['act'] == 'login_in'){
		
		$u = $_POST['username'];
		$p = $_POST['password'];
		
		$ud = new U($u,$p,true);

		if($ud->isuser){
			$uinfo = $ud->getNative();
			$sydata =$ud->getDatasurplus();
			$_sy = $ud->getDatadays();
			$max = $ud->getDatamax();
			$count =  printmb($max);
			$isuse = printmb($ud->getDataused());
			$sy = printmb($sydata);
			$s = $count>=_MAX_LIMIT_*1024*1024*1024 ? "NO_LIMIT" : round($sy['n'],1)." ".$sy['p'];
			die(json_encode(array(
				'status'=>'success',
				'msg'=>base64_encode($u[_iuser_]."\n".$u[_ipass_]."\n".round($sy['n'],1).$sy['p']."\n".$count."\n".round($_sy,0)),
				'username'=>$uinfo[_iuser_],
				'password'=>$uinfo[_ipass_],
				'liuliang'=>$s,
				'all'=>$sydata,
				'bl'=>$_sy."天"
			)));
			
		}else{
			die(json_encode(array(
				'status'=>'error',
				'msg'=>'用户不存在或者密码错误'
			)));
		}
		
	}elseif($_GET['act'] == 'login_check'){
		$u = $_POST['username'];
		$p = $_POST['pass'];
		//echo "系统紧急调试 请稍等几分钟";
		//	exit;
		$ud = new U($u,$p,true);
		include("Splash.php");
		$yes = $data["status"] == "success" ? "yes" : "no";
		$url = $data["url"];
		if($ud->isuser){
			
			$uinfo = $ud->getNative();
			
			$sydata =$ud->getDatasurplus();
			$_sy = $ud->getDatadays();
			$max = $ud->getDatamax();
			$count =  printmb($max);
			$isuse = printmb($ud->getDataused());
			$sy = printmb($sydata);
			
			
			$s = $max>=_MAX_LIMIT_*1024*1024*1024 ? "NO_LIMIT" : round($sy['n'],1)." ".$sy['p'];
			$data = "success_need_login\n";
			$data .= $uinfo[_iuser_]."\n";
			$data .= $uinfo[_ipass_]."\n";
			$data .= $s."\n";
			$data .= $sydata."\n";
			$data .= $_sy."天\n";
			$data .= $yes."\n";
			$data .= $url;
			
			die($data);
			
			exit;
		}else{
			$data = "error_need_login\n";
			$data .= "0\n";
			$data .= "0\n";
			$data .= "0\n";
			$data .= "0\n";
			$data .= "0\n";
			$data .= $yes."\n";
			$data .= $url;
			
			die($data);
			exit;
		}
		
		
		
	//=======================================
	}elseif($_GET['act'] == 'theme'){
		include('api_head.php');
		include('mode/theme.php');	
		include("api_footer.php");
	}elseif($_GET['act'] == 'help'){
		include('api_head.php');
		include('mode/help.php');	
		include("api_footer.php");
	}elseif($_GET['act'] == 'more'){
		include('api_head.php');
		include('mode/all.php');
		include("api_footer.php");  
	}else{
		include('api_head.php');
		echo "页面走丢啦";
		include("api_footer.php");  
	} ?>
