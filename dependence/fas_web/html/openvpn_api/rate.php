<?php
/*
CREATE TABLE `vpndata`.`app_bw` ( `id` INT NOT NULL AUTO_INCREMENT , `rx` INT NOT NULL COMMENT '下行宽带' , `tx` INT NOT NULL COMMENT '上行宽带' , `time` INT NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
*/

include(dirname(dirname(__FILE__))."/system.php");
if($argv[1] != "rate"){exit;}

$time = time();
$last_time = time()-70;
 
exec("ifconfig",$net);
 
 foreach($net as $line){
	 if(trim($line)==""){
		$nets[] = $netinfo;
		$netinfo = array();
	 }else{
		$netinfo[] = $line;
	 }
 }
 
$RX = 0;//下行
$TX = 0;//上行
$RX_BW = 0;//上行
$TX_BW = 0;//上行



foreach($nets as $info){
	$t = explode(":",$info[0]);
	$netname = $t[0];
	if(strpos($netname,"lo") !== 0 && strpos($netname,"tun") !== 0){
		$info = implode("\n",$info);
		preg_match("/RX\s*packets\s*([0-9]*)\s*bytes\s*([0-9]*)/",$info,$m1);
		preg_match("/TX\s*packets\s*([0-9]*)\s*bytes\s*([0-9]*)/",$info,$m2);
		$RX = $m1[2];
		$TX = $m2[2];
	}
}
$db = db("app_bw");
$last = $db->where("time > :time",[":time"=>$last_time])->order("id DESC")->limit(1)->find();
if($last){
	$RX_BW = ($RX-$last["rx"])/60;
	$TX_BW = ($TX-$last["tx"])/60;
}
$db->insert(["time"=>$time,"tx"=>$TX,"rx"=>$RX,"tx_bw"=>$TX_BW,"rx_bw"=>$RX_BW]);