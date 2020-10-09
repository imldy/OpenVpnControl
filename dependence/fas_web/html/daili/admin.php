<?php
require('head.php');
require('nav.php');
//基本信息加载
$nums = db(_openvpn_)->where(["daili"=>$admin["id"]])->getnums();
$nums2 = db(_openvpn_)->where(["i"=>"1","daili"=>$admin["id"]])->getnums();
$nums3 = db(_openvpn_)->where("endtime<:endtime AND endtime>:start AND i = 1 AND daili=:daili",["endtime"=>time()+24*60*60*3,"start"=>time(),"daili"=>$admin["id"]])->getnums();
?>

<div class="row">
	<div class="col-xs-12 col-sm-8"> 
		<div class="box" style="margin-bottom:15px">
			  <div class="row">
                <div class="col-sm-12 col-md-3"> 
                <strong><?php echo $nums?></strong>
                <small class="text-muted text-uc">注册用户</small> 
              </div>             
               <div class="col-sm-12 col-md-3"> 
                <strong><?php echo $nums2?></strong> 
                <small class="text-muted text-uc">正常用户</small> 
              </div>
               <div class="col-sm-12 col-md-3"> 
                <strong><?php echo $nums3?></strong>
                <small class="text-muted text-uc">三天内过期</small> 
              </div>
             <div class="col-sm-12 col-md-3"> 
                <strong><?php echo date("H:i",time())?></strong>
                <small class="text-muted text-uc">系统时间</small> 
              </div>
              </div>
		</div>
		<div class="box" style="margin-bottom:15px">
			<h2>余额：<?= $admin["balance"]?>元&nbsp;&nbsp;&nbsp;有效期至：<?= date("Y年m月d日",$admin["endtime"])?></h2>
			<?php 
			$m = new Map();
			if($m->type("cfg_pay")->getValue("pay_on") == 'pay'){;
			?>
			<a href="order.php" class="btn btn-success">余额充值</a>&nbsp;充值到我的余额
			<?php } ?>
		</div>
		<div class="box" style="margin-bottom:15px">
			<h2>等级：<?= $admin_ext["name"]?>&nbsp;&nbsp;&nbsp;折扣：<?= $admin_ext["per"]?>%</h2>
		</div>
		

	</div>

	<div class="col-xs-12 col-sm-4"> 

		  <div class="box" style="margin-bottom:15px;">
		  <h3>总站公告</h3>
		
		 <?php
		  echo  file_get_contents(R."/daili.txt");
		  ?>

		  </div>
		
	</div>
</div>

 <?php
 include("footer.php");
 ?>