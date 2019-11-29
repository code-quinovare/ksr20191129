<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
mload()->model('deliveryer');
$do = 'index';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
checkdeliveryer();
header('location:' . $this->createMobileUrl('dyorder'));
die;