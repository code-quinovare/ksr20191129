<?php
/**
 * 外送系统
 * @author 微信魔方
 * @QQ 278869155 * @url http://weizan.52jscn.com/
 */
defined('IN_IA') or exit('Access Denied');
global $_W, $_GPC;
$do = 'mghome';
$op = trim($_GPC['op']) ? trim($_GPC['op']) : 'list';
mload()->model('manage');
mload()->model('order');
mload()->model('deliveryer');
checkstore();
$sid = intval($_GPC['__mg_sid']);
$title = '数据统计';

$today_starttime = strtotime(date('Y-m-d'));
$yesterday_starttime = $today_starttime - 86400;
$month_starttime = strtotime(date('Y-m'));
$stat['today_total'] = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid and status = 5 and is_pay = 1 and addtime >= :starttime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $today_starttime)));
$stat['today_price'] = floatval(pdo_fetchcolumn('select sum(final_fee) from ' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid and status = 5 and is_pay = 1 and addtime >= :starttime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $today_starttime)));
$stat['month_price'] = floatval(pdo_fetchcolumn('select sum(final_fee) from ' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid and status = 5 and is_pay = 1 and addtime >= :starttime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $month_starttime)));
$stat['month_total'] = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid and status = 5 and is_pay = 1 and addtime >= :starttime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $month_starttime)));
$stat['yesterday_total'] = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid  and status = 5 and is_pay = 1 and addtime >= :starttime and addtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $yesterday_starttime, ':endtime' => $today_starttime)));
$stat['yesterday_price'] = floatval(pdo_fetchcolumn('select sum(final_fee) from ' . tablename('tiny_wmall_plus_order') . ' where uniacid = :uniacid and sid = :sid  and status = 5 and is_pay = 1 and addtime >= :starttime and addtime <= :endtime', array(':uniacid' => $_W['uniacid'], ':sid' => $sid, ':starttime' => $yesterday_starttime, ':endtime' => $today_starttime)));

include $this->template('manage/stat');


