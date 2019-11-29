<?php
        $id = intval($_GPC['id']);
        $reid = intval($_GPC['reid']);
		$activity=$this->get_yuyuepay($reid);
//			if($openid != $activity['kfid']){
//				$this->showMessage('非法访问！你不是管理员。');
//			}
		$isstaff = pdo_get($this->tb_staff, array('weid' => $weid, 'reid' => $reid, 'openid' => $openid), array('id'));
		$row = pdo_fetch("SELECT * FROM ".tablename($this->tb_info)." WHERE rerid = :rerid", array(':rerid' => $id));
		if (empty($row)) {
			$this->showMessage('记录不存在或是已经被删除！');
		}
		$par = iunserializer($activity['par']);
		$status = $this->get_status($row['reid'],$row['status']);
		
		$state = array();
		$arr2=array('0','1','2','3','8');
		foreach ($arr2 as $index => $v) {
				$state[$v][] = $this->get_status($reid,$v);
		}
		
		if($setting['store']==1 && pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($row['sid'])){
			$store = $this->get_store($row['sid']);
		}
		if ($openid == $activity['kfid'] || $openid == $row['kf'] || $openid==$store['openid'] || ($activity['guanli']=='1' && $isstaff)) {
			//防止重复提交
			$repeat = $_COOKIE['r_submit'];
			if(!empty($_GPC['repeat'])){
				if(!empty($repeat)){
					if($repeat==$_GPC['repeat']){
						$this->showMessage($activity['information'], $this->createMobileUrl('mydayu_yuyuepay', array('id' => $reid)));
					}else{
						setcookie("r_submit",$_GPC['repeat']);
					}
				}else{
					setcookie("r_submit",$_GPC['repeat']);
				}
			}
			$staff = pdo_fetchall("SELECT * FROM ".tablename($this->tb_staff)." WHERE reid = :reid ORDER BY `id` DESC", array(':reid' => $reid));
			$face = mc_fansinfo($row['openid'],$acid, $weid);
			$yuyuetime = $activity['is_time']==2 ? $row['restime'] : date('Y-m-d H:i', $row['yuyuetime']);
			$row['thumb']   = iunserializer($row['thumb']);
			$xiangmu = $this->get_xiangmu($row['reid'],$row['xmid']);
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
		if(pdo_tableexists('dayu_yuyuepay_plugin_car')) {
			$car_info = module_fetch('dayu_yuyuepay_plugin_car');
			$carid = pdo_get('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $id), array());
			if($carid) {
				$allcar = pdo_fetchall("SELECT * FROM ".tablename('dayu_yuyuepay_plugin_car')." WHERE `id` IN ({$carid['carid']})");
			}
			
			$car = pdo_fetchall("SELECT * FROM " . tablename('dayu_yuyuepay_plugin_car') . " WHERE weid = :weid ORDER BY id DESC", array(':weid' => $weid), 'id');
			foreach($car AS $key => $val){
				$car[$key]['id'] = $val['id'];
				$car[$key]['title'] = $val['name'].' '.$val['mobile'];
			}
			$caryyid = pdo_get('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $id), array());
			if (!empty($caryyid['carid'])) {
				$carids = explode(',', $caryyid['carid']);
			}
		}
		
			$sql = 'SELECT * FROM ' . tablename($this->tb_field) . ' WHERE `reid`=:reid ORDER BY displayorder DESC, refid DESC';
			$params = array();
			$params[':reid'] = $row['reid'];
			$fields = pdo_fetchall($sql, $params);
			if (empty($fields)) {
				$this->showMessage('非法访问.');
			}
			$ds = $fids = array();
			foreach ($fields as $f) {
				$ds[$f['refid']]['fid'] = $f['title'];
				$ds[$f['refid']]['type'] = $f['type'];
				$ds[$f['refid']]['refid'] = $f['refid'];
				$fids[] = $f['refid'];
			}

			$fids = implode(',', $fids);
			$row['fields'] = array();
			$sql = 'SELECT * FROM ' . tablename($this->tb_data) . " WHERE `reid`=:reid AND `rerid`='{$row['rerid']}' AND `refid` IN ({$fids})";
			$fdatas = pdo_fetchall($sql, $params);

			foreach ($fdatas as $fd) {
				$row['fields'][$fd['refid']] = $fd['data'];
			}
		
			
			if ($_W['ispost']){
				$record = array();
				$record['status'] = $_GPC['status'];	
				$record['kfinfo'] = $_GPC['kfinfo'];
		//		if (!empty($_GPC['paystatus'])) {
		//			$record['paystatus'] = intval($_GPC['paystatus']);
		//		}
				if (is_array($_GPC['thumb'])) {
					foreach ($_GPC['thumb'] as $thumb) {
						$th[] = tomedia($thumb);
					}
					$record['thumb'] = iserializer($th);
				}
				$kfinfo = !empty($_GPC['kfinfo']) ? "\n客服回复：".$_GPC['kfinfo'] : "";
				$status = $this->get_status($row['reid'],$_GPC['status']);
				
				if ($activity['is_time']==0) {
					$times = $row['yuyuetime'];
				}elseif ($activity['is_time']==2) {
					$times = $row['restime'];
				}
			
				$url=$_W['siteroot'] .'app/'.$this->createMobileUrl('detail', array('reid' => $row['reid'], 'id' => $row['rerid']));
				$data = array (
					'first' => array('value' => $par['mfirst']."\n",'color'=>"#743A3A"),
					'keyword1' => array('value' => $row['member']),
					'keyword2' => array('value' => $xiangmu['title']." - ".$xiangmu['price']."元"),
					'keyword3' => array('value' => $times),
					'keyword4' => array('value' => $status['name']),
					'remark' => array('value' => $kfinfo."\n".$activity['mfoot'],'color'=>"#008000")
				);
				
				$check = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tb_record) . " WHERE rerid=:rerid and status=3", array('rerid' => $row['rerid']));
				
				$recorddata = array(
					'rerid' => $row['rerid'],
					'openid' => $openid,
					'thumb' => $record['thumb'],
					'info' => $record['kfinfo'],
					'ostatus' => $row['status'],
					'status' => $record['status'],
					'createtime' => TIMESTAMP			
				);
                if (pdo_insert($this->tb_record, $recorddata) === false) {
                    $this->showMessage('更新失败, 请稍后重试.');
					exit();
                }
		//		pdo_update($this->tb_info, $record,array('rerid' => $id));
                if (pdo_update($this->tb_info, $record,array('rerid' => $id))=== false) {
                   $this->showMessage('更新失败, 请稍后重试.');
                }else{
					if(!empty($par['credit2']) && $check=='0' && $record['status']=='3'){
						load()->model('mc');
						$log = $activity['title'].'-预约核销奖励'.$par['credit2'].'积分';
						mc_credit_update(mc_openid2uid($row['openid']), 'credit1', $par['credit2'], array(0, $log));
						mc_notice_credit1($row['openid'], mc_openid2uid($row['openid']), $par['credit2'], $log);
					}
					if (!empty($activity['m_templateid'])) {
						$acc = WeAccount::create($_W['acid']);
						$acc->sendTplNotice($row['openid'],$activity['m_templateid'],$data,$url,"#FF0000");
					}
					if (!empty($activity['smsid']) && $par['sms']!='0') {
						load()->func('communication');
						$smsdata = array(
							'type' => 'yuyue',
							'addons' => $_W['current_module']['name'],
							'openid' => $row['openid'],
							'mobile' => $activity['mobile'],
							'mname' => $row['member'],
							'mmobile' => $row['mobile'],
							'item' => $xiangmu['title'],
							'time' => $times,
							'status' => $status['name']
						);
						ihttp_post(murl('entry', array('do' => 'Notice', 'id' => $activity['smsid'], 'm' => 'dayu_sms'), true, true), $smsdata);
					}
					
					$store_msg = '';
					if($setting['store']==1 && pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($row['sid']) && $_GPC['status']=='3'){
						$store = $this->get_store($row['sid']);
						$boss = $this->get_store_boss($store['bid']);
						$paylog = pdo_get('dayu_yuyuepay_plugin_store_paylog', array('weid' => $_W['uniacid'], 'sid' => $row['sid'], 'bid' => $store['bid'], 'reid' => $row['reid'], 'yid' => $row['rerid'], 'ordersn' => $info['ordersn']), array());
						if(empty($paylog)){
							$paylogdata = array(
								'weid' => $_W['uniacid'],
								'sid' => $row['sid'],
								'bid' => $store['bid'],
								'reid' => $row['reid'],
								'yid' => $row['rerid'],
								'price' => $row['price'],
								'ordersn' => $info['ordersn'],
								'createtime' => TIMESTAMP
							);
							pdo_insert('dayu_yuyuepay_plugin_store_paylog', $paylogdata);
							pdo_update('dayu_yuyuepay_plugin_store_boss', array('money' => $boss['money'] + $paylogdata['price']), array('id' => $store['bid']));
							$store_msg = '店主余额增加'. $paylogdata['price'].'元，';
						}
					}	
					if($carid && pdo_tableexists('dayu_yuyuepay_plugin_car')) {
						pdo_update('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $row['rerid'],'carid' =>implode(',', $_GPC['p_carid']),'createtime' => TIMESTAMP), array('id' => $carid));
					}else{
						pdo_insert('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $row['rerid'],'carid' => implode(',', $_GPC['p_carid']),'createtime' => TIMESTAMP));
					}		
					if($setting['store']==1 && pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($row['sid'])){
						$this->showMessage('修改成功',$this->createMobileUrl('manage', array('id' => $row['reid'], 'sid' => $row['sid'], 'status' => 0)),'success');
					}else{
						$this->showMessage('修改成功',$this->createMobileUrl('manage', array('id' => $row['reid'], 'status' => 0)),'success');
					}
				}
			}
		}
		$title=$activity['title'];
		$picker=1;
		include $this->template('manage_detail');
?>