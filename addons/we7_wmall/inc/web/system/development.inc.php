<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
if ($op == 'index') 
{
	$_W['page']['title'] = '调试模式';
	if ($_W['ispost']) 
	{
		set_global_config('development', intval($_GPC['development']));
		imessage(error(0, '调试模式设置成功'), referer(), 'ajax');
	}
	$development = get_global_config('development');
	include itemplate('system/development');
}
?>