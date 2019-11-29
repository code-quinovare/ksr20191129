<?php
/**
 * 分销设置
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */
 load()->func('tpl');
 load()->func('file');

$glo_comsetting = $this->getComsetting();
if($op=='display'){
	/* 分享课程和讲师 */
	$sharelink	  = unserialize($comsetting['sharelink']);
	$sharelesson  = unserialize($comsetting['sharelesson']);
	$shareteacher = unserialize($comsetting['shareteacher']);
	$cash_way	  = unserialize($comsetting['cash_way']);

	/* 佣金比例 */
	$commission = unserialize($comsetting['commission']);
	/* 微信证书 */
	$cert = file_exists(dirname(dirname(__FILE__))."/cert/apiclient_cert".$uniacid.".pem");
	$key = file_exists(dirname(dirname(__FILE__))."/cert/apiclient_key".$uniacid.".pem");
	$rootca = file_exists(dirname(dirname(__FILE__))."/cert/rootca".$uniacid.".pem");

	$agent_condition = unserialize($comsetting['agent_condition']);
	/* 直接推荐下级奖励 */
	$rec_income = json_decode($comsetting['rec_income'], true);

	if (checksubmit('submit')) {
		$data = array(
			'uniacid'			=> $uniacid,
			'agent_status'		=> intval($_GPC['agent_status']),
			'is_sale'			=> intval($_GPC['is_sale']),
			'self_sale'			=> intval($_GPC['self_sale']),
			'sale_rank'			=> intval($_GPC['sale_rank']),
			'level'				=> intval($_GPC['level']),
			'upgrade_condition' => intval($_GPC['upgrade_condition']),
			'rec_income'		=> json_encode($_GPC['rec_income']),
			'cash_type'			=> intval($_GPC['cash_type']),
			'cash_way'			=> serialize($_GPC['cash_way']),
			'cash_lower_common' => floatval($_GPC['cash_lower_common']),
			'cash_lower_vip'	=> floatval($_GPC['cash_lower_vip']),
			'cash_lower_teacher'=> floatval($_GPC['cash_lower_teacher']),
			'mchid'				=> trim($_GPC['mchid']),
			'mchkey'			=> trim($_GPC['mchkey']),
			'serverIp'			=> trim($_GPC['serverIp']),
			'sale_desc'			=> trim($_GPC['sale_desc']),
			'qrcode_cache'		=> intval($_GPC['qrcode_cache']),
			'addtime'			=> time(),
		);
		if(empty($data['upgrade_condition'])){
			message('请选择分销商升级条件');
		}
		if(!is_numeric(trim($_GPC['rec_income']['credit1'])) || !is_numeric(trim($_GPC['rec_income']['credit2']))){
			message('直接推荐下级奖励的积分余额必须为数字');
		}

		/* 分享课程和讲师 */
		$sharelink = array(
			'title'  => $_GPC['sharelinktitle'],
			'desc'   => $_GPC['sharelinkdesc'],
			'images' => $_GPC['sharelinkimg'],
		);
		$data['sharelink'] = serialize($sharelink);

		$sharelesson = array(
			'title'  => $_GPC['sharelessontitle'],
			'images' => $_GPC['sharelessonimg'],
		);
		$data['sharelesson'] = serialize($sharelesson);

		$shareteacher = array(
			'title'  => $_GPC['shareteachertitle'],
			'images' => $_GPC['shareteacherimg'],
		);
		$data['shareteacher'] = serialize($shareteacher);
	 
		/* 佣金比例 */
		$commission = array(
			'commission1' => floatval($_GPC['commission1']),
			'commission2' => floatval($_GPC['commission2']),
			'commission3' => floatval($_GPC['commission3']),
			'updatemoney' => floatval($_GPC['updatemoney']),
		);
		$data['commission'] = serialize($commission);

		/* 分销商冻结状态转正常条件 */
		$acondition = array(
			'order_amount' => intval($_GPC['order_amount']),
			'order_total'  => intval($_GPC['order_total']),
		);
		$data['agent_condition'] = serialize($acondition);

		if($data['agent_status']==0 && $acondition['order_amount']==0 && $acondition['order_total']==0){
			message("分销商冻结状态转正常状态条件至少填写一个", "", "error");
		}

		if(!empty($_FILES['apiclient_cert']['name'])){
			$this->upfile($_FILES['apiclient_cert'], "apiclient_cert");
		}
		if(!empty($_FILES['apiclient_key']['name'])){
			$this->upfile($_FILES['apiclient_key'], "apiclient_key");
		}
		if(!empty($_FILES['rootca']['name'])){
			$this->upfile($_FILES['rootca'], "rootca");
		}
		
		/* 清空会员推广海报缓存 */
		if($_GPC['clearposter']){
			$files = glob(ATTACHMENT_ROOT.'images/fy_lessonv2/*');
			foreach($files as $file) {
				if (is_file($file)) {
					unlink($file);
				}
			}
			//清空token缓存
			pdo_update('core_cache', array('value'=>null), array('key'=>"accesstoken:".$_W['acid']));
		}

		if (empty($glo_comsetting)) {
			$result = pdo_insert($this->table_commission_setting, $data);
		} else {
			$result = pdo_update($this->table_commission_setting, $data, array('uniacid' => $uniacid));
		}

		if($result){
			/* 更新分销表缓存 */
			$comsetting = $this->getComsetting();
			$this->updateCache('fy_lessonv2_commission_setting_'.$uniacid, $comsetting);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "分销管理->分销设置", "编辑分销设置内容");
			message('更新成功', $this->createWebUrl('comsetting'), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}
	}

}elseif($op=='font'){
	$font = json_decode($comsetting['font'], true);
	if(checksubmit()){
		$data = array(
			'uniacid'	=> $uniacid,
			'font'		=> json_encode($_GPC['font']),
			'addtime'	=> time(),
		);
		if (empty($glo_comsetting)) {
			$result = pdo_insert($this->table_commission_setting, $data);
		} else {
			$result = pdo_update($this->table_commission_setting, $data, array('uniacid' => $uniacid));
		}

		if($result){
			/* 更新分销表缓存 */
			$comsetting = $this->getComsetting();
			$this->updateCache('fy_lessonv2_commission_setting_'.$uniacid, $comsetting);

			$this->addSysLog($_W['uid'], $_W['username'], 3, "分销管理->分销文字", "编辑分销文字");
			message('更新成功', $this->createWebUrl('comsetting', array('op'=>'font')), 'success');
		}else{
			message('更新失败，请稍候重试 ', '', 'error');
		}
	}
}


include $this->template('comsetting');

?>