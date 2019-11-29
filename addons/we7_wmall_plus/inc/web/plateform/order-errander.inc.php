<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$_W['page']['title'] = '跑腿订单-' . $_W['we7_wmall_plus']['config']['title'];
mload()->model('deliveryer');
mload()->model('errander');
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
$GLOBALS['frames'] = array();

$config = $_W['we7_wmall_plus']['config'];
if($op == 'list') {
	if($_W['isajax']) {
		$type = trim($_GPC['type']);
		$status = intval($_GPC['value']);
		isetcookie("_{$type}", $status, 1000000);
	}

	$condition = ' WHERE uniacid = :uniacid';
	$params[':uniacid'] = $_W['uniacid'];

	$status = intval($_GPC['status']);
	if($status > 0) {
		$condition .= ' AND status = :status';
		$params[':status'] = $status;
	}
	$is_pay = isset($_GPC['is_pay']) ? intval($_GPC['is_pay']) : -1;
	if($is_pay >= 0) {
		$condition .= ' AND is_pay = :is_pay';
		$params[':is_pay'] = $is_pay;
	}
	$keyword = trim($_GPC['keyword']);
	if(!empty($keyword)) {
		$condition .= " AND (accept_username LIKE '%{$keyword}%' OR accept_mobile LIKE '%{$keyword}%' OR order_sn LIKE '%{$keyword}%')";
	}
	if(!empty($_GPC['addtime'])) {
		$starttime = strtotime($_GPC['addtime']['start']);
		$endtime = strtotime($_GPC['addtime']['end']) + 86399;
	} else {
		$starttime = strtotime('-15 day');
		$endtime = TIMESTAMP;
	}
	$condition .= " AND addtime > :start AND addtime < :end";
	$params[':start'] = $starttime;
	$params[':end'] = $endtime;

	$pindex = max(1, intval($_GPC['page']));
	$psize = 15;

	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('tiny_wmall_plus_errander_order') .  $condition, $params);
	$data = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_plus_errander_order') . $condition . ' ORDER BY id DESC LIMIT '.($pindex - 1) * $psize.','.$psize, $params, 'id');

	$pager = pagination($total, $pindex, $psize);
	$pay_types = order_pay_types();
	$errander_types = errander_types();
	$errander_order_status = errander_order_status();
	$deliveryers = deliveryer_fetchall();
}

if($op == 'cancel') {
	$ids = $_GPC['id'];
	if(!is_array($ids)) {
		$ids = array($ids);
	}
	foreach($ids as $id) {
		$id = intval($id);
		$status = errander_order_status_update($id, 'cancel');
		if(is_error($status)) {
			message($status['message'], referer(), 'error');
		}
	}
	message('取消订单成功', referer(), 'success');
}

if($op == 'end') {
	$ids = $_GPC['id'];
	if(!is_array($ids)) {
		$ids = array($ids);
	}
	foreach($ids as $id) {
		$id = intval($id);
		$status = errander_order_status_update($id, 'end');
		if(is_error($status)) {
			message($status['message'], referer(), 'error');
		}
	}
	message('设置订单完成成功', referer(), 'success');
}

if($op == 'del') {
	$ids = $_GPC['id'];
	if(!is_array($ids)) {
		$ids = array($ids);
	}
	foreach($ids as $id) {
		$id = intval($id);
		$order = pdo_get('tiny_wmall_plus_errander_order', array('uniacid' => $_W['uniacid'], 'id' => $id));
		if($order['status'] != 4) {
			message('订单状态有误， 不能删除订单', referer(), 'error');
		}
		pdo_delete('tiny_wmall_plus_errander_order', array('uniacid' => $_W['uniacid'], 'id' => $id));
		pdo_delete('tiny_wmall_plus_errander_order_status_log', array('uniacid' => $_W['uniacid'], 'oid' => $id));
		pdo_delete('tiny_wmall_plus_order_refund_log', array('uniacid' => $_W['uniacid'], 'oid' => $id, 'order_type' => 'errander'));
	}
	message('删除订单成功', referer(), 'success');
}

if($op == 'begin_refund') {
	$id = intval($_GPC['id']);
	$result = errander_order_begin_payrefund($id);
	if(!is_error($result)) {
		$query = errander_order_query_payrefund($id);
		if(is_error($query)) {
			message('发起退款成功, 获取退款状态失败', referer(), 'error');
		} else {
			message('发起退款成功, 退款状态已更新', referer(), 'success');
		}
	} else {
		message($result['message'], referer(), 'error');
	}
}

if($op == 'query_refund') {
	$id = intval($_GPC['id']);
	$query = errander_order_query_payrefund($id);
	if(is_error($query)) {
		message('获取退款状态失败', referer(), 'error');
	} else {
		message('更新退款状态成功', referer(), 'success');
	}
}

if($op == 'detail') {
	$id = intval($_GPC['id']);
	$order = errander_order_fetch($id);
	if(empty($order)) {
		message('订单不存在或已经删除', $this->createWebUrl('manage', array('op' => 'order')), 'error');
	}
	$pay_types = order_pay_types();
	$order_types = errander_types();
	$order_status = errander_order_status();
	$logs = errander_order_fetch_status_log($id);
}

if($op == 'analyse') {
	$id = intval($_GPC['id']);
	$deliveryers = errander_order_analyse($id);
	if(is_error($deliveryers)) {
		message($deliveryers, '', 'ajax');
	}
	message(error(0, $deliveryers), '', 'ajax');
}

if($op == 'dispatch') {
	$order_id = intval($_GPC['order_id']);
	$deliveryer_id = intval($_GPC['deliveryer_id']);
	$status = errander_order_assign_deliveryer($order_id, $deliveryer_id, true);
	if(is_error($status)) {
		message($status, '', 'ajax');
	}
	message(error(0, '分配订单成功'), '', 'ajax');
}
include $this->template('plateform/order-errander');