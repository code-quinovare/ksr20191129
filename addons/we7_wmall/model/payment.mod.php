<?php
defined('IN_IA') || exit('Access Denied');
function alipay_build($params, $alipay = array()) 
{
	global $_W;
	$config_paycallback = $_W['we7_wmall']['config']['paycallback'];
	$notify_use_http = intval($config_paycallback['notify_use_http']);
	load()->func('communication');
	$tid = $params['uniontid'];
	$set = array();
	$set['service'] = 'alipay.wap.create.direct.pay.by.user';
	$set['partner'] = $alipay['partner'];
	$set['_input_charset'] = 'utf-8';
	$set['sign_type'] = 'MD5';
	$set['notify_url'] = ((WE7_WMALL_ISHTTPS && $notify_use_http ? WE7_WMALL_URL_NOHTTPS : WE7_WMALL_URL)) . 'payment/alipay/notify.php';
	$set['return_url'] = WE7_WMALL_URL . 'payment/alipay/return.php';
	$set['out_trade_no'] = $tid;
	$set['subject'] = $params['title'];
	$set['total_fee'] = $params['fee'];
	$set['seller_id'] = $alipay['account'];
	$set['payment_type'] = 1;
	$set['body'] = $_W['uniacid'];
	$prepares = array();
	foreach ($set as $key => $value ) 
	{
		if (($key != 'sign') && ($key != 'sign_type')) 
		{
			$prepares[] = $key . '=' . $value;
		}
	}
	sort($prepares);
	$string = implode('&', $prepares);
	$string .= $alipay['secret'];
	$set['sign'] = md5($string);
	$response = ihttp_request('https://mapi.alipay.com/gateway.do?' . http_build_query($set, '', '&'), array(), array('CURLOPT_FOLLOWLOCATION' => 0));
	if (empty($response['headers']['Location'])) 
	{
		return error(-1, '生成url错误');
	}
	return array('url' => $response['headers']['Location']);
}
function wechat_build($params, $wechat) 
{
	global $_W;
	$config_paycallback = $_W['we7_wmall']['config']['paycallback'];
	$notify_use_http = intval($config_paycallback['notify_use_http']);
	load()->func('communication');
	if (empty($wechat['version']) && !(empty($wechat['signkey']))) 
	{
		$wechat['version'] = 1;
	}
	if (empty($wechat['channel'])) 
	{
		$wechat['channel'] = 'wap';
	}
	$wOpt = array();
	if ($wechat['version'] == 1) 
	{
		$wOpt['appId'] = $wechat['appid'];
		$wOpt['timeStamp'] = strval(TIMESTAMP);
		$wOpt['nonceStr'] = random(8);
		$package = array();
		$package['bank_type'] = 'WX';
		$package['body'] = $params['title'];
		$package['attach'] = $_W['uniacid'] . ':' . $wechat['channel'];
		$package['partner'] = $wechat['partner'];
		$package['out_trade_no'] = $params['uniontid'];
		$package['total_fee'] = $params['fee'] * 100;
		$package['fee_type'] = '1';
		$package['notify_url'] = ((WE7_WMALL_ISHTTPS && $notify_use_http ? WE7_WMALL_URL_NOHTTPS : WE7_WMALL_URL)) . 'payment/wechat/notify.php';
		$package['spbill_create_ip'] = CLIENT_IP;
		$package['time_start'] = date('YmdHis', TIMESTAMP);
		$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
		$package['input_charset'] = 'UTF-8';
		if (!(empty($wechat['sub_appid']))) 
		{
			$package['sub_appid'] = $wechat['sub_appid'];
		}
		if (!(empty($wechat['sub_mch_id']))) 
		{
			$package['sub_mch_id'] = $wechat['sub_mch_id'];
		}
		ksort($package);
		$string1 = '';
		foreach ($package as $key => $v ) 
		{
			if (empty($v)) 
			{
				continue;
			}
			$string1 .= $key . '=' . $v . '&';
		}
		$string1 .= 'key=' . $wechat['key'];
		$sign = strtoupper(md5($string1));
		$string2 = '';
		foreach ($package as $key => $v ) 
		{
			$v = urlencode($v);
			$string2 .= $key . '=' . $v . '&';
		}
		$string2 .= 'sign=' . $sign;
		$wOpt['package'] = $string2;
		$string = '';
		$keys = array('appId', 'timeStamp', 'nonceStr', 'package', 'appKey');
		sort($keys);
		foreach ($keys as $key ) 
		{
			$v = $wOpt[$key];
			if ($key == 'appKey') 
			{
				$v = $wechat['signkey'];
			}
			$key = strtolower($key);
			$string .= $key . '=' . $v . '&';
		}
		$string = rtrim($string, '&');
		$wOpt['signType'] = 'SHA1';
		$wOpt['paySign'] = sha1($string);
		return $wOpt;
	}
	$package = array();
	$package['appid'] = $wechat['appid'];
	$package['mch_id'] = $wechat['mchid'];
	$package['nonce_str'] = random(8);
	$package['body'] = cutstr($params['title'], 26);
	$package['attach'] = $_W['uniacid'] . ':' . $wechat['channel'];
	$package['out_trade_no'] = $params['uniontid'];
	$package['total_fee'] = $params['fee'] * 100;
	$package['spbill_create_ip'] = CLIENT_IP;
	$package['time_start'] = date('YmdHis', TIMESTAMP);
	$package['time_expire'] = date('YmdHis', TIMESTAMP + 600);
	$package['notify_url'] = ((WE7_WMALL_ISHTTPS && $notify_use_http ? WE7_WMALL_URL_NOHTTPS : WE7_WMALL_URL)) . 'payment/wechat/notify.php';
	$package['trade_type'] = (($wechat['trade_type'] ? $wechat['trade_type'] : 'JSAPI'));
	$package['openid'] = ((empty($wechat['openid']) ? $_W['fans']['from_user'] : $wechat['openid']));
	if (!(empty($wechat['sub_appid']))) 
	{
		$package['sub_appid'] = $wechat['sub_appid'];
	}
	if (!(empty($wechat['sub_mch_id']))) 
	{
		$package['sub_mch_id'] = $wechat['sub_mch_id'];
	}
	if ($package['trade_type'] == 'MWEB') 
	{
		$package['scene_info'] = json_encode(array( 'h5_info' => array('type' => 'Wap', 'wap_url' => $_W['siteroot'], 'wap_name' => $_W['we7_wmall']['config']['mall']['title']) ));
	}
	ksort($package, SORT_STRING);
	$string1 = '';
	foreach ($package as $key => $v ) 
	{
		if (empty($v)) 
		{
			continue;
		}
		$string1 .= $key . '=' . $v . '&';
	}
	$string1 .= 'key=' . $wechat['apikey'];
	$package['sign'] = strtoupper(md5($string1));
	$dat = array2xml($package);
	$response = ihttp_request('https://api.mch.weixin.qq.com/pay/unifiedorder', $dat);
	if (is_error($response)) 
	{
		return $response;
	}
	$xml = @isimplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
	if (strval($xml->return_code) == 'FAIL') 
	{
		return error(-1, strval($xml->return_msg));
	}
	if (strval($xml->result_code) == 'FAIL') 
	{
		return error(-1, strval($xml->err_code) . ': ' . strval($xml->err_code_des));
	}
	$prepayid = $xml->prepay_id;
	$wOpt['appId'] = $wechat['appid'];
	$wOpt['timeStamp'] = strval(TIMESTAMP);
	$wOpt['nonceStr'] = random(8);
	$wOpt['package'] = 'prepay_id=' . $prepayid;
	$wOpt['signType'] = 'MD5';
	ksort($wOpt, SORT_STRING);
	foreach ($wOpt as $key => $v ) 
	{
		$string .= $key . '=' . $v . '&';
	}
	$string .= 'key=' . $wechat['apikey'];
	$wOpt['paySign'] = strtoupper(md5($string));
	if ($wechat['channel'] == 'wxapp') 
	{
		$paylog = pdo_get('tiny_wmall_paylog', array('uniacid' => $_W['uniacid'], 'order_sn' => $params['tid']));
		if (!(empty($paylog))) 
		{
			$data = iunserializer($paylog['data']);
			$data['prepay_id'] = $prepayid;
			pdo_update('tiny_wmall_paylog', array('data' => iserializer($data)), array('id' => $paylog['id']));
		}
	}
	if ($package['trade_type'] == 'MWEB') 
	{
		$mweb_url = $xml->mweb_url;
		$wOpt['mweb_url'] = $mweb_url;
	}
	return $wOpt;
}
function yimafu_build($params, $yimafu) 
{
	global $_W;
	load()->func('communication');
	$package = array('selfOrdernum' => $params['uniontid'], 'money' => $params['fee'], 'openId' => $params['openid'], 'customerId' => $yimafu['mchid'], 'notifyUrl' => base64_encode(urlencode(WE7_WMALL_URL . 'payment/yimafu/notify.php?uniacid=' . $_W['uniacid'])), 'successUrl' => base64_encode(urlencode($params['url_detail'])), 'uid' => 'we7_wmall', 'goodsName' => cutstr($params['title'], 26), 'remark' => $_W['uniacid'] . ':wap');
	ksort($package);
	$str = '';
	foreach ($package as $key => $val ) 
	{
		$str .= $key . '=' . $val . '&';
	}
	$str = substr($str, 0, -1);
	$str = $yimafu['secret'] . $str;
	$sign = strtoupper(md5($str));
	$package['sign'] = $sign;
	$query = '';
	foreach ($package as $k => $v ) 
	{
		$query .= $k . '/' . $v . '/';
	}
	$query = substr($query, 0, -1);
	$url = $yimafu['host'] . '/index.php?s=/Home/linenew/m_pay/' . $query;
	return $url;
}
?>