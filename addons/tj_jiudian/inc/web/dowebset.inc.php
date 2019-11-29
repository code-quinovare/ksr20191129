<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';

$setting = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
$setting['logo'] = unserialize($setting['logo']);
if($action == "set"){
    if($_W['ispost']){
        $data = array(
            'title' => $_GPC['title'],
            'logo' => serialize($_GPC['logo']),
            'zhutu' => $_GPC['zhutu'],
            'guanggao' => $_GPC['guanggao'],
            'info' => $_GPC['info'],
            'jingdu' => $_GPC['jingdu'],
            'address' => $_GPC['address'],
            'weidu' => $_GPC['weidu'],
            'he_openid' => $_GPC['he_openid'],
            'tempid' => $_GPC['tempid'],
            'shangtou' => $_GPC['shangtou'],
            'shangwei' => $_GPC['shangwei'],
            'yongtou' => $_GPC['yongtou'],
            'yongwei' => $_GPC['yongwei'],
            'acid' => $_W['account']['acid'],
            'mch_id' => $_GPC['mch_id'],
            'pay_key' => $_GPC['pay_key']
        );
        $res = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
        //var_dump($data);
        if($res == "")
        {
            pdo_insert('tj_jiudian_set',$data);
            message("设置成功!","","success");
        }else{
            pdo_update('tj_jiudian_set',$data,array('acid' => $_W['account']['acid']));
            message("编辑成功","","sunccess");
        }
    }
}
include $this->template("web/set");