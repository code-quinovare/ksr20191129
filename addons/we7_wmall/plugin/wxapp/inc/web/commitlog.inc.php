<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'index'));
mload()->model('cloud');
if ($op == 'index') 
{
	$_W['page']['title'] = '代码上传记录';
	$logs = cloud_w_wxapp_get_commit_log();
	if (is_error($logs)) 
	{
		imessage($logs, '', 'info');
	}
}
include itemplate('commitlog');
?>