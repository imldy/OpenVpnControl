<?php
include('head.php');
include('nav.php');
?><style>
.row-col{
		background:#fff;
		border:1px solid #ccc;
		border-top:1px solid #ddd;
		border-left:1px solid #ddd;
		padding:15px;
	}
.sub{
	font-size:16px;
}
	.row-col h3{
		color:#777;
	}
	.row-col p{
		padding:15px;
	}</style>
<?php 	
 	if($_GET['act'] == 'del'){
		$db = db('app_tc');
		if($db->where(array('id'=>$_POST['id']))->delete()){
			db("app_kms")->where(array('type_id'=>$_POST['id']))->delete();
			die(json_encode(array("status"=>'success')));
		}else{
			die(json_encode(array("status"=>'error')));
		}
		
	}elseif($_GET['act'] == 'show'){
		$show = $_POST['show'] == '1' ? "1" : "0";
		$db = db('app_tc');
		if($db->where(array('id'=>$_POST['id']))->update(array('show'=>$show))){
			die(json_encode(array("status"=>'success')));
		}else{
			die(json_encode(array("status"=>'error')));
		}
		
	}else{
 ?>
<div class="main">
	<div class="row">
	<?php 
		$db = db('app_tc');
		$list = $db->where(array())->order('id DESC')->select();
		foreach($list as $vo){
		
echo '<div class="col-xs-6 col-sm-3 text-center line-id-'.$vo['id'].'">';
	echo '<div class="row-col c_active div_shadow">';
      echo '<h3>'.$vo['name'].'</h3>';
		echo '<div class="sub">价格：'.$vo["jg"].'元</div>';
		echo '<div class="sub">流量：'.$vo["rate"].'M</div>';
		echo '<div class="sub">期限：'.$vo["limit"].'天</div>';
		echo '<br>';
		echo '<a type="button" class="btn btn-primary btn-xs" href="km_list.php?tid='.$vo['id'].'">管理/添加卡密</a>&nbsp;';
		echo '<button type="button" class="btn btn-primary btn-xs" onclick="window.location.href=\'add_tc.php?act=mod&id='.$vo['id'].'\'">编辑</button>&nbsp;';
		echo '<button type="button" class="btn btn-danger btn-xs" onclick="delLine(\''.$vo['id'].'\')">删除</button>&nbsp;';
		echo '<a class="btn btn-danger btn-xs" href="'.$vo["url"].'" target="_blank">购买</a>';
    echo '</div>';
    echo '</div>';
		}
	?>
   
</div>
</div>
<?php
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
	var url = "list_tc.php?act=show";
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
		var url = "list_tc.php?act=del";
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
