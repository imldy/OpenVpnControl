<?php
require('head.php');
require('nav.php');
$_SESSION["token"] = "active";
$_SESSION["order"] = date("YmdHis",time()).rand(10000,99999);
?>

<div class="row">
	<div class="col-xs-12 col-sm-12"> 
		<div class="box" style="margin-bottom:15px">
			<h3><i class="icon-credit-card"></i>&nbsp;当前余额：<?= $admin["balance"]?>元</h3>
			<hr>
			  <div class="form-group form-inline">
				<label for="name">金额：</label>
				<input type="text" class="form-control" id="payVal" placeholder="请输入充值的金额">&nbsp;元（至少1元，只能输入整数，不能输入小数）
			  </div> 
			  <div class="form-group form-inline">
				<label for="name">支付方式：</label>
				<div class="btn-group" data-toggle="buttons">
					<label class="btn btn-default">
						<input type="radio" name="pay_type" id="pay_type_1" value="alipay">支付宝支付
					</label>
					<label class="btn btn-default">
						<input type="radio" name="pay_type" id="pay_type_2" value="wxchat" target="_blank">微信扫码
					</label>
				</div>
			  </div>
			<a class="btn btn-success pay"><i class="icon-ok"></i>&nbsp;确认充值</a>
			<hr><table class="table table-striped">
  <caption>充值记录</caption>			
  <thead>
    <tr>
      <th>订单号</th>
      <th>金额</th>
      <th>支付方式</th>
      <th>状态</th>
      <th>创建时间</th>
    </tr>
  </thead>
  <tbody>
	<?php
	$db = db("app_order");
	$numrows =$db->where(['uid'=>DID])->getnums();
	$order = $db->where(['uid'=>DID])->fpage($_GET['page'],10)->order('id DESC')->select();
	foreach($order as $vo){
	?>
    <tr>
      <td><?= $vo['order']?></td>
      <td><?= $vo['pay']?>元</td>
      <td><?= $vo['type']?></td>
      <td><?= $vo['status'] == 1 ? "已支付" : "未支付";?></td>
      <td><?= date("Y/m/d H:i:s",$vo['time'])?></td>
    </tr>
  	<?php } ?>
		</tbody>
		</table>
		<?php
		echo create_page_html($numrows,$_GET["page"],10,null);
		?>
	</div>
	</div>
</div>
<div style="display:none">
<a href="do.php" target="_blank" id="newpage">newpage</a>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					&times;
				</button>
				<h4 class="modal-title" id="myModalLabel">
					确认订单
				</h4>
			</div>
			<div class="modal-body">
				请在新页面中完成支付(支付成功后可能延迟2-3秒到帐)
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					取消支付
				</button>
				<button type="button" class="btn btn-info yes-to-pay">
					支付完成
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal -->
</div><!-- /.modal -->
<script>

$(function(){
	$(".pay").click(function(){
		var pay_val = $("#payVal").val();
		var type_val = $("[name='pay_type']:checked").val();
		if(!type_val){
			alert("请选择支付方式");
			return;
		};
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "do.php?do=create_order",
			async: false,//同步请求
			data: {
				pay:pay_val,
				type:type_val
			},
			success: function(data) {
				 if(data.ret == '10000')
				{ 
					 window.open(data.url);
					 $('#myModal').modal('show');
				}else{
					 alert(data.msg);
				}
			},
			error: function(data) {
				alert("正在加载请稍后！");
			}
		});
		//$("#newpage").attr({'href':data.url});
		//$('#myModal').modal('show');
		//$('#newpage')[0].click();		
       
    });
	$(".yes-to-pay").click(function(){
        window.location.reload();
    });  
});
</script>
 <?php
 include("footer.php");
 ?>