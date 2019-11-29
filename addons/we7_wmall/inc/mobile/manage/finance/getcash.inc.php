<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$_W['page']['title'] = '申请提现';
$sid = intval($_GPC['__mg_sid']);
$account = $store['account'];
if ($_W['isajax']) 
{
	if ((empty($account['wechat']['openid']) && empty($account['wechat']['openid_wxapp'])) || empty($account['wechat']['realname'])) 
	{
		imessage(error(-1, '提现账户不完善, 请到电脑端商户管理-财务-提现账户进行完善'), '', 'ajax');
	}
	$get_fee = floatval($_GPC['fee']);
	if (MODULE_FAMILY == 'wxapp') 
	{
		if (empty($account['wechat']['openid_wxapp'])) 
		{
			imessage(error(-1, '未获取到商户账户针对小程序的openid,你可以尝试进入平台小程序会员中心并重新设置提现账户来解决此问题'), '', 'ajax');
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
	if (!($get_fee)) 
	{
		imessage(error(-1, '提现金额有误'), '', 'ajax');
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
	if ($final_fee <= 0) 
	{
		imessage(error(-1, '实际到账金额小于0元'), '', 'ajax');
	}
	$data = array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'sid' => $sid, 'trade_no' => date('YmdHis') . random(10, true), 'get_fee' => $get_fee, 'take_fee' => $take_fee, 'final_fee' => $final_fee, 'account' => iserializer($account['wechat']), 'status' => 2, 'addtime' => TIMESTAMP, 'channel' => (MODULE_FAMILY == 'wxapp' ? 'wxapp' : 'weixin'));
	pdo_insert('tiny_wmall_store_getcash_log', $data);
	$getcash_id = pdo_insertid();
	store_update_account($sid, -$get_fee, 2, $getcash_id);
	sys_notice_store_getcash($sid, $getcash_id, 'apply');
	$getcashperiod = get_system_config('store.serve_fee.get_cash_period');
	if (empty($getcashperiod)) 
	{
		imessage(error(0, '申请提现成功,等待平台管理员处理'), iurl('manage/finance/getcash/log'), 'ajax');
	}
	else if ($getcashperiod == 1) 
	{
		$transfers = store_getcash_transfers($getcash_id);
		imessage($transfers, '', 'ajax');
	}
}
include itemplate('finance/getcash');
?>