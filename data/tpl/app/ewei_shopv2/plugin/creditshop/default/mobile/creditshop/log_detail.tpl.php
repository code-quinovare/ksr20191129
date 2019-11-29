<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php  $this->followBar()?>
<style type="text/css">
    .fui-navbar ~ .fui-content, .fui-content.navbar{padding-bottom:0;}
    <?php  if($pay['credit'] == 0) { ?>
    .fui-actionsheet a.balance{display: none;}
    <?php  } ?>
    <?php  if($pay['weixin'] == 0 && $pay['weixin_jie'] == 0) { ?>
    .fui-actionsheet a.wechat{display: none;}
    <?php  } ?>
    <?php  if($pay['alipay'] == 0) { ?>
    .fui-actionsheet a.alipay{display: none;}
    <?php  } ?>
    .fui-list{display: none;} /*关注条隐藏*/
</style>
<div class='fui-page order-detail-page'>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back" href="<?php  echo mobileUrl('creditshop/log')?>"></a>
        </div>
        <div class="title">订单详情</div>
        <div class="fui-header-right" onclick="location.href='<?php  echo mobileUrl('creditshop/index')?>'">
            <span class="icon icon-home" style="font-size:1.1rem;"></span>
        </div>
    </div>
    <div class='fui-content navbar'>
        <div class='fui-list-group result-list'>
            <div class='fui-list order-status'>
                <div class='fui-list-inner'>
                    <div class='title'>
                        <?php  if($goods['type']==1) { ?>
                            <?php  if($log['status'] ==1) { ?>未中奖<?php  } ?>
                        <?php  } ?>
                        <?php  if($goods['goodstype']==0) { ?>
                            <?php  if($goods['isverify']==1) { ?>
                                <?php  if($log['status'] ==2) { ?>待兑换<?php  } ?>
                                <?php  if($set['isreply'] == 1) { ?>
                                    <?php  if($log['status'] ==3 && $log['iscomment'] == 0 ) { ?>等待评价<?php  } ?>
                                    <?php  if($log['status'] ==3 && $log['iscomment'] == 1 ) { ?>追加评价<?php  } ?>
                                    <?php  if($log['status'] ==3 && $log['iscomment'] == 2 ) { ?>已完成<?php  } ?>
                                <?php  } else { ?>
                                    <?php  if($log['status'] ==3) { ?>已完成<?php  } ?>
                                <?php  } ?>
                            <?php  } else { ?>
                                <?php  if($log['status'] ==2 && $log['addressid'] == 0 ) { ?><?php  if($goods['type']==0) { ?>已兑换<?php  } else { ?>已中奖<?php  } ?>，请选择收货地址<?php  } ?>
                                <?php  if($log['status'] ==2 && $log['addressid'] > 0 && $log['time_send'] == 0) { ?>等待卖家发货<?php  } ?>
                                <?php  if($log['status'] ==3 && $log['time_send'] > 0 && $log['time_finish'] ==0 ) { ?>卖家已发货，等待签收<?php  } ?>
                                <?php  if($set['isreply'] == 1) { ?>
                                    <?php  if($log['status'] ==3 && $log['time_finish'] > 0 && $log['iscomment'] == 0 ) { ?>待评价<?php  } ?>
                                    <?php  if($log['status'] ==3 && $log['time_finish'] > 0 && $log['iscomment'] == 1 ) { ?>追加评价<?php  } ?>
                                    <?php  if($log['status'] ==3 && $log['time_finish'] > 0 && $log['iscomment'] == 2 ) { ?>已完成<?php  } ?>
                                <?php  } else { ?>
                                    <?php  if($log['status'] ==3 && $log['time_finish'] > 0) { ?>已完成<?php  } ?>
                                <?php  } ?>
                            <?php  } ?>
                        <?php  } else { ?>
                            <?php  if($log['status'] ==2 && $goods['goodstype']==3) { ?><?php  if($goods['type']==0) { ?>已兑换<?php  } else { ?>已中奖<?php  } ?>，等待领取<?php  } ?>
                            <?php  if($set['isreply'] == 1) { ?>
                                <?php  if($log['status'] ==3 && $log['iscomment'] == 0 ) { ?>等待评价<?php  } ?>
                                <?php  if($log['status'] ==3 && $log['iscomment'] == 1 ) { ?>追加评价<?php  } ?>
                                <?php  if($log['status'] ==3 && $log['iscomment'] == 2 ) { ?>
                                    <?php  if($goods['goodstype']==1) { ?>优惠券<?php  } else if($goods['goodstype']==2) { ?>余额<?php  } else if($goods['goodstype']==3) { ?>红包<?php  } ?>已发放
                                <?php  } ?>
                            <?php  } else { ?>
                                <?php  if($log['status'] ==3) { ?><?php  if($goods['goodstype']==1) { ?>优惠券<?php  } else if($goods['goodstype']==2) { ?>余额<?php  } else if($goods['goodstype']==3) { ?>红包<?php  } ?>已发放<?php  } ?>
                            <?php  } ?>
                        <?php  } ?>
                    </div>
                    <div class='text'>
                        商品总额: <?php  echo $goods['credit'];?><?php  echo $_W['shopset']['trade']['credittext'];?>
                        <?php  if($goods['money'] > 0) { ?> + &yen; <?php  echo $goods['money'];?><?php  } ?>
                        <?php  if($goods['goodstype']==0 && $goods['isverify']==0) { ?>
                            <?php  if($goods['dispatch'] > 0) { ?>运费：&yen; <?php  echo $goods['dispatch'];?><?php  } else { ?>免运费<?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
                <div class='fui-list-media'>
                    <?php  if($goods['goodstype']==0) { ?>
                        <?php  if($goods['isverify']==1) { ?>
                            <?php  if($log['status'] ==2) { ?><i class='icon icon-money'></i><?php  } ?>
                        <?php  } else { ?>
                            <?php  if($log['status'] ==2 && $log['time_send'] == 0) { ?><i class='icon icon-money'></i><?php  } ?>
                            <?php  if($log['status'] ==2 && $log['time_send'] > 0 ) { ?><i class='icon icon-deliver'></i><?php  } ?>
                        <?php  } ?>
                        <?php  if($log['status'] ==3) { ?><i class='icon icon-check'></i><?php  } ?>
                    <?php  } else if($goods['goodstype']==1) { ?>
                        <?php  if($log['status'] ==3) { ?><i class='icon icon-check'></i><?php  } ?>
                    <?php  } else if($goods['goodstype']==2) { ?>
                        <?php  if($log['status'] ==3) { ?><i class='icon icon-check'></i><?php  } ?>
                    <?php  } else if($goods['goodstype']==3) { ?>
                        <?php  if($log['status'] ==2) { ?><i class='icon icon-check'></i><?php  } ?>
                    <?php  } ?>
                    <?php  if($log['status'] ==1) { ?>
                    <i class='icon icon-roundclose'></i>
                    <?php  } ?>

                </div>
            </div>
        </div>
        <?php  if($goods['goodstype']==0) { ?>
        <?php  if(!empty($address)) { ?>
        <div class='fui-list-group' style='margin-top:5px;'>
            <?php  if($log['status'] == 3 && !empty($log['expresssn'])) { ?>
            <a href="<?php  echo mobileUrl('creditshop/log/express',array('id'=>$log['id']))?>">
                <div class='fui-list'>
                    <div class='fui-list-media'><i class='icon icon-deliver'></i></div>
                    <div class='fui-list-inner'>
                        <?php  if(empty($express)) { ?>
                        <div class='text'><span>快递公司:<?php  echo $log['expresscom'];?></span></div>
                        <div class='text'><span>快递单号:<?php  echo $log['expresssn'];?></span></div>
                        <?php  } else { ?>
                        <div class='text'><span <?php  if($express && strexists($express['step'],'已签收')) { ?>class='text-danger2'<?php  } ?>><?php  echo $express['step'];?></span></div>
                        <div class='text'><span <?php  if($express && strexists($express['step'],'已签收')) { ?>class='text-danger2'<?php  } ?>><?php  echo $express['time'];?></span></div>
                        <?php  } ?>
                    </div>
                    <div class='fui-list-angle'><span class='angle'></span></div>
                </div>
            </a>
            <?php  } ?>

            <div class='fui-list'>
                <div class='fui-list-media'><i class='icon icon-location'></i></div>
                <div class='fui-list-inner'>
                    <div class='title'><?php  echo $address['realname'];?> <?php  echo $address['mobile'];?></div>
                    <div class='text'><?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?> <?php  echo $address['address'];?></div>
                </div>
            </div>
        </div>
        <?php  } else { ?>
        <?php  } ?>
        <?php  } ?>
        <?php  if($goods['isverify']==0 && $log['addressid']==0 && $goods['goodstype']==0) { ?>
        <div class="fui-cell-group">
            <div class="fui-cell ">
                <div class="fui-cell-label ">收货地址</div>
                <a class="fui-cell-info" href="<?php  echo mobileUrl('member/address/selector')?>">
                    <input type="text" class="fui-input" placeholder="点击选择收货地址" readonly id="address_select" value="<?php  echo $address['province'];?><?php  echo $address['city'];?><?php  echo $address['area'];?><?php  echo $address['address'];?>" />
                </a>
            </div>
        </div>
        <?php  } ?>
        <?php  if(!empty($carrier)) { ?>
        <div class='fui-list-group' style='margin-top:5px;'>
            <div class='fui-list' style="display: none;">
                <div class='fui-list-media'><i class='icon icon-person2'></i></div>
                <div class='fui-list-inner'>
                    <div class='title'><?php  echo $carrier['carrier_realname'];?> <?php  echo $carrier['carrier_mobile'];?></div>
                </div>
            </div>
            <?php  if(!empty($store)) { ?>
            <div  class="fui-list" >
                <div class="fui-list-media">
                    <i class='icon icon-shop'></i>
                </div>
                <div class="fui-list-inner store-inner">
                    <div class="title"> <span class='storename'><?php  echo $store['storename'];?></span></div>
                    <div class="text">
                        <span class='realname'><?php  echo $store['realname'];?></span> <span class='mobile'><?php  echo $store['mobile'];?></span>
                    </div>
                    <div class="text">
                        <span class='address'><?php  echo $store['address'];?></span>
                    </div>
                </div>
                <div class="fui-list-angle ">
                    <?php  if(!empty($store['tel'])) { ?><a href="tel:<?php  echo $store['tel'];?>" class='external '><i class=' icon icon-phone' style='color:green'></i></a><?php  } ?>
                    <a href="<?php  echo mobileUrl('store/map',array('id'=>$store['id']))?>" class='external' ><i class='icon icon-location' style='color:#f90'></i></a>
                </div>
            </div>

            <?php  } ?>
        </div>
        <?php  } ?>

        <div class="fui-list-group goods-list-group">
            <div class="fui-list-group-title"><i class="icon icon-shop"></i> <?php  echo $_W['shopset']['shop']['name'];?></div>
            <a href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$goods['id']))?>" class="external">
                <div class="fui-list goods-list">
                    <div class="fui-list-media">
                        <img src="<?php  echo tomedia($goods['thumb'])?>" alt="<?php  echo $goods['title'];?>" class="round" onerror="this.src='../addons/ewei_shopv2/static/images/nopic100.jpg'">
                    </div>
                    <div class="fui-list-inner">
                        <div class="text goodstitle"><?php  echo $goods['title'];?></div>
                        <?php  if(!empty($log['optionid'])) { ?><div class='subtitle' style="font-size:0.6rem;color:#999;">规格：<?php  echo $goods['optiontitle'];?></div><?php  } ?>
                    </div>
                    <div class='fui-list-angle'>
                        <span class='marketprice'>
                            <?php  echo $goods['credit'];?><?php  echo $_W['shopset']['trade']['credittext'];?><?php  if($goods['money']>0) { ?><br />&yen;<?php  echo $goods['money'];?><?php  } ?>
				            <br/>   x 1
                        </span>
                    </div>
                </div>
            </a>
        </div>


        <?php  if(!empty($order['virtual']) && !empty($order['virtual_str'])) { ?>
        <div class='fui-according-group'>
            <div class='fui-according expanded'>
                <div class='fui-according-header'>
                    <i class='icon icon-productfeatures'></i>
                    <span class="text">发货信息</span>
                    <span class="remark"></span>
                </div>
                <div class="fui-according-content">
                    <div class='content-block'>
                        <?php  echo $order['virtual_str'];?>
                    </div>
                </div>

            </div></div>
        <?php  } ?>

        <?php  if(!empty($order['isvirtualsend']) && !empty($order['virtualsend_info'])) { ?>
        <div class='fui-according-group'>
            <div class='fui-according expanded'>
                <div class='fui-according-header'>
                    <i class='icon icon-productfeatures'></i>
                    <span class="text">发货信息</span>
                    <span class="remark"></span>
                </div>
                <div class="fui-according-content">
                    <div class='content-block'>
                        <?php  echo $order['virtualsend_info'];?>
                    </div>
                </div>

            </div></div>
        <?php  } ?>

        <?php  if($goods['isverify']==1 && $log['status'] > 1) { ?>

        <div class='fui-according-group expanded verify-container' data-verifytype="<?php  echo $goods['verifytype'];?>" data-orderid="<?php  echo $log['id'];?>">
            <div class='fui-according'>
                <div class='fui-according-header'>
                    <i class='icon icon-list'></i>
                    <span class="text">兑奖码</span>
                    <span class="remark"><div class="badge">1</div></span>
                </div>
                <div class="fui-according-content verifycode-container">

                    <div class='fui-cell-group'>
                        <div class='fui-cell verify-cell' data-verifycode="<?php  echo $log['eno'];?>">
                            <div class='fui-cell-label' style='width:auto'>
                                <?php  echo $log['eno'];?>
                            </div>
                            <div class='fui-cell-info'></div>
                            <div class='fui-cell-remark noremark'>
                                <?php  if($verify['isverify']) { ?>
                                <div class='fui-label fui-label-danger' >已使用</div>
                                <?php  } else { ?>
                                    <?php  if($goods['verifytype']==1) { ?>
                                        <?php  if($verifynum == 0) { ?>
                                            <div class='fui-label fui-label-danger' >已使用</div>
                                        <?php  } else { ?>
                                            <div class='fui-label fui-label-default' >剩余<?php  echo $verifynum?> 次</div>
                                        <?php  } ?>
                                    <?php  } else { ?>
                                        <div class='fui-label fui-label-default' >未使用</div>
                                    <?php  } ?>
                                <?php  } ?>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <?php  } ?>

        <?php  if(!empty($stores) && $log['status'] > 1) { ?>
        <script language='javascript' src='https://api.map.baidu.com/api?v=2.0&ak=ZQiFErjQB7inrGpx27M1GR5w3TxZ64k7&s=1'></script>
        <div class='fui-according-group'>
            <div class='fui-according'>
                <div class='fui-according-header'>
                    <i class='icon icon-shop'></i>
                    <span class="text">适用门店</span>
                    <span class="remark"><div class="badge"><?php  echo count($stores)?></div></span>
                </div>
                <div class="fui-according-content store-container">
                    <?php  if(is_array($stores)) { foreach($stores as $item) { ?>
                    <div  class="fui-list store-item"

                          data-lng="<?php  echo floatval($item['lng'])?>"
                          data-lat="<?php  echo floatval($item['lat'])?>">
                        <div class="fui-list-media">
                            <i class='icon icon-shop'></i>
                        </div>
                        <div class="fui-list-inner store-inner">
                            <div class="title"> <span class='storename'><?php  echo $item['storename'];?></span></div>
                            <div class="text">
                                <span class='realname'><?php  echo $item['realname'];?></span> <span class='mobile'><?php  echo $item['mobile'];?></span>
                            </div>
                            <div class="text">
                                <span class='address'><?php  echo $item['address'];?></span>
                            </div>
                            <div class="text location" style="color:green;display:none">正在计算距离...</div>
                        </div>
                        <div class="fui-list-angle ">
                            <?php  if(!empty($item['tel'])) { ?><a href="tel:<?php  echo $item['tel'];?>" class='external '><i class=' icon icon-phone' style='color:green'></i></a><?php  } ?>
                            <a href="<?php  echo mobileUrl('store/map',array('id'=>$item['id']))?>" class='external' ><i class='icon icon-location' style='color:#f90'></i></a>
                        </div>
                    </div>
                    <?php  } } ?>
                </div>

                <div id="nearStore" style="display:none">

                    <div class='fui-list store-item'  id='nearStoreHtml'></div>
                </div>
            </div></div>
        <?php  } ?>




        <div class='fui-cell-group price-cell-group'>
            <div class="fui-cell">
                <div class="fui-cell-label">商品小计</div>
                <div class="fui-cell-info"></div>
                <div class="fui-cell-remark noremark"><?php  echo $goods['credit'];?><?php  echo $_W['shopset']['trade']['credittext'];?> + &yen;<?php  echo $goods['money'];?></div>
            </div>
            <?php  if($goods['goodstype']==0 && $goods['isverify']==0) { ?>
            <div class="fui-cell">
                <div class="fui-cell-label">运费</div>
                <div class="fui-cell-info"></div>
                <div class="fui-cell-remark noremark"><?php  if($goods['dispatch'] > 0) { ?>¥ <?php  echo $goods['dispatch'];?><?php  } else { ?>免运费<?php  } ?></div>
            </div>
            <?php  } ?>
            <div class="fui-cell">
                <div class="fui-cell-label" style='width:auto;'>
                    实付费<?php  if($goods['isverify']==0) { ?>(含运费)<?php  } ?>
                </div>
                <div class="fui-cell-info"></div>
                <div class="fui-cell-remark noremark">
                    <span class='text-danger2'>
                        <?php  echo $goods['credit'];?><?php  echo $_W['shopset']['trade']['credittext'];?><?php  if(($goods['money'] + $goods['dispatch']) >0) { ?> + &yen; <?php  echo number_format($goods['money'] + $goods['dispatch'],2)?><?php  } ?>
                    </span>
                </div>
            </div>
        </div>

        <div class="fui-cell-group info-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label">订单编号:</div>
                <div class="fui-cell-info"><?php  echo $log['logno'];?></div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">创建时间:</div>
                <div class="fui-cell-info"><?php  echo date('Y-m-d H:i:s', $log['createtime'])?></div>
            </div>
            <?php  if($log['status']>=1) { ?>
            <div class="fui-cell">
                <div class="fui-cell-label">支付时间: </div>
                <div class="fui-cell-info"><?php  echo date('Y-m-d H:i:s', $log['createtime'])?></div>
            </div>
            <?php  } ?>
            <?php  if($log['status']>=2 && $log['time_send'] > 0) { ?>
            <div class="fui-cell">
                <div class="fui-cell-label">发货时间: </div>
                <div class="fui-cell-info"><?php  echo date('Y-m-d H:i:s', $log['time_send'])?></div>
            </div>
            <?php  } ?>
            <?php  if($log['status']==3 && $log['time_finish'] > 0) { ?>
            <div class="fui-cell">
                <div class="fui-cell-label">完成时间: </div>
                <div class="fui-cell-info"><?php  echo date('Y-m-d H:i:s', $log['time_finish'])?></div>
            </div>
            <?php  } ?>
        </div>


    </div>

    <div class='fui-footer'>
        <?php  if($goods['isverify']==0 && $goods['goodstype']==0 && $log['addressid']==0 ) { ?>
            <?php  if($goods['dispatch'] >0) { ?>
                <div class="btn btn-warning block btn-1">支付运费</div>
            <?php  } else { ?>
                <div class="btn btn-warning block btn-1">确认兑换</div>
            <?php  } ?>
        <?php  } ?>
        <?php  if($goods['goodstype'] == 0 &&  $goods['isverify'] > 0 && ($log['status'] == 2 || $log['status'] == 3 && $verifynum > 0)) { ?>
        <a class="btn btn-default" href="<?php  echo mobileUrl('creditshop/verify',array('logid'=>$log['id'],'verifycode'=>$log['eno']))?>">
            <i class="icon icon-qrcode" style="vertical-align: middle;"></i>
            <span>兑换二维码</span>
        </a>
        <?php  } ?>
        <?php  if($set['isreply']==1  && $log['time_finish'] > 0 ) { ?>
            <?php  if($goods['goodstype']==0 || $goods['goodstype']==1) { ?>
                <?php  if($log['status'] == 3 && $log['iscomment'] == 1) { ?>
                    <a class="btn btn-default" href="<?php  echo mobileUrl('creditshop/comment',array('goodsid'=>$log['goodsid'],'logid'=>$log['id']))?>">追加评价</a>
                <?php  } ?>
                <?php  if($log['status'] == 3 && $log['iscomment'] == 0) { ?>
                    <a class="btn btn-default" href="<?php  echo mobileUrl('creditshop/comment',array('goodsid'=>$log['goodsid'],'logid'=>$log['id']))?>">评价</a>
                <?php  } ?>
            <?php  } else if($goods['goodstype']==2 || $goods['goodstype']==3) { ?>
                <?php  if($log['status'] ==3 && $log['iscomment'] == 1) { ?>
                    <a class="btn btn-default" href="<?php  echo mobileUrl('creditshop/comment',array('goodsid'=>$log['goodsid'],'logid'=>$log['id']))?>">追加评价</a>
                <?php  } ?>
                <?php  if($log['status'] ==3 && $log['iscomment'] == 0) { ?>
                    <a class="btn btn-default" href="<?php  echo mobileUrl('creditshop/comment',array('goodsid'=>$log['goodsid'],'logid'=>$log['id']))?>">评价</a>
                <?php  } ?>
            <?php  } ?>
        <?php  } ?>
        <?php  if($goods['goodstype']==0 && $log['status']==3 && $log['time_send'] > 0 && $log['time_finish'] == 0) { ?>
        <div class="btn btn-default btn-default-o order-finish" data-logid="<?php  echo $log['id'];?>">确认收货</div>
        <?php  } ?>
        <?php  if($goods['goodstype']==3 && $log['status']==2) { ?>
        <div class="btn btn-default btn-default-o order-packet" data-logid="<?php  echo $log['id'];?>">领取红包</div>
        <?php  } ?>
    </div>
    <script language='javascript'>
        require(['../addons/ewei_shopv2/plugin/creditshop/static/js/log_detail.js'], function (modal) {
            modal.init({goods: <?php  echo json_encode($goods)?>, log: <?php  echo json_encode($log)?>});
        });
    </script>
    <?php  if(com('verify')) { ?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('groups/orders/verify', TEMPLATE_INCLUDEPATH)) : (include template('groups/orders/verify', TEMPLATE_INCLUDEPATH));?>
    <?php  } ?>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--NDAwMDA5NzgyNw==-->