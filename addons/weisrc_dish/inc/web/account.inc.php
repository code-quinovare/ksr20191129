<?php
global $_GPC, $_W;
$returnid = $this->checkPermission();
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$stores = pdo_fetchall("SELECT * FROM " . tablename($this->table_stores) . " WHERE weid = :weid ORDER BY id DESC", array(':weid' => $this->_weid), 'id');
$GLOBALS['frames'] = $this->getMainMenu();


if ($operation == 'post') {
    $id = intval($_GPC['id']);
    $storeid = intval($_GPC['storeid']);
    if (!empty($id)) {
        $account = pdo_fetch("SELECT * FROM " . tablename($this->table_account) . " WHERE weid = :weid AND id=:id ORDER BY id DESC", array(':weid' => $this->_weid, ':id' => $id));
        $fans = $this->getFansByOpenid($account['from_user']);
    }

    if (!empty($account)) {
        $users = user_single($account['uid']);
    }

    if (checksubmit('submit')) {
        load()->model('user');
        $user = array();
        $user['username'] = trim($_GPC['username']);
        if (!preg_match(REGULAR_USERNAME, $user['username'])) {
            message('必须输入用户名，格式为 3-15 位字符，可以包括汉字、字母（不区分大小写）、数字、下划线和句点。');
        }
        if (empty($users)) {
            $user['password'] = $_GPC['password'];
            if (istrlen($user['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }
        if (!empty($_GPC['password'])) {
            $user['password'] = $_GPC['password'];
            if (istrlen($user['password']) < 8) {
                message('必须输入密码，且密码长度不得低于8位。');
            }
        }

        if (!empty($account)) {
            $user['salt'] = $users['salt'];
            $user['uid'] = $account['uid'];
        }
        $user['remark'] = $_GPC['remark'];
        $user['status'] = $_GPC['status'];
//            $user['groupid'] = intval($_GPC['groupid']) ? intval($_GPC['groupid']) : message('请选择所属用户组');
        $user['groupid'] = -1;

        if (empty($users)) {
            if (user_check(array('username' => $user['username']))) {
                message('非常抱歉，此用户名已经被注册，你需要更换注册名称！');
            }
            $uid = user_register($user);
            if ($uid > 0) {
                unset($user['password']);
                //operator
                $data = array(
                    'uniacid' => $this->_weid,
                    'uid' => $uid,
                    'role' => 'operator',
                );
                $exists = pdo_fetch("SELECT * FROM " . tablename('uni_account_users') . " WHERE uid = :uid AND uniacid = :uniacid", array(':uniacid' => $this->_weid, ':uid' => $uid));
                if (empty($exists)) {
                    pdo_insert('uni_account_users', $data);
                }
                //permission
                pdo_insert('users_permission', array(
                    'uid' => $uid,
                    'uniacid' => $this->_weid,
                    'url' => '',
                    'type' => 'weisrc_dish',
                    'permission' => 'weisrc_dish_menu_stores2'
                ));

//update ims_users_permission set permission='weisrc_dish_menu_stores2' where permission='weisrc_dish_menu_stores';

                pdo_insert($this->table_account, array(
                    'uid' => $uid,
                    'weid' => $this->_weid,
                    'storeid' => intval($_GPC['storeid']),
                    'from_user' => trim($_GPC['from_user']),
                    'email' => trim($_GPC['email']),
                    'mobile' => trim($_GPC['mobile']),
                    'pay_account' => trim($_GPC['pay_account']),
                    'status' => intval($_GPC['status']),
                    'remark' => trim($_GPC['remark']),
                    'dateline' => TIMESTAMP,
                    'username' => trim($_GPC['truename']),
                    'role' => 1,
                    'is_admin_order' => intval($_GPC['is_admin_order']),
                    'is_notice_order' => intval($_GPC['is_notice_order']),
                    'is_notice_service' => intval($_GPC['is_notice_service']),
                    'is_notice_boss' => intval($_GPC['is_notice_boss']),
                    'is_notice_queue' => intval($_GPC['is_notice_queue']),
                ));

                message('用户增加成功！!', $this->createWebUrl('account', array(), true));
            }
        } else {
            user_update($user);
            pdo_update($this->table_account, array(
                'weid' => $this->_weid,
                'storeid' => intval($_GPC['storeid']),
                'from_user' => trim($_GPC['from_user']),
                'email' => trim($_GPC['email']),
                'mobile' => trim($_GPC['mobile']),
                'pay_account' => trim($_GPC['pay_account']),
                'status' => intval($_GPC['status']),
                'remark' => trim($_GPC['remark']),
                'dateline' => TIMESTAMP,
                'role' => 1,
                'username' => trim($_GPC['truename']),
                'is_admin_order' => intval($_GPC['is_admin_order']),
                'is_notice_order' => intval($_GPC['is_notice_order']),
                'is_notice_service' => intval($_GPC['is_notice_service']),
                'is_notice_boss' => intval($_GPC['is_notice_boss']),
                'is_notice_queue' => intval($_GPC['is_notice_queue']),
            ), array('id' => $id));
            message('更新成功！', $this->createWebUrl('account', array(), true));
        }
        message('操作用户失败，请稍候重试或联系网站管理员解决！');
    }
} else if ($operation == 'display') {
    $strwhere = '';
    $pindex = max(1, intval($_GPC['page']));
    $psize = 10;
    $list = pdo_fetchall("SELECT a.*,b.username AS username,b.status AS status FROM " . tablename($this->table_account) . " a LEFT JOIN
" . tablename('users') . " b ON a.uid=b.uid WHERE a.weid = :weid AND a.role=1 $strwhere ORDER BY id DESC LIMIT
" . ($pindex - 1) * $psize . ',' . $psize, array(':weid' => $this->_weid));

    if (!empty($list)) {
        $total = pdo_fetchcolumn('SELECT COUNT(1) FROM ' . tablename($this->table_account) . " WHERE weid = :weid $strwhere", array(':weid' => $this->_weid));
        $pager = pagination($total, $pindex, $psize);
    }
} else if ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $item = pdo_fetch("SELECT id FROM " . tablename($this->table_account) . " WHERE id = '$id'");
    if (empty($item)) {
        message('抱歉，不存在或是已经被删除！', $this->createWebUrl('account', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_account, array('id' => $id, 'weid' => $_W['uniacid']));
    message('删除成功！', $this->createWebUrl('account', array('op' => 'display')), 'success');
}
include $this->template('web/account');