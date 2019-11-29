<?php
defined('IN_IA') || exit('Access Denied');
mload()->model('activity');
global $_W;
global $_GPC;
$_W['page']['title'] = '新建活动';
$sid = intval($_GPC['__mg_sid']);
$activity = activity_getall($sid, -1);
include itemplate('activity/index');
?>