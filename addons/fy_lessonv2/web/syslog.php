<?php
/**
 * 日志管理
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 * ============================================================================
 */

if ($operation == 'display'){
	/* 所有操作员 */
	$admin_list = pdo_fetchall("SELECT uid,username FROM " .tablename($this->table_users));
	$pindex = max(1, intval($_GPC['page']));
	$psize = 10;

	$condition = " uniacid=:uniacid ";
	$params = array(':uniacid' => $uniacid);
	if($_W['user']['groupid']!=0){
		$condition .= " AND admin_uid=:admin_uid ";
		$params[':admin_uid'] = $_W['uid'];
	}
	if(!empty($_GPC['function'])){
		$condition .= " AND function LIKE :function ";
		$params[':function'] = "%".$_GPC['function']."%";
	}
	if($_GPC['log_type']>0){
		$condition .= " AND log_type=:log_type ";
		$params[':log_type'] = $_GPC['log_type'];
	}
	if($_W['user']['groupid']==0 && $_GPC['admin_uid']>0){
		$condition .= " AND admin_uid=:admin_uid ";
		$params[':admin_uid'] = $_GPC['admin_uid'];
	}
	if (!empty($_GPC['time']['start'])) {
		$starttime = strtotime($_GPC['time']['start']);
		$endtime = strtotime($_GPC['time']['end']);
		$endtime = !empty($endtime) ? $endtime + 86399 : 0;
		if (!empty($starttime)) {
			$condition .= " AND addtime >= :starttime ";
			$params[':starttime'] = $starttime;
		}
		if (!empty($endtime)) {
			$condition .= " AND addtime <= :endtime ";
			$params[':endtime'] = $endtime;
		}
	}

	$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_syslog). " WHERE {$condition} ORDER BY addtime DESC LIMIT " .($pindex - 1) * $psize. ',' . $psize, $params);
	$total = pdo_fetchcolumn('SELECT COUNT(*) FROM ' .tablename($this->table_syslog). " WHERE {$condition}", $params);
	$pager = pagination($total, $pindex, $psize);

}else if ($operation == 'delete'){
	
	if(checksubmit('submit')){
		$endDate = $_GPC['endDate'];
		if(empty($endDate)){
			message("请选择截止日期", "", "error");
		}
		$endTime = strtotime($endDate.' 00:00:00');

		pdo_query("DELETE FROM ".tablename($this->table_syslog)." WHERE addtime<:addtime", array(':addtime'=>$endTime));
		message("删除日志成功", $this->createWebUrl('syslog'), "success");
	}
	
}

include $this->template('syslog');

?>