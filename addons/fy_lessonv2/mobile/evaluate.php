<?php
/**
 * 评价课程订单
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
checkauth();
$title = "评价订单";
 
$uid = $_W['member']['uid'];
$orderid = intval($_GPC['orderid']); /* 课程订单id */
$member = pdo_fetch("SELECT nickname FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$uid));

if($op=='display'){
	$order = pdo_fetch("SELECT a.id,a.ordersn,a.uid,a.lessonid,a.status,a.teacherid, b.bookname,b.images,b.price, c.nickname FROM " .tablename($this->table_order). " a LEFT JOIN " .tablename($this->table_lesson_parent). " b ON a.lessonid=b.id LEFT JOIN " .tablename($this->table_mc_members). " c ON a.uid=c.uid WHERE a.uniacid=:uniacid AND a.id=:id AND a.uid=:uid", array(':uniacid'=>$uniacid,':id'=>$orderid,':uid'=>$uid));
	if(empty($order)){
		message("该订单不存在或已被删除！", "", "error");
	}

	if($order['status']==2){
		message("该订单已评价！", $this->createMobileUrl('mylesson'), "warning");
	}

	/* 提交评价 */
	if(checksubmit('submit')){
		$grade   = intval($_GPC['grade']);
		$content = $_GPC['content']?trim($_GPC['content']):'好评';

		$evaluate = array(
			'uniacid'  => $uniacid,
			'orderid'  => $orderid,
			'ordersn'  => $order['ordersn'],
			'lessonid' => $order['lessonid'],
			'bookname' => $order['bookname'],
			'teacherid'=> $order['teacherid'],
			'uid'      => $order['uid'],
			'nickname' => $order['nickname'],
			'grade'    => $grade,
			'content'  => $content,
			'status'   => $setting['audit_evaluate']==0 ? 1 : 0,
			'addtime'  => time(),
		);
		$result = pdo_insert($this->table_evaluate, $evaluate);
		if($result){
			/* 更新订单状态 */
			pdo_update($this->table_order, array('status'=>2), array('id'=>$order['id']));

			/* 课程总评论数 */
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_evaluate). " WHERE lessonid=:lessonid", array(':lessonid'=>$order['lessonid']));
			/* 课程好评数 */
			$good = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_evaluate). " WHERE lessonid=:lessonid AND grade=:grade", array(':lessonid'=>$order['lessonid'],':grade'=>1));
			/* 更新课程好评率 */
			pdo_update($this->table_lesson_parent, array('score'=>round($good/$total,2)), array('id'=>$order['lessonid']));

			$evaluate_word = $setting['audit_evaluate']==0 ? "评价成功" : "评价成功，等待管理员审核";
			message($evaluate_word, $this->createMobileUrl('mylesson'), "success");
		}else{
			message("评价失败！", $this->createMobileUrl('mylesson'), "error");
		}
	}

}elseif($op=='freeorder'){
	$lessonid = intval($_GPC['lessonid']);
	$lesson = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_parent). " WHERE uniacid=:uniacid AND id=:id LIMIT 1", array(':uniacid'=>$uniacid,':id'=>$lessonid));
	if(empty($lesson)){
		message("该课程不存在或已被删除！", "", "error");
	}

	$already_evaluate = pdo_fetch("SELECT id FROM " .tablename($this->table_evaluate). " WHERE uid=:uid AND lessonid=:lessonid AND orderid=:orderid", array(':uid'=>$uid,':lessonid'=>$lessonid,':orderid'=>0));
	if(!empty($already_evaluate)){
		message("您已评价该课程，无需重复评价！", "", "warning");
	}

	$order = array(
		'images'   => $lesson['images'],
		'bookname' => $lesson['bookname'],
		'price'    => $lesson['price'],
		'uid'	   => $uid,
		'nickname' => $member['nickname'],
	);

	/* 提交评价 */
	if(checksubmit('submit')){
		$grade   = intval($_GPC['grade']);
		$content = $_GPC['content']?trim($_GPC['content']):'好评';

		$evaluate = array(
			'uniacid'  => $uniacid,
			'orderid'  => '',
			'ordersn'  => '',
			'lessonid' => $lessonid,
			'bookname' => $order['bookname'],
			'teacherid'=> $lesson['teacherid'],
			'uid'      => $order['uid'],
			'nickname' => $order['nickname'],
			'grade'    => $grade,
			'content'  => $content,
			'status'   => $setting['audit_evaluate']==0 ? 1 : 0,
			'addtime'  => time(),
		);
		$result = pdo_insert($this->table_evaluate, $evaluate);
		if($result){
			/* 课程总评论数 */
			$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_evaluate). " WHERE lessonid=:lessonid", array(':lessonid'=>$lessonid));
			/* 课程好评数 */
			$good = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_evaluate). " WHERE lessonid=:lessonid AND grade=:grade", array(':lessonid'=>$lessonid,':grade'=>1));
			/* 更新课程好评率 */
			pdo_update($this->table_lesson_parent, array('score'=>round($good/$total,2)), array('id'=>$lessonid));
			
			$evaluate_word = $setting['audit_evaluate']==0 ? "评价成功" : "评价成功，等待管理员审核";
			message($evaluate_word, $this->createMobileUrl('lesson',array('id'=>$lessonid)), "success");
		}else{
			message("评价失败！", $this->createMobileUrl('lesson',array('id'=>$lessonid)), "error");
		}
	}
}

include $this->template('evaluate');

?>