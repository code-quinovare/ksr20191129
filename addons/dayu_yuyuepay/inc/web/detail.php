<?php

		load()->func('tpl');
        $rerid = intval($_GPC['id']);
        $info = $this->get_yuyueinfo($rerid);
		$activity=$this->get_yuyuepay($info['reid']);
        $sql = 'SELECT * FROM ' . tablename($this->tb_field) . ' WHERE `reid`=:reid ORDER BY displayorder DESC, refid';
        $params = array();
        $params[':reid'] = $info['reid'];
        $fields = pdo_fetchall($sql, $params);
        if (!$info || !$activity || !$fields) {
            message('访问非法.');
        }
		
		$role=$this->get_isrole($info['reid'],$_W['user']['uid']);
		if ($setting['role']==1 && $_W['role'] == 'operator' && !$role) message('您没有权限进行该操作.');
		
		$par = iunserializer($activity['par']);
		$xm=$this->get_xiangmu($info['reid'],$info['xmid']);		
		$status = $this->get_status($info['reid'],$info['status']);
		$state = array();
		$arr2=array('0','1','2','3','8','7');
		foreach ($arr2 as $index => $v) {
			$state[$v][] = $this->get_status($info['reid'],$v);
		}
			
		$info['yuyuetime'] && $info['yuyuetime'] = date('Y-m-d H:i:s', $info['yuyuetime']);
		$thumb1 = unserialize($info['thumb']);
		$thumb = array();
		if(is_array($thumb1)){
			foreach($thumb1 as $p){
				$thumb[] = is_array($p)?$p['attachment']:$p;
			}
		}

        $info['fields'] = array();
        $sql = 'SELECT * FROM ' . tablename($this->tb_data) . " WHERE `reid`=:reid AND `rerid`='{$info['rerid']}'";
        $fdatas = pdo_fetchall($sql, $params);
		
        $ds = array();
        foreach ($fields as $f) {
            $ds[$f['refid']]['fid'] = $f['title'];
            $ds[$f['refid']]['type'] = $f['type'];
            $ds[$f['refid']]['refid'] = $f['refid'];
        }
        foreach ($fdatas as $fd) {
            $info['fields'][$fd['refid']] = $fd['data'];
        }
        foreach ($ds as $value) {
            if ($value['type'] == 'reside') {
                $info['fields'][$value['refid']] = '';
                foreach ($fdatas as $fdata) {
                    if ($fdata['refid'] == $value['refid']) {
                        $info['fields'][$value['refid']] .= $fdata['data'];
                    }
                }
                break;
            }
        }

		if($setting['store']==1 && pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($info['sid'])){
			$store = $this->get_store($info['sid']);
			$store['score_num'] = $store['score_num'] == 0 ? 5 : round(($store['total_score']/$store['score_num']),0);
		}
		if(pdo_tableexists('dayu_yuyuepay_plugin_car')) {
			$car = pdo_fetchall("SELECT * FROM " . tablename('dayu_yuyuepay_plugin_car') . " WHERE weid = :weid ORDER BY id DESC", array(':weid' => $weid), 'id');
			foreach($car AS $key => $val){
				$car[$key]['id'] = $val['id'];
				$car[$key]['title'] = $val['name'].' '.$val['mobile'];
			}
			$carid = pdo_get('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $rerid), array());
			if (!empty($carid['carid'])) {
				$carids = explode(',', $carid['carid']);
			}
		}
		if ($_W['ispost']){		
			$record = array();
			$record['status'] = $_GPC['status'];
			if (!empty($_GPC['paystatus'])) {
				$record['paystatus'] = intval($_GPC['paystatus']);
			}
			if ($activity['is_time']==0){
				$record['yuyuetime'] = strtotime($_GPC['yuyuetime']);
			}
			$record['kfinfo'] = $_GPC['kfinfo'];
			if (is_array($_GPC['thumb'])) {
				foreach ($_GPC['thumb'] as $thumb) {
					$th[] = tomedia($thumb);
				}
				$record['thumb'] = iserializer($th);
			}else{
				$record['thumb'] = '';
			}
			
			$kfinfo = !empty($_GPC['kfinfo']) ? "\n客服回复：".$_GPC['kfinfo'] : "";
			$status = $this->get_status($info['reid'],$_GPC['status']);
			$getxm = $this->get_xiangmu($info['reid'],$info['xmid']);
			$xiangmu = $activity['is_num']==1 ? $getxm['title']." - ".$getxm['price']."元 * ".$num : $getxm['title']." - ".$getxm['price']."元";
			
			if ($activity['is_time']==0) {
				$times = date('Y-m-d H:i:s', $record['yuyuetime']);
			}elseif ($activity['is_time']==2) {
				$times = $info['restime'];
			}
			$url=$_W['siteroot'] .'app/'.$this->createMobileUrl('detail', array('reid' => $info['reid'], 'id' => $info['rerid']));
			$data = array (
				'first' => array('value' => $par['mfirst']."\n",'color'=>"#743A3A"),
				'keyword1' => array('value' => $info['member']),
				'keyword2' => array('value' => $xiangmu),
				'keyword3' => array('value' => $times),
				'keyword4' => array('value' => $status['name']),
				'remark' => array('value' => $kfinfo."\n".$par['mfoot'],'color'=>"#008000")
			);
			
			if ($par['sms']!='0' && !empty($activity['smsid'])) {
				load()->func('communication');
				$smsdata = array(
					'type' => 'yuyue',
					'addons' => $_W['current_module']['name'],
					'openid' => $info['openid'],
					'mobile' => $activity['mobile'],
					'mname' => $info['member'],
					'mmobile' => $info['mobile'],
					'item' => $getxm['title'],
					'time' => $times,
					'status' => $status['name']
				);
				ihttp_post(murl('entry', array('do' => 'Notice', 'id' => $activity['smsid'], 'm' => 'dayu_sms'), true, true), $smsdata);
			}
			
            if (!empty($activity['m_templateid'])) {
				$acc = WeAccount::create($_W['acid']);
				$acc->sendTplNotice($info['openid'],$activity['m_templateid'],$data,$url,"#FF0000");
            }
			$store_msg = '';
			if($setting['store']==1 && pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($info['sid']) && $_GPC['status']=='3'){
				$store = $this->get_store($info['sid']);
				$boss = $this->get_store_boss($store['bid']);
				$paylog = pdo_get('dayu_yuyuepay_plugin_store_paylog', array('weid' => $_W['uniacid'], 'sid' => $info['sid'], 'bid' => $store['bid'], 'reid' => $info['reid'], 'yid' => $info['rerid'], 'ordersn' => $info['ordersn']), array());
				if(empty($paylog)){
					$paylogdata = array(
						'weid' => $_W['uniacid'],
						'sid' => $info['sid'],
						'bid' => $store['bid'],
						'reid' => $info['reid'],
						'yid' => $info['rerid'],
						'ordersn' => $info['ordersn'],
						'price' => $info['price'],
						'createtime' => TIMESTAMP
					);
					pdo_insert('dayu_yuyuepay_plugin_store_paylog', $paylogdata);
					pdo_update('dayu_yuyuepay_plugin_store_boss', array('money' => $boss['money'] + $paylogdata['price']), array('id' => $store['bid']));
					$store_msg = '店主余额增加'. $paylogdata['price'].'元，';
				}
			}
			$recorddata = array(
				'rerid' => $rerid,
				'openid' => $openid,
				'thumb' => $record['thumb'],
				'info' => $record['kfinfo'],
				'ostatus' => $info['status'],
				'status' => $record['status'],
				'createtime' => TIMESTAMP			
			);
			if (pdo_insert($this->tb_record, $recorddata) === false) {
				itoast('更新失败, 请稍后重试.');
				exit();
			}
			pdo_update($this->tb_info, $record, array('rerid' => $rerid));
			if($carid && pdo_tableexists('dayu_yuyuepay_plugin_car')) {
				pdo_update('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $rerid,'carid' =>implode(',', $_GPC['p_carid']),'createtime' => TIMESTAMP), array('id' => $carid));
			}else{
				pdo_insert('dayu_yuyuepay_plugin_car_yyid', array('infoid' => $rerid,'carid' => implode(',', $_GPC['p_carid']),'createtime' => TIMESTAMP));
			}
			itoast($store_msg.'修改成功',referer(),'success');
		}
        include $this->template('detail');
?>