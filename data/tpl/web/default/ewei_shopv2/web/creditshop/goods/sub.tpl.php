<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group notice">
    <label class="col-sm-2 control-label">商家通知</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <?php  echo tpl_selector('noticeopenid',array('key'=>'openid','text'=>'nickname', 'thumb'=>'avatar', 'placeholder'=>'昵称/姓名/手机号','buttontext'=>'选择通知人', 'items'=>$saler,'url'=>webUrl('member/query') ))?>
        <span class="help-block">如果用户中奖，可指定某个商家用户，通知商品下单备货通知,如果商品为同一商家，建议使用系统统一设置</span>
        <?php  } else { ?>
        <div class='form-control-static'>
            <?php  if(!empty($saler)) { ?><img  style="width:100px;height:100px;border:1px solid #ccc;padding:1px" src="<?php  echo tomedia($saler['avatar'])?>"/><?php  } else { ?>无<?php  } ?>
        </div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">提供商家</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <input type='text' class='form-control' name='subtitle' value="<?php  echo $item['subtitle'];?>" />
        <?php  } else { ?>
            <div class='form-control-static'><?php  echo $item['subtitle'];?></div>
        <?php  } ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-2 control-label">商家介绍</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <?php  echo tpl_ueditor('subdetail', $item['subdetail'], array('height'=>200))?>
        <?php  } else { ?>
            <textarea id='subdetail' style='display:none'><?php  echo $item['subdetail'];?></textarea>
            <a href='javascript:preview_html("#subdetail")' class="btn btn-default">查看内容</a>
        <?php  } ?>
    </div>
</div>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->