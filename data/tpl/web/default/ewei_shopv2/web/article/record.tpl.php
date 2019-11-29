<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-heading">
	<span class="pull-right">
		<a class="btn btn-default  btn-sm" href="<?php  echo webUrl('article')?>">返回列表</a>
	</span>
	<h2>数据统计</h2>
</div>
 <div class="panel panel-default" style="margin-top:10px;">
	 <div class="panel-body">
            <p>文章标题：<?php  echo $article['article_title'];?></p>
            <p>文章分类：<?php  echo $article['category_name'];?></p>
            <p>触发关键字：<?php  echo $article['article_keyword'];?></p>
            <p>创建时间：<?php  echo $article['article_date'];?></p>
			<p>奖励模式：<?php  if($article['article_advance']) { ?><span class="text-danger">高级模式</span><?php  } else { ?><span class="text-info">普通模式</span><?php  } ?></p>
            <p>阅读量(真实+虚拟=总数)：<?php  echo intval($article['article_readnum'])?> + <?php  echo intval($article['article_readnum_v'])?> = <?php  echo intval($article['article_readnum_v'])+intval($article['article_readnum'])?></p>
            <p>点赞数(真实+虚拟=总数)：<?php  echo intval($article['article_likenum'])?> + <?php  echo intval($article['article_likenum_v'])?> = <?php  echo intval($article['article_likenum_v'])+intval($article['article_likenum'])?></p>
           </div>
	 
	 <?php  if($article['article_advance']) { ?>
	 <div class="panel-body">
	   <p> <span class="text-danger"><b>高级模式:</b></span>	 
	   <p>发放积分: <span class="text-danger"><b><?php  echo intval($add_credit1)?></b></span>
            <p>发放余额: <span class="text-danger"><b><?php  echo intval($add_money1)?></b></span>
           </div>
	 <?php  } ?>
	 
	 
	 <div class="panel-body">
	    <p>实际发放积分: <span class="text-danger"><b><?php  echo intval($add_credit)?></b></span> 个积分
            <p>实际发放余额: <span class="text-danger"><b><?php  echo intval($add_money)?></b></span> 元余额
           </div>
	 
	 
        </div>

<ul class="nav nav-arrow-next nav-tabs" id="myTab" style="margin-bottom:10px;">
                    <li <?php  if($_GPC['type']=='read' || empty($_GPC['type'])) { ?>class="active"<?php  } ?> ><a href="<?php  echo webUrl('article/record', array('type'=>'read','aid'=>$article['id']))?>">阅读及点赞记录</a></li>
                    <li <?php  if($_GPC['type']=='share') { ?>class="active"<?php  } ?> ><a href="<?php  echo webUrl('article/record', array('type'=>'share','aid'=>$article['id']))?>">分享记录</a></li>
</ul>

 

<?php  if($type == 'read') { ?>

        <table class="table">
            <thead>
                <tr>
                    <th style="width:80px;">记录ID</th>
                    <th style="width:300px;">会员昵称</th>
                    <th style="width:100px; text-align:center;">阅读次数</th>
                    <th style="width:100px; text-align:center;">点赞状态</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                 <?php  if(empty($list_reads)) { ?>
                        <tr>
                            <td  colspan="5" style="line-height:30px;">没有查询到记录！</td>
                        </tr>
                 <?php  } else { ?>
                    <?php  if(is_array($list_reads)) { foreach($list_reads as $list_read) { ?>
                       <tr style="border-bottom:0px;">
                           <td><?php  echo $list_read['id'];?></td>
                           <td>
                           		<?php  if(!empty($list_read['nickname'])) { ?>
                           			<a href="<?php  echo webUrl('member/list/detail', array('id'=>$list_read['mid']))?>" target="_blank"><?php  echo $list_read['nickname'];?></a>
                           		<?php  } else { ?>* 未更新用户信息<?php  } ?>
                           </td>
                           <td style="text-align:center;"><?php  echo $list_read['read'];?></td>
                           <td style="text-align:center;">
                           <?php  if($list_read['like']==1) { ?>
                               <label class="label label-success">已点赞</label>
                           <?php  } else { ?>
                               <label class="label label-default">未点赞</label>
                           <?php  } ?>
                           </td>
                           <td></td>
                       </tr>
                   <?php  } } ?>
                  
                <?php  } ?>
            </tbody>
        </table>
<?php  echo $pager;?>
<?php  } else if($type == 'share') { ?>

        <table class="table">
                    <thead>
                        <tr>
                            <th style="width:80px;">记录ID</th>
                            <th style="width:140px;">分享者</th>
                            <th style="width:140px;">点击者</th>
                            <th style="width:180px;">点击时间</th>
                            <th style="width:150px;">分享者所获的积分</th>
                            <th style="width:150px;">分享者所获的余额</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php  if(empty($list_shares)) { ?>
                        <tr>
                            <td  colspan="7" style="line-height:30px;">没有查询到记录！</td>
                        </tr>
                        <?php  } else { ?>
                            <?php  if(is_array($list_shares)) { foreach($list_shares as $list_share) { ?>
                                <tr style="border-bottom:0px;">
                                    <td><?php  echo $list_share['id'];?></td>
                                    <td>
                                    	<?php  if(!empty($list_share['share_user'])) { ?>
                                    		<a href="<?php  echo webUrl('member/list/detail', array('id'=>$list_share['share_id']))?>" target="_blank"><?php  echo $list_share['share_user'];?></a>
                                    	<?php  } else { ?>* 未更新用户信息<?php  } ?>
                                    </td>
                                    <td>
                                    	<?php  if(!empty($list_share['click_user'])) { ?>
                                    		<a href="<?php  echo webUrl('member/list/detail', array('id'=>$list_share['click_id']))?>" target="_blank"><?php  echo $list_share['click_user'];?></a>
                                    	<?php  } else { ?>* 未更新用户信息<?php  } ?></td>
                                    <td><?php  echo date("Y-m-d H:m:s",$list_share['click_date'])?></td>
                                    <td><?php  echo $list_share['add_credit'];?></td>
                                    <td><?php  echo $list_share['add_money'];?>元</td>
                                    <td></td>
                                </tr>
                            <?php  } } ?>
                  
                        <?php  } ?>
                    </tbody>
        </table>
 <?php  echo $pager;?>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--913702023503242914-->