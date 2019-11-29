<?php
global $_GPC, $_W;
$action = 'start';
//$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$cur_store = $this->getStoreById($storeid);
$list = pdo_get('wpdc_type',array('id'=>$_GPC['id']));
			$data['order_by']=$_GPC['order_by'];
			$data['type_name']=$_GPC['type_name'];
			$data['is_open']=$_GPC['is_open'];
			$data['store_id']=$storeid;
			$data['uniacid']=$_W['uniacid'];
		if(checksubmit('submit')){
			if($_GPC['id']==''){
				$res=pdo_insert('wpdc_type',$data);
				if($res){
					message('添加成功',$this->createWebUrl2('dldishestype',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('wpdc_type', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl2('dldishestype',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/dladddishestype');