<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;

$_W['page']['title'] = '活动';
$do = 'activity-invite';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';


include $this->template('plateform/activity-invite');