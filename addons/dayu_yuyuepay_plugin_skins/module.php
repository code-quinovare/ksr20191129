<?php

/**
 * 微预约提交页皮肤管理
 *
 * @author dayu
 * @url zy.weiaokeji.com为傲资源
 */
defined('IN_IA') or exit('Access Denied');

class dayu_yuyuepay_plugin_skinsModule extends WeModule {

    public function settingsDisplay($settings) {
        global $_GPC, $_W;
        if (checksubmit()) {
            $data = array(
            );
            if ($this->saveSettings($data)) {
                message('保存成功', 'refresh');
            }
        }
        include $this->template('setting');
    }

}
