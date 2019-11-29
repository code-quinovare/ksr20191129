<?php
/**
 * 外送系统
 * @author 说图谱网
 * @url http://www.shuotupu.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'index';
set_time_limit(0);
$uniacid = 1;
$stores =  pdo_getall('tiny_wmall_store', array('uniacid' => $uniacid), array('id', 'data'));
foreach($stores as $store) {
	$store['data'] = iunserializer($store['data']);
	$store['data']['wxapp']['template'] = 2;
	pdo_update('tiny_wmall_store', array('data' => iserializer($store['data'])), array('uniacid' => $uniacid, 'id' => $store['id']));
}
die();
/*	$tables = array(
		'tiny_wmall_store_deliveryer', 'tiny_wmall_deliveryer', 'tiny_wmall_agent', 'tiny_wmall_members', 'tiny_wmall_address', 'tiny_wmall_store_clerk', 'tiny_wmall_clerk', 'tiny_wmall_store', 'tiny_wmall_goods_category', 'tiny_wmall_store_category', 'tiny_wmall_goods', 'tiny_wmall_goods_options'
	);
	foreach($tables as $table) {
		pdo_delete($table, array('uniacid' => $uniacid));
	}
	echo 111;die;*/
if($op == 'index') {
	include itemplate('system/test2');
	//include itemplate('system/test');
}
elseif($op == 'user') {
	$page = $_GPC['page'] ? $_GPC['page'] : 1;
	$psize = 2000;
	$condition = ' where 1';
	$limit = ' order by uid desc limit ' . ($page - 1) * $psize . ',' . $psize;
	$users = pdo_fetchall('select * from ' . tablename('pigcms_user') . $condition . $limit);
	foreach($users as $val) {
		$update = array(
			'uniacid' => $uniacid,
			'openid' => $val['openid'],
			'unionId' => $val['union_id'],
			'uid' => date('His') . random(3, true),
			'mobile' => $val['phone'],
			'salt' => random(6, true),
			'nickname' => $val['nickname'],
			'realname' => $val['truename'],
			'avatar' => $val['avatar'],
			'addtime' => $val['add_time'],
			'credit2' => $val['now_money'],
			'mobile_audit' => $val['is_check_phone'],
			'status' => $val['status'],
			'token' => random(32),
		);
		$update['password'] = md5(md5($update['salt'] . '888888') . $update['salt']);
		if($val['sex'] == 1) {
			$update['sex'] = '男';
		} elseif($val['sex'] == 2) {
			$update['sex'] = '女';
		} else {
			$update['sex'] = '';
		}
		pdo_insert('tiny_wmall_members', $update);
		$addresses = pdo_getall('pigcms_user_adress', array('uid' => $val['uid']));
		foreach($addresses as $v) {
			$address_update = array(
				'uid' => $update['uid'],
				'uniacid' => $uniacid,
				'realname' => $v['name'],
				'sex' => $update['sex'],
				'mobile' => $v['phone'],
				'address' => $v['adress'].$v['detail'],
				//'number' => $val['detail'],
				'location_x' => $v['latitude'],
				'location_y' => $v['longitude'],
				'is_default' => $v['default'],
			);
			pdo_insert('tiny_wmall_address', $address_update);
		}
	}
	if(count($users) == 2000) {
		$page++;
		imessage('导入第'.($page -1).'用户数据', iurl('system/test/user', array('page' => $page)), 'success');
	} else {
		unset($page);
		imessage('顾客导入成功，即将导入商户等数据', iurl('system/test/store'), 'success');
	}
}
elseif($op == 'store') {
	$areas = array(
		'3106' => array(
			'area_id' => 3106,
			'area_name' => '富宁县',
			'area_ip_desc' => '云南省文山壮族苗族自治州富宁县',
			'first_pinyin' => 'F',
			'mobile' => 1234567891
		),
		'630' => array(
			'area_id' => 630,
			'area_name' => '龙胜各族自治县',
			'area_ip_desc' => '广西自治区桂林市龙胜各族自治县',
			'first_pinyin' => 'X',
			'mobile' => 1234567892
		),
		'649' => array(
			'area_id' => 649,
			'area_name' => '昭平县',
			'area_ip_desc' => '广西自治区贺州市昭平县',
			'first_pinyin' => 'X',
			'mobile' => 1234567893
		),
		'616' => array(
			'area_id' => 616,
			'area_name' => '桂平市',
			'area_ip_desc' => '广西自治区贵港市桂平市',
			'first_pinyin' => 'G',
			'mobile' => 1234567894
		),
		'631' => array(
			'area_id' => 631,
			'area_name' => '资源县',
			'area_ip_desc' => '广西自治区桂林市资源县',
			'first_pinyin' => 'Z',
			'mobile' => 1234567895
		),
		'636' => array(
			'area_id' => 636,
			'area_name' => '金城江区',
			'area_ip_desc' => '广西自治区河池市金城江区',
			'first_pinyin' => 'J',
			'mobile' => 1234567896
		),
		'567' => array(
			'area_id' => 567,
			'area_name' => '南宁',
			'area_ip_desc' => '广西自治区南宁市',
			'first_pinyin' => 'N',
			'mobile' => 1234567897
		),
	);
	foreach($areas as $area) {
		$area_update = array(
			'uniacid' => $uniacid,
			'title' => $area['area_name'],
			'area' => $area['area_ip_desc'],
			'initial' => $area['first_pinyin'],
			'status' => 1,
			'salt' => random(6),
			'mobile' => $area['mobile'],
		);
		$area_update['password'] = md5(md5($area_update['salt'] . '888888') . $area_update['salt']);
		pdo_insert('tiny_wmall_agent', $area_update);
		$agentid = pdo_insertid();
		$areas[$area['area_id']]['agentid'] = $agentid;
	}
	//pigcms_merchant_category, pigcms_shop_category
	$categorys = pdo_fetchall('select * from ' . tablename('pigcms_merchant_category') . ' where cat_fid = 0');
	$old2new = array();
	foreach ($categorys as $value) {
		$data = array(
			'uniacid' => $uniacid,
			'title' => trim($value['cat_name']),
			//'thumb' => trim($value['icon']),
			'status' => trim($value['cat_status']),
			'displayorder' => intval($value['cat_sort'])
		);
		pdo_insert('tiny_wmall_store_category',$data);
		$new_store_category_id = pdo_insertid();
		$old2new['store_category'][$value['cat_id']] = $new_store_category_id;
	}
	echo '商户类型OK';

	$shops = pdo_fetchall('select a.*, b.* from ' . tablename('pigcms_merchant_store') . ' as a left join ' . tablename('pigcms_merchant_store_shop') . ' as b on a.store_id = b.store_id');
	foreach ($shops as $value) {
		//美团， 饿了么, 审核状态auth，auth_files, 配送费，图片
		/*	$thumbs = array(
				array('image' => $value['photo']),
				array('image' => $value['photo1']),
				array('image' => $value['photo2']),
				array('image' => $value['photo3'])
			);*/
		$dataShop = array(
			'uniacid' => $uniacid,
			'agentid' => $areas[$value['area_id']]['agentid'],
			'cid' => "|{$old2new['store_category'][$value['cat_fid']]}|",
			'title' => trim($value['name']),
			//'logo' => trim($value['pic_info']),
			'telephone' => trim($value['phone']),//
			//'thumbs' => iserializer(array($value['pic_info'])),
			'address' => trim($value['adress']),
			'location_x' => $value['lat'],
			'location_y' => $value['long'],
			'displayorder' => $value['sort'],
			'addtime' => $value['last_time'],
			'description' => $value['feature'],
			'content' => $value['txt_info'],
			'sns' => iserializer(array(
				'qq' => trim($value['qq']),
				'weixin' => trim($value['weixin']),
			)),
			'consume_per_person' => $value['permoney'],
			'invoice_status' => $value['is_invoice'],
			'is_reserve' => $value['is_reserve'],
			'delivery_within_days' => $value['advance_day'],
			'auto_handel_order' => $value['is_auto_order'],
			'discount_status' => $value['store_discount'],
			'notice' => trim($value['store_notice']),
			'sailed' => $value['sale_count'],
			'score' => $value['score_mean'],
			'serve_radius' => $value['delivery_radius'],
			'delivery_type' => $value['deliver_type'] < 2  ? 1 : $value['deliver_type'],//$value['deliver_type'] == 3没说明
			'is_rest' => $value['is_close'],

			//'elemeShopId' => $value['eleme_shopId'],

			/*		'data' => iserializer(array(
						'dada' => array(
							'shopno' => trim($value['dada_shop_id']),
							'status' => 1,
							'citycode' => trim($value['dada_city_code'])
						),
					)),

					'delivery_price' => iserializer($thumbs),
					'delivery_free_price' => intval($value['s_full_money']),
					'delivery_time' => $value['send_time'],
					'delivery_times' => iserializer(array(
						array(
							'start' => $value['delivertime_start'],
							'end' => $value['delivertime_stop'],
							'status' => 1,
							'fee' => 0,
						),
					)),
					'addtype' => trim($value['adress']),
					'auto_notice_deliveryer' => $value['long'],
					'click' => $value['hits'],
					'delivery_mode' => $value['keywords'],
					'delivery_fee_mode' => $value['last_time'],
					'meituanShopId' => $value['long'],*/
		);
		if(!empty($value['pic_info'])) {
			$value['pic_info'] = trim($value['pic_info']);
			$value['pic_info'] = str_replace('，', ',', $value['pic_info']);
			$value['pic_info'] = str_replace(',', '/', $value['pic_info']);
			$dataShop['logo'] = '/store/' . $value['pic_info'];
		}
		if($value['auth'] == 1 || $value['auth'] == 4) {
			$dataShop['status'] = 2;
		} elseif($value['auth'] == 3) {
			$dataShop['status'] = 1;
		} elseif($value['auth'] == 2 || $value['auth'] == 5) {
			$dataShop['status'] = 3;
		}
		if($value['open_1'] == '00:00:00' && $value['close_1'] == '00:00:00' && $value['open_2']== '00:00:00' && $value['close_2'] == '00:00:00' && $value['open_3']== '00:00:00' && $value['close_3'] == '00:00:00') {
			$hours = array(
				array(
					's' => '09:00',
					'e' => '21:00'
				)
			);
		} else {
			$hours = array();
			if($value['open_1'] != $value['close_1']) {
				$hours[] = array(
					's' => $value['open_1'],
					'e' => $value['close_1']
				);
			}
			if($value['open_2'] != $value['close_2']) {
				$hours[] = array(
					's' => $value['open_2'],
					'e' => $value['close_2']
				);
			}
			if($value['open_3'] != $value['close_3']) {
				$hours[] = array(
					's' => $value['open_3'],
					'e' => $value['close_3']
				);
			}
		}
		$dataShop['business_hours'] = iserializer($hours);

		pdo_insert('tiny_wmall_store', $dataShop);
		$new_store_id = pdo_insertid();
		$old2new['store'][$value['store_id']] = $new_store_id;
		//商家账户
		$config_settle = $_W['we7_wmall']['config']['settle'];
		$store_account = array(
			'uniacid' => $uniacid,
			'agentid' => $dataShop['agentid'],
			'sid' => $new_store_id,
			'fee_limit' => $config_settle['get_cash_fee_limit'],
			'fee_rate' => $config_settle['get_cash_fee_rate'],
			'fee_min' => $config_settle['get_cash_fee_min'],
			'fee_max' => $config_settle['get_cash_fee_max'],
		);
		pdo_insert('tiny_wmall_store_account', $store_account);
	}
	echo '商户OK';


	$staffs = pdo_getall('pigcms_merchant_store_staff');
	foreach($staffs as $val) {
		$update = array(
			'uniacid' => $uniacid,
			//'agentid' => $areas[$val['area_id']]['agentid'],//没有对应area_id
			'title' => $val['name'],
			'openid' => $val['openid'],
			'mobile' => $val['tel'],
			'token' => random(32),
			'salt' => random(6),
			'status' => 1,
			'addtime' => $val['last_time'],
		);
		$update['password'] = md5(md5($update['salt'] . '888888') . $update['salt']);
		pdo_insert('tiny_wmall_clerk', $update);
		$clerk_id = pdo_insertid();
		$store_clerk = array(
			'uniacid' => $uniacid,
			'sid' => $old2new['store'][$val['store_id']],
			'clerk_id' => $clerk_id,
			'role' => $val['type'] == 2 ? 'manager' : 'clerk',
			'extra' => iserializer(array(
				'accept_wechat_notice' => 1,
				'accept_voice_notice' => 1
			)),
		);
		pdo_insert('tiny_wmall_store_clerk', $store_clerk);
	}
	echo '店员OK';

	$deliveryers = pdo_getall('pigcms_deliver_user');
	foreach($deliveryers as $val) {
		$update = array(
			'uniacid' => $uniacid,
			'agentid' => $areas[$val['area_id']]['agentid'],
			'title' => $val['name'],
			'openid' => $val['openid'],
			'mobile' => $val['phone'],
			'token' => random(32),
			'salt' => random(6),
			'work_status' => $val['status'],
			'addtime' => $val['create_time'],
			'location_x' => $val['now_lat'],
			'location_y' => $val['now_lng'],
			'is_takeout' => 1,
			'is_errander' => 1,
		);
		$update['password'] = md5(md5($update['salt'] . '888888') . $update['salt']);
		pdo_insert('tiny_wmall_deliveryer', $update);
		$deliveryer_id = pdo_insertid();
		if($val['store_id'] > 0 && $val['group'] == 2) {
			$store_deliveryer = array(
				'uniacid' => $uniacid,
				'agentid' => $areas[$val['area_id']]['agentid'],
				'sid' => $old2new['store'][$val['store_id']],
				'deliveryer_id' => $deliveryer_id,
				'addtime' => $val['create_time'],
			);
			pdo_insert('tiny_wmall_store_deliveryer', $store_deliveryer);
		}
	}
	echo '配送员OK';

	$goodsCategory = pdo_fetchall('select * from ' . tablename('pigcms_shop_goods_sort') . ' order by fid asc');
	foreach ($goodsCategory as $value) {
		$dataGoodsCategory = array(
			'uniacid' => $uniacid,
			'title' => trim($value['sort_name']),
			'sid' => $old2new['store'][$value['store_id']],
			'displayorder' => $value['sort'],
			'week' => trim($value['week']),
			'is_showtime' => $value['is_weekshow'],
			'status' => 1,
		);
		if($dataGoodsCategory['is_showtime']) {
			$dataGoodsCategory['start_time'] = '00:00';
			$dataGoodsCategory['end_time'] = '23:59';
		}

		if(!empty($value['fid'])) {
			$dataGoodsCategory['parentid'] = $old2new['goods_category'][$value['fid']]['cid'];
		}
		pdo_insert('tiny_wmall_goods_category', $dataGoodsCategory);
		$new_goods_category_id = pdo_insertid();
		$old2new['goods_category'][$value['sort_id']] = array(
			'cid' => $new_goods_category_id,
			'parentid' => $value['fid'] > 0 ? $old2new['goods_category'][$value['fid']]['cid'] : 0
		);
	}
	icache_write('pigcms_store_category', $old2new['store_category']);
	icache_write('pigcms_store', $old2new['store']);
	icache_write('pigcms_goods_category', $old2new['goods_category']);
	unset($old2new);
	imessage('商家信息导入成功，即将导入商品数据', iurl('system/test/goods'), 'success');
}
elseif($op == 'goods') {
	$old2new_store = icache_read('pigcms_store');
	$old2new_goods_category = icache_read('pigcms_goods_category');
	$page = $_GPC['page'] ? $_GPC['page'] : 1;
	$psize = 300;
	$condition = ' where 1';
	$limit = ' order by goods_id desc limit ' . ($page - 1) * $psize . ',' . $psize;

	$goods = pdo_fetchall('select * from ' . tablename('pigcms_shop_goods') . $condition . $limit);
	foreach ($goods as $value) {
		$dataGoods = array(
			'uniacid' => $uniacid,
			'sid' => $old2new_store[$value['store_id']],
			'title' => trim($value['name']),
			'number' => $value['number'],
			'price' => $value['price'],
			'old_price' => $value['old_price'],
			'unitname' => trim($value['unit']),
			'total' => intval($value['stock_num']),
			'status' => intval($value['status']),
			//'thumb' => trim($value['image']),
			'displayorder' => intval($value['sort']),
			'description' => trim($value['des']),
			'sailed' => intval($value['sell_count']),
			'comment_total' => $value['reply_count'],
			'box_price' => $value['packing_charge'],
			'is_options' => empty($value['spec_value']) ? 0 : 1,
			'attrs' => '',
		);
		if(!empty($value['image'])) {
			$value['image'] = trim($value['image']);
			$value['image'] = str_replace('，', ',', $value['image']);
			$value['image'] = str_replace(',', '/s_', $value['image']);
			$dataGoods['thumb'] = '/goods/' . $value['image'];
		}
		if($value['is_properties']) {
			$attrs = pdo_getall('pigcms_shop_goods_properties', array('goods_id' => $value['goods_id']), array('name', 'val'));
			foreach($attrs as $val) {
				if(empty($val)) {
					continue;
				}
				$val['val'] = str_replace(':1', '', $val['val']);
				$val['val'] = str_replace(':0', '', $val['val']);
				$val['val'] = array_filter(explode(',', $val['val']), trim);
				$attrs_new[] = array(
					'name' => $val['name'],
					'label' => $val['val']
				);
			}
			if(!empty($attrs_new)) {
				$dataGoods['attrs'] = iserializer($attrs_new);
			}
			unset($attrs_new);
		}
		if($old2new_goods_category[$value['sort_id']]['parentid'] > 0) {
			$dataGoods['cid'] = $old2new_goods_category[$value['sort_id']]['parentid'];
			$dataGoods['child_id'] = $old2new_goods_category[$value['sort_id']]['cid'];
		} else {
			$dataGoods['cid'] = $old2new_goods_category[$value['sort_id']]['cid'];
			$dataGoods['child_id'] = 0;
		}
		pdo_insert('tiny_wmall_goods', $dataGoods);
		$goodsId = pdo_insertid();
		if(!empty($value['spec_value'])) {
			$value['spec_value'] = explode('#', $value['spec_value']);
			foreach($value['spec_value'] as $item) {
				$item = explode('|', $item);
				$optionids = explode(':', $item[0]);
				$options = explode(':', $item[1]);
				$option_update = array(
					'uniacid' => $uniacid,
					'sid' => $dataGoods['sid'],
					'goods_id' => $goodsId,
					'name' => '',
					'total' => $options[3],
					'price' => $options[1]
				);
				foreach($optionids as $optionid) {
					$pigcms_option = pdo_get('pigcms_shop_goods_spec_value', array('id' => $optionid), array('name'));
					$option_update['name'] = trim($pigcms_option['name']);
					if(empty($option_update['name'])) {
						continue;
					}
					$is_exist = pdo_get('tiny_wmall_goods_options', array('uniacid' => $uniacid, 'sid' => $dataGoods['sid'], 'goods_id' => $goodsId, 'name' => $option_update['name']), array('id'));
					if($is_exist) {
						continue;
					}
					pdo_insert('tiny_wmall_goods_options', $option_update);
				}
			}
			unset($value['spec_value']);
		}
	}
	unset($old2new_store);
	unset($old2new_goods_category);
	if(count($goods) == 300) {
		$page++;
		imessage('正在导入第'.($page-1).'页商品数据', iurl('system/test/goods', array('page' => $page)), 'success');
	} else {
		imessage('商品导入成功', iurl('merchant/store/list'), 'success');
	}
}