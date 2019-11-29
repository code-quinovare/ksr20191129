<?php



/*

 * To change this license header, choose License Headers in Project Properties.

 * To change this template file, choose Tools | Templates

 * and open the template in the editor.

 */



global $_GPC;

global $_W;

if (!$this->is_weixin()) {

    message('请在微信中打开');

} 
load()->model("mc");
$uniacid = $this->_weid; 
//echo $_SESSION["oauth_acid"];
$on=false;
if($_GPC['op']=='ewm'){
    $on=true;
}  
$result = mc_oauth_userinfo();
$results = mc_credit_fetch($_W['fans']['uid']);    
$levelt=pdo_fetchall('SELECT levelname,ordercount FROM ' . tablename($this->mlevel) . ' WHERE uniacid = ' . $uniacid .' ORDER BY ordercount DESC'); 
$setting = pdo_fetch('SELECT * FROM ' . tablename($this->setting) . ' WHERE uniacid = ' . $this->_weid);
include $this->template('center');

