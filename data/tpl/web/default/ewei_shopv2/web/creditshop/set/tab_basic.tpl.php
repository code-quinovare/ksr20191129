<?php defined('IN_IA') or exit('Access Denied');?><div class='form-group-title'>线下核销设置</div>
<div class="form-group">
    <label class="col-sm-2 control-label">线下核销是否填写联系人</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <label class='radio radio-inline'>
            <input type='radio' value='1' name='data[set_realname]' <?php  if($data['set_realname']==1) { ?>checked<?php  } ?> /> 隐藏
        </label>
        <label class='radio radio-inline'>
            <input type='radio' value='0' name='data[set_realname]'  <?php  if($data['set_realname']==0) { ?>checked<?php  } ?> /> 显示
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($data['set_realname']==1) { ?>隐藏<?php  } else { ?>显示<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">线下核销是否填写联系方式</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <label class='radio radio-inline'>
            <input type='radio' value='1' name='data[set_mobile]' <?php  if($data['set_mobile']==1) { ?>checked<?php  } ?> /> 隐藏
        </label>
        <label class='radio radio-inline'>
            <input type='radio' value='0' name='data[set_mobile]'  <?php  if($data['set_mobile']==0) { ?>checked<?php  } ?> /> 显示
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($data['set_mobile']==1) { ?>隐藏<?php  } else { ?>显示<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">线下兑换关键词</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <input type="text" name="data[exchangekeyword]" class="form-control" value="<?php  echo $data['exchangekeyword'];?>" />
        <span class='help-block'>店员线下兑换使用，使用方法: 回复关键词后系统会提示输入兑换码</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if(empty($data['exchangekeyword'])) { ?>兑换<?php  } else { ?><?php  echo $data['exchangekeyword'];?><?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class='form-group-title'>红包设置</div>
<div class="form-group">
    <label class="col-sm-2 control-label">发送者名称</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <input type="text" name="data[sendname]" class="form-control" value="<?php  echo $data['sendname'];?>"  />
        <span class="help-block">不填写默认为商城名称</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['sendname'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">红包祝福语</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <input type="text" name="data[wishing]" class="form-control" value="<?php  echo $data['wishing'];?>"  />
        <span class="help-block">不填写默认为”红包领到手抽筋，别人加班你加薪!“</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['wishing'];?></div>
        <?php  } ?>
    </div>
</div>

<div class='form-group-title'>基础设置</div>
<div class="form-group">
    <label class="col-sm-2 control-label">在会员中心显示积分兑换按钮</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <label class='radio radio-inline'>
            <input type='radio' value='0' name='data[centeropen]' <?php  if($data['centeropen']==0) { ?>checked<?php  } ?> /> 隐藏
        </label>
        <label class='radio radio-inline'>
            <input type='radio' value='1' name='data[centeropen]'  <?php  if($data['centeropen']==1) { ?>checked<?php  } ?> /> 显示
        </label>
        <?php  } else { ?>
        <div class='form-control-static'><?php  if($data['centeropen']==1) { ?>显示<?php  } else { ?>关闭<?php  } ?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">关注引导页面</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <input type="text" name="data[followurl]" class="form-control" value="<?php  echo $data['followurl'];?>"  />
        <span class="help-block">不填写默认为商城引导页面</span>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['followurl'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">积分说明页面</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <input type="text" name="data[crediturl]" class="form-control" value="<?php  echo $data['crediturl'];?>"  />
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['crediturl'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享标题</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <input type="text" name="data[share_title]" id="share_title" class="form-control" value="<?php  echo $data['share_title'];?>" />
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['share_title'];?></div>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享图标</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <?php  echo tpl_form_field_image2('data[share_icon]', $data['share_icon'])?>
        <?php  } else { ?>
        <?php  if(!empty($data['share_icon'])) { ?>
        <a href='<?php  echo tomedia($data['share_icon'])?>' target='_blank'>
        <img src="<?php  echo tomedia($data['share_icon'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
        </a>
        <?php  } ?>
        <?php  } ?>
    </div>
</div>
<div class="form-group">
    <label class="col-sm-2 control-label">分享描述</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <textarea name="data[share_desc]" class="form-control" ><?php  echo $data['share_desc'];?></textarea>
        <?php  } else { ?>
        <div class='form-control-static'><?php  echo $data['share_desc'];?></div>
        <?php  } ?>
    </div>
</div>
<!--<div class="form-group">
    <label class="col-sm-2 control-label">模板选择</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <select class='form-control' name='data[style]'>
            <?php  if(is_array($styles)) { foreach($styles as $style) { ?>
            <option value='<?php  echo $style;?>' <?php  if($style==$data['style']) { ?>selected<?php  } ?>><?php  echo $style;?></option>
            <?php  } } ?>
        </select>
        <?php  } else { ?>
        <?php  echo $data['style'];?>
        <?php  } ?>
    </div>
</div>-->
<div class="form-group">
    <label class="col-sm-2 control-label">重要说明</label>
    <div class="col-sm-9 col-xs-12">
        <?php if(cv('creditshop.set.edit')) { ?>
        <textarea name="data[importantdetail]" class="form-control" placeholder="全局重要说明，不填则不显示"><?php  echo $data['importantdetail'];?></textarea>
        <?php  } else { ?>
        <textarea id='importantdetail' style='display:none'><?php  echo $data['importantdetail'];?></textarea>
        <a href='javascript:preview_html("#importantdetail")' class="btn btn-default">查看内容</a>
        <?php  } ?>
    </div>
</div>
<!--NDAwMDA5NzgyNw==-->