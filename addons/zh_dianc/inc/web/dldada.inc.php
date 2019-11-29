<?php
global $_GPC, $_W;
$action = 'start';
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
//$GLOBALS['frames'] = $this->getMainMenu2();
$info=pdo_get('wpdc_store',array('uniacid'=>$_W['uniacid'],'id'=>$storeid));
    if(checksubmit('submit')){
            $data['source_id']=$_GPC['source_id'];
            $data['shop_no']=$_GPC['shop_no'];
            //$data['ps_mode']=$_GPC['ps_mode'];

                $res = pdo_update('wpdc_store', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl2('dldada',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
           
        }
include $this->template('web/dldada');