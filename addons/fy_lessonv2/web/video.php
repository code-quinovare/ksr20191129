<?php
/**
 * 视频管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

$qiniu = unserialize($setting['qiniu']);
if(!empty($qiniu['url'])){
	$qiniu['url'] = "http://".str_replace("http://","",$qiniu['url'])."/";
}

$qcloud = unserialize($setting['qcloud']);
if(!empty($qcloud['url'])){
	$qcloud['url'] = "http://".$qcloud['url'];
}

if($op=='display'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = " uniacid=:uniacid AND teacher=:teacher ";
	$params[':uniacid'] = $uniacid;
	$params[':teacher'] = 0;
	if(!empty($_GPC['keyword'])){
		$condition .= " AND name LIKE :name ";
		$params[':name'] = "%".trim($_GPC['keyword'])."%";
	}
	if (!empty($_GPC['time']['start'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		$endtime = !empty($endtime) ? $endtime + 86399 : 0;
		if (!empty($starttime)) {
			$condition .= " AND addtime>=:starttime ";
			$params[':starttime'] = $starttime;
		}
		if (!empty($endtime)) {
			$condition .= " AND addtime<=:endtime ";
			$params[':endtime'] = $endtime;
		}
	}

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_qiniu_upload). " WHERE {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);
	foreach($list as $key=>$value){
		if(!empty($qiniu['url'])){
			$list[$key]['qiniu_url'] = $qiniu['url'].$value['com_name'];
		}

		$list[$key]['play_url'] = $this->privateDownloadUrl($qiniu['access_key'], $qiniu['secret_key'], $list[$key]['qiniu_url']);
		if($qiniu['https']){
			$list[$key]['play_url'] = str_replace("http://", "https://", $list[$key]['play_url']);
		}

		$tmp = explode('.', $value['name']);
		$list[$key]['suffix'] = strtolower($tmp[count($tmp)-1]);
	}

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_qiniu_upload). " WHERE {$condition}", $params);
	$pager = pagination($total, $pindex, $psize);

	include $this->template('qiniu');

}elseif($op=='upqiniu'){
	/* 引入七牛云存储API接口 */
	require_once(MODULE_ROOT.'/library/Qiniu/autoload.php');

	$auth = new Qiniu\Auth($qiniu['access_key'], $qiniu['secret_key']);
	$token = $auth->uploadToken($qiniu['bucket']);

	include $this->template('qiniu');

}elseif($op=='saveQiniuUrl'){
	$data = array(
		'uniacid'	=> $uniacid,
		'uid'		=> '',
		'openid'	=> '',
		'teacher'	=> '',
		'name'		=> trim($_GPC['name']),
		'com_name'	=> trim($_GPC['com_name']),
		'qiniu_url' => $qiniu['url'].trim($_GPC['com_name']),
		'size'		=> intval($_GPC['size']),
		'addtime'	=> time(),
	);
	pdo_insert($this->table_qiniu_upload, $data);

}elseif($op=='delQiniu'){
	$id = intval($_GPC['id']);
	$file = pdo_fetch("SELECT * FROM " .tablename($this->table_qiniu_upload). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid, ':id'=>$id));
	if(empty($file)){
		message("该文件不存在!", "", "error");
	}
	if(pdo_delete($this->table_qiniu_upload, array('id'=>$id))){
		message("删除成功!", $this->createWebUrl('video'), "success");
	}else{
		message("删除失败!", "", "error");
	}

}elseif($op=='qcloud'){
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = " uniacid=:uniacid AND teacherid=:teacherid ";
	$params[':uniacid'] = $uniacid;
	$params[':teacherid'] = 0;
	if(!empty($_GPC['keyword'])){
		$condition .= " AND name LIKE :name ";
		$params[':name'] = "%".trim($_GPC['keyword'])."%";
	}
	if (!empty($_GPC['time']['start'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		$endtime = !empty($endtime) ? $endtime + 86399 : 0;
		if (!empty($starttime)) {
			$condition .= " AND addtime>=:starttime ";
			$params[':starttime'] = $starttime;
		}
		if (!empty($endtime)) {
			$condition .= " AND addtime<=:endtime ";
			$params[':endtime'] = $endtime;
		}
	}

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_qcloud_upload). " WHERE {$condition} ORDER BY id DESC LIMIT " . ($pindex - 1) * $psize . ',' . $psize, $params);

	foreach($list as $key=>$value){
		if(!empty($qcloud['url'])){
			$tmp_url = explode("myqcloud.com", $value['sys_link']);
			$list[$key]['sys_link'] = $qcloud['url'].$tmp_url[1];
		}

		$list[$key]['play_url'] = $this->tencentDownloadUrl($qcloud, $list[$key]['sys_link']);
		if($qcloud['https']){
			$list[$key]['play_url'] = str_replace("http://", "https://", $list[$key]['play_url']);
		}

		$tmp = explode('.', $value['name']);
		$list[$key]['suffix'] = strtolower($tmp[count($tmp)-1]);
	}

	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM " .tablename($this->table_qcloud_upload). " WHERE {$condition}", $params);
	$pager = pagination($total, $pindex, $psize);

	include $this->template('qcloud');

}elseif($op=='upqcloud'){
	/* 引入腾讯云存储API接口 */
	require_once(MODULE_ROOT.'/library/Qcloud/include.php');

	$expired = time() + 3600;
	$signature = QcloudCos\Auth::createReusableSignature($expired, $qcloud['bucket'], $filepath = null, $qcloud);

	include $this->template('qcloud');

}elseif($op=='saveQcloudUrl'){
	$com_name = urldecode($_GPC['com_name']);
	$sys_link = trim($_GPC['sys_link']);
	$size = trim($_GPC['size']);

	$data = array(
		'uniacid'	=> $uniacid,
		'uid'		=> '',
		'teacherid'	=> '',
		'name'		=> str_replace("/admin/", "", $com_name),
		'com_name'	=> $_GPC['com_name'],
		'sys_link'  => $sys_link,
		'size'		=> $size,
		'addtime'	=> time(),
	);
	pdo_insert($this->table_qcloud_upload, $data);

}elseif($op=='delQcloud'){
	$id = intval($_GPC['id']);
	$file = pdo_fetch("SELECT * FROM " .tablename($this->table_qcloud_upload). " WHERE uniacid=:uniacid AND id=:id", array(':uniacid'=>$uniacid, ':id'=>$id));
	if(empty($file)){
		message("该文件不存在!", "", "error");
	}
	if(pdo_delete($this->table_qcloud_upload, array('id'=>$id))){
		message("删除成功!", $this->createWebUrl('video', array('op'=>'qcloud')), "success");
	}else{
		message("删除失败!", "", "error");
	}
}



