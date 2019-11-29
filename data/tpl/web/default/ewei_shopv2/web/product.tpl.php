<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-heading">
<span class="pull-right"><a class='btn btn-primary btn-sm' href="<?php  echo webUrl('product/add')?>"><i class="fa fa-plus"></i> 注册产品</a> </span>
 <h2>产品注册记录</h2> 
 </div>

  <form action="./index.php" method="get" class="form-horizontal table-search" role="form">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="ewei_shopv2" />
                <input type="hidden" name="do" value="web" />
                <input type="hidden" name="r" value="product" />
<div class="page-toolbar row m-b-sm m-t-sm">
                           


                            <div class="col-sm-12 pull-right">

                <div class="input-group">
                                          <input type="text" class="form-control input-sm"  name="keywords" value="<?php  echo $_GPC['keywords'];?>" placeholder="可搜索注册码/昵称"/>
                 <span class="input-group-btn">

                                        <button class="btn btn-sm btn-primary" type="submit"> 搜索</button>
                                       <!--  <button type="submit" name="export" value="1" class="btn btn-success btn-sm">导出</button> -->
                                        <button class="btn btn-sm btn-default" type="button" onclick="$('#moresearch').toggle()"> 其他 <i class="fa fa-angle-down"></i></button>
                </span>
                                </div>

                            </div>
</div>
                <div class="page-toolbar row" <?php  if($_GPC['status']=='' && $_GPC['time']['start']==''  && $_GPC['time']['end']=='' ) { ?>style='display:none;'<?php  } ?> id='moresearch' >


                    <div class="col-sm-12">

               


    
    

                       


                        <?php  echo tpl_daterange('time', array('sm'=>true, 'placeholder'=>'注册时间'),true);?>




                            </div>


                </div>
  </form>

 
        <table class="table table-hover table-responsive">
            <thead class="navbar-inner">
                <tr>
                      <th style="width:25px;"><input type='checkbox' /></th>
         
                    <th style="width:40px;">ID</th>
                    <th style="width:100px;">产品名称</th>
                   
                    <th style="width:150px;">注册码</th>
                    <th style="width:150px;">注射器编号</th>
                    
                    <th style="width:80px;">会员昵称</th>
                    <th style="width:120px;">时间</th>
                    
                    <th style="width:100px;">操作</th>
                   
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr rel="pop" data-title="ID: <?php  echo $row['id'];?>">
                    
            
                    <td style="position: relative; ">
                    <input type='checkbox'   value="<?php  echo $row['id'];?>"/></td>
                    <td><?php  echo $row['id'];?></td>
                    <td><?php  echo $row['productname'];?></td>
                    
                    <td><?php  echo $row['num'];?></td>
                    <td><?php  echo $row['zcode'];?></td>
                    <td><?php  echo $row['nickname'];?></td>
                    <td><?php  echo date("Y-m-d H:i:s",$row['createtime'])?></td>
                    <td> 
         
                       <a class='btn btn-primary btn-sm' href="<?php  echo webUrl('product/edit',array('id'=>$row['id']))?>">编辑</a> 
                    
                    </td>
             
                      
                           
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
           <?php  echo $pager;?>
           <script language="javascript">
                 <?php  if($opencommission) { ?>
                 require(['bootstrap', 'jquery', 'jquery.ui'], function (bs, $, $) {
        $("[rel=pop]").popover({
            trigger:'manual',
            placement : 'left', 
            title : $(this).data('title'),
            html: 'true', 
            content : $(this).data('content'),
            animation: false
        }).on("mouseenter", function () {
                    var _this = this;
                    $(this).popover("show"); 
                    $(this).siblings(".popover").on("mouseleave", function () {
                        $(_this).popover('hide');
                    });
                }).on("mouseleave", function () {
                    var _this = this;
                    setTimeout(function () {
                        if (!$(".popover:hover").length) {
                            $(_this).popover("hide")
                        }
                    }, 100);
                });
 
     
       });
    <?php  } ?>
               
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->