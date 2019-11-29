<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='page-heading'><h2>入口/分享设置</h2></div>
<form id="setform"  <?php if(cv('sign.set')) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" >

    <div class="form-group">
        <label class="col-sm-2 control-label">在个人中心显示</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <label class='radio radio-inline'><input type='radio' value='0' name='iscenter' <?php  if(empty($set['iscenter'])) { ?>checked<?php  } ?>  /> 关闭</label>
            <label class='radio radio-inline'><input type='radio' value='1' name='iscenter' <?php  if(!empty($set['iscenter'])) { ?>checked<?php  } ?> /> 显示</label>
            <?php  } else { ?>
            <div class="form-control-static"><?php  if(!empty($set['iscenter'])) { ?>显示<?php  } else { ?>关闭<?php  } ?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">在积分商城显示</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <label class='radio radio-inline'><input type='radio' value='0' name='iscreditshop' <?php  if(empty($set['iscreditshop'])) { ?>checked<?php  } ?> /> 关闭</label>
            <label class='radio radio-inline'><input type='radio' value='1' name='iscreditshop' <?php  if(!empty($set['iscreditshop'])) { ?>checked<?php  } ?> /> 显示</label>
            <?php  } else { ?>
            <div class="form-control-static"><?php  if(!empty($set['iscreditshop'])) { ?>显示<?php  } else { ?>关闭<?php  } ?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">分享地址</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <label class='radio radio-inline'><input type='radio' value='0' name='share' <?php  if(empty($set['share'])) { ?>checked<?php  } ?> /> 商城首页</label>
            <label class='radio radio-inline'><input type='radio' value='1' name='share' <?php  if(!empty($set['share'])) { ?>checked<?php  } ?> /> 签到页面</label>
            <?php  } else { ?>
            <div class="form-control-static"><?php  if(!empty($set['share'])) { ?>签到页面<?php  } else { ?>商城首页<?php  } ?></div>
            <?php  } ?>
            <div class="help-block">选择分享地址，签到页面的分享信息读取下面的封面信息</div>
        </div>
    </div>

    <div class="form-group-title"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">直接链接</label>
        <div class="col-sm-9 col-xs-12">
            <p class='form-control-static'>
                <a href='javascript:;' class="js-clip" title='点击复制链接' data-url="<?php  echo mobileUrl('sign',null,true)?>" ><?php  echo mobileUrl('sign',null,true)?></a>
                <span style="cursor: pointer;" data-toggle="popover" data-trigger="hover" data-html="true"
                      data-content="<img src='<?php  echo $qrcode;?>' width='130' alt='链接二维码'>" data-placement="auto right">
                    <i class="glyphicon glyphicon-qrcode"></i>
                </span>
            </p>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label must">关键词</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <input type='text' class='form-control' name='keyword' value="<?php  echo $set['keyword'];?>" data-rule-required="true" />
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $set['keyword'];?></div>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">封面标题</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <input type='text' class='form-control' name='title' value="<?php  echo $set['title'];?>" />
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $set['title'];?></div>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">封面图片</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <?php  echo tpl_form_field_image2('thumb',$set['thumb'])?>
            <?php  } else { ?>
            <?php  if(!empty($set['thumb'])) { ?>
            <div class='form-control-static'>
                <img src="<?php  echo tomedia($set['thumb'])?>" style='width:100px;border:1px solid #ccc;padding:1px' />
            </div>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">封面描述</label>
        <div class="col-sm-9 col-xs-12">
            <?php if(cv('sign.set')) { ?>
            <textarea name='desc' class='form-control'><?php  echo $set['desc'];?></textarea>
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $set['desc'];?></div>
            <?php  } ?>
        </div>
    </div>

<?php if(cv('sign.set')) { ?>
    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9">
            <input type="submit" value="提交" class="btn btn-primary" />
        </div>
    </div>
<?php  } ?>

</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
