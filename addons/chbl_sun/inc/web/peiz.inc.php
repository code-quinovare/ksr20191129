<?php
global $_GPC, $_W;
// $action = 'ad';
// $title = $this->actions_titles[$action];
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('chbl_sun_system',array('uniacid'=>$_W['uniacid']));
    if(checksubmit('submit')){
//        if(strpos($_GPC['cityname'],'市') === false){
//             message('城市名称填写不规范,已市结尾','','error');
//        }
            $data['cityname']=trim($_GPC['cityname']);
            $data['appid']=trim($_GPC['appid']);
            $data['appsecret']=trim($_GPC['appsecret']);
            $data['mapkey']=trim($_GPC['mapkey']);
            $data['gd_key']=trim($_GPC['gd_key']);
            $data['mchid']=trim($_GPC['mchid']);
            $data['wxkey']=trim($_GPC['wxkey']);
            if($_GPC['appid']==''){
                message('小程序appid不能为空!','','error'); 
            }
            if($_GPC['appsecret']==''){
                message('小程序appsecret不能为空!','','error'); 
            }
            $data['uniacid']=trim($_W['uniacid']);
            if($_GPC['id']==''){                
                $res=pdo_insert('chbl_sun_system',$data);
                if($res){
                    message('添加成功',$this->createWebUrl('peiz',array()),'success');
                }else{
                    message('添加失败','','error');
                }
            }else{
                $res = pdo_update('chbl_sun_system', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('peiz',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
            }
        }
    include $this->template('web/peiz');