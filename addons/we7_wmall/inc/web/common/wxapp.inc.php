<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = trim($_GPC['op']);
if ($op == 'link') 
{
	$getScene = trim($_GPC['scene']);
	if (empty($getScene)) 
	{
		$getScene = 'page';
	}
	$type = (($getScene == 'vuepage' ? 'vuepage' : ''));
	$data = wxapp_urls($type);
	if ($getScene == 'menu') 
	{
		unset($data['errander']['business']);
		unset($data['errander']['scene']);
	}
	if ($getScene != 'store') 
	{
		unset($data['other']['table']);
	}
	include itemplate('public/wxappLink');
	return 1;
}
if ($op == 'icon') 
{
	include itemplate('public/wxappIcon');
}
?>