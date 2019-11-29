<?php

	    global $_W  ,$_GPC;
		checklogin();
		$pici = $_GPC['pici'];
		$wheresql = " WHERE uniacid = {$_W['uniacid']}";
		if($pici){
			$wheresql .= " AND pici = {$pici} ";
		}
		$wheresql .= " AND status = 1";
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$list = pdo_fetchall("SELECT * FROM ".tablename('n1ce_red_code'). $wheresql . ' ORDER BY time DESC LIMIT '.($pindex - 1) * $psize.','. $psize);
		if (!empty($list)) {
			foreach ($list as $index => &$qrcode) {
				$qrcode['newsalt'] = base64_encode(strrev($qrcode['salt']));
				$url = $this->createMobileUrl('salt',array('salt'=>strrev($qrcode['salt']),'pici'=>$pici));
				$salturl = $_W['siteroot'] . 'app' . str_replace('./', '/', $url);
				//$salturl = shorturl($salturl);
				$qrcode['showurl'] = $salturl;
			}
		}
		$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' . tablename('n1ce_red_code') . $wheresql);
		$pager = pagination($total, $pindex, $psize);
		
		include $this->template('saltshow');
		
		function shorturl($url){
			$ch=curl_init();
			curl_setopt($ch,CURLOPT_URL,"http://dwz.cn/create.php");
			curl_setopt($ch,CURLOPT_POST,true);
			curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
			$data=array('url'=>$url);
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
			$strRes=curl_exec($ch);
			curl_close($ch);
			$arrResponse=json_decode($strRes,true);
			if($arrResponse['status']==0)
			{
			/**错误处理*/
			echo iconv('UTF-8','GBK',$arrResponse['err_msg'])."\n";
			}
			/** tinyurl */
			return $arrResponse['err_msg'];
		}