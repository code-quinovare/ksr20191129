<?php
/**
 * 分销佣金管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */

$pindex = max(1, intval($_GPC['page']));
$psize = 10;

if($op=='level'){
	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_commission_level). " WHERE uniacid=:uniacid ORDER BY id ASC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid'=>$uniacid));

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_commission_level) . " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
	$pager = pagination($total, $pindex, $psize);

}elseif($op=='editlevel'){
	$id = intval($_GPC['id']);
	if($id>0){
		$level = pdo_fetch("SELECT * FROM " .tablename($this->table_commission_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
		if(empty($level)){
			message("该分销商等级不存在或已被删除", "", "error");
		}
	}

	if(checksubmit('submit')){
		$data = array(
			'uniacid'	  => $uniacid,
			'levelname'   => trim($_GPC['levelname']),
			'commission1' => floatval($_GPC['commission1']),
			'commission2' => floatval($_GPC['commission2']),
			'commission3' => floatval($_GPC['commission3']),
			'updatemoney' => floatval($_GPC['updatemoney']),
		);
		if(empty($data['levelname'])){
			message("请输入等级名称");
		}
		if(empty($data['commission1'])){
			message("请输入一级分销比例");
		}

		if(empty($id)){
			pdo_insert($this->table_commission_level, $data);
			$id = pdo_insertid();
			if($id){
				$this->addSysLog($_W['uid'], $_W['username'], 1, "分销管理->分销商等级", "新增ID:{$id}的分销商等级");
			}
		}else{
			$res = pdo_update($this->table_commission_level, $data, array('uniacid'=>$uniacid, 'id'=>$id));
			if($res){
				$this->addSysLog($_W['uid'], $_W['username'], 3, "分销管理->分销商等级", "编辑ID:{$id}的分销商等级");
			}
		}

		message("操作成功", $this->createWebUrl("commission", array('op'=>'level')), "success");
	}

}elseif($op=='dellevel'){
	$id = intval($_GPC['id']);
	$level = pdo_fetch("SELECT * FROM " .tablename($this->table_commission_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
	
	if(empty($level)){
		message("该分销商等级不存在或已被删除", "", "error");
	}

	$res = pdo_delete($this->table_commission_level, array('uniacid'=>$uniacid, 'id'=>$id));
	if($res){
		if($res){
			$this->addSysLog($_W['uid'], $_W['username'], 2, "分销管理->分销商等级", "删除ID:{$res}的分销商等级");
		}
	}

	message("删除成功", $this->createWebUrl("commission", array('op'=>'level')), "success");
	
}elseif($op=='commissionlog'){
	$nickname = trim($_GPC['nickname']);
	$bookname = trim($_GPC['bookname']);
	$grade	  = intval($_GPC['grade']);
	$remark	  = trim($_GPC['remark']);

	$condition = " uniacid='{$uniacid}' ";
	if (empty($starttime) || empty($endtime)) {
		$starttime = strtotime('-1 month');
		$endtime   = time();
	}
	if (!empty($_GPC['time'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime   = strtotime($_GPC['time']['end'])+86399;
	}
	$condition .= " AND addtime>=:starttime AND addtime<:endtime";
	$params[':starttime'] = $starttime;
	$params[':endtime'] = $endtime;

	if(!empty($nickname)){
		$condition .= " AND nickname LIKE :nickname ";
		$params[':nickname'] = "%".$nickname."%";
	}

	if(!empty($bookname)){
		$condition .= " AND bookname LIKE :bookname ";
		$params[':bookname'] = "%".$bookname."%";
	}
	if(!empty($grade)){
		$condition .= " AND grade = :grade ";
		$params[':grade'] = $grade;
	}
	if(!empty($remark)){
		$condition .= " AND remark LIKE :remark ";
		$params[':remark'] = $remark;
	}

	$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_commission_log) . " WHERE {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_commission_log) . " WHERE {$condition} ", $params);
	$pager = pagination($total, $pindex, $psize);

	/* 导出excel表格 */
	if($_GPC['export']==1){
		$lists = pdo_fetchall("SELECT * FROM " . tablename($this->table_commission_log) . " WHERE {$condition} ORDER BY id DESC", $params);
		$i = 0;
		foreach ($lists as $key => $value) {
			$arr[$i]['id']			   = $value['id'];
			$arr[$i]['nickname']       = $value['nickname'];
			$arr[$i]['openid']         = $value['openid'];
			$arr[$i]['bookname']       = $value['bookname'];
			if($value['grade'] == '1'){
				$arr[$i]['grade'] = "一级分销";
			}elseif($value['grade'] == '2'){
				$arr[$i]['grade'] = "二级分销";
			}elseif($value['grade'] == '3'){
				$arr[$i]['grade'] = "三级分销";
			}
			$arr[$i]['change_num']      = $value['change_num']."元";
			$arr[$i]['remark']		    = $value['remark'];
			$arr[$i]['addtime']         = date('Y-m-d H:i:s',$value['addtime']);
			$i++;
		}
	 
		$this->exportexcel($arr, array('ID', '会员信息', '会员openid', '分销课程', '分销等级', '分销佣金', '备注', '分销时间'), "分销佣金明细-".date('Y-m-d',time()));
		exit();
	}

}elseif($op=='statis'){
	$nickname = trim($_GPC['nickname']);
	$realname = trim($_GPC['realname']);
	$mobile	  = trim($_GPC['mobile']);
	$ranking  = intval($_GPC['ranking']);

	$condition = " a.uniacid='{$uniacid}' ";

	if(!empty($nickname)){
		$condition .= " AND b.nickname LIKE :nickname ";
		$params[':nickname'] = "%".$nickname."%";
	}
	if(!empty($realname)){
		$condition .= " AND b.realname LIKE :realname ";
		$params[':realname'] = "%".$realname."%";
	}
	if(!empty($mobile)){
		$condition .= " AND b.mobile LIKE :mobile ";
		$params[':mobile'] = "%".$mobile."%";
	}
	if(empty($ranking) || $ranking==1){
		$ORDER = " ORDER BY total_commission DESC ";
	}elseif($ranking==2){
		$ORDER = " ORDER BY pay_commission DESC ";
	}elseif($ranking==3){
		$ORDER = " ORDER BY nopay_commission DESC ";
	}

	$list = pdo_fetchall("SELECT a.nopay_commission,a.pay_commission,a.nopay_commission+a.pay_commission AS total_commission,b.uid,b.nickname,b.realname,b.mobile FROM " . tablename($this->table_member) . " a LEFT JOIN " .tablename('mc_members'). " b ON a.uid=b.uid WHERE {$condition} {$ORDER},uid ASC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_member) . " a LEFT JOIN " .tablename('mc_members'). " b ON a.uid=b.uid WHERE {$condition} ", $params);
	$pager = pagination($total, $pindex, $psize);

	/* 导出excel表格 */
	if($_GPC['export']==1){
		$lists = pdo_fetchall("SELECT a.nopay_commission,a.pay_commission,a.nopay_commission+a.pay_commission AS total_commission,b.uid,b.nickname,b.realname,b.mobile FROM " . tablename($this->table_member) . " a LEFT JOIN " .tablename('mc_members'). " b ON a.uid=b.uid WHERE {$condition} {$ORDER},uid ASC ", $params);
		$i = 0;
		foreach ($lists as $key => $value) {
			$arr[$i]['uid']			     = $value['uid'];
			$arr[$i]['nickname']         = $value['nickname'];
			$arr[$i]['realname']         = $value['realname'];
			$arr[$i]['mobile']		     = $value['mobile'];
			$arr[$i]['pay_commission']   = $value['pay_commission']."元";
			$arr[$i]['nopay_commission'] = $value['nopay_commission']."元";
			$arr[$i]['total_commission'] = $value['total_commission']."元";
			$i++;
		}
	 
		$this->exportexcel($arr, array('会员ID', '会员昵称', '会员姓名', '手机号码', '已申请佣金', '待申请佣金', '累计佣金'), "分销佣金统计-".date('Y-m-d',time()));
		exit();
	}

}


include $this->template('commission');


?>