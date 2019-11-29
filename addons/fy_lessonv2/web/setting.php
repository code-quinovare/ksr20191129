<?php
/**
 * 系统设置
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */
load()->func('tpl');

$glo_setting = $this->getSetting();
if($op == 'display') {
	$login_visit = json_decode($setting['login_visit'], true);
	$poster = json_decode($setting['poster_config'], true);
	$index_verify = json_decode($setting['index_verify'], true);

    if (checksubmit('submit')) {
        $data = array(
            'uniacid'		=> $uniacid,
			'stock_config'	=> intval($_GPC['stock_config']),
			'visit_limit'	=> intval($_GPC['visit_limit']),
			'login_visit'	=> json_encode($_GPC['login_visit']),
            'isfollow'		=> intval($_GPC['isfollow']),
            'follow_word'	=> trim($_GPC['follow_word']) ? trim($_GPC['follow_word']) : '关注微课堂，学习海量课程',
			'lesson_follow_title'	=> trim($_GPC['lesson_follow_title']),
			'lesson_follow_desc'	=> trim($_GPC['lesson_follow_desc']),
            'category_ico'	=> $_GPC['category_ico'],
            'qrcode'		=> $_GPC['qrcode'],
			'is_invoice'	=> intval($_GPC['is_invoice']),
            'posterbg'		=> trim($_GPC['posterbg']),
			'poster_type'	=> intval($_GPC['poster_type']),
			'poster_config'	=> json_encode($_GPC['poster_config']),
            'manageopenid'	=> trim($_GPC['manageopenid']),
            'closespace'	=> intval($_GPC['closespace']),
            'teacher_income'=> intval($_GPC['teacher_income']),
            'audit_evaluate'=> intval($_GPC['audit_evaluate']),
            'autogood'		=> intval($_GPC['autogood']),
			'self_setting'  => $_GPC['self_setting'],
			'modify_mobile' => $_GPC['modify_mobile'],
			'index_verify'  => json_encode($_GPC['index_verify']),
            'addtime'		=> time(),
        );

		$font_color = $_GPC['poster_config']['nickname_fontcolor'];
		if(!empty($font_color)){
			if(strlen($font_color) != 7){
				message("海报用户昵称字体颜色值错误");
			}
			if(substr($font_color, 0, 1) != '#'){
				message("海报用户昵称字体颜色值错误");
			}
		}
        if ($data['teacher_income'] > 100) {
            message("讲师课程收入分成不能超过100%");
        }

        if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($_GPC['clearhistory']==1){
			pdo_delete($this->table_lesson_history, array('uniacid'=>$uniacid));
		}

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->全局设置", "编辑全局设置");
			message('更新成功', $this->createWebUrl('setting'), 'success');
		}else{
			message('更新失败，请稍候重试', "", 'error');
		}
    }

}elseif ($op == 'frontshow') {
	$lazyload = unserialize($setting['index_lazyload']);
	$self_diy = unserialize($setting['self_diy']);
	$search_box = json_decode($setting['search_box'], true);
	$user_info = json_decode($setting['user_info'], true);
	
    if (checksubmit('submit')) {
		foreach ($_GPC['diy_name'] as $key => $row) {
            $diy_link = $_GPC['diy_link'][$key];
			$diy_image = $_GPC['diy_image'][$key];
            if (!$row || !$diy_link)
                continue;
            $diy_data[] = array(
                'diy_name'  => $row,
                'diy_link'  => $diy_link,
				'diy_image' => $diy_image,
            );
        }

		$_GPC['search_box']['top']  = intval($_GPC['search_box']['top']);
		$_GPC['search_box']['left'] = intval($_GPC['search_box']['left']);
        $data = array(
            'uniacid'		 => $uniacid,
            'sitename'		 => trim($_GPC['sitename']),
            'copyright'		 => trim($_GPC['copyright']),
            'logo'			 => trim($_GPC['logo']),
            'show_newlesson' => intval($_GPC['show_newlesson']),
            'teacherlist'	 => intval($_GPC['teacherlist']),
            'lesson_show'	 => intval($_GPC['lesson_show']),
            'mustinfo'		 => intval($_GPC['mustinfo']),
			'user_info'		 => json_encode($_GPC['user_info']),
			'search_box'	 => json_encode($_GPC['search_box']),
			'self_diy'		 => serialize($diy_data),
            'addtime'	     => time(),
        );
		$data['index_lazyload'] = serialize(
			array(
				'lazyload_switch'=>intval($_GPC['lazyload_switch']),
				'lazyload_image'=>$_GPC['lazyload_image']
			)
		);

        if ($data['teacher_income'] > 100) {
            message("讲师课程收入分成不能超过100%");
        }

        if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->手机端显示", "编辑手机端显示");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'frontshow')), 'success');
		}else{
			message('更新失败，请稍候重试', "", 'error');
		} 
    }

}elseif ($op == 'templatemsg') {
	$tplmessage = pdo_fetch("SELECT * FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
    if (checksubmit('submit')) {
        $data = array(
            'uniacid'		=> $uniacid,
            'buysucc'		=> trim($_GPC['buysucc']),
            'cnotice'		=> trim($_GPC['cnotice']),
            'newjoin'		=> trim($_GPC['newjoin']),
            'newlesson'		=> trim($_GPC['newlesson']),
            'neworder'		=> trim($_GPC['neworder']),
            'newcash'		=> trim($_GPC['newcash']),
            'apply_teacher' => trim($_GPC['apply_teacher']),
			'receive_coupon'=> trim($_GPC['receive_coupon']),
            'addtime'		=> time(),
			'update_time'	=> time(),
        );

        if (empty($tplmessage)) {
            $result = pdo_insert($this->table_tplmessage, $data);
        } else {
            $result = pdo_update($this->table_tplmessage, $data, array('uniacid' => $uniacid));
        }

		if($result){
			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->模版消息", "编辑模版消息");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'templatemsg')), 'success');
		}else{
			message('更新失败，请稍候重试', "", 'error');
		}
    }

}elseif ($op == 'vipservice') {

    /* VIP等级列表 */
    $level_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid ORDER BY sort DESC,id DESC", array(':uniacid'=>$uniacid));

	/* VIP分销佣金比例 */
	$commission = unserialize($comsetting['viporder_commission']);

    if (checksubmit('submit')) {
        $data = array(
            'uniacid'  => $uniacid,
            'vipdesc'  => $_GPC['vipdesc'],
            'vip_sale' => $_GPC['vip_sale'],
            'addtime'  => time(),
        );

        /* 会员服务 */
        $data['viporder_commission'] = iserializer($_GPC['com']);

        if (empty($comsetting)) {
            $result = pdo_insert($this->table_commission_setting, $data);
        } else {
            $result = pdo_update($this->table_commission_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新分销表缓存 */
			$comsetting = $this->getComsetting();
			$this->updateCache('fy_lessonv2_commission_setting_'.$uniacid, $comsetting);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->会员服务", "编辑会员服务");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'vipservice')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}
    }
}elseif($op=='vipLevel'){
	$level_id = intval($_GPC['level_id']);
	if($level_id>0){
		$level = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$level_id));
		if(empty($level)){
			message("该VIP等级不存在或已被删除", "", "error");
		}
	}
	
	if(checksubmit('submit')){
		$data = array(
			'uniacid'         => $uniacid,
			'level_name'      => trim($_GPC['level_name']),
			'level_validity'  => intval($_GPC['level_validity']),
			'level_price'     => floatval($_GPC['level_price']),
			'integral'		  => intval($_GPC['integral']),
			'discount'        => intval($_GPC['discount']),
			'sort'            => intval($_GPC['sort']),
			'is_show'		  => intval($_GPC['is_show']),
		);

		if(empty($data['level_name'])){
			message("VIP等级名称不能为空", "", "error");
		}
		if(empty($data['level_validity'])){
			message("VIP等级有效期不能为空", "", "error");
		}
		if(empty($data['level_price'])){
			message("VIP等级价格不能为空", "", "error");
		}
		
		if($level_id>0){
			$result = pdo_update($this->table_vip_level, $data, array('id'=>$level_id));
		}else{
			$result = pdo_insert($this->table_vip_level, $data);
		}

		if($result){
			message("更新成功", $this->createWebUrl('setting',array('op'=>'vipservice')), "success");
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}
	}
	
}elseif($op=='delVipLevel'){
	$level_id = intval($_GPC['level_id']);
	if($level_id>0){
		$level = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$level_id));
		if(empty($level)){
			message("该VIP等级不存在或已被删除", "", "error");
		}
	}
	
	if(pdo_delete($this->table_vip_level, array('id'=>$level_id))){
		message("删除成功", $this->createWebUrl('setting',array('op'=>'vipservice')), "success");
	}else{
		message("删除失败", "", "error");
	}
	
}elseif ($op == 'banner') {
    /* banner图 */
    $banner = unserialize($setting['banner']);
    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => $uniacid,
            'banner' => serialize($_GPC['banner']),
            'addtime' => time(),
        );

        if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->首页幻灯片", "编辑首页幻灯片");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'banner')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}  
    }

}elseif ($op == 'adv') {
    /* avd图 */
    $adv = unserialize($setting['adv']);
    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => $uniacid,
            'adv' => serialize($_GPC['adv']),
            'addtime' => time(),
        );

        if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->课程页广告", "编辑课程页广告");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'adv')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		} 
    }

}elseif ($op == 'savetype') {
    /* 存储方式 */
    $qiniu = unserialize($setting['qiniu']);
    $qcloud = unserialize($setting['qcloud']);

    if (checksubmit('submit')) {
        $data = array(
            'uniacid' => $uniacid,
            'savetype' => intval($_GPC['savetype']), /* 存储方式 0.其他 1.七牛 2.腾讯云*/
            'addtime' => time(),
        );

        /* 七牛云存储 */
        $qiniutype = array(
			'bucket'	 => trim($_GPC['qiniu']['bucket']),
            'access_key' => trim($_GPC['qiniu']['access_key']),
            'secret_key' => trim($_GPC['qiniu']['secret_key']),
			'qiniu_area' => intval($_GPC['qiniu']['qiniu_area']),
            'url'		 => str_replace("http://","",trim($_GPC['qiniu']['url'])),
			'https'		 => intval($_GPC['qiniu']['https'])
        );
        $data['qiniu'] = serialize($qiniutype);

        /* 腾讯云存储 */
        $qcloudtype = array(
            'appid'		=> trim($_GPC['qcloud']['appid']),
            'bucket'	=> trim($_GPC['qcloud']['bucket']),
            'secretid'  => trim($_GPC['qcloud']['secretid']),
            'secretkey' => trim($_GPC['qcloud']['secretkey']),
			'qcloud_area' => $_GPC['qcloud']['qcloud_area'],
			'url'		=> str_replace("http://","",trim($_GPC['qcloud']['url'])),
			'https'		=> intval($_GPC['qcloud']['https'])
        );
        $data['qcloud'] = serialize($qcloudtype);

        if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->存储方式", "编辑存储方式");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'savetype')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}
    }
}elseif ($op == 'sms') {
	$sms = json_decode($setting['dayu_sms'], true);

    if (checksubmit('submit')) {
        $data = array(
            'uniacid'  => $uniacid,
			'dayu_sms' => json_encode($_GPC['dayu_sms']),
            'addtime'  => time(),
        );

        if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->短信配置", "更新短信配置");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'sms')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}
    }

}elseif ($op == 'resetVer') {
	if(pdo_update('modules', array('version'=>'2.2.0'), array('name'=>'fy_lessonv2'))){
		message("重置微课堂V2版本号成功，请继续升级", "", "success");
	}else{
		message("重置微课堂V2版本号失败，请稍后重试", "", "error");
	}

}elseif ($op == 'service') {
	$service = json_decode($setting['qun_service'], true);

	if(checksubmit()){
		foreach ($_GPC['service'] as $k => $v) {
			$nickname = trim($v['nickname']);
			$avatar = trim($v['avatar']);
			$qrcode = trim($v['qrcode']);

			if (!$nickname || !$avatar || !$qrcode){
				continue;
			}
				
			$service_data[] = array(
				'nickname' => $nickname,
				'avatar' => $avatar,
				'qrcode' => $qrcode,
			);
		}

		$data = array(
            'uniacid'  => $uniacid,
			'qun_service'  => json_encode($service_data),
            'addtime'  => time(),
        );

		if (empty($glo_setting)) {
            $result = pdo_insert($this->table_setting, $data);
        } else {
            $result = pdo_update($this->table_setting, $data, array('uniacid' => $uniacid));
        }

		if($result){
			/* 更新设置表缓存 */
			$this->updateCache('fy_lessonv2_setting_'.$uniacid);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "基本设置->加群客服", "更新加群客服");
			message('更新成功', $this->createWebUrl('setting', array('op' => 'service')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
			pdo_debug();
		}
	}

}

include $this->template('setting');
?>