<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'search';
$title = "{$_W['we7_wmall_plus']['config']['title']}-商家列表";
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';
$discounts = store_discounts();
$categorys = store_fetchall_category();
$orderbys = store_orderbys();
$lat = $_GPC['__lat'];
$lng = $_GPC['__lng'];
$force = intval($_GPC['force']);
$carousel = store_fetch_category();
if($op == 'list') {
	$lat = trim($_GPC['lat']);
	$lng = trim($_GPC['lng']);
	if(!empty($lat) && !empty($lng)) {
		isetcookie('__lat', $lat, 60);
		isetcookie('__lng', $lng, 60);
	}
	$condition = ' where uniacid = :uniacid and status = 1';
	$params = array(':uniacid' => $_W['uniacid']);
	if($_GPC['cid'] > 0) {
		$condition .= ' and cid like :cid';
		$params[':cid'] = "%|{$_GPC['cid']}|%";
	}

	$dis = trim($_GPC['dis']);
	if(!empty($dis)) {
		$condition .= " and {$dis} = {$discounts[$dis]['val']}";
	}
	$stores = pdo_fetchall('select id,title,logo,label,sailed,score,business_hours,is_in_business,delivery_fee_mode,delivery_price,delivery_free_price,send_price,delivery_time,delivery_mode,token_status,invoice_status,location_x,location_y,forward_mode,forward_url from ' . tablename('tiny_wmall_plus_store') . $condition, $params);
	$min = 0;
	if(!empty($stores)) {
		$store_label = category_store_label();
		foreach($stores as &$row) {
			$row['logo'] = tomedia($row['logo']);
			$row['business_hours'] = (array)iunserializer($row['business_hours']);
			$row['is_in_business_hours'] = ($row['is_in_business'] && store_is_in_business_hours($row['business_hours']));
			$row['hot_goods'] = pdo_fetchall('select title from ' . tablename('tiny_wmall_plus_goods') . ' where uniacid = :uniacid and sid = :sid and is_hot = 1 limit 3', array(':uniacid' => $_W['uniacid'], ':sid' => $row['id']));
            $row['sailed']= pdo_fetchcolumn('select sum(sailed) from ' . tablename('tiny_wmall_plus_goods') . ' where uniacid = :uniacid and sid = :sid ', array(':uniacid' => $_W['uniacid'], ':sid' => $row['id']));
			$row['activity'] = store_fetch_activity($row['id']);
			$row['activity']['activity_num'] += ($row['delivery_free_price'] > 0 ? 1 : 0);
			$row['score_cn'] = round($row['score'] / 5, 2) * 100;
			$row['url'] = store_forward_url($row['id'], $row['forward_mode'], $row['forward_url']);
			if($row['label'] > 0) {
				$row['label_color'] = $store_label[$row['label']]['color'];
				$row['label_cn'] = $store_label[$row['label']]['title'];
			}
			if($row['delivery_fee_mode'] == 2) {
				$row['delivery_price'] = iunserializer($row['delivery_price']);
				$row['delivery_price'] = $row['delivery_price']['start_fee'];
			}
            $row['distance'] = 0;
//			if(!empty($lng) && !empty($lat)) {
//				$row['distance'] = distanceBetween($row['location_y'], $row['location_x'], $lng, $lat);
//				$row['distance'] = round($row['distance'] / 1000, 2);
//			} else {
//				$row['distance'] = 0;
//			}
			if($row['is_in_business_hours'] == 1) {
				$row['is_in_business_hours_'] = 100000;
			}
			$row['displayorder_order'] = $row['displayorder'] + (($row['displayorder'] + 1) * $row['is_in_business_hours_']);
			$row['sailed_order'] = $row['sailed'] + (($row['sailed'] + 1) * $row['is_in_business_hours_']);
			$row['score_order'] = $row['score'] + (($row['score'] + 1) * $row['is_in_business_hours_']);
			$row['click_order'] = $row['click'] + (($row['click'] + 1) * $row['is_in_business_hours_']);
			$row['distance_order'] = $row['distance'] + ($row['distance'] + 1) * ($row['is_in_business_hours'] == 1 ? 0 : 100000);
			$row['send_price_order'] = $row['send_price'] + ($row['send_price'] + 1) * ($row['is_in_business_hours'] == 1 ? 0 : 1000);
			$row['delivery_time_order'] = $row['delivery_time'] + ($row['delivery_time'] + 1) * ($row['is_in_business_hours'] == 1 ? 0 : 1000);
		}
		$min = min(array_keys($stores));

		$order_by_type = trim($_GPC['order']) ? trim($_GPC['order']) : 'distance';
		if(empty($lat)) {
			$order_by_type = 'displayorder';
		}
		if(in_array($order_by_type, array('distance', 'send_price', 'delivery_time'))) {
			$stores = array_sort($stores, "{$order_by_type}_order", SORT_ASC);
		} else {
			$stores = array_sort($stores, "{$order_by_type}_order", SORT_DESC);
		}
	}
	$stores = array_values($stores);
	$respon = array('error' => 0, 'message' => $stores, 'min' => $min);
	message($respon, '', 'ajax');
}
include $this->template('search');


