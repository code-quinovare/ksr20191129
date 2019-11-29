<?php
/**
 * 分销(成员)管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */

if($op == 'display') {
	$agent_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_commission_level). " WHERE uniacid=:uniacid ORDER BY id ASC", array(':uniacid'=>$uniacid));

    $pindex    = max(1, intval($_GPC['page']));
    $psize     = 10;

	$condition = " a.uniacid=:uniacid ";
	$params[':uniacid'] = $uniacid;

	/* 会员昵称 */
    if (!empty($_GPC['nickname'])) {
        $condition .= " AND ( b.realname LIKE :nickname OR b.nickname LIKE :nickname OR b.mobile LIKE :nickname)";
		$params[':nickname'] = "%".trim($_GPC['nickname'])."%";
    }
	/* 会员ID */
	if (!empty($_GPC['uid'])) {
        $condition .= " AND b.uid=:uid ";
		$params[':uid'] = intval($_GPC['uid']);
    }
	/* 推荐人ID */
	if (intval($_GPC['parentid'])>0) {        
		$condition .= " AND a.parentid =:parentid ";
		$params[':parentid'] = intval($_GPC['parentid']);
    }
	/* 分销状态 */
	if ($_GPC['status'] != '') {
		$condition .= " AND a.status=:status";
		$params[':status'] = intval($_GPC['status']);
    }
	/* 分销级别 */
	if ($_GPC['agent_level'] != '') {
        $condition .= " AND a.agent_level=:agent_level";
		$params[':agent_level'] = $_GPC['agent_level'];
    }
	/* VIP身份 */
	if ($_GPC['vip'] != '') {
		$condition .= " AND a.vip=:vip";
		$params[':vip'] = intval($_GPC['vip']);
    }
	/* 加入时间 */
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

    $list  = pdo_fetchall("SELECT a.uid,a.parentid,a.nopay_commission,a.pay_commission,a.agent_level,a.status,a.addtime, b.mobile,b.realname,b.nickname,b.avatar FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition} ORDER BY a.id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
	foreach($list as $key=>$value){
		if(empty($value['avatar'])){
			$list[$key]['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$list[$key]['avatar'] = strstr($value['avatar'], "http://") ? $value['avatar'] : $_W['attachurl'].$value['avatar'];
		}

		$list[$key]['parent'] = pdo_fetch("SELECT nickname,avatar FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$value['parentid']));
		if(empty($list[$key]['parent']['avatar'])){
			$list[$key]['parent']['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$list[$key]['parent']['avatar'] = strstr($list[$key]['parent']['avatar'], "http://") ? $list[$key]['parent']['avatar'] : $_W['attachurl'].$list[$key]['parent']['avatar'];
		}
		$list[$key]['agent'] = $this->getAgentLevelName($value['agent_level']);
	}
    
	$total = pdo_fetchcolumn("SELECT count(a.id) FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition}", $params);
    $pager = pagination($total, $pindex, $psize);

	if($_GPC['export']==1){
		$list  = pdo_fetchall("SELECT a.uid,a.nopay_commission,a.pay_commission,a.agent_level,a.status, a.addtime, b.mobile,b.realname,b.nickname FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition} ORDER BY a.id", $params);
		
		foreach ($list as $key => $value) {
			$arr[$key]['uid']				= $value['uid'];
			$arr[$key]['nickname']			= $value['nickname'];
			$arr[$key]['realname']			= $value['realname'];
			$arr[$key]['mobile']			= $value['mobile'];
			$arr[$key]['status']			= $this->getAgentStatusName($value['status']);
			$arr[$key]['levelname']			= $this->getAgentLevelName($value['agent_level']);
			$arr[$key]['pay_commission']	= $value['pay_commission'];
			$arr[$key]['nopay_commission']	= $value['nopay_commission'];
			$arr[$key]['fans_count']		= $this->getFansCount($value['uid']);
			$arr[$key]['addtime']		    = date('Y-m-d H:i:s', $value['addtime']);
		}

		$this->exportexcel($arr, array('会员ID', '会员昵称', '真实姓名', '手机号码', '分销商状态', '分销商级别', '已结算佣金', '未结算佣金', '下级成员数量','加入时间'), "分销商列表");
		exit();
	}
}elseif($op=='detail'){
	$uid = intval($_GPC['uid']);
	$member = pdo_fetch("SELECT a.uid,a.parentid,a.nopay_commission,a.pay_commission,a.agent_level,a.payment_amount,a.payment_order,a.validity,a.status,a.addtime, b.mobile,b.nickname,b.realname,b.avatar,c.openid FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid LEFT JOIN " .tablename($this->table_fans). " c ON a.uid=c.uid WHERE a.uniacid=:uniacid AND a.uid=:uid", array(':uniacid'=>$uniacid,':uid'=>$uid));

	if(empty($member)){
		message("该会员不存在！");
	}
	
	if(empty($member['avatar'])){
		$member['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
	}else{
		$member['avatar'] = strstr($member['avatar'], "http://") ? $member['avatar'] : $_W['attachurl'].$member['avatar'];
	}

	/* 已开通VIP等级列表 */
	$viplist = pdo_fetchall("SELECT a.id,a.validity,b.level_name FROM " .tablename($this->table_member_vip). " a LEFT JOIN " .tablename($this->table_vip_level). " b ON a.level_id=b.id WHERE a.uniacid=:uniacid AND a.uid=:uid ORDER BY b.id ASC", array(':uniacid'=>$uniacid,':uid'=>$uid));

	/* 分销代理级别列表 */
	$levellist = pdo_fetchall("SELECT * FROM " .tablename($this->table_commission_level). " WHERE uniacid=:uniacid ORDER BY id ASC", array(':uniacid'=>$uniacid));
	/* 分销代理级别 */
	$levename= $this->getAgentLevelName($member['agent_level']);

	if(checksubmit('submit')){
		$realname	 = trim($_GPC['realname']);
		$mobile		 = trim($_GPC['mobile']);
		$parentid	 = intval($_GPC['parentid']);
		$status		 = intval($_GPC['status']);
		$checkmobile = pdo_fetch("SELECT mobile FROM " .tablename($this->table_mc_members). " WHERE uniacid=:uniacid AND mobile=:mobile LIMIT 1", array(':uniacid'=>$uniacid, ':mobile'=>$mobile));
		
		if(!empty($mobile)){
			if(!(preg_match("/1\d{10}/",$mobile))){
				message("手机号码格式错误！", "", "error");
			}
			if(!empty($checkmobile) && $member['mobile']!=$mobile){
				message("手机号码已存在！", "", "error");
			}
		}
		pdo_update($this->table_mc_members, array('realname'=>$realname,'mobile'=>$mobile), array('uniacid'=>$uniacid,'uid'=>$uid));
		cache_build_memberinfo($uid);

		$fymember = array();
		if($parentid == $uid){
			message("上级会员不能为自己！", "", "error");
		}
		if($parentid != $member['parentid']){
			if($parentid==0){
				$fymember['parentid']=0;
			}else{
				$new_member = pdo_fetch("SELECT * FROM " .tablename($this->table_member). " WHERE uid=:uid", array(':uid'=>$parentid));
				if(empty($new_member)){
					message("该上级会员不存在！");
				}

				$fymember['parentid'] = $parentid;
			}
		}
		$fymember['status'] = $status;
		$fymember['agent_level'] = intval($_GPC['agent_level']);
		pdo_update($this->table_member, $fymember, array('uniacid'=>$uniacid,'uid'=>$uid));
		cache_build_memberinfo($uid);

		$validity = $_GPC['validity'];
		if(!empty($validity)){
			foreach($validity as $k=>$v){
				pdo_update($this->table_member_vip, array('validity'=>strtotime($v)), array('id'=>$k));
			}
		}


		$remark = "编辑uid:{$uid}的分销商资料";
		if($member['parentid'] != $parentid){
			$remark .= "原上级ID[".$member['parentid']."]，现上级ID[".$parentid."]；";
		}
		if($member['agent_level'] != $fymember['agent_level']){
			$remark .= "原分销等级:".$member['agent_level']."[".$levename."]，现分销等级:".$fymember['agent_level']."[".$this->getAgentLevelName($fymember['agent_level'])."]；";
		}
		if($member['status'] != $status){
			$remark .= "原分销状态[".$member['status']."]，现分销状态[".$status."]；";
		}

		$this->addSysLog($_W['uid'], $_W['username'], 3, "分销管理->分销商管理", $remark);
		message("操作成功！", $_GPC['refurl'], "success");
	}
}elseif($op=='delete'){
	$uid = intval($_GPC['uid']);
	$member = pdo_fetch("SELECT * FROM " .tablename($this->table_member). " WHERE uid=:uid LIMIT 1", array(':uid'=>$uid));
	
	if(empty($member)){
		message("该分销成员不存在!", "", "error");
	}

	if(pdo_delete($this->table_member, array('uid'=>$uid))){
		$this->addSysLog($_W['uid'], $_W['username'], 2, "分销管理->分销商管理", "删除用户ID:[{$uid}]，昵称:[{$member['nickname']}]的分销商");
		message("删除成功!", $_GPC['refurl'], "success");
	}else{
		message("删除失败!", "", "error");
	}
}

include $this->template('agent');

?>