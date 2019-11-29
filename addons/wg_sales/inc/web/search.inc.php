<?php
class Wg_sales_Web_Search extends SalesBaseController{

    public static $URL = 'https://api.datougou.cn/search/news/?site=%s&sign=%s&timestamp=%s&kw=%s&size=%s';

    public static $PAGE_SIZE = 20;
    public function init() {
        parent::init();

        $this->uid  = $this->site->_W['uniacid'];
        $this->site->loadmodule('categoryModule');
        $this->site->loadmodule('articleModule');

    }

    public function index() {
        $kw = trim($_GET['kw']);
        $data['ec'] = 200;
        if($kw) {
//            $kw = urlencode($kw);
            $data = $this->site->getSettings();
            $sign = $this->site->getSignedData($data['token'],[
                'site'      => $data['site'],
                'timestamp' => time(),
                'kw'       => $kw,
                'size'     => self::$PAGE_SIZE
            ]);
            $url  = sprintf(self::$URL, $data['site'],$sign['sign'],time(), $kw, self::$PAGE_SIZE);
            $data = json_decode($this->site->send_http_request($url), true);
        }

        $data['kw'] = $kw;
        $this->site->assign($data);
    }

}

