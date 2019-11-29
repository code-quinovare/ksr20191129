<?php
/**
 * 文章公告
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
 
$this->setParentId(intval($_GPC['uid']));

$aid = intval($_GPC['aid']);/* 文章id */
$uid = $_W['member']['uid'];

if($op=='display'){
	$aid = intval($_GPC['aid']);
	$article = pdo_fetch("SELECT * FROM " .tablename($this->table_article). " WHERE id=:id", array(':id'=>$aid));
	if(empty($article)){
		message("该文章公告不存在！", "", "error");
	}
	$title = $article['title'];

	/* 增加访问量 */
	pdo_update($this->table_article, array('view'=>$article['view']+1), array('uniacid'=>$uniacid,'id'=>$aid));

	/* 分享设置 */
	$sharelink = unserialize($comsetting['sharelink']);
	$article['desc'] = substr(strip_tags(htmlspecialchars_decode($article['content'])), 0, 240);
	$article['images'] = $article['images']?$article['images']:$sharelink['images'];
	$shareurl = $uid ? $_W['siteroot'] .'app/'. $this->createMobileUrl('article', array('aid'=>$aid,'uid'=>$uid)) : '';

}elseif($op=='list'){
	$title = "全部公告";
	
	$pindex =max(1,$_GPC['page']);
	$psize = 10;

	$list = pdo_fetchall("SELECT * FROM " . tablename($this->table_article) . " WHERE uniacid=:uniacid AND isshow=:isshow ORDER BY displayorder DESC  LIMIT " . ($pindex-1) * $psize . ',' . $psize, array(':uniacid'=>$uniacid, ':isshow'=>1));
	foreach($list as $key=>$value){
		$list[$key]['addtime'] = date("Y-m-d H:i:s", $value['addtime']);
	}

	if($_GPC['method']=='ajaxgetlist'){
		echo json_encode($list);
	}
}

if($_W['isajax']!='true'){
	include $this->template('article');
}

?>