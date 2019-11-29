<?php
defined('IN_IA') || exit('Access Denied');
abstract class TyAccount 
{
	static public function create($acidOrAccount = '', $type = 'wap') 
	{
		global $_W;
		if ($type != 'wxapp') 
		{
			mload()->classs('wxaccount');
			$acc = new WxAccount($acidOrAccount);
			return $acc;
		}
		if (empty($acidOrAccount)) 
		{
			$acidOrAccount = $_W['acid'];
		}
		if (is_array($acidOrAccount)) 
		{
			$account = $acidOrAccount;
		}
		else 
		{
			$wxapp = get_plugin_config('wxapp.basic');
			$account = array('key' => $wxapp['key'], 'secret' => $wxapp['secret']);
		}
		mload()->classs('wxapp');
		return new Wxapp($account);
	}
}
?>