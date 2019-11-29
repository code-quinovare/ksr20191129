<?php

//http://www.shuotupu.com
//说图谱网
defined('IN_IA') || exit('Access Denied');
global $_W;
global $_GPC;
icheckauth();
mload()->model('goods');
mload()->model('activity');
$sid = intval($_GPC['sid']);
$store = store_fetch($sid);
if (empty($store)) 
{
	imessage(error(-1, '门店不存在或已经删除'), '', 'ajax');
}
store_business_hours_init($sid);
activity_store_cron($sid);
$footmark = pdo_get('tiny_wmall_member_footmark', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'sid' => $sid, 'stat_day' => date('Ymd')), array('id'));
if (empty($footmark)) 
{
	$insert = array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid'], 'sid' => $sid, 'addtime' => TIMESTAMP, 'stat_day' => date('Ymd'));
	pdo_insert('tiny_wmall_member_footmark', $insert);
}
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
	$template = (($store['data']['wxapp']['template'] ? $store['data']['wxapp']['template'] : 1));
	$categorys = array_values(store_fetchall_goods_category($sid, 1, false, 'all'));
	$result = array('store' => $store, 'coupon' => $coupons, 'category' => $categorys, 'cart' => cart_data_init($sid), 'template' => $template);
	$cid = $categorys[0]['id'];
	$cid = ((intval($_GPC['cid']) ? intval($_GPC['cid']) : $cid));
	if (strexists($cid, 'bargain_')) 
	{
		$result['goods'] = goods_filter1($sid, array('cid' => $cid));
	}
	else 
	{
		$child_id = 0;
		if (!(empty($categorys[0]['child']))) 
		{
			$child_id = $categorys[0]['child'][0]['id'];
		}
		$result['goods'] = goods_filter1($sid, array('cid' => $cid, 'child_id' => $child_id));
	}
	$result['cid'] = $cid;
	imessage(error(0, $result), '', 'ajax');
}
if ($ta == 'goods') 
{
	$goods = goods_filter1($sid);
	$result = array('goods' => $goods);
	imessage(error(0, $result), '', 'ajax');
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
	$bargain_goods = pdo_get('tiny_wmall_activity_bargain_goods', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'goods_id' => $id, 'status' => 1), array('discount_price', 'max_buy_limit'));
	if (!(empty($bargain_goods))) 
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
}
if ($ta == 'truncate') 
{
	$data = pdo_delete('tiny_wmall_order_cart', array('uniacid' => $_W['uniacid'], 'sid' => $sid, 'uid' => $_W['member']['uid']));
	imessage(error(0, ''), '', 'ajax');
}
if ($ta == 'cart') 
{
	$goods_id = intval($_GPC['goods_id']);
	$option_id = trim($_GPC['option_id']);
	$sign = trim($_GPC['sign']);
	$cart = cart_data_init($sid, $goods_id, $option_id, $sign);
	imessage($cart, '', 'ajax');
}
if ($ta == 'shopPage') 
{
	$shopPageKey = trim($_GPC['shopPageKey']);
	$goodsids = $store['data']['shopPage'][$shopPageKey]['goods'];
	$goods = goods_filter($sid, array('goodsids' => $goodsids, 'psize' => 1000));
	$store['data']['shopPage'][$shopPageKey]['thumb'] = tomedia($store['data']['shopPage'][$shopPageKey]['thumb']);
	$result = array('goods' => $goods, 'store' => $store, 'cart' => cart_data_init($sid));
	imessage(error(0, $result), '', 'ajax');
}
?>