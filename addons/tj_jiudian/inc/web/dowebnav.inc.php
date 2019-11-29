<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';
if(($_GPC['action']) == 'add')
{
    if($_W['ispost'])
    {
        $data = array(
            "title" => $_GPC['title'],
            "logo" => $_GPC['logo'],
            "rank" => $_GPC['rank'],
            "url" => $_GPC['url'],
            "acid" => $_W['account']['acid']
        );
        $row=pdo_insert("tj_jiudian_caidan",$data);
        if($row){
            message("添加成功!",$this->createWebUrl('nav',array('action' =>'')),"success");
        }
    }
}
if(($_GPC['action']) == 'up_caidan') {
    $cai = pdo_fetch('select * from '.tablename('tj_jiudian_caidan').' where id= '.$_GPC['id']);
    //var_dump($cai);
    if ($_W['ispost']) {
        $data = array(
            "title" => $_GPC['title'],
            "logo" => $_GPC['logo'],
            "rank" => $_GPC['rank'],
            "url" => $_GPC['url'],
            "acid" => $_W['account']['acid']
        );
        $setting = pdo_update('tj_jiudian_caidan', $data, array('id' => $_GPC['id']));

        if (!empty($setting)) {
            message('修改成功', $this->createWebUrl('nav', array('action' => '')), 'success');
        }
    }
}
if(empty($action)){
    $set = pdo_fetchall("SELECT * FROM ".tablename("tj_jiudian_caidan")." WHERE acid = ".$_W['account']['acid']);
}


//删除菜单
if(isset($_GPC['action']) && $_GPC['action'] == 'del_caidan'){
    $delete = pdo_query('DELETE FROM '.tablename('tj_jiudian_caidan').' WHERE id ='.$_GPC['id']);
    if(!empty($delete)){
        message('删除成功',$this->createWebUrl('nav',array('action' =>'')),'success');
    }
}

include $this->template("web/nav");