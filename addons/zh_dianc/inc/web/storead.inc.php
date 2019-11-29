<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);	
$list=pdo_getall('wpdc_ad',array('uniacid'=>$_W['uniacid'],'store_id'=>$storeid),array(),'','orderby ASC');
if($_GPC['id']){
	$res=pdo_delete('wpdc_ad',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('storead'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
include $this->template('web/storead');