<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
$config_getcash = $_deliveryer['fee_getcash'];
if ($ta == 'index') 
{
	imessage(error(0, array('deliveryer' => $_deliveryer)), '', 'ajax');
	return 1;
}
if ($ta == 'submit') 
{
	if (empty($_W['deliveryer']['perm_plateform'])) 
	{
		imessage(error(-1, '你不是平台配送员，不能进行提现操作'), '', 'ajax');
	}
	if ((empty($_deliveryer['openid']) && empty($_deliveryer['openid_wxapp'])) || empty($_deliveryer['title'])) 
	{
		imessage(error(-1, '配送员账户不完善, 无法提现'), '', 'ajax');
	}
	$get_fee = floatval($_GPC['get_fee']);
	if (MODULE_FAMILY == 'wxapp') 
	{
		if (empty($_deliveryer['openid_wxapp'])) 
		{
			imessage(error(-1, '未获取到配送员针对小程序的openid, 你可以尝试进入平台小程序会员中心来解决此问题'), '', 'ajax');
		}
	}
	else 
	{
		$openid = mktTransfers_get_openid($_deliveryer['id'], $_deliveryer['openid'], $get_fee, 'deliveryer');
		if (is_error($openid)) 
		{
			imessage($openid, '', 'ajax');
		}
	}
	if (!($get_fee)) 
	{
		imessage(error(-1, '提现金额有误'), '', 'ajax');
	}
	if ($get_fee < $config_getcash['get_cash_fee_limit']) 
	{
		imessage(error(-1, '提现金额小于最低提现金额限制'), '', 'ajax');
	}
	if ($_deliveryer['credit2'] < $get_fee) 
	{
		imessage(error(-1, '提现金额大于账户可用余额'), '', 'ajax');
	}
	$take_fee = round($get_fee * ($config_getcash['get_cash_fee_rate'] / 100), 2);
	$take_fee = max($take_fee, $config_getcash['get_cash_fee_min']);
	if (0 < $config_getcash['get_cash_fee_max']) 
	{
		$take_fee = min($take_fee, $config_getcash['get_cash_fee_max']);
	}
	$final_fee = $get_fee - $take_fee;
	if ($final_fee < 0) 
	{
		$final_fee = 0;
	}
	$formId = trim($_GPC['formId']);
	$data = array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'deliveryer_id' => $_deliveryer['id'], 'trade_no' => date('YmdHis') . random(10, true), 'get_fee' => $get_fee, 'take_fee' => $take_fee, 'final_fee' => $final_fee, 'account' => iserializer(array('nickname' => $_deliveryer['nickname'], 'openid' => $openid, 'openid_wxapp' => $_deliveryer['openid_wxapp'], 'avatar' => $_deliveryer['avatar'], 'realname' => $_deliveryer['title'])), 'status' => 2, 'addtime' => TIMESTAMP, 'channel' => (MODULE_FAMILY == 'wxapp' ? 'wxapp' : 'weixin'));
	pdo_insert('tiny_wmall_deliveryer_getcash_log', $data);
	$getcash_id = pdo_insertid();
	$remark = date('Y-m-d H:i:s') . '申请提现,提现金额' . $get_fee . '元, 手续费' . $take_fee . '元, 实际到账' . $final_fee . '元';
	deliveryer_update_credit2($_deliveryer['id'], -$get_fee, 2, $getcash_id, $remark);
	sys_notice_deliveryer_getcash($_deliveryer['id'], $getcash_id, 'apply');
	$getcashperiod = $config_getcash['get_cash_period'];
	if (empty($getcashperiod)) 
	{
		imessage(error(0, array('message' => '申请提现成功,等待平台管理员审核', 'id' => $getcash_id)), '', 'ajax');
		return 1;
	}
	if ($getcashperiod == 1) 
	{
		$transfers = deliveryer_getcash_transfers($getcash_id);
		imessage(error($transfers['errno'], array('message' => $transfers['message'], 'id' => $getcash_id)), '', 'ajax');
		return 1;
	}
}
else if ($ta == 'detail') 
{
	$id = intval($_GPC['id']);
	$getcash_log = pdo_get('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'id' => $id));
	$getcash_log['addtime_cn'] = date('Y-m-d H:i', $getcash_log['addtime']);
	if ($getcash_log['status'] == 1) 
	{
		$getcash_log['status_cn'] = '提现成功';
	}
	else if ($getcash_log['status'] == 2) 
	{
		$getcash_log['status_cn'] = '申请中';
	}
	else 
	{
		$getcash_log['status_cn'] = '已撤销';
	}
	imessage(error(0, array('getcash_log' => $getcash_log)), '', 'ajax');
	return 1;
}
else if ($ta == 'list') 
{
	$condition = ' WHERE uniacid = :uniacid AND deliveryer_id = :deliveryer_id';
	$params = array(':uniacid' => $_W['uniacid'], ':deliveryer_id' => $_deliveryer['id']);
	$status = intval($_GPC['status']);
	if (0 < $status) 
	{
		$condition .= ' and status = :status';
		$params[':status'] = $status;
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = intval($_GPC['psize']);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	if (!(empty($records))) 
	{
		foreach ($records as &$row ) 
		{
			if ($row['status'] == 1) 
			{
				$row['status_cn'] = '提现成功';
			}
			else if ($row['status'] == 2) 
			{
				$row['status_cn'] = '申请中';
			}
			else 
			{
				$row['status_cn'] = '已撤销';
			}
			$row['addtime_cn'] = date('Y-m-d H:i', $row['addtime']);
		}
	}
	$result = array('records' => $records);
	imessage(error(0, $result), '', 'ajax');
}
?>