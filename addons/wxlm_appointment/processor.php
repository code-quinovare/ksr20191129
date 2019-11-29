<?php

//decode by QQ:10373458 https://www.010xr.com/
defined('IN_IA') or exit('Access Denied');
class Wxlm_appointmentModuleProcessor extends WeModuleProcessor
{
	public function respond()
	{
		global $_W;
		$content = $this->message['content'];
		$rid = $this->rule;
		$eventkey = $this->message['eventkey'];
		$openid = $this->message['from'];
		$eventkey = str_replace("qrscene_", "", $eventkey);
		$staff_id = str_replace("appointment", "", $eventkey);
		$url = $_W['siteroot'] . "app/" . str_replace('./', '', $this->createMobileUrl('StaffComment', array('op' => 'create', 'staffid' => $staff_id)));
		return $this->respText('<a href="' . $url . '">点击这里为当前服务点评完成</a>');
	}
}