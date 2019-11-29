<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC, $_POST;
mload()->model('store');
mload()->model('order');
load()->func('logging');
$_W['we7_wmall_plus']['config'] = sys_config();

