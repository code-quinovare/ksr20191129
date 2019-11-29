<?php
/**
 * 二维码推广
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();
$uid = $_W['member']['uid'];
$title = "我的推广海报";

if($comsetting['is_sale']==0){
	message("系统未开启该功能", "", "warning");
}

$member = pdo_fetch("SELECT a.*,b.avatar,b.nickname AS mc_nickname FROM " .tablename($this->table_member). " a LEFT JOIN ".tablename($this->table_mc_members). " b ON a.uid=b.uid WHERE a.uniacid=:uniacid AND a.uid=:uid", array(':uniacid'=>$uniacid,':uid'=>$uid));

if(!empty($member)){
	$infourl = $_W['siteroot'] .'app/'. $this->createMobileUrl('index', array('uid'=>$uid));
}

/* 已购买VIP等级 */
$memberVip = pdo_fetchall("SELECT * FROM " .tablename($this->table_member_vip). " WHERE uid=:uid AND validity>:validity", array(':uid'=>$uid,':validity'=>time()));
if($comsetting['sale_rank']==2 && empty($memberVip)){
	message("您不是VIP会员，无法访问该功能", $this->createMobileUrl('index'), "warning");
}
if($member['status']!=1){
	message("您的分销身份未激活", $this->createMobileUrl('index'), "warning");
}

$sale_desc = $comsetting['sale_desc'] ? explode("\n", $comsetting['sale_desc']) : "";

/* 分享设置 */
load()->model('mc');
$sharelink = unserialize($comsetting['sharelink']);
$shareurl = $_W['siteroot'] .'app/'. $this->createMobileUrl('index', array('uid'=>$uid));

/* 海报配置参数 */
$poster = json_decode($setting['poster_config'], true);
$qrcode_left = intval($poster['qrcode_left'])>0 ? $poster['qrcode_left'] : 473;
$qrcode_top = intval($poster['qrcode_top'])>0 ? $poster['qrcode_top'] : 733;
$avatar_left = intval($poster['avatar_left'])>0 ? $poster['avatar_left'] : 22;
$avatar_top = intval($poster['avatar_top'])>0 ? $poster['avatar_top'] : 698;
$nickname_left = intval($poster['nickname_left'])>0 ? $poster['nickname_left'] : 210;
$nickname_top = intval($poster['nickname_top'])>0 ? $poster['nickname_top'] : 728;
$nickname_fontsize = intval($poster['nickname_fontsize'])>0 ? $poster['nickname_fontsize'] : 24;
if(!empty($poster['nickname_fontcolor'])){
	$font_color = $this->hexTorgb($poster['nickname_fontcolor']);
}else{
	$font_color['r'] = $font_color['g'] = $font_color['b'] = 255;
}

$dirpath = "../attachment/images/fy_lessonv2/";
if(!file_exists($dirpath)){
	mkdir($dirpath, 0777);
}

if(!file_exists($dirpath.$uniacid."_".$uid."_ok.png") || $comsetting['qrcode_cache']==0){
	set_time_limit(80); 
	ignore_user_abort(true); 
	include("../framework/library/qrcode/phpqrcode.php");

	/* 背景图片 */
	$bgimg = $setting['posterbg']?$_W['attachurl'].$setting['posterbg']:MODULE_URL."template/mobile/images/posterbg.jpg";

	/* 二维码图片 */
	$errorCorrectionLevel = 'L';  /* 纠错级别：L、M、Q、H */
	$matrixPointSize = 4;  /* 点的大小：1到10 */
	
	$qrcode = $dirpath.$uniacid."_".$uid."_qrcode".'.png'; /* 生成的文件名 */
	QRcode::png($infourl, $qrcode, $errorCorrectionLevel, $matrixPointSize, 2);

	/* 合成二维码 */
	$savefield = $this->img_water_mark($bgimg, $qrcode, $dirpath, $uniacid."_".$uid.".png", $qrcode_left, $qrcode_top);
	
	/* 合成头像 */
	if($poster['avatar_show']==1){
		if(empty($member['avatar'])){
			$avatar = MODULE_URL."template/mobile/images/default_avatar.jpg";
		}else{
			$inc = strstr($member['avatar'], "http://");
			$avatar = $inc ? $member['avatar'].".jpg" : $_W['attachurl'].$member['avatar'];
		}

		$suffix = strtolower(substr(strrchr($avatar, '.'), 1));
		$this->saveImage($avatar, $dirpath.$uniacid."_".$uid."_","avatar.".$suffix);

		$avatar_size = filesize($dirpath.$uniacid."_".$uid."_avatar.".$suffix);
		if($avatar_size==0){
			message("获取头像失败，请检查用户头像是否正常");
		}

		if($suffix=='png'){
			$im = imagecreatefrompng($dirpath.$uniacid."_".$uid."_avatar.".$suffix);
		}elseif($suffix=='jpeg' || $suffix=='jpg'){
			$im = imagecreatefromjpeg($dirpath.$uniacid."_".$uid."_avatar.".$suffix);
		}else{
			$im = imagecreatefromjpeg(MODULE_URL."template/mobile/images/default_avatar.jpg");
		}
		imagejpeg($im, $dirpath.$uniacid."_".$uid."_avatar.jpg");
		imagedestroy($im);
		
		$this->resize($dirpath.$uniacid."_".$uid."_avatar.jpg", $dirpath.$uniacid."_".$uid."_avatar.jpg", "100", "100", "100");
		$savefield = $this->img_water_mark($savefield, $dirpath.$uniacid."_".$uid."_avatar.jpg", $dirpath, $uniacid."_".$uid."_ok.png", $avatar_left, $avatar_top);
	}

	
	$info = getimagesize($savefield);
	/* 通过编号获取图像类型 */
	$type = image_type_to_extension($info[2],false);
	/* 图片复制到内存 */
	$image = imagecreatefromjpeg($savefield);
	
	/* 合成昵称 */
	if($poster['nickname_show']==1){
		/* 设置字体的路径 */
		$font = "../addons/fy_lessonv2/template/mobile/ttf/yahei.ttf";  
		/* 设置字体颜色和透明度 */
		$color = imagecolorallocatealpha($image, $font_color['r'], $font_color['g'], $font_color['b'], 0);
		/* 写入文字 */
		$fun = $dirpath.$uniacid."_".$uid.".png";
		imagettftext($image, $nickname_fontsize, 0, $nickname_left, $nickname_top, $color, $font, $member['mc_nickname']);
	}

	/* 保存图片 */
	$fun = "image".$type;
	$okfield = $dirpath.$uniacid."_".$uid."_ok.png";
	$fun($image, $okfield);  
	/*销毁图片*/  
	imagedestroy($image);
	
	/* 删除多余文件 */
	unlink($dirpath.$uniacid."_".$uid.".png");
	unlink($dirpath.$uniacid."_".$uid."_qrcode.png");
	unlink($dirpath.$uniacid."_".$uid."_avatar.jpg");
	if($suffix!='jpg'){
		unlink($dirpath.$uniacid."_".$uid."_avatar.".$suffix);
	}

	pdo_update($this->table_member, array('uptime'=>time()), array('uid'=>$uid));
}

$imagepath = $dirpath.$uniacid."_".$uid."_ok.png?v=".time();


include $this->template('qrcode');

?>