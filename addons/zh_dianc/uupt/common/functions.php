<?php
/**
 * 自定义函数
 *
 * @author 点沐
 * @url 
 */

function show_json($status = 1, $return = NULL){
	$ret = array('status' => $status, 'result' => ($status == 1 ? array('url' => referer()) : array()));
	if (!(is_array($return))) 
	{
		if ($return) 
		{
			$ret['result']['message'] = $return;
		}
		exit(json_encode($ret));
	}
	else 
	{
		$ret['result'] = $return;
	}
	if (isset($return['url'])) 
	{
		$ret['result']['url'] = $return['url'];
	}
	else if ($status == 1) 
	{
		$ret['result']['url'] = referer();
	}
	exit(json_encode($ret));
}
function formatQueryParaMap($paraMap, $urlencode){
	$buff = "";
	ksort($paraMap);
	foreach ($paraMap as $k => $v){
		if (null != $v && "null" != $v && "sign" != $k) {
		    if($urlencode){
			   $v = urlencode($v);
			}
			$buff .= $k . "=" . $v . "&";
		}
	}
	$reqPar;
	if (strlen($buff) > 0) {
		$reqPar = substr($buff, 0, strlen($buff)-1);
	}
	return $reqPar;
}
function curl_post($url,$data){
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_POST, 1);//发送一个常规的Post请求
	curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//Post提交的数据包
    $rv = curl_exec($curl);//输出内容
    curl_close($curl);
    return $rv;
}
function httpcurl($url){
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$output = curl_exec($ch);//输出内容
	curl_close($ch);
	return $output;
}
function arrayToXml($arr){
    $xml = "<xml>";
    foreach ($arr as $key=>$val)
    {
    	 if (is_numeric($val))
    	 {
    	 	$xml.="<".$key.">".$val."</".$key.">"; 

    	 }
    	 else{
    	 	$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";  
    	 } 
    }
    $xml.="</xml>";
    return $xml;
}
function orderquery($res,$wechat){
	$orderQueryUrl = 'https://api.mch.weixin.qq.com/pay/orderquery';
	$input = array();
	$input['appid'] = $res['appid'];
	$input['mch_id'] = $res['mch_id'];
	$input['out_trade_no'] = $res['out_trade_no'];
	$input['nonce_str'] = random(32);
	
	$unSignParaStr = formatQueryParaMap($input,false);
	$signStr = $unSignParaStr."&key=".$wechat['apikey'];
	$input['sign'] = strtoupper(md5($signStr));
	
	$orderQueryInfo = simplexml_load_string(curl_post($orderQueryUrl,arrayToXml($input)),'SimpleXMLElement', LIBXML_NOCDATA);//红包预下单返回信息
	$orderQueryInfo = json_decode(json_encode($orderQueryInfo),true);	
	return $orderQueryInfo;
}
function json_encode_ex($value){
	if(version_compare(PHP_VERSION,'5.4.0','<')){
		$str = json_encode($value);
		$str = preg_replace_callback(
			"#\\\u([0-9a-f]{4})#i",
			function($matchs){
				return iconv('UCS-2BE', 'UTF-8', pack('H4', $matchs[1]));
			},
			$str
		);
		return $str;
	}else{
		return json_encode($value, JSON_UNESCAPED_UNICODE);
	}
}
function getSignature($str, $key) {  
    $signature = "";  
    if (function_exists('hash_hmac')) {  
        $signature = base64_encode(hash_hmac("sha1", $str, $key, true));  
    } else {  
        $blocksize = 64;  
        $hashfunc = 'sha1';  
        if (strlen($key) > $blocksize) {  
            $key = pack('H*', $hashfunc($key));  
        }  
        $key = str_pad($key, $blocksize, chr(0x00));  
        $ipad = str_repeat(chr(0x36), $blocksize);  
        $opad = str_repeat(chr(0x5c), $blocksize);  
        $hmac = pack(  
                'H*', $hashfunc(  
                        ($key ^ $opad) . pack(  
                                'H*', $hashfunc(  
                                        ($key ^ $ipad) . $str  
                                )  
                        )  
                )  
        );  
        $signature = base64_encode($hmac);  
    }  
    return $signature;  
}
function is_utf8($str) 
{
	return preg_match('%^(?:' . "\r\n" . '            [\	\
\
\ -\~]              # ASCII' . "\r\n" . '            | [\?-\?][\?-\?]             # non-overlong 2-byte' . "\r\n" . '            | \?[\?-\?][\?-\?]         # excluding overlongs' . "\r\n" . '            | [\?-\?\?\?][\?-\?]{2}  # straight 3-byte' . "\r\n" . '            | \?[\?-\?][\?-\?]         # excluding surrogates' . "\r\n" . '            | \?[\?-\?][\?-\?]{2}      # planes 1-3' . "\r\n" . '            | [\?-\?][\?-\?]{3}          # planes 4-15' . "\r\n" . '            | \?[\?-\?][\?-\?]{2}      # plane 16' . "\r\n" . '            )*$%xs', $str);
}
function setSpacing($str, $length = 32) 
{
	$str_old = $str;
	$str = ((is_utf8($str) ? iconv('utf-8', 'gb2312', $str) : $str));
	$num = strlen($str);
	if ($length < $num) 
	{
		if ((32 < $num) && ($length == 32)) 
		{
			$temp = '';
			$count = ceil($num / $length);
			$i = 0;
			while ($i <= $count) 
			{
				$temp .= mb_substr($str_old, $i * $length, $length);
				++$i;
			}
			return $temp;
		}
		return mb_substr($str_old, 0, floor($length / 2), 'utf-8') . str_repeat(' ', $length % 2);
	}
	return $str_old . str_repeat(' ', $length - $num);
}
function wxappMessage($access_token,$touser,$template_id,$page,$form_id,$data,$emphasis_keyword){
	if(empty($access_token)){
		return error(1, 'access_token为空');
	}
	if(empty($touser)){
		return error(1, 'openid为空');
	}
	$postArr = array(
		'touser'			=>	$touser,
		'template_id'		=>	$template_id,
		'page'				=>	$page,
		'form_id'			=>	$form_id,
		'data'				=>	$data,
		'emphasis_keyword'	=>	$emphasis_keyword
	);
	if(empty($emphasis_keyword)){
		unset($postArr['emphasis_keyword']);
	}
	$postJson = json_encode_ex($postArr);
	$url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=".$access_token;
	$response = ihttp_request($url, $postJson);
	$result = @json_decode($response['content'], true);
	return $result;
}
function manage_template($filename, $flag = TEMPLATE_DISPLAY) {
	global $_W;
	$name = 'deam_food';
	if (defined('IN_SYS')) {
		$template = 'default';
		$source = IA_ROOT . '/addons/' . $name . '/manage/template/' . $template . '/' . $filename . '.html';
		$compile = IA_ROOT . '/data/tpl/web/' . $name . '/' . $template . '/manage/' . $filename . '.tpl.php';
	}else{
		$template = 'default';
		$source = IA_ROOT . '/addons/' . $name . '/manage/template/' . $template . '/' . $filename . '.html';
		$compile = IA_ROOT . '/data/tpl/web/' . $name . '/' . $template . '/manage/' . $filename . '.tpl.php';
	}
	if(!is_file($source)) {
		echo "template source '{$filename}' is not exist!";
		return '';
	}
	if(DEVELOPMENT || !is_file($compile) || filemtime($source) > filemtime($compile)) {
		manage_template_compile($source, $compile);
	}
	return $compile;
}

function manage_url($params = array()){
	global $_W;
	$params['i'] = $_W['uniacid'];
	$params['do'] = "manage";
	$params['m'] = "deam_food";
	return wurl('site/entry', $params);
}
function activity_get_coupon_colors() {
	$colors = array(
		'Color010' => '#55bd47',
		'Color020' => '#10ad61',
		'Color030' => '#35a4de',
		'Color040' => '#3d78da',
		'Color050' => '#9058cb',
		'Color060' => '#de9c33',
		'Color070' => '#ebac16',
		'Color080' => '#f9861f',
		'Color081' => '#f08500',
		'Color082' => '#a9d92d',
		'Color090' => '#e75735',
		'Color100' => '#d54036',
		'Color101' => '#cf3e36',
		'Color102' => '#5e6671',
	);
	return $colors;
}
require DM_ROOT. '/common/template.func.php';
?>