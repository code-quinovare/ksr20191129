<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'help';

$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';
if($op == 'index') {
	$helps = pdo_fetchall('select * from ' . tablename('tiny_wmall_plus_help') . ' where uniacid = :uniacid order by displayorder desc, id asc', array(':uniacid' => $_W['uniacid']));

}

include $this->template('help');
