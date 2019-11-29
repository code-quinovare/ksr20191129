<?php
/**
 * 个人中心
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();
$uid = $_W['member']['uid'];

$member = pdo_fetch("SELECT a.*,b.credit1,b.credit2,b.nickname,b.avatar,b.mobile,b.realname,b.msn,b.occupation,b.company,b.graduateschool,b.grade,b.address FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uid=:uid LIMIT 1", array(':uid'=>$uid));

if(empty($member['avatar'])){
	$member['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
}else{
	$member['avatar'] = strstr($member['avatar'], "http://") ? $member['avatar'] : $_W['attachurl'].$member['avatar'];
}

if($op=='display'){
	$title = '我的VIP服务';
	$comsetting['vipdesc'] = htmlspecialchars_decode($comsetting['vipdesc']);
	
	/*VIP等级列表*/
	$level_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid AND is_show=:is_show ORDER BY sort DESC", array(':uniacid'=>$uniacid,':is_show'=>1));
	foreach($level_list as $k=>$v){
		$memberVip = pdo_fetch("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND level_id=:level_id AND validity>:validity", array(':uid'=>$uid,':level_id'=>$v['id'],':validity'=>time()));
		if(!empty($memberVip)) $level_list[$k]['renew'] = 1;
	}
	
	/*我的VIP等级列表*/	
	$memberVip_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$uid,':validity'=>time()));
	foreach($memberVip_list as $k=>$v){
		$memberVip_list[$k]['level'] = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$v['level_id']));
	}

	/* 随机获取客服列表 */
	if($_GPC['ispay']==1 && $member['gohome']==0){
		$service = json_decode($setting['qun_service'], true);
		if(!empty($service)){
			$rand = rand(0, count($service)-1);
			$now_service = $service[$rand];
		}
	}

	include $this->template('vip');
	
}elseif($op=='buyvip'){
	$level_id = intval($_GPC['level_id']);
	
	$level = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$level_id));
	if(empty($level)){
		message("该VIP等级不存在", "", "error");
	}

	if ($setting['mustinfo'] == 1) {
		$user_info = json_decode($setting['user_info']);
		if(in_array('mobile',$user_info) && empty($member['mobile'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('realname',$user_info) && empty($member['realname'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('msn',$user_info) && empty($member['msn'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('occupation',$user_info) && empty($member['occupation'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('company',$user_info) && empty($member['company'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('graduateschool',$user_info) && empty($member['graduateschool'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('grade',$user_info) && empty($member['grade'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
		if(in_array('address',$user_info) && empty($member['address'])){
			 message("请完善您的个人信息", $this->createMobileUrl('writemsg', array('type' => 'vip')), "warning");
		}
	}

	/* 构造购买会员订单信息 */
	$orderdata = array(
		'acid'	    => $_W['account']['acid'],
		'uniacid'   => $uniacid,
		'ordersn'   => date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),
		'uid'	    => $uid,
		'level_id'  => $level_id,
		'level_name'=> $level['level_name'],
		'viptime'   => $level['level_validity'],
		'vipmoney'  => $level['level_price'],
		'integral'	=> $level['integral'],
		'addtime'   => time(),
	);

	/* 检查当前分销功能是否开启且课程价格大于0 */
	if($comsetting['is_sale']==1 && $comsetting['vip_sale']==1){
		$orderdata['commission1'] = 0;
		$orderdata['commission2'] = 0;
		$orderdata['commission3'] = 0;

		if($comsetting['self_sale']==1){
			/* 开启分销内购，一级佣金为购买者本人 */
			$orderdata['member1'] = $uid;
			$orderdata['member2'] = $this->getParentid($uid);
			$orderdata['member3'] = $this->getParentid($orderdata['member2']);
		}else{
			/* 关闭分销内购 */
			$orderdata['member1'] = $this->getParentid($uid);;
			$orderdata['member2'] = $this->getParentid($orderdata['member1']);
			$orderdata['member3'] = $this->getParentid($orderdata['member2']);
		}

		$vipordercom = unserialize($comsetting['viporder_commission']); /* VIP订单佣金比例 */
		$settingcom = unserialize($comsetting['commission']);/* 全局佣金比例 */
		if($orderdata['member1']>0){
			/* 查询用户是否属于其他分销代理级别 */
			$member1 = pdo_fetch("SELECT agent_level FROM " .tablename($this->table_member). " WHERE uid=:uid", array(':uid'=>$orderdata['member1']));
			$com_level = pdo_fetch("SELECT commission1 FROM " .tablename($this->table_commission_level). " WHERE id=:id", array(':id'=>$member1['agent_level']));

			if($vipordercom['commission1']>0){
				$orderdata['commission1'] = round($orderdata['vipmoney']*$vipordercom['commission1']*0.01, 2);
			}else{
				if($com_level['commission1']>0){
					$orderdata['commission1'] = round($orderdata['vipmoney']*$com_level['commission1']*0.01, 2);
				}else{
					$orderdata['commission1'] = round($orderdata['vipmoney']*$settingcom['commission1']*0.01, 2);
				}
			}
		}
		if($orderdata['member2']>0 && in_array($comsetting['level'], array('2','3'))){
			/* 查询用户是否属于其他分销代理级别 */
			$member2 = pdo_fetch("SELECT agent_level FROM " .tablename($this->table_member). " WHERE uid=:uid", array(':uid'=>$orderdata['member2']));
			$com_level = pdo_fetch("SELECT commission2 FROM " .tablename($this->table_commission_level). " WHERE id=:id", array(':id'=>$member2['agent_level']));

			if($vipordercom['commission2']>0){
				$orderdata['commission2'] = round($orderdata['vipmoney']*$vipordercom['commission2']*0.01, 2);
			}else{
				if($com_level['commission2']>0){
					$orderdata['commission2'] = round($orderdata['vipmoney']*$com_level['commission2']*0.01, 2);
				}else{
					$orderdata['commission2'] = round($orderdata['vipmoney']*$settingcom['commission2']*0.01, 2);
				}
			}
		}
		if($orderdata['member3']>0 && $comsetting['level']==3){
			/* 查询用户是否属于其他分销代理级别 */
			$member3 = pdo_fetch("SELECT agent_level FROM " .tablename($this->table_member). " WHERE uid=:uid", array(':uid'=>$orderdata['member3']));
			$com_level = pdo_fetch("SELECT commission3 FROM " .tablename($this->table_commission_level). " WHERE id=:id", array(':id'=>$member3['agent_level']));

			if($vipordercom['commission3']>0){
				$orderdata['commission3'] = round($orderdata['vipmoney']*$vipordercom['commission3']*0.01, 2);
			}else{
				if($com_level['commission3']>0){
					$orderdata['commission3'] = round($orderdata['vipmoney']*$com_level['commission3']*0.01, 2);
				}else{
					$orderdata['commission3'] = round($orderdata['vipmoney']*$settingcom['commission3']*0.01, 2);
				}
			}
		}
	}

	if($uid>0){
		$result = pdo_insert($this->table_member_order, $orderdata);
		$orderid = pdo_insertid();
	}
	
	if($result){
		header("Location:".$this->createMobileUrl('pay', array('orderid'=>$orderid, 'ordertype'=>'buyvip')));
	}else{
		message("写入订单信息失败，请重试！", $this->createMobileUrl('vip'), "error");
	}
}elseif($op=='ajaxgetlist'){
	/* 购买会员VIP服务订单 */
	$pindex =max(1,$_GPC['page']);
	$psize = 5;

	$memberorder_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_order). " WHERE uid=:uid AND status=:status ORDER BY id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':uid'=>$uid,':status'=>1));
	foreach($memberorder_list as $key=>$value){
		$memberorder_list[$key]['addtime'] = date('Y-m-d H:i', $value['addtime']);
		$memberorder_list[$key]['paytime'] = $value['paytime']>0?date('Y-m-d H:i', $value['paytime']):'';
		$memberorder_list[$key]['status']  = $value['status']==0?'未支付':'购买成功';
		if($value['paytype']=='credit'){
			$memberorder_list[$key]['paytype'] = '余额支付';
		}elseif($value['paytype']=='wechat'){
			$memberorder_list[$key]['paytype'] = '微信支付';
		}elseif($value['paytype']=='alipay'){
			$memberorder_list[$key]['paytype'] = '支付宝支付';
		}elseif($value['paytype']=='vipcard'){
			$memberorder_list[$key]['paytype'] = '服务卡支付';
		}elseif($value['paytype']=='admin'){
			$memberorder_list[$key]['paytype'] = '后台支付';
		}
		$level = pdo_fetch("SELECT level_name FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$value['level_id']));
		$memberorder_list[$key]['level_name'] = $level['level_name'] ? $level['level_name'] : "默认等级";
	}

	echo json_encode($memberorder_list);

}elseif($op=='vipcard'){
	$title = 'VIP服务卡开通服务';

	if(checksubmit('submit')){
		$password = trim($_GPC['card_password']);
		$vipcard = pdo_fetch("SELECT * FROM " .tablename($this->table_vipcard). " WHERE uniacid=:uniacid AND password=:password AND is_use=0 AND validity>:time ", array(':uniacid'=>$uniacid, ':password'=>$password, ':time'=>time()));
		if(!$vipcard){
			message("该服务卡不存在或已被使用", $this->createMobileUrl('vip', array('op'=>'vipcard','code'=>$password)), "warning");
		}
		if(!$vipcard['level_id']){
			message("该服务卡已暂停使用", $this->createMobileUrl('vip', array('op'=>'vipcard','code'=>$password)), "warning");
		}
		
		$memberVip = pdo_fetch("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND level_id=:level_id", array(':uid'=>$uid,':level_id'=>$vipcard['level_id']));
		$newLevel = $this->getLevelById($vipcard['level_id']);
		if(!empty($memberVip)){
			if(time()>=$memberVip['validity']){
				$vipData = array(
					'validity' => time()+$vipcard['viptime']*86400,
					'discount'=> $newLevel['discount'],
					'update_time' => time(),
				);
			}else{
				$vipData = array(
					'validity' => $memberVip['validity']+$vipcard['viptime']*86400,
					'discount'=> $newLevel['discount'],
					'update_time' => time(),
				);
			}
			$result = pdo_update($this->table_member_vip, $vipData, array('id'=>$memberVip['id']));
		}else{
			$vipData = array(
				'uniacid' => $uniacid,
				'uid'	  => $uid,
				'level_id'=> $vipcard['level_id'],
				'validity'=> time()+$vipcard['viptime']*86400,
				'discount'=> $newLevel['discount'],
				'addtime' => time(),
			);
			$result = pdo_insert($this->table_member_vip, $vipData);
		}
		
		if($result){
			/* 构造购买会员订单信息 */
			$orderdata = array(
				'acid'		=> $_W['account']['acid'],
				'uniacid'	=> $uniacid,
				'ordersn'	=> date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8),
				'uid'		=> $uid,
				'level_id'  => $newLevel['id'],
				'level_name'=> $newLevel['level_name'],
				'viptime'	=> $vipcard['viptime'],
				'vipmoney'	=> '0.00',
				'paytype'	=> 'vipcard',
				'status'	=> 1,
				'paytime'	=> time(),
				'refer_id'	=> $vipcard['id'],
				'addtime'	=> time(),
			);
			pdo_insert($this->table_member_order, $orderdata);

			$vipcardData = array(
				'is_use'	=> 1,
				'nickname'	=> $member['nickname'],
				'uid'		=> $uid,
				'ordersn'	=> $orderdata['ordersn'],
				'use_time'	=> $orderdata['addtime'],
			);
			pdo_update($this->table_vipcard, $vipcardData, array('uniacid'=>$uniacid,'id'=>$vipcard['id']));
			
			/* 更新会员vip字段 */
			$this->updateMemberVip($uid, 1);
			
			$fans = pdo_fetch("SELECT openid FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$uid));
			$tplmessage = pdo_fetch("SELECT buysucc FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

			/* 发送模版消息 */
			$sendmessage = array(
				'touser'      => $fans['openid'],
				'template_id' => $tplmessage['buysucc'],
				'url'         => $_W['siteroot'] ."app/index.php?i={$uniacid}&c=entry&do=vip&m=fy_lessonv2",
				'topcolor'    => "#7B68EE",
				'data'        => array(
					 'name'	  => array(
						 'value' => "开通/续费：[".$newLevel['level_name']."]-".$vipcard['viptime']."天",
						 'color' => "#26b300",
					 ),
					 'remark' => array(
						 'value' => "\n有效期至：".date('Y-m-d H:i:s', $vipData['validity']),
						 'color' => "#e40606",
					 ),
			 
				  )
			);
			$this->send_template_message(urldecode(json_encode($sendmessage)),$orderdata['acid']);

			message("开通成功", $this->createMobileUrl('vip'), "success");
		}else{
			message("更新会员VIP状态失败，请稍候重试", $this->createMobileUrl('vip', array('op'=>'vipcard','code'=>$password)), "error");
		}
		
	}
	

	include $this->template('vip');

}elseif($op=='gohome'){
	$result = pdo_update($this->table_member, array('gohome'=>1), array('uid'=>$uid));

	echo $this->resultJson($result);
}

?>