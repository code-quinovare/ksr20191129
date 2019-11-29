<?php
//		checkauth();
		$subject = !empty($setting['subject']) ? $setting['subject'] : "主题列表";
		$activity=$this->get_yuyuepay($reid);
		$par = iunserializer($activity['par']);
		$main_url = $par['member']==0 ? $this->createMobileUrl('index') : $this->createMobileUrl('dayu_yuyuepay',array('id' => $reid));
		$index_url = !empty($activity['store']) && pdo_tableexists('dayu_yuyuepay_plugin_store_store') && $setting['store'] ? murl('entry', array('do' => 'store', 'm' => 'dayu_yuyuepay_plugin_store'), true, true) : $main_url;
		
		$par = iunserializer($activity['par']);
		
		$where = 'openid = :openid and reid = :reid';
        $params = array();
        $params[':reid'] = $reid;
        $params[':openid'] = $openid;
		if ($_GPC['status']!='') {
			if ($_GPC['status'] == 2) {
				$where.=" and (status='2' or status='9')";
			} else {
				$where.=" and status=$_GPC[status]";
			}
		}
		$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tb_info) . " WHERE $where ", $params);
		
        $title = !empty($activity['title']) ? $activity['title'] : '预约';
		$sub_title = '我的预约';
		$menushow=1;
        include $this->template('member/dayu_yuyuepay');
?>