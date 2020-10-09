<?php
$mod='blank';
$title = "叮咚云控系统";
include('head.php');
include('nav.php');
$key = file_get_contents("/root/res/app_key.txt");
?>
<div class="" >
<div class="box">
<?php
if($_GET["act"]=='del'){
	if(db("app_daili")->where(array("id"=>$_GET['id']))->delete()){
		tip_success("操作成功！",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
	}
}

else
{

echo '<form action="?" method="get" class="form-inline">
  <div class="form-group">
    <input type="text" class="form-control" name="kw" placeholder="账号">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>&nbsp;';
if(!empty($_GET['kw'])) {
	$numrows = db("app_daili")->where(array("name"=>$_GET["kw"]))->getnums();
	$where = array("name"=>$_GET["kw"]);
	$con='<a href="#" class="btn btn-success">平台共有 <b>'.$numrows.'</b> 个账号</a>';
}else{
	$numrows = db("app_daili")->where()->getnums();
	$where= '';
	$con='<a href="#" class="btn btn-success">平台共有 <b>'.$numrows.'</b> 个账号</a>';
}
echo $con;
echo '</form>';

?>
      <div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th width="50">序号</th><th>账号</th><th>添加时间</th><th>到期时间</th><th>等级</th><th>余额</th><th>APP_KEY</th><th>状态</th><th>操作</th></tr></thead>
          <tbody>
<?php
$rs=db("app_daili")->where($where)->fpage($_GET["page"],30)->order("id DESC")->select();
$i = 1;
foreach($rs as $res)
{ 
	$deng=db("app_daili_type")->where(["id"=>$res["type"]])->find();
?>
	<tr class="line-id-<?=$res['id']?>">
	<td><?=$i?></td>
	<td><?=$vip?><?=$res['name']?><?=$p?></td>
	<td><?=date("Y-m-d",$res['time'])?></td>
	<td><?=date("Y-m-d",$res['endtime'])?></td>
	<td><?=$deng["name"]?> 折扣：<?=$deng["per"]?>%</td>
	<td><span class="maxll"><?=$res['balance']?>元</td>
	<td><?php echo trim($key)."_".$res["id"];?></td>
	<td><?=($res['lock']?'开通':'禁用')?></td>
	<td><a class="btn btn-xs btn-success" href="dl_add.php?act=mod&id=<?=$res['id']?>">配置</a>&nbsp;<a href="?act=del&id=<?=$res['id']?>" class="btn btn-xs btn-danger" onclick="if(!confirm('你确实要删除此记录吗？')){return false;}else{return true}">删除</a></td>
	</tr>

<?php 
	$i++;
}
?>
          </tbody>
        </table>
    </div>
    </div>
<?php echo create_page_html($numrows,$_GET["page"]);?>
<?php } include("footer.php");?>
