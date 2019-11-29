<?php defined('IN_IA') or exit('Access Denied');?><?php  if(p('newstore')) { ?>
<ul class="menu-head-top">
    <li <?php  if($_W['action']=='store.statistic') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/statistic')?>">门店概述 <i class="fa fa-caret-right"></i></a></li>
</ul>
<?php  } ?>

<?php  if(com('verify')) { ?>
<div class='menu-header'>门店管理</div>
<ul>
    <?php if(cv('store')) { ?><li <?php  if($_W['action'] == 'store'||$_W['action'] == 'store.add'||$_W['action'] == 'store.edit'||$_W['action'] == 'store.diypage.page'||$_W['routes'] == 'store.diypage.settings') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store')?>">门店列表</a></li><?php  } ?>
    <?php if(cv('store.saler')) { ?><li <?php  if($_W['action'] == 'store.saler') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/saler')?>">店员管理</a></li><?php  } ?>
    <?php  if(p('newstore')) { ?>
        <?php  if(false) { ?>
        <?php if(cv('store.storegroup')) { ?><li <?php  if($_W['action'] == 'store.storegroup') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/storegroup')?>">门店分组</a></li><?php  } ?>
        <?php  } ?>
        <?php if(cv('store.category')) { ?><li <?php  if($_W['action'] == 'store.category') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/category')?>">门店分类</a></li><?php  } ?>
        <?php if(cv('store.role')) { ?><li <?php  if($_W['action'] == 'store.perm.role') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/perm/role')?>">店员角色管理</a></li><?php  } ?>
        <?php if(cv('store.staff')) { ?><li <?php  if($_W['action'] == 'store.staff') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/staff')?>">服务人员</a></li><?php  } ?>
    <?php  } ?>
    <?php if(cv('store.set')) { ?><li <?php  if($_W['action'] == 'store.set') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/set')?>">关键词设置</a></li><?php  } ?>
</ul>
<div class='menu-header'>门店商品管理</div>
<ul>
    <?php  if(p('newstore')) { ?>
    <?php if(cv('store.goodsgroup')) { ?><li <?php  if($_W['action'] == 'store.goodsgroup') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/goodsgroup')?>">商品组管理</a></li><?php  } ?>
    <?php  } ?>
    <?php if(cv('store.verifygoods')) { ?><li <?php  if($_W['action'] == 'store.verifygoods') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/verifygoods')?>">记次时商品核销管理</a></li><?php  } ?>
</ul>

<div class='menu-header'>统计</div>
<ul>
    <?php if(cv('store.verify.log')) { ?><li <?php  if($_W['action'] == 'store.verify') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/verify/log')?>">记次时商品记录</a></li><?php  } ?>
    <?php if(cv('store.verifyorder.log')) { ?><li <?php  if($_W['action'] == 'store.verifyorder') { ?> class="active" <?php  } ?>><a href="<?php  echo webUrl('store/verifyorder/log')?>">核销订单记录</a></li><?php  } ?>
</ul>

<?php  if(p('newstore')) { ?>
    <?php if(cv('store.diypage.add|store.diypage.edit|store.diypage.delete')) { ?>
        <div class='menu-header'>门店装修</div>
        <ul class="mc-list">
            <li <?php  if($_W['action']=='store.diypage'&&$_W['routes']!='store.diypage.settings') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('store/diypage')?>">模板列表</a></li>
        </ul>
    <?php  } ?>
<?php  } ?>

<?php  } ?>
