<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$item=pdo_get('wpdc_ydorder',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
	$data['link_name']=$_GPC['link_name'];
	$data['link_tel']=$_GPC['link_tel'];
	$data['yjdd_date']=$_GPC['yjdd_date'];
	$data['jc_num']=$_GPC['jc_num'];
	$data['remark']=$_GPC['remark'];
	// $data['state']=$_GPC['state'];
	$res=pdo_update('wpdc_ydorder',$data,array('id'=>$_GPC['id']));
	if($res){
             message('编辑成功！', $this->createWebUrl('inydorder'), 'success');
        }else{
             message('编辑失败！','','error');
        }
}
include $this->template('web/inydorderinfo');