<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php  $this->followBar()?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/template/mobile/default/images/common.css" />
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/static/css/common.css" />
<style type="text/css">
    .fui-navbar ~ .fui-content, .fui-content.navbar{padding-bottom:0;}
    <?php  if($set['creditbalance']==0 && $pay['credit'] == 0) { ?>
    .fui-actionsheet a.balance{display: none;}
    <?php  } ?>
    <?php  if($set['creditwechat']==0 && $pay['weixin'] == 0 && $pay['weixin_jie'] == 0) { ?>
    .fui-actionsheet a.wechat{display: none;}
    <?php  } ?>
    <?php  if($set['creditalipay']==0 && $pay['alipay'] == 0) { ?>
    .fui-actionsheet a.alipay{display: none;}
    <?php  } ?>
    .text-danger2 {
        background: none;
    }
    .fui-list{display: none;}
    .btn.btn-danger {
        background: #01c7a8;
        color: #fff;
        border: 1px solid #01c7a8;
    }
</style>
<div class='fui-page order-detail-page'>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back" href="<?php  echo mobileUrl('creditshop/detai')?>"></a>
        </div>
        <div class="title">创建订单</div>
        <div class="fui-header-right"></div>
    </div>
    <div class='fui-content navbar'>
        <?php  if($goods['type']==0) { ?>
            <div class="fui-cell-group fui-cell-click">
                <?php  if($goods['isverify']==0 && $goods['goodstype']==0) { ?>
                <div class="fui-cell ">
                    <div class="fui-cell-label ">收货地址</div>
                    <a class="fui-cell-info" href="<?php  echo mobileUrl('member/address/selector')?>">
                        <div class="fui-cell-remark" id="address_select">请选择收货地址</div>
                    </a>
                </div>
                <?php  } else if($goods['isverify']==1 && $goods['goodstype']==0) { ?>
                <div class="fui-cell">
                    <div class="fui-cell-text mask">兑换必填</div>
                </div>
                <?php  if($set['set_realname']==0) { ?>
                <div class="fui-cell">
                    <div class="fui-cell-label">联系人</div>
                    <div class="fui-cell-info">
                        <input type="text" placeholder="请输入真实姓名" id="carrier_realname" data-show="<?php  echo $set['set_realname'];?>" value="<?php  echo $member['realname'];?>" class="fui-input" maxlength="10">
                    </div>
                </div>
                <?php  } ?>
                <?php  if($set['set_mobile']==0) { ?>
                <div class="fui-cell">
                    <div class="fui-cell-label">联系方式</div>
                    <div class="fui-cell-info">
                        <input type="tel" placeholder="请输入手机号码" id="carrier_mobile" data-show="<?php  echo $set['set_mobile'];?>" value="<?php  echo $member['mobile'];?>" class="fui-input" maxlength="11">
                    </div>
                </div>
                <?php  } ?>
                <div class="fui-cell">
                    <div class="fui-cell-text store">请选择兑换门店</div>
                    <a class="fui-cell-info" href="<?php  echo mobileUrl('store/selector', array('ids'=>$goods['storeids'],'merchid'=>$goods['merchid']))?>">
                        <div class="fui-cell-remark" id="storename"></div>
                    </a>
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
                        <?php  if($optionid) { ?><div class='subtitle' style="font-size:0.6rem;color:#999;">规格：<?php  echo $goods['optiontitle'];?></div><?php  } ?>
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

        <?php  if(!empty($stores)) { ?>
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
            <?php  if($goods['goodstype']==0 && $goods['type']==0 && $goods['isverify']==0) { ?>
            <div class="fui-cell">
                <div class="fui-cell-label">运费</div>
                <div class="fui-cell-info"></div>
                <div class="fui-cell-remark noremark dispatchprice">
                    <?php  if(is_array($goods['dispatch'])) { ?>
                        &yen;<?php  echo number_format($goods['dispatch']['min'],2)?> ~ &yen;<?php  echo number_format($goods['dispatch']['max'],2)?>
                    <?php  } else { ?>
                        <?php echo $goods['dispatch'] == 0 ? '包邮' : '&yen;'.number_format($goods['dispatch'],2)?>
                    <?php  } ?>
                </div>
            </div>
            <?php  } ?>
        </div>
    </div>

    <div class='fui-footer fui-navbar order-create-checkout'>
        <p class="nav-item" style="width:10%;text-align: left;padding:0.3rem;font-size:0.7rem;">
            需付<?php  if($goods['isverify'] == 0 && $goods['goodstype']==0 && $goods['type']==0 && $goods['dispatch'] > 0) { ?>(含运费)<?php  } ?>：
            <span class="text-danger2" style="background: none;">
                <?php  echo $goods['credit'];?><?php  echo $_W['shopset']['trade']['credittext'];?>
                <?php  if($goods['money'] > 0 || $goods['dispatch'] >0) { ?>+
                    <?php  if(is_array($goods['dispatch'])) { ?>
                        &yen;<span class="moneydispatch"><?php  echo number_format($goods['money'] + $goods['dispatch']['max'],2)?></span>
                    <?php  } else { ?>
                        &yen;<span class="moneydispatch"><?php  echo number_format($goods['money'] + $goods['dispatch'],2)?></span>
                    <?php  } ?>
                <?php  } ?>
            </span>
        </p>
        <a href="javascript:;" class="nav-item btn btn-danger buybtn" id="openActionSheet" style="background: #01c7a8;">立即支付</a>
    </div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH)) : (include template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH));?>
    <script language='javascript'>
        require(['../addons/ewei_shopv2/plugin/creditshop/static/js/create.js'], function (modal) {
            modal.init({goods: <?php  echo json_encode($goods)?>,optionid:<?php  echo $optionid;?>});
        });
    </script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--913702023503242914-->