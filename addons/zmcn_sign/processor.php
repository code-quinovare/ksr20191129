<?php
/**
 *涵创网络友情提供
 * http://www.hcexe.com
 */
defined('IN_IA') or exit('Access Denied');
class zmcn_signModuleProcessor extends WeModuleProcessor
{
    public function respond()
    {
        global $_W, $fans, $member, $settings;
        $content  = $this->message['content'];
        $openid   = $this->message['from'];
        $settings = $this->module['config'];
        $rid      = $this->rule;
        $rna      = 'H' . $rid;
        $gjz      = "每日签到：";
        $huod     = array();
        $title    = pdo_fetchcolumn("SELECT name FROM " . tablename('rule') . " WHERE id = :rid LIMIT 1", array(
            ':rid' => $rid
        ));
        if (!empty($huod['id'])) {
            $gjz = "每日签到：[" . $rna . "]";
            if (is_serialized($huod['hd'])) {
                $qdset = iunserializer($huod['hd']);
            }
        }
        load()->model('mc');
        load()->classs('weixin.account');
        $_W['access_token'] = WeAccount::token();
        $member             = array();
        $fans               = array();
        $settings['jftype'] = max(1, intval($settings['jftype']));
        $fans               = pdo_fetch("SELECT * FROM " . tablename('mc_mapping_fans') . " WHERE uniacid=:uniacid AND openid=:openid", array(
            ':uniacid' => $_W['uniacid'],
            ':openid' => $openid
        ));
        $member             = mc_fetch($fans['uid'], array(
            'avatar',
            'nickname',
            'credit1'
        ));
        $_W['uid']          = $fans['uid'];
        if ($_W['account']['level'] > '2') {
            $oauth2_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=" . $_W['access_token'] . "&openid=" . $openid . "&lang=zh_CN&a=";
            $cont2      = ihttp_get($oauth2_url);
            $info       = @json_decode($cont2['content'], true);
            if (empty($info) || !is_array($info) || empty($info['subscribe'])) {
                $_W['fans']['follow'] = 0;
            } else {
                $cont2            = array();
                $info['nickname'] = weblogin_clearemoji($info['nickname']);
                if (!empty($info['nickname'])) {
                    $cont2['nickname']  = $info['nickname'];
                    $fans['nickname']   = $info['nickname'];
                    $member['nickname'] = $info['nickname'];
                }
                if (!empty($info['sex'])) {
                    $cont2['gender']  = $info['sex'];
                    $fans['gender']   = $info['sex'];
                    $member['gender'] = $info['sex'];
                }
                if (!empty($info['province'])) {
                    $cont2['resideprovince']  = $info['province'];
                    $member['resideprovince'] = $info['province'];
                }
                if (!empty($info['city'])) {
                    $cont2['residecity']  = $info['city'];
                    $member['residecity'] = $info['city'];
                }
                if (!empty($info['country'])) {
                    $cont2['nationality']  = $info['country'];
                    $member['nationality'] = $info['country'];
                }
                if (!empty($info['headimgurl'])) {
                    $cont2['avatar']  = $info['headimgurl'];
                    $member['avatar'] = $info['headimgurl'];
                }
                $_W['fans']['follow'] = '1';
                pdo_update('mc_members', $cont2, array(
                    'uid' => $_W['member']['uid']
                ));
                $cont2 = array(
                    'nickname' => $info['nickname'],
                    'groupid' => $info['groupid'],
                    'follow' => '1',
                    'updatetime' => TIMESTAMP
                );
                if (!is_array($info['unionid']) && pdo_fieldexists('mc_mapping_fans', 'unionid')) {
                    $cont2['unionid'] = $info['unionid'];
                }
                pdo_update('mc_mapping_fans', $cont2, array(
                    'openid' => $info['openid']
                ));
            }
        }
        if (empty($member['avatar'])) {
            $member['avatar'] = $fans['avatar'];
        }
        if (empty($member['nickname'])) {
            $member['nickname'] = $fans['nickname'];
        }
        $today = mktime(0, 0, 0, date("m"), date("d"), date("Y"));
        if (empty($settings['success_msg'])) {
            $settings['success_msg'] = "亲，您好棒！签到成功啦！[签到积分]个积分正在奔赴您的账户！明天再来签到您将能获得[下期积分]个积分！要天天来哦~！请登录会员中心查询。";
        }
        if (empty($settings['continuity_msg'])) {
            $settings['continuity_msg'] = "亲，您太热情了，今天您已经签到过了~明天再来吧~";
        }
        $_W['zmcn']['allnum']   = (int) pdo_fetchcolumn("SELECT sum(num) FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND uid=:uid AND module = 'zmcn_sign' ", array(
            ':uniacid' => $_W['uniacid'],
            ':uid' => $fans['uid']
        ));
        $_W['zmcn']['todaycom'] = pdo_fetch("SELECT COUNT(*) AS a , sum(num) AS b FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND module = 'zmcn_sign' AND createtime>=:starttime", array(
            ':uniacid' => $_W['uniacid'],
            ':starttime' => $today
        ));
        $_W['zmcn']['number']   = 0;
        $_W['zmcn']['total']    = round($member['credit1']);
        $_W['zmcn']['jl']       = 0;
        $nao                    = intval(date("Hi"));
        $thisw                  = intval(date("w"));
        $record                 = (int) pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND uid=:uid AND module = 'zmcn_sign' AND createtime>=:starttime", array(
            ':uniacid' => $_W['uniacid'],
            ':uid' => $fans['uid'],
            ':starttime' => $today
        ));
        if (!empty($settings['time']['is']) && ($nao < (int) $settings['time']['a'] || $nao > (int) $settings['time']['e'])) {
            $fgltxt              = '';
            $settings['welcome'] = $settings['time']['t'];
        } elseif (empty($record)) {
            $record = pdo_fetch("SELECT COUNT(*) AS number , num FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND uid=:uid AND module = 'zmcn_sign' AND createtime>=:starttime AND createtime<:endtime", array(
                ':uniacid' => $_W['uniacid'],
                ':uid' => $fans['uid'],
                ':starttime' => $today - 86400,
                ':endtime' => $today
            ));
            if (empty($record['number'])) {
                $_W['zmcn']['number'] = max(1, $settings['everyday']);
            } else {
                $_W['zmcn']['number'] = $record['num'] + max(0, $settings['continuity']);
            }
            if ((int) $settings['intup'] > 0 && $_W['zmcn']['number'] > (int) $settings['intup']) {
                $_W['zmcn']['number'] = (int) $settings['intup'];
            }
            mc_credit_update($fans['uid'], 'credit1', $_W['zmcn']['number'], array(
                0 => 0,
                1 => '每日签到：[' . $rna . ']' . date("Y-m-d"),
                'zmcn_sign',
                0,
                0
            ));
            $_W['zmcn']['total']         = round($member['credit1'] + $_W['zmcn']['number']);
            $_W['zmcn']['allnum']        = round($_W['zmcn']['allnum'] + $_W['zmcn']['number']);
            $_W['zmcn']['today']         = $_W['zmcn']['number'];
            $_W['zmcn']['todaycom']['a'] = (int) $_W['zmcn']['todaycom']['a'] + 1;
            $_W['zmcn']['todaycom']['b'] = (int) $_W['zmcn']['todaycom']['b'] + $_W['zmcn']['number'];
            if (!empty($settings['jl']['is']) && in_array($thisw, $settings['jl']['w'])) {
                for ($i = 0; $i < 5; ++$i) {
                    if ((int) $settings['jl']['a'][$i] <= $_W['zmcn']['todaycom']['a'] && $_W['zmcn']['todaycom']['a'] <= (int) $settings['jl']['b'][$i]) {
                        if ($settings['jl']['t'][$i] == '2') {
                            $settings['jl']['e'][$i] = (int) $settings['jl']['e'][$i] * 0.01;
                        } else {
                            $settings['jl']['t'][$i] = '1';
                        }
                        mc_credit_update($fans['uid'], 'credit' . $settings['jl']['t'][$i], $settings['jl']['e'][$i], array(
                            0 => 0,
                            1 => '[' . $rna . ']签到前' . $_W['zmcn']['todaycom']['a'] . '名奖励',
                            'zmcn_sign',
                            0,
                            0
                        ));
                        $settings['success_msg'] = $settings['success_msg'] . "\n" . $settings['jl']['ts'];
                        $_W['zmcn']['jl']        = $settings['jl']['e'][$i];
                    }
                }
            }
            $fgltxt = $this->replaceString($settings['success_msg']);
        } else {
            $_W['zmcn']['today'] = (int) pdo_fetchcolumn("SELECT num FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND uid=:uid AND module = 'zmcn_sign' AND createtime>=:starttime", array(
                ':uniacid' => $_W['uniacid'],
                ':uid' => $fans['uid'],
                ':starttime' => $today
            ));
            $fgltxt              = $this->replaceString($settings['continuity_msg']);
        }
        if (!empty($settings['ispaihang']) && $settings['ispaihang'] > 0) {
            $i = 1;
            $b = 'Y年m月d日';
            $c = "分";
            if ($settings['ispaihang'] == '1') {
                $phtj = array(
                    ':uniacid' => $_W['uniacid'],
                    ':starttime' => $today
                );
                $fgltxt .= "\n今天签到排行榜";
                $b = 'H:i:s';
            } elseif ($settings['ispaihang'] == '2') {
                $phtj = array(
                    ':uniacid' => $_W['uniacid'],
                    ':starttime' => $today - 604800
                );
                $fgltxt .= "\n7天签到排行榜";
            } elseif ($settings['ispaihang'] == '3') {
                $phtj = array(
                    ':uniacid' => $_W['uniacid'],
                    ':starttime' => $today - 2592000
                );
                $fgltxt .= "\n30天签到排行榜";
            } elseif ($settings['ispaihang'] == '4') {
                $phtj = array(
                    ':uniacid' => $_W['uniacid'],
                    ':starttime' => 0
                );
                $fgltxt .= "\n历史签到排行榜";
            } elseif ($settings['ispaihang'] == '5') {
                $phtj = array(
                    ':uniacid' => $_W['uniacid'],
                    ':starttime' => mktime(0, 0, 0, date("m"), 1, date("Y"))
                );
                $fgltxt .= "\n本月签到排行榜";
            }
            if (intval($settings['px']) == '1') {
                $px = ' DESC ';
            } else {
                $px = '';
            }
            if ($settings['paihangt'] == '1') {
                $ph = pdo_fetchall("SELECT uid,sum(num) as num,createtime FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND module = 'zmcn_sign' AND createtime>=:starttime group by uid ORDER BY num DESC,id " . $px . " LIMIT " . max(3, (int) $settings['paihangs']), $phtj);
                $fgltxt .= "(按积分总和)：\n";
            } elseif ($settings['paihangt'] == '2') {
                $ph = pdo_fetchall("SELECT uid,count(id) as num,max(createtime) as createtime FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND module = 'zmcn_sign' AND createtime>=:starttime group by uid ORDER BY num DESC,id " . $px . " LIMIT " . max(3, (int) $settings['paihangs']), $phtj);
                $fgltxt .= "(按签到次数)：\n";
                $c = "次";
            } else {
                $ph = pdo_fetchall("SELECT uid,max(num) as num,createtime FROM " . tablename('mc_credits_record') . " WHERE uniacid=:uniacid AND module = 'zmcn_sign' AND createtime>=:starttime group by uid ORDER BY num DESC,id " . $px . " LIMIT " . max(3, (int) $settings['paihangs']), $phtj);
                $fgltxt .= "(按单次积分)：\n";
            }
            foreach ($ph AS $param) {
                $aa = mc_fetch($param['uid']);
                $fgltxt .= "第" . $i . "名：[" . round($param['num']) . $c . "]" . $aa['nickname'] . "\n";
                $i += 1;
            }
        }
        if (!empty($settings['tx']['is'])) {
            if ((int) $settings['tx']['type'] == '1' && strlen($settings['tx']['djs']['day'] . '') == 8) {
                $txtx   = $settings['tx']['djs']['day'];
                $mbdata = mktime(0, 0, 0, date(substr($txtx, 4, 2)), date(substr($txtx, -2)), date(substr($txtx, 0, 4)));
                $txtx   = ceil(($mbdata - time()) / 60 / 60 / 24);
                $txtx   = "距离" . $settings['tx']['djs']['name'] . "还有" . $txtx . "天！";
            } elseif ((int) $settings['tx']['type'] == '0' && TIMESTAMP > strtotime($settings['tx']['time']['start']) && TIMESTAMP < strtotime($settings['tx']['time']['end']) && strlen($settings['tx']['xq']['t'][$thisw] . '') > 1) {
                $txtx = $settings['tx']['xq']['t'][$thisw];
            }
            if (strlen($txtx) > 2) {
                if (!empty($settings['welcome'])) {
                    $settings['welcome'] = $settings['welcome'] . "\n【提示】" . $txtx;
                } else {
                    $settings['welcome'] = "【提示】" . $txtx;
                }
            }
        }
        if (empty($settings['welcome'])) {
            $settings['welcome'] = "亲，欢迎您签到";
        }
        $abcd = array();
        $ii   = 0;
        cache_load('zmcn_good_pro', true);
        $ppo    = array();
        $abcd[] = array(
            'title' => $this->replaceString($settings['linktitle']),
            'picurl' => $settings['linklogo'],
            'url' => $settings['url1']['f']
        );
        $ii += 1;
        $abcd[] = array(
            'title' => $this->replaceString($settings['welcome']),
            'picurl' => $member['avatar'],
            'url' => $settings['url1']['t']
        );
        $ii += 1;
        $abcd[] = array(
            'title' => $fgltxt,
            'url' => $settings['url']
        );
        $ii += 1;
        if ($settings['isgg'] == '1') {
            if (!empty($_W['cache']['zmcn_good_pro'])) {
                shuffle($_W['cache']['zmcn_good_pro']);
                $ii += 1;
            }
            $ser = substr(md5(rand()), -6);
            for ($i = 0; $i < 5; ++$i) {
                $df = 0;
                if ($qdset['wailink'][$i]['is'] == '1') {
                    $df = (int) $_W['zmcn']['number'];
                } elseif ($qdset['wailink'][$i]['is'] == '2') {
                    $df = (int) $_W['zmcn']['today'];
                } elseif ($qdset['wailink'][$i]['is'] == '3') {
                    $df = (int) $_W['zmcn']['allnum'];
                }
                if ((int) $qdset['wailink'][$i]['fsu'] == '0') {
                    $qdset['wailink'][$i]['fsu'] = $df + 100;
                }
                if (!empty($qdset['wailink'][$i]['is']) && (TIMESTAMP > strtotime($qdset['wailink'][$i]['time']['start']) && TIMESTAMP < strtotime($qdset['wailink'][$i]['time']['end'])) && ($df >= (int) $qdset['wailink'][$i]['fs'] && $df <= (int) $qdset['wailink'][$i]['fsu'])) {
                    if (!empty($qdset['wailink'][$i]['a'])) {
                        $mm                          = TIMESTAMP . strtoupper(substr(md5($openid . TIMESTAMP . $ser . $qdset['wailink'][$i]['a']), -16));
                        $mbb5                        = md5($mm . $qdset['wailink'][$i]['a']);
                        $qdset['wailink'][$i]['url'] = str_replace('[FWM]', $mm, $qdset['wailink'][$i]['url']);
                        $qdset['wailink'][$i]['url'] = str_replace('[KEY]', $mbb5, $qdset['wailink'][$i]['url']);
                        $qdset['wailink'][$i]['url'] = str_replace('[SER]', $ser, $qdset['wailink'][$i]['url']);
                    }
                    $abcd[] = $qdset['wailink'][$i];
                    $ii += 1;
                }
            }
            if (!empty($settings['isint'])) {
                $ii = min(10 - $ii, $settings['shops']);
                if ($settings['isint'] == '88' && pdo_tableexists('zmcn_goods')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , sthumb as c FROM " . tablename('zmcn_goods') . " WHERE uniacid=:uniacid  and status = 1  and deleted = 0   order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '1' && pdo_tableexists('shopping_goods')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , thumb as c FROM " . tablename('shopping_goods') . " WHERE weid=:uniacid  and status = 1  and deleted = 0   order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif (($settings['isint'] == '2' || $settings['isint'] == '14') && pdo_tableexists('ewei_shop_goods')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , thumb as c FROM " . tablename('ewei_shop_goods') . " WHERE uniacid=:uniacid  and status = 1  and deleted = 0 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '3' && pdo_tableexists('quickshop_goods')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , thumb as c FROM " . tablename('quickshop_goods') . " WHERE weid=:uniacid and status = 1  and deleted = 0 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '4' && pdo_tableexists('surpershop_goods')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , thumb as c FROM " . tablename('surpershop_goods') . " WHERE weid=:uniacid and status = 1  and deleted = 0 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '5' && pdo_tableexists('weliam_indiana_goodslist')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , picarr as c FROM " . tablename('weliam_indiana_goodslist') . " WHERE uniacid=:uniacid and status = 2 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '6' && pdo_tableexists('superman_mall_item')) {
                    $pro = pdo_fetchall("SELECT id as a , title as b , cover as c FROM " . tablename('superman_mall_item') . " WHERE uniacid=:uniacid and status = 1 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '7' && pdo_tableexists('tg_goods')) {
                    $pro = pdo_fetchall("SELECT id as a , gname as b , gimg as c FROM " . tablename('tg_goods') . " WHERE uniacid=:uniacid and isshow = 1 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '8' && pdo_tableexists('tiny_wmall_goods')) {
                    $pro = pdo_fetchall("SELECT sid as a , title as b , thumb as c FROM " . tablename('tiny_wmall_goods') . " WHERE uniacid=:uniacid and status = 1 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '9' && pdo_tableexists('lonaking_ai_restaurant_product')) {
                    $pro = pdo_fetchall("SELECT id as a , name as b , pic as c FROM " . tablename('lonaking_ai_restaurant_product') . " WHERE uniacid=:uniacid order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } elseif ($settings['isint'] == '10' && pdo_tableexists('weisrc_dish_goods')) {
                    $pro = pdo_fetchall("SELECT storeid as a , title as b , pic as c FROM " . tablename('weisrc_dish_goods') . " WHERE weid=:uniacid and status = 1 order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                } else {
                    $pro = pdo_fetchall("SELECT id as a , title as b , thumb as c FROM " . tablename('site_article') . " WHERE uniacid=:uniacid order by rand() LIMIT " . $ii, array(
                        ':uniacid' => $_W['uniacid']
                    ));
                }
                foreach ($pro AS $par) {
                    $abcd[] = array(
                        'title' => "【推荐】" . $par['b'],
                        'picurl' => tomedia($par['c']),
                        'url' => zmcn_get_buylink($settings['isint'], $par['a'])
                    );
                }
            }
            if (!empty($_W['cache']['zmcn_good_pro'][0])) {
                $bacd = $_W['cache']['zmcn_good_pro'][0];
                if ((int) $settings['btggid'] > 0) {
                    $bacd['url'] .= "&mid=" . $settings['btggid'] . "&wxref=mp.weixin.qq.com#wechat_redirect";
                } else {
                    $bacd['url'] .= "&wxref=mp.weixin.qq.com#wechat_redirect";
                }
                $abcd[] = $bacd;
            }
        }
        mc_group_update();
        return $this->respNews($abcd);
    }
    private function replaceString($string)
    {
        global $_W, $fans, $member, $settings;
        $string = str_replace('[昵称]', $member['nickname'], $string);
        $string = str_replace('[总积分]', $_W['zmcn']['total'], $string);
        $string = str_replace('[签到总积分]', $_W['zmcn']['allnum'], $string);
        $string = str_replace('[签到积分]', $_W['zmcn']['number'], $string);
        $string = str_replace('[今天得分]', $_W['zmcn']['today'], $string);
        $string = str_replace('[当天签到量]', (int) $_W['zmcn']['todaycom']['a'], $string);
        $string = str_replace('[首次积分]', $settings['everyday'], $string);
        $string = str_replace('[续签积分]', $settings['continuity'], $string);
        $string = str_replace('[积分上限]', $settings['intup'], $string);
        $string = str_replace('[额外奖值]', $_W['zmcn']['jl'], $string);
        $aa     = $_W['zmcn']['today'] + $settings['continuity'];
        if ((int) $settings['intup'] > 0 && $aa > (int) $settings['intup']) {
            $aa = (int) $settings['intup'];
        }
        $string = str_replace('[下期积分]', $aa, $string);
        return $string;
    }
}
function zmcn_get_buylink($j, $f, $s = 0)
{
    global $_W;
    if (strlen($f) > 15) {
        $a = $f;
    } elseif ($j == 88) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'zmcn_goods',
            'id' => $f
        ), true);
    } elseif ($j == 1) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'ewei_shopping',
            'id' => $f
        ), true);
    } elseif ($j == 2) {
        $a = url('entry', array(
            'do' => 'shop',
            'm' => 'ewei_shop',
            'p' => 'detail',
            'id' => $f,
            'mid' => $s
        ), true);
    } elseif ($j == 14) {
        $a = url('entry', array(
            'do' => 'mobile',
            'm' => 'ewei_shopv2',
            'r' => 'goods.detail',
            'id' => $f,
            'mid' => $s
        ), true);
    } elseif ($j == 3) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'quickshop',
            'id' => $f
        ), true);
    } elseif ($j == 4) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'hawk_surpershop',
            'id' => $f,
            'u' => $s
        ), true);
    } elseif ($j == 5) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'weliam_indiana',
            'id' => $f
        ), true);
    } elseif ($j == 6) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'superman_mall',
            'itemid' => $f
        ), true);
    } elseif ($j == 7) {
        $a = url('entry', array(
            'do' => 'goodsdetails',
            'm' => 'feng_fightgroups',
            'id' => $f
        ), true);
    } elseif ($j == 8) {
        $a = url('entry', array(
            'do' => 'goods',
            'm' => 'we7_wmall',
            'sid' => $f
        ), true);
    } elseif ($j == 9) {
        $a = url('entry', array(
            'do' => 'detail',
            'm' => 'lonaking_ai',
            'id' => $f
        ), true);
    } elseif ($j == 10) {
        $a = url('entry', array(
            'do' => 'waplist',
            'm' => 'weisrc_dish',
            'storeid' => $f,
            'mode' => 2
        ), true);
    } else {
        $a = url('site/site/detail', array(
            'id' => $f,
            'uniacid' => $_W['uniacid']
        ));
    }
    return $a;
}
function weblogin_clearemoji($str)
{
    $str = json_encode($str);
    $str = preg_replace("#(\\\ud[0-9a-f]{3})#ie", "", $str);
    $str = preg_replace("#(\\\u2[0-9a-f]{3})#ie", "", $str);
    $str = preg_replace("#(\\\u0[0-9a-f]{3})#ie", "", $str);
    $str = json_decode($str);
    $str = trim(str_replace(array(
        ' ',
        "'",
        ',',
        '。',
        '•',
        '.',
        '+',
        ')',
        '(',
        '_',
        '、',
        '，',
        '"'
    ), '', $str));
    return $str;
}
