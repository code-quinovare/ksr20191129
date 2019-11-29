<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">排序</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <input type='number' class='form-control' name='displayorder' value="<?php  echo $item['displayorder'];?>"/>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $item['displayorder'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label must">商品类型</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <label class="radio-inline"><input type="radio" name='goodstype' value="0" <?php  if(empty($item['goodstype'])) { ?>checked<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> />商品</label>
            <?php  if(com('coupon')) { ?>
                <label class="radio-inline"><input type="radio" name='goodstype' value="1" <?php  if($item['goodstype']==1) { ?>checked<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> />优惠券</label>
            <?php  } ?>
            <?php  if(empty($_W['merchid'])) { ?>
            <label class="radio-inline"><input type="radio" name='goodstype' value="2" <?php  if($item['goodstype']==2) { ?>checked<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> />余额</label>
            <label class="radio-inline"><input type="radio" name='goodstype' value="3" <?php  if($item['goodstype']==3) { ?>checked<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> />红包</label>
            <?php  } ?>
            <div class='help-block cgt cgt-0' <?php  if(!empty($item['goodstype'])) { ?>style="display:none"<?php  } ?>>保存后商品类型不可更改</div>
            <div class='help-block cgt cgt-1' <?php  if($item['goodstype']!=1) { ?>style="display:none"<?php  } ?>>设置为优惠券类型，则无需进行领取，兑换或抽中直接发送到优惠券账户(保存后商品类型不可更改)</div>
            <div class='help-block cgt cgt-2' <?php  if($item['goodstype']!=2) { ?>style="display:none"<?php  } ?>>设置为余额类型，则无需进行领取，兑换或抽中直接发送到用户账户(保存后商品类型不可更改)</div>
            <div class='help-block cgt cgt-3' <?php  if($item['goodstype']!=3) { ?>style="display:none"<?php  } ?>>设置为红包类型，则无需进行领取，兑换或抽中直接发送微信红包(保存后商品类型不可更改)</div>
        <?php  } else { ?>
            <div class='form-control-static'><?php  if(empty($item['goodstype'])) { ?>商品<?php  } else if($item['goodstype']==1) { ?>优惠券<?php  } else if($item['goodstype']==2) { ?>余额<?php  } else if($item['goodstype']==3) { ?>红包<?php  } ?></div>
        <?php  } ?>
    </div>
</div>

<div class="form-group cgt cgt-0" <?php  if($item['goodstype']!=0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">设置商品</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <?php  echo tpl_selector('goodsid', array('required'=>false, 'preview'=>false,'url'=>webUrl('creditshop/goods/query'), 'items'=>$goods, 'readonly'=>true, 'buttontext'=>'选择商品', 'placeholder'=>'请选择商品','callback'=>'select_goods'))?>
        <div class="help-block">提示：您可选择商城商品或自行设置商品信息(此项非必选)</div>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $goods['title'];?></div>
        <?php  } ?>
    </div>
</div>

<?php  if(com('coupon')) { ?>
    <div class="form-group cgt cgt-1" <?php  if($item['goodstype']!=1) { ?>style="display:none"<?php  } ?>>
        <label class="col-sm-2 control-label">选择优惠券</label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('creditshop.goods' ,$item) ) { ?>
                <?php  echo tpl_selector('couponid',array('required'=>false, 'preview'=>true,'url'=>webUrl('sale/coupon/query'),'text'=>'couponname','items'=>$coupon,'readonly'=>true,'buttontext'=>'选择优惠券','placeholder'=>'请选择优惠券','callback'=>'select_coupon'))?>
            <?php  } else { ?>
                <div class='form-control-static'><?php  echo $coupon['title'];?></div>
            <?php  } ?>
        </div>
    </div>
<?php  } ?>

<div class="form-group cgt cgt-2" <?php  if($item['goodstype']!=2) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">设置余额</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class="input-group-addon">余额</span>
            <input type="number" class="form-control" name="grant1" value="<?php  echo $item['grant1'];?>">
            <span class="input-group-addon">元</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>余额：<?php  echo $coupon['grant1'];?>元</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group cgt cgt-3" <?php  if($item['goodstype']!=3 || $item['packetmoney']<=0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">红包总发放金额</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class="input-group-addon">总额</span>
            <input type="number" class="form-control" name="packetmoney" value="<?php  echo $item['packetmoney'];?>" <?php  if(!empty($item)) { ?> disabled<?php  } ?>>
            <span class="input-group-addon">元 剩余</span>
            <input type="number" class="form-control" name="surplusmoney" disabled value="<?php  echo $item['surplusmoney'];?>">
            <span class="input-group-addon">元</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>总额：<?php  echo $coupon['packetmoney'];?>元，剩余<?php  echo $coupon['surplusmoney'];?>元</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group cgt cgt-3" <?php  if($item['goodstype']!=3 || $item['packetmoney']<=0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">红包兑换限制</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class="input-group-addon">剩余金额小于</span>
            <input type="number" class="form-control" name="packetlimit" value="<?php  echo $item['packetlimit'];?>">
            <span class="input-group-addon">元，停止兑换</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>剩余金额小于<?php  echo $coupon['packetlimit'];?>元，停止兑换</div>
        <?php  } ?>
        <span class='help-block'>剩余金额小于X时，停止兑换。如果为空，剩余金额为0时停止兑换。</span>
    </div>
</div>
<div class="form-group cgt cgt-3" <?php  if($item['goodstype']!=3 || !$item['packettotal']>0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">红包个数</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class="input-group-addon">红包</span>
            <input type="text" class="form-control" name="packettotal" <?php  if(!empty($item)) { ?> disabled<?php  } ?> value="<?php  echo $item['packettotal'];?>">
            <span class="input-group-addon">个 剩余</span>
            <input type="text" class="form-control" name="packetsurplus" disabled value="<?php  echo $item['packetsurplus'];?>">
            <span class="input-group-addon">个</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>红包<?php  echo $coupon['packettotal'];?>个，剩余<?php  echo $coupon['packetsurplus'];?>个</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group cgt cgt-3" <?php  if($item['goodstype']!=3) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">红包类型</label>
    <div class="col-sm-9 col-xs-12" style='padding-left:0'>
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class='input-group-addon' style='border:none'>
                <label class="radio-inline" style='margin-top:-7px;' >
                    <input type="radio" name="packettype" value="1" <?php  if($item['packettype'] == 1) { ?>checked="true"<?php  } ?> <?php  if(!empty($item)) { ?> disabled<?php  } ?> /> 随机金额
                </label>
            </span>
            <span class="input-group-addon">每个红包最低</span>
            <input type="number" class="form-control" name="minpacketmoney" <?php  if(!empty($item)) { ?> disabled<?php  } ?> value="<?php  echo $item['minpacketmoney'];?>">
            <span class="input-group-addon">元</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if($item['packettype'] == 1) { ?>随机金额：每个红包最低<?php  echo $item['minpacketmoney'];?>元<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group cgt cgt-3" <?php  if($item['goodstype']!=3) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-9 col-xs-12" style='padding-left:0'>
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class='input-group-addon' style='border:none'>
                <label class="radio-inline"  style='margin-top:-7px;' >
                    <input type="radio"name="packettype" value="0" <?php  if(!empty($item)) { ?> disabled<?php  } ?> <?php  if(empty($item['packettype'])) { ?>checked="true"<?php  } ?>  /> 固定金额
                </label>
            </span>
            <input type="text" name="grant2" id="grant2" class="form-control" <?php  if(!empty($item)) { ?> disabled<?php  } ?> value="<?php  echo $item['grant2'];?>" />
            <span class="input-group-addon">元</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if($item['packettype'] == 1) { ?>固定金额：<?php  echo $item['grant2'];?>元<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>


<div class="form-group">
    <label class="col-sm-2 control-label must">商品标题</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <input type='text' class='form-control' id="goodsname" name='title' value="<?php  echo $item['title'];?>" id="title" data-rule-required='true' data-msg-required='请设置标题'/>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $item['title'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label must">商品分类</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <select class='form-control' name='cate' data-rule-required='true' data-msg-required='请选择分类'>
            <option value=''>请选择商品分类</option>
            <?php  if(is_array($category)) { foreach($category as $cate) { ?>
                <option value='<?php  echo $cate['id'];?>' <?php  if($item['cate']==$cate['id']) { ?>selected<?php  } ?>><?php  echo $cate['name'];?></option>
            <?php  } } ?>
        </select>
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $item['displayorder'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">商品图片</label>
    <div class="col-sm-9 col-xs-12 thumb-container gimgs">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <?php  echo tpl_form_field_image2('thumb',$item['thumb'])?>
        <?php  } else { ?>
            <?php  if(!empty($item['thumb'])) { ?>
                <a href='<?php  echo tomedia($item[' thumb'])?>' target='_blank'>
                    <img src="<?php  echo tomedia($item['thumb'])?>" style='width:100px;border:1px solid #ccc;padding:1px'/>
                </a>
            <?php  } ?>
        <?php  } ?>
    </div>
</div>
<div class="form-group" <?php  if($item['goodstype']!=0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">商品原价</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <input type="text" name="price" id="price" class="form-control" value="<?php  echo $item['price'];?>" />
            <!--<span class="input-group-addon">原价</span>
            <input type="text" name="productprice" id="productprice" class="form-control" value="<?php  echo $item['productprice'];?>" />-->
            <span class="input-group-addon">元</span>
        </div>
        <span class='help-block'></span>
        <?php  } else { ?>
        <div class='form-control-static'>现价：<?php  echo $item['price'];?> 元 原价：<?php  echo $item['productprice'];?> 元/div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">兑换限制</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <!--<span class="input-group-addon">每人每天</span>
            <input type='text' class='form-control' value="<?php  echo $item['chanceday'];?>" name='chanceday' />-->
            <span class="input-group-addon" style="border-right: 0;">每人共</span>
            <input type='text' class='form-control' value="<?php  echo $item['chance'];?>" name='chance' />
            <span class="input-group-addon">次，每天提供</span>
            <input type='text' class='form-control' value="<?php  echo $item['totalday'];?>" name="totalday" />
            <span class="input-group-addon">份</span>
        </div>
        <span class="help-block">空为不限制</span>
        <?php  } else { ?>
        <div class='form-control-static'>每人<?php  if($item['chance']==0) { ?>无限<?php  } else { ?><?php  echo $item['chance'];?><?php  } ?>次机会，每天<?php  if($item['totalday']==0) { ?>无限<?php  } else { ?><?php  echo $item['totalday'];?><?php  } ?>次机会</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label must">活动消耗</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class="input-group-addon">消耗</span>
            <input type='text' class='form-control' value="<?php  echo $item['credit'];?>" name='credit'/>
            <span class="input-group-addon">积分 + 金额</span>
            <input type='text' class='form-control' value="<?php  echo $item['money'];?>" name='money'/>
            <span class="input-group-addon">元&nbsp;&nbsp;
                <label class="checkbox-inline" style='margin-top:-8px;display:none;'>
                    <input type="checkbox" name='usecredit2' value="1" <?php  if($item['usecredit2']==1) { ?>checked<?php  } ?> /> 优先使用余额支付
                </label>
            </span>
        </div>
        <span class="help-block">可任意组合，可以单独积分兑换，或者积分+现金形式兑换(积分必须大于0)</span>
        <?php  } else { ?>
        <div class='form-control-static'>消耗 <?php  echo $item['credit'];?> 积分 花费 <?php  echo $item['money'];?> 元现金</div>
        <?php  } ?>
    </div>
</div>
<div class="form-group dispatch_info" <?php  if($item['goodstype']!=0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label">运费设置</label>
    <div class="col-sm-6 col-xs-6" style='padding-left:0'>
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class='input-group-addon' style='border:none'><label class="radio-inline" style='margin-top:-7px;' ><input type="radio" name="dispatchtype" value="1" <?php  if($item['dispatchtype'] == 1) { ?>checked="true"<?php  } ?> /> 运费模板</label></span>
            <select class="form-control tpl-category-parent select2" id="dispatchid" name="dispatchid">
                <option value="0">默认模板</option>
                <?php  if(is_array($dispatch_data)) { foreach($dispatch_data as $dispatch_item) { ?>
                <option value="<?php  echo $dispatch_item['id'];?>" <?php  if($item['dispatchid'] == $dispatch_item['id']) { ?>selected="true"<?php  } ?>><?php  echo $dispatch_item['dispatchname'];?></option>
                <?php  } } ?>
            </select>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if(empty($item['dispatchtype'])) { ?>运费模板 <?php  if($item['dispatchid'] == 0) { ?>默认模板<?php  } else { ?><?php  if(is_array($dispatch_data)) { foreach($dispatch_data as $dispatch_item) { ?><?php  if($item['dispatchid'] == $dispatch_item['id']) { ?><?php  echo $dispatch_item['dispatchname'];?><?php  } ?><?php  } } ?><?php  } ?><?php  } else { ?>统一邮费<?php  } ?></div>
        <?php  } ?>
    </div>
    </div>
    <div class="form-group dispatch_info" <?php  if($item['goodstype']!=0) { ?>style="display:none"<?php  } ?>>
    <label class="col-sm-2 control-label"></label>
    <div class="col-sm-6 col-xs-6" style='padding-left:0'>
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <div class="input-group">
            <span class='input-group-addon' style='border:none'><label class="radio-inline"  style='margin-top:-7px;' ><input type="radio"name="dispatchtype" value="0" <?php  if(empty($item['dispatchtype'])) { ?>checked="true"<?php  } ?>  /> 统一邮费</label></span>
            <input type="text" name="dispatch" id="dispatch" class="form-control" value="<?php  echo $item['dispatch'];?>" />
            <span class="input-group-addon">元</span>
        </div>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  echo $item['dispatch'];?> 元
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">商品属性</label>
    <div class="col-sm-9 col-xs-12" >
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <!--<label for="istop" class="checkbox-inline">
            <input type="checkbox" name="istop" value="1" id="istop" <?php  if($item['istop'] == 1) { ?>checked="true"<?php  } ?> /> 置顶
        </label>-->
        <label for="isrecommand" class="checkbox-inline">
            <input type="checkbox" name="isrecommand" value="1" id="isrecommand" <?php  if($item['isrecommand'] == 1) { ?>checked="true"<?php  } ?> /> 推荐
        </label>
        <label for="istime" class="checkbox-inline">
            <input type="checkbox" name="istime" value="1" id="istime" <?php  if($item['istime'] == 1) { ?>checked="true"<?php  } ?> /> 限时购买
        </label>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if($item['istop']==1) { ?>置顶; <?php  } ?>
            <?php  if($item['isrecommand']==1) { ?>推荐; <?php  } ?>
            <?php  if($item['istime']==1) { ?>限时购买; <?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group" id="creditshoptime" <?php  if($item['istime'] != 1) { ?>style="display:none;"<?php  } ?>>
    <label class="col-sm-2 control-label">限时购买</label>
    <?php if( ce('creditshop.goods' ,$item) ) { ?>
    <div class="col-sm-4 col-xs-6">
        <?php echo tpl_form_field_date('timestart', !empty($item['timestart']) ? date('Y-m-d H:i',$item['timestart']) : date('Y-m-d H:i'), 1)?>
    </div>
    <div class="col-sm-4 col-xs-6">
        <?php echo tpl_form_field_date('timeend', !empty($item['timeend']) ? date('Y-m-d H:i',$item['timeend']) : date('Y-m-d H:i'), 1)?>
    </div>
    <?php  } else { ?>
    <div class="col-sm-6 col-xs-6">
        <div class='form-control-static'>
            <?php  if($item['istime']==1) { ?>
            <?php  echo date('Y-m-d H:i',$item['timestart'])?> - <?php  echo date('Y-m-d H:i',$item['timeend'])?>
            <?php  } ?>
        </div>
    </div>
    <?php  } ?>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">活动状态</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <label class="radio-inline"><input type="radio" name='status' value="0" <?php  if(empty($item['status'])) { ?>checked<?php  } ?> /> 暂停</label>
        <label class="radio-inline"><input type="radio" name='status' value="1" <?php  if($item['status']==1) { ?>checked<?php  } ?> /> 开启</label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if(empty($item['type'])) { ?>暂停<?php  } else { ?>开启<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $("#istime").on("click",function(){
            if($(this).prop("checked")){
                $("#creditshoptime").show();
            }else{
                $("#creditshoptime").hide();
            }
        })
    })
</script>
<!--4000097827-->