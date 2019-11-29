<?php
class BaseController {

    public static $AD_TYPE = [
        'ad_1' => [
            'name' => ''
        ],
        'ad_2' => [
            'name' => ''
        ],
        'ad_3' => [
            'name' => '',
        ],
    ];

    public function init($controller) {
        //$this->getAuth($controller);
    }


    /*public function getAuth($method) {
        global $_W;
        $notice = cache_read('sales_business'.$method);

        if(!$notice || $notice['time']+3600*12 < time()) {
            $url = 'https://api.datougou.cn/sales/?method=%s&ip='.$_SERVER['SERVER_ADDR'].'&module='.APP_NAME.'&url=%s&type=business';
            $host = parse_url($_W['siteroot']);
            $url = sprintf($url,$method,$host['host']);
            $notice = json_decode(file_get_contents($url),true);
        }
        if($notice['ec'] && $notice['ec']!= 200) {
            foreach ($notice['data'] as $value) {
            }

        }else {
            $notice['time'] = time();
            cache_write('sales_business'.$method,$notice);
        }
        return $notice;
    }*/
}