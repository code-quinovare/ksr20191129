<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$pageindex = max(1, intval($_GPC['page']));
$pagesize=10;
$sql="select * from".tablename('chbl_sun_ad')." where uniacid={$_W['uniacid']} and cityname='{$_COOKIE["cityname"]}' ORDER BY orderby ASC";
$total=pdo_fetchcolumn("select count(*) from".tablename('chbl_sun_ad')." where uniacid={$_W['uniacid']} and cityname='{$_COOKIE["cityname"]}' ");
$select_sql =$sql." LIMIT " .($pageindex - 1) * $pagesize.",".$pagesize;
$list=pdo_fetchall($select_sql);
$pager = pagination($total, $pageindex, $pagesize);
//$list=pdo_getall('chbl_sun_ad',array('uniacid'=>$_W['uniacid']),array(),'','orderby ASC');
if($_GPC['op']=='delete'){
	$res=pdo_delete('chbl_sun_ad',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('inad'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
if($_GPC['status']){
	$data['status']=$_GPC['status'];
	$res=pdo_update('chbl_sun_ad',$data,array('id'=>$_GPC['id']));
	if($res){
		 message('编辑成功！', $this->createWebUrl('inad'), 'success');
		}else{
			  message('编辑失败！','','error');
		}
}
include $this->template('web/inad');