<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
if ($op == 'index') 
{
	$_W['page']['title'] = '数据初始化';
	set_time_limit(0);
	if ($_W['ispost']) 
	{
		$tables = array('tiny_wmall_activity_bargain', 'tiny_wmall_activity_bargain_goods', 'tiny_wmall_cube', 'tiny_wmall_deliveryer', 'tiny_wmall_deliveryer_current_log', 'tiny_wmall_deliveryer_getcash_log', 'tiny_wmall_errander_category', 'tiny_wmall_errander_order', 'tiny_wmall_news', 'tiny_wmall_news_category', 'tiny_wmall_notice', 'tiny_wmall_order', 'tiny_wmall_order_comment', 'tiny_wmall_order_stat', 'tiny_wmall_paybill_order', 'tiny_wmall_paylog', 'tiny_wmall_report', 'tiny_wmall_slide', 'tiny_wmall_store', 'tiny_wmall_store_account', 'tiny_wmall_store_category', 'tiny_wmall_store_current_log', 'tiny_wmall_store_deliveryer', 'tiny_wmall_store_getcash_log', 'tiny_wmall_text');
		$agentid = ((isset($_GPC['agentid']) ? intval($_GPC['agentid']) : 0));
		foreach ($tables as $table ) 
		{
			if (pdo_fieldexists($table, 'agentid')) 
			{
				pdo_update($table, array('agentid' => $agentid), array('uniacid' => $_W['uniacid']));
			}
		}
		cache_clean('we7_wmall:deliveryers:');
		imessage(error(0, '数据初始化成功'), 'referer', 'ajax');
	}
}
include itemplate('initialize');
?>