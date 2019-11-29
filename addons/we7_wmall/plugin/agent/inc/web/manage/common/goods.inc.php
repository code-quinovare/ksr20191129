<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = trim($_GPC['op']);
if ($op == 'list') 
{
	$condition = ' where uniacid = :uniacid';
	$params = array(':uniacid' => $_W['uniacid']);
	$sid = intval($_GPC['store_id']);
	if (0 < $sid) 
	{
		$condition .= ' and sid = :sid';
		$params[':sid'] = $sid;
	}
	$is_options = intval($_GPC['is_options']);
	$condition .= ' and is_options = :is_options';
	$params[':is_options'] = $is_options;
	$key = trim($_GPC['key']);
	if (!(empty($key))) 
	{
		$condition .= ' and title like :key';
		$params[':key'] = '%' . $key . '%';
	}
	$data = pdo_fetchall('select id, title, thumb, price, total from ' . tablename('tiny_wmall_goods') . $condition, $params, 'id');
	if (!(empty($data))) 
	{
		foreach ($data as &$row ) 
		{
			$row['thumb'] = tomedia($row['thumb']);
			if ($row['total'] == -1) 
			{
				$row['total'] = '无限';
			}
		}
		$goods = array_values($data);
	}
	message(array('errno' => 0, 'message' => $goods, 'data' => $data), '', 'ajax');
}
?>