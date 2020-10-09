<?php
$title='服务器列表';
include 'head.php';
include 'nav.php';
$my=isset($_GET['my'])?$_GET['my']:null;
$m = new Map();
if($my=='noteoff'){
	$m->type("cfg_app")->update("noteoff",$_POST["noteoff"]);
}elseif($my=='default'){
	db("app_note")->update(["default"=>"0"]);
	db("app_note")->where(["id"=>$_GET["id"]])->update(["default"=>"1"]);
	tip_success("成功设置为默认啦",$_SERVER['HTTP_REFERER']);
}elseif($my=='del'){
	$db = db("app_note");
	$id=$_GET['id'];
	if($db->where(["id"=>$id])->delete()){
		tip_success("删除成功",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed("删除失败",$_SERVER['HTTP_REFERER']);
	}
}elseif($my=='order'){
	$order = $_POST["order"];
	$db = db("app_note");
	$i=0;
	foreach($order as $id => $nums)
	{
		if($db->where(["id"=>$id])->update(["order"=>$nums]))
		{
			$i++;
		}
	}
	tip_success("成功修改 ".$i." 条记录",$_SERVER['HTTP_REFERER']);
}else{
	$noteoff = $m->type("cfg_app")->getValue("noteoff",0);
?>
<div class="row">
<div class="col-xs-12 col-sm-8">
<div class="box">
<form>
<div id="radioset" style="margin-bottom:10px">
<?php if($noteoff == 0){?>
    <input type="radio" id="radio1" name="noteoff" value="1"/><label for="radio1">开启</label>
    <input type="radio" id="radio2" name="noteoff" checked="checked" value="0"/><label for="radio2">关闭</label>     
<?php }else{ ?>	
	<input type="radio" id="radio1" name="noteoff" value="1" checked="checked"/><label for="radio1">开启</label>
    <input type="radio" id="radio2" name="noteoff" value="0"/><label for="radio2">关闭</label> 
<?php } ?>	

</div></form>
<script>
$(function(){
	$('#radioset').buttonset();
	
	$('input[name="noteoff"]').click(function(){
		var xx = $('input[name="noteoff"]:checked').val();
		$.post("?my=noteoff",{"noteoff":xx},function(){});
	});
});

</script>
<form action="?my=order" method="POST">
<input type="submit" class="btn btn-info" value="保存排序 (序号大的靠前)">
      <div class="table-responsive">
        <table class="table table-striped ">
          <thead><tr><th>排序</th><th>名称</th><th>地址</th><th>添加时间</th><th>描述</th><th>操作</th></tr></thead>
          <tbody>
<?php
$db = db("app_note");
$rs=$db->where($where)->order("`order` DESC,id DESC")->fpage($_GET["page"],30)->select();
$numrows = $db->getnums();
foreach($rs as $res)
{
?>
<tr>
<td><input value="<?=$res['order']?>" class="form-control" name="order[<?=$res["id"]?>]" style="width:40px"></td>
<td><?=$res['name']?></td>
<td><?=$res['ipport']?></td>
<td><?=$res['time']?></td>
<td><?=$res["description"]?></td>
<td><a href="?my=del&id=<?=$res['id']?>" class="btn btn-xs btn-link" onclick="if(!confirm('你确实要删除此记录吗？')){return false;}"><i class="icon-trash"></i></a>
<a href="note_add.php?act=mod&id=<?=$res['id']?>" class="btn btn-xs btn-link"><i class="icon-pencil"></i></a></td>
</tr>

<?php 
}
?>
          </tbody>
        </table>
      </div>
	</form>
</div>
<?php echo create_page_html($numrows,$_GET["page"],30,"&gid=".$_GET["gid"]);?>
</div>
<div class="col-xs-12 col-sm-4">
	<div class="box">
	<p class="text-warning">节点功能介绍：<br>
	在传统的负载方式中，客户请求会以DNS解析的方式被随机分配到不同的服务器，以实现负载。这类请求在总体上会似的每个服务器的负载近乎均衡，但是同时也带来了另一个问题，因为采取的单纯的DNS轮询，而不会去判断地域，就近选择，就会出现北京的用户明明可以有更加优质的北京服务器，却被分配到了广东服务器，那么这两个直接的延迟差距就是显而易见的。<br>
	通过本功能，添加节点可以实现根据地区负载。<br>
	例如，现在有 北京服务器 A B C三台，广东服务器  D E F三台。注册有域名 test.com<br>
	传统方式 完全请求随机分配，用户可能分配到任何一台服务器，那么，如果通过节点解决呢？<br>
	我们首先可以在域名解析中，添加 beijing.test.com  解析 A B C三个IP 。添加 guangdong.test.com添加D E F 三个IP。这样就形成了两个小的地区分组。北京的域名只解析北京服务器，广告只解析广东。
	然后分别添加两个节点:北京集群 域名beijing.test.com 广东集群 guangdong.test.com 。<br>
	这样，用户就可以选择离自己近的集群连接，同一地域内的请求又可以均衡负载。<br>
	当然，本功能适合 用户分布广泛，服务器众多的，小中用户完全可以关闭节点功能，以便于节省资源！
	<hr>
	使用方法，将线路中的服务器IP或者域名替换成[domain]（例如 http-proxy [domian]:8080），安装时，会自动替换为节点域名。当然，如果关闭节点功能，则会被替换为 [证书管理]中的域名。
	</p>
	</div>

</div>
</div>
<?php }
include("footer.php");?>
