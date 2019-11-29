<?php
/**
 * 我的课程
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();

$title = '我的课程';
$uid = $_W['member']['uid'];
$status = $_GPC['status'];

$condition = " b.uniacid=:uniacid AND b.uid=:uid ";
$params[':uniacid'] = $uniacid;
$params[':uid'] = $uid;

if(in_array($status, array('0','1'))){
	$condition .= " AND b.status=:status ";
	$params[':status'] = $status;
}

$pindex = max(1, intval($_GPC['page']));
$psize = 10;

$mylessonlist = pdo_fetchall("SELECT a.images,b.* FROM " .tablename($this->table_lesson_parent). " a LEFT JOIN " .tablename($this->table_order). " b ON a.id=b.lessonid WHERE {$condition} ORDER BY b.id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);

foreach($mylessonlist as $key=>$value){
	if($value['status']=='-2'){
		$mylessonlist[$key]['statusname'] = '已退款';
	}elseif($value['status']=='-1'){
		$mylessonlist[$key]['statusname'] = '已取消';
	}elseif($value['status']=='0'){
		$mylessonlist[$key]['statusname'] = '待付款';
	}elseif($value['status']=='1'){
		$mylessonlist[$key]['statusname'] = '已付款';
	}elseif($value['status']=='2'){
		$mylessonlist[$key]['statusname'] = '已评价';
	}
	
	if($value['status']>=1 && $value['validity']>0){
		$mylessonlist[$key]['validity'] = date('Y-m-d H:i:s', $value['validity']);
	}
	$mylessonlist[$key]['addtime'] = date('Y-m-d H:i', $value['addtime']);
}

/* 检查超时未评价课程 */
if($setting['autogood']>0){
	$paytime = time()-$setting['autogood']*86400;
	$order = pdo_fetchall("SELECT a.id,a.ordersn,a.uid,a.openid,a.lessonid,a.bookname,b.nickname FROM " .tablename($this->table_order). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.status=:status AND a.uid=:uid AND a.paytime<:paytime", array(':status'=>1,':uid'=>$uid,':paytime'=>$paytime));

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

if($op=='display'){
	include $this->template('mylesson');
}elseif($op=='cancle'){
	$orderid = intval($_GPC['orderid']);
	$order = pdo_fetch("SELECT * FROM " .tablename($this->table_order). " WHERE id=:id AND uid=:uid ", array(':id'=>$orderid, ':uid'=>$uid));
	if(empty($order)){
		message("该课程不存在!");
	}
	if($order['status'] != 0){
		message("该课程状态不允许取消!");
	}
	if(pdo_update($this->table_order, array('status'=>'-1'), array('id'=>$orderid))){
		if($setting['stock_config']==1){
			$this->updateLessonStock($order['lessonid'], "+1");
		}
		if($order['coupon']>0){
			$upcoupon = array(
				'status'	=> 0,
				'ordersn'	=> "",
				'update_time' => "",
			);
			pdo_update($this->table_member_coupon, $upcoupon, array('id'=>$order['coupon']));
		}
		if($order['deduct_integral']>0){
			load()->model('mc');
			mc_credit_update($order['uid'], 'credit1', $order['deduct_integral'], array(0, '取消微课堂订单，sn:'.$order['ordersn']));
		}

		message("取消成功", $this->createMobileUrl('mylesson'), "success");
	}else{
		message("取消失败", "", "error");
	}
}elseif($op=='ajaxgetlist'){
	echo json_encode($mylessonlist);
}

?>