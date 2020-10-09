<?php
if($_GET["op"] == "del"){
	db("app_bbs")->where(array("id"=>$_POST["id"]))->delete();
	db("app_bbs")->where(array("to"=>$_POST["id"]))->delete();
	die(json_encode(array("status"=>"success")));
	exit;
}

?>
<script>
var to_id=0;
var del_id=0;
</script>
<?php
$u = $_GET['username'];
		$p = $_GET['password'];
		$db = db('app_bbs');
		$list = $db->where(array("to"=>"0"))->order('id DESC')->fpage($_GET["page"],10)->select();
		echo '<div style="margin:10px 10px;">';
		echo '<button class="btn btn-primary " data-toggle="modal" data-target="#myModal">发布新留言</button>';
		
		echo '</div>';
		$numrows = $db->where(array("to"=>"0"))->getnums();
$pagesize=10;
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

		if($list){
			echo '<ul class="list-group">';
			foreach($list as $v){
				
				echo '<li class="list-group-item line-id-'.$v["id"].'"><span class="glyphicon glyphicon-user"></span>'.substr_replace($v["username"],'****',3,4).'于 '.date("Y/m/d H:i:s",$v["time"]).'发表留言<hr>'.$v["content"];
				$list_re = db("app_bbs")->where(array("to"=>$v["id"]))->order('id DESC')->select();
				foreach($list_re as $ve){
					echo '<pre><span class="glyphicon glyphicon-user"></span>'.substr_replace($ve["username"],'****',3,4).'于 '.date("Y/m/d H:i:s",$ve["time"]).'回复<br>'.$ve["content"].'</pre>';
				}
				echo '<hr><button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#rep" onclick="javascript:to_id='.$v["id"].';">回复</button>';
				if($v["username"] == $_GET["username"]){
					echo '&nbsp;<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#del"onclick="javascript:del_id='.$v["id"].';" >删除</button>';
				}
				echo '</li>
				';
			}
		echo '</ul>';
		}else{
			echo '消息已经删除或者不存在！';
		}
		?>
		<?php
echo'<ul class="pagination">';
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$pages;
if ($page>1)
{
echo '<li><a href="?act=list_bbs&username='.$_GET["username"].'&password='.$_GET["password"].'&page='.$first.$link.'">首页</a></li>';
echo '<li><a href="?act=list_bbs&username='.$_GET["username"].'&password='.$_GET["password"].'&page='.$prev.$link.'">&laquo;</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>&laquo;</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="?act=list_bbs&username='.$_GET["username"].'&password='.$_GET["password"].'&page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$pages;$i++)
echo '<li><a href="?act=list_bbs&username='.$_GET["username"].'&password='.$_GET["password"].'&page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$pages)
{
echo '<li><a href="?act=list_bbs&username='.$_GET["username"].'&password='.$_GET["password"].'&page='.$next.$link.'">&raquo;</a></li>';
echo '<li><a href="?act=list_bbs&username='.$_GET["username"].'&password='.$_GET["password"].'&page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>&raquo;</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';

?>
<!-- 模态框（Modal） -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">新增留言</h4>
            </div>
            <div class="modal-body">
			 <div class="form-group">
    <label for="name">请输入留言内容(文明社会 文明评论)</label>
    <textarea class="form-control" rows="3" id="content"></textarea>
  </div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary add">确认发布</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="rep" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">回复留言</h4>
            </div>
            <div class="modal-body">
			 <div class="form-group">
    <label for="name">请输入留言内容(文明社会 文明评论)</label>
    <textarea class="form-control" rows="3" id="contents"></textarea>
  </div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary rep">确认发布</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>

<div class="modal fade" id="del" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">删除留言</h4>
            </div>
            <div class="modal-body">
			 <div class="form-group">
   删除后其回复也会一起删除！
  </div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary " onclick="javascript:delBbs(del_id)">确认删除</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>
<script>
$(function(){
	$(".add").click(function(){
		var content = $("#content").val();
		if(content.length >= 5 && content.length <= 250 ){
			$.post("?act=add_bbs&username=<?php echo $_GET["username"]?>&password=<?php echo $_GET["password"]?>",{
				"content":content
			},function(data){
				if(data.status == "success"){
					 location.reload(true);
				}else{
					alert("新增失败");
				}
			},"JSON");
		}else{
			alert("内容必须在5个字符以上并且250个字符以下");
		}
	});
	
	$(".rep").click(function(){
		var content = $("#contents").val();
		if(content.length >= 5 && content.length <= 250 ){
			
			$.post("?act=re_bbs&username=<?php echo $_GET["username"]?>&password=<?php echo $_GET["password"]?>",{
				"content":content,
				"to":to_id
			},function(data){
				if(data.status == "success"){
					 location.reload(true);
				}else{
					alert("新增失败");
				}
			},"JSON");
		}else{
			alert("内容必须在5个字符以上并且250个字符以下");
		}
	});
});
function delBbs(id){
	$.post("?act=list_bbs&op=del&username=<?php echo $_GET["username"]?>&password=<?php echo $_GET["password"]?>",{
				"id":id
			},function(data){
				
					 location.reload(true);
				
			})
}
</script>