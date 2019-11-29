<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
mload()->model('deliveryer');
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'list'));
if ($op == 'list') 
{
	$_W['page']['title'] = '配送员提现记录';
	$condition = ' WHERE uniacid = :uniacid';
	$params[':uniacid'] = $_W['uniacid'];
	$deliveryer_id = intval($_GPC['deliveryer_id']);
	if (0 < $deliveryer_id) 
	{
		$condition .= ' AND deliveryer_id = :deliveryer_id';
		$params[':deliveryer_id'] = $deliveryer_id;
	}
	$agentid = intval($_GPC['agentid']);
	if (0 < $agentid) 
	{
		$condition .= ' and agentid = :agentid';
		$params[':agentid'] = $agentid;
	}
	$status = intval($_GPC['status']);
	if (0 < $status) 
	{
		$condition .= ' AND status = :status';
		$params[':status'] = $status;
	}
	$days = ((isset($_GPC['days']) ? intval($_GPC['days']) : -2));
	$todaytime = strtotime(date('Y-m-d'));
	$starttime = $todaytime;
	$endtime = $starttime + 86399;
	if (-2 < $days) 
	{
		if ($days == -1) 
		{
			$starttime = strtotime($_GPC['addtime']['start']);
			$endtime = strtotime($_GPC['addtime']['end']);
			$condition .= ' AND addtime > :start AND addtime < :end';
			$params[':start'] = $starttime;
			$params[':end'] = $endtime;
		}
		else 
		{
			$starttime = strtotime('-' . $days . ' days', $todaytime);
			$condition .= ' and addtime >= :start';
			$params[':start'] = $starttime;
		}
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	$pager = pagination($total, $pindex, $psize);
	$deliveryers = deliveryer_all(true);
}
if ($op == 'transfers') 
{
	$id = intval($_GPC['id']);
	$transfers = deliveryer_getcash_transfers($id);
	imessage($transfers, '', 'ajax');
}
if ($op == 'status') 
{
	$id = intval($_GPC['id']);
	$status = intval($_GPC['status']);
	pdo_update('tiny_wmall_deliveryer_getcash_log', array('status' => $status, 'endtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
	if ($_W['is_agent']) 
	{
		$log = pdo_get('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'id' => $id));
		if (0 < $log['agentid']) 
		{
			mload()->model('agent');
			agent_update_account($log['agentid'], $log['take_fee'], 3, '', '配送员提现收取手续费', '');
		}
	}
	imessage(error(0, '设置提现状态成功'), '', 'ajax');
}
if ($op == 'cancel') 
{
	$id = intval($_GPC['id']);
	$log = pdo_get('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if ($log['status'] == 1) 
	{
		imessage(error(-1, '本次提现已成功,无法撤销'), referer(), 'ajax');
	}
	else if ($log['status'] == 3) 
	{
		imessage(error(-1, '本次提现已撤销'), referer(), 'ajax');
	}
	$deliveryer = pdo_get('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'id' => $log['deliveryer_id']));
	if ($_W['ispost']) 
	{
		$remark = trim($_GPC['remark']);
		deliveryer_update_credit2($log['deliveryer_id'], $log['get_fee'], 3, '', $remark, '');
		pdo_update('tiny_wmall_deliveryer_getcash_log', array('status' => 3, 'endtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
		sys_notice_deliveryer_getcash($log['deliveryer_id'], $id, 'cancel', $remark);
		imessage(error(0, '提现撤销成功'), referer(), 'ajax');
	}
	include itemplate('deliveryer/plateformOp');
	exit();
}
include itemplate('deliveryer/getcash');
?>