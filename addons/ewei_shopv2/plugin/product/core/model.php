<?php

if (!defined('IN_IA')) {
	exit('Access Denied');
}

if (!class_exists('AgentModel')) {
	class ProductModel extends PluginModel
	{
		public function checkProject($project_num)	//$project_num为产品注册码即16位的数字
		{
	        libxml_disable_entity_loader(false);
			$client = new SoapClient('http://digitcode.yesno.com.cn/CCNOutService/OutDigitCodeService.asmx?wsdl');
	        $client->soap_defencoding = 'UTF-8';
	        // 参数转为数组形式传递
	        $aryPara = array(
	            'userID' => 'b6cf5d36063e44b2aa1a7d33599a1b3e',
	            'userPwd' => '50e374505e31470dad4455951ea42066',
	            'ip' => getip(),	//当前客户端ip
	            'acCode' => $project_num,
	            'language' => '1',
	            'channel' => 'X'
	        );
	        // 调用远程函数
	        $result =  $client->Get_AcCodeInfoInterface($aryPara);
	        return $result;
		}
	}
}

?>
