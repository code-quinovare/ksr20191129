<?php defined('IN_IA') or exit('Access Denied');?><div class='menu-header'><?php  echo $this->plugintitle?></div>
<ul>
    <li <?php  if($_W['routes']=='pc.shop') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('pc/shop')?>">站点设置</a></li>
    <li <?php  if($_W['routes']=='pc.link') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('pc/link')?>">友情链接</a></li>
</ul>

<div class='menu-header'>菜单管理</div>
<ul>
    <li <?php  if($_W['routes']=='pc.menu' && empty($_GPC['type'])) { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('pc/menu')?>">顶部菜单</a>
    </li>
    <li <?php  if($_W['routes']=='pc.menu' && $_GPC['type']==1) { ?>class="active"<?php  } ?>><a
                href="<?php  echo webUrl('pc/menu',array('type'=>1))?>">底部菜单</a></li>
    <li <?php  if($_W['routes']=='pc.menu' && $_GPC['type']==2) { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('pc/menu',array('type'=>2))?>">客户服务</a></li>
</ul>

<div class='menu-header'>广告管理</div>
<ul>
    <li <?php  if($_W['routes']=='pc.slide') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('pc/slide')?>">首页轮播</a></li>
    <li <?php  if($_W['routes']=='pc.recommend') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('pc/recommend')?>">精品推荐</a></li>
    <li <?php  if($_W['routes']=='pc.adv') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('pc/adv')?>">广告管理</a></li>
</ul>
<div class='menu-header'>帮助中心</div>
<ul>
    <li <?php  if($_W['routes']=='qa.category') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('qa/category')?>">文章分类</a></li>
    <li <?php  if($_W['routes']=='qa.question') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('qa/question')?>">文章管理</a></li>
    <li <?php  if($_W['routes']=='shop.notice') { ?>class="active"<?php  } ?>><a href="<?php  echo webUrl('shop/notice')?>">公告管理</a></li>
</ul>