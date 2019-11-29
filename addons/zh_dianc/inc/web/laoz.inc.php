<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu2();
$info=pdo_get('wpdc_store',array('uniacid'=>$_W['uniacid'],'id'=>$storeid));
    if(checksubmit('submit')){
            $data['is_jd']=$_GPC['is_jd'];
            $data['jd_time']=$_GPC['jd_time'];

                $res = pdo_update('wpdc_store', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('laoz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
           
        }
include $this->template('web/laoz');