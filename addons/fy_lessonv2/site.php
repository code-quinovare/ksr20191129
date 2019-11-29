<?php
/**
 * 微课堂模块微站定义
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！已购买用户允许对程序代码进行修改和使用，但是不允许对
 * 程序代码以任何形式任何目的的再发布，作者将保留追究法律责任的权力和最终解
 * 释权。
 * ============================================================================
 */
defined('IN_IA') or exit('Access Denied');

class fy_lessonv2ModuleSite extends WeModuleSite {

    public $table_article = 'fy_lesson_article';
    public $table_blacklist = 'fy_lesson_blacklist';
    public $table_cashlog = 'fy_lesson_cashlog';
    public $table_category = 'fy_lesson_category';
	public $table_lesson_collect = 'fy_lesson_collect';
	public $table_commission_level = 'fy_lesson_commission_level';
	public $table_commission_log = 'fy_lesson_commission_log';
	public $table_commission_setting = 'fy_lesson_commission_setting';
	public $table_coupon = 'fy_lesson_coupon';
    public $table_evaluate = 'fy_lesson_evaluate';
    public $table_lesson_history = 'fy_lesson_history';
	public $table_inform = 'fy_lesson_inform';
	public $table_inform_fans = 'fy_lesson_inform_fans';
	public $table_market = 'fy_lesson_market';
	public $table_mcoupon = 'fy_lesson_mcoupon';
    public $table_member = 'fy_lesson_member';
	public $table_member_coupon = 'fy_lesson_member_coupon';
    public $table_member_order = 'fy_lesson_member_order';
	public $table_member_vip = 'fy_lesson_member_vip';
    public $table_order = 'fy_lesson_order';
    public $table_lesson_parent = 'fy_lesson_parent';
    public $table_playrecord = 'fy_lesson_playrecord';
	public $table_qcloud_upload = 'fy_lesson_qcloud_upload';
	public $table_qiniu_upload = 'fy_lesson_qiniu_upload';
    public $table_recommend = 'fy_lesson_recommend';
    public $table_setting = 'fy_lesson_setting';
    public $table_lesson_son = 'fy_lesson_son';
	public $table_lesson_spec = 'fy_lesson_spec';
	public $table_static = 'fy_lesson_static';
    public $table_syslog = 'fy_lesson_syslog';
    public $table_teacher = 'fy_lesson_teacher';
    public $table_teacher_income = 'fy_lesson_teacher_income';
	public $table_tplmessage = 'fy_lesson_tplmessage';
    public $table_vip_level = 'fy_lesson_vip_level';
    public $table_vipcard = 'fy_lesson_vipcard';
	public $table_mc_members = 'mc_members';
	public $table_fans = 'mc_mapping_fans';
    public $table_core_cache = 'core_cache';
    public $table_users = 'users';

/***************************** 初始化 ******************************** */
    function __construct() {
        global $_W, $_GPC;

        /* 关闭超时未付款订单 */
        $this->checknopay();
    }

/*****************************   WEB方法  ******************************** */
    /* 课程分类 */
    public function doWebCategory() {
        $this->__web(__FUNCTION__);
    }

    /* 推荐模块 */
    public function doWebRecommend() {
        $this->__web(__FUNCTION__);
    }

    /* 课程管理 */
    public function doWebLesson() {
        $this->__web(__FUNCTION__);
    }

    /* 讲师管理 */
    public function doWebTeacher() {
        $this->__web(__FUNCTION__);
    }

    /* 课程订单管理 */
    public function doWebOrder() {
        $this->__web(__FUNCTION__);
    }

    /* 会员VIP订单管理 */
    public function doWebViporder() {
        $this->__web(__FUNCTION__);
    }

    /* 评价管理 */
    public function doWebEvaluate() {
        $this->__web(__FUNCTION__);
    }

    /* 基本设置 */
    public function doWebSetting() {
        $this->__web(__FUNCTION__);
    }

    /* 分销(成员)管理 */
    public function doWebAgent() {
        $this->__web(__FUNCTION__);
    }

    /* 佣金申请管理 */
    public function doWebCommission() {
        $this->__web(__FUNCTION__);
    }

    /* 我的团队 */
    public function doWebteam() {
        $this->__web(__FUNCTION__);
    }

    /* 分销设置 */
    public function doWebComsetting() {
        $this->__web(__FUNCTION__);
    }

    /* 文章公告 */
    public function doWebArticle() {
        $this->__web(__FUNCTION__);
    }

    /* 日志管理 */
    public function doWebSyslog() {
        $this->__web(__FUNCTION__);
    }

	/* 财务管理 */
    public function doWebFinance() {
        $this->__web(__FUNCTION__);
    }
	
	/* 退款操作 */
    public function doWebRefund() {
        $this->__web(__FUNCTION__);
    }

	/* 营销管理 */
	public function doWebMarket() {
        $this->__web(__FUNCTION__);
    }

    /* 讲师课表 */
    public function doWebTeacherclass() {
        $this->__web(__FUNCTION__);
    }

	/* 查找课程或会员 */
	public function doWebGetlessonOrMember(){
		$this->__web(__FUNCTION__);
	}

	/* 视频管理 */
	public function doWebVideo(){
		$this->__web(__FUNCTION__);
	}

	public function doWebTest(){
		$this->__web(__FUNCTION__);
	}

/***************************** Mobile方法 ******************************** */
    /* APP首页 */
    public function doMobileIndex() {
        $this->__mobile(__FUNCTION__);
    }

    /* 课程搜索页 */
    public function doMobileSearch() {
        $this->__mobile(__FUNCTION__);
    }

    /* 课程详情 */
    public function doMobileLesson() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师课程 */
    public function doMobileTeacher() {
        $this->__mobile(__FUNCTION__);
    }

    /* 个人中心 */
    public function doMobileSelf() {
        $this->__mobile(__FUNCTION__);
    }

    /* VIP服务 */
    public function doMobileVip() {
        $this->__mobile(__FUNCTION__);
    }

    /* 我的课程 */
    public function doMobileMylesson() {
        $this->__mobile(__FUNCTION__);
    }

    /* 我的足迹 */
    public function doMobileHistory() {
        $this->__mobile(__FUNCTION__);
    }

    /* 我的收藏 */
    public function doMobileCollect() {
        $this->__mobile(__FUNCTION__);
    }

    /* 收藏讲师或课程 */
    public function doMobileUpdatecollect() {
        $this->__mobile(__FUNCTION__);
    }

	/* 确认下单 */
    public function doMobileConfirm() {
        $this->__mobile(__FUNCTION__);
    }

    /* 添加课程订单 */
    public function doMobileAddtoorder() {
        $this->__mobile(__FUNCTION__);
    }

    /* 评价课程 */
    public function doMobileEvaluate() {
        $this->__mobile(__FUNCTION__);
    }

    /* 支付信息核对 */
    public function doMobilePay() {
        $this->__mobile(__FUNCTION__);
    }

    /* 分销中心 */
    public function doMobileCommission() {
        $this->__mobile(__FUNCTION__);
    }

    /* 二维码推广 */
    public function doMobileQrcode() {
        $this->__mobile(__FUNCTION__);
    }

	/* 二维码推广 - 带参数 */
    public function doMobileQrcodes() {
        $this->__mobile(__FUNCTION__);
    }

    /* 我的团队 */
    public function doMobileteam() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师列表 */
    public function doMobileTeacherlist() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师中心 */
    public function doMobileTeachercenter() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师收入 */
    public function doMobileIncome() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师收入提现 */
    public function doMobileLessoncash() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师收入提现记录 */
    public function doMobileLessoncashlog() {
        $this->__mobile(__FUNCTION__);
    }

    /* 申请讲师 */
    public function doMobileApplyteacher() {
        $this->__mobile(__FUNCTION__);
    }

    /* 二维码页面 */
    public function doMobileFollow() {
        $this->__mobile(__FUNCTION__);
    }

    /* 文章公告 */
    public function doMobileArticle() {
        $this->__mobile(__FUNCTION__);
    }

    /* 播放记录 */
    public function doMobileRecord() {
        $this->__mobile(__FUNCTION__);
    }

    /* 完善手机号码、姓名 */
    public function doMobileWritemsg() {
        $this->__mobile(__FUNCTION__);
    }

	/* 验证 */
    public function doMobileVerify() {
        $this->__mobile(__FUNCTION__);
    }

	/* 非微信端访问提示 */
    public function doMobileError() {
        $this->__mobile(__FUNCTION__);
    }

	/* 会员优惠券 */
    public function doMobileCoupon() {
        $this->__mobile(__FUNCTION__);
    }

	/* 优惠券中心 */
    public function doMobileGetcoupon() {
        $this->__mobile(__FUNCTION__);
    }

	/* 定时任务 */
    public function doMobileCrontab() {
        $this->__mobile(__FUNCTION__);
    }

	/* 开课提醒 */
    public function doMobileNotice() {
        $this->__mobile(__FUNCTION__);
    }

    /* 讲师课表 */
    public function doMobileTeacherclass() {
        $this->__mobile(__FUNCTION__);
    }

	/* 分享课程赠送优惠券 */
	public function doMobileSharecoupon(){
		$this->__mobile(__FUNCTION__);
	}

	/* 短信验证码 */
	public function doMobileSendcode(){
		$this->__mobile(__FUNCTION__);
	}

	/* 异步上传图片 */
	public function doMobileAjaxuploadimage(){
		global $_W;

		load()->func('file');
		$res = file_upload($_FILES['uploadFile']);

		//按比例压缩图片
		$imagePath = ATTACHMENT_ROOT."/".$res['path'];
        $this->resize($imagePath, $imagePath, "400", "400", "80");

		if (!empty($_W['setting']['remote']['type'])) {
			$remotestatus = file_remote_upload($res['path']);
			if (is_error($remotestatus)) {
				exit(json_encode("远程附件上传失败，请联系管理员检查配置"));
			}
		}

		exit(json_encode($res));
	}

/************************************************ 公共方法 ************************************ */
    public function __web($f_name) {
        global $_W, $_GPC;
		$versions = "2.4.0";
        $uniacid = $_W['uniacid'];
        $op = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';

        $setting = $this->readCache(1);    /* 基本设置 */
		$comsetting = $this->readCache(2); /* 分销设置 */

        include_once 'web/' . strtolower(substr($f_name, 5)) . '.php';
    }

    public function __mobile($f_name) {
        global $_W, $_GPC;
		$versions = "2.4.0";
        $uniacid = $_W['uniacid'];
        $op = $operation = $_GPC['op'] ? $_GPC['op'] : 'display';
		
		$setting = $this->readCache(1);    /* 基本设置 */
		$comsetting = $this->readCache(2); /* 分销设置 */
		$font = json_decode($comsetting['font'], true);
		$config = $this->module['config'];

		/* 检查是否允许非微信端访问 */
		if($setting['visit_limit']==0 && $_GPC['do']!='error'){
			$agent = $this->checkUserAgent();
			$dos = array('crontab', 'notice');

			if(!$agent && !in_array($_GPC['do'], $dos)){
				header("Location:".$this->createMobileUrl('error'));
			}
		}

        include_once 'mobile/' . strtolower(substr($f_name, 8)) . '.php';

		$this->updatelessonmember();
    }

    /* 支付返回确认 */
    public function payResult($params) {
        global $_W, $_GPC;
        $orderid = $params['tid'];

		//load()->func('logging');
		//logging_run('订单id:'.$orderid.',参数：'.print_r($params, true), 'info', 'fylessonv2_payresult');

        /* 购买VIP订单 */
        $viporder = pdo_fetch("SELECT * FROM " .tablename($this->table_member_order). " WHERE id=:id", array(':id'=>$orderid));
        /* 购买课程订单 */
        $lessonorder = pdo_fetch("SELECT * FROM " .tablename($this->table_order). " WHERE id=:id", array(':id'=>$orderid));
        $uniacid = $viporder['uniacid'] ? $viporder['uniacid'] : $lessonorder['uniacid'];
		$uid = $viporder['uid'] ? $viporder['uid'] : $lessonorder['uid'];
		
		$lessonmember = pdo_fetch("SELECT a.*,b.openid FROM " . tablename($this->table_member) . " a LEFT JOIN ".tablename($this->table_fans)." b ON a.uid=b.uid WHERE a.uniacid=:uniacid AND a.uid=:uid", array(':uniacid'=>$uniacid,':uid'=>$uid));

        $setting = $this->readCache(1);   /* 基本设置 */
		$comsetting = $this->readCache(2);/* 分销设置 */

        if (!empty($viporder)) {
            if ((($params['result'] == 'success' && $params['from'] == 'notify') || $params['type'] == 'credit') && $viporder['status'] == 0) {
                /* 支付成功逻辑操作 */
                $data = array('status' => $params['result'] == 'success' ? 1 : 0);
				if(!empty($params['type'])){
					$data['paytype'] = $params['type'];
				}else{
					$data['paytype'] = $params['trade_type'] ? 'wechat' : '';
				}
                
                $data['paytime'] = time();
                if (pdo_update($this->table_member_order, $data, array('id' => $orderid))) {
                    /* 更新用户VIP有效期 */
					$validity = $this->updateVipValidity($uniacid, $lessonmember, $viporder);
					
					/* 订单金额加入今日销售额汇总表 */
					$this->staticAmount($uniacid, 1, $viporder['vipmoney']);
					
					/* 判断分销员状态变化 */
					$this->checkAgentStatus($lessonmember, $comsetting, $viporder['vipmoney']);
					
                    /* 一级佣金 */
                    if ($viporder['member1'] > 0 && $viporder['commission1'] > 0) {
                    	$this->sendCommissionToUser($uniacid, $viporder['member1'], $lessonmember, 1, $setting, $viporder, $viporder['commission1'], 1);
                    }
					
					/* 二级佣金 */
                    if ($viporder['member2'] > 0 && $viporder['commission2'] > 0) {
						$this->sendCommissionToUser($uniacid, $viporder['member2'], $lessonmember, 1, $setting, $viporder, $viporder['commission2'], 2);
                    }

					/* 三级佣金 */
                    if ($viporder['member3'] > 0 && $viporder['commission3'] > 0) {
                    	$this->sendCommissionToUser($uniacid, $viporder['member3'], $lessonmember, 1, $setting, $viporder, $viporder['commission3'], 3);
                    }
					
					/* 购买成功模版消息通知用户 */
					$this->sendMessageToUser($uniacid, $setting, $viporder, 1, $validity);
					/* 新VIP订单提醒(管理员) */
					$this->sendOrderMessageToAdmin($setting, $viporder, 1);
					/* 更新会员vip字段 */
					$this->updateMemberVip($uid, 1);

					/* 赠送积分操作 */
                    if ($viporder['integral'] > 0) {
                    	$this->handleUserIntegral($type=1, $viporder['ordersn'], $viporder['uid'], $viporder['integral']);
                    }
                }
            }

            if ($params['from'] == 'return') {
                message("购买成功", $this->createMobileUrl('vip', array('ispay'=>1)), 'success');
            }
        } elseif (!empty($lessonorder)) {
            if ((($params['result'] == 'success' && $params['from'] == 'notify') || $params['type'] == 'credit' || $params['fee'] == 0) && $lessonorder['status'] == 0) {
                /* 支付成功逻辑操作 */
                $data = array('status' => $params['result'] == 'success' ? 1 : 0);
                if(!empty($params['type'])){
					$data['paytype'] = $params['type'];
				}else{
					$data['paytype'] = $params['trade_type'] ? 'wechat' : '';
				}

                $data['paytime'] = time();
				if($lessonorder['validity']>0){
					$data['validity'] = time()+86400*$lessonorder['validity'];
				}
                if (pdo_update($this->table_order, $data, array('id' => $orderid))) {
                    /* 增加课程购买人数和减少库存 */
                    $this->updateLessonNumber($lessonorder, $setting);
					
					/* 订单金额加入今日销售额汇总表 */
					$this->staticAmount($uniacid, 2, $lessonorder['price']);
					
					/* 判断分销员状态变化 */
					$this->checkAgentStatus($lessonmember, $comsetting, $lessonorder['price']);
					
                    /* 一级佣金 */
                    if ($lessonorder['member1'] > 0 && $lessonorder['commission1'] > 0) {
                    	$this->sendCommissionToUser($uniacid, $lessonorder['member1'], $lessonmember, 2, $setting, $lessonorder, $lessonorder['commission1'], 1);
                    }
					
					/* 二级佣金 */
                    if ($lessonorder['member2'] > 0 && $lessonorder['commission2'] > 0) {
                        $this->sendCommissionToUser($uniacid, $lessonorder['member2'], $lessonmember, 2, $setting, $lessonorder, $lessonorder['commission2'], 2);
                    }
					
					/* 三级佣金 */
                    if ($lessonorder['member3'] > 0 && $lessonorder['commission3'] > 0) {
                        $this->sendCommissionToUser($uniacid, $lessonorder['member3'], $lessonmember, 2, $setting, $lessonorder, $lessonorder['commission3'], 3);
                    }
					
                    /* 讲师分成 */
                    if ($lessonorder['price'] > 0 && $lessonorder['teacher_income'] > 0) {
                        $this->sendCommissionToTeacher($uniacid, $lessonorder, $setting);
                    }
					
                    
					/* 购买成功模版消息通知用户 */
					$this->sendMessageToUser($uniacid, $setting, $lessonorder, 2, $validity="");
					/* 新课程订单提醒(管理员) */
					$this->sendOrderMessageToAdmin($setting, $lessonorder, 2);
					
                    /* 赠送积分操作 */
                    if ($lessonorder['integral'] > 0) {
                    	$this->handleUserIntegral($type=2, $lessonorder['ordersn'], $lessonorder['uid'], $lessonorder['integral']);
                    }

					/* 给用户发放优惠券 */
					$this->sendCouponByBuyLesson($lessonmember, $setting);
                }
            }

            if ($params['from'] == 'return') {
                message("购买课程成功！", $this->createMobileUrl('lesson', array('id'=>$lessonorder['lessonid'], 'ispay'=>1)), 'success');
            }
        }
    }

	/* VIP订单支付成功，更新用户VIP时长
	 * $uniacid 公众号id
	 * $lessonmember 微课堂会员信息
	 * $order 订单信息
	 * return 会员VIP有效期
	 **/
	private function updateVipValidity($uniacid, $lessonmember, $order){
		$memberVip = pdo_fetch("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND level_id=:level_id", array(':uid'=>$order['uid'],':level_id'=>$order['level_id']));
		$newLevel = pdo_fetch("SELECT discount FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$order['level_id']));
		if(!empty($memberVip)){
			if(time()>=$memberVip['validity']){
				$vipData = array(
					'validity' => time()+$order['viptime']*86400,
					'discount'=> $newLevel['discount'],
					'update_time' => time(),
				);
			}else{
				$vipData = array(
					'validity' => $memberVip['validity']+$order['viptime']*86400,
					'discount'=> $newLevel['discount'],
					'update_time' => time(),
				);
			}
			pdo_update($this->table_member_vip, $vipData, array('id'=>$memberVip['id']));
		}else{
			$vipData = array(
				'uniacid' => $uniacid,
				'uid'	  => $order['uid'],
				'level_id'=> $order['level_id'],
				'validity'=> time()+$order['viptime']*86400,
				'discount'=> $newLevel['discount'],
				'addtime' => time(),
			);
			pdo_insert($this->table_member_vip, $vipData);
		}

		return $vipData['validity'];
	}

	/* 订单金额加入今日销售额汇总表
	 * $uniacid 公众号id
	 * $type 订单类型 1.VIP订单 2.课程订单
	 * $orderAmount 订单金额
	 */
	private function staticAmount($uniacid, $type, $orderAmount){
		$today= strtotime("today");
		$exit = pdo_fetch("SELECT * FROM " .tablename($this->table_static). " WHERE uniacid=:uniacid AND static_time=:static_time", array(':uniacid'=>$uniacid,':static_time'=>$today));
		if(empty($exit)){
			if($type==1){
				$staticData = array(
					'uniacid' 		  => $uniacid,
					'vipOrder_num'    => 1,
					'vipOrder_amount' => $orderAmount,
					'static_time'     => $today
				);
			}elseif($type==2){
				$staticData = array(
					'uniacid' 		     => $uniacid,
					'lessonOrder_num'    => 1,
					'lessonOrder_amount' => $orderAmount,
					'static_time'        => $today
				);
			}
			pdo_insert($this->table_static, $staticData);
		}else{
			if($type==1){
				$staticData = array(
					'vipOrder_num'    => $exit['vipOrder_num']+1,
					'vipOrder_amount' => $exit['vipOrder_amount']+$orderAmount,
				);
			}elseif($type==2){
				$staticData = array(
					'lessonOrder_num'    => $exit['lessonOrder_num']+1,
					'lessonOrder_amount' => $exit['lessonOrder_amount']+$orderAmount,
				);
			}
			pdo_update($this->table_static, $staticData, array('uniacid'=>$uniacid,'static_time'=>$today));
		}		
	}

	/* 发放佣金操作 
	 * $uniacid 公众号id
	 * $uid 用户id
	 * $lessonmember 用户信息
	 * $type 1.vip订单 2.课程订单
	 * $setting 全局配置信息
	 * $order 订单信息
	 * $commission 佣金
	 * $level 佣金级别 1.一级佣金 2.二级佣金 3.三级佣金
	 */
	private function sendCommissionToUser($uniacid, $uid, $lessonmember, $type, $setting, $order, $commission, $level){
		global $_W;
		$comsetting = $this->readCache(2); /* 分销设置 */

		if($type==1){
			$comtype = "VIP";
			$orderContent = "[{$order['level_name']}]服务-{$order['viptime']}天";
		}elseif($type==2){
			$comtype = "课程";
			$orderContent = "课程：《{$order['bookname']}》";
		}
		
		$member = pdo_fetch("SELECT openid FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$uid));
		$customer =  pdo_fetch("SELECT nickname FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$order['uid']));
		$tplmessage = pdo_fetch("SELECT cnotice FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

        $senddata = array(
            'openid' 	  => $member['openid'],
            'cnotice' 	  => $tplmessage['cnotice'],
            'url' 		  => $_W['siteroot'] . "app/index.php?i={$uniacid}&c=entry&op=commissionlog&do=commission&m=fy_lessonv2",
            'first' 	  => "您获得了一笔新的{$comtype}分销佣金。",
            'keyword1' 	  => "{$commission}元",
            'keyword2' 	  => date("Y-m-d H:i:s", time()),
            'remark' 	  => "下级成员：{$customer['nickname']}\r\n消费内容：{$orderContent}\r\n详情请进入分销中心查看佣金明细。",
        );
        if ($comsetting['sale_rank'] == 2) {/* VIP身份才可获得佣金 */
        	$memberVip = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$uid,':validity'=>time()));
            if (!empty($memberVip)) {
                $this->changecommisson($order, "{$orderContent}分销订单", $uid, $commission, $level, $level."级佣金:订单号" . $order['ordersn'], $senddata);
            } else {
            	if($level==1){
            		pdo_update($this->table_member_order, array('commission1' => 0), array('id' => $order['id']));
            	}elseif($level==2){
            		pdo_update($this->table_member_order, array('commission2' => 0), array('id' => $order['id']));
            	}elseif($level==3){
            		pdo_update($this->table_member_order, array('commission3' => 0), array('id' => $order['id']));
            	}
            }
        } else {
            $this->changecommisson($order, "{$orderContent}分销订单", $uid, $commission, $level, $level."级佣金:订单号" . $order['ordersn'], $senddata);
        }
	}
	
	/* 
	 * 新订单提醒管理员
	 * $setting 全局配置参数
	 * $order 订单信息
	 * $type 订单类型 1.VIP订单  2.课程订单
	 */
	private function sendOrderMessageToAdmin($setting, $order, $type){
		if($type==1){
			$comtype = "VIP";
			$orderContent = "开通/续费[{$order['level_name']}]服务-{$order['viptime']}天";
			$amount = $order['vipmoney'];
		}elseif($type==2){
			$comtype = "课程";
			$orderContent = "课程：《{$order['bookname']}》";
			$amount = $order['price'];
			$paytype = $order['coupon_amount'] ? "(优惠券已抵扣".$order['coupon_amount']."元)" : "";
		}
		
		$manage = explode(",", $setting['manageopenid']);
		$tplmessage = pdo_fetch("SELECT neworder FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$setting['uniacid']));
        foreach ($manage as $manageopenid) {
            $sendneworder = array(
                'touser' => $manageopenid,
                'template_id' => $tplmessage['neworder'],
                'url' => "",
                'topcolor' => "#7B68EE",
                'data' => array(
                    'first' => array(
                        'value' => "您有一条新的{$comtype}订单消息",
                        'color' => "#428BCA",
                    ),
                    'keyword1' => array(
                        'value' => $order['ordersn'],
                        'color' => "#428BCA",
                    ),
                    'keyword2' => array(
                        'value' => "{$amount} 元{$paytype}",
                        'color' => "#428BCA",
                    ),
                    'keyword3' => array(
                        'value' => $orderContent,
                        'color' => "#428BCA",
                    ),
                    'remark' => array(
                        'value' => "详情请登录网站后台查看！",
                        'color' => "#222222",
                    ),
                )
            );
            $this->send_template_message(urldecode(json_encode($sendneworder)), $order['acid']);
        }
	}

	/*
	 * 支付订单成功通知用户 
	 * $uniacid 公众号id
	 * $setting 全局配置参数
	 * $order 订单信息
	 * $type 订单类型 1.VIP订单  2.课程订单
	 * $validity VIP有效期
	 */
	 public function sendMessageToUser($uniacid, $setting, $order, $type, $validity){
	 	global $_W;

	 	if($type==1){
	 		$url = $_W['siteroot'] . "app/index.php?i={$uniacid}&c=entry&do=vip&m=fy_lessonv2";
			$orderContent = "开通/续费[{$order['level_name']}]服务-{$order['viptime']}天";
			$remark = "\n有效期至：" . date('Y-m-d H:i:s', $validity);
		}elseif($type==2){
			$url = $_W['siteroot'] . "app/index.php?i={$uniacid}&c=entry&do=mylesson&m=fy_lessonv2";
			$orderContent = "课程：《{$order['bookname']}》";
		}
		
		$fans = pdo_fetch("SELECT openid FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$order['uid']));
		$tplmessage = pdo_fetch("SELECT buysucc FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

	 	$sendmessage = array(
            'touser' => $fans['openid'],
            'template_id' => $tplmessage['buysucc'],
            'url' => $url,
            'topcolor' => "#7B68EE",
            'data' => array(
                'name' => array(
                    'value' => $orderContent,
                    'color' => "#26b300",
                ),
                'remark' => array(
                    'value' => $remark,
                    'color' => "#e40606",
                ),
            )
        );
        $this->send_template_message(urldecode(json_encode($sendmessage)), $order['acid']);
	 }

	/* 讲师课程佣金处理
	 * $uniacid 公众号id
	 * $lessonid 课程id
	 * $order 订单信息
	 */
	private function sendCommissionToTeacher($uniacid, $order, $setting){
		global $_W;
		$teacher = pdo_fetch("SELECT a.uid,a.teacher,b.openid FROM " .tablename($this->table_teacher). " a LEFT JOIN ".tablename($this->table_fans)." b ON a.uid=b.uid WHERE a.id=:id", array(':id'=>$order['teacherid']));

	    if ($teacher['uid']>0) {
	        $teachermember = pdo_fetch("SELECT id,uid,nopay_lesson FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$teacher['uid']));
	        $nopay_lesson = round($order['price'] * $order['teacher_income'] * 0.01, 2);
	
	        pdo_update($this->table_member, array('nopay_lesson' => $teachermember['nopay_lesson'] + $nopay_lesson), array('uid' => $teacher['uid']));
	
	        $incomedata = array(
	            'uniacid' 		 => $uniacid,
	            'uid' 			 => $teacher['uid'],
	            'teacher' 		 => $teacher['teacher'],
	            'ordersn' 		 => $order['ordersn'],
	            'bookname' 		 => $order['bookname'],
	            'orderprice' 	 => $order['price'],
	            'teacher_income' => $order['teacher_income'],
	            'income_amount'  => $nopay_lesson,
	            'addtime' 		 => time(),
	        );
	        pdo_insert($this->table_teacher_income, $incomedata);

			$tplmessage = pdo_fetch("SELECT cnotice FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));	
	        $sendteacher = array(
	            'openid' 	  => $teacher['openid'],
	            'cnotice' 	  => $tplmessage['cnotice'],
	            'url' 		  => $_W['siteroot'] . "app/index.php?i={$uniacid}&c=entry&do=income&m=fy_lessonv2",
	            'first' 	  => "您的课程《{$order['bookname']}》成功出售，您获得了一笔新的课程佣金。",
	            'keyword1' 	  => $nopay_lesson . "元",
	            'keyword2' 	  => date("Y-m-d H:i:s", time()),
	            'remark' 	  => "详情请进入讲师中心查看课程收入。",
	        );
	        $this->commissionMessage($sendteacher, $order['acid']);
	    }
	}

	/* 用户积分操作
	 * $type 订单类型 1.VIP订单 2.课程订单
	 * $ordersn 订单编号
	 * $uid 用户id（需要操作积分的用户）
	 * $integral 操作积分数额   +.增加  -.减少
	 */
	private function handleUserIntegral($type, $ordersn, $uid, $integral){
		$typeName = $type==1 ? '微课堂VIP订单' : '微课堂课程订单';
		load()->model('mc');
		$log = array(
			'0' => "", /* 操作管理员uid */
			'1' => $typeName."：{$ordersn}", /* 增减积分备注 */
			'2' => 'fy_lessonv2', /* 模块标识 */
			'3' => '', /* 店员uid */
			'4' => '', /* 门店id */
			'5' => '', /* 1(线上操作) 2(系统后台,公众号管理员和操作员) 3(店员) */
		);
        mc_credit_update($uid, 'credit1', $integral, $log);
	}
	
	/* 增加课程购买人数
	 * $order 订单信息
	 * $setting 全局配置信息
	 */
	private function updateLessonNumber($order, $setting){
		$lesson = pdo_fetch("SELECT stock,buynum FROM " . tablename($this->table_lesson_parent) . " WHERE id=:id", array(':id'=>$order['lessonid']));
		$lessonupdate = array(
			'buynum' => $lesson['buynum'] + 1,
		);
        pdo_update($this->table_lesson_parent, $lessonupdate, array('id' => $order['lessonid']));
	}

	/* 减少或增加课程库存
	 * $lessonid 课程id
	 * $change 库存变动数量 正数增加，负数减少
	 */
	private function updateLessonStock($lessonid, $change){
		$lesson = pdo_fetch("SELECT stock FROM " . tablename($this->table_lesson_parent) . " WHERE id=:id", array(':id'=>$lessonid));
		
		pdo_update($this->table_lesson_parent, array('stock'=>$lesson['stock']+$change), array('id' => $lessonid));
	}

    /* 获得佣金模通知 */
    private function commissionMessage($data, $acid) {
		$message = array(
			'touser' => $data['openid'],
			'template_id' => $data['cnotice'],
			'url' => $data['url'],
			'topcolor' => "#e25804",
			'data' => array(
				'first' => array(
					'value' => $data['first'],
					'color' => "#000000",
				),
				'keyword1' => array(
					'value' => $data['keyword1'],
					'color' => "#44B549",
				),
				'keyword2' => array(
					'value' => $data['keyword2'],
					'color' => "#44B549",
				),
				'remark' => array(
					'value' => $data['remark'],
					'color' => "#000000",
				),
			)
		);
		$this->send_template_message(urldecode(json_encode($message)), $acid);
    }

	/* 计算一级代理佣金
	 * $lessoncommission  课程设置的一级佣金比例
	 * $settingcommission 默认级别的一级佣金比例
	 * $price 课程实付金额
	 * $uid 一级代理商会员id
	 */
	public function getAgentCommission1($lessoncommission, $settingcommission, $price, $uid){
		if ($lessoncommission > 0) {
            $commission = round($price * $lessoncommission * 0.01, 2);
        } else {
            /* 查询用户是否属于其他分销代理级别 */
            $member = pdo_fetch("SELECT agent_level FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$uid));
            $com_level = pdo_fetch("SELECT commission1 FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$member['agent_level']));

            if (!empty($com_level['commission1'])) {
                $commission = round($price * $com_level['commission1'] * 0.01, 2);
            } else {
                $commission = round($price * $settingcommission * 0.01, 2);
            }
        }
		return $commission;
	}
	
	/* 计算二级代理佣金
	 * $lessoncommission  课程设置的二级佣金比例
	 * $settingcommission 默认级别的二级佣金比例
	 * $price 课程实付金额
	 * $uid 二级代理商会员id
	 */
	public function getAgentCommission2($lessoncommission, $settingcommission, $price, $uid){
		if ($lessoncommission > 0) {
            $commission = round($price * $lessoncommission * 0.01, 2);
        } else {
            /* 查询用户是否属于其他分销代理级别 */
            $member = pdo_fetch("SELECT agent_level FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$uid));
            $com_level = pdo_fetch("SELECT commission2 FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$member['agent_level']));

            if (!empty($com_level['commission2'])) {
                $commission = round($price * $com_level['commission2'] * 0.01, 2);
            } else {
                $commission = round($price * $settingcommission * 0.01, 2);
            }
        }
		return $commission;
	}
	
	/* 计算三级代理佣金
	 * $lessoncommission  课程设置的三级佣金比例
	 * $settingcommission 默认级别的三级佣金比例
	 * $price 课程实付金额
	 * $uid 三级代理商会员id
	 */
	public function getAgentCommission3($lessoncommission, $settingcommission, $price, $uid){
		if ($lessoncommission > 0) {
            $commission = round($price * $lessoncommission * 0.01, 2);
        } else {
            /* 查询用户是否属于其他分销代理级别 */
            $member = pdo_fetch("SELECT agent_level FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$uid));
            $com_level = pdo_fetch("SELECT commission3 FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$member['agent_level']));

            if (!empty($com_level['commission3'])) {
                $commission = round($price * $com_level['commission3'] * 0.01, 2);
            } else {
                $commission = round($price * $settingcommission * 0.01, 2);
            }
        }
		return $commission;
	}
	 
    /* 检查黑名单 */
    public function check_black_list() {
        global $_W;

        $item = pdo_fetch("SELECT * FROM " . tablename($this->table_blacklist) . " WHERE uniacid=:uniacid AND uid=:uid LIMIT 1", array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid']));

        if (!empty($item)) {
            message('您在黑名单中不能下单，请联系管理员！');
        }
    }

    /* 更新课程用户信息 */
    public function updatelessonmember() {
        global $_W, $_GPC;
        
        $recid = intval($_GPC['uid']) ? intval($_GPC['uid']) : intval($_COOKIE['parentId']); /*推荐人id*/
        $uid = intval($_W['member']['uid']); /*当前用户id*/
        if(empty($uid)){
        	return;
        }
		
		$setting = $this->readCache(1); /* 基本设置 */
		$comsetting = $this->readCache(2); /* 分销设置 */
		
		$member = pdo_fetch("SELECT * FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$uid));
		$recmember = pdo_fetch("SELECT * FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$recid));
		if(!empty($member)){
			/* 如果用户openid为uid且获取到新的openid，则更新openid */
			$this->updateOpenid($member);
			setcookie("parentId");
		}else{
			$mc_member = pdo_fetch("SELECT * FROM " . tablename($this->table_mc_members) . " WHERE uid=:uid", array(':uid'=>$uid));
			if(!empty($mc_member)){
				$tmpno = '';
				for ($i = 0; $i < 7 - strlen($uid); $i++) {
					$tmpno .= 0;
				}
				$insertarr = array(
					'uniacid' => $_W['uniacid'],
					'uid' => $uid,
					'studentno' => $tmpno . $uid,
					'openid' => !is_numeric($_W['openid']) && !empty($_W['openid']) ? $_W['openid'] : "",
					'nickname' => $_W['nickname'] ? $_W['nickname'] : $mc_member['nickname'],
					'parentid' => $recmember['status']==1 ? $recmember['uid'] : 0,
					'status' => $comsetting['agent_status'],
					'uptime' => 0,
					'addtime' => time(),
				);
				pdo_insert($this->table_member, $insertarr);
				$source_id = pdo_insertid();
				$member = pdo_fetch("SELECT * FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$uid));
			}
		}
		if($source_id>0){
			/* 新会员注册发放优惠券&&成功推荐下级，给直接推荐人发放优惠券 */
			$this->sendCouponByNewMember($member, $recmember, $setting);
			/* 新下级加入、通知一二三级推荐人 */
			$this->setMemberParentId($member, $recmember, $setting, $source_id);
		}
    }

	/**
	 * 更新用户vip字段
	 */
	 public function updateMemberVip($uid, $vip){
		 return pdo_update($this->table_member, array('vip'=>$vip), array('uid'=>$uid));
	 }

	/* 
	 * 更新课程会员表openid 
	 * $member 课程会员表会员信息
	 */
	private function updateOpenid($member){
		global $_W;
		
		$openid = $_W['openid'];
		/*课程会员表存在会员openid且openid不是数字(uid)*/
		if(!empty($member['openid']) && !is_numeric($member['openid'])){
			return;
		}
		/*当前获取到的全局openid为空或者为数字(uid)*/
		if(empty($openid) || is_numeric($openid)){
			return;
		}

		pdo_update($this->table_member, array('openid'=>$openid), array('uid'=>$member['uid']));
	}

	/*
	 * 设置会员推荐人ID
	 * $member    会员信息
	 * $recmember 推荐人信息
	 * $setting   基本设置信息
	 */
	private function setMemberParentId($member, $recmember, $setting, $source_id){
		/* 分销设置 */
		$comsetting = $this->readCache(2);

		$recid = $recmember['status']==1 ? $recmember['uid'] : 0;
		/*新用户加入通知一级推荐人*/
		if ($comsetting['is_sale'] == 1 && $recid > 0) {
			$this->sendNoticeToMember1($member, $recmember, $setting, $source_id, $comsetting);
		}
		/*新用户加入通知二级推荐人*/
		$recmember2 = pdo_fetch("SELECT * FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$recmember['parentid']));
		if ($comsetting['is_sale'] == 1 && $recmember2['uid'] > 0) {
			$this->sendNoticeToMember2($member, $recmember2, $setting, $comsetting);
		}
		 
		/*新用户加入通知三级推荐人*/
		$recmember3 = pdo_fetch("SELECT * FROM " . tablename($this->table_member) . " WHERE uid=:uid", array(':uid'=>$recmember2['parentid']));
		if ($comsetting['is_sale'] == 1 && $recmember3['uid'] > 0) {
			$this->sendNoticeToMember3($member, $recmember3, $setting, $comsetting);
		}
	}
	
	/* 新用户加入通知一级推荐人 
	 * $member 新用户信息
	 * $recmember 一级推荐人信息
	 * $setting 基本设置信息
	 * $comsetting 分销设置
	 **/
	private function sendNoticeToMember1($member, $recmember, $setting, $source_id, $comsetting){
	 	global $_W;
		
	 	if ($comsetting['level'] >= 1) {
	 		$commission = unserialize($comsetting['commission']);
			$fans = pdo_fetch("SELECT nickname,openid FROM " . tablename('mc_mapping_fans') . "  WHERE uid=:uid", array(':uid'=>$recmember['uid']));
			/* 开启直推下级获得奖励 */
			$rec_income = json_decode($comsetting['rec_income'], true);

			if (floatval($rec_income['credit1']) > 0) {
                load()->model('mc');
				$log = array(0, '直接推荐下级成员加入', 'fy_lessonv2');
				mc_credit_update($recmember['uid'], 'credit1', $rec_income['credit1'], $log);
            }
			if (floatval($rec_income['credit2']) > 0) {
                pdo_update($this->table_member, array('nopay_commission' => $recmember['nopay_commission'] + $rec_income['credit2']), array('uid' => $recmember['uid']));
                $logarr = array(
                    'uniacid' 	=> $_W['uniacid'],
                    'orderid' 	=> $source_id,
                    'uid' 		=> $recmember['uid'],
                    'openid' 	=> $fans['openid'],
                    'nickname' 	=> $fans['nickname'],
                    'bookname' 	=> "推荐下级成员",
                    'change_num' => $rec_income['credit2'],
                    'grade' 	=> 1,
                    'remark' 	=> "直接推荐下级成员加入",
                    'addtime'	=> time(),
                );
                pdo_insert($this->table_commission_log, $logarr);
            }
			
			if ($recmember['agent_level'] > 0) {
                $level = pdo_fetch("SELECT * FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$recmember['agent_level']));
            }
            if ($comsetting['self_sale'] == 1) { /* 开启分销内购，一级分销人拿二级佣金 */
                if (!empty($level)) {
                    $commission = $level['commission2'];
                } else {
                    $commission = $commission['commission2'];
                }
            } else {
                if (!empty($level)) {
                    $commission = $level['commission1'];
                } else {
                    $commission = $commission['commission1'];
                }
            }

			if($comsetting['sale_rank']==2){
				/* 如果获得佣金是VIP身份且推荐人不是VIP身份，则不发送下级加入模版消息通知 */
				$member_vip = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$recmember['uid'], ':validity'=>time()));
				if(empty($member_vip)){
					return;
				}
			}
			$this->sendNewUserNoticeToRecmember($fans['openid'], $setting, $member['nickname'], $commission, $type=1);
		}
	}

	/* 新用户加入通知二级推荐人 
	 * $member 新用户信息
	 * $recmember 二级推荐人信息
	 * $setting 基本设置信息
	 * $comsetting 分销设置
	 **/
	private function sendNoticeToMember2($member, $recmember, $setting, $comsetting){
	 	global $_W;
		
	 	if ($comsetting['level'] >= 2) {
	 		$commission = unserialize($comsetting['commission']);
			$fans = pdo_fetch("SELECT nickname,openid FROM " . tablename('mc_mapping_fans') . "  WHERE uid=:uid", array(':uid'=>$recmember['uid']));
			
			if ($recmember['agent_level'] > 0) {
                $level = pdo_fetch("SELECT * FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$recmember['agent_level']));
            }
            if ($comsetting['self_sale'] == 1) { /* 开启分销内购，一级分销人拿二级佣金 */
                if (!empty($level)) {
                    $commission = $level['commission3'];
                } else {
                    $commission = $commission['commission3'];
                }
            } else {
                if (!empty($level)) {
                    $commission = $level['commission2'];
                } else {
                    $commission = $commission['commission2'];
                }
            }
			$this->sendNewUserNoticeToRecmember($fans['openid'], $setting, $member['nickname'], $commission, $type=2);
		}
	}

	/* 新用户加入通知三级推荐人 
	 * $member 新用户信息
	 * $recmember 三级推荐人信息
	 * $setting 基本设置信息
	 * $comsetting 分销设置
	 **/
	private function sendNoticeToMember3($member, $recmember, $setting, $comsetting){
	 	global $_W;
		
	 	if ($comsetting['level'] >= 3) {
	 		$commission = unserialize($comsetting['commission']);
			$fans = pdo_fetch("SELECT nickname,openid FROM " . tablename('mc_mapping_fans') . "  WHERE uid=:uid", array(':uid'=>$recmember['uid']));
			
			if ($recmember['agent_level'] > 0) {
                $level = pdo_fetch("SELECT * FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$recmember['agent_level']));
            }
            if ($comsetting['self_sale'] == 1) { /* 开启分销内购，一级分销人拿二级佣金 */
                $commission = 0;
            } else {
                if (!empty($level)) {
                    $commission = $level['commission3'];
                } else {
                    $commission = $commission['commission3'];
                }
            }
			$this->sendNewUserNoticeToRecmember($fans['openid'], $setting, $member['nickname'], $commission, $type=3);
		}
	}

	/* 新下级加入 模版消息通知推荐人 
	 * $toOpenid 上级openid
	 * $setting 设置信息
	 * $nickname 下级用户昵称
	 * $commission 佣金比例
	 * $type 等级 1.一级 2.二级 3.三级
	 */
	private function sendNewUserNoticeToRecmember($toOpenid, $setting, $nickname, $commission, $type){
		global $_W;
		if($type==1){
			$level = "一级";
		}elseif($type==2){
			$level = "二级";
		}elseif($type==3){
			$level = "三级";
		}

		$tplmessage = pdo_fetch("SELECT newjoin FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$setting['uniacid']));		
		$send = array(
            'touser' => $toOpenid,
            'template_id' => $tplmessage['newjoin'],
            'url' => $_W['siteroot'] . 'app/' . $this->createMobileUrl('team', array('level' => $type)),
            'topcolor' => "#e25804",
            'data' => array(
                'first' => array(
                    'value' => "恭喜您有新的下级成员加入",
                    'color' => "#000000",
                ),
                'keyword1' => array(
                    'value' => $nickname?$nickname:'未设置',
                    'color' => "#44B549",
                ),
                'keyword2' => array(
                    'value' => $level,
                    'color' => "#44B549",
                ),
                'keyword3' => array(
                    'value' => "下级购买金额的{$commission}%",
                    'color' => "#44B549",
                ),
                'remark' => array(
                    'value' => "您的下级成员每次购买课程时，您将获得课程售价{$commission}%的佣金~",
                    'color' => "#000000",
                ),
            )
        );
        if ($commission > 0) {
            $this->send_template_message(urldecode(json_encode($send)));
        }
	}

	/* 给新注册会员和直接推荐人发放优惠券 
	 * $member 新会员信息
	 * $recmember 推荐人信息
	 * $setting 基本设置信息
	 */
	private function sendCouponByNewMember($member, $recmember, $setting){
		global $_W;
		$uniacid = $_W['uniacid'];

		$market = pdo_fetch("SELECT * FROM " .tablename($this->table_market). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

		$regGive = json_decode($market['reg_give'], true);
		$recommend = json_decode($market['recommend'], true);

		if(!empty($regGive)){
			$regTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member_coupon). " WHERE uid=:uid AND source=:source", array(':uid'=>$recmember['uid'], 'source'=>6));
			if($regTotal>0) return;

			$t = 0;
			foreach($regGive as $item){
				$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE id=:id", array(':id'=>$item));
				if(empty($coupon)) continue;
				$regCoupon = array(
					'uniacid'	  => $uniacid,
					'uid'		  => $member['uid'],
					'amount'      => $coupon['amount'],
					'conditions'  => $coupon['conditions'],
					'validity'	  => $coupon['validity_type']==1 ? $coupon['days1'] : time()+ $coupon['days2']*86400,
					'category_id' => $coupon['category_id'],
					'status'	  => 0, /* 未使用 */
					'source'	  => 6, /* 新会员注册 */
					'coupon_id'	  => $coupon['id'],
					'addtime'	  => time(),
				);
				if(pdo_insert($this->table_member_coupon, $regCoupon)){
					$t++;
				}
			}
			$newFans = pdo_fetch("SELECT openid,nickname FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$member['uid']));
			$tplmessage = pdo_fetch("SELECT receive_coupon FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

			$sendmessage1 = array(
				'touser' => $newFans['openid'],
				'template_id' => $tplmessage['receive_coupon'],
				'url' => $_W['siteroot'] . 'app/' . $this->createMobileUrl('coupon'),
				'topcolor' => "#7B68EE",
				'data' => array(
					'first' => array(
						'value' => $newFans['nickname']."，终于等到您了。系统赠您{$t}张新会员专享优惠券已发放到您的帐号，请您查收。",
						'color' => "#2392EA",
						),
					'keyword1' => array(
						'value' => $newFans['nickname'],
						'color' => "",
					),
					'keyword2' => array(
						'value' => $t." 张",
						'color' => "",
					),
					'keyword3' => array(
						'value' => date('Y年m月d日', time()),
						'color' => "",
					),
					'remark' => array(
						'value' => "点击详情可查看您的帐号优惠券详情哦~",
						'color' => "",
					),
				)
			);
			$this->send_template_message(urldecode(json_encode($sendmessage1)));
		}

		if(!empty($recommend) && !empty($recmember)){
			if($market['recommend_time']>0){
				$recTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member_coupon). " WHERE uid=:uid AND source=:source", array(':uid'=>$recmember['uid'], 'source'=>3));
				if($recTotal >= $market['recommend_time']) return;
			}

			$t = 0;
			foreach($recommend as $item){
				$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE id=:id", array(':id'=>$item));
				if(empty($coupon)) continue;
				$recCoupon = array(
					'uniacid'	  => $uniacid,
					'uid'		  => $recmember['uid'],
					'amount'      => $coupon['amount'],
					'conditions'  => $coupon['conditions'],
					'validity'	  => $coupon['validity_type']==1 ? $coupon['days1'] : time()+ $coupon['days2']*86400,
					'category_id' => $coupon['category_id'],
					'status'	  => 0, /* 未使用 */
					'source'	  => 3, /* 新会员注册 */
					'coupon_id'	  => $coupon['id'],
					'addtime'	  => time(),
				);
				if(pdo_insert($this->table_member_coupon, $recCoupon)){
					$t++;
				}
			}
			$recFans = pdo_fetch("SELECT openid,nickname FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$recmember['uid']));
			$tplmessage = pdo_fetch("SELECT receive_coupon FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

			$sendmessage2 = array(
				'touser' => $recFans['openid'],
				'template_id' => $tplmessage['receive_coupon'],
				'url' => $_W['siteroot'] . 'app/' . $this->createMobileUrl('coupon'),
				'topcolor' => "#7B68EE",
				'data' => array(
					'first' => array(
						'value' => "恭喜您成功推荐下级成员，系统赠您{$t}张优惠券已发放到您的帐号，请注意查收。",
						'color' => "#2392EA",
						),
					'keyword1' => array(
						'value' => $recFans['nickname'],
						'color' => "",
					),
					'keyword2' => array(
						'value' => $t." 张",
						'color' => "",
					),
					'keyword3' => array(
						'value' => date('Y年m月d日', time()),
						'color' => "",
					),
					'remark' => array(
						'value' => "点击详情可查看您的帐号优惠券详情哦~",
						'color' => "",
					),
				)
			);
			$this->send_template_message(urldecode(json_encode($sendmessage2)));
		}
	}

	/* 用户购买课程赠送优惠券 */
	private function sendCouponByBuyLesson($member, $setting){
		global $_W;
		$uniacid = $_W['uniacid'];

		$market = pdo_fetch("SELECT * FROM " .tablename($this->table_market). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));
		$buyLesson = json_decode($market['buy_lesson'], true);

		if(!empty($buyLesson)){
			if($market['buy_lesson_time']>0){
				$buyTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_member_coupon). " WHERE uid=:uid AND source=:source", array(':uid'=>$member['uid'], 'source'=>2));
				if($buyTotal >= $market['buy_lesson_time']) return;
			}

			$t = 0;
			foreach($buyLesson as $item){
				$coupon = pdo_fetch("SELECT * FROM " .tablename($this->table_mcoupon). " WHERE id=:id", array(':id'=>$item));
				if(empty($coupon)) continue;
				$lessonCoupon = array(
					'uniacid'	  => $uniacid,
					'uid'		  => $member['uid'],
					'amount'      => $coupon['amount'],
					'conditions'  => $coupon['conditions'],
					'validity'	  => $coupon['validity_type']==1 ? $coupon['days1'] : time()+ $coupon['days2']*86400,
					'category_id' => $coupon['category_id'],
					'status'	  => 0, /* 未使用 */
					'source'	  => 2, /* 购买课程赠送 */
					'coupon_id'	  => $coupon['id'],
					'addtime'	  => time(),
				);
				if(pdo_insert($this->table_member_coupon, $lessonCoupon)){
					$t++;
				}
			}
			$fans = pdo_fetch("SELECT openid,nickname FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$member['uid']));
			$tplmessage = pdo_fetch("SELECT receive_coupon FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

			$sendmessage = array(
				'touser' => $fans['openid'],
				'template_id' => $tplmessage['receive_coupon'],
				'url' => $_W['siteroot'] . 'app/' . $this->createMobileUrl('coupon'),
				'topcolor' => "#7B68EE",
				'data' => array(
					'first' => array(
						'value' => "恭喜您购买成功，系统赠您{$t}张优惠券已发放到您的帐号，请注意查收。",
						'color' => "#2392EA",
						),
					'keyword1' => array(
						'value' => $fans['nickname'],
						'color' => "",
					),
					'keyword2' => array(
						'value' => $t." 张",
						'color' => "",
					),
					'keyword3' => array(
						'value' => date('Y年m月d日', time()),
						'color' => "",
					),
					'remark' => array(
						'value' => "点击详情可查看您的帐号优惠券详情哦~",
						'color' => "",
					),
				)
			);
			$this->send_template_message(urldecode(json_encode($sendmessage)));
		}
	}
	
    /* 检查未付款订单 */
    public function checknopay() {
		ignore_user_abort(true); 
		set_time_limit(180);

        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $setting = $this->readCache(1); /* 基本设置 */

        /* 判断执行条件 */
        if (time() > $setting['closelast'] + $setting['closespace'] * 60 && $setting['closespace'] != 0) {
            $time = time() - $setting['closespace'] * 60;

            /* 取消指定时间内未支付订单 */
            $nopay_order = pdo_fetchall("SELECT * FROM " . tablename($this->table_order) . " WHERE uniacid='{$uniacid}' AND status=0 AND addtime<'{$time}'");
            foreach ($nopay_order as $item) {
				$order = pdo_fetch("SELECT * FROM " .tablename($this->table_order). " WHERE id=:id AND status=:status", array(':id'=>$item['id'],':status'=>0));
				if(empty($order)) continue;

				if($setting['stock_config']==1){
					$this->updateLessonStock($order['lessonid'], "+1");
				}

                pdo_update($this->table_order, array('status' => '-1'), array('id' => $item['id']));
				if($item['coupon']>0){
					$upcoupon = array(
						'status'	=> 0,
						'ordersn'	=> "",
						'update_time' => "",
					);
					pdo_update($this->table_member_coupon, $upcoupon, array('id'=>$item['coupon']));
				}
				if($item['deduct_integral']>0){
					load()->model('mc');
					mc_credit_update($item['uid'], 'credit1', $item['deduct_integral'], array(0, '取消微课堂订单，sn:'.$item['ordersn']));
				}
            }

            /* 更新执行时间 */
            pdo_update($this->table_setting, array('closelast' => time()), array('id' => $setting['id']));
        }
    }
	
	/* 把推荐人ID写入cookie */	
	public function setParentId($uid){
		if($uid > 0){
			setcookie("parentId", $uid);
		}
	}

    /* 查询上级推荐人 */
    public function getParentid($uid) {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];

        $parent = pdo_fetch("SELECT parentid FROM " . tablename($this->table_member) . " WHERE uniacid='{$uniacid}' AND uid='{$uid}'");

        if (!empty($parent)) {
            return $parent['parentid'];
        } else {
            return '0';
        }
    }

    /**
     * 更新用户佣金和添加日志
     * $order 订单信息
     * $uid 获得佣金会员ID
     * $change_num 变动数目
     * $grade 佣金等级 1.一级佣金 2.二级佣金 3.三级佣金
     * $remark 变动备注说明
	 * $senddata 发送模版消息内容
     */
    private function changecommisson($order, $bookname, $uid, $change_num, $grade, $remark, $senddata) {
        global $_W;

		$comsetting = $this->readCache(2); /* 分销设置 */
		$agentMember = pdo_fetch("SELECT * FROM " .tablename($this->table_member). " WHERE uid=:uid", array(':uid'=>$uid));
		$uniacid = $agentMember['uniacid'];
		
        if ($agentMember['status'] == 1) {
            $memupdate = array();

            /* 查询该分销代理商是否升级 */
			if($comsetting['upgrade_condition']==1){//分销累计佣金
				$total_commission = $agentMember['pay_commission'] + $agentMember['nopay_commission'] + $change_num;
				$upgradeLevel = $this->upgradeAgentLevel($uniacid, $agentMember['agent_level'], $total_commission, $comsetting);
				if(!empty($upgradeLevel)){
					$memupdate['agent_level'] = $upgradeLevel;
				}
			}

            $memupdate['nopay_commission'] = $agentMember['nopay_commission'] + $change_num;
            pdo_update($this->table_member, $memupdate, array('uid' => $agentMember['uid']));

            $member = pdo_fetch("SELECT nickname FROM " . tablename($this->table_mc_members) . " WHERE uid=:uid", array(':uid'=>$uid));
            $logarr = array(
                'uniacid' => $uniacid,
                'orderid' => $order['id'],
                'uid' => $uid,
                'nickname' => $member['nickname'],
                'bookname' => $bookname,
                'change_num' => $change_num,
                'grade' => $grade,
                'remark' => $remark,
                'addtime' => time(),
            );
            pdo_insert($this->table_commission_log, $logarr);
			$this->commissionMessage($senddata, $order['acid']); /* 发放佣金模版消息通知 */
        } else {
            if ($grade == 1) {
                $updatearr['commission1'] = 0;
            } elseif ($grade == 2) {
                $updatearr['commission2'] = 0;
            } elseif ($grade == 3) {
                $updatearr['commission3'] = 0;
            }
            pdo_update($this->table_order, $updatearr, array('id' => $order['id']));
        }
    }

	/* 检查分销商是否升级 */
	private function upgradeAgentLevel($uniacid, $agentLevel, $total_commission, $comsetting){
		$levellist = pdo_fetchall("SELECT * FROM " . tablename($this->table_commission_level) . " WHERE uniacid=:uniacid ORDER BY id ASC", array(':uniacid'=>$uniacid));
		if (!empty($levellist)) {
			/* 分销商升级处理开始 */
			if ($agentLevel == 0) {
				$commission = unserialize($comsetting['commission']);
				if ($commission['updatemoney'] > 0 && $total_commission >= $commission['updatemoney']) {
					foreach ($levellist as $key => $value) {
						if ($value['updatemoney'] > 0 && $total_commission >= $value['updatemoney']) {
							$upgradeLevel = intval($levellist[$key + 1]['id']);
						} else {
							break;
						}
					}
					if (empty($upgradeLevel)) {
						$upgradeLevel = $levellist[0]['id'];
					}
				}
			} else {
				$level = pdo_fetch("SELECT * FROM " . tablename($this->table_commission_level) . " WHERE id=:id", array(':id'=>$agentLevel));
				if ($level['updatemoney'] > 0 && $total_commission >= $level['updatemoney']) {
					foreach ($levellist as $key => $value) {
						if ($value['id'] == $level['id']) {
							$levelkey = $key;
						}
						if ($value['updatemoney'] > 0 && $total_commission >= $value['updatemoney']) {
							$upgradeLevel = intval($levellist[$key + 1]['id']);
						} else {
							break;
						}
					}
					if ($upgradeLevel == $level['id']) {
						$upgradeLevel = $levellist[$levelkey + 1]['id'];
					}
				}
			}

			return $upgradeLevel;
			/* 分销商升级处理结束 */
		}
	}

    /* 发送模版消息 */
    private function send_template_message($messageDatas, $acid = null) {
        global $_W, $_GPC;
        if (empty($acid)) {
            $acid = $_W['account']['acid'];
        }

        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($acid);
        $access_token = $accObj->fetch_token();

        $urls = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $ress = $this->http_request($urls, $messageDatas);

        return json_decode($ress, true);
    }

    /*
     * 添加操作日志
     * $admin_uid		管理员id
     * $admin_username  管理员用户名
     * $log_type		操作类型 1.增加 2.删除 3更新
     * $function		操作的功能
     * $content			操作描述
     */
    public function addSysLog($admin_uid, $admin_username, $log_type, $function, $content) {
        global $_W;
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
        } else if (getenv("REMOTE_ADDR")) {
            $ip = getenv("REMOTE_ADDR");
        } else {
            $ip = $_SERVER["REMOTE_ADDR"];
        }

        $log_data = array(
            'uniacid' => $_W['uniacid'],
            'admin_uid' => $admin_uid,
            'admin_username' => $admin_username,
            'log_type' => $log_type,
            'function' => $function,
            'content' => $content,
            'ip' => $ip,
            'addtime' => time(),
        );
        return pdo_insert($this->table_syslog, $log_data);
    }

    /* https请求（支持GET和POST） */
    private function http_request($url, $messageDatas = null) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($messageDatas)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $messageDatas);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /* 获取远程图片保存到本地 */
    public function saveImage($path, $file_dir, $image_name) {
        if (!preg_match('/\/([^\/]+\.[a-z]{3,4})$/i', $path)) {
            die('获取用户头像失败，请在个人中心检查头像是否正常');
        }

        $ch = curl_init();
        $fp = fopen($file_dir . $image_name, 'wb');

        curl_setopt($ch, CURLOPT_URL, $path);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 120);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    }

	public function downLoadImg($imgPath, $savePath){
		ob_start();
		readfile($imgPath);
		$img = ob_get_contents();
		ob_end_clean();
		$fp2 = @fopen($savePath,'a');
		fwrite($fp2,$img);
		fclose($fp2);		
	}

    private function object_array($array) {
        if (is_object($array)) {
            $array = (array) $array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }

    /**
     * 上传图片
     */
    private function uploadpic($upfile) {
		global $_W;

		load()->func('file');
		$result = file_upload($upfile);

		if($result['success']!=1){
			message("上传图片失败");
		}

		//按比例压缩图片
		$imagePath = ATTACHMENT_ROOT."/".$result['path'];
        $this->resize($imagePath, $imagePath, "500", "500", "100");

		if (!empty($_W['setting']['remote']['type'])) {
			$remotestatus = file_remote_upload($result['path']);
			if (is_error($remotestatus)) {
				message('远程附件上传失败，请检查配置并重新上传');
			}
		}

		return $result['path'];
    }

    /**
     *  检查目录是否存在
     */
    private function checkdir($path) {
        if (!file_exists($path)) {
            mkdir($path, 0777);
        }
    }

    /**
     * 图片加水印（适用于png/jpg/gif格式）
     * 
     * @author flynetcn
     *
     * @param $srcImg 原图片
     * @param $waterImg 水印图片
     * @param $savepath 保存路径
     * @param $savename 保存名字
     * @param $positon 水印位置 
     * 
     * @return 成功 -- 加水印后的新图片地址
     *          失败 -- -1:原文件不存在, -2:水印图片不存在, -3:原文件图像对象建立失败
     *          -4:水印文件图像对象建立失败 -5:加水印后的新图片保存失败
     */
    public function img_water_mark($srcImg, $waterImg, $savepath = null, $savename = null, $x, $y, $alpha = 100) {
        $temp = pathinfo($srcImg);
        $name = $temp['basename'];
        $path = $temp['dirname'];
        $exte = $temp['extension'];
        $savename = $savename ? $savename : $name;
        $savepath = $savepath ? $savepath : $path;
        $savefile = $savepath . '/' . $savename;
        $srcinfo = @getimagesize($srcImg);
        if (!$srcinfo) {
            return -1; /* 原文件不存在 */
        }
        $waterinfo = @getimagesize($waterImg);
        if (!$waterinfo) {
            return -2; /* 水印图片不存在 */
        }
        $srcImgObj = $this->image_create_from_ext($srcImg);
        if (!$srcImgObj) {
            return -3; /* 原文件图像对象建立失败 */
        }
        $waterImgObj = $this->image_create_from_ext($waterImg);
        if (!$waterImgObj) {
            return -4; /* 水印文件图像对象建立失败 */
        }

        imagecopymerge($srcImgObj, $waterImgObj, $x, $y, 0, 0, $waterinfo[0], $waterinfo[1], $alpha);
        switch ($srcinfo[2]) {
            case 1: imagegif($srcImgObj, $savefile);
                break;
            case 2: imagejpeg($srcImgObj, $savefile);
                break;
            case 3: imagepng($srcImgObj, $savefile);
                break;
            default: return -5; /* 保存失败 */
        }
        imagedestroy($srcImgObj);
        imagedestroy($waterImgObj);
        return $savefile;
    }

    public function image_create_from_ext($imgfile) {
        $info = getimagesize($imgfile);
        $im = null;
        switch ($info[2]) {
            case 1: $im = imagecreatefromgif($imgfile);
                break;
            case 2: $im = imagecreatefromjpeg($imgfile);
                break;
            case 3: $im = imagecreatefrompng($imgfile);
                break;
        }
        return $im;
    }

    /**
     * 等比缩放 
     * @param unknown_type $srcImage   源图片路径 
     * @param unknown_type $toFile     目标图片路径 
     * @param unknown_type $maxWidth   最大宽 
     * @param unknown_type $maxHeight  最大高 
     * @param unknown_type $imgQuality 图片质量 
     * @return unknown 
     */
    function resize($srcImage, $toFile, $maxWidth = 1024, $maxHeight = 1024, $imgQuality = 100) {

        list($width, $height, $type, $attr) = getimagesize($srcImage);
        if ($width < $maxWidth || $height < $maxHeight)
            return;
        switch ($type) {
            case 1: $img = imagecreatefromgif($srcImage);
                break;
            case 2: $img = imagecreatefromjpeg($srcImage);
                break;
            case 3: $img = imagecreatefrompng($srcImage);
                break;
        }
        $scale = min($maxWidth / $width, $maxHeight / $height); //求出绽放比例 

        if ($scale < 1) {
            $newWidth = floor($scale * $width);
            $newHeight = floor($scale * $height);
            $newImg = imagecreatetruecolor($newWidth, $newHeight);
            imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $newName = "";
            $toFile = preg_replace("/(.gif|.jpg|.jpeg|.png)/i", "", $toFile);

            switch ($type) {
                case 1: if (imagegif($newImg, "$toFile$newName.gif", $imgQuality))
                        return "$newName.gif";
                    break;
                case 2: if (imagejpeg($newImg, "$toFile$newName.jpg", $imgQuality))
                        return "$newName.jpg";
                    break;
                case 3: if (imagepng($newImg, "$toFile$newName.png", $imgQuality))
                        return "$newName.png";
                    break;
                default: if (imagejpeg($newImg, "$toFile$newName.jpg", $imgQuality))
                        return "$newName.jpg";
                    break;
            }
            imagedestroy($newImg);
        }
        imagedestroy($img);
        return false;
    }

    /**
     * * 企业付款接口
     */
    private function companyPay($post, $fans) {
        global $_W, $_GPC;
        $uniacid = $_W['uniacid'];
        $account = $_W['account'];
        
		/* 分销设置 */
		$comsetting = $this->readCache(2);

        $url = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers';
        $pars = array();
        $pars['mch_appid'] = $account['key']; /* 公众账号appid */
        $pars['mchid'] = $comsetting['mchid'];   /* 商户号 */
        $pars['nonce_str'] = random(32);   /* 随机字符串 */
        $pars['partner_trade_no'] = $comsetting['mchid'] . date('Ymd') . rand(1000000000, 9999999999); /* 商户订单号 */
        $pars['openid'] = $fans['openid'];   /* 用户openid */
        $pars['check_name'] = 'NO_CHECK';   /* 校验用户姓名选项，不校验 */
        $pars['re_user_name'] = $fans['nickname'];   /* 收款用户姓名 */
        $pars['amount'] = $post['total_amount'] * 100; /* 付款金额，单位：分 */
        $pars['desc'] = $post['desc'];    /* 企业付款描述信息 */
        $pars['spbill_create_ip'] = $comsetting['serverIp'] ? $comsetting['serverIp'] : $_SERVER["SERVER_ADDR"]; /* Ip地址 */

        ksort($pars, SORT_STRING);
        $string1 = '';
        foreach ($pars as $k => $v) {
            $string1 .= "{$k}={$v}&";
        }

        $string1 .= "key={$comsetting['mchkey']}";
        $pars['sign'] = strtoupper(md5($string1));
        $xml = '<xml>';
        foreach ($pars as $k => $v) {
            $xml .= "<{$k}>{$v}</{$k}>";
        }
        $xml .= '</xml>';

        $extras = array();
        $extras['CURLOPT_CAINFO'] = MODULE_ROOT . '/cert/rootca' . $uniacid . '.pem';
        $extras['CURLOPT_SSLCERT'] = MODULE_ROOT . '/cert/apiclient_cert' . $uniacid . '.pem';
        $extras['CURLOPT_SSLKEY'] = MODULE_ROOT . '/cert/apiclient_key' . $uniacid . '.pem';
        load()->func('communication');

        $resp = ihttp_request($url, $xml, $extras);
        $tmp = str_replace("<![CDATA[", "", $resp['content']);
        $tmp = str_replace("]]>", "", $tmp);
        $tmp = simplexml_load_string($tmp);
        $result = json_decode(json_encode($tmp), TRUE);

        return $result;
    }

    /**
     * 导出excel文件方法
     * $data  导出的数据
     * $title 标题栏
     * $filename 导出的excel文件名
     */
    protected function exportexcel($data = array(), $title = array(), $filename = 'report') {
        header("Content-type:application/octet-stream");
        header("Accept-Ranges:bytes");
        header("Content-type:application/vnd.ms-excel");
        header("Content-Disposition:attachment;filename=" . $filename . "-" . date('Ymd', time()) . ".xls");
        header("Pragma: no-cache");
        header("Expires: 0");
        /* 导出xls 开始 */
        if (!empty($title)) {
            foreach ($title as $k => $v) {
                $title[$k] = iconv("UTF-8", "GB2312", $v);
            }
            $title = implode("\t", $title);
            echo "$title\n";
        }
        if (!empty($data)) {
            $totalprice = 0;
            foreach ($data as $key => $val) {
                foreach ($val as $ck => $cv) {
                    $data[$key][$ck] = iconv("UTF-8", "GB2312", $cv);
                }
                $data[$key] = implode("\t", $data[$key]);
                $totalprice += $val['amount'];
            }
            echo implode("\n", $data);
        }
    }

    /* 上传Excel文件 */
    public function inputExcel($filename, $tmp_file) {
        if (!empty($filename)) {
            $file_types = explode(".", $filename);
            $file_type = $file_types[count($file_types) - 1];
            if (strtolower($file_type) != "xls") {
                message("请上传后缀是xls的文件", "", "error");
            }
            /* 设置上传路径 */
            $savePath = "../attachment/excel/";
            if (!file_exists($savePath)) {
                mkdir($savePath, 0777);
            }
            $savePath = $savePath . "fy_lessonv2/";
            if (!file_exists($savePath)) {
                mkdir($savePath, 0777);
            }
            /* 以时间来命名上传的文件 */
            $str = date('Ymdhis');
            $file_name = $str . random(8) . "." . $file_type;

            $newfilename = $savePath . $file_name;

            /* 是否上传成功 */
            if (!copy($tmp_file, $newfilename)) {
                message("上传文件失败，请稍候重试", "", "error");
            }

            require_once('../framework/library/phpexcel/PHPExcel/IOFactory.php');

            $reader = PHPExcel_IOFactory::createReader('Excel5');
            $PHPExcel = $reader->load($newfilename); // 文件名称
            $sheet = $PHPExcel->getSheet(0); // 读取第一个工作表从0读起
            $highestRow = $sheet->getHighestRow(); // 取得总行数
            $highestColumn = $sheet->getHighestColumn(); // 取得总列数

            $arr = array(1 => 'A', 2 => 'B', 3 => 'C', 4 => 'D', 5 => 'E', 6 => 'F', 7 => 'G', 8 => 'H', 9 => 'I', 10 => 'J', 11 => 'K', 12 => 'L', 13 => 'M', 14 => 'N', 15 => 'O', 16 => 'P', 17 => 'Q', 18 => 'R', 19 => 'S', 20 => 'T', 21 => 'U', 22 => 'V', 23 => 'W', 24 => 'X', 25 => 'Y', 26 => 'Z');

            for ($row = 2; $row <= $highestRow; $row++) {
                for ($column = 0; $arr[$column] != $highestColumn; $column++) {
                    $val = $sheet->getCellByColumnAndRow($column, $row)->getValue();
                    $list[$row][] = $val;
                }
            }

            return array('list' => $list, 'newfilename' => $newfilename);
        } else {
            message("请选择要上传的文件", "", "error");
        }
    }

    /*
     * 上传微信企业付款证书
     */
    public function upfile($file, $newfile) {
        global $_W;
        if (!empty($file['name'])) {
            $file_types = explode(".", $file['name']);
            $file_type = $file_types[count($file_types) - 1];
            if (strtolower($file_type) != "pem") {
                message("请上传后缀是pem的文件", "", "error");
            }
            /* 设置上传路径 */
            $dirpath = dirname(__FILE__) . "/cert/";
            if (!file_exists($dirpath)) {
                mkdir($dirpath, 0777);
            }
            /* 命名文件，格式：文件名公众号id.文件类型 */
            $file_name = $dirpath . $newfile . $_W['uniacid'] . "." . $file_type;

            /* 是否上传成功 */
            if (!copy($file['tmp_name'], $file_name)) {
                message("上传文件失败，请稍候重试", "", "error");
            }
        }
    }

    /*
     * 使用七牛云存储防盗链
     * $accessKey
     * $secretKey
     * $baseUrl
     */
    private function privateDownloadUrl($accessKey, $secretKey, $baseUrl, $expires = 3600) {
        $deadline = time() + $expires;

        $pos = strpos($baseUrl, '?');
        if ($pos !== false) {
            $baseUrl .= '&e=';
        } else {
            $baseUrl .= '?e=';
        }
        $baseUrl .= $deadline;
        $hmac = hash_hmac('sha1', $baseUrl, $secretKey, true);
        $find = array('+', '/');
        $replace = array('-', '_');
        $hmac = str_replace($find, $replace, base64_encode($hmac));

        $token = $accessKey . ':' . $hmac;
        return "$baseUrl&token=$token";
    }

	/*
     * 使用腾讯云存储防盗链
     * $accessKey
     * $secretKey
     * $baseUrl
     */
	private function tencentDownloadUrl($qcloud, $access_url) {
		$appid		 = $qcloud['appid'];
		$bucket		 = $qcloud['bucket'];
		$secret_id   = $qcloud['secretid'];
		$secret_key  = $qcloud['secretkey'];
		$expired	 = time() + 7200;
		$onceExpired = 0;
		$current	 = time();
		$rdm		 = rand();
		$userid		 = "0";
		$explode	 = explode("/", $access_url);
		$tmp		 = array_reverse($explode);
		$fileid		 = "/".$appid."/".$bucket."/".$tmp[0];

		$srcStr = 'a='.$appid.'&b='.$bucket.'&k='.$secret_id.'&e='.$expired.'&t='.$current.'&r='.$rdm.'&f=';
		$srcStrOnce = 'a='.$appid.'&b='.$bucket.'&k='.$secret_id.'&e='.$onceExpired .'&t='.$current.'&r='.$rdm.'&f='.$fileid;
		$signStr = base64_encode(hash_hmac('SHA1', $srcStr, $secret_key, true).$srcStr);
		
		return $access_url .= "?sign={$signStr}";
	}

	/**
	 * 去除二维数组中重复的元素
	 */
	function two_array_unique($list){
		foreach ($list as $v){
			$v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
			$temp[]=$v;
		}
		$temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
		foreach ($temp as $k => $v){
			$temp[$k]=explode(',',$v); //再将拆开的数组重新组装
		}
		return $temp;
	}

	/* 获取vip身份状态名称 */
	public function getVipStatusName($vip){
		return $vip==1?'VIP':'普通';
	}
	
	/* 获取代理状态名称 */
	public function getAgentStatusName($status){
		return $status==1?'正常':'冻结';
	}
	
	/* 获取代理级别名称 */
	public function getAgentLevelName($levelId){
		global $_W;

		$level = pdo_fetch("SELECT levelname FROM " .tablename($this->table_commission_level). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$_W['uniacid'], ':id'=>$levelId));
		
		return $level?$level['levelname']:'默认级别';
	}
	
	/* 获取下级粉丝总数 */
	public function getFansCount($uid){
		global $_W;

		return pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_member). " WHERE uniacid=:uniacid AND parentid=:parentid", array(':uniacid'=>$_W['uniacid'], ':parentid'=>$uid));
	}
	
	/* 获取微信商户号和支付订单号 */
	public function getWechatPayNo($tid){
		return pdo_fetch("SELECT uniontid,tag FROM ".tablename('core_paylog'). " WHERE tid=:tid", array(':tid'=>$tid));
	}
	
	/* 获取VIP服务卡卡密 */
	public function getVipCardPwd($id){
		$vipCard = pdo_fetch("SELECT password FROM ".tablename($this->table_vipcard). " WHERE id=:id", array(':id'=>$id));
		return $vipCard['password'];
	}
	
	/* 获取课程优惠码密钥 */
	public function getCouponPwd($id){
		$coupon = pdo_fetch("SELECT password FROM ".tablename($this->table_coupon). " WHERE card_id=:card_id", array(':card_id'=>$id));
		return $coupon['password'];
	}
	
	/* json输出 */
	public function resultJson($data){
		echo json_encode($data);
		exit();
	}
	
	/*获取VIP等级信息*/
	public function getLevelById($level_id){
		return pdo_fetch("SELECT * FROM " .tablename($this->table_vip_level). " WHERE id=:id", array(':id'=>$level_id));
	}
	
	/**
	 * 检查分销商状态变化
	 * $member 分销商会员信息
	 * $comsetting 分销设置参数
	 * $price 订单价格
	 */
	public function checkAgentStatus($member, $comsetting, $price){
		$orderAmount = $member['payment_amount'] ? $member['payment_amount']+$price : $this->getMemberOrderAmount($member['uid']);
		$orderTotal = $member['payment_order'] ? $member['payment_order']+1 : $this->getMemberOrderNumber($member['uid']);

		$memberinfo = array(
			'payment_amount' => $orderAmount,
			'payment_order'  => $orderTotal
		);

		/* 分销商状态变更 */
		$agent_condition = unserialize($comsetting['agent_condition']);
		if($member['status']==0){
			if($orderAmount >= $agent_condition['order_amount'] && $orderTotal >= $agent_condition['order_total']){
				$memberinfo['status'] = 1;
			}
		}

		/* 分销商等级变更 2. 购买订单总额 3.购买订单笔数 */
		if($comsetting['upgrade_condition']==2){
			$upgradeLevel = $this->upgradeAgentLevel($member['uniacid'], $member['agent_level'], $orderAmount, $comsetting);
			if(!empty($upgradeLevel)){
				$memberinfo['agent_level'] = $upgradeLevel;
			}

		}elseif($comsetting['upgrade_condition']==3){
			$upgradeLevel = $this->upgradeAgentLevel($member['uniacid'], $member['agent_level'], $orderTotal, $comsetting);
			if(!empty($upgradeLevel)){
				$memberinfo['agent_level'] = $upgradeLevel;
			}
		}

		pdo_update($this->table_member, $memberinfo, array('uid'=>$member['uid']));
	}

	/* 获取用户购买订单总额 */
	public function getMemberOrderAmount($uid){
		$lessonAmount = pdo_fetchall("SELECT SUM(price) as amount FROM " .tablename($this->table_order). " WHERE uid=:uid AND status>=:status", array(':uid'=>$uid, ':status'=>1));
		$vipAmount = pdo_fetchall("SELECT SUM(vipmoney) as amount FROM " .tablename($this->table_member_order). " WHERE uid=:uid AND status=:status", array(':uid'=>$uid, ':status'=>1));
			
		$orderAmount = $lessonAmount[0]['amount'] + $vipAmount[0]['amount'];
		return $orderAmount;
	}

	/* 获取用户购买订单笔数 */
	public function getMemberOrderNumber($uid){
		$lessonTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_order). " WHERE uid=:uid AND status>=:status ", array(':uid'=>$uid, ':status'=>1));
		$vipTotal = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename($this->table_member_order). " WHERE uid=:uid AND status=:status", array(':uid'=>$uid, ':status'=>1));

		$orderTotal = $lessonTotal + $vipTotal;
		return $orderTotal;
	}

	/* 获取基本设置参数 */
	private function getSetting(){
		global $_W;
		return pdo_fetch("SELECT * FROM " .tablename($this->table_setting). " WHERE uniacid=:uniacid", array(':uniacid'=>$_W['uniacid']));
	}

	/* 获取分销设置参数 */
	private function getComsetting(){
		global $_W;
		return pdo_fetch("SELECT * FROM " .tablename($this->table_commission_setting). " WHERE uniacid=:uniacid", array(':uniacid'=>$_W['uniacid']));
	}
	
	/* 检查是否在微信中打开 */
	public function checkUserAgent(){
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		if (strpos($user_agent, 'MicroMessenger') === false) {
			return false;
		}else{
			return true;
		}
	}

	/* 章节更新时间检查 */
	public function tranTime($time){
		$rtime = date("m-d H:i",$time);
		$htime = date("H:i",$time);
		$time = time() - $time;
		if ($time < 60){
			$str = '刚刚';
		}elseif ($time < 60 * 60){
			$min = floor($time/60);
			$str = $min.'分钟前';
		}elseif ($time < 60 * 60 * 24){
			$h = floor($time/(60*60));
			$str = $h.'小时前';
		}elseif ($time < 60 * 60 * 24 * 3){
			$d = floor($time/(60*60*24));
			if($d==1)
				$str = '昨天';
			else
				$str = '前天';
		}else{
			$str = $rtime;
		}
		return $str;
	}

	/* 更新缓存
	 * $cacheName 缓存名称
	 * $cacheData 缓存数据
	 */
	 private function updateCache($cacheName, $cacheData=null){
		 if(empty($cacheData)){
			 $cacheData = $this->getSetting();
		 }
		 cache_delete($cacheName);
		 cache_write($cacheName, $cacheData);
	 }

	 /* 读取缓存
	  * $type 读取缓存类型 1.全局设置表 2.分销设置表
	  */
	 private function readCache($type){
		 global $_W;

		 if($type==1){
			 $setting = cache_load('fy_lessonv2_setting_'.$_W['uniacid']);
			 if(empty($setting)){
				$setting = $this->getSetting();
				cache_write('fy_lessonv2_setting_'.$_W['uniacid'], $setting);
			}
			return $setting;

		 }elseif($type==2){
			 $comsetting = cache_load('fy_lessonv2_commission_setting_'.$_W['uniacid']);
			 if(empty($comsetting)){
				$comsetting = $this->getComsetting();
				cache_write('fy_lessonv2_commission_setting_'.$_W['uniacid'], $comsetting);
			}
			return $comsetting;
		 }
	 }

	 /* 查询通用缓存 */
	 public function readCommonCache($name){
		global $_W;

		$data = cache_load($name);
		$update_time = intval(cache_load('update_time_'.$_W['uniacid']));
		if(empty($data) || time()>$update_time){
			if(time()>$update_time){
				cache_write('update_time_'.$_W['uniacid'], time()+600);
			}
			return false;
		}else{
			return $data;
		}
	 }

	 /* 大于(阿里云)短信发送
	  * $sms 短信配置信息
	  * $mobile 接收手机号码
	  * $templateId 模版ID
	  * $data 发送参数
	  */
	  private function sendSMS($sms, $mobile, $templateId, $data){
		 if($sms['versions']==0){
			/* 大于短信 */
			include_once dirname(__FILE__)."/library/dayuSMS/TopSdk.php";
			date_default_timezone_set('Asia/Shanghai');

			$c = new TopClient;
			$c->appkey = $sms['app_key'];
			$c->secretKey = $sms['app_secret'];

			$req = new AlibabaAliqinFcSmsNumSendRequest;
			$req->setExtend("");
			$req->setSmsType("normal");
			$req->setSmsFreeSignName($sms['sign']);
			$req->setSmsParam(json_encode($data));
			$req->setRecNum($mobile);
			$req->setSmsTemplateCode($templateId);
			$result = $c->execute($req);

			return $result;

		 }elseif($sms['versions']==1){
			/* 阿里云短信 */
			include_once dirname(__FILE__)."/library/aliyunSMS/SignatureHelper.php";

			$params = array ();
			$params["PhoneNumbers"] = $mobile;
			$params["SignName"] = $sms['sign'];
			$params["TemplateCode"] = $templateId;
			$params["TemplateParam"] = json_encode($data);

			$helper = new SignatureHelper();
			$result = $helper->request(
				$sms['access_key'],
				$sms['access_secret'],
				"dysmsapi.aliyuncs.com",
				array_merge($params, array(
					"RegionId" => "cn-hangzhou",
					"Action" => "SendSms",
					"Version" => "2017-05-25",
				))
			);

			return $result;
		 }
	  }

	
	/* 十六进制颜色转为RGB */
	function hexTorgb($hexColor) {
		$color = str_replace('#', '', $hexColor);
		if (strlen($color) > 3) {
			$rgb = array(
				'r' => hexdec(substr($color, 0, 2)),
				'g' => hexdec(substr($color, 2, 2)),
				'b' => hexdec(substr($color, 4, 2))
			);
		} else {
			$color = $hexColor;
			$r = substr($color, 0, 1) . substr($color, 0, 1);
			$g = substr($color, 1, 1) . substr($color, 1, 1);
			$b = substr($color, 2, 1) . substr($color, 2, 1);
			$rgb = array(
				'r' => hexdec($r),
				'g' => hexdec($g),
				'b' => hexdec($b)
			);
		}
		return $rgb;
	}
}

?>