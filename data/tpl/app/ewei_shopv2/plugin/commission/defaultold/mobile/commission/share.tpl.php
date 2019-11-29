<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script>document.title = "分享页面"; </script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('commission/common', TEMPLATE_INCLUDEPATH)) : (include template('commission/common', TEMPLATE_INCLUDEPATH));?>
<div class="fui-page fui-page-current page-commission-shares">
    <div class="fui-content">
        <?php  if(!empty($goods)) { ?>
        <div class="fui-list-group">
            <div class="fui-list">
                <div class="fui-list-media">
                    <i class="icon icon-money"></i>
                </div>
                <div class="fui-list-inner">
                    <div class="row">
                        <div class="row-text"><?php  echo $this->set['texts']['commission1']?> <span class='text-danger'><?php  echo $commission;?></span> <?php  echo $this->set['texts']['yuan']?>
                        </div>
                    </div>
                    <div class="subtitle">已销售 <span><?php  echo $goods['sales'];?></span> 件</div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <img src="<?php  echo $qrcode;?>?t=<?php echo TIMESTAMP;?>" style="width:100%;"/>
        
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

