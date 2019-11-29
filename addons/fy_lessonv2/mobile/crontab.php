<?php
/**
 * 定时任务
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */



/*
 * 检查超期未支付订单
 */
if (time() > $setting['closelast'] + $setting['closespace'] * 60 && $setting['closespace'] != 0) {
	$time = time() - $setting['closespace'] * 60;

	/* 取消指定时间内未支付订单 */
	$nopay_order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE uniacid=:uniacid AND status=:status AND addtime<:addtime", array(':uniacid'=>$uniacid, ':status'=>0, ':addtime'=>$time));

	foreach ($nopay_order as $item) {
		$order = pdo_fetch("SELECT * FROM " .tablename($this->table_order). " WHERE id=:id AND status=:status", array(':id'=>$item['id'],':status'=>0));
		if(empty($order)) continue;

		if($setting['stock_config']==1){
			$this->updateLessonStock($order['lessonid'], "+1");
		}

		pdo_update($this->table_order, array('status' => '-1'), array('id' => $item['id']));
		if($item['coupon']>0){
			$upcoupon = array(
				'status'	=> 0,
				'ordersn'	=> "",
				'update_time' => "",
			);
			pdo_update($this->table_member_coupon, $upcoupon, array('id'=>$item['coupon']));
		}
		if($item['deduct_integral']>0){
			load()->model('mc');
			mc_credit_update($item['uid'], 'credit1', $item['deduct_integral'], array(0, '取消微课堂订单，sn:'.$item['ordersn']));
		}
	}

	/* 更新执行时间 */
	pdo_update($this->table_setting, array('closelast' => time()), array('id' => $setting['id']));
}


/*
 * 检查超期未评价订单
 */
if($setting['autogood']>0){
	$paytime = time()-$setting['autogood']*86400;
	$order = pdo_fetchall("SELECT a.id,a.ordersn,a.uid,a.openid,a.lessonid,a.bookname,b.nickname FROM " .tablename($this->table_order). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uniacid=:uniacid AND a.status=:status AND a.paytime<:paytime", array(':uniacid'=>$uniacid,':status'=>1,':paytime'=>$paytime));

	foreach($order as $value){
		$evaluate = array(
			'uniacid'  => $uniacid,
			'orderid'  => $value['id'],
			'ordersn'  => $value['ordersn'],
			'lessonid' => $value['lessonid'],
			'bookname' => $value['bookname'],
			'uid'      => $value['uid'],
			'nickname' => $value['nickname'],
			'grade'    => 1,
			'content'  => "好评!",
			'addtime'  => time(),
		);
		if(pdo_insert($this->table_evaluate, $evaluate)){
			/* 更新订单状态 */
			pdo_update($this->table_order, array('status'=>2), array('id'=>$value['id']));

			/* 课程总评论数 */
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_evaluate). " WHERE lessonid=:lessonid", array(':lessonid'=>$value['lessonid']));
			/* 课程好评数 */
			$good = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_evaluate). " WHERE lessonid=:lessonid AND grade=:grade", array(':lessonid'=>$value['lessonid'], ':grade'=>1));
			/* 更新课程好评率 */
			pdo_update($this->table_lesson_parent, array('score'=>round($good/$total,2)), array('id'=>$value['lessonid']));
		}
	}
}


/*
 * 检查已过期优惠券
 */
 $list = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_coupon). " WHERE uniacid=:uniacid AND status=:status AND validity<=:validity", array(':uniacid'=>$uniacid,':status'=>0, ':validity'=>time()));
 foreach($list as $value){
	 pdo_update($this->table_member_coupon, array('status'=>-1, 'update_time'=>time()), array('id'=>$value['id']));
 }


/*
 * 检查课程章节定期上架
 */
 $section_list = pdo_fetchall("SELECT id FROM " .tablename($this->table_lesson_son). " WHERE uniacid=:uniacid AND status=:status AND auto_show=:auto_show AND show_time<=:show_time", array(':uniacid'=>$uniacid, ':status'=>0, ':auto_show'=>1, ':show_time'=>time()));
 foreach($section_list as $item){
   pdo_update($this->table_lesson_son, array('status'=>1), array('id'=>$item['id']));
 }


/*
 * 检查过期会员
 */
 $vipmember = pdo_fetchall("SELECT uid FROM " .tablename($this->table_member). " WHERE vip=:vip", array(':vip'=>1));
 foreach($vipmember as $member){
	 $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$member['uid'], ':validity'=>time()));
	 if($total==0){
		$this->updateMemberVip($member['uid'], 0);
	 }
 }

 if($_GPC['vip']==1){
	$vip_list = pdo_fetchall("SELECT DISTINCT(uid) FROM " .tablename($this->table_member_vip). " WHERE validity>:validity", array(':validity'=>time()));
	foreach($vip_list as $vip){
		$this->updateMemberVip($vip['uid'], 1);
	}
 }



 echo "success:".date('Y-m-d H:i:s');

?>