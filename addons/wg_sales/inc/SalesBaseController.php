<?php
class SalesBaseController
{
	public $uid;
	public $user_info;
	public $site = null;
	public static $AD_TYPE = array('ad_1' => array('name' => ''), 'ad_2' => array('name' => ''), 'ad_3' => array('name' => ''));
	public function __construct()
	{
	}
	public function init()
	{
		//return true;
		//$this->getAuth(WG_CONTROLLER_NAME);
		$this->site->loadmodule('userModule');
		if ($_SERVER['SERVER_ADDR'] == '127.0.0.1' && $_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
			$this->site->site_id = 4;
			$_SESSION['wg']['user'][$this->site->site_id] = $this->site->userModule->getOne(['id' => 1]);
		}
		$this->user_info = $_SESSION['wg']['user'][$this->site->site_id];
		$this->uid = $_SESSION['wg']['user'][$this->site->site_id]['id'];
		$this->site->assign('user_info', $this->user_info);
	}
	/*public function getAuth($method)
	{
		global $_W;
		$notice = cache_read('sales_business' . $method);
		if (!$notice || $notice['time'] + 3600 * 12 < time()) {
			$url = 'https://api.datougou.cn/sales/?method=%s&ip=' . $_SERVER['SERVER_ADDR'] . '&module=' . APP_NAME . '&url=%s&type=business';
			$host = parse_url($_W['siteroot']);
			$url = sprintf($url, $method, $host['host']);
			$notice = json_decode(file_get_contents($url), true);
		}
		if ($notice['ec'] && $notice['ec'] != 200) {
			foreach ($notice['data'] as $value) {
			}
		} else {
			$notice['time'] = time();
			cache_write('sales_business' . $method, $notice);
		}
		return $notice;
	}*/
	protected function ajaxReturn($error_code, $error_msg, $error_data = '')
	{
		$result = ['code' => $error_code, 'msg' => $error_msg, 'data' => $error_data];
		echo json_encode($result);
		exit;
	}
}