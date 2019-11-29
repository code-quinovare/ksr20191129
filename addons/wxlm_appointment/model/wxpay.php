<?php

//decode by QQ:10373458 https://www.010xr.com/
include "weixin.pay.class.php";
function sendRedPacketsToFans($wechat, $openid, $money, $send_name, $act_name, $wishing, $trade_no = '')
{
	$money = $money * 100;
	$num = 1;
	$url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack";
	$pars = array();
	$pars['wxappid'] = $wechat['appid'];
	$pars['mch_id'] = $wechat['mchid'];
	$pars['nonce_str'] = random(32);
	$pars['mch_billno'] = empty($trade_no) ? $wechat['mchid'] . date('Ymd') . rand(1000000000, 9999999999.0) : $trade_no;
	$pars['send_name'] = $send_name;
	$pars['re_openid'] = $openid;
	$pars['total_amount'] = $money;
	$pars['total_num'] = $num;
	$pars['wishing'] = $wishing;
	$pars['client_ip'] = isset($wechat['ip']) ? $wechat['ip'] : $_SERVER['SERVER_ADDR'];
	$pars['act_name'] = $act_name;
	$pars['remark'] = $act_name;
	ksort($pars, SORT_STRING);
	$string1 = '';
	foreach ($pars as $k => $v) {
		$string1 .= "{$k}={$v}&";
	}
	$string1 .= "key={$wechat['apikey']}";
	$pars['sign'] = strtoupper(md5($string1));
	$xml = array2xml($pars);
	$extras = array();
	$extras['CURLOPT_CAINFO'] = ATTACHMENT_ROOT . '/cert/rootca.pem.' . $wechat['pemname'];
	$extras['CURLOPT_SSLCERT'] = ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $wechat['pemname'];
	$extras['CURLOPT_SSLKEY'] = ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $wechat['pemname'];
	load()->func('communication');
	$procResult = null;
	$response = ihttp_request($url, $xml, $extras);
	if ($response['code'] == 200) {
		$responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
		$responseObj = (array) $responseObj;
		$return['code'] = $responseObj['return_code'];
		$return['result_code'] = $responseObj['result_code'];
		$return['err_code'] = $responseObj['err_code'];
		$return['msg'] = $responseObj['return_msg'];
		$return['trade_no'] = $pars['mch_billno'];
		return $return;
	}
}
function wxpay($money, $module, $number, $notify_url)
{
	global $_W, $_GPC;
	load()->func('tpl');
	$weixinpay = new WeiXinPay();
	$pay = getconfigbytype("type2", 'wxlm_appointment_config');
	$weixinpay->wxpay = array('appid' => $pay['appid'], 'mch_id' => $pay['mchid'], 'key' => $pay['apikey'], 'notify_url' => $notify_url);
	$openid = $_W['openid'];
	$params['out_trade_no'] = $number;
	$params['body'] = "test";
	$params['total_fee'] = $money;
	$params['trade_type'] = "JSAPI";
	$params['openid'] = $openid;
	$params['notify_url'] = $notify_url;
	$order_list['openid'] = $openid;
	$order_list['module'] = $module;
	$order_list['fee'] = $money;
	$order_list['card_fee'] = 0;
	$order_list['tid'] = $number;
	$order_list['type'] = "wechat";
	$product_id = $weixinpay->buildPayLog($order_list);
	$order = $weixinpay->buildUnifiedOrder($params);
	$jspai = $weixinpay->buildJsApiPrepayid($product_id);
	return $jspai;
}
function refund($transaction_id, $money)
{
	$url = "https://api.mch.weixin.qq.com/secapi/pay/refund";
	if (!$transaction_id) {
		message('请填写微信订单号', '', 'error');
	}
	$pay = getconfigbytype("type2", 'wxlm_appointment_config');
	$data['appid'] = $pay['appid'];
	$data['mch_id'] = $pay['mchid'];
	$data['nonce_str'] = getNonceStr();
	$data['out_refund_no'] = $transaction_id;
	$data['out_trade_no'] = $pay['mchid'] . date("YmdHis");
	$data['total_fee'] = $money * 100;
	$data['refund_fee'] = $money * 100;
	$key = $pay['apikey'];
	$data['sign'] = MakeSign($data, $key);
	$xml = ToXml($data);
	$result = postXmlCurl($xml, $url, true);
	$result = FromXml($result);
	return $result;
}
function postXmlCurl($xml, $url, $useCert = false, $second = 30)
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_TIMEOUT, $second);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
	curl_setopt($ch, CURLOPT_HEADER, FALSE);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	if ($useCert == true) {
		$pay = getconfigbytype("type2", 'wxlm_appointment_config');
		curl_setopt($ch, CURLOPT_SSLCERTTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLCERT, ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $pay['pemname']);
		curl_setopt($ch, CURLOPT_SSLKEYTYPE, 'PEM');
		curl_setopt($ch, CURLOPT_SSLKEY, ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $pay['pemname']);
	}
	curl_setopt($ch, CURLOPT_POST, TRUE);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
	$data = curl_exec($ch);
	if ($data) {
		curl_close($ch);
		return $data;
	} else {
		$error = curl_errno($ch);
		curl_close($ch);
		message("curl出错，错误码:$error");
	}
}
function getNonceStr($length = 32)
{
	$chars = "abcdefghijklmnopqrstuvwxyz0123456789";
	$str = "";
	for ($i = 0; $i < $length; $i++) {
		$str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
	}
	return $str;
}
function ToXml($data)
{
	$xml = "<xml>";
	foreach ($data as $key => $val) {
		if (is_numeric($val)) {
			$xml .= "<" . $key . ">" . $val . "</" . $key . ">";
		} else {
			$xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
		}
	}
	$xml .= "</xml>";
	return $xml;
}
function FromXml($xml)
{
	if (!$xml) {
		message('xml数据异常!');
	}
	libxml_disable_entity_loader(true);
	$result = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
	return $result;
}
function MakeSign($data, $key)
{
	ksort($data);
	$string = ToUrlParams($data);
	$string = $string . "&key=" . $key;
	$string = md5($string);
	$result = strtoupper($string);
	return $result;
}
function ToUrlParams($data)
{
	$buff = "";
	foreach ($data as $k => $v) {
		if ($k != "sign" && $v != "" && !is_array($v)) {
			$buff .= $k . "=" . $v . "&";
		}
	}
	$buff = trim($buff, "&");
	return $buff;
}