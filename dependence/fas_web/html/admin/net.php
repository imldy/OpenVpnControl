<?php
require('head.php');
require('nav.php');
?>

<script src="js/amcharts.js" type="text/javascript"></script>
<script src="js/serial.js" type="text/javascript"></script>
<script src="js/pie.js" type="text/javascript"></script>
<style>


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
.box-group{
	color:#222;
	font-size:16px;
	text-align:center;
	border-bottom:4px solid #328cc9;
	padding:10px 0px;
	margin:0px 10px;
}
</style>
<div id="radioset" style="margin-bottom:10px">
	<?php if($_GET["type"] == "bwh"){
		$title = "24小时宽带流出";
		$type = "bwh";
		?>
    <input type="radio" id="radio1" name="noteoff" value="1"/><label for="radio1">半小时监控</label>
    <input type="radio" id="radio2" name="noteoff" value="2" checked="checked"/><label for="radio2">24小时监控</label>     
	<?php }else{
		$title = "实时宽带流出";
		$type = "bw";
		?>
	<input type="radio" id="radio1" name="noteoff" value="1" checked="checked"/><label for="radio1">半小时监控</label>
    <input type="radio" id="radio2" name="noteoff" value="2"/><label for="radio2">24小时监控</label>   
	<?php }?>
</div>
<script>
$(function(){
	$('#radioset').buttonset();
	
	$('input[name="noteoff"]').click(function(){
		var xx = $('input[name="noteoff"]:checked').val();
		if(xx == 2){
			window.location.href="net.php?type=bwh"
		}else{
			window.location.href="net.php?type=bw"
		}
	});
});

</script>

<div class="row">
	<div class="col-xs-12 col-sm-12"> 
		
		
		<div class="box" style="margin-bottom:15px">
			<div id="line"> 加载中... </div>
		</div>
		

</div>

<script type="text/javascript">
	function setLineChart(type,title="实时宽带检测(Mbps/s)"){
		$.post("rateJson.php?act="+type,{},function(json){
			var chart = new AmCharts.AmSerialChart();
			chart.dataProvider = json;
			chart.categoryField = "name";
			chart.angle = 30;
			chart.depth3D = 0;
			//标题
			chart.addTitle(title, 15);  
			var graph = new AmCharts.AmGraph();
			chart.addGraph(graph);
			graph.valueField = "value";
			//背景颜色透明度
			graph.fillAlphas = 0.3;
			//类型
			graph.type = "smoothedLine";
			//圆角
			graph.bullet = "round";
			//线颜色
			graph.lineColor = "#328cc9";
			//提示信息
			graph.balloonText = "[[value]] Mbps/s";
			var categoryAxis = chart.categoryAxis;
			categoryAxis.autoGridCount = false;
			categoryAxis.gridCount = json.length;
			categoryAxis.gridPosition = "start";
			chart.write("line");
		},"JSON");

	}
	AmCharts.ready(function () {
		setLineChart("<?= $type?>","<?= $title?>");
    });	
	
	var fun = function(){
		setLineChart("<?= $type?>","<?= $title?>");
	}
	$(function(){
		fun();
		setInterval(fun,10000);
	});

</script>
 <?php
 include("footer.php");
 ?>