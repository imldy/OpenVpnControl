<?php
include("system.php");
include("api_head.php");
include("nav.php");
if(isset($_POST['km'])){
	$km = $_POST['km'];
	$myrow=db("app_kms")->where(array("km"=>$km))->find();
	if(!$myrow){
		echo "<script>alert('此激活码不存在');</script>";
	}elseif($myrow['isuse']==1){
		echo "<script>alert('此激活码已被使用');</script>";
	}else{
		$type_id = $myrow["type_id"];
		$tc = db("app_tc")->where(array("id"=>$type_id))->find();
		if(!$tc){
			echo "<script>alert('套餐已经失效');</script>";
		}
		//$uinfo = db(_openvpn_)->where(array(_iuser_=>$userinfo[""]))->find();
		$duetime = time() + $tc['limit']*24*60*60;
		$addll = $tc['rate']*1024*1024;
		//已到期 清空全部流量
		$update[_maxll_] = $addll;
		$update[_endtime_] = $duetime;
		$update[_isent_] = "0";
		$update[_irecv_] = "0";
		$update["daili"] = $myrow["daili"];
		$update[_i_] = "1";
		if(db(_openvpn_)->where(["id"=>$userinfo["id"]])->update($update)){
			db("app_kms")->where(array("id"=>$myrow['id']))->update(array("isuse"=>"1","user_id"=>$userinfo["id"],"usetime"=>time()));
			echo "<script>alert('开通成功');</script>";
		}else{
			echo "<script>alert('开通失败');</script>";
		}
	}
}
$key = explode("_",$_GET["app_key"]);
?><div class="alert alert-success" style="display:none;margin:0px;" >
		请在此输入您购买的流量卡密。
	</div>
	<div style="margin:10px">
	<form action="?" method="POST">
				<div class="form-group">
					<input type="text" class="form-control" name="km" placeholder="请输入激活码卡密">
				</div>
				<button type="submit" class="btn btn-success btn-block cz" onclick="kmcz()">
					充值到我的账户
				</button>
				</a>
		
			<br />
			<br />
			【使用说明】
			<br />
			* 充值会<span style="color:red">清空剩余流量</span>，并重设为购买的流量。时间将会设置为充值之日起到充值卡指定的日期结束，超出流量无需补交。
			<br>
	</form>
	<h4>用户账号：<?php echo $userinfo[_iuser_]?></h4>
	<h4>用户状态：<?php echo $userinfo["i"] == 1 ? "启用" : "禁用";?></h4>
	<h4>流量剩余：<?php echo round(($userinfo['maxll']-$userinfo['isent']-$userinfo['irecv'])/1024/1024);?>M</h4>
	<h4>流量到期：<?php echo date("Y年m月d日",$userinfo["endtime"]);?></h4>
<?php 
include("api_footer.php");
?>