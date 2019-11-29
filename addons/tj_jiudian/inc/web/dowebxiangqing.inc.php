<?php
global $_W,$_GPC;
$action=$_GPC['action']?$_GPC['action']:'';

$setting = pdo_get('tj_jiudian_xiangqing',array('acid'=>$_W['account']['acid']));
if($action == "set"){
    if($_W['ispost']){
        $data = array(
            'phone' => $_GPC['phone'],
            'ditie' => $_GPC['ditie'],
            'ditiejuli' => $_GPC['ditiejuli'],
            'huoche' => $_GPC['huoche'],
            'huochejuli' => $_GPC['huochejuli'],
            'jichang' => $_GPC['jichang'],
            'jichangjuli' => $_GPC['jichangjuli'],
            'zhuangxiu' => $_GPC['zhuangxiu'],
            'kaiye' => $_GPC['kaiye'],
            'louceng' => $_GPC['louceng'],
            'fangjian' => $_GPC['fangjian'],
            'jianjie' => $_GPC['jianjie'],
            'acid' => $_W['account']['acid']
        );
        $res = pdo_get('tj_jiudian_xiangqing',array('acid'=>$_W['account']['acid']));
        //var_dump($data);
        if($res == "")
        {
            pdo_insert('tj_jiudian_xiangqing',$data);
            message("设置成功!","","success");
        }else{
            pdo_update('tj_jiudian_xiangqing',$data,array('acid' => $_W['account']['acid']));
            message("编辑成功","","sunccess");
        }
    }
}
include $this->template("web/xiangqing");