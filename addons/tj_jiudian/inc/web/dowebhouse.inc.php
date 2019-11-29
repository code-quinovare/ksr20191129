<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';
if(empty($action)){
    $set = pdo_fetchall("SELECT * FROM ".tablename("tj_jiudian_house")." WHERE acid = ".$_W['account']['acid']);
}
if(($_GPC['action']) == 'add')
{
    if($_W['ispost'])
    {
        $data = array(
            "title" => $_GPC['title'],
            "img" => $_GPC['img'],
            "price" => $_GPC['price'],
            "jingdu" => $_GPC['jingdu'],
            "weidu" => $_GPC['weidu'],
            "address" => $_GPC['address'],
            "shengyu" => $_GPC['shengyu'],
            "shangwang" => $_GPC['shangwang'],
            "weiyu" => $_GPC['weiyu'],
            "class" => $_GPC['class'],
            "chuanghu" => $_GPC['chuanghu'],
            "kezhu" => $_GPC['kezhu'],
            "chuangxing" => $_GPC['chuangxing'],
            "zaocan" => $_GPC['zaocan'],
            "shuoming" => $_GPC['shuoming'],
            "tuikuan" => $_GPC['tuikuan'],
            "shiyong" => $_GPC['shiyong'],
            "rooms" => $_GPC['rooms'],
            "is_rem" => $_GPC['is_rem'],
            "rank" => $_GPC['rank'],
            "acid" => $_W['account']['acid']
        );
        $row=pdo_insert("tj_jiudian_house",$data);
        if($row){
            message("添加成功!",$this->createWebUrl('House',array('action' =>'')),"success");
        }
    }
}

if(($_GPC['action']) == 'bianji') {
    $res = pdo_fetch('select * from '.tablename('tj_jiudian_house').' where id= '.$_GPC['id']);
    if ($_W['ispost']) {
        $data = array(
            "title" => $_GPC['title'],
            "img" => $_GPC['img'],
            "price" => $_GPC['price'],
            "jingdu" => $_GPC['jingdu'],
            "weidu" => $_GPC['weidu'],
            "address" => $_GPC['address'],
            "shengyu" => $_GPC['shengyu'],
            "shangwang" => $_GPC['shangwang'],
            "weiyu" => $_GPC['weiyu'],
            "class" => $_GPC['class'],
            "chuanghu" => $_GPC['chuanghu'],
            "kezhu" => $_GPC['kezhu'],
            "chuangxing" => $_GPC['chuangxing'],
            "zaocan" => $_GPC['zaocan'],
            "shuoming" => $_GPC['shuoming'],
            "tuikuan" => $_GPC['tuikuan'],
            "shiyong" => $_GPC['shiyong'],
            "rooms" => $_GPC['rooms'],
            "rank" => $_GPC['rank'],
            "is_rem" => $_GPC['is_rem'],
            "acid" => $_W['account']['acid']
        );
        $setting = pdo_update('tj_jiudian_house', $data, array('id' => $_GPC['id']));

        if ($setting) {
            message('修改成功', $this->createWebUrl('house', array('action' => '')), 'success');
        }
    }
}

//删除菜单
if(isset($_GPC['action']) && $_GPC['action'] == 'delete'){
    $delete = pdo_query('DELETE FROM '.tablename('tj_jiudian_house').' WHERE id ='.$_GPC['id']);
    if(!empty($delete)){
        message('删除成功',$this->createWebUrl('house',array('action' =>'')),'success');
    }
}
include $this->template("web/house");