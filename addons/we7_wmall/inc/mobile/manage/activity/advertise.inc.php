<?php

//http://www.shuotupu.com
//说图谱网
defined('IN_IA') || exit('Access Denied');
mload()->model('activity');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
$advertise = get_plugin_config('advertise');
if ($ta == 'index') 
{
	$leave = stat_leave_advertise();
	$payment = array_keys($advertise['payment']);
	$pay_types = array( 'alipay' => array('text' => '支付宝') );
	$config_stick = $advertise['type']['stick'];
	$config_fees = $config_stick['displayorder_fees'];
}
include itemplate('activity/advertise');
function stat_leave_advertise($type = '') 
{
	global $_W;
	$config_advertise = get_plugin_config('advertise');
	if (!(empty($type))) 
	{
		return;
	}
	$stick_advertising = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_advertise_trade') . 'where uniacid = :uniacid and status = 1 and type_cn = :type_cn', array(':uniacid' => $_W['uniacid'], ':type_cn' => 'stick'));
	$recommend_advertising = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_advertise_trade') . 'where uniacid = :uniacid and status = 1 and type_cn = :type_cn', array(':uniacid' => $_W['uniacid'], ':type_cn' => 'recommend'));
	$more_advertising = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_advertise_trade') . 'where uniacid = :uniacid and status = 1 and type_cn = :type_cn', array(':uniacid' => $_W['uniacid'], ':type_cn' => 'recommend_more'));
	$leave_stick = $config_advertise['type']['stick']['num'] - $stick_advertising;
	$leave_stick = ((0 < $leave_stick ? $leave_stick : 0));
	$leave_recommend = $config_advertise['type']['recommend']['home']['num'] - $recommend_advertising;
	$leave_recommend = ((0 < $leave_recommend ? $leave_recommend : 0));
	$leave_more = $config_advertise['type']['recommend']['other']['num'] - $more_advertising;
	$leave_more = ((0 < $leave_more ? $leave_more : 0));
	$leave = array('stick' => $leave_stick, 'recommend' => $leave_recommend, 'recommend_more' => $leave_more);
	return $leave;
}
?>