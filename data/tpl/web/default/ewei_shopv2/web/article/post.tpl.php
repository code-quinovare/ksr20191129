<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left = true;?> 
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link href="../addons/ewei_shopv2/plugin/article/static/css/article.css" rel="stylesheet">
<style type='text/css'>
	.tabs-container .form-group {overflow: hidden;}
	.tabs-container .tabs-left > .nav-tabs {width: 120px;}
	.tabs-container .tabs-left .panel-body {margin-left: 120px; width: 880px; text-align: left;}	
	.tab-article .nav li {width: 120px; text-align: right;}
	.popover {left: 0;}
	#source-container {position: relative;}
</style>
<form action="" <?php if( ce('article' ,$article) ) { ?>method="post" <?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
	<input type="hidden" name="aid" value="<?php  echo $aid;?>" />
	<input type="hidden" id="tab" name="tab" value="#tab_<?php  echo $_GPC['tab'];?>" />
	<div class="page-heading">
		<span class='pull-right'>
			<?php if( ce('article' ,$article) ) { ?>
				<input type="submit" value="保存文章" class="btn btn-primary btn-sm" onclick='return save()'/>
			<?php  } ?>
			
			<?php if(cv('article.add')) { ?>
				<a class="btn btn-success  btn-sm" href="<?php  echo webUrl('article/add')?>" >添加文章</a> 
			<?php  } ?>
             
            <a class="btn btn-default  btn-sm" href="<?php  echo webUrl('article')?>">返回列表</a>
		</span>
		<h2><?php  if(!empty($article['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>文章 <small><?php  if(!empty($article['id'])) { ?>编辑【<?php  echo $article['article_title'];?>】<?php  } ?></small></h2>
	</div>

	<div class='row'>
		
		<div class="col-sm-5" style='padding-right:5px;'>
			<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/preview', TEMPLATE_INCLUDEPATH)) : (include template('article/post/preview', TEMPLATE_INCLUDEPATH));?>
		</div>

		<div class="col-sm-7" style='padding-left:5px;position:relative'>
			<ul class="nav nav-tabs" id="myTab">
				<li <?php  if(empty($_GPC[ 'tab']) || $_GPC[ 'tab']=='basic' ) { ?>class="active" <?php  } ?>><a href="#tab_basic">基本</a></li>
				<li <?php  if($_GPC[ 'tab']=='content' ) { ?>class="active" <?php  } ?>><a href="#tab_content">内容</a></li>
				<li <?php  if($_GPC[ 'tab']=='reward' ) { ?>class="active" <?php  } ?>><a href="#tab_reward">奖励</a></li>
				<li <?php  if($_GPC[ 'tab']=='spread' ) { ?>class="active" <?php  } ?>><a href="#tab_spread">推广</a></li>
				<li <?php  if($_GPC[ 'tab']=='visit' ) { ?>class="active" <?php  } ?>><a href="#tab_visit">访问权限</a></li>
				<?php  if($_GPC['advance']==1) { ?>
				    <li <?php  if($_GPC[ 'tab']=='advance' ) { ?>class="active" <?php  } ?>><a href="#tab_advance">高级模式</a></li>
				<?php  } ?>
			</ul>

			<a id="link_source" class="btn btn-warning btn-sm" href="javascript:;" style="position: absolute;top:0px;right:20px; <?php  if($_GPC['tab']!='content') { ?>display: none;<?php  } ?>"><i class="fa fa-picture-o"></i> 素材库</a>

			<div class="tab-content ">
				<div class="tab-pane <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>active<?php  } ?> " id="tab_basic">
					<div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/basic', TEMPLATE_INCLUDEPATH)) : (include template('article/post/basic', TEMPLATE_INCLUDEPATH));?></div>
				</div>
				<div class="tab-pane <?php  if($_GPC['tab']=='content') { ?>active<?php  } ?>" id="tab_content"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/content', TEMPLATE_INCLUDEPATH)) : (include template('article/post/content', TEMPLATE_INCLUDEPATH));?></div>
				<div class="tab-pane  <?php  if($_GPC['tab']=='reward') { ?>active<?php  } ?> " id="tab_reward">
					<div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/reward', TEMPLATE_INCLUDEPATH)) : (include template('article/post/reward', TEMPLATE_INCLUDEPATH));?></div>
				</div>
				<div class="tab-pane   <?php  if($_GPC['tab']=='spread') { ?>active<?php  } ?>" id="tab_spread">
					<div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/spread', TEMPLATE_INCLUDEPATH)) : (include template('article/post/spread', TEMPLATE_INCLUDEPATH));?></div>
				</div>
				<div class="tab-pane   <?php  if($_GPC['tab']=='visit') { ?>active<?php  } ?>" id="tab_visit">
					<div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/visit', TEMPLATE_INCLUDEPATH)) : (include template('article/post/visit', TEMPLATE_INCLUDEPATH));?></div>
				</div>
				<?php  if($_GPC['advance']==1) { ?>
				<div class="tab-pane   <?php  if($_GPC['tab']=='advance') { ?>active<?php  } ?>" id="tab_advance">
					<div class="panel-body"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('article/post/advance', TEMPLATE_INCLUDEPATH)) : (include template('article/post/advance', TEMPLATE_INCLUDEPATH));?></div>
				</div>
				<?php  } ?>
			</div>

		</div>
	</div>

</form>
<script type="text/javascript">
	$(function() {
		$(':input[name=article_date_v]').attr('bind-in', 'art_date_v');
		$("input").bind('input propertychange', function() {
			pagestate = 1;
			var bindint = $(this).attr("bind-in");
			var bindnum = $(this).attr("bind-num");
			var bindinfo = !$(this).val() ? $(this).attr("bind-de") : $(this).val();
			if (bindnum == '1' && parseInt(bindinfo) > 100000) {
				bindinfo = '100000+';
			}
			$("*[bind-to=" + bindint + "]").text(bindinfo);
		});
	})
	require(['bootstrap'], function() {
		var source_content = "";
		window.source_color = '';
		$('#myTab a').click(function(e) {
			$('#tab').val($(this).attr('href'));
			e.preventDefault();
			$(this).tab('show');
			if($(this).attr('href')=='#tab_content'){
				$("#link_source").show();
			}else{
				$("#link_source").hide();
				$('#link_source').popover('hide');
			}
		});
		//素材库
		$('#link_source').popover({
			html: true,
			content: '<div id="source-container"><i class="fa fa-spinner fa-spin "></i> 加载中...</div>',
			placement: 'bottom'
		});

		function setSourceColor() {
			if (window.source_color != '') {
				$(".itembox .tc").css("color", window.source_color);
				$(".itembox .bc").css("background-color", window.source_color);
				$(".itembox .bdc").css("border-color", window.source_color);
				$(".itembox .blc").css("border-left-color", window.source_color);
				$(".itembox .btc").css("border-top-color", window.source_color);
				$(".itembox .bbc").css("border-bottom-color", window.source_color);
				$(".itembox .brc").css("border-right-color", window.source_color);
				$('.color').val(window.source_color);
			}
		}
		setInterval(function() {
			$('[bind-to=art_date_v]').html($(':input[name=article_date_v]').val());
			if ($('#link_source').next().hasClass('popover')) {
				if (source_content == '') {
					$.ajax({
						url: "<?php  echo webUrl('article/source')?>",
						cache: false,
						success: function(html) {
							source_content = html;
						},
						async: false
					});
				}
				if ($('#source-container').find('.itembox').length <= 0) {
					$('#source-container').html(source_content).css('width', '560px');
					setSourceColor();
					$(".color").change(function() {
						window.source_color = $(this).val();
						setSourceColor();
					});
					$(".itembox").click(function(a) {
						UE.getEditor('editor').execCommand("insertHtml", "<div>" + $(this).html() + "<p></p>" + "</div>");
					});
					$('#sourceTab a').click(function(e) {
						e.preventDefault();
						$(this).tab('show');
					});
					$('#link_source').next().css({
						'left': '0',
						'min-width': '600px'
					}).find('.arrow').css('left', "90%");
				}
			} else {
			}
		}, 1000);
	});
	
	function save(){
		var category = $("select[name=article_category] option:selected").val();
		if(category==0){
			$('#myTab a[href="#tab_basic"]').tab('show');
			tip.msgbox.err("请选择文章分类!");
			$("select[name=article_category]").focus();
			return false;
		}
	}
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->