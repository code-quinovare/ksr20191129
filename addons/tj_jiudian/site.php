<?php
/**
 * 商家中心模块微站定义
 *
 * @author tjtjtj
 * @url http://bbs.we7.cc/
 */
defined('IN_IA') or exit('Access Denied');
define('EWEI_SHOPV2_LOCAL','../addons/ewei_shopv2/');

function webUrl($do = '', $query = array(), $full = true)
{
    global $_W;
    global $_GPC;

    if (!empty($_W['plugin'])) {
        if ($_W['plugin'] == 'merch') {
            if (function_exists('merchUrl')) {
                return merchUrl($do, $query, $full);
            }
        }

        if ($_W['plugin'] == 'newstore') {
            if (function_exists('newstoreUrl')) {
                return newstoreUrl($do, $query, $full);
            }
        }
    }

    $dos = explode('/', trim($do));
    $routes = array();
    $routes[] = $dos[0];

    if (isset($dos[1])) {
        $routes[] = $dos[1];
    }

    if (isset($dos[2])) {
        $routes[] = $dos[2];
    }

    if (isset($dos[3])) {
        $routes[] = $dos[3];
    }

    $r = implode('.', $routes);

    if (!empty($r)) {
        $query = array_merge(array('r' => $r), $query);
    }

    $query = array_merge(array('do' => 'web'), $query);
    $query = array_merge(array('m' => 'ewei_shopv2'), $query);

    if ($full) {
        return $_W['siteroot'] . 'web/' . substr(wurl('site/entry', $query), 2);
    }

    return wurl('site/entry', $query);
}

function mobileUrl($do = '', $query = NULL, $full = false)
    {
        global $_W;
        global $_GPC;
        !$query && ($query = array());
        $dos = explode('/', trim($do));
        $routes = array();
        $routes[] = $dos[0];

        if (isset($dos[1])) {
            $routes[] = $dos[1];
        }

        if (isset($dos[2])) {
            $routes[] = $dos[2];
        }

        if (isset($dos[3])) {
            $routes[] = $dos[3];
        }

        if (isset($dos[4])) {
            $routes[] = $dos[4];
        }

        $r = implode('.', $routes);

        if (!empty($r)) {
            $query = array_merge(array('r' => $r), $query);
        }

        $query = array_merge(array('do' => 'mobile'), $query);
        $query = array_merge(array('m' => 'ewei_shopv2'), $query);

        if (empty($query['mid'])) {
            $mid = intval($_GPC['mid']);

            if (!empty($mid)) {
                $query['mid'] = $mid;
            }

            
        }

        if (empty($query['merchid'])) {
            $merchid = intval($_GPC['merchid']);

            if (!empty($merchid)) {
                $query['merchid'] = $merchid;
            }
        }
        else {
            if ($query['merchid'] < 0) {
                unset($query['merchid']);
            }
        }

        if (empty($query['liveid'])) {
            $liveid = intval($_GPC['liveid']);

            if (!empty($liveid)) {
                $query['liveid'] = $liveid;
            }
        }

        if ($full) {
            return $_W['siteroot'] . 'app/' . substr(murl('entry', $query, true), 2);
        }

        // return  $query;
        return murl('entry', $query, true);
    }


class Tj_jiudianModuleSite extends WeModuleSite {

	public function doMobileIndex() {
		include_once 'phpqrcode/phpqrcode.php';
		$this->app(__FUNCTION__);
	}
	public function doWebSet(){
        $this->web(__FUNCTION__);
    }
    public function doWebHouse(){
        $this->web(__FUNCTION__);
    }
    public function doWebNav(){
        $this->web(__FUNCTION__);
    }
    public function doWebXiangqing(){
        $this->web(__FUNCTION__);
    }
	public function doWebOrder(){
		$this->web(__FUNCTION__);
	}

    public function doWebMoney(){
        $this->web(__FUNCTION__);
    }

    public function doWebMember(){
        $this->web(__FUNCTION__);
    }

	public function doMobilePay(){
		global $_W,$_GPC;
		if (empty($_W['fans']['nickname'])) {
			mc_oauth_userinfo();
		}
		
		$order=pdo_fetch(" select * from ".tablename("tj_jiudian_records")." WHERE numberid=".$_GPC['orderid']);
		! $order && message('订单不存在', '', 'error');
		$params = array(
				'tid'     => $order['numberid'],      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
				'ordersn' => $order['numberid'],  //收银台中显示的订单号
				'title'   => '收银台',          //收银台中显示的标题
				'fee'     => $order['money'],      //收银台中显示需要支付的金额,只能大于 0
				'user'    => $_W['fans']['nickname']    //付款用户, 付款的用户名(选填项)
		);
//调用pay方法
		$this->pay($params);
	}

	public function getip() {
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"), "unknown")) {
			$ip = getenv("HTTP_CLIENT_IP");
		} else
			if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")) {
				$ip = getenv("HTTP_X_FORWARDED_FOR");
			} else
				if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"), "unknown")) {
					$ip = getenv("REMOTE_ADDR");
				} else
					if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")) {
						$ip = $_SERVER['REMOTE_ADDR'];
					} else {
						$ip = "unknown";
					}
		return ($ip);
	}

	public function payResult($params) {
		global $_GPC,$_W;
        $set = pdo_get('tj_jiudian_set',array('acid'=>$_W['account']['acid']));
        $openid = $_W['fans']['openid'];
		if ($params['from'] == 'return') {
			if ($params['result'] == 'success') {
				$order = pdo_get('tj_jiudian_records', array('numberid' => $params['tid']));
				$goods = pdo_get('tj_jiudian_order', array('numberid' => $params['tid']));
                $shouyin = pdo_get('tj_jiudian_shouyin', array('numberid' => $params['tid']));
				pdo_update('tj_jiudian_records',array('pay_status'=>1),array('id'=>$order['id']));
				pdo_update('tj_jiudian_order',array('pay_status'=>1),array('id'=>$goods['id']));
                pdo_update('tj_jiudian_shouyin',array('pay_status'=>1),array('id'=>$shouyin['id']));
				$house = pdo_get('tj_jiudian_house', array('id' => $goods['tid']));
				//$a=pdo_update('tj_jiudian_house',array('shengyu'=>$house['shengyu']-$goods['count']),array('id'=>$goods['tid']));
				//var_dump($a);exit;
				if ($params['result'] == 'success') {
                    $aa = $this->templetemsg($_W['siteroot'].'app/index.php?i='.$_W['account']['acid'].'&c=entry&do=Index&m=tj_jiudian', $openid, $set['tempid'], $set['yongtou'], $goods['numberid'], $goods['username'],$goods['money'],$goods['title'],$goods['ruzhu'] . '~'.$goods['lidian'],$set['yongwei']);
                    $res=explode('/',$set['he_openid']);
					foreach($res as $k=>$v){
						$this->templetemsg1($_W['siteroot'].'app/index.php?i='.$_W['account']['acid'].'&c=entry&do=Index&m=tj_jiudian', $v, $set['tempid'], $set['shangtou'], $goods['numberid'], $goods['username'],$goods['money'],$goods['title'],$goods['ruzhu'] . '~'.$goods['lidian'],$set['shangwei']);
					}
					message('支付成功！', $this->createMobileUrl('Index'), '');
				} else {
					message('支付失败！', $this->createMobileUrl('Index'), '');
				}
			}
		}
	}


	public function web($name=null){

		define("ASSETS_PATH",MODULE_URL."Assets/");
		include "inc/web/".strtolower($name).".inc.php";
	}
	public function app($name=null){
		define("ASSETS_PATH",MODULE_URL."Assets/");
		include_once 'Core/Base.class.php';
		include_once 'Common/Public/Function.php';
		include "inc/app/".strtolower($name).".inc.php";
	}

    public function wtw_request($url,$data=null){
        $curl = curl_init(); // 启动一个CURL会话
        curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        if($data != null){
            curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包
        }
        curl_setopt($curl, CURLOPT_TIMEOUT, 300); // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
        $info = curl_exec($curl); // 执行操作
        if (curl_errno($curl)) {
            //echo 'Errno:'.curl_getinfo($curl);//捕抓异常
            //dump(curl_getinfo($curl));
        }
        return $info;
    }

    public function templetemsg($url,$openid,$tempID,$title,$dingdan,$user,$money,$fangxing,$shijian,$end){
        //获取ACCESS_TOKEN
        /*string(86)"*****"
        * string(45)"{"errcode":0,"errmsg":"ok","msgid":201652404}"
       */
        $account_api = WeAccount::create();
        $account_api->clearAccessToken();
        $token = $account_api->getAccessToken();

        $msg_url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $time = date("Y-m-d H:i:s",time());
        $url = $url; ////这个链接是点击图文 跳转的链接,换行只能用n 不能用<Br/>
        ////请求包为一个json：
        $msg_json= '{
            "touser":"'.$openid.'",
            "template_id":"'.$tempID.'",
            "url":"'.$url.'",
            "topcolor":"#FF0000",
            "data":{
                "first":{
                "value":"'.$title.'",
                "color":"#FF0000"
                },
                "keyword1":{
                "value":"'.$dingdan.'",
                "color":"#000000"
                },
                "keyword2":{
                "value":"'.$user.'",
                "color":"#000000"
                },           
                "keyword3":{
                "value":"'.$money.'",
                "color":"#000000"
                },
                "keyword4":{
                "value":"'.$fangxing.'",
                "color":""
                },
                "keyword5":{
                "value":"'.$shijian.'",
                "color":""
                },
                "remark":{
                "value":"'.$end.'",
                "color":""
                }
            }
        }';
        //var_dump($msg_json);exit;
        $result = $this->wtw_request($msg_url,$msg_json);

        return $result;
    }

    public function templetemsg1($url,$openid,$tempID,$title,$dingdan,$user,$money,$fangxing,$shijian,$end){
        //获取ACCESS_TOKEN
        /*string(86)"*****"
        * string(45)"{"errcode":0,"errmsg":"ok","msgid":201652404}"
       */
        $account_api = WeAccount::create();
        $account_api->clearAccessToken();
        $token = $account_api->getAccessToken();

        $msg_url="http://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$token;
        $time = date("Y-m-d H:i:s",time());
        $url = $url; ////这个链接是点击图文 跳转的链接,换行只能用n 不能用<Br/>
        ////请求包为一个json：
        $msg_json= '{
            "touser":"'.$openid.'",
            "template_id":"'.$tempID.'",
            "url":"'.$url.'",
            "topcolor":"#FF0000",
            "data":{
                "first":{
                "value":"'.$title.'",
                "color":"#FF0000"
                },
                "keyword1":{
                "value":"'.$dingdan.'",
                "color":"#000000"
                },
                "keyword2":{
                "value":"'.$user.'",
                "color":"#000000"
                },           
                "keyword3":{
                "value":"'.$money.'",
                "color":"#000000"
                },
                "keyword4":{
                "value":"'.$fangxing.'",
                "color":""
                },
                "keyword5":{
                "value":"'.$shijian.'",
                "color":""
                },
                "remark":{
                "value":"'.$end.'",
                "color":""
                }
            }
        }';
        //var_dump($msg_json);exit;
        $result = $this->wtw_request($msg_url,$msg_json);

        return $result;
    }

}