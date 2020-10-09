<?php
	include('head.php');
	include('nav.php');
 	if($_GET['act'] == 'del'){
		$db = db('line_grop');
		if($db->where(["id"=>$_GET["id"]])->delete()){
			db("line")->where(["type"=>$_GET["id"]])->delete();
			tip_success("删除分类并清空本分类下全部线路成功！","?");
		}else{
			tip_failed("删除失败","?");
		}
		
	}elseif($_GET['act'] == 'add'){
		$db = db('line_grop');
		if($db->insert(['name'=>$_POST['name'],'order'=>$_POST['order'],'show'=>1])){
			tip_success("新增【".$_POST['name']."】成功！","?");
		}else{
			tip_failed("分类新增失败","?");
		}
		
	}else{
		$action = '?act=add';
 ?>
<div class="main">
	<div class="box">
		<span class="label label-default">分类管理</span>
		<div style="clear:both;height:10px;"></div>
		<form class="form-horizontal" role="form" method="POST" action="<?php echo $action; ?>">
		<div class="form-group">
			<label for="firstname" class="col-sm-2 control-label">分类名称</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="name" placeholder="分类名称" value="">
			</div>
		</div>
		<div class="form-group">
			<label for="lastname" class="col-sm-2 control-label">排序（0-9999 数字越小越靠前）</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="order" placeholder="排序" value="1">
			</div>
		</div>


		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<button type="submit" class="btn btn-default">添加</button>
			</div>
		</div>
	</form> 
	
	<ul class="list-group">
		<?php 
			
			$list=db("line_grop")->where(array())->order("`order` ASC,id DESC")->select();
			foreach($list as $vo){
				echo ' <li class="list-group-item line-id-'.$vo['id'].'">
			序号:'.$vo['order'].':'.$vo['name'];
			
			echo '&nbsp;<a type="button" class="btn btn-danger btn-xs" href="?act=del&id='.$vo['id'].'" onclick="javascript:if(confirm(\'删除分类会一并删除本分类下全部线路！\')){return true}else{return false}">删除</a>
		</li>';
			}
		?>
	   
	</ul>
	
	</div>
</div>
<?php
	}
	include('footer.php');
?>
