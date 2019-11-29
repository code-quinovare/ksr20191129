<?php
/**
 * 营销管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
 $market = pdo_fetch("SELECT * FROM " .tablename($this->table_market). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

/* 抵扣设置 */
if($op=='display'){

	if(checksubmit('submit')){
		$data = array(
			'uniacid' => $uniacid,
			'deduct_switch' => $_GPC['deduct_switch'],
			'deduct_money'  => $_GPC['deduct_money'],
		);

		if($market){
			pdo_update($this->table_market, $data, array('uniacid'=>$uniacid));
		}else{
			$data['addtime'] = time();
			pdo_insert($this->table_market, $data);
		}
		
		message("操作成功", $this->createWebUrl('market'), "success");
	}
}elseif($op=='coupon'){
	if (checksubmit('submitOrder')) { /* 排序 */
		if (is_array($_GPC['displayorder'])) {
			foreach ($_GPC['displayorder'] as $k => $v) {
				$data = array('displayorder' => intval($v));
				pdo_update($this->table_mcoupon, $data, array('id' => $k));
			}
		}
		message('操作成功!', referer, 'success');
	}

	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE uniacid=:uniacid ORDER BY status DESC,displayorder DESC, id DESC LIMIT ".($pindex - 1) * $psize . ',' . $psize, array(':uniacid'=>$uniacid));
	foreach($list as $k=>$v){
		$category = pdo_fetch("SELECT name FROM " .tablename($this->table_category). " WHERE id=:id", array(':id'=>$v['category_id']));
		$list[$k]['category_name'] = $category['name'] ? "[".$category['name']."]课程分类" : "全部课程分类";
		unset($category);
	}

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_mcoupon). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
	$pager = pagination($total, $pindex, $psize);

}elseif($op=='couponDetail'){
	$id = intval($_GPC['id']);
	$member_coupon = pdo_fetch("SELECT a.*,b.nickname,b.mobile,b.realname FROM " .tablename($this->table_member_coupon). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.id=:id", array(':id'=>$id));

	if(empty($member_coupon)){
		message("该优惠券记录不存在", "", "error");
	}

	$category = pdo_fetch("SELECT name FROM " .tablename($this->table_category). " WHERE id=:id", array(':id'=>$member_coupon['category_id']));
	$category_name = $category['name'] ? $category['name']." 课程分类" : "全部课程分类";
}elseif($op=='addCoupon'){
	$coupon_id = intval($_GPC['coupon_id']);
	if($coupon_id>0){
		$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$coupon_id));
		
		if(empty($coupon)){
			message("优惠券不存在", "", "error");
		}

		$validity = json_decode($coupon['validity']);
	}

	$category_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_category). " WHERE uniacid=:uniacid AND parentid=:parentid", array(':uniacid'=>$uniacid,':parentid'=>0));

	if(checksubmit('submit')){
		$data = array(
			'uniacid'			=> $uniacid,
			'name'				=> trim($_GPC['name']),
			'images'			=> trim($_GPC['images']),
			'amount'			=> floatval($_GPC['amount']),
			'conditions'		=> floatval($_GPC['conditions']),
			'category_id'		=> intval($_GPC['category_id']),
			'is_exchange'		=> intval($_GPC['is_exchange']),
			'exchange_integral' => intval($_GPC['exchange_integral']),
			'max_exchange'		=> intval($_GPC['max_exchange']),
			'total_exchange'    => intval($_GPC['total_exchange']),
			'already_exchange'  => intval($_GPC['already_exchange']),
			'validity_type'	    => intval($_GPC['validity_type']),
			'days1'			    => strtotime($_GPC['days1']),
			'days2'				=> intval($_GPC['days2']),
			'status'			=> intval($_GPC['status']),
			'displayorder'		=> intval($_GPC['displayorder']),
		);

		if(empty($data['name'])){
			message("请输入优惠券名称", "", "error");
		}
		if(empty($data['amount'])){
			message("请输入优惠券面值", "", "error");
		}
		if($data['is_exchange']==1){
			if($data['max_exchange']==0){
				message("请输入最大兑换数量", "", "error");
			}
			if($data['already_exchange']>$data['total_exchange']){
				message("已兑换数量不能大于兑换总数量", "", "error");
			}
			
		}
		if(empty($data['validity_type'])){
			message("请选择有效期方式", "", "error");
		}
		if($data['validity_type']==1 && empty($data['days1'])){
			message("请选择固定有效期日期", "", "error");
		}
		if($data['validity_type']==2 && empty($data['days2'])){
			message("请输入自增有效期天数", "", "error");
		}
		
		if($coupon_id>0){
			$data['update_time'] = time();
			if(pdo_update($this->table_mcoupon, $data, array('id'=>$coupon_id))){
				message("更新成功", $this->createWebUrl('market', array('op'=>'coupon')), "success");
			}else{
				message("更新失败", "", "error");
			}
		}else{
			$data['addtime'] = time();
			if(pdo_insert($this->table_mcoupon, $data)){
				message("新增成功", $this->createWebUrl('market', array('op'=>'coupon')), "success");
			}else{
				message("新增失败", "", "error");
			}
		}
	}

}elseif($op=='delAllCoupon'){
	$ids = $_GPC['ids'];

	$t = 0;
	if(!empty($ids) && is_array($ids)){
		foreach($ids as $id){
			if(pdo_delete($this->table_mcoupon, array('uniacid'=>$uniacid,'id' => $id))){
				$t++;
			}
		}
	}
	message("批量删除{$t}个优惠券活动", $this->createWebUrl('market', array('op'=>'coupon')), "success");

}elseif($op=='couponRule'){
	$coupon_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE uniacid=:uniacid AND status=:status", array(':uniacid'=>$uniacid,':status'=>1));

	$regGive = json_decode($market['reg_give'], true);
	$recommend = json_decode($market['recommend'], true);
	$buyLesson = json_decode($market['buy_lesson'], true);
	$shareLesson = json_decode($market['share_lesson'], true);

	if(checksubmit('submit')){
		$data = array(
			'uniacid'			=> $uniacid,
			'reg_give'			=> json_encode($_GPC['reg_give']),
			'recommend'			=> json_encode($_GPC['recommend']),
			'recommend_time'	=> intval($_GPC['recommend_time']),
			'buy_lesson'		=> json_encode($_GPC['buy_lesson']),
			'buy_lesson_time'	=> intval($_GPC['buy_lesson_time']),
			'share_lesson'		=> json_encode($_GPC['share_lesson']),
			'share_lesson_time' => intval($_GPC['share_lesson_time']),
			'coupon_desc'		=> trim($_GPC['coupon_desc']),
		);

		if($market){
			pdo_update($this->table_market, $data, array('uniacid'=>$uniacid));
		}else{
			$data['addtime'] = time();
			pdo_insert($this->table_market, $data);
		}

		message("操作成功", $this->createWebUrl('market', array('op'=>'couponRule')), "success");
	}

}elseif($op=='sendCoupon'){
	set_time_limit(180);

	/* 优惠券列表 */
	$couponList = pdo_fetchall("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
	/* VIP等级 */
	$levelList = pdo_fetchall("SELECT * FROM " .tablename($this->table_vip_level). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

	if(checksubmit('submit')){
		$coupon_id = intval($_GPC['coupon_id']);
		$send_type = intval($_GPC['send_type']);
		$uids = explode(",", trim($_GPC['uids']));
		$level_id = $_GPC['level_id'];
		$startDate = strtotime($_GPC['time']['start'] . " 00:00:00");
		$endDate = strtotime($_GPC['time']['end'] . " 23:59:59");

		if(checksubmit('submit')){
			if(empty($coupon_id)){
				message("请选择优惠券", "", "error");
			}
			$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE id=:id", array(':id'=>$coupon_id));
			if(empty($coupon)){
				message("优惠券不存在", "", "error");
			}

			$list = array();
			if($send_type==1){
				/*全部会员*/
				$list = pdo_fetchall("SELECT a.uid,b.openid,b.nickname FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_fans). " b ON a.uid=b.uid WHERE a.uniacid=:uniacid", array(':uniacid'=>$uniacid));

			}elseif($send_type==2){
				if(empty($uids)){
					message("请输入指定会员uid", "", "error");
				}

				/*指定会员*/
				foreach($uids as $key=>$value){
					$item = pdo_fetch("SELECT a.uid,b.openid,b.nickname FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_fans). " b ON a.uid=b.uid WHERE a.uid IN (:uniacid)", array(':uniacid'=>$value));
					if(empty($item)) continue;

					$list[$key] = $item;
					unset($item);
				}

			}elseif($send_type==3){
				/*指定VIP等级*/
				if(empty($level_id)){
					message("请选择指定的会员VIP等级", "", "error");
				}
				$list = pdo_fetchall("SELECT a.uid,b.openid,b.nickname FROM " .tablename($this->table_member_vip). " a LEFT JOIN ".tablename($this->table_fans)." b ON a.uid=b.uid WHERE a.level_id=:level_id", array(':level_id'=>$level_id));

			}elseif($send_type==4){
				/*指定注册日期*/
				if(empty($startDate) || empty($endDate)){
					message("请选择加入日期", "", "error");
				}
				$list = pdo_fetchall("SELECT a.uid,b.openid,b.nickname FROM " .tablename($this->table_member). " a LEFT JOIN ".tablename($this->table_fans)." b ON a.uid=b.uid WHERE a.addtime>=:startDate AND addtime<=:endDate", array(':startDate'=>$startDate,':endDate'=>$endDate));
			}

			$validity = $coupon['validity_type']==1 ? $coupon['days1'] : time()+ $coupon['days2']*86400;
			$now = time();

			$sql_head = "INSERT INTO ".tablename($this->table_member_coupon)." (`uniacid`, `uid`,`amount`,`conditions`,`validity`,`category_id`,`status`,`source`,`coupon_id`,`addtime`) VALUES ";
			$sql = "";

			foreach($list as $k=>$v){
				$sql .= "('{$uniacid}','{$v[uid]}','{$coupon[amount]}','{$coupon[conditions]}','{$validity}','{$coupon[category_id]}','0','7','$coupon[id]','{$now}'),";

				if(($k+1)%1000==0 || $k+1==count($list)){
					$sql = substr($sql, 0, strlen($sql)-1);
					pdo_query($sql_head.$sql);
					$sql = "";
				}
			}

			message("发放成功", $this->createWebUrl('market', array('op'=>'sendCoupon')), "success");
		}
	}

}elseif($op=='couponLog'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = "a.uniacid=:uniacid";
	$params[':uniacid'] = $uniacid;

	if (!empty($_GPC['ordersn'])) {
		$condition .= " AND a.ordersn LIKE :ordersn ";
		$params[':ordersn'] = "%".$_GPC['ordersn']."%";
	}
	if (!empty($_GPC['nickname'])) {
		$condition .= " AND ((b.nickname LIKE :nickname) OR (b.realname LIKE :nickname) OR (b.mobile LIKE :nickname)) ";
		$params[':nickname'] = "%".$_GPC['nickname']."%";
	}
	if ($_GPC['status']!='') {
		$condition .= " AND a.status=:status ";
		$params[':status'] = $_GPC['status'];
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

	$list = pdo_fetchall("SELECT a.*,b.nickname,b.mobile,b.realname FROM " .tablename($this->table_member_coupon). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition} ORDER BY a.id DESC LIMIT ".($pindex - 1) * $psize . ',' . $psize, $params);
	foreach($list as $k=>$v){
		if($v['category_id']>0){
			$category = pdo_fetch("SELECT name FROM " .tablename($this->table_category). " WHERE id=:id", array(':id'=>$v['category_id']));
		}
		$list[$k]['category_name'] = $category['name'] ? "[".$category['name']."]课程分类" : "全部课程分类";
		if(time()>$v['validity'] && $v['status']==0){
			pdo_update($this->table_member_coupon, array('status'=>-1), array('id'=>$v['id']));
			$list[$k]['status'] = -1;
		}
		unset($category);
	}
	
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member_coupon). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE {$condition}", $params);
	
	$pager = pagination($total, $pindex, $psize);
}

include $this->template('market');

?>