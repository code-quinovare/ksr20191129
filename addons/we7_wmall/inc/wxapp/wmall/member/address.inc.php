<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
icheckauth();
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'list'));
if ($ta == 'list') 
{
	$sid = intval($_GPC['sid']);
	if (0 < $sid) 
	{
		$addresses = member_fetchall_address_bystore($sid);
		$available = array();
		$disavailable = array();
		if (!(empty($addresses))) 
		{
			foreach ($addresses as $val ) 
			{
				if ($val['available'] == 1) 
				{
					$available[] = $val;
				}
				else 
				{
					$disavailable[] = $val;
				}
			}
		}
		$addresses = array('available' => $available, 'dis_available' => $disavailable);
	}
	else 
	{
		$addresses = member_fetchall_address();
		$addresses = array_values($addresses);
	}
	$respon = array('errno' => 0, 'message' => $addresses);
	imessage($respon, '', 'ajax');
	return 1;
}
if ($ta == 'post') 
{
	$id = intval($_GPC['id']);
	if (0 < $id) 
	{
		$address = member_fetch_address($id);
		if (empty($address)) 
		{
			imessage(error(-1, '地址不存在或已经删除'), '', 'ajax');
		}
	}
	else 
	{
		$address = array('mobile' => $_W['member']['mobile'], 'realname' => $_W['member']['realname']);
	}
	if ($_W['ispost']) 
	{
		if (empty($_GPC['realname']) || empty($_GPC['mobile'])) 
		{
			imessage(error(-1, '信息有误'), '', 'ajax');
		}
		$data = array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'realname' => trim($_GPC['realname']), 'sex' => trim($_GPC['sex']), 'mobile' => trim($_GPC['mobile']), 'address' => trim($_GPC['address']), 'number' => trim($_GPC['number']), 'location_x' => floatval($_GPC['location_x']), 'location_y' => floatval($_GPC['location_y']), 'type' => 1);
		$sid = intval($_GPC['sid']);
		$force = intval($_GPC['force']);
		$channel = ((0 < $sid ? 'takeout' : trim($_GPC['channel'])));
		if (!($force)) 
		{
			if ($channel == 'takeout') 
			{
				$address = member_takeout_address_check($sid, $data);
				if (is_error($address)) 
				{
					imessage(error(-1000, '亲,您的地址已超出商家的配送范围了'), '', 'ajax');
				}
			}
			else if ($channel == 'errander') 
			{
				mload()->model('plugin');
				pload()->model('errander');
				$address = member_errander_address_check($data);
				if (is_error($address)) 
				{
					imessage(error(-1000, '亲,您的地址已超出跑腿的服务范围了'), '', 'ajax');
				}
			}
		}
		if (!(empty($id))) 
		{
			pdo_update('tiny_wmall_address', $data, array('uniacid' => $_W['uniacid'], 'id' => $id));
		}
		else 
		{
			pdo_insert('tiny_wmall_address', $data);
			$id = pdo_insertid();
		}
		imessage(error(0, $id), '', 'ajax');
	}
	imessage(error(0, $address), '', 'ajax');
	return 1;
}
if ($ta == 'location') 
{
	$config = $_W['we7_wmall']['config']['takeout'];
	$map = array( 'center' => array('location_x' => '39.90923', 'location_y' => '116.397428'), 'serve_radius' => 0 );
	if (!(empty($config['range']['map']))) 
	{
		$map['center'] = array('location_x' => $config['range']['map']['location_x'], 'location_y' => $config['range']['map']['location_y']);
	}
	if (!(empty($config['range']['serve_radius']))) 
	{
		$map['serve_radius'] = $config['range']['serve_radius'];
	}
	$result = array('map' => $map);
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'del') 
{
	$id = intval($_GPC['id']);
	pdo_delete('tiny_wmall_address', array('uniacid' => $_W['uniacid'], 'id' => $id));
	imessage(error(0, '删除成功'), '', 'ajax');
	return 1;
}
if ($ta == 'default') 
{
	$id = intval($_GPC['id']);
	pdo_update('tiny_wmall_address', array('is_default' => 0), array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'type' => 1));
	pdo_update('tiny_wmall_address', array('is_default' => 1), array('uniacid' => $_W['uniacid'], 'id' => $id));
	exit();
}
?>