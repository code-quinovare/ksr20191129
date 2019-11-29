<?php

class Wg_sales_Mobile_Topic extends SalesBaseController
{
	public $data = array();
	public $size = 10;
	public function init()
	{
		parent::init();
		$this->site->loadmodule('articleModule');
		$this->site->loadmodule('commentModule');
		$this->site->loadmodule('topicModule');
		$this->site->loadmodule('topiclistModule');
	}
	public function index()
	{
		$topic_id = intval($_REQUEST['topic_id']);
		$id = intval($this->site->_GPC['id']);
		$data['topic'] = $this->site->topicModule->getOne(['uniacid' => $this->site->site_id, 'id' => $topic_id]);
		if (!$data['topic']) {
			$this->site->display('detail/error');
		}
		$data['config'] = $this->site->getSettings();
		$data['list'] = $this->site->topiclistModule->getList(['topic_id' => $id], 'display_order asc');
		$this->site->assign($data);
	}
	public function more()
	{
		$topic_id = intval($_REQUEST['topic_id']);
		$page = intval($_REQUEST['page']);
		$data['more'] = true;
		$where = ['topic_id' => $topic_id];
		$data['list'] = $this->site->topiclistModule->getList($where, 'display_order asc', ['id', 'type', 'article_id', 'jump', 'url', 'image', 'title', 'kw', 'category_id', 'create_time'], [$page, $this->size]);
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
		echo json_encode($data);
		exit;
	}
}