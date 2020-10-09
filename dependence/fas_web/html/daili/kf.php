<?php

include('head.php');
include('nav.php');

	if($_GET["act"] == "mod"){
		$db = db('app_daili');
		if($db->where(['id'=>$admin['id']])->update(['content'=>$_POST['content']])){
			tip_success("公告修改成功",$_SERVER['HTTP_REFERER']);
		}else{
			tip_failed("十分抱歉修改失败",$_SERVER['HTTP_REFERER']);
		}
	}else{
		
 ?>
   
<div class="box">
   
 <form role="form" action="?act=mod" method="POST">
  <div class="form-group">
    <label for="name">客服页面的文字内容 支持HTML</label>
    <textarea class="form-control" rows="6" name="content"><?=$admin["content"]?></textarea>
  </div>
  <input type="submit" class="btn btn-default mod" value="确认修改">
  </form>
</div>
<?php include('footer.php'); };?>