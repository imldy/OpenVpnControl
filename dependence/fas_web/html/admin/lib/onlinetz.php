<?php
$domain = $_POST["domain"];
$file = $_POST["file"];
$str=file_get_contents('http://'. $domain .'/openvpn_api/'.$file.'.txt',false,stream_context_create(array('http' => array('method' => "GET", 'timeout' =>2))));
	$onlinenum = (substr_count($str,date('Y'))-1)/2;
	if($onlinenum < 0)
		$onlinetext = '<span style="color:red;">超时</span>';
	else
		$onlinetext = '<a href="online.php?id='.$res['id'].'">'.(int)$onlinenum.'</a>';
		
	die($onlinetext);