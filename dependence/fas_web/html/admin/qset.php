<div class=" center-block" style="float: none;">
<?php
$user = trim($_GET['user']);
if(!$user || !$row = db(_openvpn_)->where(array(_iuser_=>$user))->find()){ exit("账号不存在!");}
if($_POST['type']=="update"){
$pass = trim($_POST['pass']);
$maxll = trim($_POST['maxll'])*1024*1024;
$state = trim($_POST['state']);
$endtime = $row["endtime"]+((int)$_POST['enddate']*24*60*60);
	if(db(_openvpn_)->where(array(_iuser_=>$user))->update(array(
			_ipass_=>$pass,
			_maxll_=>$maxll,
			_i_=>$state,
			_endtime_=>$endtime
			))){
		tip_success("修改成功",'user_list.php?a=qset&user='.$user);
	}else{
		tip_failed('修改失败！','user_list.php?a=qset&user='.$user);
	}
}else{
?>

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
</style>


<div class="row">
<div class="col-xs-12 col-sm-12"> 
	<div class="box">
		
		 <form action="./user_list.php?a=qset&user=<?=$user?>" method="post" class="form-horizontal" role="form">
		 <input type="hidden" name="type" value="update" />
	
			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">密码</label>
				<div class="col-sm-10">
					<input class="form-control" rows="10" name="pass" value="<?=$row['pass']?>">
				</div>
			</div>
			
			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">账号状态</label>
				<div class="col-sm-10">
					 <select name="state" class="form-control">
						<option value="0">0_禁用</option>
						<option value="1" <?=$row['i']?"selected":''?>>1_开通</option>
					  </select>
				</div>
			</div>
			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">总流量</label>
				<div class="col-sm-10">
					<input type="text" name="maxll" value="<?=round($row['maxll']/1024/1024)?>" class="form-control">
				</div>
			</div>
			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">有效期</label>
				<div class="col-sm-10">
					<input type="text" value="<?=date("Y年m月d日 H点i分s秒",$row["endtime"])?>" class="form-control" disabled>
				</div>
			</div>

			<div class="form-group" >
				<label for="firstname" class="col-sm-2 control-label">延期(正数为添加 负数为减少 单位：天)</label>
				<div class="col-sm-10">
					<input type="text" name ="enddate" value="0" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="submit" name="submit" value="修改" class="btn btn-info btn-block"/>
				</div>
			</div>
		 </form>
	</div>
	
	<div class="box" style="margin-top:10px;">
		<div class="main">
			<div id="line">
			</div>
		</div>
	</div>
	
</div>


<div class="col-xs-12 col-sm-12"> 
	
</div>

</div>

        		<script type="text/javascript">
    
    var json = [
	<?php  
		$temp_date = date("Y-m-d 0:0:0",time());
		$now = strtotime($temp_date); 
		for($i=0;$i<=30;$i++){
			$t = $now-((30-$i)*24*60*60);
			$p = date("Y-m-d",$t);
			
			//$res = $DB->get_row("select * from `top` where `username`='".$user."' AND time='".$p."' limit 1");
			$res = db("top")->where(array("username"=>$user,"time"=>$p))->find();
			
			if($res){
				$value = $res['data'] / 1024 / 1024;
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
  
    //折线图
    AmCharts.ready(function () {
        var chart = new AmCharts.AmSerialChart();
        chart.dataProvider = json;
        chart.categoryField = "name";
        chart.angle = 30;
        chart.depth3D = 20;
        //标题
        chart.addTitle("30天流量趋势", 15);  
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
</div>
 <script src="./js/datepicker/bootstrap-datepicker.js"></script>
 <?php } ?>
