<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
 $item=pdo_get('wpdc_sms',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
            $data['tid']=trim($_GPC['tid']);
            $data['yy_tid']=trim($_GPC['yy_tid']);
             $data['dm_tid']=trim($_GPC['dm_tid']);
             $data['sj_tid']=trim($_GPC['sj_tid']);
             $data['sj_tid2']=trim($_GPC['sj_tid2']);
             $data['wx_appid']=trim($_GPC['wx_appid']);
             $data['wx_secret']=trim($_GPC['wx_secret']);
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){                
                $res=pdo_insert('wpdc_sms',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('wpdc_sms', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('template',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/template');