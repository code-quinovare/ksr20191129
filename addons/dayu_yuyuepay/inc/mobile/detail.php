<?php
		$paytime = !empty($setting['paytime']) ? $setting['paytime'] : 30;
//		$uni_setting = uni_setting($_W['uniacid'], array('payment', 'recharge'));
//		$pay = $uni_setting['payment'];
//		if(!is_array($pay)) {
//			$pay = array();
//		}
//		$line = htmlspecialchars_decode($pay['line']['message']);
        $id = intval($_GPC['id']);
        $reid = intval($_GPC['reid']);
		$row = pdo_fetch("SELECT * FROM ".tablename($this->tb_info)." WHERE openid = :openid AND rerid = :rerid", array(':openid' => $openid, ':rerid' => $id));
		if (empty($row)) {
			$this->showMessage('订单不存在或是已经被删除或该订单不归您所有！');
		}
		$activity=$this->get_yuyuepay($row['reid']);
		$par = iunserializer($activity['par']);
		if (pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($row['sid']) && !empty($activity['store'])){
			$store = pdo_get('dayu_yuyuepay_plugin_store_store', array('weid' => $weid, 'id' => $row['sid']), array());
			$store['score_num'] = $store['score_num'] == 0 ? 5 : round(($store['total_score']/$store['score_num']),0);
		}
		if(pdo_tableexists('dayu_yuyuepay_plugin_car')) {			
			$car_info = module_fetch('dayu_yuyuepay_plugin_car');
			$carid = pdo_get('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $id), array());
			if($carid) {
				$allcar = pdo_fetchall("SELECT * FROM ".tablename('dayu_yuyuepay_plugin_car')." WHERE `id` IN ({$carid['carid']})");
			}
//			print_r($car_info['config']['url']);
//			$car = pdo_get('dayu_yuyuepay_plugin_car', array('id' => $row['p_carid']), array());
		}
//		$row['createtimes'] = !empty($row['createtime']) ? date('Y-m-d H:i', $row['createtime']) : '时间丢失';
//		$row['yuyuetime'] = !empty($row['yuyuetime']) ? date('Y-m-d H:i', $row['yuyuetime']) : '客服尚未受理本订单';
		$yuyuetime = $activity['is_time']==2 ? $row['restime'] : date('Y-m-d H:i', $row['yuyuetime']);
		$row['thumb']   = iunserializer($row['thumb']);
		$row['outtime'] = $row['createtime'] + $paytime*60;
		$offline=$row['paytype'];
		$paytype = array (
			'0' => array('css' => 'default', 'name' => '未支付'),
			'1' => array('css' => 'green','name' => '在线支付'),
			'2' => array('css' => 'blue', 'name' => '余额支付'),
			'3' => array('css' => 'black ', 'name' => '其他付款方式'),
			'4' => array('css' => 'orange', 'name' => '免费预约'),
			'9' => array('css' => 'primary', 'name' => '线下付款')
		);
		$row['css'] = $paytype[$row['paytype']]['css'];
		if ($row['paytype'] == 1) {
			if (empty($row['transid'])) {
				if ($row['paystatus'] == 1) {
					$row['paytypes'] = '';
				} else {
					$row['paytypes'] = '支付宝支付';
				}
			} else {
				$row['paytypes'] = '微信支付';
			}
		} else {
			$row['paytypes'] = $paytype[$row['paytype']]['name'];
		}
		
		$tb_record = pdo_fetchall("select * from ".tablename($this->tb_record)." where rerid=:rerid ORDER BY createtime DESC, id", array(':rerid'=>$row['rerid']));
		if(is_array($tb_record)){
			foreach($tb_record AS $key => $val){
				$tb_record[$key]['createtime'] = date("Y-m-d H:i:s", $val['createtime']);
				$tb_record[$key]['first'] = $key=='0' ? '-first' : '';
				$tb_record[$key]['hide'] = $key!='0' ? 'hide' : '';
				$tb_record[$key]['recent'] = $key=='0' ? 'recent dayu-blue' : 'dayu-gray';
				$tb_record[$key]['status'] = $this->get_status($reid,$val['status']);
				if($key == count($tb_record)-1){
					$tb_record[$key]['ad'] = '23';
				}
				$tb_record[$key]['thumb'] = !empty($val['thumb']) ? iunserializer($val['thumb']) : '';
			}
		}
		$qrcode = $_W['siteroot'].'app/'.$this->createMobileUrl('manage_detail', array('reid' => $row['reid'], 'id' => $row['rerid']));
		$qrcodesrc = tomedia('headimg_'.$_W['acid'].'.jpg');
//		$index_url = !empty($activity['store']) && pdo_tableexists('dayu_yuyuepay_plugin_store_store') ? murl('entry', array('do' => 'store', 'm' => 'dayu_yuyuepay_plugin_store'), true, true) : $this->createMobileUrl('dayu_yuyuepay',array('id' => $row['reid']));
		
//		$activity['fields'] = pdo_fetchall("SELECT a.title, a.type, b.data FROM " . tablename($this->tb_field) . " AS a LEFT JOIN " . tablename($this->tb_data) . " AS b ON a.refid = b.refid WHERE a.reid = :reid AND b.rerid = :rerid", array(':reid' => $row['reid'], ':rerid' => $id));

		$sql = 'SELECT * FROM ' . tablename($this->tb_field) . ' WHERE `reid`=:reid ORDER BY displayorder DESC, refid';
        $params = array();
        $params[':reid'] = $row['reid'];
        $fields = pdo_fetchall($sql, $params);
        if (empty($fields)) {
            $this->showMessage('非法访问.');
        }
        $ds = array();
        foreach ($fields as $f) {
            $ds[$f['refid']]['fid'] = $f['title'];
            $ds[$f['refid']]['type'] = $f['type'];
            $ds[$f['refid']]['refid'] = $f['refid'];
            $fids[] = $f['refid'];
        }

        $row['fields'] = array();
        $sql = 'SELECT * FROM ' . tablename($this->tb_data) . " WHERE `reid`=:reid AND `rerid`='{$row['rerid']}'";
        $fdatas = pdo_fetchall($sql, $params);

        foreach ($fdatas as $fd) {
            $row['fields'][$fd['refid']] = $fd['data'];
        }
		
		$xiangmu = $this->get_xiangmu($row['reid'],$row['xmid']);
		$status = $this->get_status($row['reid'],$row['status']);
		
		if ($_W['ispost']) {
			$record = array();
			$record['status'] = $_GPC['status'];
			pdo_update($this->tb_info, $record,array('rerid' => $id));
			$this->showMessage('取消订单成功',referer(),'success');
		}
		$title=$activity['title'];
//		$footer_off = $par['member']==1 ? 1:0;
        include $this->template('member/detail');
?>