<?php

class Wg_sales_Web_Reward extends SalesBaseController
{
	public static $PAGE_SIZE = 10;
	public function init()
	{
		parent::init();
		$this->uid = $this->site->_W['uniacid'];
		$this->site->loadmodule('userModule');
		$this->site->loadmodule('orderModule');
		$this->site->loadmodule('categoryModule');
	}
	public function index()
	{
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$data['cate'] = $this->site->arrayIndex($data['cate'], 'id');
		$count = $this->site->orderModule->count([]);
		$this->site->loadmodule('page', [], false);
		$pag = new Page($count, self::$PAGE_SIZE);
		$show = $pag->show();
		$user_ids = [];
		$page = intval($_GET['p']) ? intval($_GET['p']) : 1;
		$list = $this->site->orderModule->getList(['uniacid' => $this->uid], '*', 'id desc', [$page, self::$PAGE_SIZE]);
		if ($list) {
			foreach ($list as $reward) {
				if ($reward['uid']) {
					$user_ids[] = $reward['uid'];
				}
			}
			$user_ids = array_unique($user_ids);
			$users = $this->site->userModule->getList(['id' => $user_ids], ['nickname', 'id']);
			$users = $this->site->arrayIndex($users, 'id');
			foreach ($list as &$value) {
				$value['user'] = $users[$value['uid']];
			}
		}
		$data['list'] = $list;
		$data['show'] = $show;
		$this->site->assign($data);
	}
	public function del()
	{
		$id = intval($_POST['id']);
		$category_id = intval($_POST['category_id']);
		$data['cate'] = $this->site->categoryModule->getAllCategory(['uniacid' => $this->uid, 'del' => 0]);
		$in = false;
		foreach ($data['cate'] as $cate) {
			if ($cate['id'] == $category_id) {
				$in = true;
				break;
			}
		}
		if (!$in) {
			echo json_encode(['code' => 1, 'msg' => '删除失败']);
			exit;
		}
		$result = $this->site->commentModule->del($category_id, ['id' => $id]);
		if ($result) {
			echo json_encode(['code' => 0]);
		} else {
			echo json_encode(['code' => 2, 'msg' => '删除失败']);
		}
		exit;
	}
}