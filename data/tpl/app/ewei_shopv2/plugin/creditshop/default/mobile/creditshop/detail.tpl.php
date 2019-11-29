<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php  $this->followBar()?>
<style>
    .fui-cell-group .fui-cell.fui-cell-credit:before{border:none;}
    .fui-cell-group .fui-cell.fui-cell-credit{padding:0.2rem 0.5rem;}
    .fui-cell-group .fui-cell.fui-cell-credit .fui-cell-text{color:#666;font-size:0.6rem;}
    .fui-navbar ~ .fui-content, .fui-content.navbar{padding:0;}
    .fui-footer.btn-disabled{background: #ddd;color: #bbb;line-height: 2.4rem;text-align: center;}
    <?php  if($pay['credit'] == 0) { ?>
    .fui-actionsheet a.balance{display: none;}
    <?php  } ?>
    <?php  if($pay['weixin'] == 0 && $pay['weixin_jie'] == 0) { ?>
    .fui-actionsheet a.wechat{display: none;}
    <?php  } ?>
    <?php  if($pay['alipay'] == 0) { ?>
    .fui-actionsheet a.alipay{display: none;}
    <?php  } ?>
    #basic img{max-width: 100%;display: block;}
    .fui-list{display: none;} /*隐藏关注条*/
    .fui-tab.fui-tab-danger a.active {
        color: #01c7a8;
        border-color: #01c7a8;
        z-index: 100;
    }
</style>
<script>document.title = "商品详情"</script>
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/template/mobile/default/images/common.css" />
<link rel="stylesheet" href="../addons/ewei_shopv2/plugin/creditshop/static/css/common.css" />
<div class='fui-page  fui-page-current creditshop-detail-page'>
    <?php  if(!is_h5app()) { ?>
        <a class="back back-dot" style="z-index: 999;"><i class="icon icon-back1"></i></a>
    <?php  } else { ?>
        <div class="fui-header">
            <div class="fui-header-left">
                <a class="back"></a>
            </div>
            <div class="title">商品详情</div>
            <div class="fui-header-right"></div>
        </div>
    <?php  } ?>
    <div class='fui-content navbar'>
        <!-- 商品图片 -->
        <div class='fui-swipe'>
            <div class='fui-swipe-wrapper'>
                <a class='fui-swipe-item' href="javascript:void(0);">
                    <img src="<?php  echo tomedia($goods['thumb'])?>" width="100%" />
                </a>
            </div>
            <div class='fui-swipe-page'></div>

            <?php  if($goods['timestate'] && $goods['istime']) { ?>
            <div class="fui-swipe-layer">
                <i class="icon icon-history"></i>
                <span id="divdown1"></span>
            </div>
            <?php  } ?>
        </div>

        <script language="javascript" type="text/javascript">
            var interval = 1000;
            function ShowCountDown(endtime,divname)
            {
                var now = new Date();
                var endDate = new Date(endtime*1000);
                var leftTime=endDate.getTime()-now.getTime();
                var leftsecond = parseInt(leftTime/1000);
                //var day1=parseInt(leftsecond/(24*60*60*6));
                var day1=Math.floor(leftsecond/(60*60*24));
                var hour=Math.floor((leftsecond-day1*24*60*60)/3600);
                var minute=Math.floor((leftsecond-day1*24*60*60-hour*3600)/60);
                var second=Math.floor(leftsecond-day1*24*60*60-hour*3600-minute*60);
                var cc = document.getElementById(divname);
                cc.innerHTML = "剩余:"+day1+"天"+hour+"小时"+minute+"分"+second+"秒";
            }
            var $demodiv = document.getElementById('divdown1');
            if($demodiv){
                window.setInterval(function(){ShowCountDown(<?php  echo $goods['timeend'];?>,'divdown1');}, interval);
            }
        </script>
        <div class="fui-cell-group fui-detail-group">
            <div class="fui-cell">
                <div class="fui-cell-text name">
                    <?php  if($goods['goodstype'] == 0) { ?><label style="background-color: #01c7a8;">商品</label><?php  } ?>
                    <?php  if($goods['goodstype'] == 1) { ?><label>优惠券</label><?php  } ?>
                    <?php  if($goods['goodstype'] == 2) { ?><label>余额</label><?php  } ?>
                    <?php  if($goods['goodstype'] == 3) { ?><label>红包</label><?php  } ?>
                    <span><?php  echo $goods['title'];?></span>
                </div>
            </div>

            <?php  if($goods['isverify']==1) { ?>
                <?php  if(($goods['usetime'] > 0 && $goods['isendtime']==0) || $goods['isendtime']==1) { ?>
                <div class="fui-cell fui-cell-credit">
                    <div class="fui-cell-text"><p>使用有效期: <?php  if($goods['isendtime']==1) { ?>截止至<?php  echo $goods['endtime_str'];?><?php  } else { ?>兑换之日起 <?php  echo $goods['usetime'];?> 天内<?php  } ?></p></div>
                </div>
                <?php  } ?>
            <?php  } ?>
            <?php  if($goods['total']>0) { ?>
            <div class="fui-cell fui-cell-credit">
                <div class="fui-cell-text"><p>仅限: <?php  echo $goods['total'];?> 份 已参与: <?php  echo $goods['joins'];?> 次</p></div>
            </div>
            <?php  } ?>
            <?php  if(!empty($goods['dispatch']) && $goods['isverify'] == 0) { ?>
            <div class="fui-cell fui-cell-credit">
                <div class="fui-cell-text">
                    <p>
                    邮费:
                        <?php  if(is_array($goods['dispatch'])) { ?>
                            <?php  echo number_format($goods['dispatch']['min'],2)?> ~ <?php  echo number_format($goods['dispatch']['max'],2)?> 元
                        <?php  } else { ?>
                            <?php echo $goods['dispatch'] == 0 ? '包邮' : '&yen;'.number_format($goods['dispatch'],2)?>
                        <?php  } ?>
                    </p>
                </div>
            </div>
            <?php  } ?>
            <div class="fui-cell">
                <div class="fui-cell-text flex">
                    <span class="price" style="text-align: left;">
                        <span class="big"><?php  if($goods['mincredit']>0) { ?><?php  echo $goods['mincredit'];?><?php  } else { ?><?php  echo $goods['credit'];?><?php  } ?></span><?php  echo $_W['shopset']['trade']['credittext'];?>
                        <?php  if($goods['money'] > 0) { ?>
                            + <span style="font-size: 0.8rem;font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $goods['money'];?></span>
                        <?php  } ?>
                         <span class="old">原价:<?php  echo $goods['price'];?>元</span>
                    </span>
                </div>
            </div>
        </div>

        <?php  if($goods['hasoption']) { ?>
        <div class="fui-cell-group fui-cell-click">
            <div class="fui-cell">
                <div class="fui-cell-text store">请选择规格及数量</div>
                <div class="fui-cell-remark fui-cell-info" id="optionid">
                    <input type="hidden" placeholder="请选择规格" id="carrier_optionid" value="<?php  echo $member['realname'];?>" class="fui-input">
                </div>
            </div>
        </div>
        <?php  } ?>
        <?php  if($goods['detailshow'] == 1 || $set['isdetail']) { ?>
        <div class="fui-list-group">
            <div class="fui-list">
                <div class="fui-list-inner">
                    <div class="title">兑换流程</div>
                    <div class="text">
                        <?php  if($goods['detailshow'] == 1) { ?>
                            <?php  echo htmlspecialchars_decode($goods['detail'])?>
                        <?php  } else if($set['isdetail']) { ?>
                            <?php  echo htmlspecialchars_decode($set['detail'])?>
                        <?php  } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php  } ?>
        <?php  if($goods['noticedetailshow'] == 1 || $set['isnoticedetail']) { ?>
        <div class="fui-list-group">
            <div class="fui-list">
                <div class="fui-list-inner">
                    <div class="title">注意事项</div>
                    <div class="text">
                        <?php  if($goods['noticedetailshow'] == 1) { ?>
                            <?php  echo htmlspecialchars_decode($goods['noticedetail'])?>
                        <?php  } else if($set['isnoticedetail']) { ?>
                            <?php  echo htmlspecialchars_decode($set['noticedetail'])?>
                        <?php  } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php  } ?>

        <div class="fui-tab fui-tab-danger detail-tab" id="detailTab">
            <a data-tab="basic" class="active">商品详情</a>
            <?php  if($set['isreply']==1) { ?><a data-tab="comment">评价</a><?php  } ?>
            <a data-tab="records">参与记录</a>
        </div>

        <div class="detail-block">
            <div class="block block-basic tab-basic" id="basic">
                <?php  if($goods['goodsdetail']) { ?><?php  echo htmlspecialchars_decode($goods['goodsdetail'])?><?php  } else { ?>暂无商品详情<?php  } ?>
            </div>
            <?php  if($set['isreply']==1) { ?>
            <div class="block block-comment tab-basic" id="comment">
                <?php  if(!empty($replytotal)) { ?>
                <div class="comments" id="comments_reply">
                    <?php  if(is_array($replys)) { foreach($replys as $item) { ?>
                    <div class="item">
                        <div class="userinfo">
                            <div class="user">
                                <img src="<?php  echo tomedia($item['headimg'])?>">
                                <span><?php  echo $item['nickname'];?></span>
                                <span class="date"><?php  echo $item['time_str'];?></span>
                            </div>
                            <div class="feel">
                                <?php  if($item['level'] > 0) { ?><span class="shine">★</span><?php  } ?>
                                <?php  if($item['level'] > 1) { ?><span class="shine">★</span><?php  } ?>
                                <?php  if($item['level'] > 2) { ?><span class="shine">★</span><?php  } ?>
                                <?php  if($item['level'] > 3) { ?><span class="shine">★</span><?php  } ?>
                                <?php  if($item['level'] > 4) { ?><span class="shine">★</span><?php  } ?>
                            </div>
                        </div>
                        <div class="comment"><?php  echo $item['content'];?></div>
                        <div class="comment-images">
                            <?php  if(is_array($item['images'])) { foreach($item['images'] as $images) { ?>
                            <img src="<?php  echo $images;?>">
                            <?php  } } ?>
                        </div>
                        <?php  if($item['reply_content'] || $item['reply_images'] ) { ?>
                        <div class="comment-reply">
                            卖家回复: <?php  echo $item['reply_content'];?>
                            <div class="comment-images">
                                <?php  if(is_array($item['reply_images'])) { foreach($item['reply_images'] as $images) { ?>
                                <img src="<?php  echo $images;?>">
                                <?php  } } ?>
                            </div>
                        </div>
                        <?php  } ?>
                        <?php  if($item['append_time']>0) { ?>
                        <div class="comment">追加评论：<?php  echo $item['append_content'];?></div>
                        <div class="comment-images">
                            <?php  if(is_array($item['append_images'])) { foreach($item['append_images'] as $images) { ?>
                            <img src="<?php  echo $images;?>">
                            <?php  } } ?>
                        </div>
                        <?php  } ?>
                        <?php  if($item['append_reply_content'] || $item['append_reply_images']) { ?>
                        <div class="comment-reply">
                            卖家回复: <?php  echo $item['append_reply_content'];?>
                            <div class="comment-images">
                                <?php  if(is_array($item['append_reply_images'])) { foreach($item['append_reply_images'] as $images) { ?>
                                <img src="<?php  echo $images;?>">
                                <?php  } } ?>
                            </div>
                        </div>
                        <?php  } ?>
                    </div>
                    <?php  } } ?>
                </div>
                <?php  if($replytotal > 2) { ?>
                <div class="more replymore"><a href="javascript:void(0);">查看更多(<?php  if($replytotal > 999) { ?>999+<?php  } else { ?><?php  echo $replytotal;?><?php  } ?>+)</a></div>
                <?php  } ?>
                <?php  } else { ?>
                <div class="detail-block block-basic">
                    暂无评价！
                </div>
                <?php  } ?>
            </div>
            <script id='tpl_replylist' type='text/html'>
                <%each list as item%>
                <div class="item">
                    <div class="userinfo">
                        <div class="user">
                            <img src="<%item.headimg%>">
                            <span><%item.nickname%></span>
                            <span class="date"><%item.time_str%></span>
                        </div>
                        <div class="feel">
                            <%if item.level > 0%><span class="shine">★</span><%/if%>
                            <%if item.level > 1%><span class="shine">★</span><%/if%>
                            <%if item.level > 2%><span class="shine">★</span><%/if%>
                            <%if item.level > 3%><span class="shine">★</span><%/if%>
                            <%if item.level > 4%><span class="shine">★</span><%/if%>
                        </div>
                    </div>
                    <div class="comment"><%item.content%></div>
                    <div class="comment-images">
                        <%each item.images img%>
                        <img src="<%img%>">
                        <%/each%>
                    </div>
                    <%if item.reply_time > 0 %>
                    <div class="comment-reply">
                        卖家回复: <%item.reply_content%>
                        <div class="comment-images">
                            <%each item.reply_images img%>
                            <img src="<%img%>">
                            <%/each%>
                        </div>
                    </div>
                    <%/if%>
                    <%if item.append_time > 0 %>
                    <div class="comment">追加评论：<%item.append_content%></div>
                    <div class="comment-images">
                        <%each item.append_images img%>
                        <img src="<%img%>">
                        <%/each%>
                    </div>
                    <%/if%>
                    <%if item.append_reply_time > 0 %>
                    <div class="comment-reply">
                        卖家追加回复: <%item.append_reply_content%>
                        <div class="comment-images">
                            <%each item.append_reply_images img%>
                            <img src="<%img%>">
                            <%/each%>
                        </div>
                    </div>
                    <%/if%>
                </div>
                <%/each%>
            </script>

            <?php  } ?>
            <div class="block block-records tab-basic" id="records">
                <?php  if(!empty($logtotal)) { ?>
                <div id="loglist">
                    <?php  if(is_array($log)) { foreach($log as $item) { ?>
                    <div class="fui-list">
                        <div class="fui-list-media">
                            <img src="<?php  echo tomedia($item['avatar'])?>">
                        </div>
                        <div class="fui-list-inner">
                            <div class="title" style="font-size:0.7rem;"><?php  echo $item['nickname'];?></div>
                            <!--<div class="text">x 10</div>-->
                        </div>
                        <div class="fui-list-media" style="font-size:0.6rem;color:#666"><?php  echo $item['createtime_str'];?></div>
                    </div>
                    <?php  } } ?>
                </div>
                <?php  if($logtotal > 2) { ?>
                <div class="more logmore"><a href="javascript:void(0);">查看更多(<?php  if($logtotal > 999) { ?>999+<?php  } else { ?><?php  echo $logtotal;?><?php  } ?>)</a></div>
                <?php  } ?>
                <?php  } else { ?>
                <div class="detail-block block-basic">
                    暂无参与记录！
                </div>
                <?php  } ?>
            </div>
        </div>
        <script id='tpl_loglist' type='text/html'>
            <%each list as item%>
            <div class="fui-list">
                <div class="fui-list-media">
                    <img src="<%item.avatar%>">
                </div>
                <div class="fui-list-inner">
                    <div class="title" style="font-size:0.7rem;"><%item.nickname%></div>
                    <!--<div class="text">x 10</div>-->
                </div>
                <div class="fui-list-media" style="font-size:0.6rem;color:#666"><%item.createtime_str%></div>
            </div>
            <%/each%>
        </script>

        <div class="fui-list-group">
            <div class="fui-list noclick">
                <div class="fui-list-inner">
                    <div class="title">为您推荐</div>
                    <div class="text recommend">
                        <?php  if(is_array($goodsrec)) { foreach($goodsrec as $item) { ?>
                        <div class="item">
                            <a href="<?php  echo mobileUrl('creditshop/detail',array('id'=>$item['id']))?>">
                            <img src="<?php  echo tomedia($item['thumb'])?>" />
                            <div class="title"><?php  echo $item['title'];?></div>
                            <div class="price">
                                <?php  if($item['mincredit']>0) { ?><?php  echo $item['mincredit'];?><?php  } else { ?><?php  echo $item['credit'];?><?php  } ?><?php  echo $_W['shopset']['trade']['credittext'];?>
                                <?php  if($item['money'] > 0) { ?>
                                + <span style="font-weight: bold;padding-right: 0.1rem;">&yen;<?php  echo $item['money'];?></span>
                                <?php  } ?>
                            </div>
                            </a>
                        </div>
                        <?php  } } ?>
                    </div>
                </div>
            </div>
        </div>
        <?php  if($goods['subdetail']) { ?>
        <div class="fui-list-group">
            <div class="fui-list">
                <div class="fui-list-inner">
                    <div class="title">提供商家介绍</div>
                    <div class="text"><?php  echo htmlspecialchars_decode($goods['subdetail'])?></div>
                </div>
            </div>
        </div>
        <?php  } ?>

    </div>

    <div class="fui-footer <?php  if($goods['canbuy']) { ?>btn-danger<?php  } else { ?>btn-disabled<?php  } ?>">
        <div id="openActionSheet">
            <?php  if($goods['canbuy']) { ?>
                <?php  if($goods['type']==1) { ?>立即抽奖<?php  } else { ?>立即兑换<?php  } ?>
            <?php  } else { ?>
                <?php  echo $goods['buymsg'];?>
            <?php  } ?>
        </div>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('creditshop/picker', TEMPLATE_INCLUDEPATH)) : (include template('creditshop/picker', TEMPLATE_INCLUDEPATH));?>
<script>
    $("#detailTab a").unbind('click').click(function () {
        var tab = $(this).data('tab');
        $(this).addClass('active').siblings().removeClass('active');
        $("#"+tab).show().siblings().hide();
    });

    require(['../addons/ewei_shopv2/plugin/creditshop/static/js/detail.js'],function(modal){
        modal.init({goods: <?php  echo json_encode($goods)?> });
    });
</script>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--青岛易联互动网络科技有限公司-->