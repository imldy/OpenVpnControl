<?php
if($_GET['act'] == 'save'){
include('system.php');
	//执行数据保存
	$status1 = setSystemData("TCP_PATH",$_POST["tcp"]);
	$status2 = setSystemData("UDP_PATH",$_POST["udp"]);
	die(json_encode(array(
		"status"=>"success"
	)));
}elseif($_GET['act'] == 'data'){
	
include('system.php');

$tcp_file[0]["file"] = "openvpn_api/online_1194.txt";
$tcp_file[0]["telnet"] =  "7075";

$tcp_file[1]["file"] = "openvpn_api/online_1195.txt";
$tcp_file[1]["telnet"] =  "7076";

$tcp_file[2]["file"] = "openvpn_api/online_1196.txt";
$tcp_file[2]["telnet"] =  "7077";

$tcp_file[3]["file"] = "openvpn_api/online_1197.txt";
$tcp_file[3]["telnet"] =  "7078";


$udp_file[0]["file"] = "openvpn_api/user-status-udp.txt";
$udp_file[0]["telnet"] = "7079";

$status_file = $_GET["t"] == "udp" ? $udp_file:$tcp_file;



$html ='
<table class="table table-striped">
   <thead>
      <tr>
         <th>用户名</th>
         <th>上传</th>
	<th>下载</th>
	<th>剩余(实时)</th>
	<th>IP</th>
	<th>操作</th>
      </tr>
   <tbody>';
foreach($status_file as $vo)
{
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$rs = db("auth_fwq")->where(array("id"=>$id))->find();
		if(!$rs){
			echo "此服务器不存在";
		}else{
			$file = 'http://'.$rs['ipport'].'/'.$vo["file"];
		}
	}else{
		$file = '../'.$vo["file"];
		if(!is_file($file)){
			exit;
		}
	}
	
	$context = stream_context_create(array(
		'http' => array(
		'timeout' => 5 //超时时间，单位为秒
		) 
	));  
	if($str = file_get_contents($file,false, $context))
	{
		$num = (substr_count($str,date('Y'))-1)/2;
		$num = (int)$num;
		$nums += $num;
		$lines = explode("\n",$str);
		
		for($i=3;$i<$num+3;$i++)
		{
			$line=$lines[$i];
			$arr=explode(",",$line);
			$recv=round($arr[2]/1024)/1000;
			$sent=round($arr[3]/1024)/1000;
			//$row = $DB->get_row("select * from `openvpn` where `iuser`='".$arr[0]."' limit 1");
			$row = db(_openvpn_)->where(array("iuser"=>$arr[0]))->find();
			$sy = ($row['maxll']-$row['isent']-$row['irecv']-$arr[2]-$arr[3]);
			$value = round($sy/1024/1024,3);
			$pre = $sy < 1024*1024*100 ? '<span class="label label-warning">流量不足</span':'';
			$pre = $sy < 0 ? '<span class="label label-danger">流量超额</span':$pre;
			
			$username = $arr[0] == "UNDEF"?"正在登陆...(UNDEF)":$arr[0];
			
			$html .= "<tr class=\"line-id-{$arr[0]}\">";
			$html .= "<td>".$username."</td>";
			$html .= "<td>".$recv."MB</td>";
			$html .= "<td>".$sent."MB</td>";
			$html .= "<td>".round($value,3)."MB&nbsp;".$pre."</td>";
			$html .= "<td>".$arr[1]."</td>";
			$html .= '<td><a class="btn btn-xs btn-success" href="./user_list.php?a=qset&user='.$arr[0].'">查看用户</a>&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="if(!confirm(\'只对本机有效，是否继续\')){return false;}else{outline(\''.$arr[0].'\','.$vo["telnet"].')}">强制下线</button></td>';
			$html .= "</tr>";
		}
	}
}
$html .="
	</tbody>
</thead>
</table>";
die(json_encode(array('status'=>"success",'nums'=>$nums,"html"=>$html)));

}else{
$title='当前在线用户';
include('head.php');
include('nav.php');


?>

<div class="box">
<div class="col-xs-12 center-block" style="float: none;">
<button type="button" class="btn btn-success">当前在线&nbsp;<span class="oln">0</span>&nbsp;人</button>&nbsp;
<button type="button" class="btn btn-warning" onclick="window.location.href='online.php?<?php echo $_GET['id'] == "" ? "" : "id=".$_GET['id']; ?><?php echo $_GET['t'] == "udp" ? "&t=tcp" : "&t=udp" ?>'">切换至<?php echo $_GET["t"] == "udp" ? "TCP":"UDP" ?>模式</button>&nbsp;
十秒钟自动刷新一次数据
<div style="height:10px;"></div>

<button type="button" class="btn btn-primary btn-xs">节点</button>
<?php
if($_GET["id"] == ""){
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-info" ><a href="?'.$t_str.'" style="color:#fff">当前服务器</a></span>';
}else{
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<span ><a href="?'.$t_str.'" >当前服务器</a></span>';
}
//$rs=$DB->query("SELECT * FROM `auth_fwq`  order by id desc limit 20");
$rs = db("auth_fwq")->order("id DESC")->select();
foreach($rs as $res)
{
	$id_str = $res['id'] == "" ? "" : "id=".$res['id'];
	$t_str = $_GET['t'] == "" ? "" : "&t=".$_GET['t'];
	if($res['id'] == $_GET["id"]){
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-info" ><a href="?'.$id_str.$t_str.'" style="color:#fff">'.$res['name'].'</a></span>';
	}else{
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="?'.$id_str.$t_str.'">'.$res['name'].'</a></span>';
	}
}
?>
<div style="height:10px;"></div>
<div class="table-responsive">
<center>
<br>
<br>
<br>
<b>请稍等...加载中...</b>
</center>
</div>
	  
	 
    </div>
</div>

<script>
     function outline(id,port){
		$.post('fas_service.php',{
			  "cmd":"/root/res/sha "+id+" "+port  
		},function(data){
			if(data.status == "success"){
				alert("执行完毕");
				 location.reload();
			}else{
				alert(data.msg);
					}
		},"JSON");
		$('.line-id-'+id).slideUp();
  }
  
	var fun = function(){
			$.post('?act=data&<?php echo $_GET['id'] == "" ? "" : "id=".$_GET['id']; ?><?php echo $_GET['t'] == "" ? "" : "&t=".$_GET['t']; ?>',{
			},function(data){
				if(data.status == "success"){
					$('.table-responsive').html(data.html);
					$('.oln').html(data.nums);
				}else{
					$('.table-responsive').html(data.mes);
				}
			},"JSON");
	}
	$(function(){
		fun();
		setInterval(fun,10000);
	});
	</script>
<?php 
include("footer.php");
}?>