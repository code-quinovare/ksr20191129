<?php

        $kwd = $_GPC['keyword'];
        $sql = 'SELECT * FROM ' . tablename($this->tb_yuyue) . ' WHERE `weid`=:weid AND `title` LIKE :title ORDER BY reid DESC LIMIT 0,8';
        $params = array();
        $params[':weid'] = $_W['uniacid'];
        $params[':title'] = "%{$kwd}%";
        $ds = pdo_fetchall($sql, $params);
        foreach ($ds as &$row) {
            $r = array();
            $r['title'] = $row['title'];
            $r['description'] = cutstr(strip_tags($row['description']), 50);
            $r['thumb'] = $row['thumb'];
            $r['reid'] = $row['reid'];
            $row['entry'] = $r;
        }
        include $this->template('query');
?>