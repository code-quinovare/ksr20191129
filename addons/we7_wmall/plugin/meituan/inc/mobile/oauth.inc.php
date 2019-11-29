<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$op = ((trim($_GPC['op']) ? trim($_GPC['op']) : 'storemap'));
$sid = intval($_GPC['state']);
if (empty($sid)) 
{
	imessage('店铺id不能为空', '', 'info');
}
pload()->classs('meituan');
$app = new Meituan($sid);
if ($op == 'storemap') 
{
	$url = $app->getStoremapUrl();
}
else if ($op == 'releasebinding') 
{
	$url = $app->getReleasebindingUrl();
}
if (is_error($url)) 
{
	imessage('获取url失败', '', 'error');
}
header('Location: ' . $url);
exit();
?>