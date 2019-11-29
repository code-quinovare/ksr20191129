<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
mload()->model('table');
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
if ($ta == 'index') 
{
	$_W['page']['title'] = '店内点餐设置';
	$pay = get_available_payment();
	if ($_W['ispost']) 
	{
		if (!(empty($_GPC['payment']))) 
		{
			store_set_data($sid, 'tangshi.payment', $_GPC['payment']);
		}
		imessage(error(0, '设置店内点餐支付方式成功'), 'refresh', 'ajax');
	}
	$payment = store_get_data($sid, 'tangshi.payment');
	include itemplate('store/tangshi/setting');
}
?>