<?php
global $_GPC,$_W;
$action = $_GPC['action']?$_GPC['action']:'';
if(empty($action)) {
    $pagesize = 12;
    $pageindex = max(1, intval($_GPC['page']));
    $total = count(pdo_fetchall(' SELECT * FROM ' . tablename('ewei_shop_member') . 'WHERE  uniacid=' . $_W['uniacid'] . " ORDER BY id DESC"));
    $pager = pagination($total, $pageindex, $pagesize);
    $p = ($pageindex - 1) * $pagesize;
    $list = pdo_fetchall(' SELECT * FROM ' . tablename('ewei_shop_member') . 'WHERE uniacid=' . $_W['uniacid'] . " ORDER BY id DESC LIMIT " . $p . "," . $pagesize);


     foreach ($list as $k=>$row) {
        $res_fans = pdo_fetch('select fanid,openid,follow as followed, unfollowtime from ' . tablename('mc_mapping_fans') . ' where openid = "'.$row['openid'].'"');
        $list[$k]['followed'] = $res_fans['followed'];
        $list[$k]['unfollowtime'] = date('Y-m-d H:i', $res_fans['unfollowtime']);

        $level = pdo_fetch('select levelname from ' . tablename('ewei_shop_member_level') . ' where id = '.$row['level']);
       $list[$k]['levelname'] = $level['levelname'];
    }

}

// print_r($res);die;
    






 include $this->template('web/list');
