<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='page-heading'>
    <h2 class="text-center">基本设置</h2>
</div>
<div class="form-group" >
    <label class="col-sm-2 control-label">手机端链接<br></label>
    <div class="col-sm-9 col-xs-12">
        <p class='form-control-static'>
            <a href='javascript:;' title='点击复制链接' data-url="<?php  echo mobileUrl('product', null, true)?>" class="js-clip">
                <?php  echo mobileUrl('product', null, true)?>
            </a>
           
        </p>
    </div>
</div>
<div class="form-group" >
    <label class="col-sm-2 control-label">手机端注册中心链接<br></label>
    <div class="col-sm-9 col-xs-12">
        <p class='form-control-static'>
            <a href='javascript:;' title='点击复制链接' data-url="<?php  echo mobileUrl('product/list', null, true)?>" class="js-clip">
                <?php  echo mobileUrl('product/list', null, true)?>
            </a>
           
        </p>
    </div>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>