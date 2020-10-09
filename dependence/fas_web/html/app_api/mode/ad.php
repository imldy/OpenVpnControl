<?php
$u = $_GET["username"];
$p = $_GET["password"];
$res=db(_openvpn_)->where(array(_iuser_=>$u,_ipass_=>$p))->find();
if(!$res){
	die("用户信息获取失败，请联系系统管理员！");
}
if(isset($_POST['km'])){
	$km = $_POST['km'];
	$myrow=db("app_kms")->where(array("km"=>$km))->find();
	if(!$myrow){
		die('充值失败，此卡密不存在哦！');
	}elseif($myrow['isuse']==1){
		die('充值失败，此卡密已被使用哦！');
	}else{
		$type_id = $myrow["type_id"];
		$tc = db("app_tc")->where(array("id"=>$type_id))->find();
		if(!$tc){
			die("充值失败，此卡密已失效，请联系您的上级服务商更换卡密~~~");
		}
		$uinfo = db(_openvpn_)->where(array(_iuser_=>$u))->find();
		$duetime = time() + $tc['limit']*24*60*60;
		$addll = $tc['rate']*1024*1024;
		//已到期 清空全部流量
		$update[_maxll_] = $addll;
		$update[_endtime_] = $duetime;
		$update[_isent_] = "0";
		$update[_irecv_] = "0";
		$update["daili"] = $myrow["daili"];
		$update[_i_] = "1";
		if(db(_openvpn_)->where(["id"=>$uinfo["id"]])->update($update)){
			db("app_kms")->where(array("id"=>$myrow['id']))->update(array("isuse"=>"1","user_id"=>$uinfo["id"],"usetime"=>time()));
			die('恭喜亲，卡密充值成功！');
		}else{
			die('充值失败，请联系系统管理员！');
		}
	}
}
$key = explode("_",$_GET["app_key"]);
?>

<div class="alert alert-danger" style="display:none;margin:0px;" >
		请在此输入您购买的流量卡密。
	</div>
	<div style="margin:10px">
				<div class="form-group">
					<input type="text" class="form-control" name="km" placeholder="请输入激活码卡密，请勿输入非卡密内容！">
				</div>
				<button type="submit" class="btn btn-info btn-block cz" onclick="kmcz()">
					点击充值
				</button>
				</a>
		
			<br />
			<br />
			【充值须知】
			<br />
			* 充值会<span style="color:red"> 清空当前流量 </span>，并更新为购买的卡密流量。时间将会设置为充值当天起到卡密指定的日期结束，超出流量无需补交哦。
			<br>
			
			</div>
		
 <script>
 var old_html = "";
 function kmcz(){
	 if($("[name=km]").val() == ""){
		 $(".alert").html("充值失败，请检查您的卡密是否正确或已被使用哦！").show();
	 }else{
		 old_html = $(".cz").html();
		 $(".cz").html("处理中...");
		 $.post("?act=Shop&username=<?php echo $_GET['username']?>&password=<?php echo $_GET['password']?>&app_key=<?php echo $_GET['app_key']?>",{
			 "km":$("[name=km]").val()
		 },function(data){
			 $(".cz").html(old_html);
			  $(".alert").show();
			  $(".alert").html(data);
		 })
	 }
 }
 </script>