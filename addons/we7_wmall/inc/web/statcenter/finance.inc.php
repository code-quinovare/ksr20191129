<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
if ($op == 'index') 
{
	$_W['page']['title'] = '财务统计';
	$stat['store_total_amount'] = floatval(pdo_fetchcolumn('select round(sum(amount), 2) from ' . tablename('tiny_wmall_store_account') . 'where uniacid = :uniacid', array(':uniacid' => $_W['uniacid'])));
	$stat['deliveryer_total_credit2'] = floatval(pdo_fetchcolumn('select round(sum(credit2), 2) from ' . tablename('tiny_wmall_deliveryer') . 'where uniacid = :uniacid', array(':uniacid' => $_W['uniacid'])));
}
include itemplate('statcenter/finance');
?>