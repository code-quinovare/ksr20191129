<?php
defined('IN_IA') || exit('Access Denied');
load()->func('communication');
function jpush_get_devices($registration_id) 
{
	global $_W;
	if (empty($registration_id)) 
	{
		return error(-1, '用户极光id为空');
	}
	$config = $_W['we7_wmall']['config']['app']['deliveryer'];
	if (empty($config['push_key']) || empty($config['push_secret'])) 
	{
		return error(-1, 'key或secret不完善');
	}
	if (empty($config['serial_sn'])) 
	{
		return error(-1, 'app序列号不完善');
	}
	$extra = array('Authorization' => 'Basic ' . base64_encode($config['push_key'] . ':' . $config['push_secret']), 'Accept' => 'application/json');
	$response = ihttp_request('https://device.jpush.cn/v3/devices/' . $registration_id, '', $extra);
	if (is_error($response)) 
	{
		return $response;
	}
	$result = @json_decode($response['content'], true);
	if (!(empty($result['error']))) 
	{
		return error(-1, '错误代码: ' . $result['error']['code'] . ', 错误信息: ' . $result['error']['message']);
	}
	return $result;
}
function jpush_update_devices($registration_id, $original, $dest) 
{
	global $_W;
	if (empty($registration_id)) 
	{
		return error(-1, '用户极光id为空');
	}
	$config = $_W['we7_wmall']['config']['app']['deliveryer'];
	if (empty($config['push_key']) || empty($config['push_secret'])) 
	{
		return error(-1, 'key或secret不完善');
	}
	if (empty($config['serial_sn'])) 
	{
		return error(-1, 'app序列号不完善');
	}
	$extra = array('Authorization' => 'Basic ' . base64_encode($config['push_key'] . ':' . $config['push_secret']), 'Accept' => 'application/json');
	$add = array_diff($dest['tags'], $original['tags']);
	$remove = array_diff($original['tags'], $dest['tags']);
	$params = array( 'tags' => array('add' => array_values($add), 'remove' => array_values($remove)), 'alias' => $original['alias'], 'mobile' => $original['mobile'] );
	$response = ihttp_request('https://device.jpush.cn/v3/devices/' . $registration_id, json_encode($params), $extra);
	if (is_error($response)) 
	{
		return $response;
	}
	$result = @json_decode($response['content'], true);
	if (!(empty($result['error']))) 
	{
		return error(-1, '错误代码: ' . $result['error']['code'] . ', 错误信息: ' . $result['error']['message']);
	}
	return true;
}
function Jpush_platefrom_send($title, $alert, $extra = array()) 
{
	global $_W;
	$config = $_W['we7_wmall']['config']['app']['plateform'];
	if (empty($config['push_key']) || empty($config['push_secret'])) 
	{
	}
	if (empty($config['serial_sn'])) 
	{
	}
	$sound_router = array( 'takeout' => array('ordernew' => 'orderSound.wav', 'orderassign' => 'assignSound.wav', 'ordercancel' => 'cancelSound.wav'), 'errander' => array('ordernew' => 'erranderOrderSound.wav', 'orderassign' => 'erranderAssignSound.wav', 'ordercancel' => 'erranderCancelSound.wav') );
	$sound = $sound_router[$extra['redirect_type']][$extra['notify_type']];
	if (empty($sound)) 
	{
		$sound = 'default';
	}
	$push_tag = $config['push_tags']['all'];
	if (empty($extra['audience'])) 
	{
		$extra['audience'] = array( 'tag' => array($push_tag) );
	}
	$extras_orginal = array('voice_play_nums' => 1, 'voice_text' => '', 'redirect_type' => 'order', 'redirect_extra' => '');
	$extras = array_merge($extras_orginal, $extra);
	$jpush_andriod = array( 'platform' => 'android', 'audience' => $extra['audience'], 'notification' => array( 'alert' => $alert, 'android' => array('alert' => $alert, 'title' => $title, 'builder_id' => 1, 'extras' => $extras) ) );
	load()->func('communication');
	$extra = array('Authorization' => 'Basic ' . base64_encode('0c6d4c4fa27202b3a3cde173:27c13954167b692bc6f8a3be'));
	$response = ihttp_request('https://api.jpush.cn/v3/push', json_encode($jpush_andriod), $extra);
	$return = Jpush_response_parse($response);
	if (is_error($return)) 
	{
		slog('plateformappJpush', '平台管理App极光推送(andriod)通知管理员', $jpush_andriod, $return['message']);
	}
	return true;
}
?>