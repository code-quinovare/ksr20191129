<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$sid = intval($_GPC['sid']);
isetcookie('__mg_sid', $sid, 86400 * 7);
header('location: ' . $this->createMobileUrl('mghome'));
exit();
