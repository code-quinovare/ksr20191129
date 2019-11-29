<?php
/**
 * 记录播放章节
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

$lessonid    = intval($_GPC['lessonid']);
$sectionid   = intval($_GPC['sectionid']);
$uid	     = intval($_GPC['uid']);
$currentTime = intval($_GPC['currentTime']);

if(empty($uid)){
	return;
}

$record = pdo_fetch("SELECT * FROM " .tablename($this->table_playrecord). " WHERE uniacid=:uniacid AND uid=:uid AND lessonid=:lessonid AND sectionid=:sectionid LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':lessonid'=>$lessonid,':sectionid'=>$sectionid));
$data = array(
	'uniacid'	 => $uniacid,
	'uid'		 => $uid,
	'lessonid'   => $lessonid,
	'sectionid'  => $sectionid,
	'playtime'	 => $currentTime,
	'addtime'	 => time(),
);

if(empty($record)){
	$r = pdo_insert($this->table_playrecord, $data);
}else{
	pdo_update($this->table_playrecord, $data, array('uniacid'=>$uniacid,'uid'=>$uid,'lessonid'=>$lessonid, 'sectionid'=>$sectionid));
}

?>