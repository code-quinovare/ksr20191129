<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
if ($ta == 'index') 
{
	$_W['page']['title'] = '账户余额提现';
	$account = store_account($sid);
	if (empty($account['wechat']['openid']) && empty($account['wechat']['openid_wxapp'])) 
	{
		header('location:' . iurl('store/finance/getcash/account'));
		exit();
	}
	if ($_W['ispost']) 
	{
		if ((empty($account['wechat']['openid']) && empty($account['wechat']['openid_wxapp'])) || empty($account['wechat']['realname'])) 
		{
			imessage(error(-1, '提现账户不完善,提现前请先完善提现账户'), '', 'ajax');
		}
		$get_fee = intval($_GPC['get_fee']);
		if (MODULE_FAMILY == 'wxapp') 
		{
			if (empty($account['wechat']['openid_wxapp'])) 
			{
				imessage(error(-1, '未获取到商户账户针对小程序的openid,你可以尝试进入平台小程序会员中心并重新设置提现账户来解决此问题,'), '', 'ajax');
			}
		}
		else 
		{
			$openid = mktTransfers_get_openid($sid, $account['wechat']['openid'], $get_fee);
			if (is_error($openid)) 
			{
				imessage($openid, '', 'ajax');
			}
			if (empty($openid)) 
			{
				imessage(error(-1, '未获取到商户账户针对公众号的openid,你可以尝试进入平台公众号会员中心并重新设置提现账户来解决此问题'), '', 'ajax');
			}
			$account['wechat']['openid'] = $openid;
		}
		if ($get_fee < $account['fee_limit']) 
		{
			imessage(error(-1, '提现金额小于最低提现金额限制'), '', 'ajax');
		}
		if ($account['amount'] < $get_fee) 
		{
			imessage(error(-1, '提现金额大于账户可用余额'), '', 'ajax');
		}
		$fee_period = $account['fee_period'] * 24 * 3600;
		if (0 < $fee_period) 
		{
			$getcash_log = pdo_fetch('select addtime from ' . tablename('tiny_wmall_store_getcash_log') . ' where uniacid = :uniacid and sid = :sid order by addtime desc', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
			$last_getcash = $getcash_log['addtime'];
			if (TIMESTAMP < ($last_getcash + $fee_period)) 
			{
				imessage(error(-1, '距上次提现时间小于提现周期'), '', 'ajax');
			}
		}
		$take_fee = round($get_fee * ($account['fee_rate'] / 100), 2);
		$take_fee = max($take_fee, $account['fee_min']);
		if (0 < $account['fee_max']) 
		{
			$take_fee = min($take_fee, $account['fee_max']);
		}
		$final_fee = $get_fee - $take_fee;
		if ($final_fee < 0) 
		{
			$final_fee = 0;
		}
		$data = array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'sid' => $sid, 'trade_no' => date('YmdHis') . random(10, true), 'get_fee' => $get_fee, 'take_fee' => $take_fee, 'final_fee' => $final_fee, 'account' => iserializer($account['wechat']), 'status' => 2, 'addtime' => TIMESTAMP, 'channel' => (MODULE_FAMILY == 'wxapp' ? 'wxapp' : 'weixin'));
		pdo_insert('tiny_wmall_store_getcash_log', $data);
		$getcash_id = pdo_insertid();
		store_update_account($sid, -$get_fee, 2, $getcash_id);
		sys_notice_store_getcash($sid, $getcash_id, 'apply');
		$getcashperiod = get_system_config('store.serve_fee.get_cash_period');
		if (empty($getcashperiod)) 
		{
			imessage(error(0, '申请提现成功,等待平台管理员审核'), iurl('store/finance/getcash/log'), 'ajax');
		}
		else if ($getcashperiod == 1) 
		{
			$transfers = store_getcash_transfers($getcash_id);
			imessage($transfers, iurl('store/finance/getcash/log'), 'ajax');
		}
	}
}
if ($ta == 'account') 
{
	$_W['page']['title'] = '设置提现账户';
	$account = store_account($sid);
	if ($_W['ispost']) 
	{
		$data = array('uniacid' => $_W['uniacid'], 'sid' => $sid);
		$wechat = array();
		$wechat['openid'] = trim($_GPC['wechat']['openid']);
		$wechat['openid_wxapp'] = trim($_GPC['wechat']['openid_wxapp']);
		$wechat['nickname'] = trim($_GPC['wechat']['nickname']);
		$wechat['avatar'] = trim($_GPC['wechat']['avatar']);
		$wechat['realname'] = ((trim($_GPC['wechat']['realname']) ? trim($_GPC['wechat']['realname']) : imessage(error(-1, '微信实名认证姓名不能为空'), '', 'ajax')));
		$data['wechat'] = iserializer($wechat);
		if (empty($account)) 
		{
			$data['amount'] = 0;
			pdo_insert('tiny_wmall_store_account', $data);
		}
		else 
		{
			pdo_update('tiny_wmall_store_account', $data, array('uniacid' => $_W['uniacid'], 'sid' => $sid));
		}
		imessage(error(0, '设置提现账户成功'), iurl('store/finance/getcash/account'), 'ajax');
	}
}
if ($ta == 'log') 
{
	$_W['page']['title'] = '提现记录';
	$condition = ' WHERE uniacid = :uniacid AND sid = :sid';
	$params[':uniacid'] = $_W['uniacid'];
	$params[':sid'] = $sid;
	$status = intval($_GPC['status']);
	if (0 < $status) 
	{
		$condition .= ' AND status = :status';
		$params[':status'] = $status;
	}
	if (!(empty($_GPC['addtime']))) 
	{
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']);
	}
	else 
	{
		$today = strtotime(date('Y-m-d'));
		$starttime = strtotime('-15 day', $today);
		$endtime = $today + 86399;
	}
	$condition .= ' AND addtime > :start AND addtime < :end';
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_store_getcash_log') . $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_store_getcash_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	if (!(empty($records))) 
	{
		foreach ($records as &$row ) 
		{
			$row['account'] = iunserializer($row['account']);
		}
	}
	$pager = pagination($total, $pindex, $psize);
}
include itemplate('store/finance/getcash');
?>