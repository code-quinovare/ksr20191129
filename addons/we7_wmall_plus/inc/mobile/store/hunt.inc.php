<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'hunt';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';

if($op == 'index') {
	$title = "{$_W['we7_wmall_plus']['config']['title']}-热门搜索";
	$stores = store_fetchall_by_condition('hot');
	if($_W['member']['uid'] > 0) {
		mload()->model('member');
		$member = member_fetch();
	}
	include $this->template('hunt-index');
}

if($op == 'truncate') {
	if($_W['member']['uid'] > 0) {
		pdo_update('tiny_wmall_plus_members', array('search_data' => ''), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	}
	exit('success');
}

if($op == 'search_data') {
	if($_W['member']['uid'] > 0) {
		mload()->model('member');
		$key = trim($_GPC['key']);
		$member = member_fetch();
		if(!empty($member)) {
			$num = count($member['search_data']);
			if($num >= 5) {
				array_pop($member['search_data']);
			}
			array_push($member['search_data'], $key);
			$search_data = iserializer(array_unique($member['search_data']));
			pdo_update('tiny_wmall_plus_members', array('search_data' => $search_data), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
		}
	}
}

if($op == 'search') {
	$key = trim($_GPC['key']);
	$sids = array(0);
	$sids_str = 0;
	$stores = array();
	$goods = pdo_fetchall('select * from ' . tablename('tiny_wmall_plus_goods') . ' where uniacid = :uniacid and status = 1 and title like :key', array(':uniacid' => $_W['uniacid'], ':key' => "%{$key}%"));
	if(!empty($goods)) {
		$store_goods = array();
		foreach($goods as $good) {
			$sids[] = $good['sid'];
			$store_goods[$good['sid']][] = $good;
		}
		$sids_str = implode(',', $sids);
		$stores = pdo_fetchall('select id,title,logo,business_hours,delivery_fee_mode,delivery_price,send_price,delivery_time,delivery_mode,forward_mode,forward_url from ' . tablename('tiny_wmall_plus_store') . " where uniacid = :uniacid and status = 1 and id in ({$sids_str})", array(':uniacid' => $_W['uniacid']), 'id');
	}
	$search_stores = pdo_fetchall('select id,title,logo,business_hours,delivery_fee_mode,delivery_price,send_price,delivery_time,delivery_mode,forward_mode,forward_url from ' . tablename('tiny_wmall_plus_store') . " where uniacid = :uniacid and status = 1 and id not in ({$sids_str}) and title like :key", array(':uniacid' => $_W['uniacid'], ':key' => "%{$key}%"));
	$stores = array_merge($search_stores, $stores);
	foreach($stores as &$row) {
		$row['goods'] = $store_goods[$row['id']];
		$row['activity'] = store_fetch_activity($row['id'], array('discount_status', 'discount_data'));
		$row['url'] = store_forward_url($row['id'], $row['forward_mode'], $row['forward_url']);
		if($row['delivery_fee_mode'] == 2) {
			$row['delivery_price'] = iunserializer($row['delivery_price']);
			$row['delivery_price'] = $row['delivery_price']['start_fee'];
		}
	}
	$num = count($stores);
	if($num < 4) {
		$recommend_stores = store_fetchall_by_condition('recommend');
	}
	include $this->template('hunt-search');
}


