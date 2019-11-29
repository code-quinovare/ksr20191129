<?php defined('IN_IA') or exit('Access Denied');?><div class='menu-header'><?php  echo $this->plugintitle?></div>
<ul>
    <?php if(cv('creditshop.goods')) { ?>
        <li <?php  if($_W['action']=='goods') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/goods')?>">商品管理</a></li>
    <?php  } ?>
    <?php if(cv('creditshop.category')) { ?>
        <li <?php  if($_W['action']=='category') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/category')?>">分类管理</a></li>
    <?php  } ?>
    <?php if(cv('creditshop.adv')) { ?>
        <li <?php  if($_W['action']=='adv') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/adv')?>">幻灯片管理</a></li>
    <?php  } ?>
</ul>
<div class='menu-header'>参与记录</div>
<ul>
    <?php if(cv('creditshop.log.exchange')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.log.exchange') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/exchange')?>">兑换记录</a></li>
    <?php  } ?>
    <?php if(cv('creditshop.log.draw')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.log.draw') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/draw')?>">抽奖记录</a></li>
    <?php  } ?>
</ul>

<?php if(cv('creditshop.comment|creditshop.comment.add|creditshop.comment.edit|creditshop.comment.check')) { ?>
<div class='menu-header'>评价管理</div>
<ul>
    <?php if(cv('creditshop.comment|creditshop.comment.add|creditshop.comment.edit')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.comment'||$_GPC['r']=='creditshop.comment.add'||$_GPC['r']=='creditshop.comment.edit') { ?> class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/comment')?>">全部评价</a></li>
    <?php  } ?>
    <?php if(cv('creditshop.comment.check')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.comment.check') { ?> class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/comment/check')?>">待审核</a></li>
    <?php  } ?>
</ul>
<?php  } ?>

<?php if(cv('creditshop.log.order|creditshop.log.convey|creditshop.log.finish')) { ?>
    <div class='menu-header'>发货管理</div>
    <ul>
        <?php if(cv('creditshop.log.order')) { ?>
            <li <?php  if($_GPC['r']=='creditshop.log.order') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/order')?>">待发货</a></li>
        <?php  } ?>
    </ul>
    <ul>
        <?php if(cv('creditshop.log.convey')) { ?>
            <li <?php  if($_GPC['r']=='creditshop.log.convey') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/convey')?>">待收货</a></li>
        <?php  } ?>
    </ul>
    <ul>
        <?php if(cv('creditshop.log.finish')) { ?>
            <li <?php  if($_GPC['r']=='creditshop.log.finish') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/finish')?>">已完成</a></li>
        <?php  } ?>
    </ul>
<?php  } ?>
<?php if(cv('creditshop.log.verifying|creditshop.log.verifyover|creditshop.log.verify')) { ?>
    <div class='menu-header'>核销管理</div>
    <ul>
        <?php if(cv('creditshop.log.verify')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.log.verify') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/verify')?>">全部核销</a></li>
        <?php  } ?>
    </ul>
    <ul>
        <?php if(cv('creditshop.log.verifying')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.log.verifying') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/verifying')?>">待核销</a></li>
        <?php  } ?>
    </ul>
    <ul>
        <?php if(cv('creditshop.log.verifyover')) { ?>
        <li <?php  if($_GPC['r']=='creditshop.log.verifyover') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/log/verifyover')?>">已核销</a></li>
        <?php  } ?>
    </ul>
<?php  } ?>

<?php if(cv('creditshop.cover|creditshop.notice|creditshop.set')) { ?>
    <div class='menu-header'>设置</div>
    <ul>
        <?php if(cv('creditshop.cover')) { ?>
            <li <?php  if($_W['action']=='cover') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/cover')?>">入口设置</a></li>
        <?php  } ?>
        <?php if(cv('creditshop.notice' && $_W['merchid']==0)) { ?>
            <li  <?php  if($_W['action']=='notice') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/notice')?>">通知设置</a></li>
        <?php  } ?>
        <?php if(cv('creditshop.set' && $_W['merchid']==0)) { ?>
            <li <?php  if($_W['action']=='set') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('creditshop/set')?>">基础设置</a></li>
        <?php  } ?>
    </ul>
<?php  } ?>
<!--913702023503242914-->