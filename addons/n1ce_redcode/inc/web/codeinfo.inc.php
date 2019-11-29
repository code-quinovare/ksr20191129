<?php

	    global $_W  ,$_GPC;
		checklogin();
		$pici = $_GPC['pici'];
		$codeinfo = pdo_fetch('select * from ' . tablename('n1ce_red_pici') . ' where uniacid = :uniacid and pici = :pici', array(':uniacid' => $_W['uniacid'],':pici' => $pici));
		if(checksubmit()){
			$data = array(
				'pici' => $_GPC['pici'],
				'codeinfo' => $_GPC['codeinfo'],
				
			);
			//var_dump($data);die();
			pdo_update('n1ce_red_pici',$data,array('pici'=>$_GPC['pici'],'uniacid'=>$_W['uniacid']));
			message('操作成功！',$this->createWebUrl('code'),'success');
		}
		load()->func('tpl');
		include $this->template('codeinfo');