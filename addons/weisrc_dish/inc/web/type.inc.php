<?php
global $_GPC, $_W;
$weid = $this->_weid;
$GLOBALS['frames'] = $this->getMainMenu();

$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update($this->table_type, array('displayorder' => $displayorder), array('id' => $id));
        }
        foreach ($_GPC['url'] as $id => $url) {
            pdo_update($this->table_type, array('url' => $url), array('id' => $id));
        }
        message('门店类型排序更新成功！', $this->createWebUrl('type', array('op' => 'display')), 'success');
    }

    $list = pdo_fetchall("SELECT * FROM " . tablename($this->table_type) . " WHERE weid = :weid  ORDER BY parentid ASC, displayorder DESC", array(':weid' => $weid));

} elseif ($operation == 'post') {
    load()->func('tpl');
    $parentid = intval($_GPC['parentid']);
    $id = intval($_GPC['id']);
    if (!empty($id)) {
        $type = pdo_fetch("SELECT * FROM " . tablename($this->table_type) . " WHERE id = '$id'");
    } else {
        $type = array(
            'displayorder' => 0,
        );
    }

    if (checksubmit('submit')) {
        if (empty($_GPC['catename'])) {
            message('抱歉，请输入区域名称！');
        }

        $data = array(
            'weid' => $weid,
            'name' => $_GPC['catename'],
            'thumb' => $_GPC['thumb'],
            'url' => $_GPC['url'],
            'displayorder' => intval($_GPC['displayorder']),
            'parentid' => intval($parentid),
        );

        if (!empty($id)) {
            unset($data['parentid']);
            pdo_update($this->table_type, $data, array('id' => $id));
        } else {
            pdo_insert($this->table_type, $data);
        }
        message('更新门店类型成功！', $this->createWebUrl('type', array('op' => 'display')), 'success');
    }
} elseif ($operation == 'delete') {
    $id = intval($_GPC['id']);
    $type = pdo_fetch("SELECT id, parentid FROM " . tablename($this->table_type) . " WHERE id = '$id'");
    if (empty($type)) {
        message('抱歉，数据不存在或是已经被删除！', $this->createWebUrl('type', array('op' => 'display')), 'error');
    }
    pdo_delete($this->table_type, array('id' => $id, 'weid' => $weid));
    message('数据删除成功！', $this->createWebUrl('type', array('op' => 'display')), 'success');
}
include $this->template('web/type');