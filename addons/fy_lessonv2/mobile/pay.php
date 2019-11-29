<?php
/**
 * 支付方式选择页面
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！已购买用户允许对程序代码进行修改和使用，但是不允许对
 * 程序代码以任何形式任何目的的再发布，作者将保留追究法律责任的权力和最终解
 * 释权。
 * ============================================================================
 */
 
checkauth();

if($_GPC['ordertype'] == "buyvip"){
	$orderid = intval($_GPC['orderid']);
	$order = pdo_fetch("SELECT * FROM " . tablename($this->table_member_order) . " WHERE id = :id", array(':id' => $orderid));
	if ($order['status'] != '0') {
		message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('vip'), 'error');
	}
	$level = pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$order['level_id']));

	$params['tid']     = $orderid;
	$params['user']    = $order['uid'];
	$params['fee']     = $order['vipmoney'];
	$params['title']   = '购买['.$level['level_name'].']'.$order['viptime'].'天服务';
	$params['ordersn'] = $order['ordersn'];
	$params['virtual'] = false;
}else{
	$orderid = intval($_GPC['orderid']);
	$order = pdo_fetch("SELECT * FROM " . tablename($this->table_order) . " WHERE id = :id", array(':id' => $orderid));
	if ($order['status'] != '0') {
		message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('mylesson'), 'error');
	}

	$params['tid']     = $orderid;
	$params['user']    = $order['uid'];
	$params['fee']     = $order['price'];
	$params['title']   = '购买['.$order['bookname'].']课程';
	$params['ordersn'] = $order['ordersn'];
	$params['virtual'] = false;
}

include $this->template('pay');

?>