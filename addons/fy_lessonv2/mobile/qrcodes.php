<?php
/**
 * 二维码推广 - 带参数
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

/* 分享设置 */
load()->model('mc');
$sharelink = unserialize($comsetting['sharelink']);
$shareurl = $_W['siteroot'] .'app/'. $this->createMobileUrl('index', array('uid'=>$uid));

$dirpath = "../attachment/images/fy_lessonv2/";
if(!file_exists($dirpath)){
	mkdir($dirpath, 0777);
}

if(!file_exists("../attachment/images/fy_lessonv2/".$uniacid."_".$uid."_params_ok.png") || time()-$member['uptime']>86400*7){
	set_time_limit(60); 
	ignore_user_abort(true); 
	include("../framework/library/qrcode/phpqrcode.php");

	/* 背景图片 */
	$bgimg = $setting['posterbg']?$_W['attachurl'].$setting['posterbg']:MODULE_URL."template/mobile/images/posterbg.jpg";

	/* 获取带参数二维码 */
	$codeArray = array (
		'expire_seconds' => "",
		'action_name' => QR_LIMIT_SCENE,
		'action_info' => array (
			'scene' => array (
				'scene_id' => $uid,
			),
		),
	);
	$account_api = WeAccount::create();
	$res = $account_api->barCodeCreateDisposable($codeArray);
	if(empty($res['ticket'])){
		message("获取二维码失败，错误信息:".$res['errcode']."，".$res['errmsg']);
	}
	$qrcodeurl = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$res['ticket'];
	$this->downLoadImg($qrcodeurl, $dirpath.$uniacid."_".$uid."_qrcode.jpg");
	$this->resize($dirpath.$uniacid."_".$uid."_qrcode.jpg", $dirpath.$uniacid."_".$uid."_qrcode.jpg", "150", "150", "100");

	/* 合成二维码 */
	$savefield = $this->img_water_mark($bgimg, $dirpath.$uniacid."_".$uid."_qrcode.jpg", $dirpath, $uniacid."_".$uid.".png", "473", "733");
	
	/* 合成头像 */
	if(empty($member['avatar'])){
		$avatar = MODULE_URL."template/mobile/images/default_avatar.jpg";
	}else{
		$inc = strstr($member['avatar'], "http://");
		$avatar = $inc ? $member['avatar'].".jpg" : $_W['attachurl'].$member['avatar'];
	}

	$suffix = strtolower(substr(strrchr($avatar, '.'), 1));
	$this->saveImage($avatar, $dirpath.$uniacid."_".$uid."_","avatar.".$suffix);
	
	if($suffix=='png'){
		$im = imagecreatefrompng($dirpath.$uniacid."_".$uid."_avatar.png");
		imagejpeg($im, $dirpath.$uniacid."_".$uid."_avatar.jpg");
		imagedestroy($im);
		unlink($dirpath.$uniacid."_".$uid."_avatar.png");
	}
	
	$this->resize($dirpath.$uniacid."_".$uid."_avatar.jpg", $dirpath.$uniacid."_".$uid."_avatar.jpg", "100", "100", "100");
	$savefield = $this->img_water_mark($savefield, $dirpath.$uniacid."_".$uid."_avatar.jpg", "../attachment/images/fy_lessonv2/", $uniacid."_".$uid."_params_ok.png", "22", "698");

	/* 合成昵称 */
	$info = getimagesize($savefield);  
	/* 通过编号获取图像类型 */ 
	$type = image_type_to_extension($info[2],false);  
	/* 图片复制到内存 */
	$image = imagecreatefromjpeg($savefield);  
	  
	/* 设置字体的路径 */
	$font = "../addons/fy_lessonv2/template/mobile/ttf/yahei.ttf";  
	/* 设置字体颜色和透明度 */
	$color = imagecolorallocatealpha($image, 255, 255, 255, 0);
	/* 写入文字 */
	$fun = $dirpath.$uniacid."_".$uid.".png";
	imagettftext($image, 24, 0, 210, 728, $color, $font, $member['mc_nickname']);  
	/* 保存图片 */
	$fun = "image".$type;
	$okfield = $dirpath.$uniacid."_".$uid."_params_ok.png";
	$fun($image, $okfield);  
	/*销毁图片*/  
	imagedestroy($image);
	
	/* 删除多余文件 */
	unlink("../attachment/images/fy_lessonv2/".$uniacid."_".$uid.".png");
	unlink("../attachment/images/fy_lessonv2/".$uniacid."_".$uid."_qrcode.jpg");
	unlink("../attachment/images/fy_lessonv2/".$uniacid."_".$uid."_avatar.jpg");
	
	$imagepath = "../attachment/images/fy_lessonv2/".$uniacid."_".$uid."_params_ok.png";
}


include $this->template('qrcode');

?>