<?php

        $reid = intval($_GPC['id']);
		$activity=$this->get_yuyuepay($reid);
		$par = iunserializer($activity['par']);
		$role=$this->get_isrole($reid,$_W['user']['uid']);
		if ($setting['role']==1 && $_W['role'] == 'operator' && !$role) message('您没有权限进行该操作.');
		$zhuti = pdo_fetchall("SELECT reid,title,cid FROM ".tablename($this->tb_yuyue)." WHERE weid = :weid and status=1 ORDER BY `reid` DESC", array(':weid' => $_W['uniacid']));
		foreach($zhuti AS $key => $val){
			$zhuti[$key]['cate'] = $this->get_category($val['cid']);
		}
        $sql = 'SELECT * FROM ' . tablename($this->tb_field) . ' WHERE `reid`=:reid ORDER BY `refid`';
        $params = array();
        $params[':reid'] = $reid;
        $fields = pdo_fetchall($sql, $params);
//		if (empty($fields)) {
//			message('非法访问.');
//		}
//        $ds = array();
//        foreach ($fields as $f) {
//            $ds[$f['refid']] = $f['title'];
//        }
//        $select = array();
//        if (!empty($_GPC['select'])) {
//            foreach ($_GPC['select'] as $field) {
//                if (isset($ds[$field])) {
//                    $select[] = $field;
//                }
//            }
//        } elseif (!empty($_GPC['export'])) {
//            $select = array_keys($fields);
//        }
		$cate = $this->get_category($activity['cid']);
		if(!$reid){
			$yuyue = pdo_fetchall('SELECT reid FROM '.tablename($this->tb_yuyue)." WHERE weid=:weid AND status=1", array(':weid' => $weid),'reid');
			$yuyueid = array_keys($yuyue);
	//		print_r($yuyueid);
		}

		
		if(pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($setting['store'])) {
			$store = pdo_fetchall("SELECT * FROM " . tablename('dayu_yuyuepay_plugin_store_store') . " WHERE weid = :weid and checked = 1 ORDER BY id DESC", array(':weid' => $weid), 'id');
			foreach($store AS $key => $val){
				$store[$key]['reid'] = $val['id'];
				$store[$key]['title'] = $val['name'];
			}
		}
        $pindex = max(1, intval($_GPC['page']));
        $psize = 10;
		$status = $_GPC['status'];
		$paystatus = $_GPC['paystatus'];
        $starttime = empty($_GPC['time']['start']) ? strtotime('-1 month') : strtotime($_GPC['time']['start']);
        $endtime = empty($_GPC['time']['end']) ? TIMESTAMP : strtotime($_GPC['time']['end']) + 86399;
//		$yytime = urldecode($_GPC['yytime']);
		$yytime = $_GPC['yytime'];
		$stime = empty($_GPC['yytime']['start']) ? TIMESTAMP : strtotime($_GPC['yytime']['start']);
		$etime = empty($_GPC['yytime']['end']) ? strtotime('+15 day') : strtotime($_GPC['yytime']['end']) + 86399;
		$where.='reid=:reid';
//		$where.='reid=:reid AND `createtime` > :starttime AND `createtime` < :endtime';
		$params = array();
		$params[':reid'] = $reid;
		if (!empty($_GPC['time'])) {
			$where .= " AND createtime >= :starttime AND createtime <= :endtime ";
			$params[':starttime'] = $starttime;
			$params[':endtime'] = $endtime;
		}
        if ($activity['is_time']==2 && !empty($_GPC['yytime'])) {
            $where.=' AND restime like :yytime';
            $params[':yytime'] = "%{$_GPC['yytime']}%";
        }elseif ($activity['is_time']==0 && !empty($_GPC['yytime']['start'])) {
            $where.=' AND `yuyuetime` > :stime AND `yuyuetime` < :etime';
			$params[':stime'] = $stime;
			$params[':etime'] = $etime;
        }
        if (!empty($_GPC['keywords'])) {
            $where.=' and (member like :member or mobile like :mobile)';
            $params[':member'] = "%{$_GPC['keywords']}%";
            $params[':mobile'] = "%{$_GPC['keywords']}%";
        }
        if (!empty($_GPC['orderid'])) {
            $where.=' and (ordersn like :ordersn or transid like :transid)';
            $params[':ordersn'] = "%{$_GPC['orderid']}%";
            $params[':transid'] = "%{$_GPC['orderid']}%";
        }
        if (!empty($_GPC['storeid'])) {
            $where.=' and sid=:sid';
            $params[':sid'] = "{$_GPC['storeid']}";
        }
        if ($status != '') {
			if ($status == 2) {
				$allstatus.=" and ( status=2 or status=9 )";
			} else {
				$allstatus.=" and status='{$status}'";
			}
        }
        if ($paystatus != '') {
				$allstatus.=" and paystatus='{$paystatus}'";
        }
        $sql = 'SELECT * FROM ' . tablename($this->tb_info) . " WHERE $where $allstatus ORDER BY createtime DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize;
        $list = pdo_fetchall($sql, $params, 'rerid');
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->tb_info) . " WHERE $where $allstatus", $params);
        $pager = pagination($total, $pindex, $psize);
		
				$paytype = array (
					'0' => array('css' => 'default', 'name' => '未支付'),
					'1' => array('css' => 'success','name' => '在线支付'),
					'2' => array('css' => 'info', 'name' => '余额支付'),
					'3' => array('css' => 'warning', 'name' => '其他付款方式'),
					'4' => array('css' => 'info', 'name' => '免费预约')
				);
			foreach ($list as $index => $row) {
				$list[$index]['user'] = mc_fansinfo($row['openid'],$acid, $_W['uniacid']);
				$list[$index]['xm'] = $this->get_xiangmu($row['reid'],$row['xmid']);
				$list[$index]['store'] = !empty($row['sid']) ? $this->get_store($row['sid']) : '';
				$list[$index]['status'] = $this->get_status($row['reid'],$row['status']);
//				$list[$index]['paystatus'] = $row['paystatus']==1 ? '<span class="btn btn-warning btn-xs">未支付</span>' : '<span class="btn btn-danger btn-xs">已支付</span>';
				$list[$index]['css'] = $paytype[$row['paytype']]['css'];
					if ($list[$index]['paytype'] == 1) {
						if (empty($list[$index]['transid'])) {
							if ($list[$index]['paystatus'] == 1) {
							$list[$index]['paytype'] = '';
							} else {
							$list[$index]['paytype'] = '支付宝支付';
							}
						} else {
							$list[$index]['paytype'] = '微信支付';
						}
					} else {
						$list[$index]['paytype'] = $paytype[$row['paytype']]['name'];
					}
			}
			$rerid = array_keys($list);
			$children = array();			
			$childlist = pdo_fetchall("SELECT * FROM ".tablename($this->tb_data)." WHERE rerid IN ('".implode("','", is_array($rerid) ? $rerid : array($rerid))."') AND `reid`=:reid", array(':reid' => $reid));
			foreach ($childlist as $reply => $d) {	
				if (!empty($d['rerid'])) {
					$children[$d['rerid']][] = $d;
					unset($children[$reply]);
				}				
			}
		
			$sum_price_all = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where", $params);
			$sum_price_confirm = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where AND status=0 AND paystatus=1", $params);
			$sum_price_pay = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where AND status=0 AND paystatus=2", $params);
			$sum_price_finish = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where AND status=1 AND paystatus=2", $params);
			$sum_price_cancel = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where AND ( status=2 or status=9 )", $params);
			$sum_price_end = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where AND status=3", $params);
			$sum_price_refund = pdo_fetch('SELECT SUM(price) AS sum_money FROM ' . tablename($this->tb_info) . " WHERE $where AND status=7", $params);
			
//			$sum_price = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . "  WHERE $where", $params);
			$order_count_all = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where", $params);
			$order_count_confirm = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where AND status=0 AND paystatus=1", $params);
			$order_count_pay = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where AND status=0 AND paystatus=2", $params);
			$order_count_finish = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where AND status=1 AND paystatus=2", $params);
			$order_count_cancel = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where AND ( status=2 or status=9 )", $params);
			$order_count_end = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where AND status=3", $params);
			$order_count_refund = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_info) . " WHERE $where AND status=7", $params);

		if (!empty($_GPC['export'])) {
//			$sql = 'SELECT title FROM ' . tablename($this->tb_field) . " AS f JOIN " . tablename($this->tb_info) . " AS r ON f.reid='{$reid}' GROUP BY title ORDER BY refid";
//			$tableheader = pdo_fetchall($sql, $params);
			$tableheader = pdo_fetchall("SELECT title,f.displayorder FROM " . tablename($this->tb_field) . " AS f JOIN " . tablename($this->tb_info) . " AS r ON f.reid='{$reid}' GROUP BY title ORDER BY refid, f.displayorder desc");
            $tablelength = count($tableheader);
            /* 获取预约数据 */
			$sql = 'SELECT * FROM ' . tablename($this->tb_info) . " WHERE $where $allstatus ORDER BY createtime DESC";
			$list = pdo_fetchall($sql, $params);
            if (empty($list)) {
                itoast('暂时没有预约数据');
            }
            foreach ($list as &$r) {
                $sql = 'SELECT data, refid FROM ' . tablename($this->tb_data) . " WHERE `reid`=:reid AND `rerid`='{$r['rerid']}' ORDER BY redid, displayorder desc";
				$paramss = array();
				$paramss[':reid'] = $r['reid'];
                $r['fields'] = array();
                $fdatas = pdo_fetchall($sql, $paramss);
                foreach ($fdatas as $fd) {
//					if (false == array_key_exists($fd['refid'], $r['fields'])) {
						$r['fields'][$fd['refid']] = $fd['data'];
//					} else {
//						$r['fields'][$fd['refid']] .= '-' . $fd['data'];
//					}
                }
            }

            /* 处理预约数据 */
            $data = array();
            foreach ($list as $key => $value) {
                $data[$key]['member'] = $value['member'];
                $data[$key]['mobile'] = $value['mobile'];
				if(pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($setting['store'])) {
					$data[$key]['store'] = $this->get_store($value['sid']);
				}
                $data[$key]['xmid'] = $this->get_xiangmu($value['reid'],$value['xmid']);
                $data[$key]['paystatus'] = $value['paystatus'] == '2' ? '已付款' : '未付款';
                $data[$key]['status'] = $this->get_status($value['reid'],$value['status']);
                $data[$key]['price'] = $value['price'];
                $data[$key]['restime'] = $value['restime'];
                $data[$key]['yuyuetime'] = date('Y-m-d H:i', $value['yuyuetime']);
                if (!empty($value['fields'])) {
                    foreach ($value['fields'] as $field) {
                    if (substr($field, 0, 6) == 'images') {
                        $data[$key][] = str_replace(array("\n", "\r", "\t"), '', $_W['attachurl'] . $field);
                    } else {
                        $data[$key][] = str_replace(array("\n", "\r", ",", "\t"), '，', $field);
					}
                    }
                }
                $data[$key]['createtime'] = date('Y-m-d H:i:s', $value['createtime']);
				$data[$key]['kfinfo'] = $value['kfinfo'];
				$data[$key]['transid'] = $value['transid'];
				$data[$key]['share'] = $value['share'];
            }


            /* 输入到CSV文件 */
            $html = "\xEF\xBB\xBF";
            /* 输出表头 */
            $html .= "姓名\t,";
            $html .= "手机\t,";
			if(pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($setting['store'])) {
            $html .= "店铺\t,";
			}
            $html .= $par['xmname']."\t,";
            $html .= "金额\t,";
            $html .= "预约时间\t,";
            $html .= "付款状态\t,";
            $html .= "支付单号\t,";
            $html .= "预约状态\t,";
            foreach ($tableheader as $value) {		//自定义使用排序，标题与内容不对应
                $html .= $value['title'] . "\t ,";
            }
            $html .= "回复\t,";
            $html .= "提交时间\t,";
            $html .= "分享人\t,";
            $html .= "\n";

            /* 输出内容 */
            foreach ($data as $value) {			
                $html .= $value['member']."\t,";
                $html .= $value['mobile']."\t,";
				if(pdo_tableexists('dayu_yuyuepay_plugin_store_store') && !empty($setting['store'])) {
					$html .= !empty($value['store']['name']) ? $value['store']['name']."\t," : "\t,";
				}
                $html .= $value['xmid']['title']."\t,";
                $html .= $value['price']."\t,";
                $html .= $activity['is_time']==2 ? $value['restime']."\t," : $value['yuyuetime']."\t,";
                $html .= $value['paystatus']."\t,";
                $html .= $value['transid']."\t,";
                $html .= $value['status']['name']."\t,";
                for ($i = 0; $i < $tablelength; $i++) {
                    $html .= $value[$i]."\t,";
                }
				$html .= $value['kfinfo']."\t,";
                $html .= $value['createtime']."\t,";
                $html .= $value['share']."\t,";
                $html .= "\n";
            }
            /* 输出CSV文件 */
			$stime=date('Ymd', $starttime);
			$etime=date('Ymd', $endtime);
            header("Content-type:text/csv");
            header("Content-Disposition:attachment; filename={$cate['title']} - {$activity['title']}$stime-$etime.csv");
            echo $html;
            exit();
        }
        /* 如果调查项目类型为图片，处理fields字段信息 */
        foreach ($list as $key => &$value) {
            if(is_array($value['fields'])){
                foreach ($value['fields'] as &$v) {
                    $img = '<div align="center"><img src="';
                    if (substr($v, 0, 6) == 'images') {
                        $v = $img . $_W['attachurl'] . $v . '" style="width:50px;height:50px;"/></div>';
                    }
                }
                unset($v);
            }
        }
		$title="预约记录管理";
        include $this->template('manage');
?>