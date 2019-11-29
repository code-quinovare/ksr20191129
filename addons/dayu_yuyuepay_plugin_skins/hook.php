<?php
defined('IN_IA') or exit('Access Denied');

include "model.php";

class dayu_yuyuepay_plugin_skinsModuleHook extends WeModuleHook {
	public function hookMobileTest() {
		//return 'testplugincontent';
		include $this->template('testplugin');
	}

	public function hookWebTest() {
		include $this->template('testplugin');
	}
	
	public function hookWebskins($hook) {
		include $this->template('skins');
	}
	
	public function hookMobileMyprofile($hook) {
		include $this->template('myprofile');
	}
}