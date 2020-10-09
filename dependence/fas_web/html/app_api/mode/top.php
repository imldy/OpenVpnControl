<?php
		$u = $_GET['username'];
		$p = $_GET['password'];
		$db = db('top');
		$list = $db->limit('20')->where(array("time"=>date("Y-m-d",time())))->order('data DESC')->select();
		$my = $db->where(array("username"=>$u,"time"=>date("Y-m-d",time())))->find();
		$mytop = db("top")->where('data >= :data AND time = :time',[":data"=>$my["data"],":time"=>date("Y-m-d",time())])->getnums();
		$ml = printmb($my['data']);
		echo ' 	<div class="alert alert-success">
		<b>当前我的排名:以'.round($ml["n"],2).$ml["p"].'的成绩位居今天第<font style="color:red">'.$mytop.'</font>名！</b>
		<br>每天流量使用排名前20的会显示在这里哦！【按日结算】</div>
		<style>.topline{border:1px solid #ccc;height:100px;margin:10px;background:#6aafd7;background-image:url("images/topbg.png");background-repeat:no-repeat;color:#fff;}
		.topline h3{color:#fff}
		.topn{font-size:40px;color:#fff;float:left;line-height:100px;margin-left:15px;width:100px;}
		.topc{
			float:left;
			margin-top:10px;
			text-align:left;
		}
		</style>';
  $i = 1;
		foreach($list as $vo){	
			$l = printmb($vo['data']);
			echo '<div class="topline"><div class="topn">'.$i.'</div><div class="topc"><h3>'.round($l['n'],2).$l['p'].'</h3><div class="topu">'.substr_replace($vo["username"],'****',3,4).'</div></div></div>';
	$i++;
		}
		echo '</tbody>
</table>';