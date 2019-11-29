<?php
/**
 * 完善手机号码/姓名
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

checkauth();
$uid = $_W['member']['uid'];

$member = pdo_fetch("SELECT mobile,realname,msn,occupation,company,graduateschool,grade FROM " .tablename($this->table_mc_members). " WHERE uid=:uid", array(':uid'=>$uid));

if($op=='display'){
	$title = '完善信息';

	$user_info = json_decode($setting['user_info'], true);
	$sms = json_decode($setting['dayu_sms'], true);

	if(checksubmit('submit')){
		$data = array();

		if(in_array('realname',$user_info)){
			$data['realname'] = trim($_GPC['realname']);
			if(empty($data['realname'])){
				message("请输入您的姓名");
			}
		}
		if(in_array('mobile',$user_info)){
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
		}

		if(in_array('mobile',$user_info) && !$member['mobile'] && $sms['verify_code']){
			$mobile_code = trim($_GPC['verify_code']);
			if(empty($mobile_code)){
				message("请输入的短信验证码");
			}
			if($mobile_code != $_SESSION['mobile_code']){
				message("短信验证码错误");
			}
		}

		if(in_array('msn',$user_info)){
			$data['msn'] = trim($_GPC['msn']);
			if(empty($data['msn'])){
				message("请输入您的微信号");
			}
		}
		if(in_array('occupation',$user_info)){
			$data['occupation'] = trim($_GPC['occupation']);
			if(empty($data['occupation'])){
				message("请输入您的职业名称");
			}
		}
		if(in_array('company',$user_info)){
			$data['company'] = trim($_GPC['company']);
			if(empty($data['company'])){
				message("请输入您的公司名称");
			}
		}
		if(in_array('graduateschool',$user_info)){
			$data['graduateschool'] = trim($_GPC['graduateschool']);
			if(empty($data['graduateschool'])){
				message("请输入您的学校名称");
			}
		}
		if(in_array('grade',$user_info)){
			$data['grade'] = trim($_GPC['grade']);
			if(empty($data['grade'])){
				message("请输入您的班级名称");
			}
		}
		if(in_array('address',$user_info)){
			$data['address'] = trim($_GPC['address']);
			if(empty($data['address'])){
				message("请输入您的地址");
			}
		}

		$result = pdo_update($this->table_mc_members, $data, array('uniacid'=>$uniacid,'uid'=>$uid));
		if($result){
			/* 销毁短信验证码 */
			unset($_SESSION['mobile_code']);

			if($_GPC['type']=='vip'){
				message("完善信息成功", $this->createMobileUrl('vip'), "success");
			}else{
				message("完善信息成功", $this->createMobileUrl('confirm', array('id'=>$_GPC['lessonid'],'spec_id'=>$_GPC['spec_id'])), "success");
			}
		}else{
			if($_GPC['type']=='vip'){
				message("网络错误，请稍后重试", $this->createMobileUrl('vip'), "error");
			}else{
				message("网络错误，请稍后重试", $this->createMobileUrl('lesson', array('id'=>$_GPC['lessonid'])), "error");
			}
		}
	}

}elseif($op=='modifyMobile'){
	$title = $member['mobile'] ? '修改手机号码':'绑定手机号码';

	$sms = json_decode($setting['dayu_sms'], true);
	if(empty($sms['verify_code'])){
		message("短信验证码未配置，请联系管理员");
	}

	if(checksubmit('submit')){
		$data = array();
		$data['mobile'] = trim($_GPC['mobile']);
		if(empty($data['mobile'])){
			message("请输入您的手机号码");
		}
		if(!(preg_match("/1\d{10}/",$data['mobile']))){
			message("您输入的手机号码格式有误");
		}
		$exist = pdo_fetch("SELECT uid FROM " .tablename($this->table_mc_members). " WHERE uniacid=:uniacid AND mobile=:mobile", array(':uniacid'=>$uniacid,':mobile'=>$data['mobile']));
		if(!empty($exist)){
			message("该手机号码已存在，请重新输入其他手机号码");
		}

		$mobile_code = trim($_GPC['verify_code']);
		if(empty($mobile_code)){
			message("请输入的短信验证码");
		}
		if($mobile_code != $_SESSION['mobile_code']){
			message("短信验证码错误");
		}

		$result = pdo_update($this->table_mc_members, $data, array('uniacid'=>$uniacid,'uid'=>$uid));
		if($result){
			cache_build_memberinfo($uid);
			/* 销毁短信验证码 */
			unset($_SESSION['mobile_code']);

			message($member['mobile'] ? "修改成功" : '绑定成功', $this->createMobileUrl('self'), "success");
		}else{
			message($member['mobile'] ? "修改失败" : '绑定失败', "", "error");
		}
	}
}

include $this->template('writemsg');

?>