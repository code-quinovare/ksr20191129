<?php
defined('IN_IA') || exit('Access Denied');
mload()->model('cloud');
global $_W;
global $_GPC;
$ta = trim($_GPC['ta']);
$post = file_get_contents('php://input');
if ($ta == 'touch') 
{
	imessage(error(0, 'success'), '', 'ajax');
}
if ($ta == 'build') 
{
	$data = cloud_w_parse_build($post);
	imessage($data, '', 'ajax');
}
if ($ta == 'schema') 
{
	cloud_w_parse_schema($post);
}
if ($ta == 'download') 
{
	$data = cloud_w_parse_download($post);
	imessage($data, '', 'ajax');
}
?>