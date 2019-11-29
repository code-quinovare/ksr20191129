<?php
defined('IN_IA') || exit('Access Denied');
function bargain_avaliable($sid, $fileds = 'id', $filter = array()) 
{
	global $_W;
	$condition = ' where uniacid = :uniacid and sid = :sid and status = :status order by id limit 2';
	$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':status' => 1);
	if (!(empty($filter['bargain_id']))) 
	{
		$condition .= ' and id = :bargain_id';
		$params[':bargain_id'] = $filter['bargain_id'];
	}
	$bargains = pdo_fetchall('select id, title, content, order_limit, goods_limit from ' . tablename('tiny_wmall_activity_bargain') . $condition, $params, 'id');
	$bargain_ids = array();
	if ($fileds == 'id') 
	{
		if (!(empty($bargains))) 
		{
			$bargain_ids = array_keys($bargains);
		}
		return $bargain_ids;
	}
	if ($fileds == 'goods') 
	{
		$bargain_ids = implode(',', array_keys($bargains));
		$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':stat_day' => date('Ymd'), ':uid' => $_W['member']['uid']);
		$where = ' where uniacid = :uniacid and sid = :sid and uid = :uid and stat_day = :stat_day and bargain_id in (' . $bargain_ids . ') group by bargain_id';
		$bargain_order = pdo_fetchall('select count(distinct(oid)) as num, bargain_id from ' . tablename('tiny_wmall_order_stat') . $where, $params, 'bargain_id');
		foreach ($bargains as &$bargain ) 
		{
			$bargain['avaliable_order_limit'] = $bargain['order_limit'];
			if (!(empty($bargain_order))) 
			{
				$bargain['avaliable_order_limit'] = $bargain['order_limit'] - intval($bargain_order[$bargain['id']]['num']);
			}
			$bargain['hasgoods'] = array();
			array_unshift($categorys, array('id' => 'bargain_' . $bargain['id'], 'title' => $bargain['title'], 'bargain_id' => $bargain['id']));
		}
		$where = ' where uniacid = :uniacid and sid = :sid and (discount_available_total = -1 or discount_available_total > 0) and bargain_id in (' . $bargain_ids . ')';
		$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid);
		$bargain_goods = pdo_fetchall('select * from ' . tablename('tiny_wmall_activity_bargain_goods') . $where, $params, 'goods_id');
		foreach ($bargain_goods as &$goods ) 
		{
			$goods = goods_format($goods);
		}
		return $bargain_goods;
	}
}
function goods_format($goods) 
{
	$goods['is_sail_now'] = 1;
	if (!(goods_is_available($goods))) 
	{
		$goods['is_sail_now'] = 0;
	}
	if (isset($goods['discount_price']) && !(empty($goods['discount_price']))) 
	{
		$goods['old_price'] = (($goods['old_price'] ? $goods['old_price'] : $goods['price']));
		$goods['price'] = $goods['discount_price'];
		$goods['discount'] = round($goods['price'] / $goods['old_price'], 2) * 10;
	}
	$goods['totalnum'] = 0;
	$goods['thumb'] = tomedia($goods['thumb']);
	$goods['unitname_cn'] = ((!(empty($goods['unitname'])) ? '/' . $goods['unitname'] : ''));
	$goods['options'] = goods_option_fetch($goods['id']);
	$goods['is_attrs'] = 0;
	$goods['attrs'] = iunserializer($goods['attrs']);
	if (!(empty($goods['attrs']))) 
	{
		$goods['is_attrs'] = 1;
	}
	$goods['options_data'] = goods_build_options($goods);
	$week_cn = array();
	$time_cn = '';
	if ($goods['is_showtime'] == 1) 
	{
		if (!(empty($goods['week']))) 
		{
			$weeks = array(0, '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');
			$week = explode(',', $goods['week']);
			foreach ($week as $value ) 
			{
				foreach ($weeks as $key1 => $value1 ) 
				{
					if ($value == $key1) 
					{
						$week_cn[] = $value1;
					}
				}
			}
		}
		else 
		{
			$week_cn = array('星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');
		}
		if (!(empty($goods['start_time1']))) 
		{
			$time_cn = $goods['start_time1'] . '-' . $goods['end_time1'] . ' ';
		}
		if (!(empty($goods['start_time2']))) 
		{
			$time_cn .= $goods['start_time2'] . '-' . $goods['end_time2'];
		}
	}
	$goods['week_cn'] = implode(',', $week_cn);
	$goods['time_cn'] = $time_cn;
	return $goods;
}
function get_goods_item($goods_id, $option_id = 0, $sign = '+', $cart = array()) 
{
	global $_W;
	if ($sign == '+') 
	{
		$goods = pdo_get('tiny_wmall_goods', array('uniacid' => $_W['uniacid'], 'id' => $goods_id), array('id', 'price', 'box_price', 'total'));
		if (empty($goods)) 
		{
			return array('price' => 0, 'box_price' => 0);
		}
		$goods_info = array('box_price' => $goods['box_price']);
		if (!(empty($option_id))) 
		{
			$option = pdo_get('tiny_wmall_goods_options', array('uniacid' => $_W['uniacid'], 'goods_id' => $goods_id, 'id' => $option_id), array('id', 'price', 'total'));
			if (empty($option['total'])) 
			{
				return error(-1, '库存不足');
			}
			$goods_info['price'] = $option['price'];
			return $goods_info;
		}
		$sql = 'select a.*,b.id as bid, b. from ' . tablename('tiny_wmall_activity_bargain_goods') . ' as a left join' . tablename('tiny_wmall_activity_bargain') . ' as b on a.bargain_id = b.id where a.uniacid = :uniacid and a.goods_id = :goods_id and b.status = 1';
		$bargain_goods = pdo_fetch($sql, array(':uniacid' => $_W['uniacid'], ':goods_id' => $goods_id));
		if (empty($bargain_goods['bid']) || (($bargain_goods['discount_available_total'] != -1) && ($bargain_goods['discount_available_total'] < 0))) 
		{
			if (empty($goods['total'])) 
			{
				return error(-1, '库存不足');
			}
			$goods_info['price'] = $goods['price'];
			return $goods_info;
		}
		if (($bargain_goods['poi_user_type'] != 'all') && ($_W['member']['is_store_newmember'] == 1)) 
		{
			$goods_info['price'] = $goods['price'];
			return $goods_info;
		}
		if (!(empty($cart)) && !(empty($cart[$goods_id]))) 
		{
			$goods_num = 10;
			if ($bargain_goods['max_buy_limit'] < $goods_num) 
			{
				$goods_info['price'] = $goods['price'];
				return $goods_info;
			}
		}
		$bargain_id = $bargain_goods['bid'];
		$params = array(':uniacid' => $_W['uniacid'], ':sid' => $goods['sid'], ':stat_day' => date('Ymd'), ':uid' => $_W['member']['uid'], ':bargain_id' => $bargain_id);
		$where = ' where uniacid = :uniacid and sid = :sid and uid = :uid and stat_day = :stat_day and bargain_id = :bargain_id';
		$bargain_order = pdo_fetch('select count(distinct(oid)) as num, bargain_id from ' . tablename('tiny_wmall_order_stat') . $where, $params);
		if ($bargain_goods['order_limit'] <= $bargain_order['num']) 
		{
			$goods_info['price'] = $goods['price'];
			return $goods_info;
		}
		if (empty($cart)) 
		{
			$goods_info['price'] = $bargain_goods['discount_price'];
			return $goods_info;
		}
		$goods_ids = pdo_getall('tiny_wmall_activity_bargain_goods', array('uniacid' => $_W['uniacid'], 'bargain_id' => $bargain_id), array('goods_id'), 'goods_id');
		$goods_ids = array_keys($goods_ids);
		$cart_temp = $cart;
		unset($cart_temp[$goods_id]);
		$cart_goods_ids = array_keys($cart_temp);
		$diff = array_diff($goods_ids, $cart_goods_ids);
		if (empty($diff) || (count($diff) < $bargain_goods['goods_limit'])) 
		{
			$goods_info['price'] = $bargain_goods['discount_price'];
			return $goods_info;
		}
		$goods_info['price'] = $goods['price'];
		return $goods_info;
	}
}
function goods_avaliable_fetchall($sid, $cid = 0, $ignore_bargain = false) 
{
	global $_W;
	$result = array( 'goods' => array(), 'category' => array() );
	$categorys = store_fetchall_goods_category($sid, 1, true, 'parent', 'available');
	if (empty($categorys)) 
	{
		return $result;
	}
	$condition = ' where uniacid = :uniacid and sid = :sid and status = 1 order by displayorder desc, id desc';
	$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid);
	$goods = pdo_fetchall('select id, cid, title, price, box_price, total, thumb, sailed, label, content, is_options, attrs, unitname, comment_good, status, is_showtime, start_time1, end_time1, start_time2, end_time2, week from ' . tablename('tiny_wmall_goods') . $condition, $params, 'id');
	if (empty($goods)) 
	{
		return $result;
	}
	$options = pdo_fetchall('select * from ' . tablename('tiny_wmall_goods_options') . ' where uniacid = :uniacid and sid = :sid order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':sid' => $sid));
	$goods_options = array();
	foreach ($options as $option ) 
	{
		$option['discount_price'] = $option['price'];
		$goods_options[$option['goods_id']][$option['id']] = $option;
	}
	unset($options);
	$condition = ' where uniacid = :uniacid and sid = :sid and status = :status order by id limit 2';
	$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':status' => 1);
	if (!($ignore_bargain)) 
	{
		$bargains = pdo_fetchall('select id, title, content, order_limit, goods_limit from ' . tablename('tiny_wmall_activity_bargain') . $condition, $params, 'id');
		if (!(empty($bargains))) 
		{
			$bargain_ids = implode(',', array_keys($bargains));
			$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':stat_day' => date('Ymd'), ':uid' => $_W['member']['uid']);
			$where = ' where uniacid = :uniacid and sid = :sid and uid = :uid and stat_day = :stat_day and bargain_id in (' . $bargain_ids . ') group by bargain_id';
			$bargain_order = pdo_fetchall('select count(distinct(oid)) as num, bargain_id from ' . tablename('tiny_wmall_order_stat') . $where, $params, 'bargain_id');
			foreach ($bargains as &$bargain ) 
			{
				$bargain['avaliable_order_limit'] = $bargain['order_limit'];
				if (!(empty($bargain_order))) 
				{
					$bargain['avaliable_order_limit'] = $bargain['order_limit'] - intval($bargain_order[$bargain['id']]['num']);
				}
				$bargain['hasgoods'] = array();
				array_unshift($categorys, array('id' => 'bargain_' . $bargain['id'], 'title' => $bargain['title'], 'bargain_id' => $bargain['id']));
			}
			$where = ' where uniacid = :uniacid and sid = :sid and (discount_available_total = -1 or discount_available_total > 0) and bargain_id in (' . $bargain_ids . ')';
			$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid);
			$bargain_goods = pdo_fetchall('select * from ' . tablename('tiny_wmall_activity_bargain_goods') . $where, $params, 'goods_id');
		}
	}
	$cate_goods = array();
	foreach ($goods as &$good ) 
	{
		$good['is_sail_now'] = 1;
		if (!(goods_is_available($good))) 
		{
			$good['is_sail_now'] = 0;
		}
		$good['unitname_cn'] = ((!(empty($good['unitname'])) ? '/' . $good['unitname'] : ''));
		$good['options'] = $goods_options[$good['id']];
		$good['is_attrs'] = 0;
		$good['attrs'] = iunserializer($good['attrs']);
		if (!(empty($good['attrs']))) 
		{
			$good['is_attrs'] = 1;
		}
		$good['options_data'] = goods_build_options($good);
		$good['bargain_id'] = 0;
		if (!(empty($bargain_goods)) && in_array($good['id'], array_keys($bargain_goods)) && (($good['total'] == -1) || (0 < $good['total']))) 
		{
			$discount_goods = $bargain_goods[$good['id']];
			$good['bargain_id'] = $discount_goods['bargain_id'];
			$good['discount'] = round($discount_goods['discount_price'] / $good['price'], 2) * 10;
			$good['discount_price'] = $discount_goods['discount_price'];
			$good['discount_total'] = $discount_goods['discount_total'];
			$good['max_buy_limit'] = $discount_goods['max_buy_limit'];
			$good['poi_user_type'] = $discount_goods['poi_user_type'];
			$cate_goods['bargain_' . $discount_goods['bargain_id']][] = $good;
			$good['cid'] = 'bargain_' . $discount_goods['bargain_id'];
		}
		else 
		{
			$good['discount_price'] = $good['price'];
			$cate_goods[$good['cid']][] = $good;
		}
		$good['show'] = 0;
		if (!(empty($cid)) && ($good['cid'] == $cid)) 
		{
			$good['show'] = 1;
		}
		if ($good['is_showtime'] == 1) 
		{
			if (!(empty($good['week']))) 
			{
				$week = explode(',', $good['week']);
				$weeks = array(0, '星期一', '星期二', '星期三', '星期四', '星期五', '星期六', '星期日');
				$week_cn = array();
				foreach ($week as $val ) 
				{
					foreach ($weeks as $k => $v ) 
					{
						if ($val == $k) 
						{
							$week_cn[] = $v;
						}
					}
				}
				$good['week_cn'] = implode('，', $week_cn);
			}
			else 
			{
				$good['week_cn'] = '星期一，星期二，星期三，星期四，星期五，星期六，星期日';
			}
			$time_cn = '';
			if (!(empty($good['start_time1']))) 
			{
				$time_cn = $good['start_time1'] . '-' . $good['end_time1'] . ' ';
			}
			if (!(empty($good['start_time2']))) 
			{
				$time_cn .= $good['start_time2'] . '-' . $good['end_time2'];
			}
			if (empty($good['start_time1']) && empty($good['start_time2'])) 
			{
				$time_cn = '00:00-23:59';
			}
			$good['time_cn'] = $time_cn;
		}
	}
	if (!(is_array($bargains))) 
	{
		$bargains = array();
	}
	$result = array('goods' => $goods, 'cate_goods' => $cate_goods, 'category' => $categorys, 'bargains' => $bargains);
	return $result;
}
function goods_option_fetch($id) 
{
	global $_W;
	return pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods_options') . ' WHERE uniacid = :aid AND goods_id = :goods_id ORDER BY displayorder DESC, id ASC', array(':aid' => $_W['uniacid'], ':goods_id' => $id));
}
function goods_fetch($id) 
{
	global $_W;
	$data = pdo_get('tiny_wmall_goods', array('uniacid' => $_W['uniacid'], 'id' => $id));
	$data['options'] = array( array('id' => '0', 'title' => '', 'price' => $data['price'], 'total' => $data['total']) );
	if ($data['is_options'] == 1) 
	{
		$data['options'] = pdo_fetchall('SELECT * FROM ' . tablename('tiny_wmall_goods_options') . ' WHERE uniacid = :aid AND goods_id = :goods_id ORDER BY displayorder DESC, id ASC', array(':aid' => $_W['uniacid'], ':goods_id' => $id));
	}
	$data['is_attrs'] = 0;
	$data['attrs'] = iunserializer($data['attrs']);
	if (!(empty($data['attrs']))) 
	{
		$data['is_attrs'] = 1;
	}
	$options = goods_build_options($data);
	$option = array_slice($options, 0, 1);
	$key = key($option);
	$data['price'] = floatval($option[$key]['price']);
	$data['option_id'] = $key;
	$data['thumb_'] = tomedia($data['thumb']);
	if (!($data['comment_total'])) 
	{
		$data['comment_good_percent'] = '0%';
	}
	else 
	{
		$data['comment_good_percent'] = round(($data['comment_good'] / $data['comment_total']) * 100, 2) . '%';
	}
	if (!(empty($data['slides']))) 
	{
		$data['slides'] = iunserializer($data['slides']);
		foreach ($data['slides'] as &$slide ) 
		{
			$slide = tomedia($slide);
		}
	}
	else 
	{
		$data['slides'] = array();
	}
	return $data;
}
function goods_build_options($goods) 
{
	if (!($goods['is_options'])) 
	{
		$goods['options'] = array( array('id' => '0', 'name' => '', 'price' => $goods['price'], 'total' => $goods['total']) );
	}
	if (!(is_array($goods['attrs']))) 
	{
		$goods['attrs'] = iunserializer($goods['attrs']);
	}
	if (!(empty($goods['attrs'])) && is_array($goods['attrs'])) 
	{
		$goods['is_attrs'] = 1;
	}
	if (!($goods['is_attrs'])) 
	{
		$options = array();
		foreach ($goods['options'] as $option ) 
		{
			$options[$option['id']] = $option;
		}
		return $options;
	}
	foreach ($goods['attrs'] as $key1 => $value ) 
	{
		$labels = array();
		foreach ($value['label'] as $key2 => $label ) 
		{
			$labels[$key1 . 's' . $key2] = $label;
		}
		$attrs[] = $labels;
	}
	$attrs = dikaer($attrs, 'v');
	$options = array();
	foreach ($goods['options'] as $option ) 
	{
		foreach ($attrs as $key => $attr ) 
		{
			$index = $option['id'] . '_' . $key;
			$title = $attr;
			if (!(empty($option['name']))) 
			{
				$title = $option['name'] . '+' . $attr;
			}
			$attr = array('name' => $title);
			$options[$index] = array_merge($option, $attr);
		}
	}
	return $options;
}
function tranferOptionid($optionid) 
{
	if ($optionid == 0) 
	{
		return 0;
	}
	$params = explode('_', $optionid);
	return $params[0];
}
function goods_is_available($goodsOrId) 
{
	global $_W;
	$goods = $goodsOrId;
	if (!(is_array($goods)) || empty($goods['is_showtime'])) 
	{
		$id = $goods;
		if (is_array($goods)) 
		{
			$id = $goods['id'];
		}
		$goods = pdo_fetch('select a.status, a.is_showtime, a.start_time1, a.end_time1, a.start_time2, a.end_time2, a.week, b.is_showtime as c_is_showtime, b.start_time as c_start_time, b.end_time as c_end_time, b.week as c_week from ' . tablename('tiny_wmall_goods') . ' as a left join ' . tablename('tiny_wmall_goods_category') . ' as b on a.cid = b.id where a.uniacid = :uniacid and a.id = :id', array('uniacid' => $_W['uniacid'], 'id' => $id));
		if (empty($goods['is_showtime']) && !(empty($goods['c_is_showtime']))) 
		{
			$goods['is_showtime'] = $goods['c_is_showtime'];
			$goods['start_time1'] = $goods['c_start_time'];
			$goods['end_time1'] = $goods['c_end_time'];
			$goods['week'] = $goods['c_week'];
		}
	}
	if ($goods['status'] != 1) 
	{
		return false;
	}
	if (!(empty($goods['is_showtime']))) 
	{
		$now_week = date('N', TIMESTAMP);
		$start_time1 = intval(strtotime($goods['start_time1']));
		$end_time1 = intval(strtotime($goods['end_time1']));
		$start_time2 = intval(strtotime($goods['start_time2']));
		$end_time2 = intval(strtotime($goods['end_time2']));
		if (!(empty($goods['week']))) 
		{
			$week = explode(',', $goods['week']);
		}
		if (!(empty($week)) && !(in_array($now_week, $week))) 
		{
			return false;
		}
		if ((!(empty($start_time1)) && ($start_time1 < TIMESTAMP) && (TIMESTAMP < $end_time1)) || (!(empty($start_time2)) && ($start_time2 < TIMESTAMP) && (TIMESTAMP < $end_time2))) 
		{
			return true;
		}
		if (empty($start_time1) && empty($start_time2)) 
		{
			return true;
		}
		return false;
	}
	return true;
}
function goods_filter($sid, $filter = array()) 
{
	global $_W;
	global $_GPC;
	if (empty($filter)) 
	{
		if (!(empty($_GPC['cid']))) 
		{
			$filter['cid'] = trim($_GPC['cid']);
		}
		if (!(empty($_GPC['child_id']))) 
		{
			$filter['child_id'] = intval($_GPC['child_id']);
		}
		if (!(empty($_GPC['type']))) 
		{
			$filter['type'] = trim($_GPC['type']);
		}
		if (!(empty($_GPC['value']))) 
		{
			$filter['value'] = trim($_GPC['value']);
		}
		if (!(empty($_GPC['page']))) 
		{
			$filter['page'] = max(1, intval($_GPC['page']));
		}
		if (!(empty($_GPC['psize']))) 
		{
			$filter['psize'] = intval($_GPC['psize']);
		}
	}
	$goods_categorys = pdo_fetchall('select id, is_showtime, start_time, end_time, week from ' . tablename('tiny_wmall_goods_category') . 'where uniacid = :uniacid and sid = :sid and parentid = 0', array(':uniacid' => $_W['uniacid'], ':sid' => $sid), 'id');
	if (strexists($filter['cid'], 'bargain_')) 
	{
		$bargain_id = str_replace('bargain_', '', $filter['cid']);
		$where = ' as a left join ' . tablename('tiny_wmall_goods') . ' as b on a.goods_id = b.id where a.uniacid = :uniacid and a.sid = :sid and (a.discount_available_total = -1 or a.discount_available_total > 0) and a.bargain_id = :bargain_id order by b.displayorder desc, b.id desc';
		$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':bargain_id' => $bargain_id);
		$bargain_goods = pdo_fetchall('select a.*, b.* from ' . tablename('tiny_wmall_activity_bargain_goods') . $where, $params);
		if (!(empty($bargain_goods))) 
		{
			$cart = order_fetch_member_cart($sid);
			$cart_goodsids = array();
			if (!(empty($cart))) 
			{
				$cart_goodsids = array_keys($cart['data']);
			}
			foreach ($bargain_goods as &$goods ) 
			{
				$goods['is_showtime'] = $goods_categorys[$goods['cid']]['is_showtime'];
				$goods['start_time1'] = $goods_categorys[$goods['cid']]['start_time'];
				$goods['end_time1'] = $goods_categorys[$goods['cid']]['end_time'];
				$goods['week'] = $goods_categorys[$goods['cid']]['week'];
				$goods = goods_format($goods);
				if (in_array($goods['id'], $cart_goodsids)) 
				{
					foreach ($cart['data'][$goods['id']]['options'] as $key => $cart_option ) 
					{
						$goods['options_data'][$key]['num'] = $cart_option['num'];
						$goods['totalnum'] += $cart_option['num'];
					}
				}
			}
		}
		return $bargain_goods;
	}
	$condition = ' where uniacid = :uniacid and sid = :sid and status = 1';
	$params = array(':uniacid' => $_W['uniacid'], ':sid' => $sid);
	if (!(empty($filter['cid']))) 
	{
		$condition .= ' and cid = :cid';
		$params[':cid'] = $filter['cid'];
	}
	else if (!(empty($filter['goodsids'])) && is_array($filter['goodsids'])) 
	{
		$filter['goodsids'] = implode(',', $filter['goodsids']);
		$condition .= ' and id in (' . $filter['goodsids'] . ')';
	}
	if (!(empty($filter['child_id']))) 
	{
		$condition .= ' and child_id = :child_id';
		$params[':child_id'] = $filter['child_id'];
	}
	$orderby = ' order by displayorder desc, id desc';
	if (!(empty($filter['type'])) && !(empty($filter['value']))) 
	{
		$orderby = ' order by CONVERT(' . $filter['type'] . ',SIGNED) ' . $filter['value'] . ', displayorder desc, id desc';
	}
	$pindex = max(1, intval($filter['page']));
	$psize = ((!(isset($filter['psize'])) ? 30 : $filter['psize']));
	$condition .= $orderby . ' LIMIT ' . (($pindex - 1) * $psize) . ' , ' . $psize;
	$goods = pdo_fetchall('select id, cid, child_id, title, price, box_price, total, thumb, sailed, label, content, is_options, attrs, unitname, comment_good, status, is_showtime, start_time1, end_time1, start_time2, end_time2, week from ' . tablename('tiny_wmall_goods') . $condition, $params);
	if (!(empty($goods))) 
	{
		$cart = order_fetch_member_cart($sid);
		$cart_goodsids = array();
		if (!(empty($cart))) 
		{
			$cart_goodsids = array_keys($cart['data']);
		}
		foreach ($goods as &$good ) 
		{
			$bargain_goods = pdo_fetch('select a.discount_price,a.max_buy_limit,b.status as bargain_status from ' . tablename('tiny_wmall_activity_bargain_goods') . ' as a left join ' . tablename('tiny_wmall_activity_bargain') . ' as b on a.bargain_id = b.id where a.uniacid = :uniacid and a.sid = :sid and a.goods_id = :goods_id and a.status = 1 and b.status = 1', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':goods_id' => $good['id']));
			if (!(empty($bargain_goods['bargain_status']))) 
			{
				$good = array_merge($good, $bargain_goods);
			}
			$good['unitname_cn'] = ((!(empty($good['unitname'])) ? '/' . $good['unitname'] : ''));
			if ($goods_categorys[$good['cid']]['is_showtime'] == 1) 
			{
				$good['is_showtime'] = $good['is_showtime'] || $goods_categorys[$good['cid']]['is_showtime'];
				$good['start_time1'] = $goods_categorys[$good['cid']]['start_time'];
				$good['end_time1'] = $goods_categorys[$good['cid']]['end_time'];
			}
			$good['week'] = $goods_categorys[$good['cid']]['week'];
			$good = goods_format($good);
			if (in_array($good['id'], $cart_goodsids)) 
			{
				foreach ($cart['data'][$good['id']] as $key => $cart_option ) 
				{
					$good['options_data'][$key]['num'] = $cart_option['num'];
					$good['totalnum'] += $cart_option['num'];
				}
			}
		}
	}
	return $goods;
}
?>