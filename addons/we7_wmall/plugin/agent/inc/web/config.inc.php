<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'basic'));
$_config = get_plugin_config('agent');
if ($op == 'basic') 
{
	$_W['page']['title'] = '基本设置';
	if ($_W['ispost']) 
	{
		$basic = array('status' => intval($_GPC['status']));
		set_plugin_config('agent.basic', $basic);
		imessage(error(0, '基本设置成功'), referer(), 'ajax');
	}
	$config_basic = $_config['basic'];
	include itemplate('config');
}
if ($op == 'serve_fee') 
{
	$_W['page']['title'] = '服务费率';
	$serve_fee = $_config['serve_fee'];
	if ($_W['ispost']) 
	{
		$fee_takeout = $serve_fee['fee_takeout'];
		$takeout_GPC = $_GPC['fee_takeout'];
		$fee_takeout['type'] = ((intval($takeout_GPC['type']) ? intval($takeout_GPC['type']) : 1));
		if ($fee_takeout['type'] == 2) 
		{
			$fee_takeout['fee'] = floatval($takeout_GPC['fee']);
		}
		else 
		{
			$fee_takeout['fee_rate'] = floatval($takeout_GPC['fee_rate']);
			$fee_takeout['fee_min'] = floatval($takeout_GPC['fee_min']);
			$items_yes = array_filter($takeout_GPC['items_yes'], trim);
			if (empty($items_yes)) 
			{
				imessage(error(-1, '至少选择一项抽佣项目'), '', 'ajax');
			}
			$fee_takeout['items_yes'] = $items_yes;
			$items_no = array_filter($takeout_GPC['items_no'], trim);
			$fee_takeout['items_no'] = $items_no;
		}
		$fee_selfDelivery = $serve_fee['fee_selfDelivery'];
		$selfDelivery_GPC = $_GPC['fee_selfDelivery'];
		$fee_selfDelivery['type'] = ((intval($selfDelivery_GPC['type']) ? intval($selfDelivery_GPC['type']) : 1));
		if ($fee_selfDelivery['type'] == 2) 
		{
			$fee_selfDelivery['fee'] = floatval($selfDelivery_GPC['fee']);
		}
		else 
		{
			$fee_selfDelivery['fee_rate'] = floatval($selfDelivery_GPC['fee_rate']);
			$fee_selfDelivery['fee_min'] = floatval($selfDelivery_GPC['fee_min']);
			$items_yes = array_filter($selfDelivery_GPC['items_yes'], trim);
			if (empty($items_yes)) 
			{
				imessage(error(-1, '至少选择一项抽佣项目'), '', 'ajax');
			}
			$fee_selfDelivery['items_yes'] = $items_yes;
			$items_no = array_filter($selfDelivery_GPC['items_no'], trim);
			$fee_selfDelivery['items_no'] = $items_no;
		}
		$fee_instore = $serve_fee['fee_instore'];
		$instore_GPC = $_GPC['fee_instore'];
		$fee_instore['type'] = ((intval($instore_GPC['type']) ? intval($instore_GPC['type']) : 1));
		if ($fee_instore['type'] == 2) 
		{
			$fee_instore['fee'] = floatval($instore_GPC['fee']);
		}
		else 
		{
			$fee_instore['fee_rate'] = floatval($instore_GPC['fee_rate']);
			$fee_instore['fee_min'] = floatval($instore_GPC['fee_min']);
			$items_yes = array_filter($instore_GPC['items_yes'], trim);
			if (empty($items_yes)) 
			{
				imessage(error(-1, '至少选择一项抽佣项目'), '', 'ajax');
			}
			$fee_instore['items_yes'] = $items_yes;
			$items_no = array_filter($instore_GPC['items_no'], trim);
			$fee_instore['items_no'] = $items_no;
		}
		$fee_paybill = $serve_fee['fee_paybill'];
		$paybill_GPC = $_GPC['fee_paybill'];
		$fee_paybill['type'] = ((intval($paybill_GPC['type']) ? intval($paybill_GPC['type']) : 1));
		if ($fee_paybill['type'] == 2) 
		{
			$fee_paybill['fee'] = floatval($paybill_GPC['fee']);
		}
		else 
		{
			$fee_paybill['fee_rate'] = floatval($paybill_GPC['fee_rate']);
			$fee_paybill['fee_min'] = floatval($paybill_GPC['fee_min']);
		}
		$fee_errander = $serve_fee['fee_errander'];
		$errander_GPC = $_GPC['fee_errander'];
		$fee_errander['type'] = ((intval($errander_GPC['type']) ? intval($errander_GPC['type']) : 1));
		if ($fee_errander['type'] == 2) 
		{
			$fee_errander['fee'] = floatval($errander_GPC['fee']);
		}
		else 
		{
			$fee_errander['fee_rate'] = floatval($errander_GPC['fee_rate']);
			$fee_errander['fee_min'] = floatval($errander_GPC['fee_min']);
			$items_yes = array_filter($errander_GPC['items_yes'], trim);
			if (empty($items_yes)) 
			{
				imessage(error(-1, '至少选择一项抽佣项目'), '', 'ajax');
			}
			$fee_errander['items_yes'] = $items_yes;
			$items_no = array_filter($errander_GPC['items_no'], trim);
			$fee_errander['items_no'] = $items_no;
		}
		$fee_period = intval($_GPC['fee_period']);
		$serve_fee = array('fee_takeout' => $fee_takeout, 'fee_instore' => $fee_instore, 'fee_selfDelivery' => $fee_selfDelivery, 'fee_paybill' => $fee_paybill, 'fee_period' => $fee_period, 'fee_errander' => $fee_errander);
		set_plugin_config('agent.serve_fee', $serve_fee);
		$sync = intval($_GPC['sync']);
		if ($sync == 1) 
		{
			$update = array('fee' => iserializer($serve_fee));
			pdo_update('tiny_wmall_agent', $update, array('uniacid' => $_W['uniacid']));
		}
		imessage(error(0, '代理服务费率设置成功'), referer(), 'ajax');
	}
	include itemplate('configServeFee');
}
?>