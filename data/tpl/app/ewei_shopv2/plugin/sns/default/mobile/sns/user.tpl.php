<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/sns/template/mobile/default/images/common.css"/>
<div class='fui-page fui-page-current  fui-page-current user-info-page'>

    <?php  if(is_h5app()) { ?>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title"><?php  echo m('plugin')->getName('sns')?></div>
        <div class="fui-header-right"></div>
    </div>
    <?php  } ?>

    <div class="fui-content navbar">
             <div class="user-bg">
                 <img data-lazy="../addons/ewei_shopv2/plugin/sns/template/mobile/default/images/userbg.png" class="bg" style="display: block"/>
                 <img data-lazy="<?php  echo $member['avatar'];?>" class="head" />
                 <?php  if(!is_h5app()) { ?>
                 <a class="back" data-nocache="true"><i class="icon icon-back1"></i></a>
                 <?php  } ?>
             </div>
        <div class="user-info">
            <span class="nickname"><?php  echo $member['nickname'];?></span>
            <span class="label">
                <span class="level-label fui-label fui-label-default level-label" style="background:<?php  echo $level['bg'];?>;color:<?php  echo $level['color'];?>"><?php  echo $level['levelname'];?></span>
            </span>
            <span class="post">
                话题数: <?php  echo $postcount;?> 关注数: <?php  echo $followcount;?> <br/>
                社区积分: <?php  echo $member['sns_credit'];?>
                <?php  if(!empty($set['crediturl'])) { ?>
                <a href="<?php  echo $set['crediturl'];?>"><i class="icon icon-question"></i></a>
                <?php  } ?>
            </span>
            <span class="sign">
               <i class="icon icon-we" ></i>
                <?php  if(empty($member['sns_sign'])) { ?>
                <span class="sign-content">这个家伙什么也没留下~~</span>

                <?php  } else { ?><span class="sign-content"><?php  echo $member['sns_sign'];?></span><?php  } ?>

                 <?php  if($member['openid']==$_W['openid']) { ?>
                <a href="#" onclick="$('#edit-sign').show();"><i class="icon icon-edit2"></i></a>
                <?php  } ?>

            </span>
        </div>
        <?php  if($boardcount>0) { ?>
        <div class="user-history">

            <div class="fui-line" style="text-align: center;" >
                <div class="fui-list-inner"  style="margin:auto;display: inline;background:#fafafa;padding:0 .2rem;"><?php  if($openid==$_W['openid']) { ?>我的<?php  } else { ?>TA的<?php  } ?>版块</div>
            </div>
            <div class="boards" >
                <?php  if(is_array($boards)) { foreach($boards as $k => $v) { ?>
                    <a class="board-item" href="<?php  echo mobileUrl('sns/board',array('id'=>$v['id'],'page'=>1))?>" data-nocache="true">
                       <img data-lazy="<?php  echo $v['logo'];?>"/>
                        <div class="text"><?php  echo $v['title'];?></div>
                    </a>
                <?php  } } ?>
            </div>
            <?php  if($boardcount>=5) { ?>
            <a class="post-more" href="<?php  echo mobileUrl('sns/user/boards',array('id'=>$member['id']))?>" style="padding:.5rem 0"  data-nocache="true">查看更多</a>
            <?php  } ?>
        </div>
        <?php  } ?>


        <?php  if(count($posts)>0) { ?>

        <div class="user-history">

            <div class="fui-line" style="text-align: center;" >
                <div class="fui-list-inner"  style="margin:auto;display: inline;background:#fafafa;padding:0 .2rem;"><?php  if($openid==$_W['openid']) { ?>我的<?php  } else { ?>TA的<?php  } ?>话题</div>
            </div>
            <div class="fui-list-group">
                <?php  if(is_array($posts)) { foreach($posts as $value) { ?>
                <a class="fui-list" href="<?php  echo mobileUrl('sns/post',array('id'=>$value['id']))?>" data-nocache="true">
                    <div class="fui-list-media">
                        <img data-lazy="<?php  echo tomedia($value['thumb'])?>">
                    </div>
                    <div class="fui-list-inner">
                        <div class="row">
                            <div class="row-text"><?php  echo $value['title'];?></div>
                            <div class="angle"></div>
                        </div>
                        <div class='text'><?php  echo $value['boardtitle'];?> | 阅读 <?php  echo number_format($value['views'],0)?></div>
                    </div>
                </a>
                <?php  } } ?>
            </div>
            <?php  if($postcount>=3) { ?>
                <a class="post-more" href="<?php  echo mobileUrl('sns/user/posts',array('id'=>$member['id']))?>" style="padding:.5rem 0"  data-nocache="true">查看更多</a>
            <?php  } ?>
        </div>
        <?php  } ?>
        <?php  if(count($replys)>0 && $openid==$_W['openid']) { ?>

        <div class="user-history">

            <div class="fui-line" style="text-align: center;" >
                <div class="fui-list-inner"  style="margin:auto;display: inline;background:#fafafa;padding:0 .2rem;">我的回复(仅本人可见)</div>
            </div>
            <div class="fui-list-group">
                <?php  if(is_array($replys)) { foreach($replys as $value) { ?>
                <a class="fui-list" href="<?php  echo mobileUrl('sns/post',array('id'=>$value['parentid']))?>" data-nocache="true">
                    <div class="fui-list-inner">
                         <div class="subtitle">回复<?php  echo $value['parentnickname'];?>: <?php  echo $value['content'];?></div>
                        <div class='text'>话题: <?php  echo $value['parenttitle'];?></div>
                    </div>
                </a>
                <?php  } } ?>
            </div>
            <?php  if($replycount>=3) { ?>
            <a class="post-more" href="<?php  echo mobileUrl('sns/user/replys')?>" style="padding:.5rem 0" >查看更多</a>
            <?php  } ?>
        </div>
        <?php  } ?>


        </div>


    </div>
    <script language='javascript'>
        require(['../addons/ewei_shopv2/plugin/sns/static/js/user.js'], function (modal) {
            modal.init();
        });
    </script>
</div>


<div class="fui-message fui-message-popup" style="display: none;" id="edit-sign">

    <div class="fui-header">
        <div class="fui-header-left">
            <a href="#" onclick="$('#edit-sign').hide();">取消</a>
        </div>
        <div class="title" style="font-size:.8rem;;line-height:1.2rem;">设置签名</div>
        <div class="fui-header-right" id="btnSend">提交</div>
	</div>
    <div class="fui-content">
        <div class="fui-cell-group" style="margin-top:0;">
            <div class="fui-cell">
                <div class="fui-cell-info">
                    <textarea placeholder="内容 60个字以内" rows="8" id="content"><?php  if(!empty($member['sns_sign'])) { ?><?php  echo $member['sns_sign'];?><?php  } ?></textarea>
                </div>
            </div>
        </div>
    </div>

</div>

<?php  $this->footerMenus()?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--913702023503242914-->