<?php
/**
 *涵创网络友情提供
 * http://www.hcexe.com
 */
defined('IN_IA') or exit('Access Denied');
class zmcn_signModule extends WeModule
{
    public function fieldsFormDisplay($rid = 0)
    {
    }
    public function fieldsFormValidate($rid = 0)
    {
        return '';
    }
    public function fieldsFormSubmit($rid)
    {
    }
    public function ruleDeleted($rid)
    {
    }
    public function settingsDisplay($settings)
    {
        global $_W, $_GPC;
        load()->func('communication');
        load()->func('tpl');
        $wna     = array(
            '日',
            '一',
            '二',
            '三',
            '四',
            '五',
            '六'
        );
        $shoplis = array(
            'zmcn_goods' => '88',
            'wdl_shopping' => '1',
            'ewei_shopv2' => '14',
            'ewei_shop' => '2',
            'quickshop' => '3',
            'hawk_surpershop' => '4',
            'weliam_indiana' => '5',
            'superman_mall' => '6',
            'feng_fightgroups' => '7',
            'we7_wmall' => '8',
            'lonaking_ai' => '9',
            'weisrc_dish' => '10'
        );
        if (checksubmit()) {
            $data               = array(
                'everyday' => intval($_GPC['everyday']),
                'continuity' => intval($_GPC['continuity']),
                'intup' => intval($_GPC['intup']),
                'ispaihang' => intval($_GPC['ispaihang']),
                'isint' => intval($_GPC['isint']),
                'shops' => intval($_GPC['shops']),
                'time' => $_GPC['time'],
                'jl' => $_GPC['jl'],
                'tx' => $_GPC['tx'],
                'paihangs' => intval($_GPC['paihangs']),
                'paihangt' => intval($_GPC['paihangt']),
                'jftype' => max(1, intval($_GPC['jftype'])),
                'success_msg' => trim($_GPC['success_msg']),
                'continuity_msg' => trim($_GPC['continuity_msg']),
                'px' => intval($_GPC['px']),
                'welcome' => trim($_GPC['welcome']),
                'linklogo' => trim($_GPC['linklogo']),
                'linktitle' => trim($_GPC['linktitle']),
                'url' => trim($_GPC['url']),
                'url1' => $_GPC['url1'],
                'wailink' => $_GPC['wailink']
            );
            $data['isgg']       = intval($_GPC['isgg']);
            $data['btggid']     = intval($_GPC['btggid']);
            $data['btggopenid'] = $_GPC['btggopenid'];
            $data['btggts']     = max(1, intval($_GPC['btggts']));
            if ($this->saveSettings($data)) {
                message('保存成功', 'refresh');
            }
        }
        $txtr = "<div class='main'><div class='panel panel-default'><div class='panel-heading'>规则说明</div><div class='panel-body'>　　用户第一天签到，就赠送“首次签到积分”，然后连续每天签到都将递增“续签递增积分”，如果中断，将重新回到“首次签到积分”，然后再重新递增<br>　　例如：首次签到积分为10；续签递增积分为2<br>　　那么用户第一天签到赠送10个积分，第二天12个积分，第三天14个积分 （10+12+14+16+18+20……）<br>　　如果有设上限，例如上限是20，就是（10+12+14+16+18+20+20+20+20+20+20+20……）<br>　　但是如果有一天没签到（中断了）那么下次签到又从10分送起<br>　　好处：增加用户对公众号的粘性</div></div></div>";
        $set  = pdo_fetch("SELECT * FROM " . tablename('modules') . " WHERE `name` = :name", array(
            ':name' => 'zmcn_fw'
        ));
        $result = cache_write('zmcn_good_pro', $a['pro']);

        $txtr .= "<input type='submit' name='submit' value='提交' class='btn btn-primary'/>";
        if (empty($settings['jl']['w'])) {
            $settings['jl']['w'] = range(12, 14);
        }
        $shopnane = pdo_fetchall("SELECT name as a , title as b FROM " . tablename('modules') . " WHERE name IN ('" . implode("','", array_keys($shoplis)) . "')");
        include $this->template('setting');
    }
}
