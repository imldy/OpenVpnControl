<?php

function getkm($len = 18)
{
	$str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
	$strlen = strlen($str);
	$randstr = "";
	for ($i = 0; $i < $len; $i++) {
		$randstr .= $str[mt_rand(0, $strlen - 1)];
	}
	return $randstr;
}

if($_GET['act'] == 'save'){
	include('system.php');
	if($tc = db("app_tc")->where(["id"=>$_POST["tid"]])->find()){
		$jg = $tc["jg"];
		
		if($_POST["nums"] < 0){$_POST["nums"] = 0;}
		$need = $jg*($admin_ext["per"]/100)*$_POST["nums"];
		if($need <= $admin["balance"]){
			$db = db("app_kms");
			$n = 0;
			$time = time();
			for($i=0;$i<intval($_POST["nums"]);$i++){
				if($db->insert(array("km"=>getkm(18),"daili"=>$admin["id"],"addtime"=>$time,"type_id"=>$_POST["tid"]))){
					$n++;
				};
			}
			
			$new = $admin["balance"]-$n*$jg*($admin_ext["per"]/100);
			db("app_daili")->where(["id"=>$admin["id"]])->update(["balance"=>$new]);
			
			die(json_encode(array("status"=>'success')));
		}else{
			die(json_encode(array("status"=>'error',"msg"=>"余额不足")));
		}
		
	}else{
		die(json_encode(array("status"=>'error',"msg"=>"套餐不存在")));
	}

}elseif($_GET['act'] == 'del'){
	include('system.php');
	$db = db('app_kms');
	if($db->where(array('id'=>$_POST['id'],"daili"=>$admin["id"]))->delete()){
		die(json_encode(array("status"=>'success')));
	}else{
		die(json_encode(array("status"=>'error')));
	}
}elseif($_GET['act'] == 'del_select'){
	include('head.php');
	include('nav.php');
	$db = db('app_kms');
	$n = 0;
	$arr = $_POST['checkbox'];
	foreach($arr as $id){
		if($db->where(array('id'=>$id,"daili"=>$admin["id"]))->delete()){
			$n++;
		}
	}
	
	tip_success($n."条卡密删除成功","?tid=".$_GET["id"]);
	
}elseif($_GET['act'] == 'show'){
	include('head.php');
	echo "请复制保存<br>";
	$db = db('app_kms');
	$list = $db->where(array('type_id'=>$_GET['id'],"isuse"=>0,"daili"=>$admin["id"]))->order("id DESC")->select();
	echo "<br><textarea style='width:100%;height:400px;'>";
	foreach($list as $vo){
		echo $vo["km"]."\n";
	}
	echo "</textarea>";
}elseif($_GET['act'] == 'del_all'){
	include('head.php');
	include('nav.php');
	$db = db('app_kms');
	if($db->where(array('type_id'=>$_GET['gid'],"daili"=>$admin["id"]))->delete()){
		tip_success("删除成功","?tid=".$_GET["id"]);
	}else{
		tip_failed("删除失败",$_SERVER['HTTP_REFERER']);
	}
}else{
$title='当前在线用户';
include('head.php');
include('nav.php');
if(trim($_GET["tid"]) == ""){
	$tmp = db("app_tc")->order("id DESC")->find();
	$tid =  $tmp["id"];
}else{
	$tid = $_GET["tid"];
}
if(!$tc_info = db("app_tc")->where(array("id"=>$tid))->find()){
	die("没有此套餐");
};
?>
<div class="box">
<form action="?act=del_select" method="POST">
<div class="col-xs-12 center-block" style="float: none;">
<button type="submit" class="btn btn-danger">删除所选</button>&nbsp;
<button type="button" class="btn btn-danger" onclick="delAll('<?php echo $tid?>')">清空本套餐</button>&nbsp;
<a type="button" class="btn btn-primary" href="km_list.php?act=show&id=<?php echo $tid?>" target="_blank">导出本套餐未使用卡密</a>&nbsp;
<a class="btn btn-primary" data-toggle="modal" data-target="#myModal" id="setting">
	新增卡密
</a>&nbsp;

<div style="height:10px;"></div>

<button type="button" class="btn btn-primary btn-xs">套餐</button>
<?php

//$rs=$DB->query("SELECT * FROM `auth_fwq`  order by id desc limit 20");
$km_type = db("app_tc")->order("id DESC")->select();
foreach($km_type as $res)
{
	if($res['id'] == $tid){
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-info" ><a href="?tid='.$res['id'].'" style="color:#fff">'.$res['name'].'</a></span>';
	}else{
		echo '&nbsp;&nbsp;&nbsp;&nbsp;<span><a href="?tid='.$res['id'].'">'.$res['name'].'</a></span>';
	}
}
?>
<div style="height:10px;"></div>
<div class="table-responsive">
<?php 
$numrows = db("app_kms")->where(array("type_id"=>$tid,"daili"=>$admin["id"]))->order("id DESC")->getnums();
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
$rs = db("app_kms")->where(array("type_id"=>$tid,"daili"=>$admin["id"]))->order("id DESC")->fpage($_GET["page"],30)->select();
if($rs){
	echo '<table class="table table-striped">
   <thead>
      <tr>
	   <th style="width:50px;"><input name="checkbox-all" type="checkbox" value="" /></th>
	   <th>ID</th>
   <th>卡密</th>
   <th>状态</th>
    <th>套餐时间</th>
	<th>套餐流量</th>
	<th>使用者</th>
	<th>使用时间</th>
	<th>添加时间</th>
	<th>操作</th>
      </tr>
   <tbody>';
	foreach($rs as $res){
		$info = db("app_tc")->where(array("id"=>$res["type_id"]))->find();
		echo "<tr class=\"line-id-".$res["id"]."\">";
		echo "<td><input name=\"checkbox[]\" type=\"checkbox\" value=\"".$res["id"]."\" /></td>";
		echo "<td>".$res["id"]."</td>";
		echo "<td style=\"width:200px\">";
			if($res["isuse"] == 1){
				echo '<s style="color:red">'.$res["km"].'</s>';
			}else{
				echo $res["km"];
			}
		
		"</td>";
		echo "<td>";
		if($res["isuse"] == 1){
			echo "已使用";
		}else{
			echo "正常";
		}
		echo "</td>";
		echo "<td>".$info["limit"]."天</td>";
		echo "<td>".round($info["rate"],3)."MB&nbsp;".$pre."</td>";
		echo "<td>";
		if($res["user_id"]>0){
			$uinfo = db(_openvpn_)->where(["id"=>$res["user_id"]])->find();
			echo $uinfo["iuser"];
		}else{
			echo " - ";
		}
		echo "</td>";
		echo "<td>";
		if($res["usetime"]!=""&&$res["usetime"]!=0){
			echo date("Y/m/d H:i:s",$res["usetime"]);
		}else{
			echo " - ";
		}
		echo "</td>";
		echo "<td>";
		if($res["addtime"]!=""&&$res["addtime"]!=0){
			echo date("Y/m/d H:i:s",$res["addtime"]);
		}else{
			echo " - ";
		}
		echo "</td>";
		echo '<td><button type="button" class="btn btn-danger btn-xs" onclick="delById(\''.$res["id"].'\')">删除</button></td>';
		echo "</tr>";
	}
	echo "
		 </tbody>
	   </thead>
	</table>";
}else{
	echo "<center>";
	echo "空空如也~暂时没有任何卡密！";
	echo "</center>";
}
?>
</form>
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
						
						$bn = (int)($admin["balance"]/($tc_info["jg"]*$admin_ext["per"]/100));
					?>
				  </div>
				  <div class="form-group">
					<label for="name">价格：<?= $tc_info["jg"]?>元&nbsp;请输入数量(代理价格<?php echo ($tc_info["jg"]*$admin_ext["per"]/100)?>元 &nbsp;最多可购买：<?php echo $bn; ?>)</label>
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
</script>
<script>
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
					 location.reload(true);
				}else{
					alert(data.msg);
				}
			},"JSON");
	   });
   });
</script>
<?php 
include("footer.php");
}?>
