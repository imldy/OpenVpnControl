<?php
require(dirname(dirname(__FILE__))."/system.php");
$username = $argv[1];
@$s = $argv[2];
@$r = $argv[3];
$db = db(_openvpn_);
$uinfo = $db->where(array(_iuser_=>$username))->find();
$new_s = $uinfo[_isent_] + $s;
$new_r = $uinfo[_irecv_] + $r;

db(_openvpn_)->where(["id"=>$uinfo["id"]])->update(["online"=>0]);
if($new_r+$new_s > $uinfo[_maxll_]){
	//流量不足 禁用此用户
	$db->where(array("id"=>$uinfo["id"]))->update(array(_i_=>"0"));
}
if($db->where(array("id"=>$uinfo["id"]))->update(array(_isent_=>$new_s,_irecv_=>$new_r)))
{
	//更新用户数据并且更新排行榜数据
	$db2 = db('top');
	$c = $s+$r;
	$u = $db2->where(array('username'=>$username,'time'=>date('Y-m-d',time())))->find();
	if($u){
		$new = $u['data']+$c;
		$db2->where(array('id'=>$u['id']))->update(array('data'=>$new));
	}else{
		$db2->insert(array('username'=>$username,'data'=>$c,'time'=>date('Y-m-d',time())));
	}
	//db("session")->where(["username"=>$username])->delete();
};