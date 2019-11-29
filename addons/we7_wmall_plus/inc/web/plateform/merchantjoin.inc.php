<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '商家入驻-' . $_W['we7_wmall_plus']['config']['title'];

$sid = $store['id'];
$do = 'merchantjoin';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';


include $this->template('plateform/merchantjoin');