<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
icheckauth();
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
if ($ta == 'index') 
{
	$sid = intval($_GPC['sid']);
	mload()->model('page');
	$homepage = store_page_get($sid);
	imessage(error(0, array('homepage' => $homepage['data'], 'store_id' => $sid)), '', 'ajax');
}
?>