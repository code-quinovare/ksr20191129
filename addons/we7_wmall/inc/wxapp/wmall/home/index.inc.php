<?php
defined('IN_IA') || exit('Access Denied');
mload()->model('page');
global $_W;
global $_GPC;
$ta = ((trim($_GPC['ta']) ? trim($_GPC['ta']) : 'index'));
$config_mall = $_W['we7_wmall']['config']['mall'];
if (defined('IN_WXAPP')) 
{
	icheckauth();
	$_config_wxapp_basic = $_config_wxapp['basic'];
	$_config_wxapp_basic['new_audit_status'] = 0;
	if ($_W['we7_wxapp']['config']['basic']['release_version'] < $_W['we7_wxapp']['config']['basic']['request_version']) 
	{
		if ($_config_wxapp_basic['audit_status'] == 1) 
		{
			$_config_wxapp_basic['new_audit_status'] = 1;
		}
	}
	if ($_config_wxapp_basic['new_audit_status'] == 1) 
	{
		$config_mall['version'] = 2;
		$config_mall['default_sid'] = $_config_wxapp_basic['default_sid'];
		$config_mall['store_url'] = $_config_wxapp_basic['store_url'];
	}
}
else 
{
	icheckauth(false);
}
if ($ta == 'index') 
{
	mload()->model('plugin');
	if ($_W['ochannel'] == 'wxapp') 
	{
		if ($_config_wxapp['diy']['use_diy_home'] != 1) 
		{
			$slides = sys_fetch_slide('homeTop', true);
			$categorys = store_fetchall_category();
			$categorys_chunk = array_chunk($categorys, 8);
			$notices = pdo_fetchall('select id,title,link,wxapp_link,displayorder,status from' . tablename('tiny_wmall_notice') . ' where uniacid = :uniacid and agentid = :agentid and type = :type and status = 1 order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid'], ':type' => 'member'));
			$recommends = store_fetchall_by_condition('recommend', array('extra_type' => 'base'));
			$cubes = pdo_fetchall('select * from ' . tablename('tiny_wmall_cube') . ' where uniacid = :uniacid and agentid = :agentid order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
			if (!(empty($cubes))) 
			{
				foreach ($cubes as &$c ) 
				{
					$c['thumb'] = tomedia($c['thumb']);
				}
			}
			if (check_plugin_perm('bargain')) 
			{
				$_config_bargain = get_plugin_config('bargain');
				if (($_config_bargain['status'] == 1) && ($_config_bargain['is_home_display'] == 1)) 
				{
					$bargains = pdo_fetchall('select a.discount_price,a.goods_id,b.title,b.thumb,b.price,b.sid,c.is_rest from ' . tablename('tiny_wmall_activity_bargain_goods') . ' as a left join ' . tablename('tiny_wmall_goods') . ' as b on a.goods_id = b.id left join ' . tablename('tiny_wmall_store') . 'as c on b.sid = c.id where a.uniacid = :uniacid and a.agentid = :agentid and a.status = 1 and b.status = 1 order by c.is_rest asc, a.mall_displayorder desc limit 8', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
					foreach ($bargains as &$val ) 
					{
						$val['thumb'] = tomedia($val['thumb']);
						$val['discount'] = round(($val['discount_price'] / $val['price']) * 10, 1);
					}
				}
			}
			$orderbys = store_orderbys();
			$discounts = store_discounts();
			$result = array('is_use_diy' => 0, 'config' => $config_mall, 'slides' => $slides, 'categorys' => $categorys, 'categorys_chunk' => $categorys_chunk, 'notices' => $notices, 'recommends' => $recommends, 'cubes' => $cubes, 'bargains' => $bargains, 'stores' => store_filter(), 'orderbys' => $orderbys, 'discounts' => $discounts, 'cart_sum' => get_member_cartnum());
		}
		else 
		{
			$id = $_config_wxapp['diy']['shopPage']['home'];
			if (empty($id)) 
			{
				imessage(error(-1, '未设置首页DIY页面'), '', 'ajax');
			}
			mload()->model('diy');
			$page = get_wxapp_diy($id, true, array('from' => ''));
			if (empty($page)) 
			{
				imessage(error(-1, '页面不能为空'), '', 'ajax');
			}
			$result = array('is_use_diy' => 1, 'config' => $config_mall, 'config_wxapp' => $_config_wxapp, 'diy' => $page, 'stores' => store_filter(), 'cart_sum' => ($page['is_show_cart'] == 1 ? get_member_cartnum() : 0));
		}
	}
	else 
	{
		mload()->model('diy');
		if ($_config_wxapp['diy']['use_diy_home'] != 1) 
		{
			$pageOrid = get_wap_defaultpage();
		}
		else 
		{
			$pageOrid = $_config_wxapp['diy']['shopPage']['home'];
			if (empty($pageOrid)) 
			{
				imessage(error(-1, '未设置首页DIY页面'), '', 'ajax');
			}
		}
		$page = get_wxapp_diy($pageOrid, true, array('from' => 'wap'));
		if (empty($page)) 
		{
			imessage(error(-1, '页面不能为空'), '', 'ajax');
		}
		$result = array('is_use_diy' => 1, 'config' => $config_mall, 'config_wxapp' => $_config_wxapp, 'diy' => $page, 'stores' => store_filter(), 'cart_sum' => ($page['is_show_cart'] == 1 ? get_member_cartnum() : 0));
	}
	if (check_plugin_perm('superRedpacket')) 
	{
		pload()->model('superRedpacket');
		$result['superRedpacketData'] = superRedpacket_grant_show();
	}
	if (check_plugin_perm('spread')) 
	{
		mload()->model('plugin');
		pload()->model('spread');
		$spread = member_spread_bind();
		if (!(is_error($spread))) 
		{
			$spread = error(0, $spread);
		}
		$result['spread'] = $spread;
	}
	$guide = json_decode(base64_decode($_config_wxapp['guide']), true);
	if (!(empty($guide['data']))) 
	{
		foreach ($guide['data'] as &$gvalue ) 
		{
			$gvalue['imgUrl'] = tomedia($gvalue['imgUrl']);
		}
	}
	$result['guide'] = $guide;
	$_W['_share'] = get_mall_share();
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'store') 
{
	$result = store_filter();
	imessage(error(0, $result), '', 'ajax');
	return 1;
}
if ($ta == 'spread') 
{
	if (check_plugin_perm('spread')) 
	{
		mload()->model('plugin');
		pload()->model('spread');
		$spread = member_spread_bind();
		if (!(is_error($spread))) 
		{
			$spread = error(0, $spread);
		}
		imessage($spread, '', 'ajax');
		return 1;
	}
}
else if ($ta == 'cart') 
{
	$result = array('cart_sum' => get_member_cartnum());
	imessage(error(0, $result), '', 'ajax');
}
?>