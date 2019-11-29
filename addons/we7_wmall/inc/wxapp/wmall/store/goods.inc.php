<?php
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
icheckauth();
mload()->model('goods');
mload()->model('activity');
$sid = intval($_GPC['sid']);
store_business_hours_init($sid);
$store = store_fetch($sid);
if (empty($store)) 
{
	imessage(error(-1, '门店不存在或已经删除'), '', 'ajax');
}
activity_store_cron($sid);
if ($_GPC['from'] == 'search') 
{
	pdo_query('update ' . tablename('tiny_wmall_store') . ' set click = click + 1 where uniacid = :uniacid and id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $sid));
}
$price = store_order_condition($store);
$store['send_price'] = $price['send_price'];
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : $store['template']));
if ($ta == 'index') 
{
	$store['activity'] = store_fetch_activity($sid);
	$store['is_favorite'] = is_favorite_store($sid, $_W['member']['uid']);
	mload()->model('coupon');
	$coupons = coupon_collect_member_available($sid);
	if (!(empty($_GPC['order_id']))) 
	{
		order_place_again($sid, $_GPC['order_id']);
	}
	if (!(empty($store['data']['shopPage']))) 
	{
		foreach ($store['data']['shopPage'] as &$val ) 
		{
			$val['goodsLength'] = count($val['goods']);
			$val['thumb'] = tomedia($val['thumb']);
		}
	}
	if (!(empty($store['data']['shopSign']))) 
	{
		$store['data']['shopSign'] = tomedia($store['data']['shopSign']);
	}
	$template = (($store['data']['wxapp']['template'] ? $store['data']['wxapp']['template'] : 1));
	$categorys = array_values(store_fetchall_goods_category($sid, 1, false, 'all', 'available'));
	$result = array('store' => $store, 'coupon' => $coupons, 'category' => $categorys, 'cart' => cart_data_init($sid), 'template' => $template, 'lazyload_goods' => $_config_mall['lazyload_goods']);
	$cid = ((intval($_GPC['cid']) ? intval($_GPC['cid']) : $categorys[0]['id']));
	$child_id = 0;
	if (!(empty($categorys[0]['child']))) 
	{
		$child_id = $categorys[0]['child'][0]['id'];
	}
	$result['goods'] = goods_filter($sid, array('cid' => $cid, 'child_id' => $child_id));
	$result['cid'] = $cid;
	$result['child_id'] = $child_id;
	if ($store['is_rest']) 
	{
		$result['recommend_stores'] = store_fetchall_by_condition('recommend', array('extra_type' => 'all', 'is_rest' => 0));
	}
	$_W['_share'] = array('title' => $store['title'], 'desc' => $store['content'], 'imgUrl' => tomedia($store['logo']), 'link' => ivurl('/pages/store/share', array('sid' => $sid), true));
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'goods') 
{
	$goods = goods_filter($sid);
	$result = array('goods' => $goods);
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'detail') 
{
	$sid = intval($_GPC['sid']);
	$id = intval($_GPC['id']);
	$goods = goods_fetch($id);
	if (is_error($goods)) 
	{
		imessage(error(-1, '商品不存在或已删除'), '', 'ajax');
	}
	$bargain_goods = pdo_fetch('select a.discount_price,a.max_buy_limit,b.status as bargain_status from ' . tablename('tiny_wmall_activity_bargain_goods') . ' as a left join ' . tablename('tiny_wmall_activity_bargain') . ' as b on a.bargain_id = b.id where a.uniacid = :uniacid and a.sid = :sid and a.goods_id = :goods_id and a.status = 1 and b.status = 1', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':goods_id' => $id));
	if (!(empty($bargain_goods['bargain_status']))) 
	{
		$goods = array_merge($goods, $bargain_goods);
	}
	$cart = order_fetch_member_cart($sid);
	$goods = goods_format($goods);
	if (!(empty($cart['data'][$id]))) 
	{
		foreach ($cart['data'][$id] as $key => $cart_option ) 
		{
			$goods['options_data'][$key]['num'] = $cart_option['num'];
			$goods['totalnum'] += $cart_option['num'];
		}
	}
	$result = array('goodsDetail' => $goods, 'cart' => cart_data_init($sid), 'store' => $store);
	message(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'truncate') 
{
	$data = pdo_delete('tiny_wmall_order_cart', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid']));
	imessage(error(0, ''), '', 'ajax');
	return 1;
}
if ($ta == 'cart') 
{
	$goods_id = intval($_GPC['goods_id']);
	$option_id = trim($_GPC['option_id']);
	$sign = trim($_GPC['sign']);
	$cart = cart_data_init($sid, $goods_id, $option_id, $sign);
	imessage($cart, '', 'ajax');
	return 1;
}
if ($ta == 'shopPage') 
{
	$shopPageKey = trim($_GPC['shopPageKey']);
	$goodsids = $store['data']['shopPage'][$shopPageKey]['goods'];
	$goods = goods_filter($sid, array('goodsids' => $goodsids, 'psize' => 1000));
	$store['data']['shopPage'][$shopPageKey]['thumb'] = tomedia($store['data']['shopPage'][$shopPageKey]['thumb']);
	$result = array('goods' => $goods, 'store' => $store, 'cart' => cart_data_init($sid));
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'pindan') 
{
	mload()->model('pindan');
	$cart = pdo_get('tiny_wmall_order_cart', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid']));
	if (empty($cart)) 
	{
		imessage(error(-1, '购物车数据不存在'), '', 'ajax');
	}
	pdo_update('tiny_wmall_order_cart', array('pindan_status' => 1), array('id' => $cart['id']));
	$pindan = pindan_data_init($sid, $cart['id']);
	imessage(error(0, $pindan), '', 'ajax');
}
?>