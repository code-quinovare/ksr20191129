<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
icheckauth();
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
if ($op == 'index') 
{
	$data = spread_commission_stat();
	$settle = get_plugin_config('spread.settle');
	$result = array('data' => $data, 'settle' => $settle);
	imessage(error(0, $result), '', 'ajax');
}
?>