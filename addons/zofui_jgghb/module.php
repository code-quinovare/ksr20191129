<?php
/**
 * 众惠九宫格红包模块定义
 *
 * @author 众惠科技
 * @url http://www.012wz.com/
 */
defined('IN_IA') or exit('Access Denied');
define('MB_ROOT', IA_ROOT . '/addons/zofui_jgghb');
class Zofui_jgghbModule extends WeModule {
	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		load()->func('tpl');
		load()->model('account');
		$modules = uni_modules();
		if(checksubmit()) {
			load()->func('file');
            $r = mkdirs(MB_ROOT . '/cert/'.$_W['uniacid']);
			if(!empty($_GPC['cert'])) {
                $ret = file_put_contents(MB_ROOT.'/cert/'.$_W['uniacid'].'/apiclient_cert.pem', trim($_GPC['cert']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['key'])) {
                $ret = file_put_contents(MB_ROOT.'/cert/'.$_W['uniacid'].'/apiclient_key.pem', trim($_GPC['key']));
                $r = $r && $ret;
            }
            if(!empty($_GPC['rootca'])) {
                $ret = file_put_contents(MB_ROOT.'/cert/'.$_W['uniacid'].'/rootca.pem', trim($_GPC['rootca']));
                $r = $r && $ret;
            }			
			if(!$r) {
                message('证书保存失败, 请保证 /cert/ 目录可写');
            }				
			$dat = array(
				'mchid'=>$_GPC['mchid'],
				'apikey'=>$_GPC['apikey']
            );
			if ($this->saveSettings($dat)) {
                message('保存成功', 'refresh');
            }
		}
		//这里来展示设置项表单
		include $this->template('web/setting');
	}

}
