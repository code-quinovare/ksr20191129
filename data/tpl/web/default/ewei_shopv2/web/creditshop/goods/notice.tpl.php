<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
    <label class="col-sm-2 control-label">商品简介</label>
    <div class="col-sm-9 col-xs-12">
        <?php if( ce('creditshop.goods' ,$item) ) { ?>
        <?php  echo tpl_ueditor('goodsdetail',$item['goodsdetail'], array('height'=>'200'))?>
        <?php  } else { ?>
        <textarea id='goodsdetail' name='goodsdetail' style='display:none;'><?php  echo $item['goodsdetail'];?></textarea>
        <a href='javascript:preview_html("#goodsdetail")' class="btn btn-default">查看内容</a>
        <?php  } ?>
    </div>
</div>
<div class="form-group" >
    <label class="col-sm-2 control-label">兑换流程</label>
    <div class="col-sm-9 col-xs-12">
        <div class="col-sm-10 col-xs-12">
            <label class="control-label" style="font-weight: normal;">是否单独开启商品兑换流程</label>
        </div>
        <div class="col-sm-2 pull-right" style="padding-right:50px;text-align: right" >
            <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <input type="checkbox" class="js-switch" name="detailshow" value="1" <?php  if($item['detailshow']==1) { ?>checked<?php  } ?> />
            <?php  } else { ?>
            <?php  if($item['detailshow']==1) { ?>
            <span class='text-success'>开启</span>
            <?php  } else { ?>
            <span class='text-default'>关闭</span>
            <?php  } ?>
            <?php  } ?>
        </div>
        <div style="clear:both;height:20px;"></div>
        <div class="detailcontent" <?php  if(empty($item['detailshow'])) { ?>style="display: none;"<?php  } ?>>
            <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <?php  echo tpl_ueditor('detail',$item['detail'],array('height'=>200))?>
            <?php  } else { ?>
            <textarea id='detail' style='display:none'><?php  echo $item['detail'];?></textarea>
            <a href='javascript:preview_html("#detail")' class="btn btn-default">查看内容</a>
            <?php  } ?>
        </div>
    </div>
</div>
<div class="form-group" >
    <label class="col-sm-2 control-label">注意事项</label>
    <div class="col-sm-9 col-xs-12">
        <div class="col-sm-10 col-xs-12">
            <label class="control-label" style="font-weight: normal;">是否单独开启商品注意事项</label>
        </div>
        <div class="col-sm-2 pull-right" style="padding-right:50px;text-align: right" >
            <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <input type="checkbox" class="js-switch" name="noticedetailshow" value="1" <?php  if($item['noticedetailshow']==1) { ?>checked<?php  } ?> />
            <?php  } else { ?>
            <?php  if($item['noticedetailshow']==1) { ?>
            <span class='text-success'>开启</span>
            <?php  } else { ?>
            <span class='text-default'>关闭</span>
            <?php  } ?>
            <?php  } ?>
        </div>
        <div style="clear:both;height:20px;"></div>
        <div class="noticedetailcontent" <?php  if(empty($item['noticedetailshow'])) { ?>style="display: none;"<?php  } ?>>
            <?php if( ce('creditshop.goods' ,$item) ) { ?>
            <?php  echo tpl_ueditor('noticedetail',$item['noticedetail'],array('height'=>200))?>
            <?php  } else { ?>
            <textarea id='noticedetail' style='display:none'><?php  echo $item['noticedetail'];?></textarea>
            <a href='javascript:preview_html("#noticedetail")' class="btn btn-default">查看内容</a>
            <?php  } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $(":checkbox[name='detailshow']").click(function () {
            if ($(this).prop('checked')) {
                $(".detailcontent").show();
            }
            else {
                $(".detailcontent").hide();
            }
        })
        $(":checkbox[name='noticedetailshow']").click(function () {
            if ($(this).prop('checked')) {
                $(".noticedetailcontent").show();
            }
            else {
                $(".noticedetailcontent").hide();
            }
        })
    })
</script>

<!--913702023503242914-->