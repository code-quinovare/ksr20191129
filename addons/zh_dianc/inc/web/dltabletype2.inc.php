<?php
global $_GPC, $_W;
$action = 'start';
//$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$list = pdo_getall('wpdc_table_type',array('uniacid' => $_W['uniacid'],'seller_id'=>$storeid), array() , '' , 'orderby ASC');
if($_GPC['id']){
		$result = pdo_delete('wpdc_table_type', array('id'=>$_GPC['id']));
		if($result){
			message('删除成功',$this->createWebUrl2('dltabletype2',array()),'success');
		}else{
		message('删除失败','','error');
		}
	}


include $this->template('web/dltabletype2');