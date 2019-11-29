<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style type='text/css'>
	.feed-activity-list {
		width: 100%;
		overflow: hidden;
		padding-top: 10px;
		padding-bottom: 10px;
		border-bottom: 1px solid #f2f2f2
	}
	
	.feed-element {
		float: left;
		cursor: pointer;
		width: 400px;
		padding: 10px;
		margin: 0;
		margin-right: 10px;
		margin-left: 10px;
		border: none;
	}
	
	.feed-element::after {
		display: none
	}
	
	.feed-element .title {
		font-size: 14px;
		font-weight: bold;
		height: 32px;
		margin-top: 10px;
	}
	
	.feed-activity-list .feed-element {
		border: none;
		border-right: 1px solid #f2f2f2;
	}
	
	.feed-element img.img-circle,
	.dropdown-messages-box img.img-circle {
		width: 60px;
		height: 60px;
		border-radius: 10px;
	}
	
	.media-body {
		margin-top: 3px;
	}
</style>
<div class="page-heading">
	<?php  if($permPlugin || $_W['role'] == 'founder') { ?>
    <span class='pull-right' style="display: none;">
        <a class='btn btn-default btn-sm' href="<?php  echo webUrl('grant')?>">授权应用中心</a>
    </span>
	<?php  } ?>
	<h2>我的应用</h2> 
</div>

<div class='panel panel-default' style='border:none;'>
	<?php  if($permPlugin || $_W['role'] == 'founder') { ?>
		<?php  if(!empty($setting['adv'])) { ?>
		<a href="<?php  echo webUrl('grant')?>">
			<img src="<?php  echo tomedia($setting['adv'])?>" width="100%" alt="授权应用中心">
		</a>
		<?php  } ?>
	<?php  } ?>
	<?php  if(p("grant") && !empty($pluginsetting['adv'])) { ?>
	<a href="<?php  echo webUrl('plugingrant')?>">
		<img src="<?php  echo tomedia($pluginsetting['adv'])?>" width="100%" alt="授权应用中心">
	</a>
	<?php  } ?>
	<?php  if(is_array($category)) { foreach($category as $ck => $cv) { ?>
		<?php  if(count($cv['plugins'])<=0) { ?><?php  continue;?><?php  } ?> 
		<div class="panel-heading" style='background:none;border:none;'>
			<?php  echo $cv['name'];?>
		</div>
		<div class="feed-activity-list">
			<?php  if(is_array($cv['plugins'])) { foreach($cv['plugins'] as $plugin) { ?>
				<?php  if(com_run('perm::check_plugin',$plugin['identity'])) { ?>
				<?php if(cv($plugin['identity'])) { ?>
					<div class="feed-element" onclick="location.href='<?php  echo webUrl($plugin['identity'])?>'">
						<span class="pull-left" style="position: relative;">
							<img src="<?php echo empty($plugin['thumb'])?'../addons/ewei_shopv2/static/images/plugin.png': tomedia($plugin['thumb'])?>" class="img-circle" alt="image">
						</span>
						<div class="media-body ">
							<span class="title"><?php  echo $plugin['name'];?></span>
							<?php  if($_W['role'] != 'founder' && $plugin['isgrant']>0) { ?>

							<Script Language="JavaScript">
							<!-- Begin
							var timedate= new Date(<?php  echo $plugin['permendtime'];?>*1000);
							var times="研究生考试";
							var now = new Date();
							var date = timedate.getTime() - now.getTime();
							var time = Math.floor(date / (1000 * 60 * 60 * 24));
							if (time >= 0) {
							    if(time <=30){
                                    document.write("授权剩余：<span style='font-size:12px;color:#fff;background: #ed5565 ;padding:2px 5px;display:inline-block;border-radius: 3px;'>"+time +"天</span>");
								}else{
                                    document.write("授权剩余：<span style='font-size:12px;color:#fff;background: #3c9be1 ;padding:2px 5px;display:inline-block;border-radius: 3px;'>"+time +"天</span>");
								}
							}else{
                                document.write("授权已过期");
							};
							// End -->
							</Script>
							<?php  } else if($_W['role'] != 'founder' && $plugin['isplugingrant']>0) { ?>
							<script type="text/javascript">
                                var timedate= new Date(<?php  echo $plugin['permendtime'];?>*1000);
                                var month = <?php  echo $plugin['month'];?>;
                                var isperm = <?php  echo $plugin['isperm'];?>;
                                var now = new Date();
                                var date = timedate.getTime() - now.getTime();
                                var time = Math.floor(date / (1000 * 60 * 60 * 24 * 30));
                                if(month==0){
									if(isperm==0){
                                        document.write("授权已过期");
									}
								}else{
                                    if(time >= 0){
                                        if(time <=1){
                                            document.write("授权剩余：<span style='font-size:12px;color:#fff;background: #ed5565 ;padding:2px 5px;display:inline-block;border-radius: 3px;'>"+1 +"月</span>");
                                        }else{
                                            document.write("授权剩余：<span style='font-size:12px;color:#fff;background: #3c9be1 ;padding:2px 5px;display:inline-block;border-radius: 3px;'>"+time +"月</span>");
                                        }
									}
								};
							</script>
							<?php  } ?>
							<br>
							<small class="text-muted"><?php  echo $plugin['desc'];?></small>
						</div>
					</div>
				<?php  } ?>
				<?php  } ?>
			<?php  } } ?>
		</div>
	<?php  } } ?>
</div>
<script>
	$(document).ready(function () {
		$('.feed-activity-list,.plugin_tabs').each(function(){
			if($(this).children().length<=0){
				$(this).prev().remove();
				$(this).remove();
			}
		});
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->