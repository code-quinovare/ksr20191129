<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$_W['page']['title'] = '基础设置';
if ($_W['ispost']) 
{
	$mall = array('version' => 1, 'store_orderby_type' => trim($_GPC['store_orderby_type']), 'store_overradius_display' => intval($_GPC['store_overradius_display']));
	set_agent_system_config('mall', $mall);
	$manager = $_GPC['manager'];
	set_agent_system_config('manager', $manager);
	imessage(error(0, '基础设置成功'), referer(), 'ajax');
}
$_config = get_agent_system_config();
$config = $_config['mall'];
$config['manager'] = $_config['manager'];
include itemplate('config/basic');
?>