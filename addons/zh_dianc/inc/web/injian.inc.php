<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$list=pdo_getall('wpdc_reduction',array('store_id'=>$storeid));
if($_GPC['id']){
	$res=pdo_delete('wpdc_reduction',array('id'=>$_GPC['id']));
	if($res){
		 message('删除成功！', $this->createWebUrl('injian'), 'success');
		}else{
			  message('删除失败！','','error');
		}
}
include $this->template('web/injian');