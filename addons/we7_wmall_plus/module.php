<?php
/**
 * 微擎外送模块
 *
 * @author 微信魔方
 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');

class we7_wmall_plusModule extends WeModule {
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		include $this->template('settings');
	}
}
