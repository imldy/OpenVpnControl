<?php
function ubb($Text){
      $Text=trim($Text);
      //$Text=ereg_replace("\n","<br>",$Text);
      $Text=preg_replace("/\\t/is","  ",$Text);
      $Text=preg_replace("/\[hr\]/is","<hr>",$Text);
      $Text=preg_replace("/\[separator\]/is","<br/>",$Text);
      $Text=preg_replace("/\[h1\](.+?)\[\/h1\]/is","<h1>\\1</h1>",$Text);
      $Text=preg_replace("/\[h2\](.+?)\[\/h2\]/is","<h2>\\1</h2>",$Text);
      $Text=preg_replace("/\[h3\](.+?)\[\/h3\]/is","<h3>\\1</h3>",$Text);
      $Text=preg_replace("/\[h4\](.+?)\[\/h4\]/is","<h4>\\1</h4>",$Text);
      $Text=preg_replace("/\[h5\](.+?)\[\/h5\]/is","<h5>\\1</h5>",$Text);
      $Text=preg_replace("/\[h6\](.+?)\[\/h6\]/is","<h6>\\1</h6>",$Text);
      $Text=preg_replace("/\[center\](.+?)\[\/center\]/is","<center>\\1</center>",$Text);
      //$Text=preg_replace("/\[url=([^\[]*)\](.+?)\[\/url\]/is","<a href=\\1 target='_blank'>\\2</a>",$Text);
      $Text=preg_replace("/\[url\](.+?)\[\/url\]/is","<a href=\"\\1\" target='_blank'>\\1</a>",$Text);
      $Text=preg_replace("/\[url=(http:\/\/.+?)\](.+?)\[\/url\]/is","<a href='\\1' target='_blank'>\\2</a>",$Text);
      $Text=preg_replace("/\[url=(.+?)\](.+?)\[\/url\]/is","<a href=\\1>\\2</a>",$Text);
      $Text=preg_replace("/\[img\](.+?)\[\/img\]/is","<img src=\\1>",$Text);
      $Text=preg_replace("/\[img\s(.+?)\](.+?)\[\/img\]/is","<img \\1 src=\\2>",$Text);
      $Text=preg_replace("/\[color=(.+?)\](.+?)\[\/color\]/is","<font color=\\1>\\2</font>",$Text);
      $Text=preg_replace("/\[style=(.+?)\](.+?)\[\/style\]/is","<div class='\\1'>\\2</div>",$Text);
      $Text=preg_replace("/\[size=(.+?)\](.+?)\[\/size\]/is","<font size=\\1>\\2</font>",$Text);
      $Text=preg_replace("/\[sup\](.+?)\[\/sup\]/is","<sup>\\1</sup>",$Text);
      $Text=preg_replace("/\[sub\](.+?)\[\/sub\]/is","<sub>\\1</sub>",$Text);
      $Text=preg_replace("/\[pre\](.+?)\[\/pre\]/is","<pre>\\1</pre>",$Text);
      $Text=preg_replace("/\[email\](.+?)\[\/email\]/is","<a href='mailto:\\1'>\\1</a>",$Text);
      $Text=preg_replace("/\[i\](.+?)\[\/i\]/is","<i>\\1</i>",$Text);
      $Text=preg_replace("/\[u\](.+?)\[\/u\]/is","<u>\\1</u>",$Text);
      $Text=preg_replace("/\[b\](.+?)\[\/b\]/is","<b>\\1</b>",$Text);
      $Text=preg_replace("/\[quote\](.+?)\[\/quote\]/is","<blockquote>引用:<div style='border:1px solid silver;background:#EFFFDF;color:#393939;padding:5px' >\\1</div></blockquote>", $Text);
      $Text=preg_replace("/\[sig\](.+?)\[\/sig\]/is","<div style='text-align: left; color: darkgreen; margin-left: 5%'><br><br>--------------------------<br>\\1<br>--------------------------</div>", $Text);
      return $Text;
}

function create_page_html($numrows = 0,$offsetPage = 1,$pageSize = 30,$link = "")
{
	$pages=intval($numrows/$pageSize);
	if ($numrows%$pageSize)
	{
		$pages++;
	}
	
	$page_limit = 15;
	$page = intval($offsetPage) == "" ? 1 : $offsetPage;  
	
	
	$rem = $page % $page_limit;
	$page_len = $rem;
	$page_start = $page - $rem + 1;
	if($page >= 15){
		$page_start--;
	}
	$for_len = $pages-$page_start> 15 ? 15 : $pages-$page_start+1; 
	
	$html .= '<ul class="pagination">';
	$first=1;
	$prev=$page-1;
	$next=$page+1;
	$last=$pages;
	if ($page>1)
	{
		$html .=  '<li><a href="?page='.$first.$link.'">首页</a></li>';
		$html .=  '<li><a href="?page='.$prev.$link.'">&laquo;</a></li>';
	} else {
		$html .=  '<li class="disabled"><a>首页</a></li>';
		$html .=  '<li class="disabled"><a>&laquo;</a></li>';
	}
	for($i=$page_start;$i<$page_start+$for_len;$i++){
		if($page != $i){
			$html .=  '<li><a href="?page='.$i.$link.'">'.$i .'</a></li>';
		}else{
			$html .=  '<li class="disabled"><a>'.$page.'</a></li>';
		}
	}
	
	if ($page<$pages)
	{
		$html .=  '<li><a href="?page='.$next.$link.'">&raquo;</a></li>';
		$html .=  '<li><a href="?page='.$last.$link.'">尾页</a></li>';
	} else {
		$html .=  '<li class="disabled"><a>&raquo;</a></li>';
		$html .=  '<li class="disabled"><a>尾页</a></li>';
	}
	$html .=  '</ul>';
	
	return $html;
}