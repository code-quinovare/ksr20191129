<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '订单列表-' . $_W['we7_wmall_plus']['config']['title'];
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'stat';

header('location: ' . $this->createWebUrl('ptforder-takeout'));
die;
include $this->template('plateform/order-stat');