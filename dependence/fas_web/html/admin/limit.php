<?php
$title = "叮咚云控系统";
include('head.php');
?>
<script src="js/amcharts.js" type="text/javascript"></script>
<script src="js/serial.js" type="text/javascript"></script>
<script src="js/pie.js" type="text/javascript"></script>
<style>
.main
{
	
	height: 400px;
	
	margin:10px;
	margin-top: 20px;
	overflow: hidden;
}

#line
{
	width: 100%;
	height: 400px;
	
}
#pie
{
	width: 100%;
	height: 400px;
	
}
</style>
<?php

include('nav.php');

//基本信息加载
$nums = db(_openvpn_)->getnums();
$nums2 = db(_openvpn_)->where(array("i"=>"1"))->getnums();
$nums3 = db(_openvpn_)->where(array("endtime"=>time()+24*60*60*3,"i"=>"1"),array("endtime"=>"<"))->getnums();

//**版本信息检测
$v = explode("|",file_get_contents(R."/version.txt"));
foreach($v as $t){
	$tmp = explode(":",$t);
	$ver[trim($tmp[0])] = $tmp[1];
}
	?>

			
<div class="col-xs-12 col-sm-12"> 
	<div class="panel panel-default">
			<div class="panel-body">
              <div class="row">
                <div class="col-sm-6 col-md-3"> 
                <strong><?php echo $nums?></strong>
                <small class="text-muted text-uc">注册用户</small> 
              </div>
             
               <div class="col-sm-6 col-md-3"> 
                <strong><?php echo $nums2?></strong> 
                <small class="text-muted text-uc">正常用户</small> 
              </div>
               <div class="col-sm-6 col-md-3"> 
                <strong><?php echo $nums3?></strong>
                <small class="text-muted text-uc">三天内过期</small> 
              </div>
             <div class="col-sm-6 col-md-3"> 
                <strong><?php echo date("H:i",time())?></strong>
                <small class="text-muted text-uc">系统时间</small> 
              </div>
              
              </div>
    
			
			</div>
	</div>
</div>


<div class="col-xs-12 col-sm-6"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">用户概览</h3></div>
			<div class="panel-body">
				<div class="main">
				<?php
				 exec('ifconfig',$c);
				 	$netname = "";
					/*foreach($c as $line){
						$t = explode(":",$line);
						$t2 = explode("=",$t[1]);
						$t3 = explode(" ",$line);
						if($t2[0] == "flags"){
							$net[$netname]["name"] = $t[0];
						}
						if($netname != ){}
					}*/
				?>
				</div>
			</div>
	</div>
</div>

<div class="col-xs-12 col-sm-6"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">负载均衡</h3></div>
			<div class="panel-body">
				<div class="main">
					<?php 
						$db = db("auth_fwq");
						$fwqn = $db->getnums();
					?>
					<h2>服务器总数：<a href="fwq_list.php"> <?php echo $fwqn;?> </a>台</h2>
				</div>
			</div>
	</div>
</div>
<div class="col-xs-12 col-sm-6"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">系统状态</h3></div>
			<div class="panel-body">
				<div class="main">
					<p>云端系统版本：<?php echo $ver["version"]."-".$ver["name"]?></p>
					<p><?php
					$str = file_get_contents('http://www.dingd.cn/app/varsiontxt',false,stream_context_create(array('http' => array('method' => "GET", 'timeout' => 5))));
					
					$v2 = explode("|",$str);
					foreach($v2 as $t){
						$tmp = explode(":",$t);
						$ver2[$tmp[0]] = $tmp[1];
					}
					$new_version = trim($str) == "" ? "查询失败" :  $ver2["version"]."-".$ver2["name"];
					?>
					官方最新版本：<?php echo $new_version; echo $ver["n"] < $ver2["n"] ? "[<a href=\"{$ver2['url']}\" target=\"_blank\">请更新</a>]" : "[无需更新]" ?>
					</p>
					<p>PHP版本：<?php echo PHP_VERSION?></p>
					<hr>
					开发团队：筑梦工作室<br>
					官方网站：<a href="http://www.dingd.cn/" target="_blank">www.dingd.cn</a><br>
					开发人员名单：
					<br>
					冬瓜
				</div>
			</div>
	</div>
</div>

<div class="col-xs-12 col-sm-6"> 
	<div class="panel panel-default">
		<div class="panel-heading"><h3 class="panel-title">流量统计</h3></div>
			<div class="panel-body">
				<div class="main"><div id="line"></div>
				</div>
			</div>
	</div>
</div>
	
		
   <script type="text/javascript">
    
    var json = [
	<?php  
		$temp_date = date("Y-m-d 0:0:0",time());
		$now = strtotime($temp_date); 
		for($i=0;$i<=15;$i++){
			$t = $now-((15-$i)*24*60*60);
			$p = date("Y-m-d",$t);
			
			$rs=db("top")->where(array("time"=>$p))->select();
			
			if($rs){
				$value = 0;
				foreach($rs as $res){
					
					$value += $res['data'] / 1024 / 1024 / 1024;
				}
				
				$data[] = '{ "name": "'.date("d",$t).'日", "value": "'.round($value,3).'" }';
			}else{
				$data[] = '{ "name": "'.date("d",$t).'日", "value": "0" }';
			}
			
		}
		echo implode(",",$data);
	?>
  
  
  ];
  var data = [
		{"name":"上传流量(MB)","value":"<?php echo(round($row['isent']/1024/1024,3));?>"},
		{"name":"下载流量(MB)","value":"<?php echo(round($row['irecv']/1024/1024,3));?>"},
		{"name":"剩余流量(MB)","value":"<?php echo(round(($row['maxll']-$row['isent']-$row['irecv'])/1024/1024,3));?>"}
  ];
  $(document).ready(function (e) {
        //GetSerialChart();
        MakeChart(data);
    });
	AmCharts.ready(function () {
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
        graph.lineColor = "#8e3e1f";
        //提示信息
        graph.balloonText = "[[name]]: [[value]]";
        var categoryAxis = chart.categoryAxis;
        categoryAxis.autoGridCount = false;
        categoryAxis.gridCount = json.length;
        categoryAxis.gridPosition = "start";
        chart.write("line");
    });
    //饼图
    //根据json数据生成饼状图，并将饼状图显示到div中
    function MakeChart(value) {
        chartData = eval(value);
        //饼状图
        chart = new AmCharts.AmPieChart();
        chart.dataProvider = chartData;
        //标题数据
        chart.titleField = "name";
        //值数据
        chart.valueField = "value";
        //边框线颜色
        chart.outlineColor = "#fff";
        //边框线的透明度
        chart.outlineAlpha = .8;
        //边框线的狂宽度
        chart.outlineThickness = 1;
        chart.depth3D = 20;
        chart.angle = 30;
        chart.write("pie");
    }
</script>
	<?php
	
include('footer.php');
?>
