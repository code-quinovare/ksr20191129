<?php

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
 
class Cy163_customerserviceModuleWxapp extends WeModuleWxapp {
  
	public function __construct() {

	}
  
    public function doPageMessiopenid() {
      global $_W,$_GPC;
      $userinfo = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid={$_W['account']['key']}&secret={$_W['account']['secret']}&js_code={$_GPC['code']}&grant_type=authorization_code");
      $userinfo = json_decode($userinfo,true);
      $this->result(0,'用户信息', $userinfo);
    }
	
	public function doPageAdvlist() {
      	global $_W,$_GPC;
      	$advlist = pdo_fetchall("SELECT * FROM ".tablename(BEST_ADV)." WHERE weid = {$_W['uniacid']} ORDER BY displayorder ASC");
     	foreach($advlist as $k=>$v){
          $data[$k]['advthumb'] = tomedia($v['thumb']);
        }
		$this->result(0,'幻灯片列表', $data);
	}
  
    public function doPageKefuzulist() {
      	global $_W,$_GPC;
		$gzhid = $this->module['config']['gzhid'];
   		$cservicegrouplist = pdo_fetchall("SELECT * FROM ".tablename(BEST_CSERVICEGROUP)." WHERE weid = {$gzhid} AND ishow = 1 ORDER BY displayorder ASC");
     	foreach($cservicegrouplist as $k=>$v){
          $data[$k]['thumb'] = tomedia($v['thumb']);
          $data[$k]['name'] = $v['name'];
          $data[$k]['fname'] = $v['typename'];
          $data[$k]['id'] = $v['id'];
        }
		$this->result(0,'客服列表', $data);
	}
  
  
    public function doPageZukefulist() {
      	global $_W,$_GPC;
		$gzhid = $this->module['config']['gzhid'];
    	$id = intval($_GPC['id']);
        $kefuandgroup = pdo_fetchall("SELECT kefuid FROM ".tablename(BEST_KEFUANDGROUP)." WHERE weid = {$gzhid} AND groupid = {$id}");
		
		$kefuids[] = 0;
		foreach($kefuandgroup as $k=>$v){
			$kefuids[] = $v['kefuid'];
		}
		
		$cservicelist = pdo_fetchall("SELECT * FROM ".tablename(BEST_CSERVICE)." WHERE weid = {$gzhid} AND (ishow = 0 OR (isrealzx = 1 AND ishow = 2 AND iszx = 1)) AND (groupid = {$id} OR id in (".implode(',',$kefuids).")) ORDER BY displayorder ASC");
     	foreach($cservicelist as $k=>$v){
          $data[$k]['thumb'] = tomedia($v['thumb']);
          $data[$k]['name'] = $v['name'];
          $data[$k]['fname'] = $v['typename'];
          $data[$k]['content'] = $v['content'];
        }
        $cservicegroup = pdo_fetch("SELECT * FROM ".tablename(BEST_CSERVICEGROUP)." WHERE weid = {$gzhid} AND id = {$id}");
     	$this->result(0,$cservicegroup['name'], $data);
	}

  
  	public function doPageKefulist() {
      	global $_W,$_GPC;
		$gzhid = $this->module['config']['gzhid'];
        $cservicelist = pdo_fetchall("SELECT * FROM ".tablename(BEST_CSERVICE)." WHERE weid = {$gzhid} AND (ishow = 0 OR (isrealzx = 1 AND ishow = 2 AND iszx = 1)) AND ctype = 1 AND groupid = 0 ORDER BY displayorder ASC");
     	foreach($cservicelist as $k=>$v){
          $kefuandgroup = pdo_fetch("SELECT id FROM ".tablename(BEST_KEFUANDGROUP)." WHERE kefuid = {$v['id']}");
          if(empty($kefuandgroup)){
            $data[$k]['thumb'] = tomedia($v['thumb']);
            $data[$k]['name'] = $v['name'];
            $data[$k]['fname'] = $v['typename'];
            $data[$k]['content'] = $v['content'];
          }
        }
		$this->result(0,'客服列表', $data);
	}
  
  	public function doPageChatlist() {
      	global $_W,$_GPC;
		$gzhid = $this->module['config']['gzhid'];
        $openid = trim($_GPC['openid']);
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansopenid = '{$openid}' AND lastcon != '' AND fansdel = 0");
        $allpage = ceil($total/10)+1;
        $page = intval($_GPC["page"]);
        $pindex = max(1, $page);
        $psize = 10;
        $chatlist = pdo_fetchall("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansopenid = '{$openid}' AND lastcon != '' AND fansdel = 0 ORDER BY notread DESC,lasttime DESC LIMIT ".($pindex - 1)*$psize.",".$psize);
        foreach($chatlist as $k=>$v){
          $data[$k]['avatar'] = $v['kefuavatar'];
          $data[$k]['nickname'] = $v['kefunickname'];
          $data[$k]['openid'] = $v['kefuopenid'];
          $data[$k]['content'] = $v['lastcon'];
          $data[$k]['time'] = $v['lasttime'] > 0 ? $this->format_date($v['lasttime']) : '无';
        }
		$this->result(0,'消息列表', $data);
	}
  
    public function doPageChatlistdetail() {
      	global $_W,$_GPC;
		$gzhid = $this->module['config']['gzhid'];
     	$toopenid = trim($_GPC['toopenid']);
      	$openid = trim($_GPC['openid']);
      	$cservice = pdo_fetch("SELECT * FROM ".tablename(BEST_CSERVICE)." WHERE weid = {$gzhid} AND ctype = 1 AND content = '{$toopenid}'");
     	$hasfanskefu = pdo_fetch("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansopenid = '{$openid}' AND kefuopenid = '{$toopenid}'");
		if(empty($hasfanskefu)){
			$datafanskefu['weid'] = $_W['uniacid'];
			$datafanskefu['fansopenid'] = $openid;
			$datafanskefu['kefuopenid'] = $cservice['content'];
			$datafanskefu['fansavatar'] = trim($_GPC['avatar']);
			$datafanskefu['fansnickname'] = trim($_GPC['nickname']);
			$datafanskefu['kefuavatar'] = tomedia($cservice['thumb']);
			$datafanskefu['kefunickname'] = $cservice['name'];
			$datafanskefu['isxcx'] = 1;
			pdo_insert(BEST_FANSKEFU,$datafanskefu);
			$hasfanskefu = pdo_fetch("SELECT * FROM ".tablename(BEST_FANSKEFU)." WHERE weid = {$_W['uniacid']} AND fansopenid = '{$openid}' AND kefuopenid = '{$toopenid}'");
		}

        $chatcon = pdo_fetchall("SELECT * FROM ".tablename(BEST_CHAT)." WHERE fkid = {$hasfanskefu['id']} AND fansdel = 0 ORDER BY time ASC");
		$chatcontime = 0;
        foreach($chatcon as $k=>$v){
			$stripcon = strip_tags($v['content']);
			if($stripcon != '' && ($v['type'] == 1 || $v['type'] == 2)){
				$data[$k]['avatar'] = $openid == $v['openid'] ? $hasfanskefu['fansavatar'] : $hasfanskefu['kefuavatar'];
				$data[$k]['nickname'] = $openid == $v['openid'] ? $hasfanskefu['fansnickname'] : $hasfanskefu['kefunickname'];
				$data[$k]['content'] = $stripcon;
				$data[$k]['type'] = $v['type'];
				if(($v['time'] - $chatcontime) > 7200){
					$data[$k]['time'] = date("Y-m-d H:i:s",$v['time']);
				}else{
					$data[$k]['time'] = '';
				}
				$chatcontime = $v['time'];
				$data[$k]['leftright'] = $openid == $v['openid'] ? 'right' : 'left';
			}
        }
		$res['fkid'] = $hasfanskefu['id'];
		$res['allpage'] = $allpage;
		$res['chatlist'] = $data;
		if($cservice['autoreply'] != ''){
			$res['replycon'] = strip_tags($cservice['autoreply']);
			$res['replytime'] = date("Y-m-d H:i:s",TIMESTAMP);
			$res['replyavatar'] = $hasfanskefu['kefuavatar'];
		}
		$this->result(0,'和'.$cservice['name'].'的对话', $res);
	}
	
	public function doPageAddchat() {
		global $_W,$_GPC;
		$gzhid = $this->module['config']['gzhid'];
		$fkid = intval($_GPC['fkid']);
		$toopenid = trim($_GPC['toopenid']);
		$chatcon = trim($_GPC['chatcon']);
		$cservice = pdo_fetch("SELECT * FROM ".tablename(BEST_CSERVICE)." WHERE weid = {$gzhid} AND ctype = 1 AND content = '{$toopenid}'");
		if($cservice['iszx'] == 1){
			if($cservice['isrealzx'] == 0){
				$notonlinemsg = !empty($cservice['notonline']) ? $cservice['notonline'] : '客服不在线哦！';
				$this->result(0,$notonlinemsg, 1);
			}
		}else{
			if($cservice['lingjie'] == 1){
				$nowhour = intval(date("H",TIMESTAMP));
				if(($nowhour+1) > $cservice['endhour'] && $nowhour < $cservice['starthour']){
					$notonlinemsg = !empty($cservice['notonline']) ? $cservice['notonline'] : '客服不在线哦！';
					$this->result(0,$notonlinemsg, 1);
				}
			}else{
				$nowhour = intval(date("H",TIMESTAMP));
				if($nowhour < $cservice['starthour'] || ($nowhour+1) > $cservice['endhour']){
					$notonlinemsg = !empty($cservice['notonline']) ? $cservice['notonline'] : '客服不在线哦！';
					$this->result(0,$notonlinemsg, 1);
				}
			}
		}
		$data['weid'] = $_W['uniacid'];
		$data['openid'] = trim($_GPC['openid']);
		$data['toopenid'] = $toopenid;
		$data['nickname'] = trim($_GPC['nickname']);
		$data['avatar'] =  trim($_GPC['avatar']);
		$data['fkid'] = $fkid;
		$data['time'] = TIMESTAMP;
		$data['content'] = $chatcon;
		$data['type'] = 1;
		pdo_insert(BEST_CHAT,$data);
		$fanskefu = pdo_fetch("SELECT lasttime,kfzx FROM ".tablename(BEST_FANSKEFU)." WHERE id = {$fkid}");
		$dataup['notread'] = $fanskefu['notread']+1;
		$dataup['guanlinum'] = $fanskefu['guanlinum']+1;
		$dataup['fansdel'] = 0;
		$dataup['kefudel'] = 0;
		$dataup['lastcon'] = $chatcon;
		$dataup['msgtype'] = 1;
		$dataup['lasttime'] = TIMESTAMP;
		pdo_update(BEST_FANSKEFU,$dataup,array('id'=>$fkid));
		$this->result(0,'发送成功',0);
	}
  
  	public function format_date($time){
		$t=time()-$time;
		$f=array(
			'31536000'=>'年',
			'2592000'=>'个月',
			'604800'=>'星期',
			'86400'=>'天',
			'3600'=>'小时',
			'60'=>'分钟',
			'1'=>'秒'
		);
		foreach ($f as $k=>$v)    {
			if (0 !=$c=floor($t/(int)$k)) {
				return $c.$v.'前';
			}
		}
	}

}
