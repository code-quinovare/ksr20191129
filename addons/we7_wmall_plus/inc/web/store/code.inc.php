<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'code';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';

$sid = intval($_GPC['sid']);
$mobile = trim($_GPC['mobile']);
if($mobile == ''){
	exit('请输入邮箱或手机号');
}

if(!preg_match(REGULAR_MOBILE, $mobile)) {
	exit('手机号格式错误');
}

$sql = 'DELETE FROM ' . tablename('uni_verifycode') . ' WHERE `createtime`<' . (TIMESTAMP - 1800);
pdo_query($sql);

$sql = 'SELECT * FROM ' . tablename('uni_verifycode') . ' WHERE `receiver`=:receiver AND `uniacid`=:uniacid';
$pars = array();
$pars[':receiver'] = $mobile;
$pars[':uniacid'] = $_W['uniacid'];
$row = pdo_fetch($sql, $pars);
$record = array();
if(!empty($row)) {
	if($row['total'] >= 5) {
		exit('您的操作过于频繁,请稍后再试');
	}
	$code = $row['verifycode'];
	$record['total'] = $row['total'] + 1;
} else {
	$code = random(6, true);
	$record['uniacid'] = $_W['uniacid'];
	$record['receiver'] = $mobile;
	$record['verifycode'] = $code;
	$record['total'] = 1;
	$record['createtime'] = TIMESTAMP;
}
if(!empty($row)) {
	pdo_update('uni_verifycode', $record, array('id' => $row['id']));
} else {
	pdo_insert('uni_verifycode', $record);
}
$config_sms = $_W['we7_wmall_plus']['config']['sms'];
$result = sms_send($config_sms['verify_code_tpl'], $mobile, array('code' => $code, 'product' => $_W['account']['name']));
if(is_error($result)) {
	exit('短信发送失败,请联系商户处理');
}
exit('success');