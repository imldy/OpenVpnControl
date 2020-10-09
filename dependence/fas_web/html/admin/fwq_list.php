<?php
$title='服务器列表';
include 'head.php';
include 'nav.php';
$my=isset($_GET['act'])?$_GET['act']:null;

if($my=='del'){
	$db = db("auth_fwq");
	$id=$_GET['id'];
	if($db->where(["id"=>$id])->delete()){
		tip_success("删除成功",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed("删除失败",$_SERVER['HTTP_REFERER']);
	}
}elseif($my=='bmd'){
	if($_GET["do"] == "on"){
		systemi('iptables -D INPUT -p tcp -m tcp --dport 3306 -j ACCEPT');
		$rs=db("auth_fwq")->order("id DESC")->select();
		$i=0;
		foreach($rs as $vo){
			$ip = trim((explode(":",$vo["ipport"]))[0]);
			$cmd = 'iptables -A INPUT -s '.$ip.' -p tcp -m tcp --dport 3306 -j ACCEPT';
			systemi($cmd);
			$i++;
		}
		systemi("service iptables save");
		tip_success("您已成功开启数据库防火墙 并自动应用".$i."条规则 FAS全程为您护航",$_SERVER['HTTP_REFERER']);
	}else{
		$rs=db("auth_fwq")->order("id DESC")->select();
		foreach($rs as $vo){
			$ip = trim((explode($vo["ipport"],":"))[0]);
			$cmd = 'iptables -D INPUT -s '.$ip.' -p tcp -m tcp --dport 3306 -j ACCEPT';
			systemi($cmd);
		}
		systemi('iptables -A INPUT -p tcp -m tcp --dport 3306 -j ACCEPT');
		systemi("service iptables save");
		tip_success("您已成功关闭数据库防火墙 已失去外网保护",$_SERVER['HTTP_REFERER']);
	}
}else{
$cmd = 'cat /etc/sysconfig/iptables|grep "\-A INPUT -p tcp -m tcp \-\-dport 3306 \-j ACCEPT"';
$res = systemi($cmd);
$is_safe = false;
if(trim($res["msg"])==""){
	$is_safe = true;
}
?>
<div class="box">
<form action="fwqlist.php" method="get" class="form-inline">
  <div class="form-group">
    <label>搜索</label>
    <input type="text" class="form-control" name="kw" placeholder="服务器名称">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
  <a href="fwq_add.php" class="btn btn-info">添加服务器</a>
 &nbsp;
 &nbsp;
 &nbsp;
数据库白名单模式：
  <div class="btn-group">
  <?php if($is_safe){?>
    <a type="button" href="?act=bmd&do=on" class="btn btn-success">开启</a>
    <a type="button" href="?act=bmd&do=off" class="btn btn-default">关闭</a>
  <?php }else{ ?>
	<a type="button" href="?act=bmd&do=on" class="btn btn-default">开启</a>
    <a type="button" href="?act=bmd&do=off" class="btn btn-success">关闭</a>
  <?php } ?>
 </div>
 &nbsp;
 &nbsp;
 &nbsp;
 <a type="button" href="http://www.dingd.cn/doc/index.php?doc=fas#bmd" class="btn btn-default" target="_blank"><i class=" icon-book"></i>&nbsp;&nbsp;什么是数据库白名单？应该如果操作？</a>
</form>

<?php
if(!empty($_GET['kw'])) {
	$where = array("name"=>$_GET['kw']);
	$numrows = db("auth_fwq")->where(array("name"=>$_GET['kw']))->getnums();
	$con='包含 '.$_GET['kw'].' 的共有 <b>'.$numrows.'</b> 个服务器';
}else{
	$numrows = db("auth_fwq")->getnums();
	$where = [];
	$con='平台共有 <b>'.$numrows.'</b> 个服务器';
}

echo $con;


?><script>
var tz = 0;
function getOnLine(url,file){
	
	tz++;
	var jtz = tz;
	document.write("<p class=\"tz_"+jtz+"\">获取中...</p>");
	$(function(){
		$.post("lib/onlinetz.php",{
			"domain":url,
			"file":file
		},function(data){
			$(".tz_"+jtz).html(data);
		});
	});
	
}
</script>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>服务器名称</th><th>地址</th>
		  <th>TCP1在线</th>
		  <th>TCP2在线</th>
		  <th>TCP3在线</th>
		  <th>TCP4在线</th>
		  <th>UDP在线</th>
		  <th>操作</th></tr></thead>
          <tbody>
<?php

$rs=db("auth_fwq")->where($where)->order("id DESC")->fpage($_GET["page"],30)->select();

foreach($rs as $res)
{
	
?>

<tr>
<td><?=$res['name']?></td>
<td><?=$res['ipport']?></td>
<td><script>getOnLine('<?= $res["ipport"]?>','online_1194')</script></td>
<td><script>getOnLine('<?= $res["ipport"]?>','online_1195')</script></td>
<td><script>getOnLine('<?= $res["ipport"]?>','online_1196')</script></td>
<td><script>getOnLine('<?= $res["ipport"]?>','online_1197')</script></td>
<td><script>getOnLine('<?= $res["ipport"]?>','user-status-udp')</script></td>
<td>
<a href="./fwq_list.php?act=del&id=<?=$res['id']?>" class="btn btn-xs btn-danger" onclick="if(!confirm('你确实要删除此记录吗？')){return false;}">删除</a>
</td>
</tr>

<?php 
}
?>
          </tbody>
        </table>
      </div>

</div>

<?php
	echo create_page_html($numrows,$_GET["page"],30);
}
	include("footer.php");
?>
