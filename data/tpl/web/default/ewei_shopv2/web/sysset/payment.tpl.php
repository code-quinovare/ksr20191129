<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-heading"> 
    <span class='pull-right'>
            <?php if(cv('sysset.payment.add')) { ?>
               <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('sysset/payment/add')?>"><i class="fa fa-plus"></i> 添加新模板</a>
              <?php  } ?>

    </span>
    <h2>支付模板管理</h2></div>

<form action="" method="post">


    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="sysset.payment"/>
        <div class="page-toolbar row m-b-sm m-t-sm">
            <div class="col-sm-4">

                <div class="input-group-btn">
                    <button class="btn btn-default btn-sm" type="button" data-toggle='refresh'>
                        <i class='fa fa-refresh'></i></button>


                    <?php if(cv('sysset.payment.delete')) { ?>
                    <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle='batch-remove' data-confirm="确认要删除?" data-href="<?php  echo webUrl('sysset/payment/delete')?>">
                        <i class='fa fa-trash'></i> 删除
                    </button>
                    <?php  } ?>

                </div>
            </div>


            <div class="col-sm-6 pull-right">


                <div class="input-group">
                    <input type="text" class="input-sm form-control" name='keyword' value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键词">
                    <span class="input-group-btn">
                        <button class="btn btn-sm btn-primary" type="submit"> 搜索</button>
                    </span>
                </div>

            </div>
        </div>
    </form>


    <?php  if(count($list)>0) { ?>
    <table class="table table-responsive table-hover">
        <thead>
        <tr>
            <th style="width:25px;"><input type='checkbox'/></th>
            <th>模板名称</th>
            <th>支付类型</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php  if(is_array($list)) { foreach($list as $row) { ?>
        <tr>
            <td>
                <input type='checkbox' value="<?php  echo $row['id'];?>"/>
            </td>
            <td><?php  echo $row['title'];?></td>
            <td>
                <span class="label label-success">
                    <?php  if($row['paytype']==0) { ?>
                        <?php echo isset($payment[$row['type']]) ? $payment[$row['type']] : '未知';?>
                    <?php  } else if($row['paytype']==1) { ?>
                        <?php echo isset($paytypeali[$row['type']]) ? $paytypeali[$row['type']] : '未知';?>
                    <?php  } ?>
                </span>
            </td>
            <td>
                <?php if(cv('sysset.payment.edit')) { ?>
                <a class='btn btn-default  btn-sm' href="<?php  echo webUrl('sysset/payment/edit', array('id' => $row['id']))?>"><i class='fa fa-edit'></i>
                    <?php if(cv('sysset.payment.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?></a><?php  } ?>
                <?php if(cv('sysset.payment.delete')) { ?><a class='btn btn-default  btn-sm' data-toggle='ajaxRemove' href="<?php  echo webUrl('sysset/payment/delete', array('id' => $row['id']))?>" data-confirm="确认删除此模板吗？"><i class='fa fa-trash'></i>
                删除</a><?php  } ?>

        </tr>
        <?php  } } ?>

        </tbody>
    </table>
    <?php  echo $pager;?>
    <?php  } else { ?>
    <div class='panel panel-default'>
        <div class='panel-body' style='text-align: center;padding:30px;'>
            暂时没有任何支付模板!
        </div>
    </div>
    <?php  } ?>

    </div>

</form>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

