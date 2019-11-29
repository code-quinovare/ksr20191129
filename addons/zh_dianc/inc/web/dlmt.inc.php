<?php
global $_GPC, $_W;
$action = 'start';
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
//$GLOBALS['frames'] = $this->getMainMenu2();
$GLOBALS['frames'] = $this->getNaveMenu($storeid, $action);
$info=pdo_get('wpdc_store',array('uniacid'=>$_W['uniacid'],'id'=>$storeid));
    if(checksubmit('submit')){
            $data['is_mp3']=$_GPC['is_mp3'];
            $data['is_video']=$_GPC['is_video'];
            $data['store_mp3']=$_GPC['store_mp3'];
            $data['store_video']=$_GPC['store_video'];
                $res = pdo_update('wpdc_store', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl2('dlmt',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
           
        }
include $this->template('web/dlmt');