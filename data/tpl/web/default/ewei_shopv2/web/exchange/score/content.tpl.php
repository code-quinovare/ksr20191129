<?php defined('IN_IA') or exit('Access Denied');?><div class="page-content" style="display: block;">
    <div class="page-heading">
        <?php if(cv('exchange.score.setting')) { ?>
    <span class="pull-right">
            <a class="btn btn-warning btn-sm" href="<?php  echo webUrl('exchange/score/setting',array('id'=>0));?>"><i class="fa fa-plus"></i> 添加积分兑换任务</a>
        </span>
        <?php  } ?>
        <h2>积分兑换任务
            <!--<small>数量: <span class="text-danger">0</span> 条</small>-->
        </h2>
    </div>

    <ul class="nav nav-arrow-next nav-tabs" id="myTab">
        <li <?php  if($_W['action'] == 'score') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('exchange/score')?>">进行中 (<span class="goods-ing"><?php  echo $allStart;?></span>)</a>
        </li>
        <li <?php  if($_W['action'] == 'score.nostart') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('exchange/score/nostart')?>">未开始 (<span class="goods-ing"><?php  echo $allNostart;?></span>)</a>
        </li>
        <li <?php  if($_W['action'] == 'score.end') { ?>class="active"<?php  } ?>>
        <a href="<?php  echo webUrl('exchange/score/end')?>">已结束 (<span class="goods-sold"><?php  echo $allEnd;?></span>)</a>
        </li>

    </ul>

    <div class="page-toolbar row m-b-sm m-t-sm">
        <div class="col-sm-4">
            <div class="input-group-btn">
                <button class="btn btn-default btn-sm" type="button" data-toggle="refresh">
                    <i class="fa fa-refresh"></i>
                </button>
                <?php if(cv('exchange.score.delete')) { ?>
                <button class="btn btn-default btn-sm" type="button" data-toggle="batch-remove" data-confirm="确认要删除选中的商品吗?" data-href="<?php  echo webUrl('exchange/goods/delete');?>" disabled="disabled">
                    <i class="fa fa-trash"></i> 删除
                </button>
                <?php  } ?>
            </div>
        </div>
        <div class="col-sm-4 pull-right">

            <div class="input-group">
                <input type="text" class="input-sm form-control" name="keyword" id="keyword" value="" placeholder="请输入关键词">
                <span class="input-group-btn">
                    <button class="btn btn-sm btn-primary" type="submit" id="so">搜索</button>
                </span>
            </div>
        </div>
    </div>

    <script language="JavaScript" type="text/javascript">
        function clearNoNum(obj){
            obj.value = obj.value.replace(/[^\d.]/g,"");  //清除“数字”和“.”以外的字符
            obj.value = obj.value.replace(/\.{2,}/g,"."); //只保留第一个. 清除多余的
            obj.value = obj.value.replace(".","$#$").replace(/\./g,"").replace("$#$",".");
            obj.value = obj.value.replace(/^(\-)*(\d+)\.(\d\d).*$/,'$1$2.$3');//只能输入两个小数
            if(obj.value.indexOf(".")< 0 && obj.value !=""){//以上已经过滤，此处控制的是如果没有小数点，首位不能为类似于 01、02的金额
                obj.value= parseFloat(obj.value);
            }
        }

        $(document).ready($('#so').click(function () {
                    var v = $('#keyword').val();
                    var so_url = '<?php  echo webUrl("exchange/score/search")?>';
                    var canshu = '&keyword='+v;
                    var so_url = so_url + canshu;
                    window.location.href = so_url;
                })
        );
    </script>
    <form action="" method="post">
        <table class="table table-hover table-responsive table_kf active" id="tab_sold"><thead>
        <tr>
            <th style="width:25px;"><input type="checkbox"></th>
            <th style="width:60px;">排序</th>
            <th style="width:90px;">兑换标题</th>
            <th style="width:90px;">&nbsp;</th>
            <th style="width:100px;">已兑/总量</th>
            <th style="width:100px;">结束时间</th>
            <th style="width:60px;">类型</th>
            <th style="width:90px;">状态</th>
            <th>操作</th>
        </tr>
        </thead>
            <tbody>
            <?php  if(is_array($list)) { foreach($list as $key => $value) { ?>
            <tr>
                <!--<td colspan="10" style="text-align: center;">暂时没有任何商品!</td>-->
                <td><input type="checkbox" name="checkbox[]" value="<?php  echo $value['id'];?>" class="checkbox"></td>
                <td><?php  echo $key+$pstart+1;?></td>
                <td colspan="2"><a href="<?php  echo webUrl('exchange/score/dno',array('id'=>$value['id']));?>"><?php  echo $value['title'];?></a></td>
                <td><?php  echo $value['use'];?>/<?php  echo $value['total'];?></td>
                <td><?php  echo substr($value['endtime'],0,10);?></td>
                <td align="center">
                    <?php  if($value['type'] == 1) { ?><span class="label label-success">指定</span><?php  } ?>
                    <?php  if($value['type'] == 2) { ?><span class="label label-danger">随机</span><?php  } ?>
                </td>
                <td>
                    <?php  if($_W['action']=='score') { ?>
                    <span class="label <?php  if($value['status']==1) { ?>label-primary<?php  } else { ?>label-danger<?php  } ?>" data-toggle="ajaxSwitch" data-confirm="确认暂停此兑换活动？" data-switch-refresh="true" data-switch-value="<?php  echo $value['status'];?>" data-switch-value0="0|已暂停|label label-default|<?php  echo webUrl('exchange/score/status',array('id'=>$value['id'],'status'=>0));?>" data-switch-value1="1|进行中|label label-success|<?php  echo webUrl('exchange/score/status',array('id'=>$value['id'],'status'=>1));?>"><?php  if($value['status']==1) { ?>进行中<?php  } else { ?>已暂停<?php  } ?></span>
                    <?php  } ?>
                    <?php  if($_W['action']=='score.nostart') { ?>
                    <span class="label label-warning" data-toggle="ajaxSwitch" data-confirm="确认立即开始此兑换活动？" data-switch-refresh="true" data-switch-value="1" data-switch-value0="">未开始</span>
                    <?php  } ?>
                    <?php  if($_W['action']=='score.end') { ?>
                    <span class="label label" data-toggle="ajaxSwitch" data-confirm="确认再次开启兑换活动？" data-switch-refresh="true" data-switch-value="1" data-switch-value0="">已结束</span>
                    <?php  } ?>
                </td>
                <td>
                    <a class="btn btn-default btn-sm" title="查看" href="<?php  echo webUrl('exchange/score/dno',array('id'=>$value['id']));?>"><i class="fa fa-search"></i> 兑换码</a>
                    <?php if(cv('exchange.score.setting')) { ?>
                    <a class="btn btn-default btn-sm" href="<?php  echo webUrl('exchange/score/setting',array('id'=>$value['id']));?>" title="编辑"><i class="fa fa-edit"></i> 编辑</a>
                    <?php  } ?>
                    <?php if(cv('exchange.score.delete')) { ?>
                    <a class="btn btn-default btn-sm" data-toggle="ajaxRemove" href="<?php  echo webUrl('exchange/score/delete',array('id'=>$value['id']));?>" data-confirm="确认删除此兑换组？"><i class="fa fa-trash"></i> 删除</a>
                    <?php  } ?>
                </td>
            </tr>
            <?php  } } ?>
            </tbody>
        </table>
    </form>
    <?php  echo $pager;?>
</div>
