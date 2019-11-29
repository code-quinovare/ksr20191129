<?php
/**
 * 易用拼车模块微站定义
 *
 * @author 349323696
 * @url http://mp.easilyuse.cn
 */
defined('IN_IA') or exit('Access Denied');

class Easily_pincheModuleSite extends WeModuleSite {
	public $setup;
	
	//系统设置信息
	public function DBSetup(){
		global $_W;
		$uniacid = $_W['account']['uniacid'];
		$this->setup = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_setup')." WHERE uniacid = {$uniacid}");
	}
	
	//用户信息
	public function DBUser(){
		global $_W;
		$uniacid = $_W['account']['uniacid'];
		$openid  = $_W['fans']['openid'];
		$user = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_user')." WHERE pcu_wx_openid = '{$openid}' and uniacid = {$uniacid}");
		if(empty($user)){
			$this->DBSetup();
			$date = array(
				'uniacid'       => $uniacid,
				'pcu_wx_sex'    => $_W['fans']['sex'],
				'pcu_wx_title'  => $_W['fans']['nickname'],
				'pcu_wx_logo'   => $_W['fans']['avatar'],
				'pcu_wx_openid' => $openid,
				'pcu_money'     => $this->setup['es_openmoney'],
				'pcu_addtime'   => date('Y-m-d H:i:s'),
				'pcu_addip'     => $_W['clientip']
			);
			pdo_insert('eu_pinche_user',$date);
			if($this->setup['es_openmoney']!=0){
				$date = array(
					'uniacid'     => $uniacid,
					'pcu_id'      => pdo_insertid(),
					'pcm_type'    => 1,
					'pcm_addtime' => date('Y-m-d H:i:s'),
					'pcm_money'   => $this->setup['es_openmoney'],
					'pcm_balance' => $this->setup['es_openmoney'],
					'pcm_content' => '新注册，系统赠送'
				);
				pdo_insert('eu_pinche_money',$date);
			}
		}
		return $user;
	}
	
	//判断是否微信登录
	public function WX_Browser(){
		$useragent = addslashes($_SERVER['HTTP_USER_AGENT']);
		if(strpos($useragent, 'MicroMessenger') === false && strpos($useragent, 'Windows Phone') === false ){
			//echo " Sorry！非微信浏览器不能访问";
			//exit;
		}	
	}
	
	//微信登录操作
	public function WX_Login(){
		global $_W;
		if (empty($_W['fans']['nickname'])) {
			$userinfo = mc_oauth_userinfo();
			$uniacid  = $_W['account']['uniacid'];
			$openid   = $userinfo['openid'];
			$userdb   = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_user')." WHERE pcu_wx_openid = '{$openid}' and uniacid = {$uniacid}");
			if(empty($userdb)){
				$this->DBSetup();
				$date = array(
				'uniacid'       => $uniacid,
				'pcu_wx_sex'    => $_W['fans']['sex'],
				'pcu_wx_title'  => $_W['fans']['nickname'],
				'pcu_wx_logo'   => $_W['fans']['avatar'],
				'pcu_wx_openid' => $openid,
				'pcu_money'     => $this->setup['es_openmoney'],
				'pcu_addtime'   => date('Y-m-d H:i:s'),
				'pcu_addip'     => $_W['clientip']
				);
				pdo_insert('eu_pinche_user',$date);
				if($this->setup['es_openmoney']!=0){
					$date = array(
						'uniacid'     => $uniacid,
						'pcu_id'      => pdo_insertid(),
						'pcm_type'    => 1,
						'pcm_addtime' => date('Y-m-d H:i:s'),
						'pcm_money'   => $this->setup['es_openmoney'],
						'pcm_balance' => $this->setup['es_openmoney'],
						'pcm_content' => '新注册，系统赠送'
					);
					pdo_insert('eu_pinche_money',$date);
				}
			}
		}
	}

	public function IsTodayOrTomorrow($str_in){
		$str_today = date('Y-m-d'); //获取今天的日期 字符串 
		$ux_today =  strtotime($str_today); //将今天的日期字符串转换为 时间戳
		
		$ux_tomorrow = $ux_today+3600*24;// 获取明天的时间戳
		$str_tomorrow = date('Y-m-d',$ux_tomorrow);//获取明天的日期 字符串
		
		
		$ux_afftertomorrow = $ux_today+3600*24*2;// 获取后天的时间戳
		$str_afftertomorrow = date('Y-m-d',$ux_tomorrow);//获取后天的日期 字符串
		
		$ux_in = strtotime($str_in);//获取输入日期的 时间戳
		$str_in_format = date('Y-m-d',$ux_in);//格式化为y-m-d的 日期字符串
		
		if($str_in_format==$str_today){
		   return "今天"; 
		}else if($str_in_format==$str_tomorrow){
		   return "明天"; 
		}else if($str_in_format==$str_afftertomorrow){
		   return "后天"; 
		}else{
		  return   $str_in_format;
		}
	}
	
	public function doMobileuser(){
		global $_W,$_GPC;
		$cssurl  = '/addons/'.$_W['current_module']['name'].'/template/css/';
		$uniacid = $_W['account']['uniacid'];
		$this->DBSetup();
		$setup = $this->setup;
		$userdb = $this->DBUser();
		$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." where uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']}");
		include $this->template('user');
	}
	
	public function doMobileIndex() {
		global $_W,$_GPC;	
		$cssurl  = '/addons/'.$_W['current_module']['name'].'/template/css/';
		$uniacid = $_W['account']['uniacid'];
		$this->DBSetup();
		$setup = $this->setup;
		$remen = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_remen')." where uniacid = {$uniacid}");
		$ORDER= " ORDER BY pci_chuaddtime";
		if(empty($_GPC['address'])){
			if(empty($_GPC['type'])){
				$type_where = 'and 1 = 1';
			}else{
				$type_where = 'and pci_type = '.$_GPC['type'];
			}
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." where uniacid = {$uniacid} and pci_show_flag = 2 {$type_where} and DATE_FORMAT(NOW(),'%Y %m %d %H:%i') < DATE_FORMAT(pci_chuaddtime,'%Y %m %d %H:%i') {$ORDER}");
		}elseif($_GPC['address']=='search'){
			$from_name = $_GPC['from_name'];
			$to_name   = $_GPC['to_name'];
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." where pci_chuaddress = '{$from_name}' and pci_muaddress = '{$to_name}' and uniacid = {$uniacid} and pci_show_flag = 2 and DATE_FORMAT(NOW(),'%Y %m %d %H:%i') < DATE_FORMAT(pci_chuaddtime,'%Y %m %d %H:%i') {$ORDER}");
		}else{
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." where pci_muaddress='".$_GPC['title']."' and uniacid = {$uniacid} and pci_show_flag = 2 and DATE_FORMAT(NOW(),'%Y %m %d %H:%i') < DATE_FORMAT(pci_chuaddtime,'%Y %m %d %H:%i') {$ORDER}");
		}
		include $this->template('index');
	}
	
	public function doMobiledetails(){
		global $_W,$_GPC;
		$cssurl  = '/addons/'.$_W['current_module']['name'].'/template/css/';
		$uniacid = $_W['account']['uniacid'];
		$this->DBSetup();
		$setup = $this->setup;
		$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." where uniacid = {$uniacid} and pci_code = '{$_GPC['code']}'");
		$userdb = $this->DBUser();
		if(empty($info)){
			message('数据不存在。');
		}
		$read = $info['pci_read'] + 1;
		$date = array(
			'pci_read' => $read
		);
		pdo_update('eu_pinche_info',$date,"uniacid = {$uniacid} and pci_code = '{$_GPC['code']}'");
		include $this->template('details');
	}
	
	public function doMobileeditcode(){
		global $_W,$_GPC;
		$this->DBSetup();
		$setup = $this->setup;
		$uniacid = $_W['account']['uniacid'];
		$cssurl = '/addons/'.$_W['current_module']['name'].'/template/css/';
		$code = $_GPC['code'];
		$userdb = $this->DBUser();
		$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." where uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']} and pci_code = '{$code}'");
		if(empty($info)){
			message('数据不存在！');
		}
		include $this->template('edit');
	}
	
	public function doMobileajaxedit(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$code    = $_GPC['code'];
		$userdb  = $this->DBUser();	
		//出发时间是否大于当前时间
		
		if(strtotime($_GPC["beginTime"]) <= strtotime(date("Y-m-d H:i:s"))){
			$JSON['type'] = 3;
			$this->json($JSON);
		}
		$data =  array(
			'pci_type'       => $_GPC["pinche"],
			'pci_chuaddress' => $_GPC["QiDian"],
			'pci_muaddress'  => $_GPC["ZhongDian"],
			'pci_tuaddress'  => $_GPC["tujingZhan"],
			'pci_chuaddtime' => $_GPC["beginTime"],
			'pci_phone'      => $_GPC["tel"],
			'pci_count'      => $_GPC["number"],
			'pci_content'    => $_GPC["info"],
		);
		pdo_update('eu_pinche_info',$data,"uniacid = {$uniacid} and pci_code = '{$code}' and pcu_id = {$userdb['pcu_id']}");
		//修改用户电话信息
		$date = array(
			'pcu_phone' => $_GPC["tel"]
		);
		$res = pdo_update('eu_pinche_user',$date,"uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']}");
		if (!empty($res)) {
			$JSON['type'] = 1;
		}else{
			$JSON['type'] = 2;
		}
		$this->json($JSON);	
	}
	
	public function doMobilefabutop(){
		global $_W,$_GPC;
		load()->web('tpl'); 
		$uniacid = $_W['account']['uniacid'];
		$this->WX_Browser();
		$this->WX_Login();
		$this->DBSetup();
		$userdb = $this->DBUser();
		$setup  = $this->setup;
		$cssurl = '/addons/'.$_W['current_module']['name'].'/template/css/';
		$code   = $_GPC['code'];
		if(empty($code)){
			message('code不能为空！');
		}
		$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." where uniacid = {$uniacid} and pci_code = '{$code}'");
		if(empty($info)){
			message('数据不存在。');
		}
		if($userdb['pcu_id']!=$info['pcu_id']){
			message('错误：#power no user');
		}
		include $this->template('top');
	}
	
	public function doMobiletopmoney(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$code  = $_GPC['code'];
		$day   = $_GPC['day'];
		$money = $_GPC['money'];
		$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." where uniacid = {$uniacid} and pci_code = '{$code}'");
		
		if($info['pci_toptime'] == '0000-00-00 00:00:00'){
			$toptime = date('Y-m-d H:i:s',strtotime('+'.$day.' day'));
		}else{
			$days = $info["pci_top"] + $day;
			if(strtotime($info["pci_toptime"]) <= strtotime(date("Y-m-d H:i:s"))){
				$toptime = date('Y-m-d H:i:s',strtotime('+'.$day.' day'));
			}else{
				$toptime = date('Y-m-d H:i:s',strtotime('+'.$day.' day',strtotime($info["pci_toptime"])));
			}
		}
		$date = array(
			'pci_top' => $days,
			'pci_toptime' => $toptime,
		);
		pdo_update('eu_pinche_info',$date,"uniacid = {$uniacid} and pci_code = '{$code}'");
		$content = "置顶信息收入+{$day}天！{$code}";
		$date = array(
			'uniacid'     => $uniacid,
			'pci_id'      => $info['pci_id'],
			'pcu_id'      => $info['pcu_id'],
			'pcm_type'    => 2,
			'pcm_addtime' => date('Y-m-d H:i:s'),
			'pcm_money'   => $money,
			'pcm_balance' => 0,
			'pcm_content' => $content
		);
		$result = pdo_insert('eu_pinche_money',$date);	
		header("Location: /app/index.php?i={$uniacid}&c=entry&do=details&m=easily_pinche&code={$code}");
	}
	
	public function doMobileFabu() {
		global $_W,$_GPC;
		load()->web('tpl');
		$this->WX_Browser();
		$this->WX_Login();
		$this->DBSetup();
		$userdb = $this->DBUser();
		$setup  = $this->setup;
		$cssurl = '/addons/'.$_W['current_module']['name'].'/template/css/';
		include $this->template('fa');
	}
	
	public function strrand( $length = 32 ) { 
		// 密码字符集，可任意添加你需要的字符 
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'; 
		$password = ''; 
		for ( $i = 0; $i < $length; $i++ ) { 
			// 这里提供两种字符获取方式 
			// 第一种是使用 substr 截取$chars中的任意一位字符； 
			// 第二种是取字符数组 $chars 的任意元素 
			// $password .= substr($chars, mt_rand(0, strlen($chars) – 1), 1); 
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ]; 
		} 
		return $password; 
	}	
	
	public function doMobilepay(){
		global $_W,$_GPC;
		load()->web('tpl'); 
		include $this->template('pay');
	}
	
	public function json($info){
		echo json_encode($info);
		exit;
	}
	

	
	public function doMobiledelcode(){
		global $_W,$_GPC;
		$userdb  = $this->DBUser();
		$uniacid = $_W['account']['uniacid'];
		$code    = $_GPC['code'];
		$info    = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." WHERE uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']} and pci_code = '{$code}'");
		if(empty($info)){
			message('错误：数据不存在！');
		}
		$result = pdo_delete('eu_pinche_info', array('uniacid' => $uniacid,'pci_code'=>$code),'and');
		if(!empty($result)) {
			message('删除成功');
		}else{
			message('删除失败');
		}
	}
		
	public function doMobilesh_details(){
		global $_W,$_GPC;		
		$userdb  = $this->DBUser();
		$uniacid = $_W['account']['uniacid'];
		$mtype   = $_GPC['mtype'];
		$code    = $_GPC['code'];
		$money   = $_GPC['money'];
		$info    = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." WHERE uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']} and pci_code = '{$code}'");
		
		//1.用户审核通过
		$date = array(
			'pci_show_flag' => 2
		);
		pdo_update('eu_pinche_info',$date,"uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']} and pci_code = '{$code}'");
		//2.用户信息电话信息
		$date = array(
			'pcu_phone' => $info["pci_phone"]
		);
		pdo_update('eu_pinche_user',$date,"uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']}");		
		
		if($mtype == 1){
			//用户帐上0元，完整支付拼车费用  X
			//3.记录充值记录与支付金额记录
			//增加一个费用支出记录 start
			$content = "发布拼车信息，充值记录！";
			$date = array(
				'uniacid'     => $uniacid,
				'pci_id'      => $info['pci_id'],
				'pcu_id'      => $userdb['pcu_id'],
				'pcm_type'    => 1,
				'pcm_addtime' => date('Y-m-d H:i:s'),
				'pcm_money'   => $money,
				'pcm_balance' => $money,
				'pcm_content' => $content
			);
			$result = pdo_insert('eu_pinche_money',$date);			
			
			$content = "发布拼车信息{$code}支出费用！";
			$date = array(
				'uniacid'     => $uniacid,
				'pci_id'      => $info['pci_id'],
				'pcu_id'      => $userdb['pcu_id'],
				'pcm_type'    => 2,
				'pcm_addtime' => date('Y-m-d H:i:s'),
				'pcm_money'   => $money,
				'pcm_balance' => 0,
				'pcm_content' => $content
			);
			$result = pdo_insert('eu_pinche_money',$date);
			//增加一个费用支出记录 end
		}else{
			//用户帐上金额小于支付拼车费用，要支付部分拼车费用   X
			$content = "发布拼车信息，充值记录！";
			$balance = $userdb['pcu_money'] + $money;
			echo $balance;
			$date = array(
				'uniacid'     => $uniacid,
				'pci_id'      => $info['pci_id'],
				'pcu_id'      => $userdb['pcu_id'],
				'pcm_type'    => 1,
				'pcm_addtime' => date('Y-m-d H:i:s'),
				'pcm_money'   => $money,
				'pcm_balance' => $balance,
				'pcm_content' => $content
			);
			$result = pdo_insert('eu_pinche_money',$date);			
			
			$content = "发布拼车信息{$code}支出费用！";
			$date = array(
				'uniacid'     => $uniacid,
				'pci_id'      => $info['pci_id'],
				'pcu_id'      => $userdb['pcu_id'],
				'pcm_type'    => 2,
				'pcm_addtime' => date('Y-m-d H:i:s'),
				'pcm_money'   => $balance,
				'pcm_balance' => 0,
				'pcm_content' => $content
			);
			$result = pdo_insert('eu_pinche_money',$date);
			$date = array(
				'pcu_money' => 0
			);
			pdo_update('eu_pinche_user',$date,"uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']}");	
		}
		header("Location: /app/index.php?i={$uniacid}&c=entry&do=fabutop&m=easily_pinche&code={$code}");
						   
	}
	
	public function doMobiledel_details(){
		global $_W,$_GPC;
		$userdb = $this->DBUser();
		pdo_delete('eu_pinche_info', array('uniacid'       => $_GPC['i'],
		                                   'pcu_id'        => $userdb['pcu_id'],
										   'pci_show_flag' => 1,
										   'pci_code'      => $_GPC['code']),'and');
	}
	
	public function doMobileajaxfabu(){
		global $_W,$_GPC;
		
		$uniacid = $_W['account']['uniacid'];
		$this->DBSetup();
		$userdb = $this->DBUser();
		$setup  = $this->setup;
		$code   = $this->strrand(); //32位随机码
		
		$MoneyType = array(1=>$setup['es_rzc_money'], //1人找车
						   2=>$setup['es_czr_money'], //2车找人
						   3=>$setup['es_fzc_money'], //3货找车
						   4=>$setup['es_czf_money'] //4车找货
					);
					

		$PincheID  = $_GPC["pinche"]; //选择的拼车类型
		$userMoney = $userdb['pcu_money']; //用户金额
		
		$JSON['type']     = 1;
		$JSON['pcucode']  = $code;
		$JSON['orderTid'] = time();
		$JSON['mtype']    = 0;
		
		//出发时间是否大于当前时间
		
		if(strtotime($_GPC["beginTime"]) <= strtotime(date("Y-m-d H:i:s"))){
			$JSON['type'] = 3;
			$this->json($JSON);
		}
		
		
		if($MoneyType[$PincheID]!=0){
			//要钱发布
			if($userMoney == 0){
				//用户帐上0元，完整支付拼车费用  X
				$JSON['money'] = $MoneyType[$PincheID];
				$JSON['mtype'] = 1;
				$this->FInfo($code,1);
				$this->json($JSON);
			}else{
				if($userMoney < $MoneyType[$PincheID]){
					//用户帐上金额小于支付拼车费用，要支付部分拼车费用   X
					$JSON['money'] =  $MoneyType[$PincheID] - $userMoney;
					$JSON['mtype'] = 2;
					$this->FInfo($code,1);
					$this->json($JSON);
				}else{
					//用户帐上金额大于支付拼车费用，直接扣除费用
					$balance = $userMoney - $MoneyType[$PincheID];
					$this->FInfo($code,2);
					//修改用户电话信息，与余额信息
					$date = array(
						'pcu_phone' => $_GPC["tel"],
						'pcu_money' => $balance
					);
					pdo_update('eu_pinche_user',$date,"uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']}");
					//增加一个费用支出记录 start
					$content = "发布拼车信息{$code}支出费用！";
					$date = array(
						'uniacid'     => $uniacid,
						'pci_id'      => pdo_insertid(),
						'pcu_id'      => $userdb['pcu_id'],
						'pcm_type'    => 2,
						'pcm_addtime' => date('Y-m-d H:i:s'),
						'pcm_money'   => $MoneyType[$PincheID],
						'pcm_balance' => $balance,
						'pcm_content' => $content
					);
					$result = pdo_insert('eu_pinche_money',$date);
					//增加一个费用支出记录 end
					$JSON['type']    = 2;
					$this->json($JSON);
				}
			}
		}else{
			//不要钱就可以发布了
			$this->FInfo($code,2);
			//修改用户电话信息
			$date = array(
				'pcu_phone' => $_GPC["tel"]
			);
			pdo_update('eu_pinche_user',$date,"uniacid = {$uniacid} and pcu_id = {$userdb['pcu_id']}");
			$JSON['type']    = 2;
			$this->json($JSON);			
		}
	}
	
	public function FInfo($code,$flag=1){
		global $_W,$_GPC;
		$userdb = $this->DBUser();
		$data =  array(
			'uniacid'        => $userdb['uniacid'],
			'pci_code'       => $code,
			'pcu_id'         => $userdb['pcu_id'],
			'pci_type'       => $_GPC["pinche"],
			'pci_chuaddress' => $_GPC["QiDian"],
			'pci_muaddress'  => $_GPC["ZhongDian"],
			'pci_tuaddress'  => $_GPC["tujingZhan"],
			'pci_chuaddtime' => $_GPC["beginTime"],
			'pci_phone'      => $_GPC["tel"],
			'pci_count'      => $_GPC["number"],
			'pci_content'    => $_GPC["info"],
			'pci_addtime'    => date('Y-m-d H:i:s'),
			'pci_show_flag'  => $flag
		);
		pdo_insert('eu_pinche_info',$data);
	}
	
	public function doWebsetup(){
		global $_W,$_GPC;
		$type = $_GPC['type'];
		if(empty($type)){
			load()->func('tpl');
			$this->DBSetup();
			$setup = $this->setup;
			if(!$setup){
				$date = array(
					'uniacid' => $_W['account']['uniacid'],
					'es_czr_money' => 1,
					'es_rzc_money' => 1,
					'es_fzc_money' => 1,
					'es_czf_money' => 1
				);
				pdo_insert('eu_pinche_setup',$date);
				$this->DBSetup();
				$setup = $this->setup;
			}
			if($_GPC['act']=='save'){
				$date = array(
					'es_title'     => $_GPC['es_title'],
					'es_img'       => $_GPC['image'],
					'es_czr_money' => $_GPC['es_czr_money'],
					'es_rzc_money' => $_GPC['es_rzc_money'],
					'es_fzc_money' => $_GPC['es_fzc_money'],
					'es_czf_money' => $_GPC['es_czf_money'],
					'es_copyright' => $_GPC['es_copyright'],
					'es_sjcontent' => $_GPC['sj'],
					'es_ckcontent' => $_GPC['ck'],
					'es_openmoney' => $_GPC['es_openmoney'],
					'es_1_money'   => $_GPC['es_1_money'],
					'es_3_money'   => $_GPC['es_3_money'],
					'es_5_money'   => $_GPC['es_5_money'],
					'es_7_money'   => $_GPC['es_7_money']
				);
				$result  = pdo_update('eu_pinche_setup',$date,"uniacid = ".$_W['account']['uniacid']);
				if (!empty($result)) {
					message('更新成功');
				}else{
					message('更新失败');
				}
			}
			include $this->template('setup');
		}elseif($type==2){
			if($_GPC['act']=='save'){
				$date = array(
					'es_share_title'   => $_GPC['es_share_title'],
					'es_share_content' => $_GPC['es_share_content'],
					'es_share_logo'    => $_GPC['es_share_logo'],
				);
				$result  = pdo_update('eu_pinche_setup',$date,"uniacid = ".$_W['account']['uniacid']);
				if (!empty($result)) {
					message('更新成功');
				}else{
					message('更新失败');
				}
			}
			include $this->template('share');
		}else{
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_remen')." where uniacid = ".$_W['account']['uniacid']);
			include $this->template('remen');
		}
	}
	
	public function doWebRemendel(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$prmid  = $_GPC['prmid'];
		if(empty($prmid)){
			message('prmid不能为空。');
		}
		$result = pdo_delete('eu_pinche_remen', array('uniacid' => $uniacid,'prm_id'=>$prmid),'and');
		if(!empty($result)) {
			message('删除热门线路信息成功',$this->createWebUrl('setup')."&type=1");
		}else{
			message('删除热门线路信息失败');
		}
	}
	
	public function doWebRemenedit(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$prmid  = $_GPC['prmid'];
		$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_remen')." WHERE prm_id ={$prmid} and uniacid = {$uniacid}");
		if($_GPC['act'] == 'save'){
			$date = array(
				'prm_title' => $_GPC['prm_title']
			);
			$result = pdo_update('eu_pinche_remen',$date,"prm_id = {$prmid} and uniacid = {$uniacid}");
			if (!empty($result)) {
				message('修改成功',$this->createWebUrl('setup')."&type=1");
			}else{
				message('修改失败');
			}
		}
		include $this->template('remenedit');	
	}
	
	public function doWebRemenadd(){
		global $_W,$_GPC;
		if($_GPC['act'] == 'save'){
			$date = array(
				'uniacid'   => $_W['account']['uniacid'],
				'prm_title' => $_GPC['prm_title']
			);
			$result = pdo_insert('eu_pinche_remen',$date);
			if (!empty($result)) {
				message('添加成功',$this->createWebUrl('setup')."&type=1");
			}else{
				message('添加失败');
			}
		}
		include $this->template('remenadd');
	}
	
	public function doWebuserdel(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$pcu_id  = $_GPC['pcuid'];
		if(empty($pcu_id)){
			message('pcuid不能为空。');
		}
		$result = pdo_delete('eu_pinche_user', array('uniacid' => $uniacid,'pcu_id'=>$pcu_id),'and');
		if(!empty($result)) {
			pdo_delete('eu_pinche_money', array('uniacid' => $uniacid,'pcu_id'=>$pcu_id));
			message('删除用户信息成功',$this->createWebUrl('user'));
		}else{
			message('删除用户信息失败');
		}
	}
	
	public function doWebUser() {
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		if(empty($_GPC['pcuid'])){
			$user = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_user')." where uniacid = {$uniacid}");
			include $this->template('user');
		}else{
			if($_GPC['act'] == 'save'){

				$money   = $_GPC['pcu_money'];
				$content = $_GPC['es_openmoney'];
				$pcu_id  = $_GPC['pcu_id'];
				$type    = $_GPC['type'];
				$balance = 0;
				if(empty($money)){
					message('金额不能为空');
				}
				if(empty($content)){
					message('内容不能为空');
				}
				
				$user = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_user')." WHERE pcu_id ={$_GPC['pcuid']} and uniacid = {$uniacid}");
				if($type==2){
					if($user['pcu_money']<$money){
						message('减少金额不能小于用户余额');
					}
					$balance = $user['pcu_money'] - $money;
				}else{
					$balance = $user['pcu_money'] + $money;
				}
				$date = array(
					'uniacid'     => $uniacid,
					'pcu_id'      => $pcu_id,
					'pcm_type'    => $type,
					'pcm_addtime' => date('Y-m-d H:i:s'),
					'pcm_money'   => $money,
					'pcm_balance' => $balance,
					'pcm_content' => $content
				);
				$result = pdo_insert('eu_pinche_money',$date);
				if (!empty($result)) {
					$dates = array(
						'pcu_money' => $balance
					);
					pdo_update('eu_pinche_user',$dates,"pcu_id ={$_GPC['pcuid']} and uniacid = {$uniacid}");
					message('添加成功',$this->createWebUrl('user'));
				}else{
					message('添加失败');
				}
			}else{
				$user = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_user')." WHERE pcu_id ={$_GPC['pcuid']} and uniacid = {$uniacid}");
				include $this->template('usermoney');
			}
		}	
	}
	
	public function doWebMoneylog() {
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$type = $_GPC['type'];
		if(!empty($_GPC['pcuid'])){
			$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_user')." WHERE pcu_id ={$_GPC['pcuid']} and uniacid = {$uniacid}");
			$user = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_money')." where pcu_id = {$_GPC['pcuid']} and uniacid = {$uniacid}");
		}else{
			if(empty($type)){
				$user = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_money')." where uniacid = {$uniacid}");
			}elseif($type==1){
				$user = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_money')." where uniacid = {$uniacid} and pcm_type = 1");
			}elseif($type==2){
				$user = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_money')." where uniacid = {$uniacid} and pcm_type = 2");
			}
		}
		include $this->template('moneylog');
	}
	
	public function doWebInfo() {
		global $_W,$_GPC;
		$type = $_GPC['type'];
		$uniacid = $_W['account']['uniacid'];
		if(empty($type)){
			//当前运行
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." info
																			left join ".tablename('eu_pinche_user')." user on info.pcu_id = user.pcu_id
																			where info.uniacid = {$uniacid} and info.pci_show_flag = 2 and DATE_FORMAT(NOW(),'%Y %m %d %H:%i') < DATE_FORMAT(info.pci_chuaddtime,'%Y %m %d %H:%i')");	
		}elseif($type==1){
			//过期
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." info
																			left join ".tablename('eu_pinche_user')." user on info.pcu_id = user.pcu_id
																			where info.uniacid = {$uniacid} and info.pci_show_flag = 2 and DATE_FORMAT(NOW(),'%Y %m %d %H:%i') > DATE_FORMAT(info.pci_chuaddtime,'%Y %m %d %H:%i')");
		}elseif($type==2){
			//审核中
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." info
																			left join ".tablename('eu_pinche_user')." user on info.pcu_id = user.pcu_id
																			where info.uniacid = {$uniacid} and info.pci_show_flag = 1");
		}elseif($type==3){
			//拒绝
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." info
																			left join ".tablename('eu_pinche_user')." user on info.pcu_id = user.pcu_id
																			where info.uniacid = {$uniacid} and info.pci_show_flag = 3");
		}elseif($type==4){
			//置顶
			$info = pdo_fetchall("SELECT * FROM ".tablename('eu_pinche_info')." info
																			left join ".tablename('eu_pinche_user')." user on info.pcu_id = user.pcu_id
																			where info.uniacid = {$uniacid} and info.pci_top > 0");
		}

		include $this->template('info');
	}
	
	//置顶拼车信息
	public function doWebTop(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$pciid   = $_GPC['pciid'];
		if($_GPC['act'] == 'save'){
			//$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." WHERE pci_id ={$pciid} and uniacid = {$uniacid}");
			$date = array(
				'pci_top'     => $_GPC['pci_top'],
				'pci_toptime' => date('Y-m-d H:i:s',strtotime('+'.$_GPC['pci_top'].' day'))
			);
			$result = pdo_update('eu_pinche_info',$date,"uniacid = {$uniacid} and pci_id = '{$pciid}'");
			if (!empty($result)) {
				message('更新成功',$this->createWebUrl('info'));
			}else{
				message('更新失败');
			}
		}
		include $this->template('info_top');
	}
	
	//删除拼车信息
	public function doWebinfodel(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$pciid   = $_GPC['pciid'];
		if(empty($pciid)){
			message('pciid不能为空');
		}
		$result = pdo_delete('eu_pinche_info', array('uniacid' => $uniacid,'pci_id'=>$pciid),'and');
		if(!empty($result)) {
			message('删除拼车信息成功',$this->createWebUrl('info')."&type=".$_GPC['type']);
		}else{
			message('删除拼车信息失败');
		}
	}
	
	//审核拼车信息
	public function doWebinfosh(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$pciid   = $_GPC['pciid'];
		if($_GPC['act'] == 'save'){
			$date = array(
				'pci_show_flag' => $_GPC['pci_show_flag']
			);
			$result = pdo_update('eu_pinche_info',$date,"uniacid = {$uniacid} and pci_id = '{$pciid}'");
			if (!empty($result)) {
				message('审核成功',$this->createWebUrl('info'));
			}else{
				message('审核失败');
			}
		}
		include $this->template('info_sh');
	}
	
	//编辑拼车信息
	public function doWebinfoedit(){
		global $_W,$_GPC;
		$uniacid = $_W['account']['uniacid'];
		$pciid   = $_GPC['pciid'];
		if($_GPC['act'] == 'save'){
			$date = array(
				'pci_type'       => $_GPC['pci_type'],
				'pci_chuaddress' => $_GPC['pci_chuaddress'],
				'pci_muaddress'  => $_GPC['pci_muaddress'],
				'pci_tuaddress'  => $_GPC['pci_tuaddress'],
				'pci_phone'      => $_GPC['pci_phone'],
				'pci_count'      => $_GPC['pci_count'],
				'pci_content'    => $_GPC['pci_content']
			);
			$result = pdo_update('eu_pinche_info',$date,"uniacid = {$uniacid} and pci_id = '{$pciid}'");
			if (!empty($result)) {
				message('编辑成功');
			}else{
				message('编辑失败');
			}
		}
		$info = pdo_fetch("SELECT * FROM ".tablename('eu_pinche_info')." WHERE pci_id ={$pciid} and uniacid = {$uniacid}");
		include $this->template('info_edit');
	}

}