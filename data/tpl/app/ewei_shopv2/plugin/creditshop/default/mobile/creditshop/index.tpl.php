<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<!--<script>document.title = "<?php  if(empty($this->merch_user)) { ?><?php  echo $_W['shopset']['shop']['name'];?><?php  } else { ?><?php  echo $this->merch_user['merchname']?><?php  } ?>"</script>-->
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/template/mobile/default/images/common.css" />
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/static/css/common.css" />
<style type="text/css">
    .fui-navbar ~ .fui-content, .fui-content.navbar{padding:0;}
    .fui-list{display: none;}
    .fui-text{background-color: #01c7a8;}
    .fui-navbar .nav-item.active, .fui-navbar .nav-item:active {
        color: #01c7a8;
    }
</style>
<script>
    $(document).attr("title","互动福利");
</script>
<div class='fui-page  fui-page-current creditshop-index-page'>
    <?php  if(is_h5app()) { ?>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title"><?php  echo $_W['shopset']['trade']['credittext'];?>商城</div>
        <div class="fui-header-right"></div>
    </div>
    <?php  } ?>
    <div class='fui-content navbar'>
        <?php  if(!empty($advs)) { ?>
        <div class='fui-swipe' data-transition="500" data-gap="1">
            <div class='fui-swipe-wrapper'>
                <?php  if(is_array($advs)) { foreach($advs as $adv) { ?>
                <a class='fui-swipe-item external' href="<?php  if(!empty($adv['link'])) { ?><?php  echo $adv['link'];?><?php  } else { ?>javascript:;<?php  } ?>"><img src="<?php  echo tomedia($adv['thumb'])?>" /></a>
                <?php  } } ?>
            </div>
            <div class='fui-swipe-page'></div>
        </div>
        <?php  } ?>
        <div class="menu">
            <a class="item" href="javascript:void(0);">
                <span class="text"><i class="icon icon-jifen"></i> <?php  echo $_W['shopset']['trade']['credittext'];?><?php  echo $credit;?></span>
            </a>
            <!--<a class="item" href="<?php  echo mobileUrl('creditshop/creditlog')?>">
                <span class="text"><i class="icon icon-navlist"></i> 参与记录</span>
            </a>-->
            <a class="item" href="http://shop.quinnovare.cn/app/index.php?i=8&c=entry&m=ewei_shopv2&do=mobile&r=sign">
                <span class="text"><i class="icon icon-navlist"></i> 每日签到</span>
            </a>

        </div>
        <?php  if(count($category)>0 && !empty($category)) { ?>
        <div class="fui-icon-group noborder circle" style="margin-top: 0.5rem">
            <?php  if(is_array($category)) { foreach($category as $cate) { ?>
            <div class="fui-icon-col">
                <a href="<?php  echo mobileUrl('creditshop/lists', array('cate'=>$cate['id']))?>" class="external">
                    <div class="icon"><img src="<?php  echo tomedia($cate['thumb'])?>"></div>
                    <div class="text"><?php  echo $cate['name'];?></div>
                </a>
            </div>
            <?php  } } ?>
        </div>
        <?php  } ?>
        <!--特色抽奖区-->
        <?php  if(count($lotterydraws)>0 && !empty($lotterydraws)) { ?>
        <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell">
                <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                <div class="fui-cell-text"><p>抽奖专区</p></div>
            </a>
        </div>
        <div class="fui-goods-group white block">
            <?php  if(is_array($lotterydraws)) { foreach($lotterydraws as $item) { ?>
            <a class="fui-goods-item external" href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$item['id']))?>" data-nocache="true">
                <div class="image" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($item['thumb'])?>');"></div>
                <div class="detail">
                    <div class="name">
                        <span class="fui-subtext">
                            <?php  if($item['goodstype']==0) { ?>商品<?php  } ?>
                            <?php  if($item['goodstype']==1) { ?>优惠券<?php  } ?>
                            <?php  if($item['goodstype']==2) { ?>余额<?php  } ?>
                            <?php  if($item['goodstype']==3) { ?>红包<?php  } ?>
                        </span>
                        <?php  echo $item['title'];?>
                    </div>
                    <div class="price" style="display: block;">
                        <span style="font-size: 0.5rem">
                            <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;"><?php  echo $item['credit'];?></span>
                            <span style="color:#999;"><?php  echo $_W['shopset']['trade']['credittext'];?></span>
                            <?php  if($item['money'] > 0) { ?>
                             + <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $item['money'];?></span>
                            <?php  } ?>
                        </span>
                        <span class="fui-text text-danger2" style="float:right;">抽奖</span>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
        <?php  } ?>
        <!--<?php  echo $_W['shopset']['trade']['credittext'];?>实物兑换-->
        <?php  if(count($exchanges)>0 && !empty($exchanges)) { ?>
        <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell">
                <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                <div class="fui-cell-text"><p><?php  echo $_W['shopset']['trade']['credittext'];?>实物兑换</p></div>
            </a>
        </div>
        <div class="fui-goods-group white block">
            <?php  if(is_array($exchanges)) { foreach($exchanges as $item) { ?>
            <a class="fui-goods-item external" href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$item['id']))?>" data-nocache="true">
                <div class="image" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($item['thumb'])?>');"></div>
                <div class="detail">
                    <div class="name">
                        <?php  echo $item['title'];?>
                    </div>
                    <div class="price" style="display: block;">
                        <span style="font-size: 0.5rem">
                            <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;"><?php  echo $item['credit'];?></span>
                            <span style="color:#999;"><?php  echo $_W['shopset']['trade']['credittext'];?></span>
                            <?php  if($item['money'] > 0) { ?>
                             + <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $item['money'];?></span>
                            <?php  } ?>
                        </span>
                        <span class="fui-text text-danger2" style="float:right;">兑换</span>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
        <?php  } ?>

        <!--红包兑换区-->
        <?php  if(count($redbags)>0 && !empty($redbags)) { ?>
        <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell">
                <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                <div class="fui-cell-text"><p>红包兑换区</p></div>
            </a>
        </div>
        <div class="fui-goods-group white block">
            <?php  if(is_array($redbags)) { foreach($redbags as $item) { ?>
            <a class="fui-goods-item external" href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$item['id']))?>" data-nocache="true">
                <div class="image" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($item['thumb'])?>');"></div>
                <div class="detail">
                    <div class="name"><?php  echo $item['title'];?></div>
                    <div class="price" style="display: block;">
                        <span style="font-size: 0.5rem">
                            <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;"><?php  echo $item['credit'];?></span>
                            <span style="color:#999;"><?php  echo $_W['shopset']['trade']['credittext'];?></span>
                            <?php  if($item['money'] > 0) { ?>
                             + <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $item['money'];?></span>
                            <?php  } ?>
                        </span>
                        <span class="fui-text text-danger2" style="float:right;">兑换</span>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
        <?php  } ?>

        <!--<?php  echo $_W['shopset']['trade']['credittext'];?>兑换券-->
        <?php  if(count($coupons)>0 && !empty($coupons)) { ?>
        <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell">
                <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                <div class="fui-cell-text"><p><?php  echo $_W['shopset']['trade']['credittext'];?>兑换劵</p></div>
            </a>
        </div>
        <div class="fui-goods-group">
            <?php  if(is_array($coupons)) { foreach($coupons as $item) { ?>
            <a class="fui-goods-item external" href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$item['id']))?>" data-nocache="true">
                <div class="image" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($item['thumb'])?>');"></div>
                <div class="detail">
                    <div class="name"><?php  echo $item['title'];?></div>
                    <div class="price" style="display: block;">
                        <span style="font-size: 0.5rem">
                            <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;"><?php  echo $item['credit'];?></span>
                            <span style="color:#999;"><?php  echo $_W['shopset']['trade']['credittext'];?></span>
                            <?php  if($item['money'] > 0) { ?>
                             + <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $item['money'];?></span>
                            <?php  } ?>
                        </span>
                        <span class="fui-text text-danger2" style="float:right;">兑换</span>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
        <?php  } ?>
        <!--余额兑换区-->
        <?php  if(count($balances)>0 && !empty($balances)) { ?>
        <div class="fui-cell-group fui-cell-click">
            <a class="fui-cell">
                <div class="fui-cell-icon"><i class="icon icon-gifts"></i></div>
                <div class="fui-cell-text"><p>余额兑换区</p></div>
            </a>
        </div>
        <div class="fui-goods-group white block">
            <?php  if(is_array($balances)) { foreach($balances as $item) { ?>
            <a class="fui-goods-item external" href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$item['id']))?>" data-nocache="true">
                <div class="image" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($item['thumb'])?>');"></div>
                <div class="detail">
                    <div class="name"><?php  echo $item['title'];?></div>
                    <div class="price" style="display: block;">
                        <span style="font-size: 0.5rem;">
                            <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;"><?php  echo $item['credit'];?></span>
                            <span style="color:#999;"><?php  echo $_W['shopset']['trade']['credittext'];?></span>
                            <?php  if($item['money'] > 0) { ?>
                             + <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $item['money'];?></span>
                            <?php  } ?>
                        </span>
                        <span class="fui-text text-danger2" style="float:right;">兑换</span>
                    </div>
                </div>
            </a>
            <?php  } } ?>
        </div>
        <?php  } ?>
    </div>

</div>


<?php  $this->footerMenus()?>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->