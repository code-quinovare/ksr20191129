<?php defined('IN_IA') or exit('Access Denied');?><ul class="menu-head-top">
    <li <?php  if($_GPC['r']=='app') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app')?>"><?php  echo m('plugin')->getName('app')?> <i class="fa fa-caret-right"></i></a></li>
</ul>

<div class='menu-header'>首页设置</div>
<ul>
    <?php if(cv('app.shop.adv')) { ?>
        <li <?php  if(strexists($_W['routes'], 'app.shop.adv')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/adv')?>">幻灯片</a></li>
    <?php  } ?>
    <?php if(cv('app.shop.nav')) { ?>
        <li <?php  if(strexists($_W['routes'], 'app.shop.nav')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/nav')?>">导航图标</a></li>
    <?php  } ?>
    <?php if(cv('app.shop.banner')) { ?>
        <li <?php  if(strexists($_W['routes'], 'app.shop.banner')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/banner')?>">广告设置</a></li>
    <?php  } ?>
    <?php if(cv('app.shop.cube')) { ?>
        <li <?php  if(strexists($_W['routes'], 'app.shop.cube')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/cube')?>">魔方推荐</a></li>
    <?php  } ?>
    <?php if(cv('app.shop.recommand')) { ?>
        <li <?php  if(strexists($_W['routes'], 'app.shop.recommand')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/recommand')?>">商品推荐</a></li>
    <?php  } ?>
    <?php if(cv('app.shop.notice')) { ?>
    <li  <?php  if(strexists($_W['routes'], 'app.shop.notice')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/notice')?>">公告管理</a></li>
    <?php  } ?>
    <?php if(cv('app.shop.sort')) { ?>
        <li <?php  if(strexists($_W['routes'], 'app.shop.sort')) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/shop/sort')?>">排版设置</a></li>
    <?php  } ?>
</ul>

<?php if(cv('app.setting|app.pay')) { ?>
    <div class='menu-header'>其他设置</div>
    <ul>
        <?php if(cv('app.setting')) { ?>
            <li <?php  if($_W['routes']=='app.setting') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/setting')?>">基本设置</a></li>
        <?php  } ?>
        <?php if(cv('app.pay')) { ?>
            <li <?php  if($_W['routes']=='app.pay') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('app/pay')?>">支付设置</a></li>
        <?php  } ?>
    </ul>
<?php  } ?>