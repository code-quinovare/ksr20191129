<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
mload()->model('deliveryer');
$op = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'list'));
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
	$pindex = max(1, intval($_GPC['page']));
	$psize = 20;
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	foreach ($records as &$record ) 
	{
		$record['account'] = iunserializer($record['account']);
		$record['addtime_cn'] = date('Y-m-d H:i', $record['addtime']);
	}
	$result = array('records' => $records);
	message(ierror(0, '', $result), '', 'ajax');
}
if ($op == 'transfers') 
{
	$id = intval($_GPC['id']);
	$transfers = deliveryer_getcash_transfers($id);
	if (is_error($transfers)) 
	{
		message(ierror(-1, $transfers['message']), '', 'ajax');
	}
	message(ierror(0, $transfers['message']), '', 'ajax');
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
	message(ierror(0, '设置提现状态成功'), '', 'ajax');
}
if ($op == 'cancel') 
{
	$id = intval($_GPC['id']);
	$log = pdo_get('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'id' => $id));
	if ($log['status'] == 1) 
	{
		message(ierror(-1, '本次提现已成功,无法撤销'), '', 'ajax');
	}
	else if ($log['status'] == 3) 
	{
		message(ierror(-1, '本次提现已撤销'), '', 'ajax');
	}
	$remark = trim($_GPC['remark']);
	if (empty($remark)) 
	{
		message(ierror(-1, '撤销原因不能为空'), '', 'ajax');
	}
	deliveryer_update_credit2($log['deliveryer_id'], $log['get_fee'], 3, '', $remark, '');
	pdo_update('tiny_wmall_deliveryer_getcash_log', array('status' => 3, 'endtime' => TIMESTAMP), array('uniacid' => $_W['uniacid'], 'id' => $id));
	sys_notice_deliveryer_getcash($log['deliveryer_id'], $id, 'cancel', $remark);
	message(ierror(0, '提现撤销成功'), '', 'ajax');
}
?>