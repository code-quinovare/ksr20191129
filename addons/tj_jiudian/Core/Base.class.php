<?php
Class Base {

    /**
     * Base constructor 获取站点的一些配置
     */
    public function __construct()
    {
    }

    static public function test(){
        echo __CLASS__."\r\n".__FUNCTION__;
    }


    static function downloadimgages($media_ids)
    {
        global $_W;
        $media_ids = explode(',', $media_ids);
        if (!$media_ids) {
            return '';
        }
        $account_api = WeAccount::create();
        $account_api->clearAccessToken();

        $access_token = $account_api->getAccessToken();
        load()->func('communication');
        load()->func('file');
        $contentType["image/gif"] = ".gif";
        $contentType["image/jpeg"] = ".jpeg";
        $contentType["image/png"] = ".png";
        foreach ($media_ids as $id) {
            $url = "http://file.api.weixin.qq.com/cgi-bin/media/get?access_token=" . $access_token . "&media_id=" . $id;
            $data = ihttp_get($url);
            $filetype = $data['headers']['Content-Type'];

            if($filetype == "image/jpeg")
            {
                $filename = date('YmdHis') .'_' . rand(1000, 9999) . $contentType[$filetype];
                $wr = file_write('/images/luntan/' . $filename, $data['content']);
                if ($wr) {
                    $file_succ[] = array('name' => $filename, 'path' => '/images/luntan/' . $filename, 'type' => 'local');
                }
            }
            else
            {
                $file_succ[] = array('name' => "", 'path' => '', 'type' => '');
            }

        }

        $temp = array();

        foreach ($file_succ as $key => $value) {

            $r = file_remote_upload('/images/luntan/' . $value['name']);
            if (is_error($r)) {
                unset($file_succ[$key]);
                continue;
            }
            if($file_succ[$key]['name'] != "")
            {
                $r = file_remote_upload('/images/luntan/' . $value['name']);
                if (is_error($r)) {
                    unset($file_succ[$key]);
                    continue;
                }
                if($file_succ[$key]['name'] != "")
                {
                    $temp[$key] = 'images/luntan/' . $value['name'];
                    $file_succ[$key]['name'] = '/images/luntan/' . $value['name'];
                    $file_succ[$key]['type'] = 'other';
                }
            }

        }

        return $temp;
    }

    /**
     * @param array $arr 文件$_FILES
     * @return string 返回上传文件的地址
     */
    static public function Upload($arr = array())
    {
        $ext = explode('.',$arr['name']);
        $filename = substr(md5(time()),10).date('Y-m-d').".".$ext[count($ext)-1];
        $path = ATTACHMENT_ROOT."images/luntan/video/";
        if(!file_exists($path.$filename))
        {
            @mkdir($path);
        }
        if(move_uploaded_file($arr["tmp_name"], $path.$filename)){
            return "images/luntan/video/".$filename;
        }
        else
        {
            return '';
        }
    }

    /**
     * @param $file 上传的文件
     * @param string $dir 需要上传到的目录
     * @return string 返回文件地址
     */
    static public function File_upload($file,$dir = 'file')
    {
        $ext = explode('.',$file['name']);
        $filename = substr(md5(time()),10).date('Y-m-d').".".$ext[count($ext)-1];
        $path = ATTACHMENT_ROOT."images/luntan/".$dir."/";
        if(!file_exists($path.$filename))
        {
            @mkdir($path);
        }
        if(move_uploaded_file($file["tmp_name"], $path.$filename)){
            return "images/luntan/".$dir."/".$filename;
        }
        else
        {
            return '';
        }
    }

}