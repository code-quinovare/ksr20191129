<?php

//decode by QQ:10373458 https://www.010xr.com/
function selectTable($table, $option = array())
{
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_integralmall_clerk') . " WHERE ";
	$params = array();
	foreach ($option['search'] as $item) {
	}
}
function selectCircle($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_circle') . " WHERE circle_uniacid = :circle_uniacid";
	$params = array(':circle_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["circle_id"]) && $option['search']["circle_id"] != "") {
			$sql .= ' and circle_id = :circle_id ';
			$params[":circle_id"] = $option['search']["circle_id"];
		}
		if (isset($option['search']["circle_name"]) && $option['search']["circle_name"] != "") {
			$sql .= ' and circle_name like :circle_name ';
			$params[":circle_name"] = '%' . $option['search']["circle_name"] . '%';
		}
		if (isset($option['search']["circle_province"]) && $option['search']["circle_province"] != "") {
			$sql .= ' and circle_province = :circle_province ';
			$params[":circle_province"] = $option['search']["circle_province"];
		}
		if (isset($option['search']["circle_city"]) && $option['search']["circle_city"] != "") {
			$sql .= ' and circle_city = :circle_city ';
			$params[":circle_city"] = $option['search']["circle_city"];
		}
		if (isset($option['search']["circle_county"]) && $option['search']["circle_county"] != "") {
			$sql .= ' and circle_county = :circle_county ';
			$params[":circle_county"] = $option['search']["circle_county"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY circle_order desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectBusiness($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_business') . " WHERE business_uniacid = :business_uniacid";
	$params = array(':business_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["business_id"]) && $option['search']["business_id"] != "") {
			$sql .= ' and business_id = :business_id ';
			$params[":business_id"] = $option['search']["business_id"];
		}
		if (isset($option['search']["business_name"]) && $option['search']["business_name"] != "") {
			$sql .= ' and business_name like :business_name ';
			$params[":business_name"] = '%' . $option['search']["business_name"] . '%';
		}
		if (isset($option['search']["business_admin"]) && $option['search']["business_admin"] != "") {
			$sql .= ' and business_admin like :business_admin ';
			$params[":business_admin"] = '%' . $option['search']["business_admin"] . '%';
		}
		if (isset($option['search']["business_tel"]) && $option['search']["business_tel"] != "") {
			$sql .= ' and business_tel = :business_tel ';
			$params[":business_tel"] = $option['search']["business_tel"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY business_order desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectAdmin($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_admin') . " WHERE admin_uniacid = :admin_uniacid";
	$params = array(':admin_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["admin_id"]) && $option['search']["admin_id"] != "") {
			$sql .= ' and admin_id = :admin_id ';
			$params[":admin_id"] = $option['search']["admin_id"];
		}
		if (isset($option['search']["admin_name"]) && $option['search']["admin_name"] != "") {
			$sql .= ' and admin_name like :admin_name ';
			$params[":admin_name"] = '%' . $option['search']["admin_name"] . '%';
		}
		if (isset($option['search']["admin_account"]) && $option['search']["admin_account"] != "") {
			$sql .= ' and admin_account = :admin_account ';
			$params[":admin_account"] = $option['search']["admin_account"];
		}
		if (isset($option['search']["admin_businessid"]) && $option['search']["admin_businessid"] != "") {
			$sql .= ' and admin_businessid = :admin_businessid ';
			$params[":admin_businessid"] = $option['search']["admin_businessid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY admin_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectWork($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_work') . " left join " . tablename('wxlm_appointment_admin') . " on admin_id = work_adminid WHERE work_uniacid = :work_uniacid";
	$params = array(':work_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["work_id"]) && $option['search']["work_id"] != "") {
			$sql .= ' and work_id = :work_id ';
			$params[":work_id"] = $option['search']["work_id"];
		}
		if (isset($option['search']["work_adminid"]) && $option['search']["work_adminid"] != "") {
			$sql .= ' and work_adminid = :work_adminid ';
			$params[":work_adminid"] = $option['search']["work_adminid"];
		}
		if (isset($option['search']["work_businessid"]) && $option['search']["work_businessid"] != "") {
			$sql .= ' and work_businessid = :work_businessid ';
			$params[":work_businessid"] = $option['search']["work_businessid"];
		}
		if (isset($option['search']["work_module"]) && $option['search']["work_module"] != "") {
			$sql .= ' and work_module = :work_module ';
			$params[":work_module"] = $option['search']["work_module"];
		}
		if (isset($option['search']["work_action"]) && $option['search']["work_action"] != "") {
			$sql .= ' and work_action = :work_action ';
			$params[":work_action"] = $option['search']["work_action"];
		}
		if (isset($option['search']["admin_name"]) && $option['search']["admin_name"] != "") {
			$sql .= ' and admin_name like :admin_name ';
			$params[":admin_name"] = '%' . $option['search']["admin_name"] . '%';
		}
		if (isset($option['search']["admin_account"]) && $option['search']["admin_account"] != "") {
			$sql .= ' and admin_account = :admin_account ';
			$params[":admin_account"] = $option['search']["admin_account"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY work_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectMarch($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_march') . " WHERE march_uniacid = :work_uniacid";
	$params = array(':work_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["march_id"]) && $option['search']["march_id"] != "") {
			$sql .= ' and march_id = :march_id ';
			$params[":march_id"] = $option['search']["march_id"];
		}
		if (isset($option['search']["march_admin_name"]) && $option['search']["march_admin_name"] != "") {
			$sql .= ' and march_admin_name like :march_admin_name ';
			$params[":march_admin_name"] = '%' . $option['search']["march_admin_name"] . '%';
		}
		if (isset($option['search']["march_admin_tel"]) && $option['search']["march_admin_tel"] != "") {
			$sql .= ' and march_admin_tel = :march_admin_tel ';
			$params[":march_admin_tel"] = $option['search']["march_admin_tel"];
		}
		if (isset($option['search']["march_business_name"]) && $option['search']["march_business_name"] != "") {
			$sql .= ' and march_business_name like :march_business_name ';
			$params[":march_business_name"] = '%' . $option['search']["march_business_name"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY march_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectPtype($option = array(), $business = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($business == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_ptype') . " WHERE ptype_uniacid = :uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_ptype') . " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = ptype_businessid WHERE ptype_uniacid = :uniacid";
	}
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["ptyp_id"]) && $option['search']["ptyp_id"] != "") {
			$sql .= ' and ptyp_id = :ptyp_id ';
			$params[":ptyp_id"] = $option['search']["ptyp_id"];
		}
		if (isset($option['search']["ptype_title"]) && $option['search']["ptype_title"] != "") {
			$sql .= ' and ptype_title like :ptype_title ';
			$params[":ptype_title"] = '%' . $option['search']["ptype_title"] . '%';
		}
		if (isset($option['search']["ptype_businessid"]) && $option['search']["ptype_businessid"] != "") {
			$sql .= ' and ptype_businessid = :ptype_businessid ';
			$params[":ptype_businessid"] = $option['search']["ptype_businessid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY ptype_order desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectProject($option = array(), $business = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($business == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_project') . " WHERE project_uniacid = :project_uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_project') . " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = project_businessid WHERE project_uniacid = :project_uniacid";
	}
	$params = array(':project_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["project_id"]) && $option['search']["project_id"] != "") {
			$sql .= ' and project_id = :project_id ';
			$params[":project_id"] = $option['search']["project_id"];
		}
		if (isset($option['search']["project_name"]) && $option['search']["project_name"] != "") {
			$sql .= ' and project_name like :project_name ';
			$params[":project_name"] = '%' . $option['search']["project_name"] . '%';
		}
		if (isset($option['search']["project_businessid"]) && $option['search']["project_businessid"] != "") {
			$sql .= ' and project_businessid = :project_businessid ';
			$params[":project_businessid"] = $option['search']["project_businessid"];
		}
		if (isset($option['search']["business_name"]) && $option['search']["business_name"] != "") {
			$sql .= ' and business_name like :business_name ';
			$params[":business_name"] = '%' . $option['search']["business_name"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY project_order desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectStaff($option = array(), $business = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($business == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_staff') . " WHERE staff_uniacid = :staff_uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_staff') . " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = staff_businessid WHERE staff_uniacid = :staff_uniacid";
	}
	$params = array(':staff_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["staff_id"]) && $option['search']["staff_id"] != "") {
			$sql .= ' and staff_id = :staff_id ';
			$params[":staff_id"] = $option['search']["staff_id"];
		}
		if (isset($option['search']["staff_name"]) && $option['search']["staff_name"] != "") {
			$sql .= ' and staff_name like :staff_name ';
			$params[":staff_name"] = '%' . $option['search']["staff_name"] . '%';
		}
		if (isset($option['search']["staff_businessid"]) && $option['search']["staff_businessid"] != "") {
			$sql .= ' and staff_businessid = :staff_businessid ';
			$params[":staff_businessid"] = $option['search']["staff_businessid"];
		}
		if (isset($option['search']["business_name"]) && $option['search']["business_name"] != "") {
			$sql .= ' and business_name like :business_name ';
			$params[":business_name"] = '%' . $option['search']["business_name"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY staff_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectStore($option = array(), $business = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($business == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_store') . " WHERE store_uniacid = :store_uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_store') . " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = store_businessid  LEFT JOIN " . tablename('wxlm_appointment_circle') . " ON circle_id = store_circleid WHERE store_uniacid = :store_uniacid";
	}
	$params = array(':store_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["store_id"]) && $option['search']["store_id"] != "") {
			$sql .= ' and store_id = :store_id ';
			$params[":store_id"] = $option['search']["store_id"];
		}
		if (isset($option['search']["store_name"]) && $option['search']["store_name"] != "") {
			$sql .= ' and store_name like :store_name ';
			$params[":store_name"] = '%' . $option['search']["store_name"] . '%';
		}
		if (isset($option['search']["store_businessid"]) && $option['search']["store_businessid"] != "") {
			$sql .= ' and store_businessid = :store_businessid ';
			$params[":store_businessid"] = $option['search']["store_businessid"];
		}
		if (isset($option['search']["store_circleid"]) && $option['search']["store_circleid"] != "") {
			$sql .= ' and store_circleid = :store_circleid ';
			$params[":store_circleid"] = $option['search']["store_circleid"];
		}
		if (isset($option['search']["store_admin_name"]) && $option['search']["store_admin_name"] != "") {
			$sql .= ' and store_admin_name like :store_admin_name ';
			$params[":store_admin_name"] = '%' . $option['search']["store_admin_name"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY store_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectStore2($option = array())
{
	global $_W;
	$sqlsel = 'SELECT *';
	if ($option['dingwei']['log'] != '' && $option['dingwei']['lat'] != '') {
		$sqlsel .= " ,(ACOS(SIN((" . $option['dingwei']['lat'] . "*3.1415)/180)*SIN((store_lat*3.1415)/180)+COS((" . $option['dingwei']['lat'] . "*3.1415)/180)*COS((store_lat*3.1415)/180)*COS((" . $option['dingwei']['log'] . "*3.1415)/180-(store_log*3.1415)/180))* 6380 ) as dis ";
	}
	$sql = " FROM " . tablename('wxlm_appointment_store') . " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = store_businessid  LEFT JOIN " . tablename('wxlm_appointment_circle') . " ON circle_id = store_circleid ";
	$sql .= " where store_uniacid =:store_uniacid ";
	$params = array(':store_uniacid' => $_W['uniacid']);
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	if ($option['dingwei']['log'] != '' && $option['dingwei']['lat'] != '') {
		$sql .= ' ORDER BY dis asc ';
	} else {
		$sql .= ' ORDER BY store_id desc';
	}
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectStore3($option = array())
{
	global $_W;
	$sqlsel = 'SELECT *';
	$sql = " FROM " . tablename('wxlm_appointment_order');
	$sql .= " where order_uniacid =:order_uniacid ";
	$sql .= " and order_useropenid = '" . $_W['openid'] . "'";
	$sql .= " and order_state = 3";
	$params = array(':order_uniacid' => $_W['uniacid']);
	if (isset($option['search']["order_projectid"]) && $option['search']["order_projectid"] != "") {
		$sql .= ' and order_projectid = :order_projectid ';
		$params[":order_projectid"] = $option['search']["order_projectid"];
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= " group by order_storeid ";
	$sql .= " ORDER BY order_time_update desc ";
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	foreach ($result['records'] as $k => $v) {
		$sql = " select * FROM " . tablename('wxlm_appointment_store');
		$sql .= " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = store_businessid ";
		$sql .= " LEFT JOIN " . tablename('wxlm_appointment_circle') . " ON circle_id = store_circleid ";
		$sql .= " where store_uniacid =:store_uniacid ";
		$sql .= " and store_id =" . $v['order_storeid'];
		$params = array(':store_uniacid' => $_W['uniacid']);
		$store = pdo_fetch($sql, $params);
		if (!empty($store)) {
			$result['records'][$k] = array_merge($v, $store);
		} else {
			unset($result['records'][$k]);
		}
	}
	return $result;
}
function selectDating($option = array(), $left = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($left == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_dating') . " WHERE dating_uniacid = :dating_uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_dating') . " LEFT JOIN " . tablename('wxlm_appointment_business') . " ON business_id = dating_businessid LEFT JOIN " . tablename('wxlm_appointment_store') . " ON store_id = dating_storeid  LEFT JOIN " . tablename('wxlm_appointment_staff') . " ON staff_id = dating_staffid LEFT JOIN " . tablename('wxlm_appointment_project') . " ON project_id = dating_projectid WHERE dating_uniacid = :dating_uniacid";
	}
	$params = array(':dating_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["dating_id"]) && $option['search']["dating_id"] != "") {
			$sql .= ' and dating_id = :dating_id ';
			$params[":dating_id"] = $option['search']["dating_id"];
		}
		if (isset($option['search']["store_name"]) && $option['search']["store_name"] != "") {
			$sql .= ' and store_name like :store_name ';
			$params[":store_name"] = '%' . $option['search']["store_name"] . '%';
		}
		if (isset($option['search']["dating_businessid"]) && $option['search']["dating_businessid"] != "") {
			$sql .= ' and dating_businessid = :dating_businessid ';
			$params[":dating_businessid"] = $option['search']["dating_businessid"];
		}
		if (isset($option['search']["dating_storeid"]) && $option['search']["dating_storeid"] != "") {
			$sql .= ' and dating_storeid = :dating_storeid ';
			$params[":dating_storeid"] = $option['search']["dating_storeid"];
		}
		if (isset($option['search']["dating_staffid"]) && $option['search']["dating_staffid"] != "") {
			$sql .= ' and dating_staffid = :dating_staffid ';
			$params[":dating_staffid"] = $option['search']["dating_staffid"];
		}
		if (isset($option['search']["dating_projectid"]) && $option['search']["dating_projectid"] != "") {
			$sql .= ' and dating_projectid = :dating_projectid ';
			$params[":dating_projectid"] = $option['search']["dating_projectid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY dating_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectAd($option)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_ad') . " where ad_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["ad_id"]) && $option['search']["ad_id"] != "") {
			$sql .= ' and ad_id = :ad_id ';
			$params[":ad_id"] = $option['search']["ad_id"];
		}
		if (isset($option['search']["ad_state"]) && $option['search']["ad_state"] != "") {
			$sql .= ' and ad_state = :ad_state ';
			$params[":ad_state"] = $option['search']["ad_state"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY ad_order desc';
	if (isset($option['limit'])) {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectOrder($option)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_order') . " where order_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["order_number"]) && $option['search']["order_number"] != "") {
			$sql .= ' and order_number = :order_number ';
			$params[":order_number"] = $option['search']["order_number"];
		}
		if (isset($option['search']["order_businessid"]) && $option['search']["order_businessid"] != "") {
			$sql .= ' and order_businessid = :order_businessid ';
			$params[":order_businessid"] = $option['search']["order_businessid"];
		}
		if (isset($option['search']["order_storeid"]) && $option['search']["order_storeid"] != "") {
			$sql .= ' and order_storeid = :order_storeid ';
			$params[":order_storeid"] = $option['search']["order_storeid"];
		}
		if (isset($option['search']["order_staffid"]) && $option['search']["order_staffid"] != "") {
			$sql .= ' and order_staffid = :order_staffid ';
			$params[":order_staffid"] = $option['search']["order_staffid"];
		}
		if (isset($option['search']["order_projectid"]) && $option['search']["order_projectid"] != "") {
			$sql .= ' and order_projectid = :order_projectid ';
			$params[":order_projectid"] = $option['search']["order_projectid"];
		}
		if (isset($option['search']["order_username"]) && $option['search']["order_username"] != "") {
			$sql .= ' and order_username like :order_username ';
			$params[":order_username"] = "%" . $option['search']["order_username"] . "%";
		}
		if (isset($option['search']["order_useropenid"]) && $option['search']["order_useropenid"] != "") {
			$sql .= ' and order_useropenid = :order_useropenid ';
			$params[":order_useropenid"] = $option['search']["order_useropenid"];
		}
		if (isset($option['search']["order_state"]) && $option['search']["order_state"] != "") {
			$sql .= ' and order_state = :order_state ';
			$params[":order_state"] = $option['search']["order_state"];
		}
		if (isset($option['search']["order_pay_type"]) && $option['search']["order_pay_type"] != "") {
			$sql .= ' and order_pay_type = :order_pay_type ';
			$params[":order_pay_type"] = $option['search']["order_pay_type"];
		}
		if (isset($option['search']["order_dating_day"]) && $option['search']["order_dating_day"] != "") {
			$sql .= ' and order_dating_day = :order_dating_day ';
			$params[":order_dating_day"] = $option['search']["order_dating_day"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY order_id desc';
	if (isset($option['limit'])) {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectSettle($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_order') . " where order_uniacid = :uniacid and  order_state = 3 ";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["order_number"]) && $option['search']["order_number"] != "") {
			$sql .= ' and order_number = :order_number ';
			$params[":order_number"] = $option['search']["order_number"];
		}
		if (isset($option['search']["order_businessid"]) && $option['search']["order_businessid"] != "") {
			$sql .= ' and order_businessid = :order_businessid ';
			$params[":order_businessid"] = $option['search']["order_businessid"];
		}
		if (isset($option['search']["order_storeid"]) && $option['search']["order_storeid"] != "") {
			$sql .= ' and order_storeid = :order_storeid ';
			$params[":order_storeid"] = $option['search']["order_storeid"];
		}
		if (isset($option['search']["order_staffid"]) && $option['search']["order_staffid"] != "") {
			$sql .= ' and order_staffid = :order_staffid ';
			$params[":order_staffid"] = $option['search']["order_staffid"];
		}
		if (isset($option['search']["order_projectid"]) && $option['search']["order_projectid"] != "") {
			$sql .= ' and order_projectid = :order_projectid ';
			$params[":order_projectid"] = $option['search']["order_projectid"];
		}
		if (isset($option['search']["order_username"]) && $option['search']["order_username"] != "") {
			$sql .= ' and order_username like :order_username ';
			$params[":order_username"] = "%" . $option['search']["order_username"] . "%";
		}
		if (isset($option['search']["order_useropenid"]) && $option['search']["order_useropenid"] != "") {
			$sql .= ' and order_useropenid = :order_useropenid ';
			$params[":order_useropenid"] = $option['search']["order_useropenid"];
		}
		if (isset($option['search']["order_state"]) && $option['search']["order_state"] != "") {
			$sql .= ' and order_state = :order_state ';
			$params[":order_state"] = $option['search']["order_state"];
		}
		if (isset($option['search']["order_pay_type"]) && $option['search']["order_pay_type"] != "") {
			$sql .= ' and order_pay_type = :order_pay_type ';
			$params[":order_pay_type"] = $option['search']["order_pay_type"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$settle1 = ' and order_settlement = 1';
	$settle2 = ' and order_settlement = 2';
	$result['wait'] = pdo_fetchcolumn(" select sum(order_pay_money) " . $sql . $settle1, $params);
	$result['finish'] = pdo_fetchcolumn(" select sum(order_pay_money) " . $sql . $settle2, $params);
	$sql .= ' ORDER BY order_id desc';
	if (isset($option['limit'])) {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectSettleTotal($option = array())
{
	global $_W;
	$sqlsel = 'SELECT SUM(order_pay_money) ';
	$sql = " FROM " . tablename('wxlm_appointment_order') . " where order_uniacid = :uniacid and  order_state = 3 and order_settlement = 1";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["order_number"]) && $option['search']["order_number"] != "") {
			$sql .= ' and order_number = :order_number ';
			$params[":order_number"] = $option['search']["order_number"];
		}
		if (isset($option['search']["order_businessid"]) && $option['search']["order_businessid"] != "") {
			$sql .= ' and order_businessid = :order_businessid ';
			$params[":order_businessid"] = $option['search']["order_businessid"];
		}
		if (isset($option['search']["order_storeid"]) && $option['search']["order_storeid"] != "") {
			$sql .= ' and order_storeid = :order_storeid ';
			$params[":order_storeid"] = $option['search']["order_storeid"];
		}
		if (isset($option['search']["order_staffid"]) && $option['search']["order_staffid"] != "") {
			$sql .= ' and order_staffid = :order_staffid ';
			$params[":order_staffid"] = $option['search']["order_staffid"];
		}
		if (isset($option['search']["order_projectid"]) && $option['search']["order_projectid"] != "") {
			$sql .= ' and order_projectid = :order_projectid ';
			$params[":order_projectid"] = $option['search']["order_projectid"];
		}
		if (isset($option['search']["order_username"]) && $option['search']["order_username"] != "") {
			$sql .= ' and order_username like :order_username ';
			$params[":order_username"] = "%" . $option['search']["order_username"] . "%";
		}
		if (isset($option['search']["order_useropenid"]) && $option['search']["order_useropenid"] != "") {
			$sql .= ' and order_useropenid = :order_useropenid ';
			$params[":order_useropenid"] = $option['search']["order_useropenid"];
		}
		if (isset($option['search']["order_state"]) && $option['search']["order_state"] != "") {
			$sql .= ' and order_state = :order_state ';
			$params[":order_state"] = $option['search']["order_state"];
		}
		if (isset($option['search']["order_pay_type"]) && $option['search']["order_pay_type"] != "") {
			$sql .= ' and order_pay_type = :order_pay_type ';
			$params[":order_pay_type"] = $option['search']["order_pay_type"];
		}
	}
	$total = pdo_fetchcolumn($sqlsel . $sql, $params);
	return $total;
}
function selectStoretype($option)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_storetype') . " where storetype_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["storetype_title"]) && $option['search']["storetype_title"] != "") {
			$sql .= ' and storetype_title like :storetype_title ';
			$params[":storetype_title"] = "%" . $option['search']["storetype_title"] . "%";
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY storetype_id desc';
	if (isset($option['limit'])) {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectComment($option, $business = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($business == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_comment') . " where comment_uniacid = :uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_comment') . " as a ";
		$sql .= " left join " . tablename('wxlm_appointment_store') . " as b on a.comment_storeid = b.store_id ";
		$sql .= " left join " . tablename('wxlm_appointment_business') . " as c on b.store_businessid = c.business_id ";
		$sql .= " LEFT JOIN " . tablename('wxlm_appointment_circle') . " ON circle_id = store_circleid ";
		$sql .= " where store_uniacid = :uniacid ";
	}
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["comment_nickname"]) && $option['search']["comment_nickname"] != "") {
			$sql .= ' and comment_nickname like :comment_nickname ';
			$params[":comment_nickname"] = "%" . $option['search']["comment_nickname"] . "%";
		}
		if (isset($option['search']["comment_storeid"]) && $option['search']["comment_storeid"] != "") {
			$sql .= ' and comment_storeid = :comment_storeid ';
			$params[":comment_storeid"] = $option['search']["comment_storeid"];
		}
		if (isset($option['search']["store_businessid"]) && $option['search']["store_businessid"] != "") {
			$sql .= ' and store_businessid = :store_businessid ';
			$params[":store_businessid"] = $option['search']["store_businessid"];
		}
		if (isset($option['search']["store_circleid"]) && $option['search']["store_circleid"] != "") {
			$sql .= ' and store_circleid = :store_circleid ';
			$params[":store_circleid"] = $option['search']["store_circleid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY comment_id desc';
	if (isset($option['limit'])) {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectrefund($option)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_orderrefund') . " as r";
	$sql .= " left join " . tablename('wxlm_appointment_order') . " as o on r.orderrefund_number = o.order_number ";
	$sql .= " where orderrefund_uniacid = :orderrefund_uniacid ";
	$params = array(':orderrefund_uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["order_number"]) && $option['search']["order_number"] != "") {
			$sql .= ' and order_number = :order_number ';
			$params[":order_number"] = $option['search']["order_number"];
		}
		if (isset($option['search']["order_businessid"]) && $option['search']["order_businessid"] != "") {
			$sql .= ' and order_businessid = :order_businessid ';
			$params[":order_businessid"] = $option['search']["order_businessid"];
		}
		if (isset($option['search']["order_storeid"]) && $option['search']["order_storeid"] != "") {
			$sql .= ' and order_storeid = :order_storeid ';
			$params[":order_storeid"] = $option['search']["order_storeid"];
		}
		if (isset($option['search']["order_staffid"]) && $option['search']["order_staffid"] != "") {
			$sql .= ' and order_staffid = :order_staffid ';
			$params[":order_staffid"] = $option['search']["order_staffid"];
		}
		if (isset($option['search']["order_projectid"]) && $option['search']["order_projectid"] != "") {
			$sql .= ' and order_projectid = :order_projectid ';
			$params[":order_projectid"] = $option['search']["order_projectid"];
		}
		if (isset($option['search']["order_username"]) && $option['search']["order_username"] != "") {
			$sql .= ' and order_username like :order_username ';
			$params[":order_username"] = "%" . $option['search']["order_username"] . "%";
		}
		if (isset($option['search']["order_useropenid"]) && $option['search']["order_useropenid"] != "") {
			$sql .= ' and order_useropenid = :order_useropenid ';
			$params[":order_useropenid"] = $option['search']["order_useropenid"];
		}
		if (isset($option['search']["order_state"]) && $option['search']["order_state"] != "") {
			$sql .= ' and order_state = :order_state ';
			$params[":order_state"] = $option['search']["order_state"];
		}
		if (isset($option['search']["order_pay_type"]) && $option['search']["order_pay_type"] != "") {
			$sql .= ' and order_pay_type = :order_pay_type ';
			$params[":order_pay_type"] = $option['search']["order_pay_type"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY orderrefund_id desc';
	if (isset($option['limit'])) {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectVip($option = array(), $card = 1)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	if ($card == 1) {
		$sql = " FROM " . tablename('wxlm_appointment_vip') . " WHERE vip_uniacid = :uniacid";
	} else {
		$sql = " FROM " . tablename('wxlm_appointment_vip') . " LEFT JOIN " . tablename('wxlm_appointment_card') . " ON card_id = vip_cardid WHERE vip_uniacid = :uniacid";
	}
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["vip_id"]) && $option['search']["vip_id"] != "") {
			$sql .= ' and vip_id = :vip_id ';
			$params[":vip_id"] = $option['search']["vip_id"];
		}
		if (isset($option['search']["vip_nickname"]) && $option['search']["vip_nickname"] != "") {
			$sql .= ' and vip_nickname like :vip_nickname ';
			$params[":vip_nickname"] = '%' . $option['search']["vip_nickname"] . '%';
		}
		if (isset($option['search']["vip_openid"]) && $option['search']["vip_openid"] != "") {
			$sql .= ' and vip_openid = :vip_openid ';
			$params[":vip_openid"] = $option['search']["vip_openid"];
		}
		if (isset($option['search']["vip_state"]) && $option['search']["vip_state"] != "") {
			$sql .= ' and vip_state = :vip_state ';
			$params[":vip_state"] = $option['search']["vip_state"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY vip_id asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function updateOrderSettle($option = array())
{
	global $_W;
	$sql = " update " . tablename('wxlm_appointment_order') . " set";
	$sql .= " order_settlement = 2";
	$sql .= " where order_uniacid = :uniacid and order_state = 3 ";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["order_number"]) && $option['search']["order_number"] != "") {
			$sql .= ' and order_number = :order_number ';
			$params[":order_number"] = $option['search']["order_number"];
		}
		if (isset($option['search']["order_businessid"]) && $option['search']["order_businessid"] != "") {
			$sql .= ' and order_businessid = :order_businessid ';
			$params[":order_businessid"] = $option['search']["order_businessid"];
		}
		if (isset($option['search']["order_storeid"]) && $option['search']["order_storeid"] != "") {
			$sql .= ' and order_storeid = :order_storeid ';
			$params[":order_storeid"] = $option['search']["order_storeid"];
		}
		if (isset($option['search']["order_staffid"]) && $option['search']["order_staffid"] != "") {
			$sql .= ' and order_staffid = :order_staffid ';
			$params[":order_staffid"] = $option['search']["order_staffid"];
		}
		if (isset($option['search']["order_projectid"]) && $option['search']["order_projectid"] != "") {
			$sql .= ' and order_projectid = :order_projectid ';
			$params[":order_projectid"] = $option['search']["order_projectid"];
		}
		if (isset($option['search']["order_username"]) && $option['search']["order_username"] != "") {
			$sql .= ' and order_username like :order_username ';
			$params[":order_username"] = "%" . $option['search']["order_username"] . "%";
		}
		if (isset($option['search']["order_useropenid"]) && $option['search']["order_useropenid"] != "") {
			$sql .= ' and order_useropenid = :order_useropenid ';
			$params[":order_useropenid"] = $option['search']["order_useropenid"];
		}
		if (isset($option['search']["order_state"]) && $option['search']["order_state"] != "") {
			$sql .= ' and order_state = :order_state ';
			$params[":order_state"] = $option['search']["order_state"];
		}
		if (isset($option['search']["order_pay_type"]) && $option['search']["order_pay_type"] != "") {
			$sql .= ' and order_pay_type = :order_pay_type ';
			$params[":order_pay_type"] = $option['search']["order_pay_type"];
		}
	}
	$res = pdo_query($sql, $params);
	return $res;
}
function selectShow($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_show') . " WHERE show_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["show_id"]) && $option['search']["show_id"] != "") {
			$sql .= ' and show_id = :show_id ';
			$params[":show_id"] = $option['search']["show_id"];
		}
		if (isset($option['search']["show_typeid"]) && $option['search']["show_typeid"] != "") {
			$sql .= ' and show_typeid = :show_typeid ';
			$params[":show_typeid"] = $option['search']["show_typeid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY show_order asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectShowType($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_showtype') . " WHERE showtype_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["showtype_id"]) && $option['search']["showtype_id"] != "") {
			$sql .= ' and showtype_id = :showtype_id ';
			$params[":showtype_id"] = $option['search']["showtype_id"];
		}
		if (isset($option['search']["showtype_title"]) && $option['search']["showtype_title"] != "") {
			$sql .= ' and showtype_title like :showtype_title ';
			$params[":showtype_title"] = '%' . $option['search']["showtype_title"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY showtype_order asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectCollection($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_collection') . " WHERE collection_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["collection_openid"]) && $option['search']["collection_openid"] != "") {
			$sql .= ' and collection_openid = :collection_openid ';
			$params[":collection_openid"] = $option['search']["collection_openid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY collection_id asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectArchive($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_archive') . " WHERE archive_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["archive_openid"]) && $option['search']["archive_openid"] != "") {
			$sql .= ' and archive_openid = :archive_openid ';
			$params[":archive_openid"] = $option['search']["archive_openid"];
		}
		if (isset($option['search']["archive_name"]) && $option['search']["archive_name"] != "") {
			$sql .= ' and archive_name like :archive_name ';
			$params[":archive_name"] = '%' . $option['search']["archive_name"] . '%';
		}
		if (isset($option['search']["archive_birthday"]) && $option['search']["archive_birthday"] != "") {
			$sql .= ' and archive_birthday like :archive_birthday ';
			$params[":archive_birthday"] = '%-' . $option['search']["archive_birthday"] . '-%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY archive_id asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectConsume($option = array())
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename('wxlm_appointment_consume') . " WHERE consume_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["consume_archiveid"]) && $option['search']["consume_archiveid"] != "") {
			$sql .= ' and consume_archiveid = :consume_archiveid ';
			$params[":consume_archiveid"] = $option['search']["consume_archiveid"];
		}
		if (isset($option['search']["consume_staffid"]) && $option['search']["consume_staffid"] != "") {
			$sql .= ' and consume_staffid = :consume_staffid ';
			$params[":consume_staffid"] = $option['search']["consume_staffid"];
		}
		if (isset($option['search']["consume_date"]) && $option['search']["consume_date"] != "") {
			$sql .= ' and consume_date = :consume_date ';
			$params[":consume_date"] = $option['search']["consume_date"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY consume_id asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectVisittype($option = array(), $tbname)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename($tbname) . " WHERE visittype_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["visittype_id"]) && $option['search']["visittype_id"] != "") {
			$sql .= ' and visittype_id = :visittype_id ';
			$params[":visittype_id"] = $option['search']["visittype_id"];
		}
		if (isset($option['search']["visittype_title"]) && $option['search']["visittype_title"] != "") {
			$sql .= ' and visittype_title like :visittype_title ';
			$params[":visittype_title"] = '%' . $option['search']["visittype_title"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY visittype_order asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectVisittpl($option = array(), $tbname)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename($tbname) . " LEFT JOIN " . tablename('wxlm_appointment_visittype') . " ON  visittype_id = visittpl_typeid WHERE visittpl_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["visittpl_id"]) && $option['search']["visittpl_id"] != "") {
			$sql .= ' and visittpl_id = :visittpl_id ';
			$params[":visittpl_id"] = $option['search']["visittpl_id"];
		}
		if (isset($option['search']["visittpl_typeid"]) && $option['search']["visittpl_typeid"] != "") {
			$sql .= ' and visittpl_typeid = :visittpl_typeid ';
			$params[":visittpl_typeid"] = $option['search']["visittpl_typeid"];
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY visittpl_order asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectScomment($option = array(), $tbname)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename($tbname) . " LEFT JOIN " . tablename('wxlm_appointment_staff') . " ON staff_id = scomment_staffid WHERE scomment_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["scomment_id"]) && $option['search']["scomment_id"] != "") {
			$sql .= ' and scomment_id = :scomment_id ';
			$params[":scomment_id"] = $option['search']["scomment_id"];
		}
		if (isset($option['search']["staff_name"]) && $option['search']["staff_name"] != "") {
			$sql .= ' and staff_name like :staff_name ';
			$params[":staff_name"] = '%' . $option['search']["staff_name"] . '%';
		}
		if (isset($option['search']["scomment_nickname"]) && $option['search']["scomment_nickname"] != "") {
			$sql .= ' and scomment_nickname like :scomment_nickname ';
			$params[":scomment_nickname"] = '%' . $option['search']["scomment_nickname"] . '%';
		}
		if (isset($option['search']["scomment_level"]) && $option['search']["scomment_level"] != "") {
			$sql .= ' and scomment_level = :scomment_level ';
			$params[":scomment_level"] = $option['search']["scomment_level"];
		}
		if (isset($option['search']["scomment_time_add"]) && $option['search']["scomment_time_add"] != "") {
			$sql .= ' and scomment_time_add like :scomment_time_add ';
			$params[":scomment_time_add"] = $option['search']["scomment_time_add"] . "%";
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY scomment_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectScommenttag($option = array(), $tbname)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename($tbname) . " WHERE scommenttag_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["scommenttage_title"]) && $option['search']["scommenttage_title"] != "") {
			$sql .= ' and scommenttage_title like :scommenttage_title ';
			$params[":scommenttage_title"] = '%' . $option['search']["scommenttage_title"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY scommenttag_order asc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}
function selectVisitlog($option = array(), $tbname)
{
	global $_W;
	$sqlsel = 'SELECT * ';
	$sql = " FROM " . tablename($tbname) . " LEFT JOIN " . tablename('wxlm_appointment_staff') . " ON staff_id = visitlog_staffid  LEFT JOIN " . tablename('wxlm_appointment_archive') . " ON archive_id = visitlog_archiveid WHERE visitlog_uniacid = :uniacid";
	$params = array(':uniacid' => $_W['uniacid']);
	if (!empty($option['search'])) {
		if (isset($option['search']["staff_name"]) && $option['search']["staff_name"] != "") {
			$sql .= ' and staff_name like :staff_name ';
			$params[":staff_name"] = '%' . $option['search']["staff_name"] . '%';
		}
		if (isset($option['search']["archive_name"]) && $option['search']["archive_name"] != "") {
			$sql .= ' and archive_name like :archive_name ';
			$params[":archive_name"] = '%' . $option['search']["archive_name"] . '%';
		}
	}
	$result['total'] = pdo_fetchcolumn(" select count(*) " . $sql, $params);
	$sql .= ' ORDER BY visitlog_id desc';
	if (isset($option['limit']) && $option['limit'] != '') {
		$sql .= $option['limit'];
	}
	$result['records'] = pdo_fetchall($sqlsel . $sql, $params);
	return $result;
}