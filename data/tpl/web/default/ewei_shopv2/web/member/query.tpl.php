<?php defined('IN_IA') or exit('Access Denied');?><div style='max-height:500px;overflow:auto;min-width:850px;'>
<table class="table table-hover" style="min-width:850px;">
    <tbody>   
        <?php  if(is_array($ds)) { foreach($ds as $row) { ?>
        <tr>
            <td><img src='<?php  echo tomedia($row['avatar'])?>' style='width:30px;height:30px;padding1px;border:1px solid #ccc' /> <?php  echo $row['nickname'];?>
                <?php  if(strexists($row['openid'],'sns_wa_')) { ?>
                <i class="icon icon-wxapp" title="小程序注册" style="color: #7586db;"></i>
                <?php  } ?>
                <?php  if(strexists($row['openid'],'wap_user_')||strexists($row['openid'],'sns_qq_')||strexists($row['openid'],'sns_wx_')) { ?>
                <i class="icon icon-mobile2"title="<?php  if(strexists($row['openid'],'wap_user_')) { ?>手机号注册<?php  } else { ?>APP注册<?php  } ?>" style="color: #44abf7;"></i>
                <?php  } ?>
            </td>
            <td><?php  echo $row['realname'];?>
            </td>
            <td><?php  echo $row['mobile'];?></td>
            <td style="width:80px;"><a href="javascript:;" onclick='biz.selector.set(this,<?php  echo json_encode($row);?>)'>选择</a></td>
        </tr>
        <?php  } } ?>
        <?php  if(count($ds)<=0) { ?>
        <tr> 
            <td colspan='4' align='center'>未找到会员</td>
        </tr>
        <?php  } ?>
    </tbody>
</table>
    </div>
<!--青岛易联互动网络科技有限公司-->