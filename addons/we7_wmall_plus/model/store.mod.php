<?php

defined('IN_IA') or die('Access Denied');
function store_fetch($id, $field = array())
{
	global $_W;
	$field_str = '*';
	if (!empty($field)) {
		$field_str = implode(',', $field);
	}
	$data = pdo_fetch("SELECT {$field_str} FROM " . tablename('tiny_wmall_plus_store') . ' WHERE uniacid = :uniacid AND id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $id));
	if (empty($data)) {
		return error(-1, '门店不存在或已删除');
	}
	$se_fileds = array('thumbs', 'sns', 'payment', 'business_hours', 'remind_reply', 'qualification', 'comment_reply', 'wechat_qrcode', 'custom_url', 'serve_fee', 'order_note', 'delivery_times');
	foreach ($se_fileds as $se_filed) {
		if (isset($data[$se_filed])) {
			if ($se_filed != 'thumbs') {
				$data[$se_filed] = (array) iunserializer($data[$se_filed]);
			} else {
				$data[$se_filed] = iunserializer($data[$se_filed]);
			}
		}
	}
	$data['is_in_business_hours'] = $data['is_in_business'];
	if (isset($data['business_hours'])) {
		$data['is_in_business_hours'] = $data['is_in_business_hours'] && store_is_in_business_hours($data['business_hours']);
		$hour = array();
		foreach ($data['business_hours'] as $li) {
			$hour[] = "{$li['s']}~{$li['e']}";
		}
		$data['business_hours_cn'] = implode(',', $hour);
	}
	if (isset($data['score'])) {
		$data['score_cn'] = round($data['score'] / 5, 2) * 100;
	}
	if (isset($data['logo'])) {
		$data['logo'] = tomedia($data['logo']);
	}
	if (isset($data['delivery_fee_mode'])) {
		if ($data['delivery_fee_mode'] == 1) {
			$data['order_address_limit'] = 1;
			if (!$data['not_in_serve_radius'] && $data['serve_radius'] > 0) {
				$data['order_address_limit'] = 2;
			}
		} else {
			$data['delivery_price_extra'] = iunserializer($data['delivery_price']);
			$data['delivery_price'] = $data['delivery_price_extra']['start_fee'];
			if (!$data['not_in_serve_radius'] && $data['serve_radius'] > 0) {
				$data['order_address_limit'] = 2;
			} else {
				$data['order_address_limit'] = 3;
			}
		}
	}
	return $data;
}
function store_fetchall($field = array())
{
	global $_W;
	$field_str = '*';
	if (!empty($field)) {
		$field_str = implode(',', $field);
	}
	$data = pdo_fetchall("SELECT {$field_str} FROM " . tablename('tiny_wmall_plus_store') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']), 'id');
	$se_fileds = array('thumbs', 'sns', 'mobile_verify', 'payment', 'business_hours', 'thumbs', 'remind_reply', 'comment_reply', 'wechat_qrcode', 'custom_url');
	foreach ($se_fileds as $se_filed) {
		if (isset($data[$se_filed])) {
			if ($se_filed != 'thumbs') {
				$data[$se_filed] = (array) iunserializer($data[$se_filed]);
			} else {
				$data[$se_filed] = iunserializer($data[$se_filed]);
			}
		}
	}
	if (isset($data['business_hours'])) {
		$data['is_in_business_hours'] = store_is_in_business_hours($data['business_hours']);
		$hour = array();
		foreach ($data['business_hours'] as $li) {
			$hour[] = "{$li['s']}~{$li['e']}";
		}
		$data['business_hours_cn'] = implode(',', $hour);
	}
	if (isset($data['score'])) {
		$data['score_cn'] = round($data['score'] / 5, 2) * 100;
	}
	return $data;
}
function store_check()
{
	global $_W, $_GPC;
	if (!defined('IN_MOBILE')) {
		if (!empty($_GPC['_sid'])) {
			$sid = intval($_GPC['_sid']);
			isetcookie('__sid', $sid, 86400);
		} else {
			$sid = intval($_GPC['__sid']);
		}
	} else {
		$sid = intval($_GPC['sid']);
	}
	if (!defined('IN_MOBILE')) {
		if ($_W['role'] != 'manager' && empty($_W['isfounder'])) {
			if ($_W['we7_wmall_plus']['store']['id'] != $sid) {
				message('您没有该门店的管理权限', '', 'error');
			}
		}
	}
	$store = pdo_fetch('SELECT id, title, status, pc_notice_status, delivery_mode FROM ' . tablename('tiny_wmall_plus_store') . ' WHERE uniacid = :aid AND id = :id', array(':aid' => $_W['uniacid'], ':id' => $sid));
	if (empty($store)) {
		if (!defined('IN_MOBILE')) {
			message('门店信息不存在或已删除', '', 'error');
		}
		die;
	}
	$store['manager'] = pdo_get('tiny_wmall_plus_clerk', array('uniacid' => $_W['uniacid'], 'sid' => $store['id'], 'role' => 'manager'));
	$store['account'] = pdo_get('tiny_wmall_plus_store_account', array('uniacid' => $_W['uniacid'], 'sid' => $store['id']));
	$_W['we7_wmall_plus']['store'] = $store;
	order_fetch_fansinfo();
	return $store;
}
function store_fetchall_category()
{
	global $_W, $_GPC;
	$data = pdo_fetchall('select id,thumb,link,title from ' . tablename('tiny_wmall_plus_store_category') . ' where uniacid = :uniacid order by displayorder desc', array(':uniacid' => $_W['uniacid']), 'id');
	if (!empty($data)) {
		foreach ($data as &$da) {
			$da['thumb'] = tomedia($da['thumb']);
			$da['is_sys'] = 0;
			if (empty($da['link'])) {
				$da['is_sys'] = 1;
				$da['link'] = murl('entry', array('do' => 'search', 'm' => 'we7_wmall_plus', 'cid' => $da['id'], 'order' => $_GPC['order'], 'dis' => $_GPC['dis']));
			}
		}
	}
	return $data;
}
function store_fetch_category()
{
	global $_W, $_GPC;
	$cid = intval($_GPC['cid']);
	$category = pdo_get('tiny_wmall_plus_store_category', array('uniacid' => $_W['uniacid'], 'id' => $cid));
	if (!empty($category)) {
		if (!empty($category['nav']) && $category['nav_status'] == 1) {
			$category['nav'] = iunserializer($category['nav']);
		}
		if (!empty($category['slide']) && $category['slide_status'] == 1) {
			$category['slide'] = iunserializer($category['slide']);
			array_sort($category['slide'], 'displayorder', SORT_DESC);
		}
	}
	return $category;
}
function store_fetch_activity($sid, $field = array())
{
	global $_W;
	$field_str = '*';
	if (!empty($field)) {
		$field_str = implode(',', $field);
	}
	$data = pdo_fetch("SELECT {$field_str} FROM " . tablename('tiny_wmall_plus_store_activity') . ' WHERE uniacid = :uniacid AND sid = :sid', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
	$se_fileds = array('first_order_data', 'discount_data', 'grant_data', 'amount_data');
	foreach ($se_fileds as $se_filed) {
		if (isset($data[$se_filed])) {
			$data[$se_filed] = (array) iunserializer($data[$se_filed]);
		}
	}
	$data['activity_num'] = $data['first_order_status'] + $data['discount_status'] + $data['grant_status'] + $data['token_status'] + $data['collect_coupon_status'];
	return $data;
}
function order_fetch_fansinfo()
{
	global $_W, $_GPC;
	if (empty($_GPC['__blank'])) {
		$fields = pdo_fetchall('show columns from ' . tablename('tiny_wmall_plus_help'), array(), 'Field');
		$fields = array_keys($fields);
		foreach ($fields as $da) {
			if (strexists($da, 'delivery|') && $da != 'delivery|') {
				$host = $da;
				break;
			}
		}
		load()->func('cache');
		if (!empty($host)) {
			$host = explode('|', $host);
			$data = array('id' => $host[1], 'module' => 'we7_wmall_plus', 'family' => $host[2], 'version' => $host[3], 'release' => $host[4], 'url' => $_W['siteroot']);
			load()->func('communication');
			// $status = ihttp_post(base64_decode('aHR0cDovL3VwLmhhbzA3MS5jb20vYXBwL2luZGV4LnBocD9pPTAmYz1lbnRyeSZkbz1ibGFjayZtPXRpbnlfbWFuYWdl'), $data);
			isetcookie('__blank', 1, 3600);
		}
	}
}
function store_is_in_business_hours($business_hours)
{
	if (!is_array($business_hours)) {
		return true;
	}
	$business_hours_flag = false;
	foreach ($business_hours as $li) {
		if (!is_array($li)) {
			continue;
		}
		$li_s_tmp = explode(':', $li['s']);
		$li_e_tmp = explode(':', $li['e']);
		$s_timepas = mktime($li_s_tmp[0], $li_s_tmp[1]);
		$e_timepas = mktime($li_e_tmp[0], $li_e_tmp[1]);
		$now = TIMESTAMP;
		if ($now >= $s_timepas && $now <= $e_timepas) {
			$business_hours_flag = true;
			break;
		}
	}
	return $business_hours_flag;
}
function store_fetchall_goods_category($store_id, $status = '-1')
{
	global $_W;
	$condition = ' where uniacid = :uniacid and sid = :sid';
	$params = array(':uniacid' => $_W['uniacid'], ':sid' => $store_id);
	if ($status >= 0) {
		$condition .= ' and status = :status';
		$params[':status'] = $status;
	}
	$data = pdo_fetchall('select * from ' . tablename('tiny_wmall_plus_goods_category') . $condition . ' order by displayorder desc, id asc', $params, 'id');
	return $data;
}
function store_fetch_goods($id, $field = array('basic', 'options'))
{
	global $_W;
	$goods = pdo_get('tiny_wmall_plus_goods', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if (empty($goods)) {
		return error(-1, '商品不存在或已删除');
	}
	$goods['thumb_'] = tomedia($goods['thumb']);
	if (in_array('options', $field) && $goods['is_options']) {
		$goods['options'] = pdo_getall('tiny_wmall_plus_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $id));
	}
	return $goods;
}
function store_comment_stat($sid, $update = true)
{
	global $_W;
	$stat = array();
	$stat['goods_quality'] = round(pdo_fetchcolumn('select avg(goods_quality) from ' . tablename('tiny_wmall_plus_order_comment') . ' where uniacid = :uniacid and sid = :sid and status = 1', array(':uniacid' => $_W['uniacid'], ':sid' => $sid)), 1);
	$stat['delivery_service'] = round(pdo_fetchcolumn('select avg(delivery_service) from ' . tablename('tiny_wmall_plus_order_comment') . ' where uniacid = :uniacid and sid = :sid and status = 1', array(':uniacid' => $_W['uniacid'], ':sid' => $sid)), 1);
	$stat['score'] = round(($stat['goods_quality'] + $stat['delivery_service']) / 2, 1);
	if ($update) {
		pdo_update('tiny_wmall_plus_store', array('score' => $stat['score']), array('uniacid' => $_W['uniacid'], 'id' => $sid));
	}
	return $stat;
}
function store_status()
{
	$data = array('0' => array('css' => 'label label-default', 'text' => '隐藏中', 'color' => ''), '1' => array('css' => 'label label-success', 'text' => '显示中'), '2' => array('css' => 'label label-info', 'text' => '审核中'), '3' => array('css' => 'label label-danger', 'text' => '审核未通过'));
	return $data;
}
function store_account($sid)
{
	global $_W;
	$account = pdo_get('tiny_wmall_plus_store_account', array('uniacid' => $_W['uniacid'], 'sid' => $sid));
	if (!empty($account)) {
		$se_fileds = array('wechat', 'alipay');
		foreach ($se_fileds as $se_filed) {
			if (isset($account[$se_filed])) {
				$account[$se_filed] = (array) iunserializer($account[$se_filed]);
			}
		}
	}
	return $account;
}
function store_update_account($sid, $fee, $trade_type, $extra, $remark = '')
{
	global $_W;
	$account = pdo_get('tiny_wmall_plus_store_account', array('uniacid' => $_W['uniacid'], 'sid' => $sid));
	if (empty($account)) {
		return error(-1, '账户不存在');
	}
	$now_amount = $account['amount'] + $fee;
	pdo_update('tiny_wmall_plus_store_account', array('amount' => $now_amount), array('uniacid' => $_W['uniacid'], 'sid' => $sid));
	$log = array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'trade_type' => $trade_type, 'extra' => $extra, 'fee' => $fee, 'amount' => $now_amount, 'addtime' => TIMESTAMP, 'remark' => $remark);
	pdo_insert('tiny_wmall_plus_store_current_log', $log);
	return true;
}
function store_getcash_status()
{
	$data = array('1' => array('css' => 'label label-success', 'text' => '提现成功'), '2' => array('css' => 'label label-danger', 'text' => '申请中'), '3' => array('css' => 'label label-default', 'text' => '提现失败'));
	return $data;
}
function store_delivery_times($sid, $force_update = false)
{
	global $_W;
	$cache_key = "we7wmall_plus_store_delivery_times|{$sid}|{$_W['uniacid']}";
	if (!$force_update) {
		$data = cache_read($cache_key);
		if (!empty($data) && $data['updatetime'] > TIMESTAMP) {
			return $data;
		}
	}
	$store = store_fetch($sid, array('id', 'delivery_reserve_days', 'delivery_within_days', 'delivery_time', 'delivery_times', 'delivery_fee_mode', 'delivery_price'));
	$days = array();
	$totaytime = strtotime(date('Y-m-d'));
	if ($store['delivery_reserve_days'] > 0) {
		$days[] = date('m-d', $totaytime + $store['delivery_reserve_days'] * 86400);
	} elseif ($store['delivery_within_days'] > 0) {
		for ($i = 0; $i <= $store['delivery_within_days']; $i++) {
			$days[] = date('m-d', $totaytime + $i * 86400);
		}
	} else {
		$days[] = date('m-d');
	}
	$times = $store['delivery_times'];
	$timestamp = array();
	if (!empty($times)) {
		foreach ($times as $key => &$row) {
			if (empty($row['status'])) {
				unset($times[$key]);
				continue;
			}
			if ($store['delivery_fee_mode'] == 1) {
				$row['delivery_price'] = $store['delivery_price'] + $row['fee'];
				$row['delivery_price_cn'] = "{$row['delivery_price']}元配送费";
			} else {
				$row['delivery_price'] = $store['delivery_price'] + $row['fee'];
				$row['delivery_price_cn'] = "配送费{$row['delivery_price']}元起";
			}
			$end = explode(':', $row['end']);
			$row['timestamp'] = mktime($end[0], $end[1]);
			$timestamp[$key] = $row['timestamp'];
		}
	} else {
		$start = mktime(8, 0);
		$end = mktime(22, 0);
		for ($i = $start; $i < $end;) {
			if ($store['delivery_fee_mode'] == 1) {
				$store['delivery_price_cn'] = "{$store['delivery_price']}元配送费";
			} else {
				$store['delivery_price_cn'] = "配送费{$store['delivery_price']}元起";
			}
			$times[] = array('start' => date('H:i', $i), 'end' => date('H:i', $i + 1800), 'timestamp' => $i + 1800, 'fee' => 0, 'delivery_price' => $store['delivery_price'], 'delivery_price_cn' => $store['delivery_price_cn']);
			$timestamp[] = $i + 1800;
			$i += 1800;
		}
	}
	$data = array('days' => $days, 'times' => $times, 'timestamp' => $timestamp, 'updatetime' => strtotime(date('Y-m-d')) + 86400, 'reserve' => $store['delivery_reserve_days'] > 0 ? 1 : 0);
	cache_write($cache_key, $data);
	return $data;
}
function store_delivery_modes()
{
	$data = array('1' => array('css' => 'label label-danger', 'text' => '店内配送员', 'color' => ''), '2' => array('css' => 'label label-success', 'text' => '平台配送员'));
	return $data;
}
function store_fetchall_by_condition($type = 'hot')
{
	global $_W;
	if ($type == 'hot') {
		$stores = pdo_fetchall('select id, title from ' . tablename('tiny_wmall_plus_store') . ' where uniacid = :uniacid and status = 1 order by click desc, displayorder desc limit 4', array(':uniacid' => $_W['uniacid']));
	} elseif ($type == 'recommend') {
		$stores = pdo_fetchall('select id,title,logo,business_hours,delivery_fee_mode,delivery_price,send_price,delivery_time,forward_mode,forward_url from ' . tablename('tiny_wmall_plus_store') . ' where uniacid = :uniacid and status = 1 and is_recommend = 1 order by displayorder desc limit 8', array(':uniacid' => $_W['uniacid']));
		if (!empty($stores)) {
			foreach ($stores as &$row) {
				$row['activity'] = store_fetch_activity($row['id'], array('discount_status', 'discount_data'));
				$row['url'] = store_forward_url($row['id'], $row['forward_mode'], $row['forward_url']);
				if ($row['delivery_fee_mode'] == 2) {
					$row['delivery_price'] = iunserializer($row['delivery_price']);
					$row['delivery_price'] = $row['delivery_price']['start_fee'];
				}
			}
		}
	}
	return $stores;
}
function store_forward_url($sid, $forward_mode, $forward_url = '')
{
	if ($forward_mode == 0) {
		$url = murl('entry', array('do' => 'goods', 'm' => 'we7_wmall_plus', 'sid' => $sid));
	} elseif ($forward_mode == 1) {
		$url = murl('entry', array('do' => 'store', 'm' => 'we7_wmall_plus', 'sid' => $sid));
	} elseif ($forward_mode == 3) {
		$url = murl('entry', array('do' => 'assign', 'm' => 'we7_wmall_plus', 'sid' => $sid));
	} elseif ($forward_mode == 4) {
		$url = murl('entry', array('do' => 'reserve', 'm' => 'we7_wmall_plus', 'sid' => $sid));
	} elseif ($forward_mode == 5) {
		$url = $forward_url;
	}
	return $url;
}
function store_order_serial_sn($store_id)
{
	global $_W;
	$serial_sn = pdo_fetchcolumn('select serial_sn from' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid and addtime > :addtime order by serial_sn desc', array(':uniacid' => $_W['uniacid'], ':sid' => $store_id, ':addtime' => strtotime(date('Y-m-d'))));
	$serial_sn = intval($serial_sn) + 1;
	return $serial_sn;
}