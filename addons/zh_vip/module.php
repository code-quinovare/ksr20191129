<?php
/**
 * 志汇-门店会员卡小程序模块定义
 *
 * @author 武汉志汇科技
 * @url 
 */
defined('IN_IA') or exit('Access Denied');

class Zh_vipModule extends WeModule {

	public function welcomeDisplay()
    {   
        $url = $this->createWebUrl('index');
        Header("Location: " . $url);
    }
}