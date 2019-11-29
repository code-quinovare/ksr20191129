<?php
defined('IN_IA') || exit('Access Denied');
function pindan_data_init($sid, $pindan_id, $ignore_bargain = false) 
{
	global $_W;
	$groups = pdo_getall('tiny_wmall_order_cart', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'pindan_id' => $pindan_id));
	if (empty($groups)) 
	{
		return error(-1, '');
	}
	$goods_ids = array();
	foreach ($groups as &$da ) 
	{
		$group['total_fee'] = 0;
		$da['data'] = iunserializer($da['data']);
		foreach ($da['data'] as $key => $row ) 
		{
			$goods_ids[] = $key;
		}
	}
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
	$pindan_data = array();
	foreach ($groups as &$cart ) 
	{
		$cart['pindan'] = array();
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
					$cart['pindan'][$k][$key] = $cart_item;
				}
				if (0 < $discount_num) 
				{
					--$bargain['available_goods_limit'];
					--$bargains[$goods_bargain_id]['available_goods_limit'];
					$bargains[$goods_bargain_id]['goods'][$k]['available_buy_limit'] -= $discount_num;
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
					$cart_goods[$k][$key] = $cart['pindan'][$k][$key] = array('cid' => $goods_info[$k]['cid'], 'goods_id' => $k, 'thumb' => tomedia($goods_info[$k]['thumb']), 'title' => $title, 'option_title' => $option['name'], 'num' => $num, 'price' => $option['price'], 'discount_price' => $option['price'], 'discount_num' => 0, 'price_num' => $num, 'total_price' => round($option['price'] * $num, 2), 'total_discount_price' => round($option['price'] * $num, 2), 'bargain_id' => 0);
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
		if ($cart['uid'] == $_W['member']['uid']) 
		{
			$pindan_data['mine'] = $cart;
		}
		else 
		{
			$pindan_data['other'][] = $cart;
		}
		$pindan_data['pindan_id'] = $pindan_data['mine']['id'];
		$pindan_data['total_price'] = $total_price;
		$pindan_data['total_original_price'] = $total_original_price;
		$pindan_data['delivery_fee'] = 0;
	}
	unset($cart);
	return $pindan_data;
}
?>