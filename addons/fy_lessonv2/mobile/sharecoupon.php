<?php
/**
 * 分享课程赠送优惠券
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
$member = pdo_fetch("SELECT a.uid,b.openid,b.nickname FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_fans). " b ON a.uid=b.uid WHERE a.uid=:uid", array(':uid'=>$_W['member']['uid']));

if($_W['isajax'] && !empty($member)){
	$market = pdo_fetch("SELECT * FROM " .tablename($this->table_market). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
	$shareLesson = json_decode($market['share_lesson'], true);

	if(!empty($shareLesson)){
		if($market['share_lesson_time']>0){
			$shareTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member_coupon). " WHERE uid=:uid AND source=:source", array(':uid'=>$member['uid'], 'source'=>4));
			if($shareTotal >= $market['share_lesson_time']) return;
		}

		$t = 0;
		foreach($shareLesson as $item){
			$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE id=:id", array(':id'=>$item));
			if(empty($coupon)) continue;
			$lessonCoupon = array(
				'uniacid'	  => $uniacid,
				'uid'		  => $member['uid'],
				'amount'      => $coupon['amount'],
				'conditions'  => $coupon['conditions'],
				'validity'	  => $coupon['validity_type']==1 ? $coupon['days1'] : time()+ $coupon['days2']*86400,
				'category_id' => $coupon['category_id'],
				'status'	  => 0, /* 未使用 */
				'source'	  => 4, /* 分享课程赠送 */
				'coupon_id'	  => $coupon['id'],
				'addtime'	  => time(),
			);
			if(pdo_insert($this->table_member_coupon, $lessonCoupon)){
				$t++;
			}
		}

		$tplmessage = pdo_fetch("SELECT receive_coupon FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
		$sendmessage = array(
			'touser' => $member['openid'],
			'template_id' => $tplmessage['receive_coupon'],
			'url' => $_W['siteroot'] . 'app/' . $this->createMobileUrl('coupon'),
			'topcolor' => "#7B68EE",
			'data' => array(
				'first' => array(
					'value' => "恭喜您成功分享课程，系统赠您{$t}张优惠券已发放到您的帐号，请注意查收。",
					'color' => "#2392EA",
					),
				'keyword1' => array(
					'value' => $member['nickname'],
					'color' => "",
				),
				'keyword2' => array(
					'value' => $t." 张",
					'color' => "",
				),
				'keyword3' => array(
					'value' => date('Y年m月d日', time()),
					'color' => "",
				),
				'remark' => array(
					'value' => "点击详情可查看您的帐号优惠券详情哦~",
					'color' => "",
				),
			)
		);
		$this->send_template_message(urldecode(json_encode($sendmessage)));
	}
}


?>