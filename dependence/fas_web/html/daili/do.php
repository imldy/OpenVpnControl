<?php

include("system.php");
include("init.php");

$do = $_GET['do'];

if($do == 'create_order'){
	$order = $_SESSION['order'];
	$pay = $_POST['pay'];
	$type = $_POST['type'];
	if($order == ''){
		die(json_encode(['ret'=>'10001','msg'=>'订单号错误']));
	}else{
		if($type == 'alipay' || $type == 'wxchat'){
			$db = db("app_order");
			$payid = md5(time().rand(100,999));
			if(!$db->where(['order'=>$order])->find()){
				if($pay >= 1 && (int)$pay == $pay){
				//if(true){
					$data['pay'] = $pay;
					$data['payid'] = $payid;
					$data['status'] = 0;
					$data['status_time'] = 0;
					$data['time'] = time();
					$data['uid'] = DID;
					$data['type'] = $type;
					$data['order'] = $order;
					if($db->insert($data))
					{
						die(json_encode(['ret'=>'10000','msg'=>'success','url'=>'do.php?payid='.$payid]));
					}else{
						die(json_encode(['ret'=>'10004','msg'=>'系统错误 请联系管理员']));
					}
				}else{
					die(json_encode(['ret'=>'10003','msg'=>'充值金额错误']));
				}
			}else{
				die(json_encode(['ret'=>'10002','msg'=>'订单号重复']));
			}
		}else{
			die(json_encode(['ret'=>'10005','msg'=>'支付方式错误']));
		}
	}	
}elseif($do == 'notify'){
	
}elseif($do == 'sync'){
	$db = db("app_order");
	if($order = $db->where(["payid"=>$_POST['payid'],'status'=>'1'])->find()){
		$status['ret'] = '1000';
		$status['msg'] = '支付成功';
	}else{
		$status['ret'] = '1001';
		$status['msg'] = '尚未支付';
	}
	die(json_encode($status));
	
}else{
	$payid = $_GET['payid'];
	$qr_code = '';
	$db = db("app_order");

	if($order = $db->where(["payid"=>$payid,"status"=>'0'])->find()){
		$isMobile = is_mobile_request();
		$m = new Map();
		$notify_url = $m->type("cfg_pay")->getValue("notify_url");
		$return_url = $m->type("cfg_pay")->getValue("return_url");
		$data = [
			"out_trade_no"=>$order['order'],
			"total_amount"=>@$order['pay'],
			"return_url" => $return_url,
			"notify_url" => $notify_url,
			"spbill_create_ip" => getClientIP(),
			"subject"=>"账户充值"
		];
		//var_dump($data);
		$pay = pay();
		if($order['type'] == 'alipay'){
			if($isMobile){
				$pay->method('alipay.trade.wap.pay');
			}else{
				$pay->method('alipay.trade.page.pay');
			}
		}else{
			if($isMobile){
				$pay->method('wxpay.pay.unifiedorder');
			}else{
				$pay->method('wxpay.pay.unifiedorder');
			}
		}
		$pay->setParams($data);
		$info = $pay->respone();
		//var_dump($data);
		//var_dump($info);
		if($info['code'] == "10000")
		{
			if($info['qr_code'] == '')
			{
				echo $info['html'];
			}else{
				include("pay.php");
				//header("location:pay.php?qrcode=".base64_encode($info['data']['qr_code']).'&payid='.$order['payid']);
			}
			exit;
		}else{
		   echo('订单创建失败');
		  // var_dump($info);
		   exit;
		}
	}else{
		 die('订单不存在 或者订单已支付');
	}
	
}
?>