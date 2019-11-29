<?php
global $_GPC, $_W;
$storeid=$_COOKIE["storeid"];
$cur_store = $this->getStoreById($storeid);
$GLOBALS['frames'] = $this->getMainMenu2();
$info=pdo_get('wpdc_store',array('uniacid'=>$_W['uniacid'],'id'=>$storeid));
    if(checksubmit('submit')){
            $data['is_mp3']=$_GPC['is_mp3'];
            $data['is_video']=$_GPC['is_video'];
            $data['store_mp3']=$_GPC['store_mp3'];
            // if($_GPC['store_video']!=$info['store_video']){
            //    $vid=substr($_GPC['store_video'],-16,-5);
            //     $vid=trim(strrchr($_GPC['store_video'], '/'),'/');
            //     $vid=substr($vid,0,-5);
            //     $json=file_get_contents("http://vv.video.qq.com/getinfo?vids=".$vid."&platform=101001&charge=0&otype=json");
            //     $json=substr($json,13);
            //     $json=substr($json,0,-1);
            //     $a=json_decode(html_entity_decode($json));
            //     $sz=json_decode(json_encode($a),true);
            //     $url=$sz['vl']['vi']['0']['ul']['ui']['3']['url'];
            //     $fn=$sz['vl']['vi']['0']['fn'];
            //     $fvkey=$sz['vl']['vi']['0']['fvkey'];
            //     $data['store_video']=$url.$fn.'?vkey='.$fvkey;  
            // }
           

            $data['store_video']=$_GPC['store_video'];
                $res = pdo_update('wpdc_store', $data, array('id' => $_GPC['id']));
                if($res){
                    message('编辑成功',$this->createWebUrl('mt',array()),'success');
                }else{
                    message('编辑失败','','error');
                }
           
        }
include $this->template('web/mt');