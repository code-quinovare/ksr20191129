<?php
/**
 * 短信发送
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */


$mobile = trim($_GPC['mobile']);
if(!(preg_match("/1\d{10}/",$mobile))){
	$data = array(
		'code' => -1,
		'msg'  => '手机号码有误'
	);
    $this->resultJson($data);
}


$sms = json_decode($setting['dayu_sms'], true);
$param['code'] = strval(rand(1234,9999));

session_start();
$_SESSION['mobile_code'] = $param['code'];

$output = $this->sendSMS($sms, $mobile, $sms['verify_code'], $param);
$result = json_decode(json_encode($output), true);

if($sms['versions']==0 && $result['code']){
	$data = array(
		'code' => -1,
		'msg'  => $result['sub_msg'],
		
	);
	$this->resultJson($data);
}

if($sms['versions']==1 && $result['Code']!='OK'){
	$data = array(
		'code' => -1,
		'msg'  => $result['Message'],
		
	);
	$this->resultJson($data);
}

$data = array(
	'code' => 0,
	'msg'  => '验证码发送成功',
	'result' => $result
);
$this->resultJson($data);