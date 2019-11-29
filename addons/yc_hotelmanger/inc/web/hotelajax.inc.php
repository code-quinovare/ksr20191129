<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

global $_GPC;
global $_W;
$op = $_GPC['op'];

if ($op == 'status') {
    $data['status'] = $_GPC['status'];
    $where['uniacid'] = $this->_weid;
    $where['id'] = $_GPC['id'];
    $temp = pdo_update($this->hotel, $data, $where);

    if ($temp == false) {
        message('抱歉，操作数据失败！', '', 'error');
        return;
    }


    message("状态设置成功！", referer(), "success");
    return;
}


if ($op == 'rstatus') {
    $data['status'] = $_GPC['status'];
    $where['uniacid'] = $this->_weid;
    $where['id'] = $_GPC['id'];
    $temp = pdo_update($this->room, $data, $where);

    if ($temp === false) {
        message('抱歉，操作数据失败！', '', 'error');
        return;
    }


    message("状态设置成功！", referer(), "success");
    return;
}


if ($op === 'mstatus') {
    $data['status'] = $_GPC['status'];
    $where['uniacid'] = $this->_weid;
    $where['id'] = $_GPC['id'];
    $temp = pdo_update($this->momy, $data, $where);

    if ($temp === false) {
        message('抱歉，操作数据失败！', '', 'error');
        return;
    }


    message("状态设置成功！", referer(), "success");
    return;
}


if ($op == 'daod') {
    $data['sjsintdate'] = time();
    $data['order_status'] = 3;
    $where['uniacid'] = $this->_weid;
    $where['order_id'] = $_GPC['order_id'];
    $temp = pdo_update($this->order, $data, $where);

    if ($temp === false) {
        message('抱歉，操作数据失败！', '', 'error');
        return;
    }


    message("状态设置成功！", referer(), "success");
    return;
}


if ($op == 'lid') {
    $data['sjsoutdate'] = time();
    $data['order_status'] = 4;
    $where['uniacid'] = $this->_weid;
    $where['order_id'] = $_GPC['order_id'];
    $temp = pdo_update($this->order, $data, $where);

    if ($temp === false) {
        message('抱歉，操作数据失败！', '', 'error');
        return;
    }


    $this->get_hoteljifen($_GPC['order_id']);
    message("状态设置成功！", referer(), "success");
    return;
}


if ($op == 'hdf') {
    $data['sjsintdate'] = time();
    $data['order_status'] = 3;
    $where['uniacid'] = $this->_weid;
    $where['order_id'] = $_GPC['order_id'];
    $temp = pdo_update($this->order, $data, $where);

    if ($temp === false) {
        message('抱歉，操作数据失败！', '', 'error');
        return;
    }


    message("状态设置成功！", referer(), "success");
    return;
}


if ($op == 'momydel') {
    $mid = $_GPC['id'];
    $total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename($this->order) . ' where uniacid =' . $this->_weid . '  and order_status <5 and mid =' . $mid);

    if ($total) {
        message('抱歉，该套餐有未完成订单，禁止删除！', '', 'error');
    }


    $delete = pdo_delete($this->momy, array('id' => $mid, 'uniacid' => $this->_weid));

    if ($delete) {
        pdo_delete($this->order, array('mid' => $mid, 'uniacid' => $this->_weid));
        message("删除成功！", referer(), "success");
        return;
    }


    message("抱歉，操作数据失败！", '', "error");
    return;
}


if ($op == 'roomdel') {
    $roomid = $_GPC['id'];
    $total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename($this->order) . ' where uniacid =' . $this->_weid . '  and order_status <5 and roomid =' . $roomid);

    if ($total) {
        message('抱歉，该房型有未完成订单，禁止删除！', '', 'error');
    }


    $delete = pdo_delete($this->room, array('id' => $roomid, 'uniacid' => $this->_weid));

    if ($delete) {
        pdo_delete($this->momy, array('roomid' => $roomid, 'uniacid' => $this->_weid));
        pdo_delete($this->order, array('roomid' => $roomid, 'uniacid' => $this->_weid));
        message("删除成功！", referer(), "success");
        return;
    }


    message("抱歉，操作数据失败！", '', "error");
    return;
}


if ($op = 'hoteldet') {
    $hotelid = $_GPC['id'];
    $total = pdo_fetchcolumn('SELECT count(*) FROM ' . tablename($this->order) . ' where uniacid =' . $this->_weid . '  and order_status <5 and hotelid =' . $hotelid);

    if ($total) {
        message('抱歉，该房型有未完成订单，禁止删除！', '', 'error');
    }


    $delete = pdo_delete($this->hotel, array('id' => $hotelid, 'uniacid' => $this->_weid));

    if ($delete) {
        pdo_delete($this->room, array('hotelid' => $hotelid, 'uniacid' => $this->_weid));
        pdo_delete($this->momy, array('hotelid' => $hotelid, 'uniacid' => $this->_weid));
        pdo_delete($this->order, array('hotelid' => $hotelid, 'uniacid' => $this->_weid));
        message("删除成功！", referer(), "success");
        return;
    }


    message("抱歉，操作数据失败！", '', "error");
}