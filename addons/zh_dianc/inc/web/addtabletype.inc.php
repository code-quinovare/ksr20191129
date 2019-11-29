<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu2();
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$list = pdo_get('wpdc_table_type',array('id'=>$_GPC['id']));
			$data['name']=$_GPC['name'];
			$data['fw_cost']=$_GPC['fw_cost'];
			$data['zd_cost']=$_GPC['zd_cost'];
			$data['yd_cost']=$_GPC['yd_cost'];
			$data['num']=$_GPC['num'];
			$data['orderby']=$_GPC['orderby'];
			$data['ss_seller']=$_GPC['ss_seller'];
			$data['seller_id']=$storeid;
			$data['uniacid']=$_W['uniacid'];
		if(checksubmit('submit')){
			if($_GPC['id']==''){
				$res=pdo_insert('wpdc_table_type',$data);
				if($res){
					message('添加成功',$this->createWebUrl('tabletype2',array()),'success');
				}else{
					message('添加失败','','error');
				}
			}else{
				$res = pdo_update('wpdc_table_type', $data, array('id' => $_GPC['id']));
				if($res){
					message('编辑成功',$this->createWebUrl('tabletype2',array()),'success');
				}else{
					message('编辑失败','','error');
				}
			}
		}
include $this->template('web/addtabletype');