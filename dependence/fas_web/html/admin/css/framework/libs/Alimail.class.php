<?php
class Alimail{
	private method = "POST";
	private $parameters = [];
	
	function  __construct($product, $version, $actionName)
	{
		//parent::__construct($product, $version, $actionName);
		$this->initialize();
	}
	
	private function initialize()
	{
		$this->setMethod("POST");	
		//$this->setAcceptFormat("JSON");
	}
	
	
	public function getMethod(){
		return $this->method;
	}
	public function setMethod($v){
		 $this->method = $v;
	}
	
	function publicParams(){
		$data['Format']='JSON'
		$data['Version']='2015-11-23'
		$data['Signature']= $this->computeSignature($this->getParameters(), $this->accessKeySecret);
		$data['SignatureMethod']='HMAC-SHA1'
		$data['SignatureNonce']=md5(rand(10000,99999).time());
		$data['SignatureVersion']='1.0'
		$data['AccessKeyId']='key-test'
		$data['Timestamp']='2015-11-23T12:00:00Z'
	}
	
	function httpRequest($url,$data=null){
		$uri = $url;//这里换成自己的服务器的地址
		// 参数数组
		
		$ch = curl_init ();
		// print_r($ch);
		curl_setopt ( $ch, CURLOPT_URL, $uri );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );	
		if($data != null){
			curl_setopt ( $ch, CURLOPT_POST, 1 );
			curl_setopt ( $ch, CURLOPT_POSTFIELDS, $data );
		}
		$return = curl_exec ( $ch );
		curl_close ( $ch );
	}
	protected function percentEncode($str)
	{
		$res = urlencode($str);
		$res = preg_replace('/\+/', '%20', $res);
		$res = preg_replace('/\*/', '%2A', $res);
		$res = preg_replace('/%7E/', '~', $res);
		 return $res;
	}

	private function computeSignature($parameters, $accessKeySecret)
		{
			ksort($parameters);
			$canonicalizedQueryString = '';
			foreach($parameters as $key => $value)
			{
				$canonicalizedQueryString .= '&' . $this->percentEncode($key). '=' . $this->percentEncode($value);
			}	
			$stringToSign = $this->getMethod().'&%2F&' . $this->percentencode(substr($canonicalizedQueryString, 1));
			$signature = $this->signString($stringToSign, $accessKeySecret."&");

			return $signature;
		}
	public function signString($source, $accessSecret)
	{
		return	base64_encode(hash_hmac('sha1', $source, $accessSecret, true));
	}
}