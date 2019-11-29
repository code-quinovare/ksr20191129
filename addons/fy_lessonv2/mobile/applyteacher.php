<?php

/**
 * 讲师中心
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */
checkauth();

load()->model('app');
load()->func('tpl');

if ($setting['teacher_income'] == 0) {
    message("系统没有开启讲师入驻！", "", "warning");
}

$title = "申请讲师";
$uid = $_W['member']['uid'];

/* 会员信息 */
$lessonmember = pdo_fetch("SELECT a.*,b.nickname AS mnickname FROM " . tablename($this->table_member) . " a LEFT JOIN " . tablename($this->table_mc_members) . " b ON a.uid=b.uid WHERE a.uid=:uid", array(':uid'=>$uid));

/* 讲师信息 */
$teacherlog = pdo_fetch("SELECT * FROM " . tablename($this->table_teacher) . " WHERE uid=:uid", array(':uid'=>$uid));

if ($op == 'display') {
    if ($teacherlog['status'] == 1 || $teacherlog['status'] == 2) {
        header("Location:" . $this->createMobileUrl('teachercenter'));
    }
} elseif ($op == 'postteacher') {
    $data = array();
    $data['teacher'] = trim($_GPC['teacher']);
	$data['weixin_qrcode'] = trim($_GPC['weixin_qrcode']);
	$data['teacherphoto'] = trim($_GPC['teacherphoto']);
    $data['qq'] = trim($_GPC['qq']);
    $data['qqgroup'] = trim($_GPC['qqgroup']);
    $data['teacherdes'] = trim($_GPC['teacherdes']);
    $data['status'] = 2;

    if (empty($data['teacher'])) {
        message("请填写讲师名称");
    }
    if (empty($data['teacherdes'])) {
        message("请填写讲师介绍");
    }
	$tplmessage = pdo_fetch("SELECT apply_teacher FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$uniacid));

    $manage = explode(",", $setting['manageopenid']);
	if (empty($teacherlog)) {
        $data['uid'] = $uid;
        $data['uniacid'] = $uniacid;
        $data['addtime'] = time();

        pdo_insert($this->table_teacher, $data);
		
        foreach ($manage as $manageopenid) {
            $sendneworder = array(
                'touser' => $manageopenid,
                'template_id' => $tplmessage['apply_teacher'],
                'url' => "",
                'topcolor' => "#7B68EE",
                'data' => array(
                    'first' => array(
                        'value' => "您有一条新的讲师入驻申请，请及时审核",
                        'color' => "#428BCA",
                    ),
                    'keyword1' => array(
                        'value' => trim($_GPC['teacher']),
                        'color' => "#428BCA",
                    ),
                    'keyword2' => array(
                        'value' => "讲师入驻申请",
                        'color' => "#428BCA",
                    ),
                    'remark' => array(
                        'value' => "详情请登录网站后台查看！",
                        'color' => "#222222",
                    ),
                )
            );
            $this->send_template_message(urldecode(json_encode($sendneworder)), $_W['acid']);
        }
        message("提交申请成功，等待管理员审核", $this->createMobileUrl("index"), "success");
	} else {
        pdo_update($this->table_teacher, $data, array('uid' => $uid));
        foreach ($manage as $manageopenid) {
            $sendneworder = array(
                'touser' => $manageopenid,
                'template_id' => $tplmessage['apply_teacher'],
                'url' => "",
                'topcolor' => "#7B68EE",
                'data' => array(
                    'first' => array(
                        'value' => "您有一条新的讲师入驻申请，请及时审核",
                        'color' => "#428BCA",
                    ),
                    'keyword1' => array(
                        'value' => trim($_GPC['teacher']),
                        'color' => "#428BCA",
                    ),
                    'keyword2' => array(
                        'value' => "微课堂讲师入驻申请",
                        'color' => "#428BCA",
                    ),
                    'remark' => array(
                        'value' => "详情请登录网站后台查看！",
                        'color' => "#222222",
                    ),
                )
            );
            $this->send_template_message(urldecode(json_encode($sendneworder)), $_W['acid']);
        }
        message("重新提交申请成功", $this->createMobileUrl("index"), "success");
    }
}

include $this->template('applyteacher');
?>