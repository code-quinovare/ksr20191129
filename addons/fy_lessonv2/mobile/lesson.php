<?php
/**
 * 课程详情页
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
$this->setParentId($_GPC['uid']);
$login_visit = json_decode($setting['login_visit']);
if(!empty($login_visit) && in_array('lesson', $login_visit)){
	checkauth();
}

/* 检查是否在微信中访问 */
$userAgent = $this->checkUserAgent();

$uid = $_W['member']['uid'];
$id = intval($_GPC['id']);/* 课程id */
$sectionid = intval($_GPC['sectionid']);/* 点播章节id */

if($uid>0){
	$member = pdo_fetch("SELECT a.*,b.follow,c.avatar,c.nickname FROM " .tablename($this->table_member). " a LEFT JOIN " .tablename($this->table_fans). " b ON a.uid=b.uid LEFT JOIN " .tablename($this->table_mc_members). " c ON a.uid=c.uid WHERE a.uid=:uid", array(':uid'=>$uid));
}
if(empty($member['avatar'])){
	$avatar = MODULE_URL."template/mobile/images/default_avatar.jpg";
}else{
	$inc = strstr($member['avatar'], "http://");
	$avatar = $inc ? $member['avatar'] : $_W['attachurl'].$member['avatar'];
}

$lesson = pdo_fetch("SELECT a.*,b.teacher,b.qq,b.qqgroup,b.qqgroupLink,b.weixin_qrcode,b.teacherphoto,b.teacherdes FROM " .tablename($this->table_lesson_parent). " a LEFT JOIN " .tablename($this->table_teacher). " b ON a.teacherid=b.id WHERE a.uniacid=:uniacid AND a.id=:id AND a.status!=:status LIMIT 1", array(':uniacid'=>$uniacid, ':id'=>$id, ':status'=>0));
if(empty($lesson)){
	message("该课程已下架，您可以看看其他课程~", "", "error");
}
$lesson['qq'] = $config['teacher_qq'] ? $config['teacher_qq'] : $lesson['qq'];
$lesson['qqgroup'] = $config['teacher_qqgroup'] ? $config['teacher_qqgroup'] : $lesson['qqgroup'];
$lesson['qqgroupLink'] = $config['teacher_qqlink'] ? $config['teacher_qqlink'] : $lesson['qqgroupLink'];
$lesson['weixin_qrcode'] = $config['teacher_qrcode'] ? $config['teacher_qrcode'] : $lesson['weixin_qrcode'];

/* 课程规格 */
$spec_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_lesson_spec). " WHERE uniacid=:uniacid AND lessonid=:lessonid ORDER BY spec_price ASC", array(':uniacid'=>$uniacid,':lessonid'=>$id));

$poster = json_decode($lesson['poster']);
$rand = rand(0, count($poster)-1);
$poster = $poster[$rand];

/* 购买按钮名称 */
$appoint_info = json_decode($lesson['appoint_info'], true);
$buynow_name = $appoint_info['buynow_name'] ? $appoint_info['buynow_name'] : $config['buynow_name'];
$buynow_link = $appoint_info['buynow_link'] ? $appoint_info['buynow_link'] : $config['buynow_link'];

if($uid>0){
	/* 查询是否收藏该课程 */
	$collect = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_collect). " WHERE uniacid=:uniacid AND uid=:uid AND outid=:outid AND ctype=:ctype LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':outid'=>$id,':ctype'=>1));

	/* 查询是否购买该课程 */
	$isbuy = pdo_fetch("SELECT * FROM " .tablename($this->table_order). " WHERE uid=:uid AND lessonid=:lessonid AND status>=:status AND paytime>:paytime ORDER BY id DESC LIMIT 1", array(':uid'=>$uid,':lessonid'=>$id,':status'=>1,':paytime'=>0));
}
if(empty($isbuy) && $lesson['status']=='-1'){
	message("该课程已下架，您可以看看其他课程~");
}

if($uid>0){
	/* 增加会员课程足迹 */
	$history = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_history). " WHERE lessonid=:lessonid AND uid=:uid LIMIT 1", array(':lessonid'=>$id,':uid'=>$uid));
	if(empty($history)){
		$insertdata = array(
			'uniacid'  => $uniacid,
			'uid'	   => $uid,
			'lessonid' => $id,
			'addtime'  => time(),
		);
		pdo_insert($this->table_lesson_history, $insertdata);
		pdo_update($this->table_lesson_parent, array('visit_number'=>$lesson['visit_number']+1), array('id'=>$lesson['id']));
	}else{
		pdo_update($this->table_lesson_history, array('addtime'=>time()), array('lessonid'=>$id,'uid'=>$uid));
	}
}

/* 标题 */
$title = $lesson['bookname'];

/* 章节列表 */
$section_list = pdo_fetchall("SELECT id FROM " .tablename($this->table_lesson_son). " WHERE parentid=:parentid AND status=:status AND auto_show=:auto_show AND show_time<=:show_time", array(':parentid'=>$id, ':status'=>0, ':auto_show'=>1, ':show_time'=>time()));
foreach($section_list as $item){
   pdo_update($this->table_lesson_son, array('status'=>1), array('id'=>$item['id']));
}

$section_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_lesson_son). " WHERE parentid=:parentid AND status=:status ORDER BY displayorder DESC, id ASC", array(':parentid'=>$id,':status'=>1));

/*课程VIP免费学习*/
$level_name = "";
if(is_array(json_decode($lesson['vipview']))){
	foreach(json_decode($lesson['vipview']) as $v){
		$level = $this->getLevelById($v);
		if(!empty($level['level_name']) && $level['is_show']==1){
			$level_name .= $level['level_name']."/";
		}
	}
	$level_name = trim($level_name, "/");
}

/* vip免费学习课程对于普通课程生效 */
if(!empty($memberVip_list) && $lesson['lesson_type']==0){
	foreach($memberVip_list as $v){
		if(in_array($v['level_id'], json_decode($lesson['vipview']))){
			$play = true; /* 判断购买事件 */
			$plays = true; /* 判断试听章节 */
			break;
		}
	}
}

if($sectionid>0){
	/* 点播章节 */
	$section = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_son). " WHERE parentid=:parentid AND id=:id AND status=:status LIMIT 1", array(':parentid'=>$id,':id'=>$sectionid,':status'=>1));
}

/* 判断用户是否已购买或免费学习机会 */
if($section['is_free']==1){
	$play = true;
	$plays = false;
}
if($lesson['price']==0){
	$play = true;
	$plays = true;
}
if($isbuy){
	if($isbuy['validity']==0){
		$play = true;
		$plays = true;
	}else{
		if($isbuy['validity']>time()){
			$play = true;
			$plays = true;
		}
	}
}
/* 讲师自己课程免费 */
$teacher = pdo_fetch("SELECT id FROM " .tablename($this->table_teacher). " WHERE uid=:uid", array(':uid'=>$uid));
if($lesson['teacherid'] == $teacher['id']){
	$play = true;
	$plays = true;
}

if($uid>0){
	/* vip免费学习课程对于普通课程生效 */
	$memberVip_list = pdo_fetchall("SELECT level_id FROM  " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$uid,':validity'=>time()));
	if(!empty($memberVip_list) && $lesson['lesson_type']==0){
		foreach($memberVip_list as $v){
			if(in_array($v['level_id'], json_decode($lesson['vipview']))){
				$play = true;
				$plays = true;
				break;
			}
		}
	}
}

if($sectionid>0){
	if(empty($section)){
		message("该章节不存在或已被删除！", "", "error");
	}

	if(!$play){
		message("请先购买课程后再学习！", $this->createMobileUrl('lesson', array('id'=>$id)), "warning");
	}

	/**
	 * 视频课程格式
	 * @sectiontype 1.视频章节 2.图文章节 3.音频课程 4、外链章节
	 * @savetype	0.其他存储 1.七牛存储 2.内嵌播放代码模式 3.腾讯云存储
	 */
	if(in_array($section['sectiontype'], array('1','3'))){

		if($section['savetype']==1){
			$qiniu = unserialize($setting['qiniu']);
			if($qiniu['https']==1){
				$section['videourl'] = str_replace("http://", "https://", $section['videourl']);
			}

			$section['videourl'] = $this->privateDownloadUrl($qiniu['access_key'],$qiniu['secret_key'],$section['videourl']);

		}elseif($section['savetype']==3){
			$qcloud		 = unserialize($setting['qcloud']);
			if($qcloud['https']==1){
				$section['videourl'] = str_replace("http://", "https://", $section['videourl']);
			}

			$section['videourl'] = $this->tencentDownloadUrl($qcloud, $section['videourl']); 
		}
	}
	
	if($section['sectiontype']==4){
		header("Location:".$section['videourl']);
	}
	
}else{
	if($uid>0){
		/* 进去章节列表 */
		$record = pdo_fetch("SELECT sectionid FROM " .tablename($this->table_playrecord). " WHERE uid=:uid AND lessonid=:lessonid ORDER BY addtime DESC LIMIT 1", array(':uid'=>$uid,':lessonid'=>$id));
	}

	if($record['sectionid']>0){
		$hissection = pdo_fetch("SELECT title FROM " .tablename($this->table_lesson_son). " WHERE id=:id", array(':id'=>$record['sectionid']));
		$hisplayurl = $this->createMobileUrl("lesson",array('id'=>$id,'sectionid'=>$record['sectionid']));
	}
}



/* 脚部广告 */
$avd = unserialize($setting['adv']);
if(!empty($avd)){
	foreach($avd as $key=>$ad){
		if(empty($ad['img'])){
			unset($avd[$key]);
		}
	}
	$advs = array_rand($avd,1);
	$advs = $avd[$advs];
}

/* 构造分享信息开始 */
$share_info = json_decode($lesson['share'], true);    /* 课程单独分享信息 */
$sharelesson = unserialize($comsetting['sharelesson']);  /* 全局课程分享信息 */

if(!empty($share_info['title'])){
	$sharelesson['title'] = $share_info['title'];
}else{
	if(empty($section)){
		$sharelesson['title'] = $lesson['bookname'].' - '.$setting['sitename'];
	}else{
		$sharelesson['title'] = $section['title'].' - '.$lesson['bookname'].' - '.$setting['sitename'];
	}
}
$sharelesson['desc'] = $share_info['descript'] ? $share_info['descript'] : str_replace("【课程名称】","《".$title."》",$sharelesson['title']);

$sharelesson['images'] = $share_info['images'] ? $share_info['images'] : $sharelesson['images'];
if(empty($sharelesson['images'])){
	$sharelesson['images'] = $lesson['images'];
}

$sharelesson['link'] = $_W['siteroot'] .'app/'. $this->createMobileUrl('lesson', array('id'=>$id,'sectionid'=>$sectionid,'uid'=>$uid));
/* 构造分享信息结束 */


/* 评价列表 */
$pindex =max(1,$_GPC['page']);
$psize = 5;

$evaluate_list = pdo_fetchall("SELECT a.lessonid,a.bookname,a.nickname,a.grade,a.content,a.reply,a.addtime, b.avatar FROM " .tablename($this->table_evaluate). " a LEFT JOIN " .tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.lessonid=:lessonid AND a.status=:status ORDER BY a.addtime DESC, a.id DESC LIMIT " . ($pindex-1) * $psize . ',' . $psize, array('lessonid'=>$id,':status'=>1));
foreach($evaluate_list as $key=>$value){
	if($value['grade']==1){
		$evaluate_list[$key]['grade'] = "好评";
		$evaluate_list[$key]['ico'] = " ";
	}elseif($value['grade']==2){
		$evaluate_list[$key]['grade'] = "中评";
		$evaluate_list[$key]['ico'] = "s2";
	}elseif($value['grade']==3){
		$evaluate_list[$key]['grade'] = "差评";
		$evaluate_list[$key]['ico'] = "s3";
	}
	$evaluate_list[$key]['addtime'] = date('Y-m-d', $value['addtime']);
	if(empty($value['avatar'])){
		$evaluate_list[$key]['avatar'] = MODULE_URL."template/mobile/images/default_avatar.jpg";
	}else{
		$inc = strstr($value['avatar'], "http://");
		$evaluate_list[$key]['avatar'] = $inc ? $value['avatar'] : $_W['attachurl'].$value['avatar'];
	}
}

$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_evaluate) . " WHERE lessonid=:lessonid AND status=:status", array(':lessonid'=>$id,':status'=>1));

if($op=='display'){
	/* 评价开关 */
	if($isbuy['status']==1){
		$already_evaluate = pdo_fetch("SELECT id FROM " .tablename($this->table_evaluate). " WHERE uid=:uid AND lessonid=:lessonid AND orderid>:orderid ", array(':uid'=>$uid,':lessonid'=>$id,':orderid'=>0));
		if(empty($already_evaluate)){
			$allow_evaluate = true;
			$evaluate_url   = $this->createMobileUrl("evaluate",array('op'=>'display',"orderid"=>$isbuy['id']));
		}
	}else{
		/* 课程价格为免费 或 会员为VIP身份且课程权限为VIP会员免费观看 */
		if($lesson['price']==0 || ($member['vip']==1 && $lesson['vipview']==1)){
			$already_evaluate = pdo_fetch("SELECT id FROM " .tablename($this->table_evaluate). " WHERE uid=:uid AND lessonid=:lessonid AND orderid=:orderid ", array(':uid'=>$uid,':lessonid'=>$id,':orderid'=>0));
			if(empty($already_evaluate)){
				$allow_evaluate = true;
				$evaluate_url   = $this->createMobileUrl("evaluate",array('op'=>'freeorder',"lessonid"=>$id));
			}
		}
	}
	 
	/*生成课程参数二维码*/
	$dirpath = "../attachment/images/{$uniacid}/fy_lessonv2/";
	if(!file_exists($dirpath)){
		mkdir($dirpath, 0777);
	}
	if(!file_exists($dirpath."lesson_{$id}.jpg") && $userAgent){
		$codeArray = array (
			'expire_seconds' => "",
			'action_name' => QR_LIMIT_STR_SCENE,
			'action_info' => array (
				'scene' => array (
					'scene_str' => "lesson_{$id}",
				),
			),
		);
		$account_api = WeAccount::create();
		$res = $account_api->barCodeCreateFixed($codeArray);
		if(!empty($res['ticket'])){
			$qrcodeurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$res['ticket'];
			$this->downLoadImg($qrcodeurl, $dirpath."qrcode_{$id}.jpg");
			$this->resize($dirpath."qrcode_{$id}.jpg", $dirpath."qrcode_{$id}.jpg", "170", "170", "100");
			$this->img_water_mark(MODULE_URL."template/mobile/images/lesson-qrcode-bg.jpg", $dirpath."qrcode_{$id}.jpg", $dirpath, "lesson_{$id}.jpg", "16", "24");
			unlink($dirpath."qrcode_{$id}.jpg");
		}
	}

	/* 随机获取客服列表 */
	if($_GPC['ispay']==1 && $member['gohome']==0){
		$service = json_decode($setting['qun_service'], true);
		if(!empty($service)){
			$rand = rand(0, count($service)-1);
			$now_service = $service[$rand];
		}
	}

	if($section['sectiontype']==2 && $sectionid>0){/* 图文章节 */
		include $this->template('lesson_article');
	}else{
		include $this->template('lesson');
	}

}elseif($op=='ajaxgetlist'){
	echo json_encode($evaluate_list);

}


?>