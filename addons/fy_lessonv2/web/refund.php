<?php
/**
 * 退款管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

if($op=='display'){
	$id = intval($_GPC['id']);
	$amount = $_GPC['refund_amount'];
	$ordertype = $_GPC['ordertype'];
	$reason = trim($_GPC['reason']);
	
	if(!is_numeric($amount)){
		message("退款金额必须为数字", "", "error");
	}
	if($ordertype=='lesson'){
		$order = pdo_fetch("SELECT * FROM " .tablename($this->table_order). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
		$price = $order['price'];
		$return_url = $this->createWebUrl('order', array('op'=>'detail','id'=>$id));
	}elseif($ordertype=='vip'){
		$order = pdo_fetch("SELECT * FROM " .tablename($this->table_member_order). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid,':id'=>$id));
		$price = $order['vipmoney'];
		$return_url = "";
	}
	
	if(empty($order)){
		message("订单不存在", "", "error");
	}
	if($amount > $price){
		message("退款金额不可超过订单金额", "", "error");
	}
	
	load()->model('refund');
	$refund_id = refund_create_order($id, $this->module['name'], $amount, $reason);
	if (is_error($refund_id)) {
		return $refund_id;
	}
	$res = refund($refund_id);

	if($res['result_code']=='SUCCESS' && $res['return_code']=='SUCCESS'){
		pdo_update($this->table_order, array('status'=>-2), array('id'=>$id));
		message("退款成功", $return_url, "success");
	}else{
		message("退款失败，公众号返回信息：".$res['errno']."，".$res['message'], "", "error");
	}

}

?>