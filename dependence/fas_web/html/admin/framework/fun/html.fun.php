<?php
	//HTML头文件
	function head($title='暂无标题',$echo = false){
		$str = '<html>
<head>
<title>'.$title.'</title>
</head>
<body>';
		if($echo == false){
			return $str;
		}else{
			echo $str;
		}
	}
	//HTML底部文件
	function footer($echo = false){
		$str = "\n</body>\n</html>";
		if($echo == false){
			return $str;
		}else{
			echo $str;
		}
	}


function userData($userid,$get=null){
	if(!isset($userid)){
		return false;
	}
	$data_file = R.'/data/user/'.$userid.'.xml';
	if(!is_file($data_file)){
		file_put_contents($data_file,'<config />');
	}
	if(isset($get)){
		$xml = simplexml_load_file($data_file);
		$json  = json_encode($xml);
		$configData = json_decode($json, true);
		$data = array_merge($configData,$get);
		$xml_new = simplexml_load_string('<config />');
		create($data, $xml_new);
		file_put_contents($data_file,$xml_new->saveXML());
		return true;
	}else{
		$xml = simplexml_load_file($data_file);
		$json  = json_encode($xml);
		$configData = json_decode($json, true);
		
		return $configData;
	}
}
 
function create($ar, $xml) {
    foreach($ar as $k=>$v) {
        if(is_array($v)) {
            $x = $xml->addChild($k);
            create($v, $x);
        }else{
			$xml->addChild($k, $v);
		}
    }
}