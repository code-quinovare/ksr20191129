<?php
defined('IN_IA') || exit('Access Denied');
function cron_order() 
{
	global $_W;
	$_W['role'] = 'system';
	$_W['role_cn'] = '系统';
	$key = 'we7_wmall:' . $_W['uniacid'] . ':task:lock:30';
	if (!(check_cache_status($key, 30)) && 0) 
	{
		$orders_no_print = pdo_fetchall('select id from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and print_status = 0 and addtime > :addtime order by id asc limit 10', array(':uniacid' => $_W['uniacid'], ':addtime' => TIMESTAMP - 3600));
		if (!(empty($orders_no_print))) 
		{
			foreach ($orders_no_print as $order ) 
			{
				order_print($order['id']);
			}
		}
	}
	$key = 'we7_wmall:' . $_W['uniacid'] . ':task:lock:60';
	if (!(check_cache_status($key, 60))) 
	{
		$config_takeout = $_W['we7_wmall']['config']['takeout']['order'];
		if (0 < $config_takeout['pay_time_limit']) 
		{
			$orders = pdo_fetchall('select id, sid, addtime from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and is_pay = 0 and status = 1 and order_type <= 2 and addtime <= :addtime limit 5', array(':uniacid' => $_W['uniacid'], ':addtime' => time() - ($config_takeout['pay_time_limit'] * 60)));
			if (!(empty($orders))) 
			{
				$extra = array('reason' => 'over_paylimit', 'note' => '提交订单' . $config_takeout['pay_time_limit'] . '分钟内未支付,系统已自动取消订单');
				foreach ($orders as $order ) 
				{
					order_status_update($order['id'], 'cancel', $extra);
				}
			}
		}
		if (0 < $config_takeout['pay_time_notice']) 
		{
			$orders = pdo_fetchall('select id, sid, addtime from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and is_pay = 0 and status = 1 and order_type <= 2 and addtime <= :addtime limit 5', array(':uniacid' => $_W['uniacid'], ':addtime' => time() - ($config_takeout['pay_time_notice'] * 60)));
			if (!(empty($orders))) 
			{
				$extra = array('reason' => 'over_paynotice', 'note' => '提交订单' . $config_takeout['pay_time_notice'] . '分钟内未支付,请尽快支付');
				foreach ($orders as $order ) 
				{
					order_status_update($order['id'], 'pay_notice', $extra);
				}
			}
		}
		if (0 < $config_takeout['handle_time_limit']) 
		{
			$orders = pdo_fetchall('select id, sid, addtime from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and is_pay = 1 and status = 1 and order_type <= 2 and paytime <= :paytime limit 5', array(':uniacid' => $_W['uniacid'], ':paytime' => time() - ($config_takeout['handle_time_limit'] * 60)));
			if (!(empty($orders))) 
			{
				$extra = array('note' => $config_takeout['handle_time_limit'] . '分钟内商户未接单,系统已自动取消订单', 'reason' => 'others', 'remark' => $config_takeout['handle_time_limit'] . '分钟内商户未接单,系统已自动取消订单');
				foreach ($orders as $order ) 
				{
					order_status_update($order['id'], 'cancel', $extra);
				}
			}
		}
		if (0 < $config_takeout['deliveryer_collect_time_limit']) 
		{
			$orders = pdo_fetchall('select id, sid, deliveryer_id, addtime from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and is_pay = 1 and status = 3 and order_type = 1 and deliveryer_id = 0 and delivery_type > 0 and handletime <= :handletime limit 5', array(':uniacid' => $_W['uniacid'], ':handletime' => time() - ($config_takeout['deliveryer_collect_time_limit'] * 60)));
			if (!(empty($orders))) 
			{
				$extra = array('note' => $config_takeout['deliveryer_collect_time_limit'] . '分钟内配送员未接单,系统已自动取消订单', 'reason' => 'others', 'remark' => $config_takeout['deliveryer_collect_time_limit'] . '分钟内配送员未接单,系统已自动取消订单');
				foreach ($orders as $order ) 
				{
					order_status_update($order['id'], 'cancel', $extra);
				}
			}
		}
		if (0 < $config_takeout['auto_success_hours']) 
		{
			$orders = pdo_fetchall('select id, sid, handletime from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and status >= 2 and status < 5 and order_type <= 2 and handletime > 0 and handletime < :handletime order by id asc limit 5', array(':uniacid' => $_W['uniacid'], ':handletime' => time() - ($config_takeout['auto_success_hours'] * 3600)));
			if (!(empty($orders))) 
			{
				$extra = array('note' => '系统已自动完成订单');
				foreach ($orders as $order ) 
				{
					order_status_update($order['id'], 'end', $extra);
				}
			}
		}
		if (0 < $config_takeout['tangshi_auto_success_hours']) 
		{
			$orders = pdo_fetchall('select id, sid, handletime from ' . tablename('tiny_wmall_order') . ' where uniacid = :uniacid and status >= 2 and status < 5 and order_type = 3 and handletime > 0 and handletime < :handletime order by id asc limit 5', array(':uniacid' => $_W['uniacid'], ':handletime' => time() - ($config_takeout['tangshi_auto_success_hours'] * 3600)));
			if (!(empty($orders))) 
			{
				$extra = array('note' => '系统已自动完成订单');
				foreach ($orders as $order ) 
				{
					order_status_update($order['id'], 'end', $extra);
				}
			}
		}
		if (!(empty($config_takeout['notify_rule_clerk'])) && !(empty($config_takeout['notify_rule_clerk']['notify_frequency'])) && (0 < $config_takeout['notify_rule_clerk']['notify_total'])) 
		{
			$condition = ' where  uniacid = :uniacid and status = 1 and is_pay = 1 and order_type <= 2 and paytime > :paytime';
			$params = array(':uniacid' => $_W['uniacid'], ':paytime' => TIMESTAMP - (86400 * 3));
			$condition_delay = ' notify_clerk_total = 0';
			if (!(empty($config_takeout['notify_rule_clerk']['notify_delay']))) 
			{
				$condition_delay .= ' and paytime < :paytime';
				$params[':paytime'] = TIMESTAMP - ($config_takeout['notify_rule_clerk']['notify_delay'] * 60);
			}
			$condition_frequency = ' notify_clerk_total > 0';
			if (!(empty($config_takeout['notify_rule_clerk']['notify_total']))) 
			{
				$condition_frequency .= ' and notify_clerk_total < :notify_clerk_total';
				$params[':notify_clerk_total'] = $config_takeout['notify_rule_clerk']['notify_total'];
			}
			$notify_frequency = intval($config_takeout['notify_rule_clerk']['notify_frequency']);
			if ($notify_frequency < 1) 
			{
				$notify_frequency = 1;
			}
			$condition_frequency .= ' and last_notify_clerk_time <=  :last_notify_clerk_time';
			$params[':last_notify_clerk_time'] = TIMESTAMP - ($notify_frequency * 60);
			$orders = pdo_fetchall('select id,last_notify_clerk_time from' . tablename('tiny_wmall_order') . ' ' . $condition . ' and ((' . $condition_delay . ') or (' . $condition_frequency . ')) order by id asc limit 5', $params);
			if (!(empty($orders))) 
			{
				foreach ($orders as $order ) 
				{
					order_clerk_notice($order['id'], 'place_order');
				}
			}
		}
		if (($config_takeout['dispatch_mode'] == 1) && !(empty($config_takeout['notify_rule_deliveryer'])) && !(empty($config_takeout['notify_rule_deliveryer']['notify_frequency'])) && (0 < $config_takeout['notify_rule_deliveryer']['notify_total'])) 
		{
			$condition = ' where  uniacid = :uniacid and status = 3 and is_pay = 1 and order_type <= 2 and paytime > :paytime';
			$params = array(':uniacid' => $_W['uniacid'], ':paytime' => TIMESTAMP - (86400 * 3));
			$condition_delay = ' notify_deliveryer_total = 0';
			if (!(empty($config_takeout['notify_rule_deliveryer']['notify_delay']))) 
			{
				$condition_delay .= ' and clerk_notify_collect_time < :clerk_notify_collect_time';
				$params[':clerk_notify_collect_time'] = TIMESTAMP - ($config_takeout['notify_rule_clerk']['notify_delay'] * 60);
			}
			$condition_frequency = ' notify_deliveryer_total > 0';
			if (!(empty($config_takeout['notify_rule_deliveryer']['notify_total']))) 
			{
				$condition_frequency .= ' and notify_deliveryer_total < :notify_deliveryer_total';
				$params[':notify_deliveryer_total'] = $config_takeout['notify_rule_deliveryer']['notify_total'];
			}
			$notify_frequency = intval($config_takeout['notify_rule_deliveryer']['notify_frequency']);
			if ($notify_frequency < 1) 
			{
				$notify_frequency = 1;
			}
			$condition_frequency .= ' and last_notify_deliveryer_time <=  :last_notify_deliveryer_time';
			$params[':last_notify_deliveryer_time'] = TIMESTAMP - ($notify_frequency * 60);
			$orders = pdo_fetchall('select id,last_notify_deliveryer_time from' . tablename('tiny_wmall_order') . ' ' . $condition . ' and ((' . $condition_delay . ') or (' . $condition_frequency . ')) order by id asc limit 5', $params);
			if (!(empty($orders))) 
			{
				foreach ($orders as $order ) 
				{
					order_deliveryer_notice($order['id'], 'delivery_wait');
				}
			}
		}
		if (check_plugin_perm('errander')) 
		{
			$url = imurl('errander/cron', array(), true);
			load()->func('communication');
			$data = ihttp_request($url, '', array(), 300);
		}
		set_cache($key, array());
	}
	$key = 'we7_wmall:' . $_W['uniacid'] . ':task:lock:300';
	if (!(check_cache_status($key, 300))) 
	{
		store_business_hours_init();
		mload()->model('activity');
		activity_cron();
		mload()->model('redPacket');
		redPacket_cron();
		mload()->model('coupon');
		coupon_cron();
		mload()->model('plugin');
		if (check_plugin_perm('superRedpacket')) 
		{
			pload()->model('superRedpacket');
			superRedpacket_cron();
		}
		$plugins = plugin_fetchall();
		$perms = get_account_perm();
		if (!(empty($plugins))) 
		{
			load()->func('communication');
			$plugins = array( array('name' => 'errander') );
			foreach ($plugins as $plugin ) 
			{
				if (empty($perms) || in_array($plugin['name'], $perms['plugins'])) 
				{
					$url = imurl($plugin['name'] . '/cron', array(), true);
					$data = ihttp_request($url, '', array(), 300);
				}
			}
		}
		set_cache($key, array());
	}
	$key = 'we7_wmall:' . $_W['uniacid'] . ':task:lock:3600';
	if (!(check_cache_status($key, 3600))) 
	{
		store_stat_init('delivery_time', 0);
		mload()->model('plugin');
		if (check_plugin_perm('advertise')) 
		{
			pload()->model('advertise');
			advertise_cron();
		}
		$time = TIMESTAMP - 7776000;
		pdo_query('delete from ' . tablename('tiny_wmall_member_footmark') . ' where uniacid = :uniacid and addtime < :time', array(':uniacid' => $_W['uniacid'], ':time' => $time));
		$time = TIMESTAMP - 604800;
		pdo_query('delete from ' . tablename('tiny_wmall_order_cart') . ' where uniacid = :uniacid and addtime < :time', array(':uniacid' => $_W['uniacid'], ':time' => $time));
		$time = TIMESTAMP - 86400;
		if (pdo_tableexists('tiny_wmall_deliveryer_location_log')) 
		{
			pdo_query('delete from ' . tablename('tiny_wmall_deliveryer_location_log') . ' where addtime < :time', array(':time' => $time));
		}
		$config_settle = $_W['we7_wmall']['config']['store']['settle'];
		if (0 < $config_settle['store_label_new']) 
		{
			mload()->model('build');
			build_category('TY_store_label');
			$new = pdo_get('tiny_wmall_category', array('uniacid' => $_W['uniacid'], 'type' => 'TY_store_label', 'alias' => 'new'));
			if (!(empty($new))) 
			{
				$params = array(':uniacid' => $_W['uniacid'], ':label' => $new['id'], ':addtime' => time() - ($config_settle['store_label_new'] * 86400));
				$data = pdo_query('update ' . tablename('tiny_wmall_store') . ' set label = :label where uniacid = :uniacid and label = 0 and addtime > :addtime', $params);
				pdo_query('update ' . tablename('tiny_wmall_store') . ' set label = 0 where uniacid = :uniacid and label = :label and addtime < :addtime', $params);
			}
		}
		set_cache($key, array());
	}
	if (defined('IN_SYS')) 
	{
		$key = 'we7_wmall:0:task:lock:7200';
		if (!(check_cache_status($key, 7200))) 
		{
			mload()->model('cloud');
			cloud_w_plugin_auth();
			set_cache($key, array());
		}
	}
	return true;
}
?>