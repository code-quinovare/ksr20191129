<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('chbl_sun_order',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
   if($_W['ispost']){
      $res = pdo_update('chbl_sun_order',array('state'=>$_GPC['state']),array('id'=>$_GPC['id']));
       if($res){
           message('修改成功',$this->createWebUrl('ddgl',array()),'success');
       }else{
           message('修改失败','','error');
       }
   }
}
include $this->template('web/orderinfo');