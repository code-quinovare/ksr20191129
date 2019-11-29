<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/sns/template/mobile/default/images/common.css" />
<div class='fui-page  fui-page-current'>
	<?php  if(is_h5app()) { ?>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title"><?php  echo m('plugin')->getName('sns')?></div>
		<div class="fui-header-right"></div>
	</div>
	<?php  } ?>
	<div class='fui-content navbar'>

		<?php  if(!empty($advs)) { ?>
			<div class='fui-swipe' data-transition="500" data-gap="1">
			    <div class='fui-swipe-wrapper'>
				<?php  if(is_array($advs)) { foreach($advs as $adv) { ?>
					<a class='fui-swipe-item external' href="<?php  if(!empty($adv['link'])) { ?><?php  echo $adv['link'];?><?php  } else { ?>javascript:;<?php  } ?>"><img src="<?php  echo tomedia($adv['thumb'])?>" /></a>
				<?php  } } ?>
			    </div>
			    <div class='fui-swipe-page'></div>
			</div>
		<?php  } ?>


		<?php  if(count($category)>0) { ?>
			<div class="fui-icon-group noborder circle" style="margin-top:0;">
				<?php  if(is_array($category)) { foreach($category as $cate) { ?>
					<a href="<?php  echo mobileUrl('sns/board/lists', array('cid'=>$cate['id'],'page'=>1))?>" data-nocache="true">
						<div class="fui-icon-col">
							<div class="icon"><img data-lazy="<?php  echo tomedia($cate['thumb'])?>"/></div>
							<div class="text"><?php  echo $cate['name'];?></div>
						</div>
					</a>
				<?php  } } ?>
			</div>
		<?php  } ?>

		<div class="fui-cell-group qa-title">
			<div class="fui-cell">
				<div class="fui-cell-text">推荐版块</div>
				<a class="fui-cell-remark external" href="<?php  echo mobileUrl('sns/board/lists')?>">全部</a>
			</div>
		</div>

		<div class="fui-list-group" style="margin-top:0;">
			<?php  if(is_array($recommands)) { foreach($recommands as $value) { ?>
			<a class="fui-list external" href="<?php  echo mobileUrl('sns/board',array('id'=>$value['id']))?>">
				<div class="fui-list-media">
					<img data-lazy="<?php  echo tomedia($value['logo'])?>" class="round">
				</div>
				<div class="fui-list-inner">
					<div class="row">
						<div class="row-text"><?php  echo $value['title'];?></div>
						<div class="angle"></div>
					</div>
					<div class='text'>话题数: <span class='text-danger'><?php  echo $value['postcount'];?></span> 关注数:<span class="text-danger"><?php  echo $value['followcount'];?></span></div>
					<div class="text"><?php  echo $value['desc'];?></div>
				</div>
			</a>
			<?php  } } ?>
		</div>
     	<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
	</div>
</div>
<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--NDAwMDA5NzgyNw==-->