<?php
class HttpClient
{
    /**
     * 发送GET请求
     * @param string $url
     * @param array $param
     * @return bool|mixed
     */
    public static function doGet($url, $param = null)
    {
        if (empty($url) or (!empty($param) and !is_array($param))) {
            throw new InvalidArgumentException('Params is not of the expected type');
        }
        // 验证url合法性
//        if (!filter_var($url, FILTER_VALIDATE_URL)) {
//            throw new InvalidArgumentException('Url is not valid');
//        }

        if (!empty($param)) {
            $url = trim($url, '?') . '?' . http_build_query($param);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     //  不进行ssl 认证
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!empty($result) and $code == 200) {
            return $result;
        }
        return false;
    }

    /**
     * POST请求
     * @param $url
     * @param $param
     * @return boolean|mixed
     */
    public static function doPost($url, $param, $method = "POST")
    {
        // echo 'Request url is ' . $url . PHP_EOL;
        if (empty($url) or empty($param)) {
            throw new InvalidArgumentException('Params is not of the expected type');
        }

        // 验证url合法性
//        if (!filter_var($url, FILTER_VALIDATE_URL)) {
//            throw new InvalidArgumentException('Url is not valid');
//        }

        if (!empty($param) and is_array($param)) {
            $param = urldecode(json_encode($param));
        } else {
            // $param = urldecode(strval($param));
            $param = strval($param);
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);     //  不进行ssl 认证

        if (strcmp($method, "POST") == 0) {  // POST 操作
          curl_setopt($ch, CURLOPT_POST, true);
        } else if (strcmp($method, "DELETE") == 0) { // DELETE操作
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
        } else {
          throw new InvalidArgumentException('Please input correct http method, such as POST or DELETE');
        }

        curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: Application/json'));
        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if (!empty($result) and $code == '200') {
            return $result;
        }
        return false;
    }
}
