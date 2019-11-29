<?php
defined('IN_IA') || exit('Access Denied');
mload()->model('deliveryer');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'list'));
if ($op == 'list') 
{
	$_W['page']['title'] = '平台配送员';
	$condition = ' WHERE uniacid = :uniacid and agentid = :agentid';
	$params[':uniacid'] = $_W['uniacid'];
	$params = array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']);
	$is_takeout = ((isset($_GPC['is_takeout']) ? intval($_GPC['is_takeout']) : -1));
	if (-1 < $is_takeout) 
	{
		$condition .= ' and is_takeout = :is_takeout';
		$params[':is_takeout'] = $is_takeout;
	}
	$is_errander = ((isset($_GPC['is_errander']) ? intval($_GPC['is_errander']) : -1));
	if (-1 < $is_errander) 
	{
		$condition .= ' and is_errander = :is_errander';
		$params[':is_errander'] = $is_errander;
	}
	$keyword = trim($_GPC['keyword']);
	if (!(empty($keyword))) 
	{
		$condition .= ' and (title like \'%' . $keyword . '%\' or nickname like \'%' . $keyword . '%\' or mobile like \'%' . $keyword . '%\')';
	}
	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer') . $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	foreach ($data as &$row ) 
	{
		$row['auth_info'] = iunserializer($row['auth_info']);
	}
	$pager = pagination($total, $pindex, $psize);
	include itemplate('deliveryer/plateform');
}
if ($op == 'inout') 
{
	$title = '收支明细';
	$condition = ' WHERE uniacid = :uniacid and agentid = :agentid';
	$params[':uniacid'] = $_W['uniacid'];
	$params = array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']);
	$deliveryer_id = intval($_GPC['deliveryer_id']);
	if (0 < $deliveryer_id) 
	{
		$condition .= ' AND deliveryer_id = :deliveryer_id';
		$params[':deliveryer_id'] = $deliveryer_id;
	}
	$trade_type = intval($_GPC['trade_type']);
	if (0 < $trade_type) 
	{
		$condition .= ' and trade_type = :trade_type';
		$params[':trade_type'] = $trade_type;
	}
	if (!(empty($_GPC['addtime']))) 
	{
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
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
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer_current_log') . $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_current_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	$order_trade_type = order_trade_type();
	$pager = pagination($total, $pindex, $psize);
	$deliveryers = deliveryer_all(true);
}
if ($op == 'stat') 
{
	$_W['page']['title'] = '配送统计';
	$id = intval($_GPC['id']);
	$deliveryer = deliveryer_fetch($id);
	if (empty($deliveryer)) 
	{
		imessage('配送员不存在', referer(), 'error');
	}
	$start = (($_GPC['start'] ? strtotime($_GPC['start']) : strtotime(date('Y-m'))));
	$end = (($_GPC['end'] ? strtotime($_GPC['end']) + 86399 : strtotime(date('Y-m-d')) + 86399));
	$day_num = ($end - $start) / 86400;
	if ($_W['isajax'] && $_W['ispost']) 
	{
		$days = array();
		$datasets = array( 'flow1' => array() );
		$i = 0;
		while ($i < $day_num) 
		{
			$key = date('m-d', $start + (86400 * $i));
			$days[$key] = 0;
			$datasets['flow1'][$key] = 0;
			++$i;
		}
		$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_order') . 'WHERE uniacid = :uniacid AND agentid = :agentid AND deliveryer_id = :deliveryer_id AND delivery_type = 2 and status = 5', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid'], ':deliveryer_id' => $id));
		foreach ($data as $da ) 
		{
			$key = date('m-d', $da['addtime']);
			if (in_array($key, array_keys($days))) 
			{
				++$datasets['flow1'][$key];
			}
		}
		$shuju['label'] = array_keys($days);
		$shuju['datasets'] = $datasets;
		exit(json_encode($shuju));
	}
	$stat = deliveryer_plateform_order_stat($id);
	include itemplate('deliveryer/plateform');
}
if ($op == 'getcashlog') 
{
	$condition = ' WHERE uniacid = :uniacid and agentid = :agentid';
	$params = array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']);
	$deliveryer_id = intval($_GPC['deliveryer_id']);
	if (0 < $deliveryer_id) 
	{
		$condition .= ' AND deliveryer_id = :deliveryer_id';
		$params[':deliveryer_id'] = $deliveryer_id;
	}
	$status = intval($_GPC['status']);
	if (0 < $status) 
	{
		$condition .= ' AND status = :status';
		$params[':status'] = $status;
	}
	if (!(empty($_GPC['addtime']))) 
	{
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
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
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition, $params);
	$records = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer_getcash_log') . $condition . ' ORDER BY id DESC LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize, $params);
	$pager = pagination($total, $pindex, $psize);
	$deliveryers = deliveryer_all(true);
	include itemplate('deliveryer/plateform');
}
if ($op == 'post') 
{
	$_W['page']['title'] = '配送员信息';
	$id = intval($_GPC['id']);
	if ($_W['ispost']) 
	{
		$mobile = trim($_GPC['mobile']);
		if (!(preg_match(IREGULAR_MOBILE, $mobile))) 
		{
			imessage(error(-1, '手机号格式错误'), '', 'ajax');
		}
		$is_exist = pdo_fetchcolumn('select id from ' . tablename('tiny_wmall_deliveryer') . ' where uniacid = :uniacid and mobile = :mobile and id != :id', array(':uniacid' => $_W['uniacid'], ':mobile' => $mobile, ':id' => $id));
		if (!(empty($is_exist))) 
		{
			imessage(error(-1, '该手机号已绑定其他配送员, 请更换手机号'), '', 'ajax');
		}
		$openid = trim($_GPC['wechat']['openid']);
		$is_exist = pdo_fetchcolumn('select id from ' . tablename('tiny_wmall_deliveryer') . ' where uniacid = :uniacid and openid = :openid and id != :id', array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':id' => $id));
		if (!(empty($is_exist))) 
		{
			imessage(error(-1, '该微信信息已绑定其他配送员, 请更换微信信息'), '', 'ajax');
		}
		$data = array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'mobile' => $mobile, 'title' => trim($_GPC['title']), 'openid' => $openid, 'openid_wxapp' => trim($_GPC['wechat']['openid_wxapp']), 'nickname' => trim($_GPC['wechat']['nickname']), 'avatar' => trim($_GPC['wechat']['avatar']), 'sex' => trim($_GPC['sex']), 'age' => intval($_GPC['age']), 'is_takeout' => intval($_GPC['is_takeout']), 'is_errander' => intval($_GPC['is_errander']), 'collect_max_takeout' => intval($_GPC['collect_max_takeout']), 'collect_max_errander' => intval($_GPC['collect_max_errander']), 'perm_cancel' => iserializer($_GPC['perm_cancel']), 'perm_transfer' => iserializer($_GPC['perm_transfer']), 'fee_getcash' => iserializer($_GPC['fee_getcash']));
		$deliveryer_takeout_fee_type = intval($_GPC['deliveryer_takeout_fee_type']);
		$deliveryer_takeout_fee = 0;
		if ($deliveryer_takeout_fee_type == 1) 
		{
			$deliveryer_takeout_fee = floatval($_GPC['deliveryer_takeout_fee_1']);
		}
		else if ($deliveryer_takeout_fee_type == 2) 
		{
			$deliveryer_takeout_fee = floatval($_GPC['deliveryer_takeout_fee_2']);
		}
		else if ($deliveryer_takeout_fee_type == 3) 
		{
			$deliveryer_takeout_fee = array('start_fee' => floatval($_GPC['deliveryer_takeout_fee_3']['start_fee']), 'start_km' => floatval($_GPC['deliveryer_takeout_fee_3']['start_km']), 'pre_km' => floatval($_GPC['deliveryer_takeout_fee_3']['pre_km']), 'max_fee' => floatval($_GPC['deliveryer_takeout_fee_3']['max_fee']));
		}
		$deliveryer_errander_fee_type = intval($_GPC['deliveryer_errander_fee_type']);
		$deliveryer_errander_fee = 0;
		if ($deliveryer_errander_fee_type == 1) 
		{
			$deliveryer_errander_fee = floatval($_GPC['deliveryer_errander_fee_1']);
		}
		else if ($deliveryer_errander_fee_type == 2) 
		{
			$deliveryer_errander_fee = floatval($_GPC['deliveryer_errander_fee_2']);
		}
		else if ($deliveryer_errander_fee_type == 3) 
		{
			$deliveryer_errander_fee = array('start_fee' => floatval($_GPC['deliveryer_errander_fee_3']['start_fee']), 'start_km' => floatval($_GPC['deliveryer_errander_fee_3']['start_km']), 'pre_km' => floatval($_GPC['deliveryer_errander_fee_3']['pre_km']), 'max_fee' => floatval($_GPC['deliveryer_errander_fee_3']['max_fee']));
		}
		$delivery_fee = array( 'takeout' => array('deliveryer_fee_type' => $deliveryer_takeout_fee_type, 'deliveryer_fee' => $deliveryer_takeout_fee), 'errander' => array('deliveryer_fee_type' => $deliveryer_errander_fee_type, 'deliveryer_fee' => $deliveryer_errander_fee) );
		$data['fee_delivery'] = iserializer($delivery_fee);
		if (!($id)) 
		{
			$data['password'] = ((trim($_GPC['password']) ? trim($_GPC['password']) : imessage(error(-1, '登陆密码不能为空'), '', 'ajax')));
			$data['salt'] = random(6);
			$data['password'] = md5(md5($data['salt'] . $data['password']) . $data['salt']);
			$data['addtime'] = TIMESTAMP;
			pdo_insert('tiny_wmall_deliveryer', $data);
			$id = pdo_insertid();
			deliveryer_all(true);
			imessage(error(0, '添加配送员成功'), iurl('deliveryer/plateform/post', array('id' => $id)), 'ajax');
		}
		else 
		{
			$password = trim($_GPC['password']);
			if (!(empty($password))) 
			{
				$data['salt'] = random(6);
				$data['password'] = md5(md5($data['salt'] . $password) . $data['salt']);
			}
			pdo_update('tiny_wmall_deliveryer', $data, array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'id' => $id));
			deliveryer_all(true);
			imessage(error(0, '编辑配送员成功'), iurl('deliveryer/plateform/post', array('id' => $id)), 'ajax');
		}
	}
	$deliveryer = pdo_get('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'id' => $id));
	if (!(empty($deliveryer))) 
	{
		$deliveryer['perm_cancel'] = iunserializer($deliveryer['perm_cancel']);
		$deliveryer['perm_transfer'] = iunserializer($deliveryer['perm_transfer']);
		$deliveryer['fee_getcash'] = iunserializer($deliveryer['fee_getcash']);
		$deliveryer['fee_delivery'] = iunserializer($deliveryer['fee_delivery']);
	}
	include itemplate('deliveryer/plateform');
}
if ($op == 'del') 
{
	$ids = $_GPC['id'];
	if (!(is_array($ids))) 
	{
		$ids = array($ids);
	}
	foreach ($ids as $id ) 
	{
		pdo_delete('tiny_wmall_deliveryer', array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'id' => $id));
		pdo_delete('tiny_wmall_store_deliveryer', array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'deliveryer_id' => $id));
		pdo_delete('tiny_wmall_deliveryer_current_log', array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'deliveryer_id' => $id));
		pdo_delete('tiny_wmall_deliveryer_getcash_log', array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'deliveryer_id' => $id));
	}
	deliveryer_all(true);
	imessage(error(0, '删除配送员成功'), '', 'ajax');
	include itemplate('deliveryer/plateform');
}
if ($op == 'perm') 
{
	$deliveryerId = intval($_GPC['id']);
	$fields = trim($_GPC['fields']);
	$value = ((intval($_GPC['value']) == 1 ? 0 : 1));
	pdo_update('tiny_wmall_deliveryer', array($fields => $value), array('uniacid' => $_W['uniacid'], 'agentid' => $_W['agentid'], 'id' => $deliveryerId));
	imessage(error(0, ''), '', 'ajax');
}
?>