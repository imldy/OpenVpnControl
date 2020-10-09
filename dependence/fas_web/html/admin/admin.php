<?php
//本FAS系统由何以潇破解QQ1744744000
$file = "../../FAS.lock";

if(file_exists($file))
{
    require ("error.php");
	return;
}
else
{
 echo "";
}
?>
<?php
require('head.php');
require('nav.php');
function unsetLine($arr){
	foreach($arr as $v){
		if(strpos($v,"apache") === 0){
			
		}else{
			$line[] = $v;
		}
	}
	return $line;
}
//本FAS系统由何以潇破解QQ1744744000   盗版凌一继续
$nums = db(_openvpn_)->getnums();
$user_num = db(_openvpn_)->where(["i"=>"1"])->getnums();
$nums2 = db(_openvpn_)->where(["online"=>"1"])->getnums();
$nums3 = db("auth_fwq")->where()->getnums();
$key = file_get_contents("license.key");
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
			<p>注册用户 <?=$nums?> 人</p> 
			<p>正常用户 <?=$user_num?> 人</p> 
			</div>             
		</div>             
    </div>      
<div class="col-xs-12 col-md-3"> 
		<div class="i-box"> 
			<div class="i-icon" style="background:#43ba9c">
				<i class="icon-heart"></i>
			</div>
			<div class="i-right">
			<p>在线人数 <?=$nums2?> 人</p> 
			<p>活跃程度 <?= round($nums2/$nums,4)*100;?> %</p> 
			</div>             
		</div>             
    </div>      
<div class="col-xs-12 col-md-3"> 
		<div class="i-box"> 
			<div class="i-icon" style="background:#5CB85C">
				<i class="icon-bell-alt"></i>
			</div>
			<div class="i-right">
			<p><?=$nums3?></p> 
			<p>服务器</p> 
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
			<div id="line"> 加载中... </div>
			<div class="box-z"></div>
		</div>
		
		<div class="box" style="margin-bottom:15px">
			<div class="row"><div class="col-xs-12 col-sm-6"> 
				<h3>TCP端口监听</h3>
				<h6><b>*</b>您的系统目前以对如下TCP端口进行了监听</h6>
				<?php
						 exec(" netstat -nap|grep tcp|grep \"0.0.0.0:\"",$tcp);
						$tcp = unsetLine($tcp);
						preg_match_all("/\:([0-9]*)/",implode("\n",$tcp),$m);
						foreach($m[1] as $v){ 
							echo '<span class="label label-info">'.$v.'</span> ';
						}
						  ?>
				</div>
				<div class="col-xs-12 col-sm-6"> 
						 <h3>UDP端口监听</h3>
						  <h6><b>*</b>您的系统目前以对如下UDP端口进行了监听</h6>
						 <?php
							exec(" netstat -nap|grep udp|grep \"0.0.0.0:\"",$udp);
							$udp = unsetLine($udp);
							preg_match_all("/\:([0-9]*)/",implode("\n",$udp),$m);
							foreach($m[1] as $v){ 
								echo '<span class="label label-info">'.$v.'</span> ';
							}
						  ?>
				</div>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-sm-3"> 
		<div class="box" style="margin-bottom:15px;border:none;padding:0px;">
			<a href="net.php" class="btn btn-primary btn-block">
				<h2><span class="bwjk">Loading</span>&nbsp;Mbps/s</h2>
			网速实时监控(每分钟扫描一次)<br><br>
			</a>
		</div>	
		<div class="box" style="margin-bottom:15px;border:none;padding:0px;">
		 <?php
		exec("top -bn1 | grep Cpu",$cpuinfo);
		//99.2 id
		preg_match('/\s*([0-9\.]*)\s*id/is',$cpuinfo[0],$cpuinfo_free);
		$lyl = 100-(float)$cpuinfo_free[1];
		  ?>
		  <div href="net.php" class="btn btn-primary btn-block">
				<h2><span class=""><?=$lyl?></span>&nbsp;%</h2>
			CPU利用率<br><br>
			</div>
		</div>	
		<div class="box" style="margin-bottom:15px;border:none;padding:0px;">
		 <?php
		 exec(" ps aux|grep jk.sh",$jiankong);
		$jiankong = unsetLine($jiankong);
		 $run = false;
		 foreach($jiankong as $v){
			// $run '<div style="border-bottom:1px dashed #ccc;margin-bottom:10px;"><span class="label label-info">监控运行中</span>&nbsp;<b>'.$v."</b></div>";
			 $run = true;
		 }
		 if($run){
			 echo '<div class="btn btn-success btn-block">';
			 echo "[用户状态扫描] 运行正常";
			 echo '</div>';
		 }else{
			 echo '<div class="btn btn-danger btn-block">';
			 echo "[用户状态扫描] 运行异常";
			 echo '</div>';
		 }
		  ?>
		</div>	
		
		<div class="box" style="margin-bottom:15px;border:none;padding:0px;">
		 <?php
		exec(" ps aux|grep FasAUTH.bin",$jiankong2);
		$jiankong2 = unsetLine($jiankong2);
		$run = false;
		foreach($jiankong2 as $v){
			//echo '<div style="border-bottom:1px dashed #ccc;margin-bottom:10px;"><span class="label label-info">监控运行中</span>&nbsp;<b>'.$v."</b></div>";
			 $run = true;
		 }
		 //本FAS系统由何以潇破解QQ1744744000   盗版凌一继续
		 if($run){
			 echo '<div class="btn btn-primary btn-block">';
			 echo "[用户流量监控] 运行正常";
			 echo '</div>';
		 }else{
			 echo '<a class="btn btn-danger btn-block" href="http://wpa.qq.com/msgrd?v=3&uin=1744744000&site=qq&menu=yes" target="_blank">';
			 echo "[用户流量监控] 运行异常 点击联系何以潇";
			 echo '</a>';
		 }
		  ?>

		  </div>
	   <div class="box" style="margin-bottom:15px;border:none;padding:0px;background:none;">
		  <div class="row">
		 <?php
		 function array_space_del($arr){
			 foreach($arr as $key=>$vo){
				 if(trim($vo) != ""){
					 $b[] = $vo;
				 }
			 }
			 return $b;
		 }
		 exec("ifconfig",$net);
		 foreach($net as $line){
			 if(trim($line)==""){
				$nets[] = $netinfo;
				$netinfo = array();
			 }else{
				$netinfo[] = $line;
			 }
		 }
		foreach($nets as $info){
			$t = explode(":",$info[0]);
			$netname = $t[0];
			
			foreach($info as $v){
				$t2 = explode(" ",$v);
				$t2 = array_space_del($t2);
				//var_dump($t2);
				switch($t2[0]){
					case $netname.":":
						$net_mtu = $t2[3];
					break;
					
					case "inet":
						$net_ip = $t2[1];
					break;
					
					case "RX":
						if($t2[1] == "packets"){
							$net_recv = $t2[4];
						}
					break;
					
					case "TX":
						if($t2[1] == "packets"){
							$net_sent = $t2[4];
						}
					break;
				}
			}
			echo '<div class="col-xs-12 col-sm-6" style="margin-bottom:10px;padding-bottom:5px;"><div class="btn btn-info btn-block"><span class="label label-info">';
			echo $netname;
			echo "</span> (MTU:";
			//echo $net_ip;
			echo $net_mtu.")<div style='margin-top:8px'>下行流量：";
			//echo $net_recv;
			//echo " bytes";
			$arr1 = printmb($net_recv);
			echo round($arr1['n'],1).$arr1['p']."<br>";
			echo "上行流量：";
			//echo $net_sent;
			$arr2 = printmb($net_sent);
			//echo " bytes";
			echo round($arr2['n'],1).$arr2['p'];
			echo "</div></div></div>";

		}
		  ?>

		  </div>
		  </div>
		  
		
	</div>
	</div>

      <script type="text/javascript">
   
	AmCharts.ready(function () {
		$.post("rateJson.php?",{},function(json){
			var chart = new AmCharts.AmSerialChart();
			chart.dataProvider = json;
			chart.categoryField = "name";
			chart.angle = 30;
			chart.depth3D = 20;
			//标题
			chart.addTitle("15天流量趋势(单位GB)", 15);  
			var graph = new AmCharts.AmGraph();
			chart.addGraph(graph);
			graph.valueField = "value";
			//背景颜色透明度
			graph.fillAlphas = 0.3;
			//类型
			graph.type = "line";
			//圆角
			graph.bullet = "round";
			//线颜色
			graph.lineColor = "#328cc9";
			//提示信息
			graph.balloonText = "[[value]] G";
			var categoryAxis = chart.categoryAxis;
			categoryAxis.autoGridCount = false;
			categoryAxis.gridCount = json.length;
			categoryAxis.gridPosition = "start";
			chart.write("line");
		},"JSON");
        
    });
    $(function(){
		$.post("rateJson.php?act=bwi",{},function(data){
				$(".bwjk").html(data);
			});
		setTimeout(function(){
			$.post("rateJson.php?act=bwi",{},function(data){
				$(".bwjk").html(data);
			});
		}, 10000);
		
	});
</script>
 <?php
 include("footer.php");
 ?>