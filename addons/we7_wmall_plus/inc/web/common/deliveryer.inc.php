<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
mload()->model('deliveryer');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'all';

if($op == 'all') {
	$datas = deliveryer_fetchall();
	$datas = array_values($datas);
	message(error(0, $datas), '', 'ajax');
}
