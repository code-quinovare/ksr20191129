<?php
//http://www.shuotupu.com
//说图谱网
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
$_POST = &$_POST;
mload()->model('store');
mload()->model('order');
load()->func('logging');
$_W['we7_wmall']['config'] = sys_config();
?>