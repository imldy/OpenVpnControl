<?php
if($_GET['act'] == 'del'){
	include('system.php');
	$db = db('app_feedback');
	if($db->where(array('id'=>$_POST['id']))->delete()){
		die(json_encode(array("status"=>'success')));
	}else{
		die(json_encode(array("status"=>'error')));
	}	
}elseif($_GET['act'] == 'del_all'){
	include('head.php');
	include('nav.php');
	$db = db('app_feedback');
	if($db->where(array('type_id'=>$_GET['gid']))->delete()){
		tip_success("删除成功",$_SERVER['HTTP_REFERER']);
	}else{
		tip_failed("删除失败",$_SERVER['HTTP_REFERER']);
	}
}else{
$title='当前在线用户';
include('head.php');
include('nav.php');


?>
<div class="box">
<form action="?act=del_select" method="POST">
<div >
<button type="button" class="btnui ui-button-error" onclick="delAll('<?php echo $tid?>')">清空</button>&nbsp;
<div style="height:10px;"></div>
<div class="table-responsive">
<?php 
$numrows = db("app_feedback")->order("id DESC")->getnums();
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
echo '<table class="table table-striped">
	   <thead>
		  <tr>
		   <th>ID</th>
	   <th>用户</th>
	   <th>线路</th>';
		foreach($config["Feedback"]["Field"] as $key=>$vo){
			echo '<th>'.$key.'</th>';
		} 
		echo '<th>时间</th>
		<th>操作</th>
		  </tr>
	   <tbody>';
	$rs = db("app_feedback")->order("id DESC")->select();
	foreach($rs as $res){
			$info = db(_openvpn_)->where(array("id"=>$res["user_id"]))->find();
			$info2 = db("line")->where(array("id"=>$res["line_id"]))->find();
			echo "<tr class=\"line-id-".$res["id"]."\">";
		
			echo "<td>".$res["id"]."</td>";
			echo "<td>".$info[_iuser_]."</td>";
			echo "<td>".$info2["name"]."</td>";
			$data = json_decode(base64_decode($res["content"]),true);
			foreach($config["Feedback"]["Field"] as $key=>$vo){
				echo '<td>'.$data[$key].'</td>';
			} 
			echo "<td>";
			echo date("Y/m/d H:i:s",$res["time"]);
			echo "</td>";
			echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="delById(\''.$res["id"].'\')">删除</button></td>';
			echo "</tr>";
		}
		echo "
			 </tbody>
		   </thead>
		</table>";

?>
</form>
</div>
<?php
	
	$page_limit = 15;
	
	$page = trim($_GET["page"]) == "" ? 1 : $_GET["page"];  
	
	
	$rem = $page % $page_limit;
	$page_len = $rem;
	$page_start = $page - $rem + 1;
	if($page >= 15){
		$page_start--;
	}
	$for_len = $pages-$page_start> 15 ? 15 : $pages-$page_start+1; 

	
	echo'<ul class="pagination">';
	$link = "&tid=".$tid;
	$first=1;
	$prev=$page-1;
	$next=$page+1;
	$last=$pages;
	if ($page>1)
	{
	echo '<li><a href="?page='.$first.$link.'">首页</a></li>';
	echo '<li><a href="?page='.$prev.$link.'">&laquo;</a></li>';
	} else {
	echo '<li class="disabled"><a>首页</a></li>';
	echo '<li class="disabled"><a>&laquo;</a></li>';
	}
	for($i=$page_start;$i<$page_start+$for_len;$i++){
		if($page != $i){
			echo '<li><a href="?page='.$i.$link.'">'.$i .'</a></li>';
		}else{
			echo '<li class="disabled"><a>'.$page.'</a></li>';
		}
	}
	
	if ($page<$pages)
	{
	echo '<li><a href="?page='.$next.$link.'">&raquo;</a></li>';
	echo '<li><a href="?page='.$last.$link.'">尾页</a></li>';
	} else {
	echo '<li class="disabled"><a>&raquo;</a></li>';
	echo '<li class="disabled"><a>尾页</a></li>';
	}
	echo '</ul>';
#分页
?>
</div>
</div>
	  
	 
    </div>
	<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
				</button>
				<h4 class="modal-title" id="myModalLabel">
					卡密生成
				</h4>
			</div>
			<div class="modal-body">
				
				 <div class="form-group">
					<label for="name">生成的套餐：</label>
					<?php 
						echo $tc_info["name"].'(';
						echo $tc_info["limit"]."天/".round($tc_info["rate"],3)."M)";
					?>
				  </div>
				  <div class="form-group">
					<label for="name">请输入数量(0-9999)</label>
				<input type="text" class="form-control" id="creat_kms" placeholder=""  value="200">
					
				  </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">
					关闭
				</button>
				<button type="button" class="btn btn-primary save">
					提交更改
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<script>
   $(function(){
	   $('#myModal').modal('hide');
	   });
	 
	function delById(id,action){
		if(confirm('确认删除吗？删除后不可恢复哦！')){
			var url = "?act=del";
			var data = {
				"id":id
			};
			$.post(url,data,function(data){
				if(data.status == "success"){
					$('.line-id-'+id).slideUp();
				}else{
					alert("删除失败");
				}
			},"JSON");
		}
	}

	function delAll(id){
		if(confirm('确认删除吗？删除后不可恢复哦！')){
			location.href="?act=del_all&gid="+id;
		}
	}
   $(function () { $('#myModal').on('hide.bs.modal', function () {
      //alert('嘿，我听说您喜欢模态框...');
	  })
   });
   $(function(){
	   
	   $(".save").click(function(){
		   var nums = $("#creat_kms").val();
		   if(nums == ""){
			   alert("请输入生成的卡密数量");
		   } 
		   $.post('?act=save',{
			   "tid":'<?php echo $tid?>',
			   "nums":nums
			},function(data){
				if(data.status == "success"){
					 $('#setting').click();
					 window.location.href="lastkm/index.php";
				}else{
					alert(data.msg);
				}
			},"JSON");
	   });
   });
</script>
<?php 
	include("footer.php");
}
?>
