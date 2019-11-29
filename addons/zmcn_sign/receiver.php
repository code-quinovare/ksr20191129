<?php
/**
*涵创网络 源 码 网 www.hcexe.com
*/
defined('IN_IA') or exit('Access Denied');
class zmcn_signModuleReceiver extends WeModuleReceiver
{
    public function receive()
    {
        $type = $this->message['type'];
    }
}