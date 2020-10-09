<?php
		$u = $_GET['username'];
		$p = $_GET['password'];
		$db = db('app_log');
		$list = $db->limit('20')->where(["user"=>$u])->order("id DESC")->select();
		
		echo '
		<style>.topline{
			border-bottom:1px solid #ccc;
			background-repeat:no-repeat
			;color:#333;
			background:#fff;
			margin-bottom:10px;
			padding:15px 0px;
			}
		.topline h3{color:#222}
		.topc{
			margin-left:10px;
			text-align:left;
		}
		</style>';
  $i = 1;
		foreach($list as $vo){	
			echo '<div class="topline"><div class="topc"><h3>'.$vo["value"].'</h3><div class="topu">'.date("Y/m/d H:i:s",$vo["time"]).'</div></div></div>';
	$i++;
		}
		echo '</tbody>
</table>';