<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            // $data['tx_rate']=$_GPC['tx_rate'];
            $data['tx_money']=$_GPC['tx_money'];
            $data['is_zfb']=$_GPC['is_zfb'];
            $data['is_yhk']=$_GPC['is_yhk'];
            $data['is_wx']=$_GPC['is_wx'];
            $data['uniacid']=$_W['uniacid'];
            $data['tx_details']=html_entity_decode($_GPC['tx_details']);
            if($_GPC['id']==''){                
                $res=pdo_insert('wpdc_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('txsz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('wpdc_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('txsz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
include $this->template('web/txsz');