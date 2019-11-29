<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = trim($_GPC['op']);
if ($op == 'list') 
{
	$key = trim($_GPC['key']);
	$data = pdo_fetchall('select id, title, logo, addtime from ' . tablename('tiny_wmall_store') . ' where uniacid = :uniacid and title like :key order by id desc limit 50', array(':uniacid' => $_W['uniacid'], ':key' => '%' . $key . '%'), 'id');
	if (!(empty($data))) 
	{
		foreach ($data as &$row ) 
		{
			$row['logo'] = tomedia($row['logo']);
			if (empty($row['addtime'])) 
			{
				$row['addtime'] = '未知';
			}
			else 
			{
				$row['addtime'] = date('Y-m-d H:i');
			}
		}
		$stores = array_values($data);
	}
	message(array('errno' => 0, 'message' => $stores, 'data' => $data), '', 'ajax');
}
if ($op == 'category') 
{
	if (isset($_GPC['key'])) 
	{
		$key = trim($_GPC['key']);
		$data = pdo_fetchall('select * from ' . tablename('tiny_wmall_store_category') . ' where uniacid = :uniacid and title like :key order by id desc limit 50', array(':uniacid' => $_W['uniacid'], ':key' => '%' . $key . '%'), 'id');
		if (!(empty($data))) 
		{
			foreach ($data as &$row ) 
			{
				$row['thumb_cn'] = tomedia($row['thumb']);
			}
			$categorys = array_values($data);
		}
		message(array('errno' => 0, 'message' => $categorys, 'data' => $data), '', 'ajax');
	}
	include itemplate('public/store');
}
?>