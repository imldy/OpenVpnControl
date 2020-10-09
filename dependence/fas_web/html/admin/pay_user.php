<?php
require('../pay/FkPay.class.php');

$do = $_GET['do'];

if($do == 'tx'){
	require('head.php');
	require('nav.php');
	?>
	<div class="box">
		<div class="alert alert-warning">
			<b>提现功能并非发卡君官方接口，您的发卡君账户信息会发送到官网，由FAS官网代理模拟登录实现，我们承诺不存储、利用、泄露您的密码信息，若您介意，请勿使用本功能。</b><br>
			若出现提现失败的情况请检查发卡君账户密码设置，或者前往发卡君提现。<br>
			一小时只能提现一次，提现只能提现进支付宝。
		</div>
		<div class="jg">
			<h3>余额提现申请中...</h3>
			<div class="progress progress-striped active">
				<div class="progress-bar progress-bar-success" role="progressbar"
					 aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
					 style="width: 100%;">
					<span class="sr-only">提现中....</span>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(function(){
		$.post('?do=tx_sync',{},function(data){
			$(".jg").html('<h3>操作完成 ：'+data.msg+'</h3>');
		},"JSON");
	});
	</script>
	<?php
	require('footer.php');
	exit;
}elseif($do == 'data'){
	require('system.php');
	$pay = pay();
	$pay->method('data.statistics');
	$data = $pay->pay();
	echo json_encode($data);
	exit;
}elseif($do == 'tx_sync'){
	require('system.php');
	$m = new Map();
	$info["fk_pass"] = $m->type("cfg_pay")->getValue("fk_pass");
	$info["fk_mail"] = $m->type("cfg_pay")->getValue("fk_mail");
	die(file_get_contents("http://api.dingd.cn/fkj.php?username=".$info["fk_mail"].'&password='.$info["fk_pass"]));
	exit;
}elseif($do == 'sync'){
	require('system.php');
	$pay = pay();
	$pay->method('invoice.list');
	$order = $pay->pay();
	foreach($order['data']['data'] as $vo)
	{
		//var_dump($vo);
	?>
    <tr>
      <td><?= $vo['number']?></td>
      <td><?= $vo['total']?></td>
      <td><?= $vo['status'] == 'unpaid' ? '未支付' : '已支付';?></td>
      <td><?= $vo['payment']?></td>
      <td><?= $vo['type']?></td>
      <td><?= $vo['updated_at']?></td>
    </tr>
	<?php }
	exit;
}

require('head.php');
require('nav.php');
$pay = pay();
$pay->method('user.info');
$info = $pay->pay();


$pay->method('login.list');
$login = $pay->pay();



//var_dump($login);
if($info['code'] != '10000')
{
	tip_failed($info['msg'],'pay.php');
}

?>
<style>
#line
{
	width: 100%;
	height: 385px;
	
}
#pie
{
	width: 100%;
	height: 400px;
	
}
.box-group{
	color:#222;
	font-size:16px;
	text-align:center;
	border-bottom:4px solid #328cc9;
	padding:10px 0px;
	margin:0px 10px;
}
.i-box{
	margin-bottom:15px;
	background:#fff;
	height:85px;
	position:relative;
	padding:15px;
}

.i-box .i-icon{
	position:absolute;
	width:55px;
	height:55px;
	line-height:55px;
	text-align:center;
	font-size:25px;
	background:#4bb0e5;
	color:#fff;
	border-radius:30px;
}
.i-box .i-right{
	padding-top:3px;
	margin-left:75px;
	height:60px;
}
</style>


	<div class="row">
    
	<div class="col-xs-12 col-md-3"> 
		<div class="i-box"> 
			<div class="i-icon">
				<i class="icon-group"></i>
			</div>
			<div class="i-right">
			<p>余额 : <?=$info['data']['money']?> 元 [<a href="?do=tx">提现</a>]</p> 
			<p>邮箱 : <?=$info['data']['email']?></p> 
			</div>             
		</div>             
    </div>      
<div class="col-xs-12 col-md-3"> 
		<div class="i-box"> 
			<div class="i-icon" style="background:#43ba9c">
				<i class="icon-heart"></i>
			</div>
			<div class="i-right">
			<p>支付宝 : <?= substr($info['data']['alipay'],0,5)?> ***</p> 
			<p>微信 : <?= substr($info['data']['wechat'],0,5)?> ***</p> 
			</div>             
		</div>             
    </div>      
<div class="col-xs-12 col-md-3"> 
		<div class="i-box"> 
			<div class="i-icon" style="background:#5CB85C">
				<i class="icon-bell-alt"></i>
			</div>
			<div class="i-right">
			<p>今日成交 : <span class="t_count">-</span> 笔</p> 
			<p>今日收入 : <span class="t_money">-</span> 元</p> 
			</div>             
		</div>             
    </div>      
<div class="col-xs-12 col-md-3"> 
		<div class="i-box"> 
			<div class="i-icon">
				<i class="icon-time"></i>
			</div>
			<div class="i-right">
			<p><?=date("Y/m/d H:i")?></p> 
			<p>系统时间</p> 
			</div>             
		</div>             
    </div>      	
	
	<div class="col-xs-12 col-sm-9">
	
		<div class="box" style="margin-bottom:15px;">
			
			<table class="table table-striped">
  <caption>已支付账单记录(最近10条) &nbsp;总数:<?=$order['data']['total']?></caption>
  <thead>
    <tr>
      <th>订单编号</th>
      <th>金额</th>
      <th>状态</th>
      <th>方式</th>
      <th>类型</th>
      <th>时间</th>
    </tr>
  </thead>
  <tbody class="invoice">
		<tr>
		<td class="" colspan="6">
			<center>
				加载中...
			</center>
		</td>
		</tr>
  </tbody>
</table>
<a class="btn btn-default btn-block" href="https://www.fakajun.com/user/index" target="_blank">更多前往发卡君查看</a>
		</div>
		
		<div class="box" style="margin-bottom:15px">
		
		</div>
	</div>

	<div class="col-xs-12 col-sm-3"> 
		<div class="box" style="margin-bottom:15px;border:none;padding:5px;">
				
			<table class="table table-striped">
			  <caption>最近登录记录</caption>
			  <tbody>
			 <?php
				foreach($login['data']['data'] as $vo)
				{
					//var_dump($vo);
				?>
				<tr>
				  <td><?= $vo['ipaddress']?></td>
				  <td><?= $vo['status'] == "success" ?"登录成功":"登录失败";?></td>
			
				  <td><?= $vo['updated_at']?></td>
				</tr>
			<?php } ?>
			  </tbody>
			</table>
		</div>	
	</div>	
	</div>	
	<script>
	$(function(){
		$.post("?do=sync",{},function(data){
			$(".invoice").html(data);
		});
	});$
	
	$(function(){
		$.post("?do=data",{},function(data){
			$("span.t_count").html(data.count);
			$("span.t_money").html(data.money);
		},"JSON");
	});
	</script>
 <?php
 include("footer.php");
 ?>