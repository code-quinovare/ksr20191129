<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
if ($op == 'index') 
{
	$_W['page']['title'] = '编辑版权';
	if ($_W['ispost']) 
	{
		$data = trim($_GPC['copyright']);
		if (!(empty($data))) 
		{
			set_global_config('system.copyright', $data);
			imessage(error(0, '版权设置成功'), referer(), 'ajax');
		}
	}
	$copyright = get_global_config('system.copyright');
	include itemplate('system/copyright');
}
?>