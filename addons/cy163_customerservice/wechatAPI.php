<?php
class wechatAPI{
	public function isValid($token)//验证微信接口，如果确认是微信就返回它传来的echostr参数
	{
		 $echoStr = $_GET["echostr"];
		 if ($this->checkSignature($token)) {
			echo $echoStr;
			exit;
		 }
	}
	
	
	private function checkSignature($token) //官方的验证函数
	{
		 $signature = $_GET["signature"];
		 $timestamp = $_GET["timestamp"];
		 $nonce = $_GET["nonce"];
		 $tmpArr = array($token, $timestamp, $nonce);
		 sort($tmpArr, SORT_STRING);
		 $tmpStr = implode( $tmpArr );
		 $tmpStr = sha1( $tmpStr );
		 if( $tmpStr == $signature ){
			return true;
		 }else{
			return false;
		 }
	}
	
};
?>