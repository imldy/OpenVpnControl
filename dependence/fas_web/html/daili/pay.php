<?php
$qrcode = json_decode(file_get_contents('https://www.dingd.cn/api/qrcode/api.php?data='.$info['qr_code']),true);
?>
<!DOCTYPE html>
<html lang="cn" >
<head>
<meta charset="utf-8" />
<title>叮咚流量卫士 云库系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="/css/bootstrap.min.css" />
<script src="/css/jquery.min.js"></script>
<script src="/css/bootstrap.min.js"></script>
<link rel="stylesheet" href="/css/font-awesome.min.css">
</head>
<body>
<style type="text/css">
body,html{
	background:#efefef;
	padding:0px;
	margin:0px;
	font-family: "Microsoft Yahei","Hiragino Sans GB","Helvetica Neue",Helvetica,tahoma,arial,Verdana,sans-serif,"WenQuanYi Micro Hei","\5B8B\4F53";
}
*{
	padding:0px;
	list-style:none;
}


 .container{
	
}
.content-main{
	background:#fff;
	padding:20px 20px;

}
.btn{
	border-radius: 0px;
}
.tip{
	padding:15px;
	margin:10px;
	background:#fff;
}
.tip-success{
	background:
}
.box{
	background:#fff;
	padding:20px;
	
}
.qrcode-box{
	max-width:100%;
	width:850px;
	margin:30px auto;
	background:#fff;
	padding:50px 0px;
	border-left:1px solid #efefef;
	border-bottom:1px solid #efefef;
}
.qrcode{
	width:200px;
	margin:0px auto;
	background:#fff;
}
.qrcode img{
	width:100%;
}
.info{
	color:#333;
	font-size:15px;
	line-height:30px;
	margin:20px;
	padding:20px 0px;
	border-top:1px solid #efefef;word-wrap:break-word ;
}
</style>
<div class="qrcode-box">
	<center>
	<h1>请<?= $order['type'] == 'alipay' ? '支付宝' : '微信扫码';?>支付</h1>
	</center>
	<div class="qrcode">
		<img src="https://www.dingd.cn<?=$qrcode['url']?>">
	</div>
	<div class="info">
		<div class="row">
		 <div class="col-xs-4 col-sm-6 text-left">
		 支付方式
		 </div> 
		 <div class="col-xs-8 col-sm-6 text-right">
		<?= $order['type'] == 'alipay' ? '支付宝' : '微信扫码';?>
		 </div>
		 </div>
		 <div class="row">
		 <div class="col-xs-4 col-sm-6 text-left">
		 产品名称
		 </div> 
		 <div class="col-xs-8 col-sm-6 text-right">
		余额充值
		 </div>
		 </div>
		 
		 <div class="row">
		 <div class="col-xs-4 col-sm-6 text-left">
		 订单编号
		 </div> 
		 <div class="col-xs-8 col-sm-6 text-right">
		 <?=$order['order']?>
		 </div>
		 </div>
		 
		 <div class="row">
		 <div class="col-xs-4 col-sm-6 text-left">
		 金额
		 </div> 
		 <div class="col-xs-8 col-sm-6 text-right">
		 <?=$order['pay']?>￥
		 </div>
		 </div> <div class="row">
		 <div class="col-xs-4 col-sm-6 text-left">
		 创建时间
		 </div> 
		 <div class="col-xs-8 col-sm-6 text-right">
		 <?=date("Y/m/d H:i:s",$order['time'])?>
		 </div>
		 </div>
	 </div>
</div>
<script>
$(function(){
	sync();
});
function sync(){
	$.post("?do=sync",{
		'payid':'<?=$payid?>'
	},function(json){
		if(json.ret == '1000'){
			window.location.href='order.php';
		}else{
			setTimeout(function(){
				sync();
			},1500);
		}
	},"JSON");
}
</script>
<?php
include("footer.php");
?>