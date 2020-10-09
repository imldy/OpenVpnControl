<?php
require('../pay/FkPay.class.php');

$do = $_GET['do'];

if($do == 'del'){
	require('head.php');
	require('nav.php');
	$pay = pay();
	$pay->method('kami.class.del');
	$pay->setParams(['cid'=>$_GET['id']]);
	$del = $pay->pay();
	if($del['code'] == 10000){
		tip_success("操作成功",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed($del['msg'],$_SERVER['HTTP_REFERER']);
	}
	require('footer.php');
	exit;
}elseif($do == 'add'){
	require('head.php');
	require('nav.php');
	$pay = pay();
	$pay->method('kami.class.add');
	$pay->setParams([
 		'i'				=>	1,
		'template_id'	=>	1,
 		'class_name'	=>	$_POST['name'],
		'price'			=>	$_POST['price'],
		'cost'			=>	0, 		
		'details'		=>	'',
		'password'		=>	$_POST['password']
	]);
	$del = $pay->pay();
	if($del['code'] == 10000){
		tip_success("操作成功",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed($del['msg'],$_SERVER['HTTP_REFERER']);
	}
	require('footer.php');
	exit;
}elseif($do == 'addKms'){
	require('head.php');
	require('nav.php');
	$pay = pay();
	$pay->method('kami.add');
	$pay->setParams([
 		'cid' =>	 $_GET['id'],
 		'content' => $_POST['content'],
	]);
	$del = $pay->pay();
	if($del['code'] == 10000){
		tip_success("操作成功",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed($del['msg'],$_SERVER['HTTP_REFERER']);
	}
	require('footer.php');
	exit;
}

require('head.php');
require('nav.php');
$pay = pay();
$pay->method('user.info');
$info = $pay->pay();


$pay->method('kami.class.list');
$kami_class = $pay->pay();
//var_dump($kami_class);


if($info['code'] != '10000')
{
	tip_failed($info['msg'],'pay.php');
	exit;
}

?>
<div class="alert alert-warning">【注意】本页面功能均为调用发卡君api实现，使用本功能务必在发卡君注册并在本后台进行参数设置。若您需要更完整的体验请自行登录发卡君平台！</div>
<div class="box" style="margin-bottom:15px;">

<button class="btn btn-success add-group">添加商品</button>

	<table class="table table-striped">
		  <caption>商品管理</caption>
		  <thead>
			<tr>
			  <th>商品编号</th>
			  <th>商品名称</th>
			  <th>价格</th>
			  <th>预览</th>
			  <th>操作</th>
			</tr>
		  </thead>
		  <tbody class="invoice">
		  
				<!--<tr>
				<td class="" colspan="6">
					<center>
						加载中...
					</center>
				</td>
				</tr>-->
			<?php 
			foreach($kami_class['data']['data'] as $vo)
			{
				?>
				<tr>
				<td><?=$vo['id']?></td>
				<td><?=$vo['name']?></td>
				<td><?=$vo['price']?></td>
				<td><a href="https://www.fakajun.com/<?=$vo['id']?>" target="_blank" class="btn btn-success btn-xs">预览</a></td>
				<td>
				<a href="?do=del&id=<?=$vo['id']?>" class="btn btn-danger btn-xs del"><i class="icon-trash"></i>&nbsp;删除</a>
				&nbsp;
				<a href="?do=addKms&id=<?=$vo['id']?>" class="btn btn-danger btn-xs addKms"><i class="icon-cloud"></i>&nbsp;添加卡密</a></td>
				</tr>
				<?php
			}
			
			if($kami_class['data']['next_page_url'] != null)
			{
				?>
				<td class="" colspan="6">
					<center>
						您可能有较多商品，FAS暂不支持分页，请前往发卡君操作。
					</center>
				</td>
				
				<?php
			}
			
			?>
		  </tbody>
		</table>
	</div>
	<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">添加商品</h4>
            </div>
            <div class="modal-body">
			
			<!--添加分类-->
			<form class="form-horizontal submit" role="form" action="?do=add" method="POST">
				<div class="form-group" >
					<label for="name" class="col-sm-3 col-sx-12 control-label">商品</label>
					<div class="col-sm-9 col-sx-12">
					<input class="form-control" rows="10" name="name" value="流量卫士">
					</div>
				</div>
				<div class="form-group" >
					<label for="price" class="col-sm-3 col-sx-12 control-label">价格（元）</label>
					<div class="col-sm-9 col-sx-12">
					<input class="form-control" rows="10" name="price" value="1">
					</div>
				</div>	
				<div class="form-group" >
					<label for="password" class="col-sm-3 col-sx-12 control-label">购买密码（可留空）</label>
					<div class="col-sm-9 col-sx-12">
					<input class="form-control" rows="10" name="password" value="1">
					</div>
				</div>
				<p>注：本操作会同步至发卡君平台，若需要更详细的操作，请前往发卡君平台操作！</p>
				<div class="" style="display:none"><input type="submit" value="submit" class="add-submit"></div>
			</form>
					
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default remake" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="$('.add-submit').click()">确认添加</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="addKms" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">同步卡密</h4>
            </div>
            <div class="modal-body">
			
			<!--添加分类-->
			<form class="form-horizontal submit addKmsForm" role="form" action="?do=addKms" method="POST">
				<div class="form-group">
					<label for="name">请在此粘贴卡密 一行一个(推荐一次性添加不多于200，方便管理)</label>
					<textarea class="form-control" rows="10" name="content"></textarea>
				  </div>
				<p>注：本操作会同步至发卡君平台，若需要更详细的操作，请前往发卡君平台操作！</p>
				<div class="" style="display:none"><input type="submit" value="submit" class="addKms-submit"></div>
			</form>
					
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default remake" data-dismiss="modal">取消</button>
                <button type="button" class="btn btn-primary" onclick="$('.addKms-submit').click()">确认添加</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
	<script>
	$(function(){
		
		$.post("?do=sync",{},function(data){
			//$(".invoice").html(data);
		});
	
	});
	
	$(function(){
		$('.del').click(function(){
			if(confirm("是否删除此商品？删除后不可恢复！请谨慎操作！"))
			{
				return true;
			}
			return false;
		});
		$('.add-group').click(function(){
			$('#myModal').modal('show');
		});
		
		$('.addKms').click(function(){
			var action = $(this).attr("href");
			$('.addKmsForm').attr({'action':action});
			$('#addKms').modal('show');
			return false;
		});
	});
	
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