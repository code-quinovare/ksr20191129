<?php
class Order {
    /**
     * 创建支付订单类
     */

    public $money = 0;

    public $order_id = '';

    public $prepay_id = '';

    public $openid = '';

    public $mch_id = null;

    public $pay_key = null;

    public $remark = '订单支付';

    public $appid = '';

    public function __construct($money,$openid)
    {
        $this->money = $money;
        $this->openid = $openid;
        $this->order_id = $this->create_order();

        $this->mch_id = $this->get_mch_id();

        $this->pay_key = $this->get_pay_key();

        $this->appid = $this->get_wx_appid();

    }

    public function set_remark($text)
    {
        $this->remark = $text;
    }

    public function get_mch_id()
    {
        global $_W;
        $config = pdo_get("tj_jiudian_set",array('acid' => $_W['account']['acid']),array('mch_id'));
        if($config)
        {
            return $config['mch_id'];
        }
        else
        {
            return false;
        }
    }

    public function get_wx_appid()
    {
        global $_W;
        return $_W['account']['key'];
//        $config = pdo_get("agr_ct_pay",array('acid' => $_W['account']['acid']),array('wx_appid'));
//        if($config)
//        {
//            return $config['wx_appid'];
//        }
//        else
//        {
//            return false;
//        }
    }

    public function get_pay_key()
    {
        global $_W;
        $config = pdo_get("tj_jiudian_set",array('acid' => $_W['account']['acid']),array('pay_key'));
        if($config)
        {
            return $config['pay_key'];
        }
        else
        {
            return false;
        }
    }

    public function get_prepay_id()
    {
        global $_W;

        //mch_id
        //$mch_id = pdo_fetch("SELECT mch_id,pay_key FROM ".tablename('xyd_config')." WHERE acid = :acid",array(':acid'=>$_W['account']['acid']));
        $mch_id = $this->mch_id;

        $appid = $this->appid;

        $pay_key = $this->pay_key;
        //url
        $url = "https://api.mch.weixin.qq.com/pay/unifiedorder";
        //msg_body
        $msg_body = '{"goods_detail":[{"goods_id":"'."{$_W['account']['name']}{$this->remark}".'","wxpay_goods_id":"'.$this->order_id.'","goods_name":"'."{$_W['account']['name']}{$this->remark}".'","goods_num":1,"price":'.$this->money.',"goods_category":"'.$this->order_id.'","body":"'."{$_W['account']['name']}{$this->remark}".'"}';

        $send_data = array(
            'appid' => $appid,
            'mch_id' => $mch_id,
            'nonce_str' => time(),
            'body' => $_W['account']['name']."{$this->remark}",
            'detail' => $msg_body,
            'out_trade_no' => time()+3600,
            'total_fee' => $this->money * 100,
            'notify_url' => $_W['siteroot'],
            'spbill_create_ip' => $_W['clientip'],
            'trade_type' => 'JSAPI',
            'attach' => $_W['account']['name']."{$this->remark}",
            'openid' => $this->openid,
        );

        $sign = $this->MakeSign($send_data,$pay_key);

        $send_data['sign'] = $sign;


        $result = $this->FromXml($this->wtw_request($url,$this->ToXml($send_data)));
        return $result['prepay_id'];
    }

    /**
     * 企业付款设置
     */
    public function top_up()
    {
        global $_W;
        $post['mch_appid'] = $_W['account']['key'];
        $post['mchid'] = $this->mch_id;
        $post['nonce_str'] = (string)time();
        $post['partner_trade_no'] = rand(1,10000).time();
        $post['openid'] = $this->openid;
        $post['check_name'] = "NO_CHECK";
        $post['re_user_name'] = $_W['fans']['nickname'];
        $post['amount'] = $this->money * 100;
        $post['desc'] = $this->remark;
        $post['spbill_create_ip'] = $_W['clientip'];

        $sign = $this->MakeSign($post,$this->pay_key);

        $post['sign'] = $sign;

        $post_data = $this->ToXml($post);

        $url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";//微信企业支付接口

        $stat = $this->FromXml($this->wxHttpsRequestPem($url,$post_data));
        if($stat['payment_no'] != "" && $stat['payment_time'] != "")
        {
            return true;
        }
        else
        {
            return $stat;
        }
    }

    /**
     * @return string 创建订单编号
     */
    public function create_order()
    {
        return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }

    public function ToUrlParams($arr)
    {
        $buff = "";
        foreach ($arr as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    public function MakeSign($array,$key)
    {
        //签名步骤一：按字典序排序参数
        ksort($array);
        $string = $this->ToUrlParams($array);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    public function Jssdk_sign($array)
    {
        //签名步骤一：按字典序排序参数
        ksort($array);
        $string = $this->ToUrlParams($array);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".$this->pay_key;
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    public function FromXml($xml)
    {

        libxml_disable_entity_loader(true);
        $arr = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $arr;
    }

    public function ToXml($array)
    {
        $xml = "<xml>";
        foreach ($array as $key=>$val)
        {
            if($key != 'body')
            {
                $xml.="<".$key.">".$val."</".$key.">";
            }
            else
            {
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    public function wtw_request($url,$data = null)
    {
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

    /*企业证书SSL请求*/
    public function wxHttpsRequestPem( $url,$vars,$aHeader=array(), $second=30) {
        global $_W;
        $cert = MODULE_ROOT."/Cert/".$_W['account']['acid']."/apiclient_cert.pem";
        $key = MODULE_ROOT."/Cert/".$_W['account']['acid']."/apiclient_key.pem";
        $ca  = MODULE_ROOT."/Cert/".$_W['account']['acid']."/rootca.pem";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_TIMEOUT,$second);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
        curl_setopt($ch,CURLOPT_SSLCERTTYPE,'PEM');

        curl_setopt($ch,CURLOPT_SSLCERT,$cert);
        curl_setopt($ch,CURLOPT_SSLKEYTYPE,'PEM');

        curl_setopt($ch,CURLOPT_SSLKEY,$key);
        curl_setopt($ch,CURLOPT_CAINFO,'PEM');

        curl_setopt($ch,CURLOPT_CAINFO,$ca);
        if( count($aHeader) >= 1 )
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeader);
        }
        curl_setopt($ch,CURLOPT_POST, 1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$vars);
        $data = curl_exec($ch);
        if($data)
        {
            curl_close($ch);
            return $data;
        }
        else
        {
            $error = curl_errno($ch);
            echo "call faild, errorCode:$error\n";
            curl_close($ch);
            return false;
        }
    }

}