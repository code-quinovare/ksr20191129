<?php



require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYConfigClient.php');

require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYSignAndUuidClient.php');

require_once (IA_ROOT . '/addons/zh_hdbm/Lib/YLYHttpClient.php');

class YLYOpenApiClient {



    /**

     * ����Ӧ��ģʽ�µ���Ȩ�ն�,ɨ������msign�����ĳ�qr_key

     * @param $machineCode

     * @param $msign or $qrKey

     * @param $accessToken

     * @param $timesTamp

     * @return mixed

     */

    public static function addPrint($machineCode, $msign, $accessToken, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/addprinter';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'msign' => $msign,

            'access_token' => $accessToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ��ӡ�ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $content

     * @param $originId

     * @param $timesTamp

     * @return mixed

     */

    public static function printIndex($machineCode, $accessToken, $content, $originId, $timesTamp,$client_id,$clientSecret)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/print/index';

        $requestAll = [

            //'client_id' => YLYConfigClient::$YLYClientId,
            'client_id' =>$client_id ,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp,$client_id,$clientSecret),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'content' => $content,

            'origin_id' => $originId,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ɾ���ն���Ȩ

     * @param $machineCode

     * @param $accessToken

     * @param $timesTamp

     * @return mixed

     */

    public static function deletePrint($machineCode, $accessToken, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/deleteprinter';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ����Ӧ�ò˵��ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $content

     * @param $timesTamp

     * @return mixed

     */

    public static function printMenu($machineCode, $accessToken, $content, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printmenu/addprintmenu';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'content' => $content,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * �ػ������ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $responseType

     * @param $timesTamp

     * @return mixed

     */

    public static function shutdownRestart($machineCode, $accessToken, $responseType, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/shutdownrestart';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'response_type' => $responseType,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * �������ڽӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $responseType

     * @param $voice

     * @param $timesTamp

     * @return mixed

     */

    public static function setSound($machineCode, $accessToken, $responseType, $voice, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/setsound';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'response_type' => $responseType,

            'voice' => $voice,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ��ȡ���ʹ�ӡ��Ƚӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $timesTamp

     * @return mixed

     */

    public static function printInfo($machineCode, $accessToken, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/printinfo';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }





    /**

     *��ȡ������Ӳ���汾�ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $timesTamp

     * @return mixed

     */

    public static function getVersion($machineCode, $accessToken, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/getversion';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ȡ������δ��ӡ�ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $timesTamp

     * @return mixed

     */

    public static function cancelAll($machineCode, $accessToken, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/cancelall';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ȡ������δ��ӡ�����ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $orderId

     * @param $timesTamp

     * @return mixed

     */

    public static function cancelOne($machineCode, $accessToken, $orderId, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/cancelone';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'order_id' => $orderId,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ����logo�ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $imgUrl

     * @param $timesTamp

     * @return mixed

     */

    public static function setIcon($machineCode, $accessToken, $imgUrl, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/seticon';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'img_url' => $imgUrl,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ȡ��logo�ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $timesTamp

     * @return mixed

     */

    public static function deleteIcon($machineCode, $accessToken, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/deleteicon';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * ������ӡ�ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $responseType

     * @param $timesTamp

     * @return mixed

     */

    public static function btnPrint($machineCode, $accessToken, $responseType, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/btnprint';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'response_type' => $responseType,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }



    /**

     * �ӵ��ܵ��ӿ�

     * @param $machineCode

     * @param $accessToken

     * @param $responseType

     * @param $timesTamp

     * @return mixed

     */

    public static function getOrder($machineCode, $accessToken, $responseType, $timesTamp)

    {

        $requestUrl = YLYConfigClient::$YLYRequestUrl.'/printer/getorder';

        $requestAll = [

            'client_id' => YLYConfigClient::$YLYClientId,

            'sign' => YLYSignAndUuidClient::GetSign($timesTamp),

            'id' => YLYSignAndUuidClient::Uuid4(),

            'machine_code' => $machineCode,

            'access_token' => $accessToken,

            'response_type' => $responseType,

            'timestamp' => $timesTamp,

        ];

        $requestInfo = http_build_query($requestAll);

        return YLYHttpClient::push($requestInfo,$requestUrl);

    }





}



