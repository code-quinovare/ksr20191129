<?php
/**
 * 外送系统
 * @author 说图谱网
 * @url http://www.shuotupu.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
icheckauth();

if($_config_wxapp['diy']['use_diy_member'] != 1) {
	$user = $_W['member'];
	$user['avatar'] = tomedia($user['avatar']);
	$user['nickname'] = $_W['member']['nickname'];
	$user['avatar'] = $_W['member']['avatar'];

	$config_settle = $_W['we7_wmall']['config']['store']['settle'];
	$config_mall = $_W['we7_wmall']['config']['mall'];
	$config_delivery = $_W['we7_wmall']['config']['delivery'];
	$favorite = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_store_favorite') . ' where uniacid = :uniacid and uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'])));
	$coupon_nums = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_activity_coupon_record') . ' where uniacid = :uniacid and uid = :uid and status = 1', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'])));
	$redpacket_nums = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_activity_redpacket_record') . ' where uniacid = :uniacid and uid = :uid and status = 1', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'])));

	$deliveryCard_status = check_plugin_perm('deliveryCard') && get_plugin_config('deliveryCard.card_apply_status');
	$deliveryCard_setmeal_ok = 0;
	if($deliveryCard_status && $user['setmeal_id'] > 0 && $user['setmeal_endtime'] > TIMESTAMP) {
		$deliveryCard_setmeal_ok = 1;
	}
	$redpacket_status = check_plugin_perm('shareRedpacket') || check_plugin_perm('freeLunch') || check_plugin_perm('superRedpacket');

	if(check_plugin_perm('spread')) {
		$config_spread = get_plugin_config('spread.basic');
		if($config_spread['show_in_mine']) {
			$spread = array(
				'status' => 1,
				'title' => $config_spread['menu_name']
			);
		}
	}
	if(check_plugin_perm('ordergrant') && get_plugin_config('ordergrant.status')) {
		$ordergrant = 1;
	} else {
		$ordergrant = 0;
	}
	$slides = sys_fetch_slide('member', true);
	if(empty($slides)){
		$slides = false;
	}

	$result = array(
		'config' => $_W['we7_wmall']['config'],
		'redpacket_nums' => $redpacket_nums,
		'coupon_nums' => $coupon_nums,
		'credit2' => floatval($user['credit2']),
		'credit1' => floatval($user['credit1']),
		'user' => $user,
		'deliveryCard_status' => $deliveryCard_status,
		'deliveryCard_setmeal_ok' => $deliveryCard_setmeal_ok,
		'spread' => $spread,
		'ordergrant' => $ordergrant,
		'slides' => $slides
	);
} else {
	//使用自定义会员中心
	$id = $_config_wxapp['diy']['shopPage']['member'];
	if(empty($id)) {
		imessage(error(-1, '未设置会员中心DIY页面'), '', 'ajax');
	}
	mload()->model('diy');
	$page = get_wxapp_diy($id, true, array('from' => 'wap'));
	if(empty($page)) {
		imessage(error(-1,'页面不能为空'), '', 'ajax');
	}
	$result = array(
		'is_use_diy' => 1,
		'diy' => $page,
	);
}

imessage(error(0, $result), '', 'ajax');



