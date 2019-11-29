<?php
/**
 * 收藏课程或讲师
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
checkauth();

$ctype = trim($_GPC['ctype']);
$id = intval($_GPC['id']);
$uid = intval($_GPC['uid']);

if($ctype=='lesson'){
	$collect = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_collect). " WHERE uniacid=:uniacid AND uid=:uid AND outid=:outid AND ctype=:ctype LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':outid'=>$id,':ctype'=>1));
	if(empty($collect)){
		$insertdata = array(
			'uniacid' => $uniacid,
			'uid'	  => $uid,
			'outid'   => $id,
			'ctype'   => 1,
			'addtime' => time(),
		);
		pdo_insert($this->table_lesson_collect, $insertdata);
		echo '1';
	}else{
		pdo_delete($this->table_lesson_collect, array('uniacid'=>$uniacid,'uid'=>$uid,'outid'=>$id,'ctype'=>1));
		echo '2';
	}

}elseif($ctype=='teacher'){
	$collect = pdo_fetch("SELECT * FROM " .tablename($this->table_lesson_collect). " WHERE uniacid=:uniacid AND uid=:uid AND outid=:outid AND ctype=:ctype LIMIT 1", array(':uniacid'=>$uniacid,':uid'=>$uid,':outid'=>$id,':ctype'=>2));
	if(empty($collect)){
		$insertdata = array(
			'uniacid' => $uniacid,
			'uid'	  => $uid,
			'outid'   => $id,
			'ctype'   => 2,
			'addtime' => time(),
		);
		pdo_insert($this->table_lesson_collect, $insertdata);
		echo '1';
	}else{
		pdo_delete($this->table_lesson_collect, array('uniacid'=>$uniacid,'uid'=>$uid,'outid'=>$id,'ctype'=>2));
		echo '2';
	}

}


?>