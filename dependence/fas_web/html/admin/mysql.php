<?php
require('head.php');
require('nav.php');

@$act = $_GET["act"];
if($act == "del"){
	$key = $_GET["id"]== "" ? $_POST["id"] : $_GET["id"];
	@unlink(R."/mysql/".$key.".sql");
}elseif($act == "bak"){
	$filename=date("Y-m-d_H-i-s",time()).'_'.md5(time().rand(10000000,99999999))."-"._ov_.".sql";  
	$tmpFile = R."/mysql/".$filename; 
	if(!is_dir(R."/mysql/")){
		mkdir(R."/mysql/");
	}
// 用MySQLDump命令导出数据库 
system("mysqldump -h"._host_." -P"._port_." -u"._user_." -p"._pass_."  "._ov_." > ".$tmpFile); 
tip_success("数据库已经成功备份","mysql.php");
}else{


?>
<h1>数据备份<small></small></h1>
<div class="panel panel-default">
    <div class="panel-body">
       <form action="?act=bak" method="POST"> <input type="submit" class="btn btn-success"  value="备份数据库"><span style="color:red">(数据库备份后请及时下载保存)</span></form>
		<hr>
		<?php
		function tree($directory)
{

    $mydir = dir($directory);
    echo "<ul>\n";

    while($file = $mydir->read())
    {

        $a[] = $file;
    }
    $mydir->close();
	
	return $a;
}
$list = tree(R."/mysql");
echo 	'<ul class="list-group">';
$liskey = file_get_contents(R."/");
	foreach($list as $file){
		$filetime = fileatime(R.'/mysql/'.$file);
		$filetree[$file] = $filetime;
	}
	arsort($filetree);
	foreach($filetree as $file=>$time){
		
		if(is_file(R.'/mysql/'.$file)){
			$file_ext = explode(".",$file);
			echo ' <li class="list-group-item line-id-'.$file_ext[0].'">
        文件:&nbsp;&nbsp;<span style="color:red">'.$file_ext[0].'.sql</span><br>
		<a type="button" class="btn btn-primary btn-xs" href="../mysql/'.$file.'" target="_blank">下载</a>&nbsp;';
		echo '<button type="button" class="btn btn-danger btn-xs" onclick="delMLine(\''.$file_ext[0].'\')">删除</button>&nbsp;
		<!--<button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">同步至云端</button>-->
    </li>';
			//}
		}
	}
		echo "</ul>";
?>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">同步数据到云端</h4>
            </div>
            <div class="modal-body">
			此功能可以将您的数据推送至叮咚的服务器，在云端存储数据！当数据出现丢失，您可以直接从云端恢复！当然，此功能仅正版用户可用
				 <div class="form-group">
					<label for="name">授权码:<code><?php echo APP_KEY;?></code></label><br>
					<label for="name">请输入您的授权域名(如果出现端口请收到删除端口部分)</label>
					<input type="text" class="form-control" id="code" placeholder="" value="<?php echo $_SERVER["HTTP_HOST"]?>">
					
					
				  </div>
				  <div class="form-group">
					<label for="name">请设置密码（您必须自己记忆 遗忘密码将无法恢复数据）</label>
				<input type="text" class="form-control" id="pass" placeholder=""  value="<?php echo $udp_file?>">
					
				  </div>
			</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary btn-block">提交更改</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
$(function() {
    $('#myModal').modal('hide')
})});
</script>
<script>
$(function() {
    $('#myModal').on('hide.bs.modal',
    function() {
      //  alert('嘿，我听说您喜欢模态框...');
    })
});
</script>
<script>
function delMLine(id){
		var url = './mysql.php?act=del&id='+id;
		$.post(url,{
		  
		},function(){
			
		});
		$('.line-id-'+id).slideUp();
  } 
  </script>
 <?php
}
 include("footer.php");
 ?>