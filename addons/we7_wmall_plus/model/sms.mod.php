<?php


defined('IN_IA') or die('Access Denied');
load()->func('communication');
function sms_send($type, $mobile, $content, $sid = 0)
{
	global $_W;
	if (!is_array($_W['we7_wmall_plus']['config']['sms']) || !$_W['we7_wmall_plus']['config']['sms']['status']) {
		return error(-1, '没有设置短信参数或已关闭短信功能');
	}
	$post = array('method' => 'alibaba.aliqin.fc.sms.num.send', 'app_key' => $_W['we7_wmall_plus']['config']['sms']['key'], 'timestamp' => date('Y-m-d H:i:s'), 'format' => 'json', 'v' => '2.0', 'sign_method' => 'md5', 'sms_type' => 'normal', 'sms_free_sign_name' => $_W['we7_wmall_plus']['config']['sms']['sign'], 'rec_num' => $mobile, 'sms_template_code' => $_W['we7_wmall_plus']['config']['sms'][$type], 'sms_param' => json_encode($content));
	ksort($post);
	$str = '';
	foreach ($post as $key => $val) {
		$str .= $key . $val;
	}
	$secret = $_W['we7_wmall_plus']['config']['sms']['secret'];
	$post['sign'] = strtoupper(md5($secret . $str . $secret));
	$query = '';
	foreach ($post as $key => $val) {
		$query .= "{$key}=" . urlencode($val) . "&";
	}
	$query = substr($query, 0, -1);
	$url = 'http://gw.api.taobao.com/router/rest?' . $query;
	$result = ihttp_get($url);
	if (is_error($result)) {
		return $result;
	}
	$result = @json_decode($result['content'], true);
	if (!empty($result['error_response'])) {
		if (isset($result['error_response']['sub_code'])) {
			$msg = sms_error_code($result['error_response']['sub_code']);
						if (empty($msg)) {
				$msg['msg'] = $result['error_response']['sub_msg'];
			}
		} else {
			$msg['msg'] = $result['error_response']['msg'];
		}
		return error(-1, $msg['msg']);
	}
	sms_insert_send_log($sid, $type, $mobile);
	return true;
}
function sms_singlecall($called_num, $content, $type = 'clerk')
{
	global $_W;
	$config = $_W['we7_wmall_plus']['config']['sms'];
	if (!is_array($_W['we7_wmall_plus']['config']['sms']) || !$_W['we7_wmall_plus']['config']['sms']['status']) {
		return error(-1, '没有设置短信参数或已关闭短信功能');
	}
	if (!is_array($config[$type]) || !$config[$type]['status']) {
		return error(-1, '没有开启电话通知功能');
	}
	$post = array('method' => 'alibaba.aliqin.fc.tts.num.singlecall', 'app_key' => $config['key'], 'timestamp' => date('Y-m-d H:i:s'), 'format' => 'json', 'v' => '2.0', 'sign_method' => 'md5', 'called_num' => $called_num, 'called_show_num' => $config[$type]['called_show_num'], 'tts_code' => $config[$type]['tts_code'], 'tts_param' => json_encode($content));
	ksort($post);
	$str = '';
	foreach ($post as $key => $val) {
		$str .= $key . $val;
	}
	$secret = $config['secret'];
	$post['sign'] = strtoupper(md5($secret . $str . $secret));
	$query = '';
	foreach ($post as $key => $val) {
		$query .= "{$key}=" . urlencode($val) . "&";
	}
	$query = substr($query, 0, -1);
	$url = 'http://gw.api.taobao.com/router/rest?' . $query;
	$result = ihttp_get($url);
	if (is_error($result)) {
		return $result;
	}
	$result = @json_decode($result['content'], true);
	if (!empty($result['error_response'])) {
		$msg = $result['error_response']['sub_msg'] ? $result['error_response']['sub_msg'] : $result['error_response']['msg'];
		return error(-1, $msg);
	}
	return true;
}
function sms_insert_send_log($sid, $type, $mobile)
{
	global $_W;
	pdo_query('update ' . tablename('tiny_wmall_store') . ' set sms_use_times = sms_use_times + 1 where uniacid = :uniacid and id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $sid));
	$data = array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'type' => $type, 'mobile' => $mobile, 'sendtime' => TIMESTAMP);
	pdo_insert('tiny_wmall_sms_send_log', $data);
	return true;
}
function sms_types()
{
	return array('verify_code_tpl' => '手机验证验证码');
}
function sms_error_code($code)
{
	$msgs = array('isv.OUT_OF_SERVICE' => array('msg' => '业务停机', 'handle' => '登陆www.alidayu.com充值'), 'isv.PRODUCT_UNSUBSCRIBE' => array('msg' => '产品服务未开通', 'handle' => '登陆www.alidayu.com开通相应的产品服务'), 'isv.ACCOUNT_NOT_EXISTS' => array('msg' => '账户信息不存在', 'handle' => '登陆www.alidayu.com完成入驻'), 'isv.ACCOUNT_ABNORMAL' => array('msg' => '账户信息异常', 'handle' => '联系技术支持'), 'isv.SMS_TEMPLATE_ILLEGAL' => array('msg' => '模板不合法', 'handle' => '登陆www.alidayu.com查询审核通过短信模板使用'), 'isv.SMS_SIGNATURE_ILLEGAL' => array('msg' => '签名不合法', 'handle' => '登陆www.alidayu.com查询审核通过的签名使用'), 'isv.MOBILE_NUMBER_ILLEGAL' => array('msg' => '手机号码格式错误', 'handle' => '使用合法的手机号码'), 'isv.MOBILE_COUNT_OVER_LIMIT' => array('msg' => '手机号码数量超过限制', 'handle' => '批量发送，手机号码以英文逗号分隔，不超过200个号码'), 'isv.TEMPLATE_MISSING_PARAMETERS' => array('msg' => '短信模板变量缺少参数', 'handle' => '确认短信模板中变量个数，变量名，检查传参是否遗漏'), 'isv.INVALID_PARAMETERS' => array('msg' => '参数异常', 'handle' => '检查参数是否合法'), 'isv.BUSINESS_LIMIT_CONTROL' => array('msg' => '触发业务流控限制', 'handle' => '短信验证码，使用同一个签名，对同一个手机号码发送短信验证码，允许每分钟1条，累计每小时7条。 短信通知，使用同一签名、同一模板，对同一手机号发送短信通知，允许每天50条（自然日）'), 'isv.INVALID_JSON_PARAM' => array('msg' => '触发业务流控限制', 'handle' => 'JSON参数不合法	JSON参数接受字符串值'));
	return $msgs[$code];
}