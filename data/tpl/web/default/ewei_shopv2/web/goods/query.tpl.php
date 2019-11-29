<?php defined('IN_IA') or exit('Access Denied');?><table class="table">
    <thead>
    <th>商品名称</th>
    <th style="width: 100px">商品价格</th>
    <?php  if(!empty($live)) { ?>
    <th style="width: 100px">直播价格</th>
    <?php  } ?>
    <th style="width: 85px">操作</th>
    </thead>
</table>
<div style='max-height:500px;overflow:auto;min-width:850px;'>
    <table class="table table-hover" style="min-width:850px;">
        <tbody>
        <?php  if(is_array($ds)) { foreach($ds as $row) { ?>
        <tr>
            <td><img src="<?php  echo tomedia($row['thumb'])?>" style="width:30px;height:30px;padding1px; border:1px solid #ccc" /> <?php  echo $row['title'];?></td>
            <td style="width: 100px">￥<?php  echo $row['minprice'];?></td>
            <?php  if(!empty($live)) { ?>
                <td style="width: 100px">
                    <?php  if(!empty($row['islive']) && $row['liveprice']<$row['minprice']) { ?>
                        ￥<?php  echo $row['liveprice'];?>
                    <?php  } else { ?>
                        -
                    <?php  } ?>
                </td>
            <?php  } ?>
            <td style="width:80px;">
                <a href="javascript:;"onclick='biz.selector.set(this, <?php  echo json_encode($row);?>)'>选择</a>
            </td>
        </tr>
        <?php  } } ?>
        <?php  if(count($ds)<=0) { ?>
        <tr>
            <td colspan='5' align='center'>未找到商品</td>
        </tr>
        <?php  } ?>
        </tbody>
    </table>
</div>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->