<?php
global $_GPC, $_W;
$GLOBALS['frames'] = $this->getMainMenu();
$item=pdo_get('zhvip_store',array('id'=>$_GPC['id']));
if(checksubmit('submit')){
      $data['coordinates']=$_GPC['coordinates'];
      $data['logo']=$_GPC['logo'];
      $data['name']=$_GPC['name'];
      $data['tel']=$_GPC['tel'];
      $data['address']=$_GPC['address'];
      $data['announcement']=$_GPC['announcement'];
       $data['num']=$_GPC['num'];
       $data['md_img']=$_GPC['md_img'];
        $data['md_img2']=$_GPC['md_img2'];
        $data['sentiment']=$_GPC['sentiment'];
      $data['is_default']=$_GPC['is_default'];
      $data['uniacid']=$_W['uniacid'];
       if($_GPC['id']==''){  
        $res=pdo_insert('zhvip_store',$data);
        if($res){
             message('添加成功！', $this->createWebUrl('store'), 'success');
        }else{
             message('添加失败！','','error');
        }
    }else{
        $res=pdo_update('zhvip_store',$data,array('id'=>$_GPC['id']));
        if($res){
             message('编辑成功！', $this->createWebUrl('store'), 'success');
        }else{
             message('编辑失败！','','error');
        }
    }

}

include $this->template('web/addstore');