<?php require("system.php");?>
<?php $act = $_GET["act"];
if($act == "bw"){

	$json = file_get_contents("/etc/rate.d/minute.json");
	//die($json);
	$data = json_decode($json,true);
	//die(json_encode($t));
	//var_dump($data);
	echo "[";
	foreach($data as $key=>$vo){
		$bw = $vo["tx"]*8/1024/1024;
		$datas[] = '{ "name": "'.$key.'", "value": "'.round($bw,3).'" }';
	}
	$dataNums = count($datas);
	if($dataNums < 30){
		for($i=0;$i<30-$dataNums;$i++){
			$datasf[] = '{ "name": "0:0", "value": "0" }';
		}
		echo implode(",",$datasf);
		echo ",";
	}
	echo implode(",",$datas);
	echo "]";
}elseif($act == "bwi"){
	if(is_file("/etc/rate.d/minute.json")){
		$json = file_get_contents("/etc/rate.d/minute.json");
		$data = json_decode($json,true);
		$dataNums = count($data);
		if($dataNums > 0){
			foreach($data as $key=>$vo){
				$bw = $vo["tx"]*8/1024/1024;
			}
			die(round($bw,3));
		}			
	}
	
	die("0");
}elseif($act == "bwh"){

	if(is_file("/etc/rate.d/hour.json")){
		$json = file_get_contents("/etc/rate.d/hour.json");
		//die($json);
		$data = json_decode($json,true);
		//die(json_encode($t));
		//var_dump($data);
		echo "[";
		foreach($data as $key=>$vo){
			$bw = $vo["tx"]*8/1024/1024;
			$datas[] = '{ "name": "'.$key.':00", "value": "'.round($bw,3).'" }';
		}
		echo implode(",",$datas);
		echo "]";
	}else{
		echo "[";
		for($i=1;$i<=24;$i++){
			$datas[] = '{ "name": "'.$i.':00", "value": "0" }';
		}
		echo implode(",",$datas);
		echo "]";
	}
}else{
?>
[
	<?php  
		$temp_date = date("Y-m-d 0:0:0",time());
		$now = strtotime($temp_date); 
		for($i=0;$i<15;$i++){
			$t = $now-((14-$i)*24*60*60);
			$p = date("Y-m-d",$t);
			
			$rs=db("top")->where(array("time"=>$p))->select();
			
			if($rs){
				$value = 0;
				foreach($rs as $res){
					
					$value += $res['data'] / 1024 / 1024 / 1024;
				}
				
				$data[] = '{ "name": "'.date("d",$t).'日", "value": "'.round($value,3).'" }';
			}else{
				$data[] = '{ "name": "'.date("d",$t).'日", "value": "0" }';
			}
			
		}
		echo implode(",",$data);
?>]<?php } ?>