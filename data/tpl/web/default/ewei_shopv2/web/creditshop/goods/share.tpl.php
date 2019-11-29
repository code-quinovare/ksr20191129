<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">参加必须关注</label>
    <div class="col-sm-9 col-xs-12">
         <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <label class="radio-inline">
            <input type="radio" name='followneed' value="0" <?php  if(empty($item['followneed'])) { ?>checked<?php  } ?> /> 不需要
        </label>
        <label class="radio-inline">
            <input type="radio" name='followneed' value="1" <?php  if($item['followneed']==1) { ?>checked<?php  } ?> /> 必须关注
        </label>
         <span class='help-block'>引导关注链接请到【基础设置】中设置</span>
            <?php  } else { ?>
         <div class='form-control-static'><?php  if(empty($item['type'])) { ?>不需要<?php  } else { ?>必须关注<?php  } ?></div>
         <?php  } ?>
    </div>
</div>
 <div class="form-group">
    <label class="col-sm-2 control-label">未关注提示</label>
    <div class="col-sm-9 col-xs-12">
           <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <input type="text" name="followtext" id="followtext" class="form-control" value="<?php  echo $item['followtext'];?>" />
        <span class='help-block'>未关注情况下，弹出的提示文字,默认为'您必须关注我们的公众帐号，才能参加活动哦!'</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['followtext'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享标题</label>
    <div class="col-sm-9 col-xs-12">
           <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <input type="text" name="share_title" id="share_title" class="form-control" value="<?php  echo $item['share_title'];?>" />
        <span class='help-block'>如果不填写，默认为商品名称</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $item['share_title'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享图标</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <?php  echo tpl_form_field_image2('share_icon', $item['share_icon'])?>
            <span class='help-block'>如果不选择，默认为商品缩略图片</span>
        <?php  } else { ?>
            <?php  if(!empty($item['share_icon'])) { ?>
            <a href='<?php  echo tomedia($item['share_icon'])?>' target='_blank'>
                <img src="<?php  echo tomedia($item['share_icon'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
            </a>
            <?php  } ?>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享描述</label>
    <div class="col-sm-9 col-xs-12">
         <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <textarea name="share_desc" class="form-control" ><?php  echo $item['share_desc'];?></textarea>
            <span class='help-block'>如果不填写，默认为商城名称</span>
         <?php  } else { ?>
            <div class='form-control-static'><?php  echo $item['share_desc'];?></div>
        <?php  } ?>
    </div>
</div>
<!--青岛易联互动网络科技有限公司-->