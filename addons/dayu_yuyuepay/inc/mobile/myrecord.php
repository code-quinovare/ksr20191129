<?php
		$sql = 'SELECT `reid` FROM ' . tablename($this->tb_info) . " WHERE openid = :openid ORDER BY rerid DESC";
		$params = array();
		$params[':openid'] = $openid;
        $rows = pdo_fetchall($sql, $params);
		$new_array = array();
			foreach($rows as $v){
				$new_array[$v['reid']]=1;
			}
		$last = array();
			foreach($new_array as $u=>$v){
				$last[] = $u;
			}
		$fids = implode(',', $last);
		if ($fids) {
//			$list = pdo_fetchall("SELECT * FROM " . tablename($this->tb_yuyue) . " WHERE weid = :weid and status = 1 ORDER BY reid DESC", array(':weid' => $weid));
			$list = pdo_fetchall("SELECT * FROM " . tablename($this->tb_yuyue) . " WHERE weid = :weid and status = 1 and reid in({$fids}) ORDER BY reid DESC", array(':weid' => $weid));
			foreach($list AS $key => $val){
				$list[$key]['form'] = $this->get_yuyue($val['reid'],1);
			}
		}
		$profile = mc_fetch($_W['member']['uid']);
		$title="我的预约";
//		$menushow=1;
		$footer=1;
        include $this->template('member/myrecord');
?>