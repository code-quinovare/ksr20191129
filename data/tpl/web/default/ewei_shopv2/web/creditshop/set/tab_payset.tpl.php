<?php defined('IN_IA') or exit('Access Denied');?><div class="panel panel-default" >
    <?php  if($pay['credit']==1) { ?>
    <div class="panel-body">
        <div class="col-sm-9 col-xs-12">
            <h4>余额支付</h4>
            <span>积分商城是否开启余额支付，此开关只控制积分商城是否支持</span>
        </div>
        <div class="col-sm-2 pull-right" style="padding-top:10px;text-align: right" >
            <?php if(cv('creditshop.set.edit')) { ?>
            <input type="checkbox" class="js-switch" name="data[creditbalance]" value="1" <?php  if($data['creditbalance']==1) { ?>checked<?php  } ?> />
            <?php  } else { ?>
            <?php  if($data['creditbalance']==1) { ?>
            <span class='text-success'>开启</span>
            <?php  } else { ?>
            <span class='text-default'>关闭</span>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
    <?php  if($pay['weixin']==1 || $pay['weixin_jie'] == 1) { ?>
    <div class="panel-body">
        <div class="col-sm-9 col-xs-12">
            <h4>微信支付</h4>
            <span>积分商城是否开启余额支付，此开关只控制积分商城是否支持</span>
        </div>
        <div class="col-sm-2 pull-right" style="padding-top:10px;text-align: right" >
            <?php if(cv('creditshop.set.edit')) { ?>
            <input type="checkbox" class="js-switch" name="data[creditwechat]" value="1" <?php  if($data['creditwechat']==1) { ?>checked<?php  } ?> />
            <?php  } else { ?>
            <?php  if($data['creditwechat']==1) { ?>
            <span class='text-success'>开启</span>
            <?php  } else { ?>
            <span class='text-default'>关闭</span>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
    <?php  if($pay['alipay']==1) { ?>
    <div class="panel-body">
        <div class="col-sm-9 col-xs-12">
            <h4>支付宝支付</h4>
            <span>积分商城是否开启余额支付，此开关只控制积分商城是否支持</span>
        </div>
        <div class="col-sm-2 pull-right" style="padding-top:10px;text-align: right" >
            <?php if(cv('creditshop.set.edit')) { ?>
            <input type="checkbox" class="js-switch" name="data[creditalipay]" value="1" <?php  if($data['creditalipay']==1) { ?>checked<?php  } ?> />
            <?php  } else { ?>
            <?php  if($data['creditalipay']==1) { ?>
            <span class='text-success'>开启</span>
            <?php  } else { ?>
            <span class='text-default'>关闭</span>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
</div>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->