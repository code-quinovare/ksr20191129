<?php
		global $_GPC, $_W;
		checklogin();
		load()->model('mc');
		$con = "";
		$nickname = trim($_GPC['nickname']);
		$code = trim($_GPC['code']);
		$status = $_GPC['status'];
		$pici = $_GPC['pici'];
		if ($nickname != '') {
			$con .= " and nickname LIKE '%$nickname%'";
		}
		if ($status != '') {
			$con .= " and status = '$status'";
		}
		if ($code != '') {
			$con .= " and code = '$code'";
		}
		if ($pici != '') {
			$con .= " and pici = '$pici'";
		}
		$settings = $this->module['config'];
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$sql = 'select * from ' . tablename('n1ce_red_user') . 'where uniacid = :uniacid '. $con .'order by time DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize ;
		$prarm = array(':uniacid' => $_W['uniacid']);
		$list = pdo_fetchall($sql, $prarm);
		foreach ($list as &$vo) {
			$mc = mc_fetch($vo['openid']);
			
			if(empty($mc['realname']) || empty($mc['mobile'])){
				$userinfo = pdo_fetch("select realname,tell from " .tablename('n1ce_red_userinfo') . " where uniacid = :uniacid and openid = :openid",array(':uniacid' => $_W['uniacid'],':openid' => $vo['bopenid']));
				$mc['realname'] = $userinfo['realname'];
				$mc['mobile'] = $userinfo['tell'];
			}
			$vo['realname'] =  $mc['realname'];
			$vo['mobile'] = $mc['mobile'];
		}
		$reply = pdo_fetch('select parama from ' . tablename('n1ce_red_pic') . ' where uniacid = :uniacid order by id DESC', array(':uniacid' => $_W['uniacid']));
		$parama = json_decode($reply['parama'], true);
		$field = array();
		if ($parama) {
			foreach ($parama as $index => $row) {
				$rew = explode("|#|", $row);
				$field[$index] = $rew[0];
			}
		}
		$count = pdo_fetchcolumn('select count(*) from ' . tablename('n1ce_red_user') . 'where uniacid = :uniacid'. $con, $prarm);
		$pager = pagination($count, $pindex, $psize);
		$category = pdo_fetchall("SELECT * FROM " . tablename('n1ce_red_pici') . " WHERE uniacid = '{$_W['uniacid']}'ORDER BY pici DESC");
		load()->func('tpl');
		include $this->template('user');