<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
mload()->model('cron');
global $_W, $_GPC;
$do = 'cron';
if($_W['isajax']) {
	set_time_limit(0);
	cron_order();
	exit('success');
}












