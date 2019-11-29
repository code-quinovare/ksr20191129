<?php
/**
 * 万能客服模块定义
 *
 * @author 梅小西
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');

class Cy163_customerserviceModule extends WeModule {

	public function settingsDisplay($settings) {
        global $_GPC, $_W;
        if (checksubmit()) {
			$cfg = array(
				'title'=>trim($_GPC['title']),
				'ckopenid'=>trim($_GPC['ckopenid']),
				
				'istplon'=>intval($_GPC['istplon']),
				'zdhf'=>intval($_GPC['zdhf']),
				'unfollowtext'=>trim($_GPC['unfollowtext']),
				'followqrcode'=>trim($_GPC['followqrcode']),
				'sharetitle'=>trim($_GPC['sharetitle']),
				'sharedes'=>trim($_GPC['sharedes']),
				'tpl_kefu'=>trim($_GPC['tpl_kefu']),
				'sharethumb'=>trim($_GPC['sharethumb']),
				'kefutplminute'=>intval($_GPC['kefutplminute']),
				'bgcolor'=>trim($_GPC['bgcolor']),
				'defaultavatar'=>trim($_GPC['defaultavatar']),
				'issharemsg'=>intval($_GPC['issharemsg']),
				'isshowwgz'=>intval($_GPC['isshowwgz']),
				'sharetype'=>intval($_GPC['sharetype']),
				'mingan'=>trim($_GPC['mingan']),
				'temcolor'=>trim($_GPC['temcolor']),
				'copyright'=>trim($_GPC['copyright']),
				'isgrouptplon'=>intval($_GPC['isgrouptplon']),
				'grouptplminute'=>intval($_GPC['grouptplminute']),
				'isgroupon'=>intval($_GPC['isgroupon']),
				'footertext1'=>trim($_GPC['footertext1']),
				'footertext2'=>trim($_GPC['footertext2']),
				'footertext4'=>trim($_GPC['footertext4']),
				'qiniuaccesskey'=>trim($_GPC['qiniuaccesskey']),
				'qiniusecretkey'=>trim($_GPC['qiniusecretkey']),
				'qiniubucket'=>trim($_GPC['qiniubucket']),
				'qiniuurl'=>trim($_GPC['qiniuurl']),
				'isqiniu'=>intval($_GPC['isqiniu']),
				'ishowgroupnum'=>intval($_GPC['ishowgroupnum']),
				'chosekefutem'=>intval($_GPC['chosekefutem']),
				//'tulingkey'=>trim($_GPC['tulingkey']),
				//'istulingon'=>intval($_GPC['istulingon']),
				'suiji'=>intval($_GPC['suiji']),
				'bdmodel'=>intval($_GPC['bdmodel']),
				
				'footer4on'=>intval($_GPC['footer4on']),
				'footertext3'=>trim($_GPC['footertext3']),
				'footer4thumb'=>trim($_GPC['footer4thumb']),
				'footer4url'=>trim($_GPC['footer4url']),
			);
            if ($this->saveSettings($cfg)) {
                message('保存成功', 'refresh');
            }
        }
        load()->func('tpl');
		include $this->template('setting');
    }
	
}