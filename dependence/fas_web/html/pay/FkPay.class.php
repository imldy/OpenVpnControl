<?php
class FkPay{
	
	private $app_id  =   '201709251706581009';       //app_id
	private $app_key  =   '$2y$10$fbCfUYr6WazFqDJJOP2HHu3TWRLhGQne33JKvRrjAKHRhc2WtNJ26'; //app_key
	private $params      =   [];
	private $method      =   '';
	
	function __construct() {
		$m = new Map();
		$this->app_id = $m->type("cfg_pay")->getValue("app_id");
		$this->app_key = $m->type("cfg_pay")->getValue("app_key");
	}
	public function setParams($params = [])
	{
		$this->params = $params;
	}

	
	public function method($method = '')
	{
		$this->method = $method;
	}
	
	public function query($no = '')
	{
		if(!$no == ''){
			$this->params['out_trade_no'] = $no;
		}
		return $this->respone();
	}
	
	
	public function pay()
	{
		$res = $this->respone();
		return $res;
	}
	
	/*
	* 发送请求到支付接口
	*/
	public function respone(){
		$url = 'https://api.fakajun.com/gateway.do';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($this->buildPayQuery()));
		$res = curl_exec($ch);
		//var_dump($this->buildPayQuery());
		$respone = json_decode($res, true);
		return $respone;
	}
	
	/*
	*	构建查询参数
	*/
	private function buildPayQuery(){
		$params['app_id']    =   $this->app_id;
		$params['method']    =   $this->method;
		$params['timestamp'] =   date('Y-m-d H:i:s'); //随即字符串（时间戳）
		if($this->params){
			$params['biz_content'] = json_encode($this->params);
		}
		$params['sign'] = $this->sign($params);
		return $params;
	}
	
	/*
	*	签名
	*/
	public function sign($params)
	{
		
		$para_filter = [];
		foreach($params as $key=>$val){
			if($key == "sign" || $key == "sign_type" || $val == "")
				continue;
			else
				$para_filter[$key] = $params[$key];
		}
		ksort($para_filter);
		reset($para_filter);
		$arg = urldecode(http_build_query($para_filter));
		
		//如果存在转义字符，那么去掉转义
		if(get_magic_quotes_gpc()){
			$arg = stripslashes($arg);
		}
		//echo $arg;
		$string = $arg . $this->app_key;

		// md5签名
		return strtoupper(md5($string));
		
	}
	
}

function pay(){
	return new FkPay();
}
