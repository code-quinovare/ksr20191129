<?php
/**
 * 会员优惠券
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();
$uid = $_W['member']['uid'];

$member = pdo_fetch("SELECT nickname FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$uid));

if($op=='display'){
	$title = "我的优惠券";

	$pindex =max(1,$_GPC['page']);
	$psize = 5;
	$status = trim($_GPC['status']);

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_coupon). " WHERE uid=:uid AND status=:status ORDER BY id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':uid'=>$uid,':status'=>$status));
	foreach($list as $k=>$v){
		$list[$k]['startDate'] = date('Y.m.d', $v['addtime']);
		$list[$k]['endDate'] = date('Y.m.d', $v['validity']);
		$list[$k]['startTime'] = date(' H:i', $v['addtime']);
		$list[$k]['endTime'] = date(' H:i', $v['validity']);
		$list[$k]['classname'] = $status ==0 ? 'pepper-red' : '';

		$category = pdo_fetch("SELECT name FROM " .tablename($this->table_category). " WHERE id=:id", array(':id'=>$v['category_id']));
		$list[$k]['category_name'] = $category['name'] ? "仅限[".$category['name']."]分类的课程" : "全部课程分类";
		unset($category);

		if($v['source']==1){
			$list[$k]['source_name'] = "优惠码转换";
		}elseif($v['source']==2){
			$list[$k]['source_name'] = "购买课程";
		}elseif($v['source']==3){
			$list[$k]['source_name'] = "邀请下级成员";
		}elseif($v['source']==4){
			$list[$k]['source_name'] = "分享课程";
		}elseif($v['source']==5){
			$list[$k]['source_name'] = "积分兑换";
		}elseif($v['source']==6){
			$list[$k]['source_name'] = "新会员专享";
		}elseif($v['source']==7){
			$list[$k]['source_name'] = "后台发放";
		}

		if(time()>$v['validity'] && $v['status']==0){
			pdo_update($this->table_member_coupon, array('status'=>-1), array('id'=>$v['id']));
			unset($list[$k]);
		}
	}

	if($_W['isajax']){
		echo json_encode($list);
	}

}elseif($op=='addCoupon'){
	$title = "优惠码转换";

	if(checksubmit('submit')){
		$password = trim($_GPC['card_password']);
		$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_coupon). " WHERE uniacid=:uniacid AND password=:password", array(':uniacid'=>$uniacid, ':password'=>$password));
		if(empty($coupon)){
			message("课程优惠码不存在", $this->createMobileUrl('coupon', array('op'=>'addCoupon','code'=>$password)), "error");
		}
		if($coupon['is_use']==1){
			message("课程优惠码已被使用", $this->createMobileUrl('coupon', array('op'=>'addCoupon','code'=>$password)), "error");
		}
		if($coupon['validity'] < time()){
			message("课程优惠码已过期", $this->createMobileUrl('coupon', array('op'=>'addCoupon','code'=>$password)), "error");
		}

		$upcoupon = array(
			'is_use'	=> 1,
			'nickname'	=> $member['nickname'],
			'uid'		=> $uid,
			'use_time'	=> time(),
		);
		$res = pdo_update($this->table_coupon, $upcoupon, array('card_id'=>$coupon['card_id']));

		if($res){
			$membeCoupon = array(
				'uniacid'   => $uniacid,
				'uid'	    => $uid,
				'amount'    => $coupon['amount'],
				'conditions' => $coupon['conditions'],
				'validity'  => $coupon['validity'],
				'password'  => $coupon['password'],
				'status'    => 0,
				'source'	=> 1,
				'addtime'   => time(),
			);

			if(pdo_insert($this->table_member_coupon, $membeCoupon)){
				message("转换成功", $this->createMobileUrl('coupon'), "success");
			}else{
				message("写入会员优惠券失败", $this->createMobileUrl('coupon', array('op'=>'addCoupon','code'=>$password)), "errot");
			}
		}else{
			message("转换失败", $this->createMobileUrl('coupon', array('op'=>'addCoupon','code'=>$password)), "errot");
		}
	}

}

if(!$_W['isajax']){
	include $this->template('coupon');
}

?>