<?php

defined('IN_IA') or die('Access Denied');
function checkstore()
{
	global $_W, $_GPC;
	$sid = intval($_GPC['sid']) ? intval($_GPC['sid']) : intval($_GPC['__mg_sid']);
	if (empty($sid)) {
		message('请先选择特定的门店', referer(), 'error');
	}
	$permiss = pdo_get('tiny_wmall_plus_clerk', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'openid' => $_W['openid']));
	if (empty($permiss)) {
		isetcookie('__mg_sid', 0, -1000);
		message('您没有该门店的管理权限', referer(), 'error');
	}
	isetcookie('__mg_sid', $sid, 86400 * 7);
	$_GPC['__mg_sid'] = $sid;
	$store = store_fetch($sid);
	$store['manager'] = pdo_get('tiny_wmall_plus_clerk', array('uniacid' => $_W['uniacid'], 'sid' => $store['id'], 'role' => 'manager'));
	$store['account'] = pdo_get('tiny_wmall_plus_store_account', array('uniacid' => $_W['uniacid'], 'sid' => $store['id']));
	if (!empty($store['account'])) {
		$store['account']['wechat'] = iunserializer($store['account']['wechat']);
	}
	$_W['we7_wmall_plus']['store'] = $store;
	return true;
}