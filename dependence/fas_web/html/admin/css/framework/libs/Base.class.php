<?php
namespace framework\libs;
class Base{

	 static function _deal(){
		 $_POST =  self::voArr($_POST);
		 $_GET =  self::getArr($_GET);
	 }
	
	static function voArr($data){
		$temp = null;
		if(is_array($data)){
			foreach($data as $key => $value){
				if(is_array($value)){
					$temp[$key] = self::voArr($value);
				}else{
					$temp[$key] = self::baseCode(html_encode($value));
				}
			}
		}else{
			return self::baseCode(html_encode($data));
		}
		return $temp;
	 }
	 static function getArr($data){
		 $temp = null;
		if(is_array($data)){
			foreach($data as $key => $value){
				if(is_array($value)){
					$temp[$key] = self::getArr($value);
				}else{
					$temp[$key] = self::baseGET(html_encode($value));
				}
			}
		}else{
			return self::baseGET(html_encode($data));
		}
		return $temp;
	 }
	 
	 static function baseCode($str){
		 $old = array(
			"/and/i",
			"/union/i",
			"/from/i",
			"/select/i",
			"/delete/i",
			"/insert/i",
			"/updata/i"
		 );
		 $new = array(
			'an\d',
			'un\ion',
			'fr\om',
			'sel\ect',
			'del\ete',
			'ins\ert',
			'upd\ate"'
		 );
		 
		 $str = preg_replace($old,$new,$str);
		 return $str;
	 }
	 static function baseGET($str){
		 if(preg_match('/and|select|updata|insert|union/i',$str,$m)){
			die('<b>您的地址包含非法字符[<a href="/">Go to website home page!</a>]</b>');
			//return true;
		 };
		 return $str;
	 }
}