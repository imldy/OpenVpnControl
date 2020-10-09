<?php
 	include('head.php');
	include('nav.php');
	
 	if($_GET['act'] == 'del'){
		$db = db('line');
		if($db->where(array('id'=>$_POST['id']))->delete()){
			die(json_encode(array("status"=>'success')));
		}else{
			die(json_encode(array("status"=>'error')));
		}
		
	}elseif($_GET['act'] == 'show'){
		$show = $_POST['show'] == '1' ? "1" : "0";
		$db = db('line');
		if($db->where(array('id'=>$_POST['id']))->update(array('show'=>$show))){
			die(json_encode(array("status"=>'success')));
		}else{
			die(json_encode(array("status"=>'error')));
		}
		
	}else{
 ?>
<div class="main">
<div class="box">
<?php
$db = db('line');
if(@$_GET["gid"] == ""){
	$data = [];
}else{
	$where[] = "`group`=:group ";
	$data[":group"] = $_GET["gid"];
	
}
if(@$_GET["kw"] != ""){
	$where[] = " name LIKE :name";
	$data[":name"] = "%".$_GET["kw"]."%";
}

$list = $db->where(implode(" AND ",$where),$data)->order('`order` DESC,id DESC')->fpage(@$_GET["page"],20)->select();
$numrows = $db->getnums();
 

echo '<form action="line_list.php" method="get" class="form-inline">
  <div class="form-group">
    <input type="hidden" class="form-control" name="gid" value="'.$_GET["gid"].'">
    <input type="text" class="form-control" name="kw" placeholder="线路名称 支持模糊搜索" value="'.$_GET["kw"].'">
  </div>
  <button type="submit" class="btn btn-primary">搜索</button>
 ';
 
echo '<a href="#" class="btn btn-success"> <b>'.$numrows.'</b> 个线路</a>';
echo '</form>';?>
<div style="clear:both;height:10px;"></div>
<button type="button" class="btn btn-primary btn-xs">线路分类</button>
<?php
if(@$_GET["gid"] == ""){
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-info" ><a href="?'.$t_str.'" style="color:#fff">全部</a></span>';
}else{
	echo '&nbsp;&nbsp;&nbsp;&nbsp;<span ><a href="?'.$t_str.'" >全部</a></span>';
}
$rs=db("line_grop")->where()->select();
foreach($rs as $res)
{
	if($res['id'] == $_GET["gid"]){
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-info" ><a href="?gid='.$res["id"].'" style="color:#fff">'.$res['name'].'</a></span>';
	}else{
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="?gid='.$res["id"].'">'.$res['name'].'</a></span>';
	}
}


?><div style="clear:both;height:10px;"></div>
<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>名称</th>
      <th>类型</th>
      <th>说明</th>
      <th>状态</th>
      <th>操作</th>
    </tr>
  </thead>
  <tbody>
  <?php 
	foreach($list as $vo){
	?>
	 <tr class=" line-id-<?=$vo['id']?>">
      <td><?=$vo['id']?></td>
      <td><?=$vo['name']?></td>
      <td><?=$vo['type']?></td>
      <td><?=$vo['label']?></td>
      <td><?php 	echo $vo['show'] == '1'? '<button type="button" class="btn btn-primary btn-xs showstatus" onclick="qiyong(\''.$vo['id'].'\')" data="1">已启用</button>&nbsp;':'<button type="button" class="btn btn-primary btn-xs showstatus" onclick="qiyong(\''.$vo['id'].'\')" data="0">已禁用</button>&nbsp;'; ?></td>
      <td><button type="button" class="btn btn-primary btn-xs" onclick="window.location.href='line_add.php?act=mod&id=<?=$vo['id']?>'">编辑</button> <button type="button" class="btn btn-danger btn-xs" onclick="delLine('<?=$vo['id']?>')">删除</button> <a type="button" class="btn btn-info btn-xs" href="option.php?my=download&id=<?=$vo['id']?>" target="download">下载</a></td>
    </tr>		
	<?php
	}
	?>
  </tbody>
</table>

</div>
</div>
<?php
	echo create_page_html($numrows,$_GET["page"],30,"&gid=".$_GET["gid"]);
	}
	include('footer.php');
	
?>
<script>
function qiyong(id){
	var doc = $('.line-id-'+id+' .showstatus');
	if(doc.attr('data') == "1"){
		doc.html("已禁用").attr({'data':'0'});
	}else{
		doc.html("已启用").attr({'data':'1'});
	}
	var url = "line_list.php?act=show";
		var data = {
			"id":id,
			"show":doc.attr('data')
		};
		$.post(url,data,function(data){
			if(data.status == "success"){

			}else{
				alert("操作失败");
			}
		},"JSON");
}
function delLine(id){
	if(confirm('确认删除吗？删除后不可恢复哦！')){
		$('.line-id-'+id).slideUp();
		var url = "line_list.php?act=del";
		var data = {
			"id":id
		};
		$.post(url,data,function(data){
			if(data.status == "success"){

			}else{
				alert("删除失败");
			}
		},"JSON");
	}
}

</script>
<iframe name="download" style="display:none"></iframe>