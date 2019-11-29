<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'file';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'image';

if($op == 'image') {
	$media_id = trim($_GPC['media_id']);
	$status = media_id2url($media_id);
	if(is_error($status)) {
		message($status, '', 'ajax');
	}
	$data = array(
		'errno' => 0,
		'message' => $status,
		'url' => tomedia($status),
	);
	message($data, '', 'ajax');
}

