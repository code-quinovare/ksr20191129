<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$sid = intval($_GPC['sid']);
$store = store_fetch($sid);
if (empty($store)) 
{
	imessage(error(-1, '门店不存在或已删除'), '', 'ajax');
}
$activity = store_fetch_activity($sid);
$hot_goods = pdo_fetchall('select id,title,price,sailed,thumb from ' . tablename('tiny_wmall_goods') . ' where uniacid = :uniacid and sid = :sid order by is_hot desc, id desc limit 6', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
if (!(empty($hot_goods))) 
{
	foreach ($hot_goods as &$goods ) 
	{
		$goods['thumb'] = tomedia($goods['thumb']);
	}
}
$result = array('store' => $store, 'activity' => $activity, 'hot_goods' => $hot_goods);
imessage(error(0, $result), '', 'ajax');
?>