<?php
class SqlBase{

	 static function _deal(){
		 $_POST =  SqlBase::voArr(@$_POST);
		 $_GET =  SqlBase::getArr(@$_GET);
	 }
	
	static function voArr($data){
		if(is_array($data)){
			foreach($data as $key => $value){
				if(is_array($value)){
					$temp[$key] = SqlBase::voArr($value);
				}else{
					$temp[$key] = html_encode($value);
				}
			}
		}else{
			return html_encode($data);
		}
		return $temp;
	 }
	 static function getArr($data){
		if(is_array($data)){
			foreach($data as $key => $value){
				if(is_array($value)){
					$temp[$key] = SqlBase::getArr($value);
				}else{
					$temp[$key] = html_encode($value);
				}
			}
		}else{
			return html_encode($data);
		}
		return $temp;
	 }
	 
	
}