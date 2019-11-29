<?php

class Wg_sales_Mobile_Center extends SalesBaseController
{
	public $data = array();
	public $size = 10;
	public function init()
	{
		parent::init();
		$this->site->loadmodule('pubModule');
		$this->site->loadmodule('articleModule');
	}
	public function index()
	{
		if ($_SESSION['wg_sales']['time'] + 60 * 10 < time()) {
			$_SESSION['wg_sales']['article_count'] = $this->site->pubModule->count(['uid' => $this->uid]);
			$sql = "select sum(money) as sum from " . tablename($this->site->pubModule->getTable()) . " where uid=" . $this->uid . " and cate=2 and status=1";
			$_SESSION['wg_sales']['ad_money'] = (int) $this->site->pubModule->pdo_fetch($sql)['sum'];
			$_SESSION['wg_sales']['time'] = time();
		}
		$data = $_SESSION['wg_sales'];
		$this->site->assign($data);
	}
	public function more()
	{
		$cate = intval($_REQUEST['cate']);
		$page = intval($_REQUEST['page']);
		$data['more'] = true;
		$where = ['uid' => $this->uid, 'cate' => $cate];
		$data['list'] = $this->site->pubModule->getList($where, ['id', 'status', 'title', 'category_id', 'time_step', 'article_id'], ['id desc'], [$page, $this->size]);
		foreach ($data['list'] as &$value) {
			$value['url'] = $value['jump'] ? $value['url'] : $this->site->mobileUrl('detail', ['category_id' => $value['category_id'], 'id' => $value['article_id']]);
			$value['count'] = 0;
			$image = @json_decode($value['image'], true);
			if (is_array($image) && $image) {
				$value['count'] = count($image) < 3 ? 1 : 3;
				foreach ($image as $key => $im) {
					$value['image_' . $key] = $this->site->formatArrImage($im)['url'];
				}
			}
			$value['author'] = $this->site->formatTime($value['create_time']);
			$value['kw'] = $value['kw'] ? $value['kw'] : '';
			if (!$value['kw'] && $value['type'] > 1) {
				$value['kw'] = $this->site->article_type[$value['type']];
			}
			$data['min_id'] = $value['id'];
		}
		if (count($data['list']) < $this->size) {
			$data['more'] = false;
		}
		$data['page'] = $page + 1;
		$this->ajaxReturn(0, '', $data);
	}
	function del()
	{
		$id = (int) $this->site->_GPC['id'];
		$article = $this->site->pubModule->getOne(['id' => $id, 'uid' => $this->uid]);
		$category_id = $article['category_id'];
		$article_id = $article['article_id'];
		if ($article_id) {
			$this->site->articleModule->del($category_id, ['id' => $article['article_id']]);
		}
		$this->site->pubModule->del(['id' => $id]);
		echo json_encode(['code' => 0]);
		exit;
	}
}