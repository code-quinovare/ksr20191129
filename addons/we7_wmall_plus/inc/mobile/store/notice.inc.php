<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'notice';
$id = intval($_GPC['id']);
$notice = pdo_get('tiny_wmall_plus_notice', array('id' => $id, 'uniacid' => $_W['uniacid']));
include $this->template('notice');
