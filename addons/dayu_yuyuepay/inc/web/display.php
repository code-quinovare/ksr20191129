<?php

		$m_card = pdo_get('mc_card', array('uniacid' => $_W['uniacid'], 'status' => 1), array());
		$grant = iunserializer($m_card['grant']);
		
		$category = pdo_fetchall("SELECT id,title FROM ".tablename($this->tb_category)." WHERE weid = :weid ORDER BY `id` DESC", array(':weid' => $_W['uniacid']));
        $cateid = intval($_GPC['yuyueid']);
		$role = pdo_fetchall("SELECT * FROM ".tablename($this->tb_role)." WHERE weid = :weid and roleid = :roleid  ORDER BY id DESC", array(':roleid' => $_W['user']['uid'],':weid' => $_W['uniacid'],), 'reid');
		$roleid = array_keys($role);
		$where = 'weid = :weid';
		$params[':weid'] = $_W['uniacid'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 12;
        $status =$_GPC['status'];
        if($cateid){
            $where.=" and cid=".intval($cateid);
        }
        if($status!=''){
            $where.=" and status=".intval($status);
        }
		if (!empty($_GPC['keyword'])) {
			$where .= " AND title LIKE '%{$_GPC['keyword']}%'";
		}
		if ($setting['role']==1 && $_W['role'] == 'operator') {
			$where .= " AND reid IN ('".implode("','", is_array($roleid) ? $roleid : array($roleid))."')";
		}
        $sql = 'SELECT * FROM ' . tablename($this->tb_yuyue) . " WHERE $where ORDER BY status DESC, displayorder DESC,reid DESC LIMIT ".($pindex - 1) * $psize.','.$psize;
        $ds = pdo_fetchall($sql, $params);
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename($this->tb_yuyue) . ' WHERE ' . $where, $params);
		$pager = pagination($total, $pindex, $psize);
//		if ($ds['is_time']==2){
//			$link=
//		}else{
//		}
//		print_r($ds);
        foreach ($ds as &$item) {
			$item['title'] = mb_substr($item['title'],0,15,'utf-8');
			$item['subtitle'] = mb_substr($item['subtitle'],0,10,'utf-8');
			$item['thumb'] = tomedia($item['thumb']);
			$item['isstart'] = $item['starttime'] > 0;
			$item['switch'] = $item['status'];
			$item['role']=$this->get_isrole($item['reid'],$_W['user']['uid']);
			$item['par'] = iunserializer($item['par']);
			$item['cate'] = $this->get_category($item['cid']);
//			$item['follow'] = $item['follow']==1 ? '<span class="btn btn-success btn-sm">启用</span>' : '<span class="btn btn-default btn-sm">关闭</span>';
//			$item['code'] = $item['code']==1 ? '<span class="btn btn-success btn-sm">启用</span>' : '<span class="btn btn-default btn-sm">关闭</span>';
//			$item['is_addr'] = $item['is_addr']==1 ? '<span class="btn btn-success btn-sm">启用</span>' : '<span class="btn btn-default btn-sm">关闭</span>';
//			$item['link'] = $item['is_time']==2 ? murl('entry', array('do' => 'timelist', 'id' =>$item['reid'], 'm' => 'dayu_yuyuepay'), true, true) : murl('entry', array('do' => 'dayu_yuyuepay', 'id' =>$item['reid'], 'm' => 'dayu_yuyuepay'), true, true);
			$item['link'] = murl('entry', array('do' => 'dayu_yuyuepay', 'id' =>$item['reid'], 'm' => 'dayu_yuyuepay'), true, true);
			$item['mylink'] = murl('entry', array('do' => 'mydayu_yuyuepay', 'id' =>$item['reid'], 'm' => 'dayu_yuyuepay'), true, true);
			$item['malink'] = murl('entry', array('do' => 'manage', 'id' =>$item['reid'], 'm' => 'dayu_yuyuepay'), true, true);
        }
		if($op == 'copy') {
			$id = intval($_GPC['id']);
			$form = pdo_fetch('SELECT * FROM ' . tablename($this->tb_yuyue) . ' WHERE weid = :weid AND reid = :reid', array(':weid' => $_W['uniacid'], ':reid' => $id));
			if(empty($form)) {
				itoast('预约主题不存在或已删除', referer(), 'error');
			}
			$form['title'] = $form['title'] . '_' . random(6);
			unset($form['reid']);
			pdo_insert($this->tb_yuyue, $form);
			$form_id = pdo_insertid();
			if(!$form_id) {
				message('复制预约主题出错', '', 'error');
			} else {
				$fields = pdo_fetchall('SELECT * FROM ' . tablename($this->tb_field) . ' WHERE reid = :reid', array(':reid' => $id));
				if(!empty($fields)) {
					foreach($fields as &$val) {
						unset($val['refid']);
						$val['reid'] = $form_id;
						pdo_insert($this->tb_field, $val);
					}
				}
				itoast('复制预约主题成功', $this->createWebUrl('display'), 'success');
			}
		}
		if(checksubmit('submit')) {
			if(!empty($_GPC['ids'])) {
				foreach($_GPC['ids'] as $k => $v) {
					$data = array(
						'displayorder' => intval($_GPC['displayorder'][$k]),
					);
					pdo_update($this->tb_yuyue, $data, array('weid' => $_W['uniacid'], 'reid' => intval($v)));
				}
				itoast('更新排序成功', $this->createWebUrl('display', array()), 'success');
			}
		}
        if ($_W['ispost']) {
            $reid = intval($_GPC['reid']);
            $switch = intval($_GPC['switch']);
            $sql = 'UPDATE ' . tablename($this->tb_yuyue) . ' SET `status`=:status WHERE `reid`=:reid';
            $params = array();
            $params[':status'] = $switch;
            $params[':reid'] = $reid;
            pdo_query($sql, $params);
            exit();
        }
		include $this->template('display');
?>