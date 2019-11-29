<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<style>
    .input-group-sm.daterange .btn {padding: 4px 6px; border-radius: 0;}
    .trhead {
        border-left: 1px solid #e7eaec;
        border-right: 1px solid #e7eaec;
        background: #f8f8f8;
    }
</style>

<div class='page-heading'><h2>签到/奖励记录 <small>(<?php  echo $total;?>条/总积分:<?php  echo $count;?>分)</small></h2></div>

<form action="./index.php" method="get" class="form-horizontal" plugins="form">
    <input type="hidden" name="c" value="site">
    <input type="hidden" name="a" value="entry">
    <input type="hidden" name="m" value="ewei_shopv2">
    <input type="hidden" name="do" value="web">
    <input type="hidden" name="r" value="sign.records">
    <div class="page-toolbar row m-b-sm m-t-sm">
        <div class="col-sm-2">
            <div class="input-group input-group-sm">
                <button class="btn btn-default btn-sm" type="button" data-toggle="refresh" title="刷新页面"><i class="fa fa-refresh"></i></button>
            </div>
        </div>
        <div class="col-sm-10 pull-right">
            <div class="input-group pull-right" style="width: 260px;">
                <input type="text" class="input-sm form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入昵称/手机号进行搜索"> <span class="input-group-btn">
                <button class="btn btn-sm btn-primary" type="submit"> 搜索</button> </span>
            </div>
            <div class="input-group input-group-sm pull-right daterange" style="width: 400px;">
                <select class="input-group-addon" style="width: 90px" name="type">
                    <option value="-1" <?php  if($_GPC['type']==-1) { ?>selected<?php  } ?>>类型</option>
                    <option value="0" <?php  if($_GPC['type']=='0') { ?>selected<?php  } ?>>日常签到</option>
                    <option value="1" <?php  if($_GPC['type']==1) { ?>selected<?php  } ?>>连签奖励</option>
                    <option value="2" <?php  if($_GPC['type']==2) { ?>selected<?php  } ?>>总签奖励</option>
                </select>
                <select class="input-group-addon" style="width: 100px" name="searchtime">
                    <option value="" <?php  if(empty($_GPC['searchtime'])) { ?>selected<?php  } ?>>不按日期</option>
                    <option value="1" <?php  if(!empty($_GPC['searchtime'])) { ?>selected<?php  } ?>>搜索日期</option>
                </select>
                <?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)), false);?>
            </div>
        </div>
    </div>
</form>

<table class="table table-responsive table-bordered">
    <tbody>
        <tr class="trhead">
            <td style="width: 80px;">ID</td>
            <td style="width: 180px;">用户</td>
            <td style="width: 80px;">类型</td>
            <td style="width: 90px;">获得积分</td>
            <td>备注</td>
            <td style="width: 145px;">签到时间</td>
        </tr>
        <?php  if(empty($list)) { ?>
            <tr>
                <td colspan="5" align="center" style="line-height: 50px;">未查询到相关记录!</td>
            </tr>
        <?php  } else { ?>
            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                <tr class="trbody">
                    <td><?php  echo $item['id'];?></td>
                    <td>
                        <a href="<?php  echo webUrl('member/list/detail', array('id'=>$item['mid']))?>" target="_blank" title="<?php  echo $item['nickname'];?>"><img src="<?php  echo tomedia($item['avatar'])?>" style="width:30px; height:30px; padding: 1px; border:1px solid #ccc;"> <?php  echo $item['nickname'];?></a>
                    </td>
                    <td>
                        <?php  if($item['type']==0) { ?>日常签到<?php  } else if($item['type']==1) { ?>连签奖励<?php  } else if($item['type']==2) { ?>总签奖励<?php  } ?>
                    </td>
                    <td><a href="<?php  echo webUrl('finance/credit/credit1', array('keyword'=>$item['nickname']))?>" target="_blank">+<?php  echo $item['credit'];?></a></td>
                    <td data-toggle="popover" data-html="true" data-placement="top" data-trigger="hover" data-content="<?php  echo $item['log'];?>" data-original-title="" title=""><?php  echo $item['log'];?></td>
                    <td><?php  echo date('Y.m.d H:i:s', $item['time'])?></td>
                </tr>
            <?php  } } ?>
        <?php  } ?>
    </tbody>
</table>
<?php  echo $pager;?>


<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
