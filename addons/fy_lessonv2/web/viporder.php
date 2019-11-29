<?php
/**
 * 会员VIP服务订单管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */
load()->model('mc');

if ($op == 'display') {
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = " a.uniacid = :uniacid";
	$params[':uniacid'] = $uniacid;

	if (!empty($_GPC['ordersn'])) {
		$condition .= " AND a.ordersn LIKE :ordersn ";
		$params[':ordersn'] = "%{$_GPC['ordersn']}%";
	}
	if ($_GPC['status']!='') {
		$condition .= " AND a.status=:status ";
		$params[':status'] = $_GPC['status'];
	}
	if (!empty($_GPC['nickname'])) {
		$condition .= " AND b.nickname LIKE :nickname ";
		$params[':nickname'] = "%{$_GPC['nickname']}%";
	}
	if (!empty($_GPC['time']['start'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		$endtime = !empty($endtime) ? $endtime + 86399 : 0;
		if (!empty($starttime)) {
			$condition .= " AND a.addtime>=:starttime ";
			$params[':starttime'] = $starttime;
		}
		if (!empty($endtime)) {
			$condition .= " AND a.addtime<=:endtime ";
			$params[':endtime'] = $endtime;
		}
	}

	$list = pdo_fetchall("SELECT a.*,b.nickname,b.realname,b.mobile FROM " .tablename($this->table_member_order). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition} ORDER BY a.id desc, a.addtime DESC LIMIT " .($pindex - 1) * $psize. ',' . $psize, $params);
	foreach($list as $k=>$v){
		$list[$k]['level'] = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$v['level_id']));
	}
	
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' .tablename($this->table_member_order). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition}", $params);
	$pager = pagination($total, $pindex, $psize);

	if($_GPC['export']){
		$outputlist = pdo_fetchall("SELECT a.*,b.nickname,b.realname,b.mobile FROM " .tablename($this->table_member_order). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition} ORDER BY a.id desc, a.addtime DESC", $params);

		$i = 0;
		foreach ($outputlist as $key => $value) {
			$level = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$value['level_id']));
			$level_name = $level['level_name'] ? $level['level_name'] : "默认VIP";
			
			$arr[$i]['ordersn']         = $value['ordersn'];
			$arr[$i]['nickname']        = $value['nickname'];
			$arr[$i]['realname']        = $value['realname'];
			$arr[$i]['mobile']          = $value['mobile'];
			$arr[$i]['viptime']         = $level_name ."-". $value['viptime']."天";
			$arr[$i]['vipmoney']        = $value['vipmoney'];
			$arr[$i]['commission1']     = $value['commission1'];
			$arr[$i]['commission2']     = $value['commission2'];
			$arr[$i]['commission3']     = $value['commission3'];
			if($value['paytype'] == 'credit'){
				$arr[$i]['paytype'] = "余额支付";
			}elseif($value['paytype'] == 'wechat'){
				$arr[$i]['paytype'] = "微信支付";
			}elseif($value['paytype'] == 'alipay'){
				$arr[$i]['paytype'] = "支付宝支付";
			}elseif($value['paytype'] == 'offline'){
				$arr[$i]['paytype'] = "线下支付";
			}elseif($value['paytype'] == 'admin'){
				$arr[$i]['paytype'] = "后台支付";
			}elseif($value['paytype'] == 'vipcard'){
				$arr[$i]['paytype'] = "服务卡支付";
			}else{
				$arr[$i]['paytype'] = "无";
			}
			
			if($value['status'] == '0'){
				$arr[$i]['status'] = "未支付";
			}elseif($value['status'] == '1'){
				$arr[$i]['status'] = "已付款";
			}
			$arr[$i]['addtime']         = date('Y-m-d H:i:s', $value['addtime']);
			$i++;
		}
	 
		$this->exportexcel($arr, array('订单编号', '昵称', '姓名','手机号码', '服务时长', '服务价格', '一级佣金', '二级佣金', '三级佣金', '付款方式', '订单状态', '下单时间'), $filename="服务卡订单");
		exit();
	}

}elseif ($op == 'detail') {
	$id = intval($_GPC['id']);
	$order = pdo_fetch("SELECT a.*,b.nickname,b.realname,b.mobile,b.msn,b.occupation,b.company,b.graduateschool,b.grade,b.address,b.avatar FROM " .tablename($this->table_member_order). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uniacid=:uniacid AND a.id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
	if (empty($order)) {
		message('该订单不存在或已被删除!');
	}
	if($order['paytype']=='wechat'){
		$wechatPay = $this->getWechatPayNo($order['id']);
		$wechatPay['transaction'] = unserialize($wechatPay['tag']);
	}
	
	if(empty($order['avatar'])){
		$avatar = MODULE_URL."template/mobile/images/default_avatar.jpg";
	}else{
		$inc = strstr($order['avatar'], "http://");
		$avatar = $inc ? $order['avatar'] : $_W['attachurl'].$order['avatar'];
	}

	if($order['member1']>0){
		$member1 = pdo_fetch("SELECT nickname,avatar FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$order['member1']));
		if(empty($member1['avatar'])){
			$avatar1 = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$avatar1 = strstr($member1['avatar'], "http://") ? $member1['avatar'] : $_W['attachurl'].$member1['avatar'];
		}
	}
	if($order['member2']>0){
		$member2 = pdo_fetch("SELECT nickname,avatar FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$order['member2']));
		if(empty($member2['avatar'])){
			$avatar2 = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$avatar2 = strstr($member2['avatar'], "http://") ? $member2['avatar'] : $_W['attachurl'].$member2['avatar'];
		}
	}
	if($order['member3']>0){
		$member3 = pdo_fetch("SELECT nickname,avatar FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$order['member3']));
		if(empty($member3['avatar'])){
			$avatar3 = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$avatar3 = strstr($member3['avatar'], "http://") ? $member3['avatar'] : $_W['attachurl'].$member3['avatar'];
		}
	}


}elseif ($op == 'delete') {
	$id = $_GPC['id'];
	$order = pdo_fetch("SELECT ordersn FROM " .tablename($this->table_member_order). " WHERE uniacid=:uniacid AND id=:id LIMIT 1", array(':uniacid'=>$uniacid, ':id'=>$id));
	if(empty($order)){
		message("该订单不存在或已被删除", "", "error");
	}

	$res = pdo_delete($this->table_member_order, array('uniacid'=>$uniacid,'id' => $id));
	if($res){
		$this->addSysLog($_W['uid'], $_W['username'], 2, "VIP订单", "删除订单编号:{$order['ordersn']}的VIP订单");
	}

	echo "<script>alert('删除成功！');location.href='".$this->createWebUrl('viporder', array('op' => 'display', 'page' => $_GPC['page']))."';</script>";

}elseif($op=='createOrder'){
	$level_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

	if(checksubmit('submit')){
		$data = array(
			'uniacid'	=> $uniacid,
			'uid'		=> intval($_GPC['uid']),
			'level_id'	=> intval($_GPC['level_id']),
			'validity'	=> strtotime($_GPC['validity']),
		);

		if(empty($data['uid'])){
			message("请选择用户", $this->createWebUrl('viporder', array('op'=>'createOrder')), "error");
		}
		if(empty($data['level_id'])){
			message("请选择要开通的有效期", $this->createWebUrl('viporder', array('op'=>'createOrder')), "error");
		}
		if($data['validity'] < time()){
			message("有效期不能小于当前时间", $this->createWebUrl('viporder', array('op'=>'createOrder')), "error");
		}

		/*检查会员等级是否存在*/
		$level = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid, ':id'=>$data['level_id']));
		if(empty($level)){
			message("该会员等级不存在，请重新选择", $this->createWebUrl('viporder', array('op'=>'createOrder')), "error");
		}
		$data['discount'] = $level['discount'];

		/*检查会员是否开通过该等级*/
		$member_vip = pdo_fetch("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uniacid=:uniacid AND uid=:uid AND level_id=:level_id", array(':uniacid'=>$uniacid, ':uid'=>$data['uid'], ':level_id'=>$data['level_id']));
		if(empty($member_vip)){
			$data['addtime'] = time();
			$res = pdo_insert($this->table_member_vip, $data);
		}else{
			$data['update_time'] = time();
			$res = pdo_update($this->table_member_vip, $data, array('id'=>$member_vip['id']));
		}

		if($res){
			/* 添加VIP服务订单 */
			$days = ceil(($data['validity']-time())/86400);
			$vipOrder = array(
				'acid' => $_W['acid'],
				'uniacid' => $uniacid,
				'ordersn' => date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),
				'uid' => $data['uid'],
				'viptime' => $days,
				'vipmoney' => 0,
				'paytype' => 'admin',
				'status' => 1,
				'paytime' => time(),
				'addtime' => time(),
				'level_id' => $data['level_id'],
				'level_name' => $level['level_name'],
			);
			pdo_insert($this->table_member_order, $vipOrder);

			/* 更新会员vip字段 */
			$this->updateMemberVip($data['uid'], 1);

			/* 写入系统日志 */
			$this->addSysLog($_W['uid'], $_W['username'], 1, "VIP订单->创建VIP服务", "给[uid:".$data['uid']."]的会员开通[id:".$level['id']." - ".$level['level_name']."]的VIP等级，有效期至:".$_GPC['validity']);
			message("创建会员VIP成功", $this->createWebUrl('viporder', array('op'=>'createOrder')), "success");
		}else{
			message("创建会员VIP失败，请稍候重试", "", "error");
		}

	}

}elseif($op=='vipcard'){
	/* VIP等级列表 */
	$level_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
	
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;
	$time = time();

	$condition = " uniacid = '{$uniacid}' ";
	if (!empty($_GPC['ordersn'])) {
		$condition .= " AND ordersn LIKE '%{$_GPC['ordersn']}%' ";
	}
	if (!empty($_GPC['nickname'])) {
		$condition .= " AND nickname LIKE '%{$_GPC['nickname']}%' ";
	}
	if ($_GPC['is_use'] != '') {
		if($_GPC['is_use']==0){
			$condition .= " AND is_use=0 AND validity>'{$time}' ";
		}elseif($_GPC['is_use']==1){
			$condition .= " AND is_use='{$_GPC['is_use']}' ";
		}elseif($_GPC['is_use']==-1){
			$condition .= " AND is_use=0 AND validity<'{$time}' ";
		}
	}
	if (!empty($_GPC['level_id'])) {
		$condition .= " AND level_id={$_GPC['level_id']} ";
	}
	if (!empty($_GPC['time']['start'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		$endtime = !empty($endtime) ? $endtime + 86399 : 0;
		if (!empty($starttime)) {
			$condition .= " AND use_time >= '{$starttime}' ";
		}
		if (!empty($endtime)) {
			$condition .= " AND use_time < '{$endtime}' ";
		}
	}

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vipcard). " WHERE {$condition} ORDER BY addtime DESC LIMIT " .($pindex - 1) * $psize. ',' . $psize);
	foreach($list as $k=>$v){
		$list[$k]['level'] = $this->getLevelById($v['level_id']);
	}
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' .tablename($this->table_vipcard). " WHERE {$condition}");
	$pager = pagination($total, $pindex, $psize);

	if($_GPC['export']==1){
		$outputlist = pdo_fetchall("SELECT * FROM " .tablename($this->table_vipcard). " WHERE {$condition} ORDER BY addtime DESC");

		$i = 0;
		foreach ($outputlist as $key => $value) {
			$level = $this->getLevelById($v['level_id']);
			
			$arr[$i]['card_id']		= $value['card_id'];
			$arr[$i]['password']	= $value['password'];
			$arr[$i]['level_name']	= $level['level_name'];
			$arr[$i]['viptime']		= $value['viptime'];
			$arr[$i]['validity']	= date('Y-m-d H:i:s',$value['validity']);
			if($value['is_use']==1){
				$status = "已使用";
			}elseif($value['is_use']==0 && $value['validity']>time()){
				$status = "未使用";
			}elseif($value['is_use']==0 && $value['validity']<time()){
				$status = "已过期";
			}
			$arr[$i]['is_use']		= $status;
			$arr[$i]['nickname']    = $value['nickname'];
			$arr[$i]['ordersn']     = $value['ordersn'];
			$arr[$i]['use_time']    = $value['use_time']?date('Y-m-d H:i:s', $value['use_time']):'';
			$arr[$i]['addtime']     = date('Y-m-d H:i:s', $value['addtime']);
			$i++;
		}
	 
		$this->exportexcel($arr, array('服务卡号', '卡密','VIP等级', '卡时长(天)','有效期', '卡状态', '使用者', '订单号', '使用时间', '添加时间'), "VIP服务卡");
		exit();
	}

}elseif($op=='delCard'){
	$id = $_GPC['id'];
	$card = pdo_fetch("SELECT password FROM " .tablename($this->table_vipcard). " WHERE uniacid=:uniacid AND id=:id LIMIT 1", array(':uniacid'=>$uniacid, ':id'=>$id));
	if(empty($card)){
		message("该VIP服务卡不存在或已被删除", "", "error");
	}
	$res = pdo_delete($this->table_vipcard, array('uniacid'=>$uniacid,'id' => $id));
	if($res){
		$this->addSysLog($_W['uid'], $_W['username'], 2, "VIP服务卡", "删除服务卡密:{$card['password']}的VIP服务卡");
	}

	echo "<script>alert('删除成功！');location.href='".$this->createWebUrl('viporder', array('op' => 'vipcard', 'page' => $_GPC['page']))."';</script>";

}elseif($op=='delAllCard'){
	$ids = $_GPC['ids'];
	if(!empty($ids) && is_array($ids)){
		$num = 0;
		$card = "";
		foreach($ids as $id){
			$card .= $this->getVipCardPwd($id).",";
			if(pdo_delete($this->table_vipcard, array('uniacid'=>$uniacid,'id' => $id))){
				$num++;
			}
		}

		$card = trim($card, ",");
		$this->addSysLog($_W['uid'], $_W['username'], 2, "VIP服务卡", "批量删除{$num}个VIP服务卡,[{$card}]");
		message("批量删除成功", $this->createWebUrl('viporder', array('op'=>'vipcard')), "success");
	}else{
		message("未选中任何服务卡", "", "error");
	}

}elseif($op=='addVipCode'){
	$level_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid ORDER BY sort DESC", array(':uniacid'=>$uniacid));
	if(checksubmit('submit')){
		$prefix = trim($_GPC['prefix']);
		$level_id = intval($_GPC['level_id']);
		$number = intval($_GPC['number']);
		$days = floatval($_GPC['days']);
		$validity = strtotime($_GPC['validity']);
		
		$level = $this->getLevelById($level_id);

		if(strlen($prefix) != 2){
			message("请输入服务卡的两位前缀", "", "error");
		}
		if(empty($level_id)){
			message("请选择的VIP等级", "", "error");
		}
		if(empty($level)){
			message("选择的VIP等级不存在", "", "error");
		}
		if($number < 1){
			message("请输入正确的服务卡数量", "", "error");
		}
		if($number > 500){
			message("单次生成服务卡不要超过500张", "", "error");
		}
		if($validity < time()){
			message("有效期必须大于当前时间", "", "error");
		}

		set_time_limit(120);
		ob_end_clean();
		ob_implicit_flush(true);
		str_pad(" ", 256);

		$total = 0;
		for($i=1;$i<=$number;$i++){
			$rand = mt_rand(0, 9999).mt_rand(0, 99999);
			$card_id = rand(1,9).str_pad($rand, 9, '0', STR_PAD_LEFT);

			$seek=mt_rand(0,9999).mt_rand(0,9999).mt_rand(0,9999).mt_rand(0,9999);
			$start=mt_rand(0,16);
			$str=strtoupper(substr(md5($seek),$start,16));
			$str=str_replace("O",chr(mt_rand(65,78)),$str);
			$str=str_replace("0",chr(mt_rand(65,78)),$str);

			$vipData = array(
				'uniacid'	=> $uniacid,
				'card_id'   => $card_id,
				'password'	=> $prefix.$str,
				'level_id'  => $level_id,
				'viptime'	=> $days,
				'validity'	=> $validity,
				'addtime'   => time()
			);
			if(pdo_insert($this->table_vipcard, $vipData)){
				$total++;
				unset($vipData);
			}
		}

		if($total){
			$this->addSysLog($_W['uid'], $_W['username'], 1, "VIP订单->VIP服务卡", "成功生成{$total}个有效期为{$days}天的服务卡");
		}
		message("成功生成{$total}个服务卡", $this->createWebUrl('viporder', array('op'=>'vipcard')), "success");
	}
}elseif($op=='updateVip'){
	$level_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
	
	if(checksubmit('submit')){
		$level_id = intval($_GPC['level_id']);
		$level = $this->getLevelById($level_id);
		if(empty($level)){
			message("指定VIP等级不存在", "", "error");
		}
		
		$member_list = pdo_fetchall("SELECT uid,vip,validity FROM " .tablename($this->table_member). " WHERE uniacid=:uniacid AND vip=:vip AND validity>:validity", array(':uniacid'=>$uniacid,':vip'=>1, ':validity'=>time()));
		$t = 0;
		foreach($member_list as $member){
			$memberVip = pdo_fetch("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND  level_id=:level_id", array(':uid'=>$member['uid'],':level_id'=>$level_id));
			if(empty($memberVip)){
				$data = array(
					'uniacid' => $uniacid,
					'uid'	  => $member['uid'],
					'level_id'=> $level_id,
					'validity'=> $member['validity'],
					'discount'=> $level['discount'],
					'addtime' => time(),
				);
				if(pdo_insert($this->table_member_vip, $data)){
					$t++;
				}
			}
		}
		
		
		$lesson_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_lesson_parent). " WHERE uniacid=:uniacid AND vipview=:vipview", array(':uniacid'=>$uniacid,':vipview'=>1));
		$s=0;
		foreach($lesson_list as $v){
			$lessonData = array(
				'vipview'=>json_encode(array("{$level_id}"))
			);
			if(pdo_update($this->table_lesson_parent, $lessonData, array('id'=>$v['id']))){
				$s++;
			}
		}
		
		message("成功同步{$t}位用户VIP信息，{$s}个课程", "", "success");
	}
}

include $this->template('viporder');

?>