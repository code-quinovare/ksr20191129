<?php
defined('IN_IA') || exit('Access Denied');
function is_open_order($order) 
{
	if (!(is_array($order)) || empty($order['order_plateform'])) 
	{
		$id = ((is_array($order) ? $order['id'] : $order));
		$order = pdo_get('tiny_wmall_order', array('id' => $id), array('order_plateform'));
	}
	return $order['order_plateform'] != 'we7_wmall';
}
function order_fetch($id, $oauth = false) 
{
	global $_W;
	$id = intval($id);
	$condition = ' where uniacid = :uniacid and id = :id';
	$params = array(':uniacid' => $_W['uniacid'], ':id' => $id);
	if ($oauth) 
	{
		$condition .= ' and uid = :uid';
		$params[':uid'] = $_W['member']['uid'];
	}
	$order = pdo_fetch('SELECT * FROM ' . tablename('tiny_wmall_order') . $condition, $params);
	if (empty($order)) 
	{
		return false;
	}
	$order['addtime_cn'] = date('H:i', $order['addtime']);
	if (($order['status'] == 3) && (0 < $_W['deliveryer']['id'])) 
	{
		$order['plateform_deliveryer_fee'] = order_calculate_deliveryer_fee($order, $_W['deliveryer']);
	}
	$order['invoice'] = iunserializer($order['invoice']);
	if (!(empty($order['invoice'])) && !(is_array($order['invoice']))) 
	{
		$order['invoice'] = array('title' => $order['invoice']);
	}
	$order['data'] = iunserializer($order['data']);
	if (defined('IN_DELIVERYAPP')) 
	{
		$order['data'] = '';
		$order['invoice'] = $order['invoice']['title'];
	}
	$order['delivery_title'] = (($order['delivery_type'] == 2 ? $_W['we7_wmall']['config']['mall']['delivery_title'] : ''));
	$order_status = order_status();
	$pay_types = order_pay_types();
	$order_types = order_types();
	$order['order_type_cn'] = $order_types[$order['order_type']]['text'];
	$order['status_cn'] = $order_status[$order['status']]['text'];
	if (!(empty($order['plateform_serve']))) 
	{
		$order['plateform_serve'] = iunserializer($order['plateform_serve']);
	}
	if (!(empty($order['agent_serve']))) 
	{
		$order['agent_serve'] = iunserializer($order['agent_serve']);
	}
	if (empty($order['is_pay'])) 
	{
		$order['pay_type_cn'] = '未支付';
	}
	else 
	{
		$order['pay_type_cn'] = ((!(empty($pay_types[$order['pay_type']]['text'])) ? $pay_types[$order['pay_type']]['text'] : '其他支付方式'));
	}
	if (empty($order['delivery_time'])) 
	{
		$order['delivery_time'] = '尽快送出';
	}
	if ($order['order_type'] == 3) 
	{
		$table = pdo_get('tiny_wmall_tables', array('uniacid' => $_W['uniacid'], 'id' => $order['table_id']));
		$order['table'] = $table;
	}
	else if ($order['order_type'] == 4) 
	{
		$reserve_type = order_reserve_type();
		$order['reserve_type_cn'] = $reserve_type[$order['reserve_type']]['text'];
		$category = pdo_get('tiny_wmall_tables_category', array('uniacid' => $_W['uniacid'], 'id' => $order['table_cid']));
		$order['table_category'] = $category;
	}
	$order['pay_type_class'] = '';
	if ($order['is_pay'] == 1) 
	{
		$order['pay_type_class'] = 'have-pay';
		if ($order['pay_type'] == 'delivery') 
		{
			$order['pay_type_class'] = 'delivery-pay';
		}
	}
	return $order;
}
function order_fetch_goods($oid, $print_lable = '') 
{
	global $_W;
	$oid = intval($oid);
	$condition = 'WHERE a.uniacid = :uniacid AND a.oid = :oid';
	if (!(empty($print_lable))) 
	{
		$condition .= ' AND a.print_label in (' . $print_lable . ')';
	}
	$params = array(':uniacid' => $_W['uniacid'], ':oid' => $oid);
	$data = pdo_fetchall('select a.*,b.thumb from ' . tablename('tiny_wmall_order_stat') . ' as a left join ' . tablename('tiny_wmall_goods') . ' as b on a.goods_id = b.id ' . $condition, $params);
	foreach ($data as &$item ) 
	{
		$item['thumb'] = tomedia($item['thumb']);
		$item['activity'] = 0;
	}
	return $data;
}
function order_fetch_discount($id, $type = '') 
{
	global $_W;
	if (empty($type)) 
	{
		$data = pdo_getall('tiny_wmall_order_discount', array('uniacid' => $_W['uniacid'], 'oid' => $id));
	}
	else 
	{
		$data = pdo_get('tiny_wmall_order_discount', array('uniacid' => $_W['uniacid'], 'oid' => $id, 'type' => $type));
	}
	return $data;
}
function order_place_again($sid, $order_id) 
{
	global $_W;
	$order = order_fetch($order_id);
	if (empty($order)) 
	{
		return false;
	}
	$order['data'] = iunserializer($order['data']);
	$isexist = pdo_fetchcolumn('SELECT id FROM ' . tablename('tiny_wmall_order_cart') . ' WHERE uniacid = :aid AND sid = :sid AND uid = :uid', array(':aid' => $_W['uniacid'], ':sid' => $sid, ':uid' => $_W['member']['uid']));
	$data = array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid'], 'groupid' => $_W['member']['groupid'], 'num' => $order['num'], 'price' => $order['price'], 'box_price' => $order['box_price'], 'original_data' => ($order['data']['cart'] ? $order['data']['cart'] : $order['data']), 'addtime' => TIMESTAMP);
	$cart_data = array();
	if (!(empty($data['original_data']))) 
	{
		foreach ($data['original_data'] as $key => $row ) 
		{
			if ($key == 88888) 
			{
				continue;
			}
			$cart_data[$key] = $row['options'];
		}
		$data['data'] = iserializer($cart_data);
	}
	$original_data = $data['original_data'];
	$data['original_data'] = iserializer($original_data);
	if (empty($isexist)) 
	{
		pdo_insert('tiny_wmall_order_cart', $data);
	}
	else 
	{
		pdo_update('tiny_wmall_order_cart', $data, array('uniacid' => $_W['uniacid'], 'id' => $isexist, 'uid' => $_W['member']['uid']));
	}
	$data['original_data'] = $original_data;
	$data['data'] = $cart_data;
	return $data;
}
function order_insert_discount($id, $sid, $discount_data) 
{
	global $_W;
	if (empty($discount_data)) 
	{
		return false;
	}
	if (!(empty($discount_data['token']))) 
	{
		pdo_update('tiny_wmall_activity_coupon_record', array('status' => 2, 'usetime' => TIMESTAMP, 'order_id' => $id), array('uniacid' => $_W['uniacid'], 'id' => $discount_data['token']['recordid']));
	}
	if (!(empty($discount_data['redPacket']))) 
	{
		pdo_update('tiny_wmall_activity_redpacket_record', array('status' => 2, 'usetime' => TIMESTAMP, 'order_id' => $id), array('uniacid' => $_W['uniacid'], 'id' => $discount_data['redPacket']['redPacket_id']));
	}
	foreach ($discount_data as $data ) 
	{
		$insert = array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'oid' => $id, 'type' => $data['type'], 'name' => $data['name'], 'icon' => $data['icon'], 'note' => $data['text'], 'fee' => $data['value'], 'store_discount_fee' => floatval($data['store_discount_fee']), 'agent_discount_fee' => floatval($data['agent_discount_fee']), 'plateform_discount_fee' => floatval($data['plateform_discount_fee']));
		pdo_insert('tiny_wmall_order_discount', $insert);
	}
	return true;
}
function get_cart_goodsnum($goods_id, $option_key = 0, $type = 'num', $cart = array()) 
{
	$cart_goods_item = $cart[$goods_id];
	if (!($cart_goods_item)) 
	{
		return 0;
	}
	if ($option_key != -1) 
	{
		$option = $cart_goods_item[$option_key];
		if (!($option)) 
		{
			return 0;
		}
		return $option[$type];
	}
	$num = 0;
	foreach ($cart_goods_item as $option ) 
	{
		if ($option[$type]) 
		{
			$num += $option[$type];
		}
	}
	return $num;
}
function cart_data_init($sid, $goods_id = 0, $option_key = 0, $sign = '', $ignore_bargain = false) 
{
	global $_W;
	$option_key = trim($option_key);
	if (empty($option_key)) 
	{
		$option_key = 0;
	}
	mload()->model('goods');
	$cart = order_fetch_member_cart($sid, false);
	$goods_ids = array();
	if (!(empty($cart))) 
	{
		$goods_ids = array_keys($cart['data']);
	}
	$goods_ids[] = $goods_id;
	$goods_ids_str = implode(',', $goods_ids);
	$goods_info = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :uniacid AND sid = :sid AND id IN (' . $goods_ids_str . ')', array(':uniacid' => $_W['uniacid'], ':sid' => $sid), 'id');
	$options = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_options') . ' where uniacid = :uniacid and sid = :sid and goods_id in (' . $goods_ids_str . ') ', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
	foreach ($options as $option ) 
	{
		$goods_info[$option['goods_id']]['options'][$option['id']] = $option;
	}
	$bargain_goods_ids = array();
	if (!($ignore_bargain)) 
	{
		mload()->model('activity');
		activity_store_cron($sid);
		$bargains = pdo_getall('tiny_wmall_activity_bargain', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'status' => '1'), array(), 'id');
		if (!(empty($bargains))) 
		{
			$bargain_ids = implode(',', array_keys($bargains));
			$bargain_goods = pdo_fetchall('select * from ' . tablename('tiny_wmall_activity_bargain_goods') . ' where uniacid = :uniacid and sid = :sid and bargain_id in (' . $bargain_ids . ')', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
			$bargain_goods_group = array();
			if (!(empty($bargain_goods))) 
			{
				foreach ($bargain_goods as &$row ) 
				{
					$bargain_goods_ids[$row['goods_id']] = $row['bargain_id'];
					$row['available_buy_limit'] = $row['max_buy_limit'];
					$bargain_goods_group[$row['bargain_id']][$row['goods_id']] = $row;
				}
			}
			$where = ' where uniacid = :uniacid and sid = :sid and uid = :uid and stat_day = :stat_day and bargain_id in (' . $bargain_ids . ') group by bargain_id';
			$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':stat_day' => date('Ymd'), ':uid' => $_W['member']['uid']);
			$bargain_order = pdo_fetchall('select count(distinct(oid)) as num, bargain_id from ' . tablename('tiny_wmall_order_stat') . $where, $params, 'bargain_id');
			foreach ($bargains as &$row ) 
			{
				$row['available_goods_limit'] = $row['goods_limit'];
				$row['goods'] = $bargain_goods_group[$row['id']];
				$row['avaliable_order_limit'] = $row['order_limit'];
				if (!(empty($bargain_order))) 
				{
					$row['avaliable_order_limit'] = $row['order_limit'] - intval($bargain_order[$row['id']]['num']);
				}
				$row['hasgoods'] = array();
			}
		}
		else 
		{
			$bargains = array();
		}
	}
	$total_num = 0;
	$total_original_price = 0;
	$total_price = 0;
	$total_box_price = 0;
	$cart_bargain = array();
	$bargain_has_goods = array();
	if (!(empty($cart))) 
	{
		foreach ($cart['data'] as $k => $v ) 
		{
			$k = intval($k);
			$goods = $goods_info[$k];
			if (empty($goods) || ($k == '88888')) 
			{
				continue;
			}
			if (!(goods_is_available($goods))) 
			{
				unset($cart['data'][$k]);
				unset($cart['original_data'][$k]);
				continue;
			}
			$goods_box_price = $goods['box_price'];
			if (!($goods['is_options'])) 
			{
				$discount_num = 0;
				foreach ($v as $key => $val ) 
				{
					$goods['options_data'] = goods_build_options($goods);
					$key = trim($key);
					$option = $goods['options_data'][$key];
					if (empty($option) || empty($option['total'])) 
					{
						continue;
					}
					$num = intval($val['num']);
					if (($option['total'] != -1) && ($option['total'] <= $num)) 
					{
						$num = $option['total'];
					}
					if ($num <= 0) 
					{
						continue;
					}
					if ($goods['total'] != -1) 
					{
						$goods['total'] -= $num;
						$goods['total'] = max($goods['total'], 0);
					}
					$title = $goods_info[$k]['title'];
					if (!(empty($key))) 
					{
						$title = $title . '(' . $option['name'] . ')';
					}
					$cart_item = array('cid' => $goods_info[$k]['cid'], 'child_id' => $goods_info[$k]['child_id'], 'goods_id' => $k, 'thumb' => tomedia($goods_info[$k]['thumb']), 'title' => $title, 'option_title' => $option['name'], 'num' => $num, 'price' => $goods_info[$k]['price'], 'discount_price' => $goods_info[$k]['price'], 'discount_num' => 0, 'price_num' => $num, 'total_price' => round($goods_info[$k]['price'] * $num, 2), 'total_discount_price' => round($goods_info[$k]['price'] * $num, 2), 'bargain_id' => 0);
					if (in_array($k, array_keys($bargain_goods_ids))) 
					{
						$goods_bargain_id = $bargain_goods_ids[$k];
						$bargain = $bargains[$goods_bargain_id];
						$bargain_goods = $bargain['goods'][$k];
						$val['discount_num'] = min($bargain_goods['max_buy_limit'], $num);
						if ((0 < $bargain['avaliable_order_limit']) && (0 < $bargain['available_goods_limit']) && (0 < $bargain_goods['available_buy_limit'])) 
						{
							$i = 0;
							while ($i < $val['discount_num']) 
							{
								if (($bargain_goods['poi_user_type'] == 'new') && empty($_W['member']['is_store_newmember'])) 
								{
									break;
								}
								if ((($bargain_goods['discount_available_total'] == -1) || (0 < $bargain_goods['discount_available_total'])) && (0 < $bargain_goods['available_buy_limit'])) 
								{
									$cart_item['discount_price'] = $bargain_goods['discount_price'];
									++$cart_item['discount_num'];
									$cart_item['bargain_id'] = $bargain['id'];
									$cart_bargain[] = $bargain['use_limit'];
									if (0 < $cart_item['price_num']) 
									{
										--$cart_item['price_num'];
									}
									if (0 < $bargain_goods['discount_available_total']) 
									{
										--$bargain_goods['discount_available_total'];
										--$bargains[$goods_bargain_id]['goods'][$k]['discount_available_total'];
									}
									--$bargain_goods['available_buy_limit'];
									--$bargains[$goods_bargain_id]['goods'][$k]['available_buy_limit'];
									++$discount_num;
									$bargain_has_goods[] = $k;
								}
								else 
								{
									break;
								}
								++$i;
							}
							$cart_item['total_discount_price'] = ($cart_item['discount_num'] * $bargain_goods['discount_price']) + ($cart_item['price_num'] * $goods_info[$k]['price']);
							$cart_item['total_discount_price'] = round($cart_item['total_discount_price'], 2);
						}
					}
					$total_num += $num;
					$total_price += $cart_item['total_discount_price'];
					$total_original_price += $cart_item['total_price'];
					$total_box_price += $goods_box_price * $num;
					$cart_goods[$k][$key] = $cart_item;
				}
				if (0 < $discount_num) 
				{
					--$bargain['available_goods_limit'];
					--$bargains[$goods_bargain_id]['available_goods_limit'];
				}
				$totalnum = get_cart_goodsnum($k, -1, 'num', $cart_goods);
				if ($goods_info[$k]['total'] != -1) 
				{
					$goods_info[$k]['total'] -= $totalnum;
					$goods_info[$k]['total'] = max($goods_info[$k]['total'], 0);
				}
			}
			else 
			{
				foreach ($v as $key => $val ) 
				{
					$goods['options_data'] = goods_build_options($goods);
					$option_id = tranferOptionid($key);
					$key = trim($key);
					$option = $goods['options_data'][$key];
					if (empty($option) || empty($option['total'])) 
					{
						continue;
					}
					$num = intval($val['num']);
					if (($option['total'] != -1) && ($option['total'] <= $num)) 
					{
						$num = $option['total'];
					}
					if ($num <= 0) 
					{
						continue;
					}
					if ($goods['options'][$option_id]['total'] != -1) 
					{
						$goods['options'][$option_id]['total'] -= $num;
						$goods['options'][$option_id]['total'] = max($goods['options'][$option_id]['total'], 0);
					}
					$title = $goods_info[$k]['title'];
					if (!(empty($key))) 
					{
						$title = $title . '(' . $option['name'] . ')';
					}
					$cart_goods[$k][$key] = array('cid' => $goods_info[$k]['cid'], 'goods_id' => $k, 'thumb' => tomedia($goods_info[$k]['thumb']), 'title' => $title, 'option_title' => $option['name'], 'num' => $num, 'price' => $option['price'], 'discount_price' => $option['price'], 'discount_num' => 0, 'price_num' => $num, 'total_price' => round($option['price'] * $num, 2), 'total_discount_price' => round($option['price'] * $num, 2), 'bargain_id' => 0);
					$total_num += $num;
					$total_price += $option['price'] * $num;
					$total_original_price += $option['price'] * $num;
					$total_box_price += $goods_box_price * $num;
					if ($goods_info[$k]['options'][$option_id]['total'] != -1) 
					{
						$goods_info[$k]['options'][$option_id]['total'] -= $num;
						$goods_info[$k]['options'][$option_id]['total'] = max($goods_info[$k]['options'][$option_id]['total'], 0);
					}
				}
			}
		}
	}
	$goods_item = $goods_info[$goods_id];
	$goods_item['options_data'] = goods_build_options($goods_item);
	$cart_item = $cart['data'][$goods_id][$option_key];
	if ($sign == '+') 
	{
		if (!(goods_is_available($goods_info[$goods_id]))) 
		{
			return error(-1, '当前商品不在可售时间范围内');
		}
		$option = $goods_item['options_data'][$option_key];
		if (empty($option['total'])) 
		{
			return error(-1, '库存不足');
		}
		if (empty($cart_item)) 
		{
			$title = $goods_item['title'];
			if (!(empty($option_key))) 
			{
				$title = $title . '(' . $option['name'] . ')';
			}
			$cart_item = array('cid' => $goods_info[$goods_id]['cid'], 'child_id' => $goods_info[$goods_id]['child_id'], 'goods_id' => $goods_id, 'thumb' => tomedia($goods_info[$goods_id]['thumb']), 'title' => $title, 'option_title' => $option['name'], 'num' => 0, 'price' => $option['price'], 'discount_price' => $option['price'], 'discount_num' => 0, 'price_num' => 0, 'total_price' => 0, 'total_discount_price' => 0, 'bargain_id' => 0);
		}
		$price_change = 0;
		$price = $option['price'];
		if (in_array($goods_id, array_keys($bargain_goods_ids))) 
		{
			$goods_bargain_id = $bargain_goods_ids[$goods_id];
			$bargain = $bargains[$goods_bargain_id];
			$bargain_goods = $bargain['goods'][$goods_id];
			$msg = '';
			$pricenum = get_cart_goodsnum($goods_id, '-1', 'price_num', $cart_goods);
			if (($bargain_goods['poi_user_type'] == 'new') && !($_W['member']['is_store_newmember'])) 
			{
				if (!($pricenum)) 
				{
					$msg = '仅限门店新用户优惠';
				}
				$price_change = 1;
				$price = $option['price'];
			}
			if (!($price_change) && ($bargain['avaliable_order_limit'] <= 0)) 
			{
				if (!($pricenum)) 
				{
					$msg = $bargain['title'] . '活动每天限购一单,超出后恢复原价';
				}
				$price_change = 1;
				$price = $option['price'];
			}
			if (!($price_change) && (count($bargain_has_goods) == $bargain['goods_limit']) && !(in_array($goods_id, $bargain_has_goods))) 
			{
				if (!($pricenum)) 
				{
					$msg = $bargain['title'] . '每单特价商品限购' . $bargain['goods_limit'] . '种,超出后恢复原价';
				}
				$price_change = 1;
				$price = $option['price'];
			}
			if (!($price_change)) 
			{
				if (!($pricenum) && (get_cart_goodsnum($goods_id, '-1', 'discount_num', $cart_goods) == $bargain_goods['max_buy_limit'])) 
				{
					$msg = $bargain['title'] . '每单特价商品限购' . $bargain_goods['max_buy_limit'] . '份,超出后恢复原价';
				}
				if ($bargain_goods['available_buy_limit'] < $cart_item['discount_num']) 
				{
					$price_change = 1;
					$price = $option['price'];
				}
				if (($bargain_goods['discount_available_total'] != -1) && ($bargain_goods['discount_available_total'] == 0)) 
				{
					if (!($pricenum)) 
					{
						$msg = '活动库存不足,恢复原价购买';
					}
					$price_change = 1;
					$price = $option['price'];
				}
			}
			if (!($price_change)) 
			{
				$price_change = 2;
				$price = $bargain_goods['discount_price'];
				$cart_bargain[] = $bargain['use_limit'];
			}
		}
		if ($price_change == 2) 
		{
			++$cart_item['discount_num'];
			$cart_item['bargain_id'] = $bargain['id'];
			$cart_item['discount_price'] = $bargain_goods['discount_price'];
		}
		else 
		{
			++$cart_item['price_num'];
		}
		++$cart_item['num'];
		$cart_item['total_discount_price'] = ($cart_item['discount_num'] * $bargain_goods['discount_price']) + ($cart_item['price_num'] * $option['price']);
		$cart_item['total_discount_price'] = round($cart_item['total_discount_price'], 2);
		$cart_item['total_price'] = round($cart_item['num'] * $option['price'], 2);
		++$total_num;
		$total_box_price = $total_box_price + $goods_item['box_price'];
		$total_price = $total_price + $price;
	}
	else if (!(empty($cart_item)) && (0 < $cart_item['num'])) 
	{
		--$cart_item['num'];
		$price = $cart_item['price'];
		if (0 < $cart_item['price_num']) 
		{
			--$cart_item['price_num'];
		}
		else if (0 < $cart_item['discount_num']) 
		{
			$price = $cart_item['discount_price'];
			--$cart_item['discount_num'];
			if ($cart_item['discount_num'] <= 0) 
			{
				$cart_item['bargain_id'] = 0;
			}
		}
		$cart_item['total_price'] = round($cart_item['num'] * $cart_item['price']);
		$cart_item['total_discount_price'] = ($cart_item['discount_num'] * $cart_item['discount_price']) + ($cart_item['price_num'] * $cart_item['price']);
		$cart_item['total_discount_price'] = round($cart_item['total_discount_price'], 2);
		--$total_num;
		$total_box_price = $total_box_price - $goods_item['box_price'];
		$total_price = $total_price - $price;
	}
	if (0 < $total_box_price) 
	{
		$cart_goods[88888] = array( array('num' => 0, 'title' => '餐盒费', 'goods_id' => '88888', 'discount_num' => 0, 'price_num' => 0, 'price_total' => $total_box_price, 'total_discount_price' => $total_box_price) );
	}
	if ($sign) 
	{
		$cart_goods[$goods_id][$option_key] = $cart_item;
		if ($sign == '-') 
		{
			foreach ($cart_goods[$goods_id] as $key => &$item ) 
			{
				if (!($item['num'])) 
				{
					unset($cart_goods[$goods_id][$key]);
				}
			}
			$item_total_num = get_cart_goodsnum($goods_id, -1, 'num', $cart_goods);
			if (!($item_total_num)) 
			{
				unset($cart_goods[$goods_id]);
			}
		}
	}
	$isexist = pdo_fetchcolumn('SELECT id FROM ' . tablename('tiny_wmall_order_cart') . ' WHERE uniacid = :aid AND sid = :sid AND uid = :uid', array(':aid' => $_W['uniacid'], ':sid' => $sid, ':uid' => $_W['member']['uid']));
	$cart_goods_original = array();
	foreach ($cart_goods as $key => $row ) 
	{
		$cart_goods_original[$key] = array('title' => $goods_info[$key]['title'], 'goods_id' => $key, 'options' => $row);
	}
	$data = array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid'], 'groupid' => $_W['member']['groupid'], 'num' => $total_num, 'price' => $total_price, 'box_price' => round($total_box_price, 2), 'data' => iserializer($cart_goods), 'original_data' => iserializer($cart_goods_original), 'addtime' => TIMESTAMP, 'bargain_use_limit' => 0);
	if (!(empty($cart_bargain))) 
	{
		$cart_bargain = array_unique($cart_bargain);
		if (in_array(1, $cart_bargain)) 
		{
			$data['bargain_use_limit'] = 1;
		}
		if (in_array(2, $cart_bargain)) 
		{
			$data['bargain_use_limit'] = 2;
		}
	}
	if (empty($isexist)) 
	{
		pdo_insert('tiny_wmall_order_cart', $data);
	}
	else 
	{
		pdo_update('tiny_wmall_order_cart', $data, array('uniacid' => $_W['uniacid'], 'id' => $isexist, 'uid' => $_W['member']['uid']));
	}
	if (empty($bargain_has_goods)) 
	{
		$discount_notice = array();
		$store_discount = pdo_get('tiny_wmall_store_activity', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'type' => 'discount', 'status' => 1), array('title', 'data'));
		if (!(empty($store_discount))) 
		{
			$discount_notice['note'] = $store_discount['title'];
			if (0 < $data['price']) 
			{
				$discount_condition = iunserializer($store_discount['data']);
				$apply_price = array_keys($discount_condition);
				sort($apply_price);
				foreach ($apply_price as $key => $val ) 
				{
					if ($val < $data['price']) 
					{
						if ($apply_price[$key + 1]) 
						{
							continue;
						}
					}
					$dvalue = $val - $data['price'];
					if (($dvalue <= 5) || (0 < $key)) 
					{
						$discount_notice['leave_price'] = $dvalue;
						$discount_notice['back_price'] = $discount_condition[$val]['back'];
						$discount_notice['note'] = ((0 < $dvalue ? '再买 ' . $dvalue . ' 元, 可减 ' . $discount_notice['back_price'] . ' 元' : '下单减 ' . $discount_notice['back_price'] . ' 元'));
						if ((0 < $key) && (0 < $dvalue)) 
						{
							$discount_notice['note'] = '下单减 ' . $discount_condition[$apply_price[$key - 1]]['back'] . ' 元 ' . $discount_notice['note'];
						}
						if ($data['price'] < $apply_price[$key + 1]) 
						{
							if ($dvalue <= 0) 
							{
								$furdiscount = $apply_price[$key + 1] - $data['price'];
								$discount_notice['note'] .= ', 再买 ' . $furdiscount . ' 元可减 ' . $discount_condition[$apply_price[$key + 1]]['back'];
							}
							break;
						}
					}
					if (5 < $dvalue) 
					{
						break;
					}
				}
			}
		}
	}
	$data['discount_notice'] = $discount_notice;
	$data['data'] = array_values($cart_goods);
	$data['data1'] = $cart_goods;
	$data['original_data'] = array_values($cart_goods_original);
	$result = array('cart' => $data, 'msg' => $msg);
	return error(0, $result);
}
function order_insert_member_cart($sid, $ignore_bargain = false) 
{
	global $_W;
	global $_GPC;
	if (!(empty($_GPC['goods']))) 
	{
		$_GPC['goods'] = str_replace('&nbsp;', '#nbsp;', $_GPC['goods']);
		$_GPC['goods'] = json_decode(str_replace('#nbsp;', '&nbsp;', html_entity_decode(urldecode($_GPC['goods']))), true);
		if (empty($_GPC['goods'])) 
		{
			return array();
		}
		mload()->model('goods');
		$ids_str = implode(',', array_keys($_GPC['goods']));
		$goods_info = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods') . ' WHERE uniacid = :uniacid AND sid = :sid AND id IN (' . $ids_str . ')', array(':uniacid' => $_W['uniacid'], ':sid' => $sid), 'id');
		$options = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_options') . ' where uniacid = :uniacid and sid = :sid and goods_id in (' . $ids_str . ') ', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
		foreach ($options as $option ) 
		{
			$goods_info[$option['goods_id']]['options'][$option['id']] = $option;
		}
		if (!($ignore_bargain)) 
		{
			mload()->model('activity');
			activity_store_cron($sid);
			$bargains = pdo_getall('tiny_wmall_activity_bargain', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'status' => '1'), array(), 'id');
			if (!(empty($bargains))) 
			{
				$bargain_ids = implode(',', array_keys($bargains));
				$bargain_goods = pdo_fetchall('select * from ' . tablename('tiny_wmall_activity_bargain_goods') . ' where uniacid = :uniacid and sid = :sid and bargain_id in (' . $bargain_ids . ')', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
				$bargain_goods_group = array();
				if (!(empty($bargain_goods))) 
				{
					foreach ($bargain_goods as &$row ) 
					{
						$row['available_buy_limit'] = $row['max_buy_limit'];
						$bargain_goods_group[$row['bargain_id']][$row['goods_id']] = $row;
					}
				}
				foreach ($bargains as &$row ) 
				{
					$row['available_goods_limit'] = $row['goods_limit'];
					$row['goods'] = $bargain_goods_group[$row['id']];
				}
			}
			else 
			{
				$bargains = array();
			}
		}
		$total_num = 0;
		$total_original_price = 0;
		$total_price = 0;
		$total_box_price = 0;
		$cart_bargain = array();
		foreach ($_GPC['goods'] as $k => $v ) 
		{
			$k = intval($k);
			$goods = $goods_info[$k];
			if (empty($goods) || ($k == '88888')) 
			{
				continue;
			}
			$goods['options_data'] = goods_build_options($goods);
			$goods_box_price = $goods['box_price'];
			if (!($goods['is_options'])) 
			{
				$discount_num = 0;
				foreach ($v['options'] as $key => $val ) 
				{
					$key = trim($key);
					$option = $goods['options_data'][$key];
					if (empty($option)) 
					{
						continue;
					}
					$num = intval($val['num']);
					if ($num <= 0) 
					{
						continue;
					}
					$title = $goods_info[$k]['title'];
					if (!(empty($key))) 
					{
						$title = $title . '(' . $option['name'] . ')';
					}
					$cart_item = array('title' => $title, 'option_title' => $option['name'], 'num' => $num, 'price' => $goods_info[$k]['price'], 'discount_price' => $goods_info[$k]['price'], 'discount_num' => 0, 'price_num' => $num, 'total_price' => round($goods_info[$k]['price'] * $num, 2), 'total_discount_price' => round($goods_info[$k]['price'] * $num, 2), 'bargain_id' => 0);
					$bargain = $bargains[$val['bargain_id']];
					$bargain_goods = $bargain['goods'][$k];
					if ((0 < $val['bargain_id']) && (0 < $val['discount_num'])) 
					{
						if ($bargain_goods['max_buy_limit'] < $val['discount_num']) 
						{
							$val['discount_num'] = $bargain_goods['max_buy_limit'];
						}
						$params = array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'], ':stat_day' => date('Ymd'), ':bargain_id' => $bargain['id']);
						$numed = pdo_fetchcolumn('select count(distinct(oid))  from ' . tablename('tiny_wmall_order_stat') . ' where uniacid = :uniacid and uid = :uid and bargain_id = :bargain_id and stat_day = :stat_day', $params);
						$numed = intval($numed);
						if (($numed < $bargain['order_limit']) && (0 < $bargain['available_goods_limit']) && (0 < $bargain_goods['available_buy_limit'])) 
						{
							$i = 0;
							while ($i < $val['discount_num']) 
							{
								if (($bargain_goods['poi_user_type'] == 'new') && empty($_W['member']['is_store_newmember'])) 
								{
									break;
								}
								if ((($bargain_goods['discount_available_total'] == -1) || (0 < $bargain_goods['discount_available_total'])) && (0 < $bargain_goods['available_buy_limit'])) 
								{
									$cart_item['discount_price'] = $bargain_goods['discount_price'];
									++$cart_item['discount_num'];
									$cart_item['bargain_id'] = $bargain['id'];
									$cart_bargain[] = $bargain['use_limit'];
									if (0 < $cart_item['price_num']) 
									{
										--$cart_item['price_num'];
									}
									if (0 < $bargain_goods['discount_available_total']) 
									{
										--$bargain_goods['discount_available_total'];
										--$bargains[$val['bargain_id']]['goods'][$k]['discount_available_total'];
									}
									--$bargain_goods['available_buy_limit'];
									--$bargains[$val['bargain_id']]['goods'][$k]['available_buy_limit'];
									++$discount_num;
								}
								else 
								{
									break;
								}
								++$i;
							}
							$cart_item['total_discount_price'] = ($cart_item['discount_num'] * $bargain_goods['discount_price']) + ($cart_item['price_num'] * $goods_info[$k]['price']);
							$cart_item['total_discount_price'] = round($cart_item['total_discount_price'], 2);
						}
					}
					$total_num += $num;
					$total_price += $cart_item['total_discount_price'];
					$total_original_price += $cart_item['total_price'];
					$total_box_price += $goods_box_price * $num;
					$cart_goods[$k][$key] = $cart_item;
				}
				if (0 < $discount_num) 
				{
					--$bargain['available_goods_limit'];
					--$bargains[$val['bargain_id']]['goods'][$k]['available_goods_limit'];
				}
			}
			else 
			{
				foreach ($v['options'] as $key => $val ) 
				{
					$key = trim($key);
					$option = $goods['options_data'][$key];
					if (empty($option)) 
					{
						continue;
					}
					$title = $goods_info[$k]['title'];
					if (!(empty($key))) 
					{
						$title = $title . '(' . $option['name'] . ')';
					}
					$cart_goods[$k][$key] = array('title' => $title, 'option_title' => $option['name'], 'num' => $val['num'], 'price' => $option['price'], 'discount_price' => $option['price'], 'discount_num' => 0, 'price_num' => $num, 'total_price' => round($option['price'] * $val['num'], 2), 'total_discount_price' => round($option['price'] * $val['num'], 2), 'bargain_id' => 0);
					$total_num += $val['num'];
					$total_price += $option['price'] * $val['num'];
					$total_original_price += $option['price'] * $val['num'];
					$total_box_price += $goods_box_price * $val['num'];
				}
			}
		}
		$isexist = pdo_fetchcolumn('SELECT id FROM ' . tablename('tiny_wmall_order_cart') . ' WHERE uniacid = :aid AND sid = :sid AND uid = :uid', array(':aid' => $_W['uniacid'], ':sid' => $sid, ':uid' => $_W['member']['uid']));
		$data = array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid'], 'groupid' => $_W['member']['groupid'], 'num' => $total_num, 'price' => $total_price, 'box_price' => round($total_box_price, 2), 'data' => iserializer($cart_goods), 'original_data' => iserializer($_GPC['goods']), 'addtime' => TIMESTAMP, 'bargain_use_limit' => 0);
		if (!(empty($cart_bargain))) 
		{
			$cart_bargain = array_unique($cart_bargain);
			if (in_array(1, $cart_bargain)) 
			{
				$data['bargain_use_limit'] = 1;
			}
			if (in_array(2, $cart_bargain)) 
			{
				$data['bargain_use_limit'] = 2;
			}
		}
		if (empty($isexist)) 
		{
			pdo_insert('tiny_wmall_order_cart', $data);
		}
		else 
		{
			pdo_update('tiny_wmall_order_cart', $data, array('uniacid' => $_W['uniacid'], 'id' => $isexist, 'uid' => $_W['member']['uid']));
		}
		$data['data'] = $cart_goods;
		$data['original_data'] = $_GPC['goods'];
		return $data;
	}
	return error(-1, '商品信息错误');
}
function order_dispatch_analyse($id, $extra = array()) 
{
	global $_W;
	$order = order_fetch($id);
	if (empty($order)) 
	{
		return error(-1, '订单不存在或已删除');
	}
	$_W['agentid'] = $order['agentid'];
	$store = pdo_get('tiny_wmall_store', array('id' => $order['sid']), array('location_x', 'location_y'));
	$order['store'] = $store;
	$filter = array('over_max_collect_show' => 0);
	if ($extra['channel'] == 'plateform_dispatch') 
	{
		$filter = array('over_max_collect_show' => 1);
	}
	$deliveryers = deliveryer_fetchall(0, $filter);
	if (!(empty($deliveryers))) 
	{
		foreach ($deliveryers as &$deliveryer ) 
		{
			$deliveryer['order_id'] = $id;
			if (empty($order['location_x']) || empty($order['location_y']) || empty($deliveryer['location_y']) || empty($deliveryer['location_x'])) 
			{
				$deliveryer['store2deliveryer_distance'] = '未知';
				$deliveryer['store2user_distance'] = '未知';
			}
			else 
			{
				$deliveryer['store2user_distance'] = distanceBetween($order['location_y'], $order['location_x'], $store['location_y'], $store['location_x']);
				$deliveryer['store2user_distance'] = round($deliveryer['store2user_distance'] / 1000, 2) . 'km';
				$deliveryer['store2deliveryer_distance'] = distanceBetween($store['location_y'], $store['location_x'], $deliveryer['location_y'], $deliveryer['location_x']);
				$deliveryer['store2deliveryer_distance'] = round($deliveryer['store2deliveryer_distance'] / 1000, 2) . 'km';
			}
		}
		if (empty($extra['sort'])) 
		{
			$extra['sort'] = 'store2deliveryer_distance';
		}
		if ($extra['sort'] == 'store2deliveryer_distance') 
		{
			$deliveryers = array_sort($deliveryers, $extra['sort']);
		}
		else 
		{
			$deliveryers = array_sort($deliveryers, $extra['sort'], SORT_DESC);
		}
		$order['deliveryers'] = $deliveryers;
	}
	else 
	{
		return error(-1, '没有平台配送员，无法进行自动调度');
	}
	return $order;
}
function deliveryer_fetchall($sid = 0, $filter = array()) 
{
	global $_W;
	if (!(isset($filter['over_max_collect_show']))) 
	{
		$filter['over_max_collect_show'] = 1;
	}
	$where = 'where uniacid = :uniacid';
	$params = array(':uniacid' => $_W['uniacid']);
	if (!(isset($filter['agentid'])) || ($filter['agentid'] != -1)) 
	{
		$where .= ' and agentid = :agentid';
		$params[':agentid'] = $_W['agentid'];
	}
	if (!(isset($filter['work_status']))) 
	{
		$filter['work_status'] = 1;
	}
	else if ($filter['work_status'] == -1) 
	{
		unset($filter['work_status']);
	}
	if (isset($filter['work_status'])) 
	{
		$where .= ' and work_status = :work_status';
		$params[':work_status'] = $filter['work_status'];
	}
	if (0 < $sid) 
	{
		$condition = ' where uniacid = :uniacid and sid = :sid';
		$params_store = array(':uniacid' => $_W['uniacid'], ':sid' => $sid);
		$data = pdo_fetchall('SELECT id,sid,deliveryer_id FROM ' . tablename('tiny_wmall_store_deliveryer') . $condition, $params_store, 'deliveryer_id');
		if (empty($data)) 
		{
			return array();
		}
		$filter['deliveryer_ids'] = implode(',', array_keys($data));
	}
	else 
	{
		if (empty($filter['order_type'])) 
		{
			$filter['order_type'] = 'is_takeout';
		}
		$where .= ' and ' . $filter['order_type'] . ' = 1';
	}
	if (!(empty($filter['deliveryer_ids']))) 
	{
		$where .= ' and id in (' . $filter['deliveryer_ids'] . ')';
	}
	$deliveryers = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_deliveryer') . $where, $params, 'id');
	if (!(empty($deliveryers))) 
	{
		foreach ($deliveryers as &$da ) 
		{
			if ($filter['over_max_collect_show'] == 0) 
			{
				if ($filter['order_type'] == 'is_takeout') 
				{
					if ((0 < $da['collect_max_takeout']) && ($da['collect_max_takeout'] <= $da['order_takeout_num'])) 
					{
						unset($deliveryers[$da['id']]);
						continue;
					}
				}
				else if ($filter['order_type'] == 'is_errander') 
				{
					if ((0 < $da['collect_max_errander']) && ($da['collect_max_errander'] <= $da['order_errander_num'])) 
					{
						unset($deliveryers[$da['id']]);
						continue;
					}
				}
			}
			$da['extra'] = iunserializer($da['extra']);
			if (empty($da['extra'])) 
			{
				$da['extra'] = array('accept_wechat_notice' => 1, 'accept_voice_notice' => 1);
			}
			$da['avatar'] = tomedia($da['avatar']);
		}
	}
	return $deliveryers;
}
function activity_getall($sid, $status = -1) 
{
	global $_W;
	activity_store_cron($sid);
	$params = array('uniacid' => $_W['uniacid'], 'sid' => $sid);
	if (0 <= $status) 
	{
		$params['status'] = $status;
	}
	$activity = pdo_getall('tiny_wmall_store_activity', $params, array(), 'type');
	if (!(empty($activity))) 
	{
		foreach ($activity as &$row ) 
		{
			$row['data'] = iunserializer($row['data']);
		}
	}
	return $activity;
}
?>