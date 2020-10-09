<?php

//file_put_contents("test.txt",http_build_query($_POST));

	require("../system.php");
	require("init.php");
	function outs($str){
		//file_put_contents("test.txt",$str);
		die($str);
	}
	
	$no = $_POST["out_trade_no"];
	$total_amount = $_POST["total_amount"];
	$sign = pay()->sign($_POST);
	if(isset($_POST['sign']) && $sign == $_POST['sign']) 
	{
		$db = db("app_order");
		if($order = $db->where(["order"=>$no,"status"=>0])->find())
		{
			$db->where(["order"=>$no])->update(['status'=>1,'status_time'=>time()]);
			$daili = db("app_daili");
			if($info = $daili->where(['id'=>$order['uid']])->update('balance = balance+'.$total_amount.',`lock`=1'))
			{
				outs("success");
			}else{
				$db->where(["order"=>$no])->update(['status'=>2]);
				outs("status success");
			}
			
		}else{
			outs('order error');
		}
	}else{
		outs('sign error'.$sign.$_POST['sign']);
	}
	