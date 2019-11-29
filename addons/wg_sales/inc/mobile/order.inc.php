<?php
class Wg_sales_Mobile_Order extends SalesBaseController
{
	public $data = array();
	public $size = 10;
	public function init()
	{
		parent::init();
		$this->site->loadmodule('orderModule');
	}
	public function ajaxGetOrder()
	{
		$ad_article = $money = floatval($_POST['money']);
		$money = number_format($money, 2);
		$money_fen = $money * 100;
		if ($money_fen < 1) {
			$this->site->ajaxReturn(410, "金额错误,{$money_fen}");
		}
		if (!$this->checkPayConfig()) {
			$this->site->ajaxReturn(400, "支付参数错误");
		}
		if (!$_SESSION['wg']['user'][$this->site->site_id]['id']) {
			$this->site->ajaxReturn(409, "您没有登录");
		}
		$order = ['uniacid' => $this->site->site_id, 'uid' => $_SESSION['wg']['user'][$this->site->site_id]['id'], 'category_id' => intval($_POST['category_id']), 'article_id' => intval($_POST['article_id']), 'order_no' => $this->getOrderId(), 'status' => 1, 'money' => $money_fen, 'pay_money' => $money_fen, 'create_time' => time()];
		$order_id = $this->site->orderModule->add($order);
		if ($order_id) {
			$params = $this->getPayParams($order, $_SESSION['wg']['user'][$this->site->site_id]['openid']);
			$this->site->ajaxReturn($params['code'], "", $params['data']);
		} else {
			$this->site->ajaxReturn(401, "生成订单id失败");
		}
	}
	private function getOrderId()
	{
		$randNo = sprintf('%04d', rand(1, 1000));
		return date("YmdHis") . $randNo;
	}
	private function getPayParams($order_info, $openid)
	{
		global $_W, $_GPC;
		require_once dirname(__FILE__) . "/../../lib/wxpay/lib/WxPay.Api.php";
		require_once dirname(__FILE__) . "/../../lib/wxpay/lib/WxPay.Notify.php";
		require_once dirname(__FILE__) . "/../../lib/wxpay/example/WxPay.JsApiPay.php";
		$notifyUrl = $_W['siteroot'] . '/addons/wg_sales/notify.php';
		$tools = new JsApiPay();
		require_once dirname(__FILE__) . "/../../lib/wxpay/lib/WxPay.Api.php";
		require_once dirname(__FILE__) . "/../../lib/wxpay/example/WxPay.JsApiPay.php";
		$title = '微信支付';
		$input = new WxPayUnifiedOrder();
		$input->SetBody($title);
		$input->SetAttach("wg_sales|{$_W['uniacid']}");
		$input->SetOut_trade_no($order_info['order_no']);
		$input->SetTotal_fee($order_info['pay_money']);
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetNotify_url($notifyUrl);
		$input->SetTrade_type("JSAPI");
		$input->SetOpenid($openid);
		$_W['module_setting']['pay']['appid'] = $_W['account']['key'];
		$_W['module_setting']['pay']['mchid'] = $_W['account']['setting']['payment']['wechat']['mchid'];
		$_W['module_setting']['pay']['key'] = $_W['account']['setting']['payment']['wechat']['signkey'];
		$order = WxPayApi::unifiedOrder($input);
		if ($order['code'] == 0) {
			return ['code' => 0, 'data' => $tools->GetJsApiParameters($order['data'])];
		} else {
			return ['code' => $order['code'], 'data' => []];
		}
	}
	private function checkPayConfig()
	{
		global $_W;
		if (!$_W['account']['key'] || !$_W['account']['setting']['payment']['wechat']['mchid'] || !$_W['account']['setting']['payment']['wechat']['signkey']) {
			return false;
		}
		return true;
	}
}