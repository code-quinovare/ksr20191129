<?php

//为傲资源 http://zy.weiaokeji.com
defined('IN_IA') or die('Access Denied');
class dayu_yuyuepay_plugin_skinsModuleSite extends WeModuleSite
{
	private $table_skins = 'dayu_yuyuepay_skins';
	public function doWebSkins()
	{
		global $_GPC, $_W;
		require 'fans.web.php';
		$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
		if ($operation == 'display' && $_W['isfounder']) {
			$skins = pdo_fetchall("select * from " . tablename($this->table_skins) . " ORDER BY id DESC", array());
			if (!empty($skins)) {
				foreach ($skins as $index => $row) {
					$skins[$index]['type'] = in_array($row['name'], array('weui'), TRUE) ? '***' : $row['name'];
				}
			}
			if (!empty($_GPC['export'])) {
				$arr2 = array(array("weui", "weui", "weui默认皮肤", "../addons/dayu_yuyuepay_plugin_skins/template/images/weui.jpg", "9"));
				$data = array();
				for ($i = 0; $i < 1; $i++) {
					$data[$key]['title'] = $arr2[$i][0];
					$data[$key]['filename'] = $arr2[$i][1];
					$data[$key]['description'] = $arr2[$i][2];
					$data[$key]['thumb'] = $arr2[$i][3];
					$data[$key]['mode'] = $arr2[$i][4];
					foreach ($data as $value) {
						$insert = array();
						$insert['title'] = $value['title'];
						$insert['name'] = $value['filename'];
						$insert['description'] = $value['description'];
						$insert['thumb'] = $value['thumb'];
						$insert['mode'] = $value['mode'];
						$insert['status'] = 1;
						$check = pdo_get($this->table_skins, array('name' => $insert['name']), array('id', 'name'));
						if (empty($check['name'])) {
							pdo_insert($this->table_skins, $insert);
						}
						$msg = empty($check) ? '' : '，存在相同皮肤名称，已排除';
					}
				}
				message('导入皮肤成功' . $msg, $this->createWebUrl('skins'));
			}
		}
		if ($operation == 'post' && $_W['isfounder']) {
			$skins = pdo_fetchall("select * from " . tablename($this->table_skins) . " ORDER BY id DESC", array());
			if (!$skins) {
				message('请先导入皮肤数据');
			}
			$id = intval($_GPC['id']);
			if (!empty($id)) {
				$row = pdo_get($this->table_skins, array('id' => $id), array());
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('抱歉，请输入皮肤名称！');
				}
				$data = array('title' => $_GPC['title'], 'name' => $_GPC['skinsname'], 'thumb' => $_GPC['thumb'], 'description' => $_GPC['description'], 'status' => $_GPC['status']);
				if (!empty($id)) {
					pdo_update($this->table_skins, $data, array('id' => $id));
				} else {
					pdo_insert($this->table_skins, $data);
					$id = pdo_insertid();
				}
				message('更新皮肤成功！', $this->createWebUrl('skins', array('op' => 'display')), 'success');
			}
		} elseif ($operation == 'delete' && $_W['isfounder']) {
			$id = intval($_GPC['id']);
			$skins = pdo_fetch("SELECT * FROM " . tablename($this->table_skins) . " WHERE id = '{$id}'");
			if (empty($skins)) {
				message('抱歉，皮肤不存在或是已经被删除！', $this->createWebUrl('skins', array('op' => 'display')), 'error');
			}
			if (in_array($skins['name'], array('weui'), TRUE)) {
				message('抱歉，系统皮肤不能删除！', $this->createWebUrl('skins', array('op' => 'display')), 'error');
			}
			unlink('../addons/dayu_yuyuepay/template/mobile/skins/' . $skins['name'] . '.html');
			pdo_delete($this->table_skins, array('id' => $id));
			message('皮肤删除成功！', $this->createWebUrl('skins', array('op' => 'display')), 'success');
		} elseif (!$_W['isfounder']) {
			message('权限不足');
		}
		load()->func('file');
		load()->func('tpl');
		include $this->template('skins');
	}
	public function doWebupfile()
	{
		global $_W, $_GPC;
		$max_file_size = 2000000;
		$destination_folder = "../addons/dayu_yuyuepay/template/mobile/skins/";
		if (!is_uploaded_file($_FILES["upfile"][tmp_name])) {
			echo 'nothing';
			die;
		}
		$file = $_FILES["upfile"];
		if ($max_file_size < $file["size"]) {
			echo 'size';
			die;
		}
		if (strstr($file["name"], 'weui')) {
			echo '禁止上传 ' . $file["name"] . ' 文件名皮肤';
			die;
		}
		if (!file_exists($destination_folder)) {
			mkdir($destination_folder);
		}
		$filename = $file["tmp_name"];
		$image_size = getimagesize($filename);
		$pinfo = pathinfo($file["name"]);
		$ftype = $pinfo['extension'];
		$destination = $destination_folder . $file["name"];
		file_exists($destination);
		if (!move_uploaded_file($filename, $destination)) {
			echo 'move';
			die;
		}
		$pinfo = pathinfo($destination);
		$fname = $pinfo[basename];
		echo substr($fname, 0, strrpos($fname, '.'));
	}
	public function doWebAjaxSet()
	{
		global $_GPC, $_W;
		require 'fans.web.php';
		$id = intval($_GPC['id']);
		$type = $_GPC['type'];
		$data = intval($_GPC['data']);
		$table = $_GPC['table'];
		if ($table == 'member') {
		}
		if (in_array($type, array('status'))) {
			$data = $data == 1 ? '0' : '1';
			pdo_update($table, array($type => $data), array("id" => $id, "weid" => $weid));
			die(json_encode(array("result" => 1, "data" => $data)));
		}
		die(json_encode(array("result" => 0)));
	}
}
function change_to_quotes($str)
{
	return sprintf('%s', $str);
}