<?php
global $_GPC, $_W;
$action = 'start';
$GLOBALS['frames'] = $this->getNaveMenu($_COOKIE['cityname'], $action);
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from".tablename('chbl_sun_news')." where uniacid={$_W['uniacid']} and cityname='{$_COOKIE["cityname"]}' ORDER BY num ASC";
$total=pdo_fetchcolumn("select count(*) from".tablename('chbl_sun_news')." where uniacid={$_W['uniacid']} and cityname='{$_COOKIE["cityname"]}'");
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql);
$pager = pagination($total, $pageindex, $pagesize);
//$list=pdo_getall('chbl_sun_news',array('uniacid'=>$_W['uniacid']),array(),'','num ASC');
if($_GPC['op']=='delete'){
	$res=pdo_delete('chbl_sun_news',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl2('dlinnews'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['state']){
	$data['state']=$_GPC['state'];
	$res=pdo_update('chbl_sun_news',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl2('dlinnews'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/dlinnews');