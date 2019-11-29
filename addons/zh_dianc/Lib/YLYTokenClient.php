<?php

require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYConfigClient.php');

require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYSignAndUuidClient.php');

require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYHttpClient.php');

class YLYTokenClient{



    private static $requestUrl = 'https://open-api.10ss.net/oauth/oauth';



    /**

     * ��ȡToken

     * @param $grantType

     * @param $scope

     * @param $timesTamp

     * @param null $code

     * @return mixed

     */

    public static function GetToken($grantType, $scope, $timesTamp,$client_id,$clientSecret, $code = null)

    {

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp,$client_id,$clientSecret),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'grant_type' => $grantType,

            'scope' => $scope,

            'code' => $code,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo, self::$requestUrl);

    }



    /**

     * ˢ��Token

     * @param $grantType

     * @param $scope

     * @param $timesTamp

     * @param $RefreshToken

     * @return mixed

     */

    public static function RefreshToken($grantType, $scope, $timesTamp, $RefreshToken)

    {

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'grant_type' => $grantType,

            'scope' => $scope,

            'refresh_token' => $RefreshToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo, self::$requestUrl);

    }



}

















