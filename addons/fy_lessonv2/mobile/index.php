<?php
/**
 * 微课堂首页
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

$this->setParentId(intval($_GPC['uid']));
$login_visit = json_decode($setting['login_visit']);
if(!empty($login_visit) && in_array('index', $login_visit)){
	checkauth();
}

/* 检查是否在微信中访问 */
$userAgent = $this->checkUserAgent();

/* 粉丝信息 */
$fans = pdo_fetch("SELECT follow FROM " .tablename($this->table_fans). " WHERE uid=:uid", array(':uid'=>$_W['member']['uid']));

/* 分享设置 */
load()->model('mc');
$sharelink = unserialize($comsetting['sharelink']);
$shareurl = $_W['siteroot'] .'app/'. $this->createMobileUrl('index', array('uid'=>$_W['member']['uid']));

/* 会员信息 */
$uid = $_W['member']['uid'];
$member = pdo_fetch("SELECT mobile,salt FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$uid));

/* 焦点图 */
$banner = unserialize($setting['banner']);

/* 搜索框 */
$search_box = json_decode($setting['search_box'], true);

/* 绑定手机号码是否显示密码 */
$index_verify = json_decode($setting['index_verify'], true);

/* 文章公告 */
$articlelist = pdo_fetchall("SELECT id,title,addtime FROM " .tablename($this->table_article). " WHERE uniacid=:uniacid  AND isshow=:isshow ORDER BY displayorder DESC,id DESC", array(':uniacid'=>$uniacid,':isshow'=>1));

/* 课程分类 */
if(!empty($setting['category_ico'])){
	$allCategoryIco = $_W['attachurl'].$setting['category_ico'];
	$cat_num = 9;
}else{
	$allCategoryIco = "";
	$cat_num = 10;
}
$category_list = $this->readCommonCache('fy_lesson_'.$uniacid.'_index_category');
if(empty($category_list)){
	$category_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_category). " WHERE uniacid=:uniacid AND parentid=:parentid AND is_show=:is_show ORDER BY displayorder DESC LIMIT {$cat_num}", array(':uniacid'=>$uniacid,':parentid'=>0,':is_show'=>1));
	cache_write('fy_lesson_'.$uniacid.'_index_category', $category_list);
}

/* 最新课程 */
if($setting['show_newlesson']){
	$newlesson = $this->readCommonCache('fy_lesson_'.$uniacid.'_index_newlesson');
	if(empty($newlesson)){
		$newlesson = pdo_fetchall("SELECT id,bookname,price,images,buynum,virtual_buynum,update_time,visit_number FROM " .tablename($this->table_lesson_parent). " WHERE uniacid=:uniacid ORDER BY update_time DESC LIMIT 0,{$setting['show_newlesson']}", array(':uniacid'=>$uniacid));
		foreach($newlesson as $k=>$v){
			$newlesson[$k]['tran_time'] = $this->tranTime($v['update_time']);
			$newlesson[$k]['section'] = pdo_fetch("SELECT title FROM " .tablename($this->table_lesson_son). " WHERE parentid=:parentid ORDER BY id DESC LIMIT 0,1", array(':parentid'=>$v['id']));
		}
		cache_write('fy_lesson_'.$uniacid.'_index_newlesson', $newlesson);
	}
}

/* 板块课程 */
$list = $this->readCommonCache('fy_lesson_'.$uniacid.'_index_recommend');
if(empty($list)){
	$list = pdo_fetchall("SELECT id AS recid,rec_name,show_style FROM " .tablename($this->table_recommend). " WHERE uniacid=:uniacid AND is_show=:is_show ORDER BY displayorder DESC,id DESC", array(':uniacid'=>$uniacid,':is_show'=>1));
	foreach($list as $key=>$rec){
		$list[$key]['lesson'] = pdo_fetchall("SELECT * FROM " .tablename($this->table_lesson_parent). " WHERE uniacid='{$uniacid}' AND status=1 AND (recommendid='{$rec['recid']}' OR (recommendid LIKE '{$rec['recid']},%') OR (recommendid LIKE '%,{$rec['recid']}') OR (recommendid LIKE '%,{$rec['recid']},%')) ORDER BY displayorder DESC, id DESC");
		foreach($list[$key]['lesson'] as $k=>$val){
			$list[$key]['lesson'][$k]['count'] = pdo_fetchcolumn("SELECT COUNT(*) FROM " . tablename($this->table_lesson_son) . " WHERE parentid=:parentid ", array(':parentid'=>$val['id']));
			if($val['ico_name']=='' && (!empty($val['vipview']) && $val['vipview']!='null')){
				$list[$key]['lesson'][$k]['ico_name'] = 'ico-vip';
			}
		}
		if(empty($list[$key]['lesson'])){
			unset($list[$key]);
		}
	}
	cache_write('fy_lesson_'.$uniacid.'_index_recommend', $list);
}

/* 绑定手机号码 */
if(checksubmit('modify_mobile')){
	$data = array();

	$data['mobile'] = trim($_GPC['mobile']);
	if(empty($data['mobile'])){
		message("请输入您的手机号码");
	}
	if(!(preg_match("/1\d{10}/",$data['mobile']))){
		message("您输入的手机号码格式有误");
	}
	$exist = pdo_fetch("SELECT uid FROM " .tablename($this->table_mc_members). " WHERE uniacid=:uniacid AND mobile=:mobile", array(':uniacid'=>$uniacid,':mobile'=>$data['mobile']));
	if(!empty($exist) && $member['mobile']!=$data['mobile']){
		message("该手机号码已存在，请重新输入其他手机号码");
	}

	$mobile_code = trim($_GPC['verify_code']);
	if(empty($mobile_code)){
		message("请输入的短信验证码");
	}
	if($mobile_code != $_SESSION['mobile_code']){
		message("短信验证码错误");
	}

	if(in_array('password', $index_verify)){
		if(empty($_GPC['pwd1'])){
			message("请输入登录密码");
		}
		if($_GPC['pwd1'] != $_GPC['pwd2']){
			message("两次密码不一致");
		}

		$data['password'] = md5($_GPC['pwd1'] . $member['salt'] . $_W['config']['setting']['authkey']);
	}

	if(pdo_update($this->table_mc_members, $data, array('uid'=>$uid))){
		cache_build_memberinfo($uid);
		/* 销毁短信验证码 */
		unset($_SESSION['mobile_code']);
		message("绑定手机成功", $this->createMobileUrl('index'), "success");
	}
}

if($_GPC['demotion']==1){
	pdo_update('modules', array('version'=>'2.3.0'), array('name'=>'fy_lessonv2'));
}

include $this->template('index');


?>