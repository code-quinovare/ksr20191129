<?php
defined('IN_IA') || exit('Access Denied');
function irurl($url) 
{
	$urls = explode('#', $url);
	return $urls[0] . random(3) . '#' . $urls[1];
}
function imessage($msg, $redirect = '', $type = 'ajax') 
{
	global $_W;
	global $_GPC;
	if (is_array($msg)) 
	{
		$msg['url'] = $redirect;
	}
	if (!(empty($_W['_share']))) 
	{
		if (!(isset($_W['_share']['autoinit']))) 
		{
			$_W['_share']['autoinit'] = 1;
		}
		$global = array('share' => $_W['_share']);
	}
	if ($_GPC['menufooter'] == 1) 
	{
		$menu = get_mall_menu();
		$global['menufooter'] = $menu;
	}
	if ($_GPC['order_remind'] == 1) 
	{
		$menu = order_mall_remind();
		$global['order'] = $menu;
	}
	$vars = array('message' => $msg, 'global' => $global, 'type' => $type, 'url' => $redirect);
	exit(json_encode($vars));
}
function get_mall_menu($menu_id = 0) 
{
	global $_W;
	global $_GPC;
	if (check_plugin_perm('diypage')) 
	{
		$menu_id = intval($menu_id);
		if (empty($menu_id)) 
		{
			$key = 'takeout';
			if ($_W['_controller'] == 'errander') 
			{
				$key = 'errander';
			}
			else if ($_W['_controller'] == 'ordergrant') 
			{
				$key = 'ordergrant';
			}
			$config_menu = get_plugin_config('diypage.vuemenu');
			if (is_array($config_menu) && !(empty($config_menu[$key]))) 
			{
				$menu_id = intval($config_menu[$key]);
			}
		}
		if (0 < $menu_id) 
		{
			$temp = pdo_get('tiny_wmall_diypage_menu', array('uniacid' => $_W['uniacid'], 'id' => $menu_id, 'version' => 2));
			if (!(empty($temp))) 
			{
				$menu = json_decode(base64_decode($temp['data']), true);
				return $menu;
			}
		}
	}
	$result = array( 'name' => 'default', 'params' => array('navstyle' => '0'), 'css' => array('iconColor' => '#163636', 'iconColorActive' => '#ff2d4b', 'textColor' => '#929292', 'textColorActive' => '#ff2d4b'), 'data' => array( 'M0123456789101' => array('img' => '../addons/we7_wmall/plugin/diypage/static/img/1.png', 'link' => '/pages/home/index', 'icon' => 'icon-home', 'text' => '首页'), 'M0123456789104' => array('img' => '../addons/we7_wmall/plugin/diypage/static/img/4.png', 'link' => '/pages/order/index', 'icon' => 'icon-order', 'text' => '订单'), 'M0123456789105' => array('img' => '../addons/we7_wmall/plugin/diypage/static/img/5.png', 'link' => '/pages/member/mine', 'icon' => 'icon-mine', 'text' => '我的') ) );
	return $result;
}
?>