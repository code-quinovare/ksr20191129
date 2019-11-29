<?php
require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYConfigClient.php');
class YLYSignAndUuidClient{


    public static function GetSign($timestamp, $client_id,$clientSecret)
    {
        return md5(
           /* YLYConfigClient::$YLYClientId.
            $timestamp.
            YLYConfigClient::$YLYClientSecret*/
           $client_id.$timestamp.$clientSecret
        );
    }


    public static function Uuid4(){
        mt_srand((double)microtime() * 10000);
        $charid = strtolower(md5(uniqid(rand(), true)));
        $hyphen = '-';
        $uuidv4 =
            substr($charid, 0, 8) . $hyphen .
            substr($charid, 8, 4) . $hyphen .
            substr($charid, 12, 4) . $hyphen .
            substr($charid, 16, 4) . $hyphen .
            substr($charid, 20, 12);
        return $uuidv4;
    }


}