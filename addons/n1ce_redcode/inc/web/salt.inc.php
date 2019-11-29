<?php

	    global $_W  ,$_GPC;
		checklogin();
		$pici = $_GPC['pici'];
		$uniacid = $_W['uniacid'];
		$res = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and pici = :pici and iscqr = 1 limit 500', array(':uniacid' => $_W['uniacid'], ':pici' => $pici));
		foreach($res as $key => $vol){
			$data = array(
				'salt' => getsaltcode($vol['code']),
				'iscqr' => '2',
				
			);
			pdo_update('n1ce_red_code',$data,array('uniacid'=>$uniacid,'pici'=>$pici,'code'=>$vol['code']));
		}
		$res2 = pdo_fetchall('select * from ' . tablename('n1ce_red_code') . ' where uniacid = :uniacid and status = 1 and iscqr = 1 and pici = :pici', array(':uniacid' => $_W['uniacid'] , ':pici' => $pici));
		if($res2){
			message('请勿刷新，智能二维码继续生成中', $this->createWebUrl('Salt',array('pici' => $pici)), 'success');
		}else{
			message('恭喜，生成智能二维码成功！', $this->createWebUrl('code'), 'success');
		}
		
		
		function getsaltcode($code){
			$salt = md5(md5($code));
			return $salt;
		}