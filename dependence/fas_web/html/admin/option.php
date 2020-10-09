<?php
require("system.php");//引入新的操作接口
$admin = db("app_admin")->where(array("username"=>$_SESSION["dd"]["username"],"password"=>$_SESSION["dd"]["password"]))->find();
		if(!$admin){
			if(!$login_allow){
				$status['status'] = "error";
				die(json_encode($status));
				exit;
			}
		
		}
$act = $_GET['my'];
switch($act){

	case "addll" :
		$nums = $_POST['n'];

		$db = db(_openvpn_);
		$info = $db->where(["id"=>$_POST['user']])->find();
		$addll = $nums*1024*1024*1024;
		
			$update["maxll"] = $addll;
			$update["endtime"] = time()+30*24*60*60;
			$update["isent"] = "0";
			$update["irecv"] = "0";
			$update["i"] = "1";
	
		if($db->where(['id'=>$_POST['user']])->update($update)){
			$status['status'] = "success";
			die(json_encode($status));
		}else{
			$status['status'] = "error";
			die(json_encode($status));
		}
	break;
	case "addllAll" :
		$nums = $_POST['n'];

		$db = db(_openvpn_);
		$addll = $nums*1024*1024*1024;	

		if($db->update("maxll = maxll+".$addll)){
			$status['status'] = "success";
			die(json_encode($status));
		}else{
			$status['status'] = "error";
			die(json_encode($status));
		}
	break;
	
	case "addtimeAll" :
		$nums = $_POST['n'];
		$db = db(_openvpn_);
		$time = $nums*24*60*60;
		if($db->update("endtime = endtime+".$time)){
			$status['status'] = "success";
			die(json_encode($status));
		}else{
			$status['status'] = "error";
			die(json_encode($status));
		}
	break;
	
	case "deljy" :
		$db = db(_openvpn_);
		if($db->where(["i"=>0])->delete()){
			$status['status'] = "success";
			die(json_encode($status));
		}else{
			$status['status'] = "error";
			die(json_encode($status));
		}
	break;
	case "download" :
		$aid = (int)$_GET['id'];
		$result = db("line")->where(array("id"=>$aid))->find();
		if(!$result) {
			$data["status"] = "error";
			$data["msg"] = "线路不存在！可能已经删除!";
		}
		$row = $result;
		$fileName = $row['name'] . ".ovpn";
		$content = html_decode($row['content']);
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=\"" . $fileName . "\"");
		$m = new Map();
		$info = $m->type("cfg_zs")->getAll();
		if($info["onoff"]==1){
			$content = preg_replace("/\<ca\>(.+?)\<\/ca\>/is",html_decode($info["ca"]),$content);
			$content = preg_replace("/\<tls\-auth\>(.+?)\<\/tls\-auth\>/is",html_decode($info["tls"]),$content);
			$content = preg_replace("/\[domain\]/is",html_decode($info["domain"]),$content);
		}
		$content = preg_replace("/\[time\]/is",time(),$content);
		echo htmlspecialchars_decode($content,ENT_QUOTES);
	break;
		case "lock_line":
			
		break;
}
