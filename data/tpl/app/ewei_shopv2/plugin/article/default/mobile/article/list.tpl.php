<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script>document.title = "<?php  if(!empty($article_sys['article_title'])) { ?><?php  echo $article_sys['article_title'];?><?php  } else { ?><?php  echo $_W['shopset']['shop']['name'];?><?php  } ?>"; </script>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/article/template/mobile/default/images/mobile.css" />
<div class='fui-page  fui-page-current article-list-page'>

	<?php  if(is_h5app()) { ?>
	<div class="fui-header">
		<div class="fui-header-left">
			<a href="<?php  echo mobileUrl()?>"><i class="icon icon-home"></i></a>
		</div>
		<div class="title"><?php  if(!empty($article_sys['article_title'])) { ?><?php  echo $article_sys['article_title'];?><?php  } else { ?><?php  echo $_W['shopset']['shop']['name'];?><?php  } ?></div>
		<div class="fui-header-right"></div>
	</div>
	<?php  } ?>

	<div class='fui-content'>
		
		<?php  if($article_sys['article_temp']==2) { ?>
			<div class="fui-article-list template-2">
				<div class="fui-tab-scroll" id="listTab">
					<div class='container'>
						<span class='item on' data-cateid="">全部分类</span>
							<?php  if(is_array($categorys)) { foreach($categorys as $i => $category) { ?>
								<span class='item' data-cateid="<?php  echo $category['id'];?>"><?php  echo $category['category_name'];?></span>
							<?php  } } ?>
					</div>
				</div>
				<div class="fui-list-group" id='container'></div>  
			</div>
		<?php  } else { ?>
			<div class="fui-article-list template-<?php  echo $article_sys['article_temp'];?>" id="container"></div>
		<?php  } ?>
		<div class='infinite-loading' style="text-align: center; color: #666; display: none;">
	    	<span class='fui-preloader'></span>
	    	<span class='text'> 正在加载...</span>
	    </div>
	    <div class="fui-message fui-message-popup in content-empty" style="display: none; margin-top: 0; position: relative; height: auto; background: none;">
				<div class="icon ">
					<i class="icon icon-information"></i>
				</div>
				<div class="content">未找到文章~</div>
		</div>
		
	</div>
	<script language="javascript">
	     require(['../addons/ewei_shopv2/plugin/article/static/js/list.js'],function(modal){ 
	     	modal.init({template: "<?php  echo $article_sys['article_temp'];?>"});
	     });
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--913702023503242914-->