<?php
global $_GPC, $_W;
$action = 'start';
//$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$item=pdo_get('wpdc_order',array('id'=>$_GPC['id']));
$goods=pdo_getall('wpdc_goods',array('order_id'=>$_GPC['id']));
if(checksubmit('submit')){
	// $data['state']=$_GPC['state'];
	$data['money']=$_GPC['money'];
	$data['preferential']=$_GPC['preferential'];
	// if($_GPC['dn_state']=="2"){
	// 	$data['pay_time']=time();
	// }
	$res=pdo_update('wpdc_order',$data,array('id'=>$_GPC['id']));
	if($res){
             message('编辑成功！', $this->createWebUrl2('dlinorder'), 'success');
        }else{
             message('编辑失败！','','error');
        }
}
include $this->template('web/dlinorderinfo');