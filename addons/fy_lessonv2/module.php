<?php
/**
 * 微课程模块定义
 *
 * @author 风影随行
 * @url https://wx.haoshu888.com
 */
defined('IN_IA') or exit('Access Denied');

class fy_lessonv2Module extends WeModule {

	public function settingsDisplay($settings) {
		global $_W, $_GPC;
		if(checksubmit()) {
			$dat = array(
				'buynow_name' => trim($_GPC['buynow_name']),
				'buynow_link' => trim($_GPC['buynow_link']),
				'wxapp_buynow_link' => trim($_GPC['wxapp_buynow_link']),
				'share_name'  => trim($_GPC['share_name']),
				'service_url'  => $_GPC['service_url'],
				'teacher_qq'  => $_GPC['teacher_qq'],
				'teacher_qqgroup' => $_GPC['teacher_qqgroup'],
				'teacher_qqlink'  => $_GPC['teacher_qqlink'],
				'teacher_qrcode'  => $_GPC['teacher_qrcode'],

				'ucenter_bg'   => $_GPC['ucenter_bg'],
				'vip_bg'	   => $_GPC['vip_bg'],
				'teacher_bg'   => $_GPC['teacher_bg'],
				'index_slogan' => $_GPC['index_slogan'],
				'statis_code'  => $_GPC['statis_code'],

				'indexs_name'  => trim($_GPC['indexs_name']),
				'indexs_link'  => trim($_GPC['indexs_link']),
				'indexs_icon'  => trim($_GPC['indexs_icon']),

				'searchs_name' => trim($_GPC['searchs_name']),
				'searchs_link' => trim($_GPC['searchs_link']),
				'searchs_icon' => trim($_GPC['searchs_icon']),

				'lessons_name' => trim($_GPC['lessons_name']),
				'lessons_link' => trim($_GPC['lessons_link']),
				'lessons_icon' => trim($_GPC['lessons_icon']),

				'selfs_name' => trim($_GPC['selfs_name']),
				'selfs_link' => trim($_GPC['selfs_link']),
				'selfs_icon' => trim($_GPC['selfs_icon']),
			);
			$this->saveSettings($dat);
			message("保存成功", refresh, 'success');
		}

		include $this->template('settings');
	}

}

?>