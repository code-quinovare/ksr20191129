<?php
defined('IN_IA') || exit('Access Denied');
mload()->model('page');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
$config_mall = $_W['we7_wmall']['config']['mall'];
if ($ta == 'index') 
{
	$categorys = store_fetchall_category();
	$orderbys = store_orderbys();
	$discounts = store_discounts();
	$carousel = store_fetch_category();
	$result = array('config' => $config_mall, 'categorys' => $categorys, 'stores' => store_filter(), 'orderbys' => $orderbys, 'discounts' => $discounts, 'carousel' => $carousel);
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'store') 
{
	$result = store_filter();
	imessage(error(0, $result), '', 'ajax');
}
?>