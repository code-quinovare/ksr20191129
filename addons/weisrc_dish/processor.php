<?php
/**
 * 微点餐
 *
 * 源码来自说图谱源码网
 *
 * www.shuotupu.com
 */
defined('IN_IA') or exit('Access Denied');

class weisrc_dishModuleProcessor extends WeModuleProcessor
{

    public $name = 'weisrc_dishModuleProcessor';

    public function isNeedInitContext()
    {
        return 0;
    }

    public function respond()
    {
        global $_W;
        $rid = $this->rule;
        $curopenid = $this->message['from'];
        $weid = $_W['uniacid'];
        load()->model('mc');
        load()->classs('weixin.account');
        $setting = $this->getSetting();

        //获取昵称，坑爹的mc_fansinfo，用mc_fetch !不能实时获取到新关注的粉丝昵称
        $mc = mc_fetch($curopenid);
        $tip = '～～～';
        if (empty($mc['nickname']) || empty($mc['avatar']) || empty($mc['gender'])) {
            load()->classs('account');
            load()->func('communication');
            $accToken = WeAccount::token();
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$accToken}&openid={$curopenid}&lang=zh_CN";
            $json = ihttp_get($url);
            $userinfo = @json_decode($json['content'], true);
            if ($userinfo['nickname']) {
                $mc['nickname'] = $userinfo['nickname'];
            }
            if ($userinfo['headimgurl']) {
                $mc['avatar'] = $userinfo['headimgurl'];
            }
            if ($userinfo['sex']) {
                $mc['gender'] = $userinfo['sex'];
            }
            $tip = '。。。';
        }

        if ($this->message['msgtype'] == 'event') {
            $scene_str = str_replace('qrscene_', '', $this->message['eventkey']); //场景
            if ($this->message['event'] == 'subscribe') { //关注

            } elseif ($this->message['event'] == 'SCAN') { //扫描

            }
            $agent = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE scene_str=:scene_str AND weid=:weid LIMIT 1", array(':scene_str' => $scene_str, ':weid' => $_W['uniacid']));

            $fans = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE from_user=:from_user AND weid=:weid LIMIT 1", array(':from_user' => $curopenid, ':weid' => $_W['uniacid']));

            if ($agent['from_user'] == $curopenid) {
                $this->postText($curopenid, '这是您的推广二维码！');
                exit;
            }

            if ($agent) {
                $agentid = $agent['id'];
                $agent = $this->getFansById($agentid);
                if ($setting['commission_mode'] == 2) { //代理商模式
                    if ($agent['is_commission'] != 2) {//用户不是代理商重新查找
                        $agent = $this->getFansById($agent['agentid']);
                        $agentid = intval($agent['id']);
                    }
                }
                if (!empty($agent['agentid'])) {
                    $agentid2 = intval($agent['agentid']);
                    $agent2 = $this->getFansById($agentid2);
                    if (!empty($agent2['agentid'])) {
                        $agentid3 = intval($agent2['agentid']);
                    }
                }

                if (empty($fans)) {
                    $insert = array(
                        'weid' => $weid,
                        'from_user' => $curopenid,
                        'nickname' => $mc['nickname'],
                        'headimgurl' => $mc['avatar'],
                        'agentid' => $agentid,
                        'agentid2' => $agentid2,
                        'agentid3' => $agentid3,
                        'dateline' => TIMESTAMP
                    );
                    pdo_insert("weisrc_dish_fans", $insert);

                    if (!empty($mc['nickname'])) {
                        $msg = $mc['nickname'] . "成为您的下级成员！";
                        $this->postText($agent['from_user'], $msg);
                    } else {
                        $msg = $curopenid . "取不到用户信息！" . $tip;
                        $this->postText($agent['from_user'], $msg);
                    }
                } else {
                    $update = array(
                        'nickname' => $mc['nickname'],
                        'headimgurl' => $mc['avatar']
                    );
                    pdo_update("weisrc_dish_fans", $update, array('id' => $fans['id']));

                    $msg = $mc['nickname'] . "访问您的二维码！" . $tip;
                    $this->postText($agent['from_user'], $msg);
                }
            } else {
                $checkmsg = "代理商不存在！" . $scene_str . $tip;
                $this->postText($curopenid, $checkmsg);
            }
        }
    }

    public function postText($openid, $text)
    {
        $post = '{"touser":"' . $openid . '","msgtype":"text","text":{"content":"' . $text . '"}}';
        $ret = $this->postRes($this->getAccessToken(), $post);
        return $ret;
    }

    private function postRes($access_token, $data)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token={$access_token}";
        load()->func('communication');
        $ret = ihttp_request($url, $data);
        $content = @json_decode($ret['content'], true);
        return $content['errcode'];
    }

    private function getAccessToken()
    {
        global $_W;
        load()->model('account');
        $acid = $_W['acid'];
        if (empty($acid)) {
            $acid = $_W['uniacid'];
        }
        $account = WeAccount::create($acid);
        $token = $account->getAccessToken();
        return $token;
    }

    public function isNeedSaveContext()
    {
        return false;
    }

    public function getFansById($id)
    {
        global $_W;
        $fans = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_fans") . " WHERE id=:id AND weid=:weid LIMIT 1", array(':id' => $id, ':weid' => $_W['uniacid']));
        return $fans;
    }

    public function getSetting()
    {
        global $_W, $_GPC;
        $setting = pdo_fetch("SELECT * FROM " . tablename("weisrc_dish_setting") . " where weid = :weid LIMIT 1", array(':weid' => $_W['uniacid']));
        return $setting;
    }
}
