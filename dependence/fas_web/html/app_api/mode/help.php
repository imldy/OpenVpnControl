<?php
if(DID > 0){
	$res = db("app_daili")->where(["id"=>DID])->find();
	$data = $res;
}else{
	$m = new Map();
	$data = $m->type("cfg_app")->getAll();
}

?>
<div class="main">
	<div class="panel panel-default">
   <div class="panel-body">
      <?php
		echo html_decode($data["content"]);
	  ?>
	 
   </div>
</div>
</div>
