<?php

	    global $_W  ,$_GPC;
		checklogin();
		if(!pdo_fieldexists('n1ce_red_pici', 'time_limit')) {
			pdo_query("ALTER TABLE ".tablename('n1ce_red_pici')." ADD `time_limit` int(1) NOT NULL DEFAULT '0';");
		}
		if(!pdo_fieldexists('n1ce_red_pici', 'starttime')) {
			pdo_query("ALTER TABLE ".tablename('n1ce_red_pici')." ADD `starttime` int(10) DEFAULT '0';");
		}
		if(!pdo_fieldexists('n1ce_red_pici', 'endtime')) {
			pdo_query("ALTER TABLE ".tablename('n1ce_red_pici')." ADD `endtime` int(10) DEFAULT '0';");
		}
		if(!pdo_fieldexists('n1ce_red_pici', 'miss_start')) {
			pdo_query("ALTER TABLE ".tablename('n1ce_red_pici')." ADD `miss_start` varchar(200) DEFAULT NULL;");
		}
		if(!pdo_fieldexists('n1ce_red_pici', 'miss_end')) {
			pdo_query("ALTER TABLE ".tablename('n1ce_red_pici')." ADD `miss_end` varchar(200) DEFAULT NULL;");
		}
		$pici = $_GPC['pici'];
		$timeinfo = pdo_fetch('select * from ' . tablename('n1ce_red_pici') . ' where uniacid = :uniacid and pici = :pici', array(':uniacid' => $_W['uniacid'],':pici' => $pici));
		if(empty($timeinfo['starttime'])){
			$now = TIMESTAMP;
            $timeinfo['starttime'] = $now;
            $timeinfo['endtime'] = strtotime(date("Y-m-d H:i", $now + 7 * 24 * 3600));
		}
		if(checksubmit()){
			$data = array(
				'pici' => $_GPC['pici'],
				'time_limit' => $_GPC['time_limit'],
				'starttime' => strtotime($_GPC['datelimit']['start']),
				'endtime' => strtotime($_GPC['datelimit']['end']),
				'miss_start' => $_GPC['miss_start'],
				'miss_end' => $_GPC['miss_end'],
			);
			//var_dump($data);die();
			pdo_update('n1ce_red_pici',$data,array('pici'=>$_GPC['pici'],'uniacid'=>$_W['uniacid']));
			message('操作成功！',$this->createWebUrl('code'),'success');
		}
		load()->func('tpl');
		include $this->template('codetime');