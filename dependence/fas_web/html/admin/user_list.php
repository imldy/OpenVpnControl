<?php
$mod='blank';
$title = "叮咚云控系统";
include('head.php');
include('nav.php');
if($_GET["a"] == "qset"){
	include("qset.php");
	}else{

?>
<div class="box">
<?php

$my=isset($_GET['my'])?$_GET['my']:null;

if($my=='del'){
echo '<div class="panel panel-default">
<div class="panel-heading w h"><h3 class="panel-title">删除账号</h3></div>
<div class="panel-body box">';
$user=$_GET['user'];
$sql=db(_openvpn_)->where(array(_iuser_=>$user))->delete();
if($sql){
	db("top")->where(["username"=>$user])->delete();
	echo '删除成功！';
	}
else{
	echo '删除失败！';
}
echo '<hr/><a href="./user_list.php">>>返回账号列表</a></div></div>';
}

else
{

echo '<form action="user_list.php" method="get" class="form-inline">
  <div class="form-group">
    <input type="text" class="form-control" name="kw" placeholder="支持模糊搜索" value="'.$_GET["kw"].'">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>&nbsp;';
if(!empty($_GET['kw'])) {
	$numrows = db(_openvpn_)->where(_iuser_." LIKE :kw",[":kw"=>"%".$_GET["kw"]."%"])->getnums();
	$where = _iuser_." LIKE :kw";
	$data = [":kw"=>"%".$_GET["kw"]."%"];
	$con='<a href="#" class="btn btn-default">平台共有 <b>'.$numrows.'</b> 个账号</a>';
}else{
	//$numrows=$DB->count("SELECT count(*) from `openvpn` WHERE 1");
	$numrows = db(_openvpn_)->where()->getnums();
	$where= '';
	$con='<a href="#" class="btn btn-default">平台共有 <b>'.$numrows.'</b> 个账号</a>';
	
}
echo $con;
echo '&nbsp;<button type="button" class="btn btn-default" onclick="javascript:var n = prompt(\'统一新增流量，减少请输入负数（单位：G）\');if(!n){return false;}else{addLlAll(n)}">统一新增流量</button>';
echo '&nbsp;<button type="button" class="btn btn-default" onclick="javascript:var n = prompt(\'统一新增天数，减少请输入负数（单位：天）\');if(!n){return false;}else{addTimeAll(n)}">统一新增天数</button>';

echo '&nbsp;<button type="button" class="btn btn-default" onclick="if(!confirm(\'清理全部禁用用户？执行后不可恢复！\')){return false;}else{delAllJ()}">清理全部禁用用户</button>';
echo '</form>';
?>

      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th width="50">序号</th><th>账号</th><th>添加时间</th><th>到期时间</th><th>剩余流量</th><th>总流量</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
$rs = db(_openvpn_)->where($where,$data)->fpage($_GET["page"],30)->order("id DESC")->select();
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
<td><a class="btn btn-default" href="./user_list.php?a=qset&user=<?=$res['iuser']?>">配置</a>&nbsp;<a href="javascript:void(0)" class="btn btn-primary" onclick="if(!confirm('你确实要删除此记录吗？')){return false;}else{delLine('<?=$res['iuser']?>')}">删除</a>&nbsp;<a href="javascript:void(0)" class="btn btn-primary"   onclick="javascript:var n = prompt('请输入您要重置的流量（单位：G)');if(!n){return false;}else{addLl('<?=$res['id']?>',n)}">新增</a></td>
</tr>

<?php 
	$i++;
}
?>
          </tbody>
        </table>
    </div>
<?php
}
?>
   
 </div>
<script>
function addLlAll(n){
		var url = './option.php?my=addllAll';
		$.post(url,{
			"n":n
		  },function(){
			
		});
		//var m = $('.line-id-'+id+" .maxll");
		//var ne = n*1024;
		//m.html(ne);
		location.reload();
}

function addTimeAll(n){
		var url = './option.php?my=addtimeAll';
		$.post(url,{
			"n":n
		  },function(){
			
		});
	
		location.reload();
}

function addLl(id,n){
		var url = './option.php?my=addll';
		$.post(url,{
			"n":n,
			"user":id
		  },function(){
			location.reload();
		});
}
function delAllJ(){
		var url = './option.php?my=deljy';
		$.post(url,{
		  },function(){
			location.reload();
		});
}
</script>
<?php
echo create_page_html($numrows,$_GET["page"]);
	} 
include("footer.php");
?>
