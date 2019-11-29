<?php
//http://www.shuotupu.com
//说图谱网

defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'settle'));
if ($op == 'range') 
{
	$_W['page']['title'] = '服务范围';
	if ($_W['ispost']) 
	{
		$range = array( 'map' => array('location_x' => trim($_GPC['map']['lat']), 'location_y' => trim($_GPC['map']['lng'])), 'city' => trim($_GPC['city']), 'serve_radius' => floatval($_GPC['serve_radius']) );
		set_system_config('takeout.range', $range);
		imessage(error(0, '外卖服务范围设置成功'), referer(), 'ajax');
	}
	$range = $_config['takeout']['range'];
	$range['map']['lat'] = $range['map']['location_x'];
	$range['map']['lng'] = $range['map']['location_y'];
	include itemplate('config/takeout-range');
}
if ($op == 'order') 
{
	$_W['page']['title'] = '订单相关';
	if ($_W['ispost']) 
	{
		$takeout_order = $_config['takeout']['order'];
		$grant_credit = array( 'credit1' => array('status' => intval($_GPC['credit1']['status']), 'grant_type' => intval($_GPC['credit1']['grant_type'])) );
		$grant_credit['credit1']['grant_num'] = (($grant_credit['credit1']['grant_type'] == 1 ? intval($_GPC['credit1']['grant_num_1']) : intval($_GPC['credit1']['grant_num_2'])));
		$delivery_status_3 = array('timeout_limit' => intval($_GPC['delivery_status_3']['timeout_limit']));
		$timeout_remind_3 = array();
		foreach ($_GPC['delivery_status_3']['timeout_remind']['minute'] as $key => $val ) 
		{
			$val = trim($val);
			if (empty($val)) 
			{
				continue;
			}
			$color = $_GPC['delivery_status_3']['timeout_remind']['color'][$key];
			if (empty($color)) 
			{
				continue;
			}
			$timeout_remind_3[] = array('minute' => $val, 'color' => $color);
		}
		if (!(empty($timeout_remind_3))) 
		{
			$delivery_status_3['timeout_remind'] = $timeout_remind_3;
		}
		$delivery_status_7 = array('timeout_limit' => intval($_GPC['delivery_status_7']['timeout_limit']));
		$timeout_remind_7 = array();
		foreach ($_GPC['delivery_status_7']['timeout_remind']['minute'] as $key => $val ) 
		{
			$val = trim($val);
			if (empty($val)) 
			{
				continue;
			}
			$color = $_GPC['delivery_status_7']['timeout_remind']['color'][$key];
			if (empty($color)) 
			{
				continue;
			}
			$timeout_remind_7[] = array('minute' => $val, 'color' => $color);
		}
		if (!(empty($timeout_remind_7))) 
		{
			$delivery_status_7['timeout_remind'] = $timeout_remind_7;
		}
		$delivery_status_4 = array('timeout_limit' => intval($_GPC['delivery_status_4']['timeout_limit']));
		$timeout_remind_4 = array();
		foreach ($_GPC['delivery_status_4']['timeout_remind']['minute'] as $key => $val ) 
		{
			$val = trim($val);
			if (empty($val)) 
			{
				continue;
			}
			$color = $_GPC['delivery_status_4']['timeout_remind']['color'][$key];
			if (empty($color)) 
			{
				continue;
			}
			$timeout_remind_4[] = array('minute' => $val, 'color' => $color);
		}
		if (!(empty($timeout_remind_4))) 
		{
			$delivery_status_4['timeout_remind'] = $timeout_remind_4;
		}
		$order = array( 'notify_rule_clerk' => array('notify_delay' => intval($_GPC['clerk']['notify_delay']), 'notify_frequency' => intval($_GPC['clerk']['notify_frequency']), 'notify_total' => intval($_GPC['clerk']['notify_total']), 'notify_phonecall_time' => intval($_GPC['clerk']['notify_phonecall_time'])), 'notify_rule_deliveryer' => array('notify_delay' => intval($_GPC['deliveryer']['notify_delay']), 'notify_frequency' => intval($_GPC['deliveryer']['notify_frequency']), 'notify_total' => intval($_GPC['deliveryer']['notify_total']), 'notify_phonecall_time' => intval($_GPC['deliveryer']['notify_phonecall_time'])), 'pay_time_limit' => intval($_GPC['pay_time_limit']), 'pay_time_notice' => intval($_GPC['pay_time_notice']), 'handle_time_limit' => intval($_GPC['handle_time_limit']), 'auto_success_hours' => intval($_GPC['auto_success_hours']), 'tangshi_auto_success_hours' => intval($_GPC['tangshi_auto_success_hours']), 'deliveryer_collect_time_limit' => intval($_GPC['deliveryer_collect_time_limit']), 'cancel_after_handle' => intval($_GPC['cancel_after_handle']), 'auto_refund_cancel_order' => intval($_GPC['auto_refund_cancel_order']), 'show_no_pay' => intval($_GPC['show_no_pay']), 'auto_refresh' => intval($_GPC['auto_refresh']), 'deliveryer_collect_notify_clerk' => intval($_GPC['deliveryer_collect_notify_clerk']), 'timeout_limit' => intval($_GPC['timeout_limit']), 'delivery_timeout_limit' => intval($_GPC['delivery_timeout_limit']), 'delivery_before_limit' => intval($_GPC['delivery_before_limit']), 'dispatch_mode' => intval($_GPC['dispatch_mode']), 'can_collect_order' => intval($_GPC['can_collect_order']), 'store_sailed_type' => trim($_GPC['store_sailed_type']), 'deliveryer_collect_max' => intval($_GPC['deliveryer_collect_max']), 'over_collect_max_notify' => intval($_GPC['over_collect_max_notify']), 'grant_credit' => $grant_credit, 'deliveryer_transfer_status' => intval($_GPC['deliveryer_transfer_status']), 'deliveryer_transfer_max' => intval($_GPC['deliveryer_transfer_max']), 'deliveryer_transfer_reason' => explode("\n", trim($_GPC['deliveryer_transfer_reason'])), 'deliveryer_cancel_reason' => explode("\n", trim($_GPC['deliveryer_cancel_reason'])), 'deliveryer_fee_type' => $takeout_order['deliveryer_fee_type'], 'deliveryer_fee' => $takeout_order['deliveryer_fee'], 'dispatch_sort' => trim($_GPC['dispatch_sort']), 'max_dispatching' => intval($_GPC['max_dispatching']), 'delivery_status_3' => $delivery_status_3, 'delivery_status_4' => $delivery_status_4, 'delivery_status_7' => $delivery_status_7, 'show_acceptaddress_when_firstdelivery' => intval($_GPC['show_acceptaddress_when_firstdelivery']), 'customer_delete_order' => intval($_GPC['customer_delete_order']), 'deliverynoassign_sort_type' => trim($_GPC['deliverynoassign_sort_type']), 'check_member_drag_address' => intval($_GPC['check_member_drag_address']) );
		$order['deliveryer_transfer_reason'] = array_filter($order['deliveryer_transfer_reason'], trim);
		$order['deliveryer_cancel_reason'] = array_filter($order['deliveryer_cancel_reason'], trim);
		set_system_config('takeout.order', $order);
		imessage(error(0, '订单相关设置成功'), referer(), 'ajax');
	}
	$order = $_config['takeout']['order'];
	if (!(empty($order['deliveryer_transfer_reason']))) 
	{
		$order['deliveryer_transfer_reason'] = implode("\n", $order['deliveryer_transfer_reason']);
	}
	if (!(empty($order['deliveryer_cancel_reason']))) 
	{
		$order['deliveryer_cancel_reason'] = implode("\n", $order['deliveryer_cancel_reason']);
	}
	include itemplate('config/takeout-order');
}
if ($op == 'deliveryer') 
{
	$_W['page']['title'] = '配送员提成';
	if ($_W['ispost']) 
	{
		$order = $_config['takeout']['order'];
		$order['deliveryer_fee_type'] = ((intval($_GPC['deliveryer_fee_type']) ? intval($_GPC['deliveryer_fee_type']) : 1));
		if ($order['deliveryer_fee_type'] == 1) 
		{
			$order['deliveryer_fee'] = floatval($_GPC['deliveryer_fee_1']);
		}
		else if ($order['deliveryer_fee_type'] == 2) 
		{
			$order['deliveryer_fee'] = floatval($_GPC['deliveryer_fee_2']);
		}
		else if ($order['deliveryer_fee_type'] == 3) 
		{
			$order['deliveryer_fee'] = array('start_fee' => floatval($_GPC['deliveryer_fee_3']['start_fee']), 'start_km' => floatval($_GPC['deliveryer_fee_3']['start_km']), 'pre_km' => floatval($_GPC['deliveryer_fee_3']['pre_km']), 'max_fee' => floatval($_GPC['deliveryer_fee_3']['max_fee']));
		}
		set_system_config('takeout.order', $order);
		imessage(error(0, '配送员提成设置成功'), referer(), 'ajax');
	}
	$order = $_config['takeout']['order'];
	include itemplate('config/takeout-deliveryer');
}
?>