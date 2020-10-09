<div style="background:#efefef;"><?php
	$u = $_GET['username'];
	$p = $_GET['password'];
		$db = db('top');
		$list = $db->where(array('username'=>$u))->limit(30)->order('id DESC')->select();
		echo ' 	<div class="alert alert-success">可以查看近期每天的流量使用情况。每次断开后数据才会更新到此处哦！最多查看30天！</div>
		<style>.topline{
			border-bottom:1px solid #ccc;height:100px;;background-repeat:no-repeat;color:#333;
			background:#fff;
			margin-bottom:10px;
			}
		.topline h3{color:#222}
		.topn{font-size:30px;color:#222;float:left;line-height:100px;margin-left:15px;width:100px;}
		.topc{
			float:left;
			margin-top:10px;
			text-align:left;
		}
		</style>';
  $i = 1;
		foreach($list as $vo){	
			$l = printmb($vo['data']);
			$t = explode("-",$vo['time']);
	  echo '<div class="topline"><div class="topn">'.$t[2].'日</div><div class="topc"><h3>'.round($l['n'],2).$l['p'].'</h3><div class="topu">'.$vo['time'].'</div></div></div>';
	$i++;
		}
		
?>
<div style="text-align:center;padding:15px;">
没有更多数据喽~~
</div>
</div>