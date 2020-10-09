<?php
$mod='blank';
$title = "叮咚云控系统";
include('head.php');
include('nav.php');
if($_GET["a"] == "qset"){
	include("qset.php");
	}else{

?>
<div class="col-xs-12 col-sm-10 col-lg-8 center-block" style="float: none;width: 100%">
<div class="box">
<?php

echo '<form action="user_list.php" method="get" class="form-inline">
  <div class="form-group">
    <input type="text" class="form-control" name="kw" placeholder="账号">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
 <!-- <a href="addqq.php" class="btn btn-success">添加账号</a>
  <a href="online.php" class="btn btn-success">在线用户</a>-->&nbsp;';
if(!empty($_GET['kw'])) {
	$numrows = db(_openvpn_)->where(array(_iuser_=>$_GET["kw"]))->getnums();
	$where = array(_iuser_=>$_GET["kw"],"daili"=>$admin["id"]);
	$con='<a href="#" class="btn btn-success">平台共有 <b>'.$numrows.'</b> 个账号</a>';
}else{
	//$numrows=$DB->count("SELECT count(*) from `openvpn` WHERE 1");
	$numrows = db(_openvpn_)->where(["daili"=>$admin["id"]])->getnums();
	$where= array("daili"=>$admin["id"]);
	$con='<a href="#" class="btn btn-success">平台共有 <b>'.$numrows.'</b> 个账号</a>';
}
echo $con;
echo '</form>';

?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th width="50">序号</th><th>账号</th><th>添加时间</th><th>到期时间</th><th>剩余流量</th><th>总流量</th><th>状态</th></tr></thead>
          <tbody>
<?php
$pagesize=30;
$pages=intval($numrows/$pagesize);
if ($numrows%$pagesize)
{
 $pages++;
 }
if (isset($_GET['page'])){
$page=intval($_GET['page']);
}
else{
$page=1;
}
$offset=$pagesize*($page - 1);
//$zt = array('0'=>'<font color=green>正常</font>','1'=>'<font color=red>密码错误</font>','2'=>'<font color=red>冻结</font>','3'=>'<font color=red>开启设备锁</font>');
$rs=db(_openvpn_)->where($where)->limit($offset,$pagesize)->order("id DESC")->select();
$i = 1;
foreach($rs as $res)
{ 
if(date("Y-m-d",$res['starttime']) == date("Y-m-d",time())){
	$p = '&nbsp;<span class="label label-success">今日新增</span>';
}elseif(date("Y-m-d",$res['starttime']) == date("Y-m-d",(time()-24*60*60))){
	$p = '&nbsp;<span class="label label-warning">昨日新增</span>';
}else{
	$p ="";
}

if($res["vip"] == 1){
	$vip = '&nbsp;<span class="label label-success">VIP</span>';
}elseif($res["vip"] == 2){
	$vip = '&nbsp;<span class="label label-warning">VIP2</span>';
}else{
	$vip ="";
}
?>
<tr class="line-id-<?=$res['iuser']?>">
<td><?=$i?></td>
<td><?=$vip?><?=$res['iuser']?><?=$p?></td>
<td><?=date("Y-m-d",$res['starttime'])?></td>
<td><?=date("Y-m-d",$res['endtime'])?></td>
<td><span class="shengyu"><?=round(($res['maxll']-$res['isent']-$res['irecv'])/1024/1024)?></span>MB</td>
<td><span class="maxll"><?=round(($res['maxll'])/1024/1024)?></span>MB</td>
<td><?=($res['i']?'开通':'禁用')?></td>
</tr>

<?php 
	$i++;
}
?>
          </tbody>
        </table>
   
<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="user_list.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="user_list.php?page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="user_list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="user_list.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="user_list.php?page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="user_list.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
}
?>
    </div>
    </div>
<?php
include("footer.php");
?>
