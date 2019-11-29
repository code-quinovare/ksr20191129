<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script>document.title = "<?php  echo $_W['shopset']['shop']['name'];?>"; </script>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/article/template/mobile/default/images/mobile.css" />
<div class='fui-page  fui-page-current article-index-page'>

	<?php  if(is_h5app()) { ?>
	<div class="fui-header">
		<div class="fui-header-left">
			<a class="back"></a>
		</div>
		<div class="title"><?php  echo $_W['shopset']['shop']['name'];?></div>
		<div class="fui-header-right"></div>
	</div>
	<?php  } ?>

	<div class='fui-content'>
		
		<div class="fui-article-page">
			
			<div class="fui-article-title"><?php  echo $article['article_title'];?></div>
			<div class="fui-article-subtitle"><?php  if(!empty($article['article_mp'])) { ?><a href="<?php  if(!empty($_W['shopset']['share']['followurl'])) { ?><?php  echo $_W['shopset']['share']['followurl'];?><?php  } else { ?>javascript:;<?php  } ?>"><?php  echo $article['article_mp'];?></a> 发布时间: <?php  echo $article['article_date_v'];?><?php  if(!empty($article['article_author'])) { ?> 作者: <?php  echo $article['article_author'];?><?php  } ?> <?php  } ?> </div>
			<!-- 关注提示 -->
			<?php  if(!$followed && !empty($_W['shopset']['share']['followurl'])) { ?>
				<div class="fui-list-group external" onclick="location.href='<?php  echo $_W['shopset']['share']['followurl'];?>'">
					<div class="fui-list">
						<div class="fui-list-media">
							<img class="round" src="<?php  echo tomedia($_W['shopset']['shop']['logo'])?>">
						</div>
						<div class="fui-list-inner">
							<div class="title"><?php  if(!empty($article['article_mp'])) { ?> <?php  echo $article['article_mp'];?> <?php  } else { ?> <?php  echo $_W['shopset']['shop']['name'];?> <?php  } ?></div>
							<div class="subtitle"><?php  echo $_W['shopset']['shop']['description'];?></div>
						</div>
						<div class="fui-list-angle" style="width: 3rem; margin-right: 0;display: -webkit-box; display: -webkit-flex; display: -ms-flexbox; display: flex; flex-shrink: 0; flex-wrap: nowrap;">
							<div class="btn btn-sm btn-success" style="width: inherit; padding: 0;" onclick="location.reload()"><i class="icon icon-add"></i>关注</div>
						</div>
					</div>
				</div>
			<?php  } ?>
			<div class="fui-article-content">
				<?php  if(!empty($article['article_areas'])) { ?>
					<div class="fui-article-gps">
						<p><i class="icon icon-address"></i> 正在获取地理位置...</p>
						<p>请开启GPS并允许获取位置信息</p>
					</div>
					<div class="fui-article-notread">
						<p>此文章内容仅限指定区域内用户查看</p>
						<p>(请开启GPS并允许获取位置信息)</p>
					</div>
				<?php  } else { ?>
					<?php  echo $article['article_content'];?>
				<?php  } ?>
			</div>
			
			<div class="fui-article-subtitle">
				<div class="nav"><i class="icon icon-person2"></i> <?php  echo $readnum;?> </div>
				<div class="nav padding" <?php  if(!empty($openid) && is_weixin()) { ?>id="likebtn" data-num="<?php  echo $likenum;?>" data-state="<?php  if(!empty($state['like'])) { ?>1<?php  } else { ?>0<?php  } ?>"<?php  } ?>>
					<i class="icon <?php  if(!empty($state['like']) && is_weixin()) { ?>icon-likefill text-danger<?php  } else { ?>icon-like<?php  } ?>"></i>
					<span><?php  echo $likenum;?></span>
				</div>
				<?php  if(!empty($article['article_linkurl'])) { ?>
					<div class="nav" style="line-height: 1.3rem; color: ; margin-left: 0.4rem;" onclick="location.href='<?php  echo $article['article_linkurl'];?>'">查看原文 </div>
				<?php  } ?>
				<?php  if($article['article_report']==1 && !empty($openid) && is_weixin()) { ?>
					<a class="nav right" href="<?php  echo mobileUrl('article/report', array('aid'=>$article['id']))?>">投诉</a>
				<?php  } ?>
			</div>
			
		</div>

		<?php  if($article['product_advs_type']!=0 && !empty($advs)) { ?>
			<?php  if(!empty($article['product_advs_title'])) { ?>
				<div class="fui-line title">
					<div class="text"><?php  echo $article['product_advs_title'];?></div>
				</div>
			<?php  } ?>
			<div class="swipe">
				<div class="inner">
					<div data-transition="500" class="fui-swipe">
						<div class="fui-swipe-wrapper">
							<?php  if(is_array($advs)) { foreach($advs as $adv) { ?>
								<?php  if(!empty($adv['img'])) { ?>
									<a href="<?php  if(empty($adv['link'])) { ?>javascript:;<?php  } else { ?><?php  echo $adv['link'];?><?php  } ?>" class="fui-swipe-item external">
										<img src="<?php  echo $adv['img'];?>">
									</a>
								<?php  } ?>
							<?php  } } ?>
						</div>
						<div class='fui-swipe-page'></div>
					</div>
				</div>
			</div>
			<?php  if(!empty($article['product_advs_more'])) { ?>
				<div class="fui-line subtitle link">
					<a class="text external" href="<?php  if(!empty($article['product_advs_link'])) { ?><?php  echo $article['product_advs_link'];?><?php  } else { ?>javascript:;<?php  } ?>"><?php  echo $article['product_advs_more'];?> </a>
				</div>
			<?php  } ?>
		<?php  } ?>
	</div>
	<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=ZQiFErjQB7inrGpx27M1GR5w3TxZ64k7&s=1"></script>
	<script language="javascript">
	     require(['../addons/ewei_shopv2/plugin/article/static/js/common.js'],function(modal){
	     	modal.init({aid: "<?php  echo $article['id'];?>", areas: <?php  echo json_encode($article['areas'])?>, shareid: "<?php  echo $_GPC['shareid'];?>"});
	     });
	</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--NDAwMDA5NzgyNw==-->