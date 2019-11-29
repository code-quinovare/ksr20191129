<?php
defined('IN_IA') or exit('Access Denied');
define('BEST_CHAT', 'messikefu_chat');//聊天表
define('BEST_CSERVICE', 'messikefu_cservice');//客服表
define('BEST_CSERVICEGROUP', 'messikefu_cservicegroup');//客服组表
define('BEST_BIAOQIAN', 'messikefu_biaoqian');//粉丝标签
define('BEST_GROUP', 'messikefu_group');//群聊表
define('BEST_GROUPMEMBER', 'messikefu_groupmember');//群聊会员表
define('BEST_GROUPCONTENT', 'messikefu_groupchat');//群聊内容表
define('BEST_FANSKEFU', 'messikefu_fanskefu');//粉丝客服表
define('BEST_ADV', 'messikefu_adv');//幻灯片表
define('BEST_SANFANSKEFU', 'messikefu_sanfanskefu');//第三方
define('BEST_SANCHAT', 'messikefu_sanchat');//第三方
define('BEST_KEFUANDGROUP', 'messikefu_kefuandgroup');//第三方
define('BEST_PINGJIA', 'messikefu_pingjia');//评价
define('BEST_WENZHANG', 'messikefu_wenzhang');//评价
define('BEST_KEFUANDCJWT', 'messikefu_kefuandcjwt');//第三方
define('BEST_ZIDONGHUIFU', 'messikefu_zdhf');//第三方
define('BEST_XCX', 'messikefu_xcx');//第三方
define('BEST_XCXCSERVICE', 'messikefu_xcxcservice');//第三方
define('BEST_XCXFANSKEFU', 'messikefu_xcxfanskefu');//第三方
define('BEST_XCXCHAT', 'messikefu_xcxchat');//第三方
define('BEST_XCXAUTO', 'messikefu_xcxauto');//第三方

class Cy163_customerserviceModuleProcessor extends WeModuleProcessor {
	
	public function respond() {
		global $_W;
		$type = $this->message['type'];
		$cservice = pdo_fetch("SELECT * FROM ".tablename(BEST_CSERVICE)." WHERE weid = {$_W['uniacid']} AND ctype = 1 AND content = '{$this->module['config']['ckopenid']}'");
		if(!empty($cservice) && ($type == 'text' || $type == 'image')){
			$openid = $this->message['from'];
			
			$hasfanskefu = pdo_fetch("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansopenid = '{$openid}' AND kefuopenid = '{$cservice['content']}'");
			if(empty($hasfanskefu)){
				$datafanskefu['weid'] = $_W['uniacid'];
				$datafanskefu['fansopenid'] = $openid;
				$datafanskefu['kefuopenid'] = $cservice['content'];
				
				$account_api = WeAccount::create();
				$info = $account_api->fansQueryInfo($_W['fans']['from_user']);
				$datafanskefu['fansavatar'] = $info['headimgurl'];
				$datafanskefu['fansnickname'] = str_replace('\'', '\'\'',$info['nickname']);
				$datafanskefu['kefuavatar'] = tomedia($cservice['thumb']);
				$datafanskefu['kefunickname'] = $cservice['name'];
				pdo_insert(BEST_FANSKEFU,$datafanskefu);
				$hasfanskefu = pdo_fetch("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansopenid = '{$openid}' AND kefuopenid = '{$cservice['content']}'");
			}
			
			if($cservice['iszx'] == 1){
				if($cservice['isrealzx'] == 0){
					$notonlinemsg = !empty($cservice['notonline']) ? $cservice['notonline'] : '客服不在线哦！';
					return $this->respText($notonlinemsg);
				}
			}else{
				if($cservice['lingjie'] == 1){
					$nowhour = intval(date("H",TIMESTAMP));
					if(($nowhour+1) > $cservice['endhour'] && $nowhour < $cservice['starthour']){
						$notonlinemsg = !empty($cservice['notonline']) ? $cservice['notonline'] : '客服不在线哦！';
						return $this->respText($notonlinemsg);
					}
				}else{
					$nowhour = intval(date("H",TIMESTAMP));
					if($nowhour < $cservice['starthour'] || ($nowhour+1) > $cservice['endhour']){
						$notonlinemsg = !empty($cservice['notonline']) ? $cservice['notonline'] : '客服不在线哦！';
						return $this->respText($notonlinemsg);
					}
				}
			}
			
			$content = $this->message['content'];
			if($type == 'text'){
				$data['type'] = 1;
				$data['content'] = $content;
			}
			if($type == 'image'){
				$data['type'] = 4;
				$media_id = $this->message['mediaid'];
				$data['content'] = $this->getmedia($media_id);
			}
			
			
			$data['openid'] = $openid;
			$data['nickname'] = $hasfanskefu['fansnickname'];
			$data['avatar'] = $hasfanskefu['fansavatar'];
			$data['toopenid'] = $cservice['content'];
			$data['time'] = TIMESTAMP;
			
			$data['weid'] = $_W['uniacid'];
			$data['fkid'] = $hasfanskefu['id'];
			
			if($data['type'] == 3 || $data['type'] == 4){
				$tplcon = $data['nickname'].'发送了图片';
			}else{
				$tplcon = $data['content'];
			}
			$tplcon = $this->guolv($tplcon);
			pdo_insert(BEST_CHAT,$data);
			pdo_query("update ".tablename(BEST_FANSKEFU)." set notread=notread+1,guanlinum=guanlinum+1 where id=:id", array(":id" => $data['fkid']));
			
			$guotime = TIMESTAMP-$fanskefu['lasttime'];
			if($this->module['config']['istplon'] == 1 && $guotime > $this->module['config']['kefutplminute']){
				if(!empty($this->module['config']['tpl_kefu'])){				
					$or_paysuccess_redirect = $_W["siteroot"].'app/'.str_replace("./","",$this->createMobileUrl("servicechat",array('toopenid'=>$data['openid'])));		
					$postdata = array(
						'first' => array(
							'value' => $data['nickname'].'向你发起了咨询！',
							'color' => '#990000'
						),
						'keyword1' => array(
							'value' => $tplcon,
							'color' => '#ff510'
						),
						'keyword2' => array(
							'value' => "点击此消息尽快回复",
							'color' => '#ff510'
						),
						'remark' => array(
							'value' => '咨询时间：'.date("Y-m-d H:i:s",TIMESTAMP),
							'color' => '#ff510'
						),							
					);
					$account_api = WeAccount::create();
					$account_api->sendTplNotice($data['toopenid'],$this->module['config']['tpl_kefu'],$postdata,$or_paysuccess_redirect,'#980000');
					
				}else{
					$texturl = $_W["siteroot"].'app/'.str_replace("./","",$this->createMobileUrl("servicechat",array('toopenid'=>$data['openid'])));
					$concon = $data['nickname'].'发起了咨询！'.$tplcon.'。';
					$row = array();
					$row['title'] = urlencode('新消息提醒');
					$row['description'] = urlencode($concon);
					$row['picurl'] = $_W["siteroot"].'/addons/cy163_customerservice/static/tuwen.jpg';
					$row['url'] = $texturl;
					$news[] = $row;
					$send['touser'] = $data['toopenid'];
					$send['msgtype'] = 'news';
					$send['news']['articles'] = $news;
					$account_api = WeAccount::create();
					$account_api->sendCustomNotice($send);
				}
			}
			pdo_query("update ".tablename(BEST_FANSKEFU)." set fansdel=0,kefudel=0,lastcon='{$data['content']}',msgtype={$data['type']},lasttime=:lasttime where id=:id", array(":lasttime" => TIMESTAMP, ":id" => $data['fkid']));	
		}
	}
	
	public function guolv($content){
		if(!empty($this->module['config']['mingan'])){
			$sensitivewordarr = explode("|",$this->module['config']['mingan']);
			foreach($sensitivewordarr as $k=>$v){
				if(!empty($v)){
					$content = str_replace($v,"***",$content);
				}
			}
		}
		$content = str_replace("\n","<br>",$content);
		return $content;
	}
	
	public function getmedia($media_id){
		global $_W, $_GPC;
		$access_token = WeAccount::token();
		$url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$media_id;
		$updir = "../attachment/images/".$_W['uniacid']."/".date("Y",time())."/".date("m",time())."/";
        if (!file_exists($updir)) {
            mkdir($updir, 0777, true);
        }
		$randimgurl = "images/".$_W['uniacid']."/".date("Y",time())."/".date("m",time())."/".date('YmdHis').rand(1000,9999).'.jpg';
        $targetName = "../attachment/".$randimgurl;
        $ch = curl_init($url); // 初始化
        $fp = fopen($targetName, 'wb'); // 打开写入
        curl_setopt($ch, CURLOPT_FILE, $fp); // 设置输出文件的位置，值是一个资源类型
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
		if(file_exists($targetName)){
			$resarr['error'] = 0;			
			$this->mkThumbnail($targetName,640,0,$targetName);
			//上传到远程
			if($this->module['config']['isqiniu'] == 1){
				$remotestatus = $this->doQiuniu($randimgurl,true);
				return $this->module['config']['qiniuurl']."/".$randimgurl;
			}elseif($this->module['config']['isqiniu'] == 3){
				if(!empty($_W['setting']['remote']['type'])){
					load()->func('file');
					$remotestatus = file_remote_upload($randimgurl,true);
					return tomedia($randimgurl);
				}
			}
			return tomedia($randimgurl);
		}
    }
	
	public function doQiuniu($filename, $auto_delete_local = true){
		global $_W;
		load()->func('file');
		require_once(IA_ROOT . '/framework/library/qiniu/autoload.php');
		$auth = new Qiniu\Auth($this->module['config']['qiniuaccesskey'],$this->module['config']['qiniusecretkey']);
		$config = new Qiniu\Config();
		$uploadmgr = new Qiniu\Storage\UploadManager($config);
		$putpolicy = Qiniu\base64_urlSafeEncode(json_encode(array('scope' => $this->module['config']['qiniubucket'].':'. $filename)));
		$uploadtoken = $auth->uploadToken($this->module['config']['qiniubucket'], $filename, 3600, $putpolicy);
		list($ret, $err) = $uploadmgr->putFile($uploadtoken, $filename, ATTACHMENT_ROOT. '/'.$filename);
		if ($auto_delete_local) {
			file_delete($filename);
		}
		if ($err !== null) {
			$resarr['error'] = 1;
			$resarr['message'] = '远程附件上传失败，请检查配置并重新上传';
			die(json_encode($resarr));
		} else {
			return true;
		}
	}
	
	/** 
	 * 生成缩略图函数（支持图片格式：gif、jpeg、png和bmp） 
	 * @author ruxing.li 
	 * @param  string $src      源图片路径 
	 * @param  int    $width    缩略图宽度（只指定高度时进行等比缩放） 
	 * @param  int    $width    缩略图高度（只指定宽度时进行等比缩放） 
	 * @param  string $filename 保存路径（不指定时直接输出到浏览器） 
	 * @return bool 
	 */  
	public function mkThumbnail($src, $width = null, $height = null, $filename = null) {  
		if (!isset($width) && !isset($height))  
			return false;  
		if (isset($width) && $width <= 0)  
			return false;  
		if (isset($height) && $height <= 0)  
			return false;  
	  
		$size = getimagesize($src);  
		if (!$size)  
			return false;  
	  
		list($src_w, $src_h, $src_type) = $size;  
		$src_mime = $size['mime'];  
		switch($src_type) {  
			case 1 :  
				$img_type = 'gif';  
				break;  
			case 2 :  
				$img_type = 'jpeg';  
				break;  
			case 3 :  
				$img_type = 'png';  
				break;  
			case 15 :  
				$img_type = 'wbmp';  
				break;  
			default :  
				return false;  
		}  
	  
		if (!isset($width))  
			$width = $src_w * ($height / $src_h);  
		if (!isset($height))  
			$height = $src_h * ($width / $src_w);  
	  
		$imagecreatefunc = 'imagecreatefrom' . $img_type;  
		$src_img = $imagecreatefunc($src);  
		$dest_img = imagecreatetruecolor($width, $height);  
		imagecopyresampled($dest_img, $src_img, 0, 0, 0, 0, $width, $height, $src_w, $src_h);  
	  
		$imagefunc = 'image' . $img_type;  
		if ($filename) {  
			$imagefunc($dest_img, $filename);  
		} else {  
			header('Content-Type: ' . $src_mime);  
			$imagefunc($dest_img);  
		}  
		imagedestroy($src_img);  
		imagedestroy($dest_img);  
		return true;  
	}
}