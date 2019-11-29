<?php
	global $_GPC, $_W;
	checklogin();
	$pici = $_GPC['pici'];
	$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
	if($operation=="edits"){
		$id = $_GPC['id'];
		$pici = $_GPC['pici'];
		$sql = 'select * from ' . tablename('n1ce_red_prize') . 'where uniacid = :uniacid and pici = :pici and id = :id';
		$prarm = array(':uniacid' => $_W['uniacid'],':pici' => $pici,':id' => $id);
		$sum = pdo_fetch($sql, $prarm);
	}
	if (checksubmit()){
		$datas = array(
			'prizeodds' => $_GPC['prizeodds'],
			'prizesum' => $_GPC['prize_sum'],
			'min_money' => $_GPC['min_money'],
			'max_money' => $_GPC['max_money'],
			'cardid' => $_GPC['cardid'],
			'url' => $_GPC['url'],
			'txt' => $_GPC['txt'],
			'total_num' => $_GPC['total_num'],
			'credit' => $_GPC['credit'],
			'youzan_credit' => $_GPC['yz_credit'],
		);
		pdo_update('n1ce_red_prize',$datas, array('id' => $_GPC['id']));
		message('更新奖品成功',$this->createWebUrl('prize',array('pici' => $pici)),'success');
	}
	include $this->template('prizeedits');