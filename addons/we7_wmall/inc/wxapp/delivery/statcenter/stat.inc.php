<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
if ($ta == 'index') 
{
	$stat = deliveryer_stat_order();
	if (is_error($stat)) 
	{
		imessage($stat, '', 'ajax');
	}
	imessage(error(0, $stat), '', 'ajax');
	return 1;
}
if ($ta == 'rank') 
{
	$params = array('type' => trim($_GPC['type']), 'deliveryer_id' => $_W['deliveryer']['id'], 'sort_type' => trim($_GPC['sort_type']));
	$rank = deliveryer_takeout_rank($params);
	if (is_error($rank)) 
	{
		imessage($rank, '', 'ajax');
	}
	imessage(error(0, $rank), '', 'ajax');
	return 1;
}
if ($ta == 'rank_errander') 
{
	$params = array('type' => trim($_GPC['type']), 'deliveryer_id' => $_W['deliveryer']['id'], 'sort_type' => trim($_GPC['sort_type']));
	$rank = deliveryer_errander_rank($params);
	if (is_error($rank)) 
	{
		imessage($rank, '', 'ajax');
	}
	imessage(error(0, $rank), '', 'ajax');
}
?>