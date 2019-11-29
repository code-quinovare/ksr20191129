<?php
/**
* 
*/
class DeamPrint{
/**
 * 易联云生成签名sign
 * @param  array $params 参数
 * @param  string $apiKey API密钥
 * @param  string $msign 打印机密钥
 * @return   string sign
 */
public function yly_GenerateSign($params, $apiKey,$msign)
{
    //所有请求参数按照字母先后顺序排
    ksort($params);
    //定义字符串开始所包括的字符串
    $stringToBeSigned = $apiKey;
    //把所有参数名和参数值串在一起
    foreach ($params as $k => $v)
    {
        $stringToBeSigned .= urldecode($k.$v);
    }
    unset($k, $v);
    //定义字符串结尾所包括的字符串
    $stringToBeSigned .= $msign;
    //使用MD5进行加密，再转化成大写
    return strtoupper(md5($stringToBeSigned));
}
/**
 * 易联云打印接口
 * @param  int $partner     用户ID
 * @param  string $machine_code 打印机终端号
 * @param  string $content      打印内容
 * @param  string $apiKey       API密钥
 * @param  string $msign       打印机密钥
 */
public function printerYilianyunNew($link_url,$partner,$machine_code,$content,$apiKey,$msign)
{
	$param = array(
		"partner"=>$partner,
		'machine_code'=>$machine_code,
		'time'=>time(),
	);
	//获取签名
	$param['sign'] = $this->yly_GenerateSign($param,$apiKey,$msign);
	$param['content'] = $content;
	$response = ihttp_request($link_url,$param);
	$result = @json_decode($response['content'], true);
	return $result;
}
/**
 * 飞鹅云打印接口
 */
public function printerFeie($link_url,$user,$ukey,$deviceNo,$content,$times)
{
	$param = array(
		"user"=>$user,
		'stime'=>time(),
		'apiname'=>'Open_printMsg',
		'sn'=>$deviceNo,
		'times'=>$times
	);
	//获取签名
	$param['sig'] = sha1($param['user'].$ukey.$param['stime']);
	$param['content'] = $content;
	$response = ihttp_request($link_url,$param);
	$result = @json_decode($response['content'], true);
	return $result;
}
/**
 * 365 s1 
*/
public function printer365s1($deviceNo,$key,$content,$times)
{
	$link_url = "http://open.printcenter.cn:8080/addOrder";
	$param = array(
		'deviceNo'		=>	$deviceNo,
		'printContent'	=>	$content,
		'key'			=>	$key,
		'times'			=>	empty($times) ? 1 : $times
	);
	$response = ihttp_request($link_url,$param);
	$result = @json_decode($response['content'], true);
	return $result;
}


}
?>