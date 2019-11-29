<?php  defined("IN_IA") or exit( "Access Denied" );
mload()->model("deliveryer");
global $_W;
global $_GPC;
$op = (trim($_GPC["op"]) ? trim($_GPC["op"]) : "index");
if( $op == "index" ) 
{
	$_W["page"]["title"] = "配送员等级";
	$groups = pdo_fetchall("select * from" . tablename("tiny_wmall_deliveryer_groups") . "where uniacid = :uniacid", array( "uniacid" => $_W["uniacid"] ));
	foreach( $groups as &$group ) 
	{
		$group["delivery_fee"] = iunserializer($group["delivery_fee"]);
	}
}
if( $op == "post" ) 
{
	$_W["page"]["title"] = "编辑配送员等级";
	$id = intval($_GPC["id"]);
	if( 0 < $id ) 
	{
		$group = pdo_get("tiny_wmall_deliveryer_groups", array( "uniacid" => $_W["uniacid"], "id" => $id ));
		$group["delivery_fee"] = iunserializer($group["delivery_fee"]);
	}
	if( $_W["ispost"] ) 
	{
		$title = trim($_GPC["title"]);
		if( empty($title) ) 
		{
			imessage(error(-1, "等级名称不能为空"), "", "ajax");
		}
		$deliveryer_takeout_fee_type = intval($_GPC["deliveryer_takeout_fee_type"]);
		$deliveryer_takeout_fee = 0;
		if( $deliveryer_takeout_fee_type == 1 ) 
		{
			$deliveryer_takeout_fee = floatval($_GPC["deliveryer_takeout_fee_1"]);
		}
		else 
		{
			if( $deliveryer_takeout_fee_type == 2 ) 
			{
				$deliveryer_takeout_fee = floatval($_GPC["deliveryer_takeout_fee_2"]);
			}
			else 
			{
				if( $deliveryer_takeout_fee_type == 3 ) 
				{
					$deliveryer_takeout_fee = array( "start_fee" => floatval($_GPC["deliveryer_takeout_fee_3"]["start_fee"]), "start_km" => floatval($_GPC["deliveryer_takeout_fee_3"]["start_km"]), "pre_km" => floatval($_GPC["deliveryer_takeout_fee_3"]["pre_km"]), "max_fee" => floatval($_GPC["deliveryer_takeout_fee_3"]["max_fee"]) );
				}
			}
		}
		$deliveryer_errander_fee_type = intval($_GPC["deliveryer_errander_fee_type"]);
		$deliveryer_errander_fee = 0;
		if( $deliveryer_errander_fee_type == 1 ) 
		{
			$deliveryer_errander_fee = floatval($_GPC["deliveryer_errander_fee_1"]);
		}
		else 
		{
			if( $deliveryer_errander_fee_type == 2 ) 
			{
				$deliveryer_errander_fee = floatval($_GPC["deliveryer_errander_fee_2"]);
			}
			else 
			{
				if( $deliveryer_errander_fee_type == 3 ) 
				{
					$deliveryer_errander_fee = array( "start_fee" => floatval($_GPC["deliveryer_errander_fee_3"]["start_fee"]), "start_km" => floatval($_GPC["deliveryer_errander_fee_3"]["start_km"]), "pre_km" => floatval($_GPC["deliveryer_errander_fee_3"]["pre_km"]), "max_fee" => floatval($_GPC["deliveryer_errander_fee_3"]["max_fee"]) );
				}
			}
		}
		$delivery_fee = array( "takeout" => array( "deliveryer_fee_type" => $deliveryer_takeout_fee_type, "deliveryer_fee" => $deliveryer_takeout_fee ), "errander" => array( "deliveryer_fee_type" => $deliveryer_errander_fee_type, "deliveryer_fee" => $deliveryer_errander_fee ) );
		$data = array( "uniacid" => $_W["uniacid"], "title" => $title, "group_condition" => floatval($_GPC["group_condition"]), "delivery_fee" => iserializer($delivery_fee) );
		if( empty($group["id"]) ) 
		{
			pdo_insert("tiny_wmall_deliveryer_groups", $data);
		}
		else 
		{
			pdo_update("tiny_wmall_deliveryer_groups", $data, array( "uniacid" => $_W["uniacid"], "id" => $id ));
		}
		imessage(error(0, "配送员等级更新成功"), iurl("deliveryer/group/index"), "ajax");
	}
}
if( $op == "del" ) 
{
	$id = intval($_GPC["id"]);
	pdo_delete("tiny_wmall_deliveryer_groups", array( "uniacid" => $_W["uniacid"], "id" => $id ));
	imessage(error(0, "删除配送员等级成功"), iurl("deliveryer/group/index"), "ajax");
}
include(itemplate("deliveryer/group"));
?>