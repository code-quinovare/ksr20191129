<?php
//http://www.shuotupu.com
//说图谱网
define('IN_MOBILE', true);
require '../../../../framework/bootstrap.inc.php';
require '../../../../addons/we7_wmall/payment/__init.php';
$orderid = trim($_GPC['orderid']);
$order = pdo_get('tiny_wmall_order', array('print_sn' => $orderid));
if (empty($order)) 
{
	exit('order is not exist');
}
$_W['uniacid'] = $_W['weid'] = $order['uniacid'];
$_W['uniaccount'] = $_W['account'] = uni_fetch($_W['uniacid']);
$_W['acid'] = $_W['uniaccount']['acid'];
$site = WeUtility::createModuleSite($log['module']);
if (!(is_error($site))) 
{
	$method = 'printResult';
	if (method_exists($site, $method)) 
	{
		$ret = array();
		$ret['uniacid'] = $log['uniacid'];
		$ret['acid'] = $log['acid'];
		$ret['result'] = 'success';
		$ret['from'] = 'notify';
		$ret['orderid'] = $order['id'];
		$ret['order'] = $order;
		$site->$method($ret);
		exit('success');
	}
}
?>