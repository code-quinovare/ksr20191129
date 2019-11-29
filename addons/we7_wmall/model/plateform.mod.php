<?php
defined('IN_IA') || exit('Access Denied');
function plateform_login($params) 
{
	$username = trim($params['username']);
	if (empty($username)) 
	{
		return error(-1, '用户名不能为空');
	}
	$password = trim($params['password']);
	if (empty($password)) 
	{
		return error(-1, '密码不能为空');
	}
	$record = pdo_get('users', array('username' => $username));
	if (empty($record)) 
	{
		return error(-1, '用户名不存在');
	}
	load()->model('user');
	$password = user_hash($password, $record['salt']);
	if ($password != $record['password']) 
	{
		return error(-1, '密码填写有误');
	}
	$update = array();
	if (empty($record['token'])) 
	{
		$record['token'] = random(20);
		$update['token'] = $record['token'];
	}
	if (!(empty($params['registration_id'])) && ($record['registration_id'] != $params['registration_id'])) 
	{
		$update['registration_id'] = $params['registration_id'];
	}
	if (!(empty($update))) 
	{
		pdo_update('users', $update, array('uid' => $record['uid']));
	}
	$record['jpush_relation'] = plateform_push_token($record);
	return $record;
}
function plateform_push_token($userOrusername) 
{
	global $_W;
	$user = $userOrusername;
	if (!(is_array($user))) 
	{
		$username = $userOrusername;
		$user = pdo_get('users', array('username' => $username));
	}
	if (empty($user)) 
	{
		return error(-1, '用户不存在');
	}
	$config = $_W['we7_wmall']['config']['app']['plateform'];
	if (empty($config['push_tags'])) 
	{
		$config['push_tags'] = array('all' => random(8));
		set_system_config('app.plateform', $config);
	}
	$relation = array( 'alias' => $user['token'], 'tags' => array($config['push_tags']['all']) );
	return $relation;
}
?>