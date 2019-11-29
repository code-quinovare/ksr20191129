<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
icheckauth();
$member = get_spread();
if (empty($member['is_spread']) || ($member['spread_status'] != 1)) 
{
	imessage(error(-1000, ''), 'register', 'ajax');
}
$rank = get_plugin_config('rank');
$basic = get_plugin_config('spread.basic');
$down1 = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_members') . 'where uniacid = :uniacid and spread1 = :spread', array(':uniacid' => $_W['uniacid'], ':spread' => $_W['member']['uid']));
$down2 = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_members') . 'where uniacid = :uniacid and spread2 = :spread', array(':uniacid' => $_W['uniacid'], ':spread' => $_W['member']['uid']));
$condition = ' where uniacid = :uniacid and is_pay = 1 ';
$params = array(':uniacid' => $_W['uniacid'], ':spread' => $_W['member']['uid']);
if ($basic['level'] == 2) 
{
	$down = $down1 + $down2;
	$condition .= ' and (spread1 = :spread or spread2 = :spread)';
}
else if ($basic['level'] == 1) 
{
	$down = $down1;
	$condition .= ' and spread1 = :spread';
}
$order = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_order') . $condition, $params);
$commission = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_spread_getcash_log') . ' where uniacid = :uniacid and spreadid = :spreadid', array(':uniacid' => $_W['uniacid'], ':spreadid' => $_W['member']['uid']));
$current = pdo_fetchcolumn('select count(*) from' . tablename('tiny_wmall_spread_current_log') . 'where uniacid = :uniacid and spreadid = :spreadid', array(':uniacid' => $_W['uniacid'], ':spreadid' => $_W['member']['uid']));
$spread = spread_commission_stat();
spread_group_update($_W['member']['uid']);
$result = array('member' => $member, 'commission' => $commission, 'spread' => $spread, 'order' => $order, 'down' => $down, 'current' => $current, 'upgrade_explain' => get_config_text('spread:upgrade_explain'));
imessage(error(0, $result), '', 'ajax');
?>