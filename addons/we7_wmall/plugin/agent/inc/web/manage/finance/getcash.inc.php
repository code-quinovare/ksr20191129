<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
mload()->model('agent');
$agent = get_agent($_W['agentid'], array('amount', 'account', 'fee'));
$account = $agent['account'];
$account['amount'] = $agent['amount'];
if ($op == 'index') 
{
	$_W['page']['title'] = '账户余额提现';
	if (empty($account['wechat']['openid'])) 
	{
		header('location:' . iurl('finance/getcash/account'));
		exit();
	}
	if ($_W['ispost']) 
	{
		if ((empty($account['wechat']['openid']) && empty($account['wechat']['openid_wxapp'])) || empty($account['wechat']['realname'])) 
		{
			imessage(error(-1, '提现前请先完善提现账户'), '', 'ajax');
		}
		$get_fee = intval($_GPC['get_fee']);
		if ($account['amount'] < $get_fee) 
		{
			imessage(error(-1, '提现金额大于账户可用余额'), '', 'ajax');
		}
		if (MODULE_FAMILY == 'wxapp') 
		{
			if (empty($account['wechat']['openid_wxapp'])) 
			{
				imessage(error(-1, '未获取到代理商针对小程序的openid,你可以尝试进入平台小程序会员中心并重新设置提现账户来解决此问题'), '', 'ajax');
			}
		}
		else 
		{
			$openid = mktTransfers_get_openid($_W['agentid'], $account['wechat']['openid'], $_GPC['get_fee'], 'agent');
			if (is_error($openid)) 
			{
				imessage($openid, '', 'ajax');
			}
			if (empty($openid)) 
			{
				imessage(error(-1, '未获取到代理商针对公众号的openid,你可以尝试进入平台公众号会员中心并重新设置提现账户来解决此问题'), '', 'ajax');
			}
			$account['wechat']['openid'] = $openid;
		}
		$fee_period = $agent['fee']['fee_period'] * 24 * 3600;
		if (0 < $fee_period) 
		{
			$getcash_log = pdo_fetch('select addtime from ' . tablename('tiny_wmall_agent_getcash_log') . ' where uniacid = :uniacid and agentid = :agentid order by addtime desc', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
			$last_getcash = $getcash_log['addtime'];
			if (TIMESTAMP < ($last_getcash + $fee_period)) 
			{
				imessage(error(-1, '距上次提现时间小于提现周期'), '', 'ajax');
			}
		}
		$data = array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'trade_no' => date('YmdHis') . random(10, true), 'get_fee' => $get_fee, 'take_fee' => 0, 'final_fee' => $get_fee, 'account' => iserializer($account['wechat']), 'status' => 2, 'addtime' => TIMESTAMP, 'channel' => (MODULE_FAMILY == 'wxapp' ? 'wxapp' : 'weixin'));
		pdo_insert('tiny_wmall_agent_getcash_log', $data);
		agent_update_account($_W['agentid'], -$get_fee, 2, '');
		sys_notice_agent_getcash($_W['agentid'], $getcash_id, 'apply');
		imessage(error(0, '申请提现成功,等待平台管理员审核'), iurl('finance/getcash/log'), 'ajax');
	}
}
if ($op == 'account') 
{
	$_W['page']['title'] = '设置提现账户';
	if ($_W['ispost']) 
	{
		$wechat = array();
		$wechat['openid'] = ((trim($_GPC['wechat']['openid']) ? trim($_GPC['wechat']['openid']) : imessage(error(-1, '微信昵称不能为空'), '', 'ajax')));
		$wechat['openid_wxapp'] = trim($_GPC['wechat']['openid_wxapp']);
		$wechat['nickname'] = trim($_GPC['wechat']['nickname']);
		$wechat['avatar'] = trim($_GPC['wechat']['avatar']);
		$wechat['realname'] = ((trim($_GPC['wechat']['realname']) ? trim($_GPC['wechat']['realname']) : imessage(error(-1, '微信实名认证姓名不能为空'), '', 'ajax')));
		$update['wechat'] = $wechat;
		pdo_update('tiny_wmall_agent', array('account' => iserializer($update)), array('uniacid' => $_W['uniacid'], 'id' => $_W['agentid']));
		imessage(error(0, '设置提现账户成功'), iurl('finance/getcash/account'), 'ajax');
	}
}
if ($op == 'log') 
{
	$_W['page']['title'] = '提现记录';
	$condition = ' WHERE uniacid = :uniacid AND agentid = :agentid';
	$params[':uniacid'] = $_W['uniacid'];
	$params = array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']);
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
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_agent_getcash_log') . $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_agent_getcash_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	if (!(empty($records))) 
	{
		foreach ($records as &$row ) 
		{
			$row['account'] = iunserializer($row['account']);
		}
	}
	$pager = pagination($total, $pindex, $psize);
}
include itemplate('finance/getcash');
?>