<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '代金券-' . $_W['we7_wmall_plus']['config']['title'];
mload()->model('coupon');
$store = store_check();
$sid = $store['id'];
$do = 'coupon-grant';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';

if($op == 'list') {

}

if($op == 'post') {

}
include $this->template('store/coupon-grant');