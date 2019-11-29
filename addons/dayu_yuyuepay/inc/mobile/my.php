<?php
		$returnUrl = urlencode($_W['siteurl']);
		$profile = mc_fetch($_W['member']['uid']);
		include MODULE_ROOT."/model/activity.mod.php";
//		print_r($yuyueid);
		
		load()->model('activity');
		$coupon = we7_coupon_activity_coupon_owned();
		$coupon = count($coupon);
		$filter = array();
		$coupons = activity_coupon_owned($uid, $filter);
		$tokens = activity_token_owned($uid, $filter);
		$uni_setting = uni_setting($_W['uniacid'], array('creditnames', 'creditbehaviors', 'uc', 'payment', 'passport'));
		$behavior = $uni_setting['creditbehaviors'];
		$creditnames = $uni_setting['creditnames'];
		$credits = mc_credit_fetch($_W['member']['uid'], '*');
		$sql = 'SELECT `num` FROM ' . tablename('mc_credits_record') . " WHERE `uid` = :uid";
		$params = array(':uid' => $uid);
		$nums = pdo_fetchall($sql, $params);
		$pay = $income = 0;
		foreach ($nums as $value) {
			if ($value['num'] > 0) {
			$income += $value['num'];
			} else {
			$pay += abs($value['num']);
			}
		}
		$pay = number_format($pay, 2);
		$countyy = $this->get_yuyue('',3);
//		$card = pdo_get('mc_card_members', array('uniacid' => $weid, 'openid' => $openid, 'uid' => $uid), array());
//		if($setting['card'] == 1 && $card['status']!=1 && !$isstaff) $this->showMessage("请注册成为会员", murl('entry', array('do' => 'index', 'm' => 'dayu_card', 'returnurl' => $returnUrl), true, true), 'info');

		$address = pdo_fetch("SELECT * FROM " . tablename('mc_member_address') . " WHERE isdefault = 1 and uid = :uid limit 1", array(':uid' => $_W['fans']['uid']));
		$pay_url = $setting['pay']=='1' ? murl('entry', array('do' => 'index', 'm' => 'dayu_card_plugin_deposit'), true, true) : url('entry', array('m' => 'recharge', 'do' => 'pay'));

		$sub_title="个人中心";
		$footer=1;
        include $this->template('member/my');
?>