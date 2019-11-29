<?php
defined('IN_IA') or exit ('Access Denied');

class Core extends WeModuleSite
{
  
    public function getMainMenu()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        $system=pdo_get('wpdc_system',array('uniacid'=>$_W['uniacid']));
        if ($_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<a href="javascript:void(0)" class="panel-title wytitle"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  业务菜单</a>',
                'items' => array(
                    0 => $this->createMainMenu('门店列表', $do, 'store','')
                )
            );}elseif($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=gaikuangdata&m=zh_dianc" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cubes"></icon>  门店管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('数据概况 ', $do, 'gaikuangdata', ''),
                    1 => $this->createMainMenu('门店列表', $do, 'store', ''),                   
                    2 => $this->createMainMenu('门店账号', $do, 'account', ''),
                    3 => $this->createMainMenu('小程序端账号', $do, 'admin', ''),
                    // 0 => $this->createMainMenu('门店回收站 ', $do, 'yg4', ''),
                )
            );
            $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=order&m=zh_dianc" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-bars"></icon>  订单管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('外卖订单 ', $do, 'order', ''),
                    1 => $this->createMainMenu('店内订单', $do, 'dnorder', ''),
                      2 => $this->createMainMenu('预订订单', $do, 'ydorder', ''),
                       3 => $this->createMainMenu('当面付订单', $do, 'dmorder', '')
                )
            );
             $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ad&m=zh_dianc" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-life-ring"></icon>  广告管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('广告列表 ', $do, 'ad', ''),
                    1 => $this->createMainMenu('广告添加', $do, 'addad', ''),
                )
            );
             $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=area&m=zh_dianc" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-map-marker"></icon>  门店区域</a>',
                'items' => array(
                     0 => $this->createMainMenu('区域列表', $do, 'area', ''),
                    1 => $this->createMainMenu('区域添加', $do, 'addarea', ''),
                )
            );
            $navemenu[4] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=typeset&m=zh_dianc" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-university"></icon>  门店类型</a>',
                'items' => array(
                    0 => $this->createMainMenu('分类设置 ', $do, 'typeset', ''),
                    1 => $this->createMainMenu('类型管理 ', $do, 'storetype', ''),
                    2 => $this->createMainMenu('类型添加 ', $do, 'addstoretype', ''),
                    
                )
            );
            
            $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ruzhu&m=zh_dianc" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-cubes"></icon>  入驻管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('申请列表 ', $do, 'ruzhu', ''),
                    1 => $this->createMainMenu('入驻设置 ', $do, 'ruzhusz', ''),
                )
            );
           
            

            
           if($system['jfgn']==1){
                $navemenu[8] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=jfgoods&m=zh_dianc" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-star-half-o"></icon>  积分商城</a>',
                'items' => array(
                    0 => $this->createMainMenu('商品列表', $do, 'jfgoods', ''),
                    1 => $this->createMainMenu('商品分类', $do, 'jftype', ''),
                    2 => $this->createMainMenu('积分设置', $do, 'jfsz', ''),
                )
            );
           }
            
            if($system['fxgn']==1){
            $navemenu[9] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=fxlist&m=zh_dianc" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-users"></icon>  分销系统</a>',
                'items' => array(
                    0 => $this->createMainMenu('分销商管理', $do, 'fxlist', ''),
                    1 => $this->createMainMenu('分销设置', $do, 'fxset', ''),
                    2 => $this->createMainMenu('提现申请', $do, 'fxtx', ''),
                )
            );
            }
            // $navemenu[10] = array(
            //     'title' => '<icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  充值中心',
            //     'items' => array(
            //        0 => $this->createMainMenu('充值优惠', $do, 'chongzhi', ''),
            //        1 => $this->createMainMenu('充值记录', $do, 'czjl', '')
            //     )
            // );
             $navemenu[11] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=integral&m=zh_dianc" class="panel-title wytitle" id="yframe-11"><icon style="color:#8d8d8d;" class="fa fa-pencil-square-o"></icon>  签到管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('签到规则 ', $do, 'integral', '')
                )
            );
          
            $navemenu[12] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=user&m=zh_dianc" class="panel-title wytitle" id="yframe-12"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  会员管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('会员列表 ', $do, 'user', ''),
                )
            );
            $navemenu[13] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=txlist&m=zh_dianc" class="panel-title wytitle" id="yframe-13"><icon style="color:#8d8d8d;" class="fa fa-jpy"></icon>  财务管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('提现管理 ', $do, 'txlist', ''),
                    1 => $this->createMainMenu('提现设置 ', $do, 'txsz', ''),
                    2 => $this->createMainMenu('充值优惠', $do, 'chongzhi', ''),
                   3 => $this->createMainMenu('充值记录', $do, 'czjl', '')
                )
            );
            // $navemenu[15] = array(
            //     'title' => '<a href="index.php?c=site&a=entry&op=display&do=analysis&m=zh_dianc" class="panel-title wytitle" id="yframe-15"><icon style="color:#8d8d8d;" class="fa fa-recycle"></icon>  经营分析</a>',
            //     'items' => array(
            //         0 => $this->createMainMenu('经营分析 ', $do, 'analysis', ''),
            //         // 1 => $this->createMainMenu('营业统计 ', $do, 'statistics', ''),
            //         // 2 => $this->createMainMenu('商家分析', $do, 'selleranaly', '')
            //     )
            // );
            $navemenu[14] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=settings&m=zh_dianc" class="panel-title wytitle" id="yframe-14"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  系统设置</a>',
                'items' => array(
                    0 => $this->createMainMenu('基本信息 ', $do, 'settings', ''),
                    1 => $this->createMainMenu('小程序配置', $do, 'peiz', ''),
                    2 => $this->createMainMenu('支付配置', $do, 'pay', ''),
                     3 => $this->createMainMenu('达达配置 ', $do, 'dasettings', ''),
                    4 => $this->createMainMenu('模板消息', $do, 'template', ''),  
                    5 => $this->createMainMenu('邮件通知', $do, 'email', ''), 
                    6 => $this->createMainMenu('帮助中心', $do, 'help', ''),                      
                    // 6 => $this->createMainMenu('系统更新', $do, 'heli', ''),
                    // 7 => $this->createMainMenu('版权设置', $do, 'banquanset', ''),   
                )
            );
            if ($_W['role'] == 'founder'){
                 $navemenu[15] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=wxapplist&m=zh_dianc" class="panel-title wytitle" id="yframe-15"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  权限设置</a>',
                'items' => array(
                     1 => $this->createMainMenu('小程序列表', $do, 'wxapplist', ''), 
                   
                )
            );
            } 
           
            
        }
        return $navemenu;
    }















     public function getMainMenu2()
    {
        global $_W, $_GPC;

        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = ' style="color:#d9534f;" ';
        if($_W['isfounder'] || $_W['role'] == 'manager' || $_W['role'] == 'operator') {
            $navemenu[0] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=index&m=zh_dianc" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-key"></icon>  门店设置</a>',
                'items' => array(
                    0 => $this->createMainMenu('数据概况', $do, 'index', ''),
                    1 => $this->createMainMenu('门店信息 ', $do, 'storeinfo', ''),
                    2 => $this->createMainMenu('营业时间 ', $do, 'yingyetime', ''),
                    3 => $this->createMainMenu('配送设置 ', $do, 'peisongset', ''),
                    // 2 => $this->createMainMenu('销售统计 ', $do, 'ygdata', ''),
                    // 4 => $this->createMainMenu('员工管理 ', $do, 'test2', ''),
                    4 => $this->createMainMenu('积分设置 ', $do, 'injfset', ''),
                    5 => $this->createMainMenu('支付设置', $do, 'inpay', '')
                )
            );
             $navemenu[1] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=inorder&m=zh_dianc" class="panel-title wytitle" id="yframe-1"><icon style="color:#8d8d8d;" class="fa fa-bars"></icon>  订单管理</a>',
                'items' => array(
                     3 => $this->createMainMenu('当面付订单', $do, 'indmorder', ''),
                    0 => $this->createMainMenu('外卖订单', $do, 'inorder', ''),
                    1 => $this->createMainMenu('店内订单', $do, 'indnorder', ''),
                    2 => $this->createMainMenu('预约订单', $do, 'inydorder', ''),
                   
                )
            );
            
           
            $navemenu[2] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=dishes2&m=zh_dianc" class="panel-title wytitle" id="yframe-2"><icon style="color:#8d8d8d;" class="fa fa-trophy"></icon>  商品管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('商品列表 ', $do, 'dishes2', ''),
                    // 1 => $this->createMainMenu('添加菜品', $do, 'adddishes', ''),
                    2 => $this->createMainMenu('商品分类', $do, 'dishestype', ''),
                    // 3 => $this->createMainMenu('添加分类', $do, 'adddishestype', ''),
                )
            );
            $navemenu[3] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=table2&m=zh_dianc" class="panel-title wytitle" id="yframe-3"><icon style="color:#8d8d8d;" class="fa fa-binoculars"></icon>  餐桌管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('餐桌列表 ', $do, 'table2', ''),
                    // 1 => $this->createMainMenu('添加餐桌', $do, 'addtable', ''),
                    2 => $this->createMainMenu('餐桌类型', $do, 'tabletype2', ''),
                    // 3 => $this->createMainMenu('添加餐桌类型', $do, 'addtabletype', ''),
                  //  4 => $this->createMainMenu('预定付款管理', $do, 'yypay', ''),
                   5 => $this->createMainMenu('餐桌设置', $do, 'intabelset', ''),
                )
            );
            $navemenu[4] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygquan&m=zh_dianc" class="panel-title wytitle" id="yframe-4"><icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  营销设置</a>',
                'items' => array(
                     0 => $this->createMainMenu('营销插件 ', $do, 'ygquan', ''),
                     1 => $this->createMainMenu('满减活动 ', $do, 'injian', ''),
                     2 => $this->createMainMenu('优惠券 ', $do, 'coupons', ''),
                     3 => $this->createMainMenu('代金券 ', $do, 'voucher', ''),
                     // 4 => $this->createMainMenu('积分设置 ', $do, 'injfset', ''),
                     4 => $this->createMainMenu('短信通道 ', $do, 'insms', ''),
                     5 => $this->createMainMenu('达达配送 ', $do, 'dada', ''),
                     6 => $this->createMainMenu('UU跑腿 ', $do, 'uuset', ''),
                     7 => $this->createMainMenu('人人快递 ', $do, 'rrset', ''),
                     8 => $this->createMainMenu('自动接单 ', $do, 'laoz', ''),
                     9 => $this->createMainMenu('门店媒体 ', $do, 'mt', '')
                )
            );
            $navemenu[5] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=ygdata&m=zh_dianc" class="panel-title wytitle" id="yframe-5"><icon style="color:#8d8d8d;" class="fa fa-key"></icon>  数据统计</a>',
                'items' => array(
                    0 => $this->createMainMenu('销售统计', $do, 'ygdata', ''),
                    1 => $this->createMainMenu('消费排行 ', $do, 'ygranking', ''),
                    // 2 => $this->createMainMenu('经营分析 ', $do, 'inanalysis', ''),

                )
            );
            
            $navemenu[6] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=intx&m=zh_dianc" class="panel-title wytitle" id="yframe-6"><icon style="color:#8d8d8d;" class="fa fa-book"></icon>  提现管理</a>',
                'items' => array(
                    0 => $this->createMainMenu('申请提现', $do, 'intx', ''),
                     1 => $this->createMainMenu('提现流水', $do, 'intxlist', ''),
                     
                )
            );
            // $navemenu[7] = array(
            //     'title' => '<a href="index.php?c=site&a=entry&op=display&do=inpay&m=zh_dianc" class="panel-title wytitle" id="yframe-7"><icon style="color:#8d8d8d;" class="fa fa-money"></icon>  支付设置</a>',
            //     'items' => array(
            //          0 => $this->createMainMenu('支付设置', $do, 'inpay', ''),
            //     )
            // );
            
         /*    $navemenu[8] = array(
                'title' => '<icon style="color:#8d8d8d;" class="fa fa-gift"></icon>  UU跑腿',
                'items' => array(
                     0 => $this->createMainMenu('UU跑腿设置 ', $do, 'uuset', ''),
                )
            );*/
            $navemenu[8] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=print&m=zh_dianc" class="panel-title wytitle" id="yframe-8"><icon style="color:#8d8d8d;" class="fa fa-clipboard"></icon>  打印设置</a>',
                'items' => array(
                     0 => $this->createMainMenu('打印设备 ', $do, 'print', ''),
                     1 => $this->createMainMenu('添加打印 ', $do, 'addprint', ''),
                )
            );
            $navemenu[9] = array(
                'title' => '<a href="index.php?c=site&a=entry&op=display&do=assess2&m=zh_dianc" class="panel-title wytitle" id="yframe-9"><icon style="color:#8d8d8d;" class="fa fa-user"></icon>  评论管理</a>',
                'items' => array(
                     0 => $this->createMainMenu('评论管理 ', $do, 'assess2', ''),
                )
            );

        }
        return $navemenu;
    }





























   public function getNaveMenu($storeid, $action)
    {
        global $_W, $_GPC;
        
        $storeInfo=pdo_get('wpdc_store',array('id'=>$storeid));
        $array=array( $this->createSubMenu('当面付订单', $do, 'dlindmorder', 'fa-angle-right', $cur_color, $storeid),);
           if($storeInfo['is_wm']==1){
            array_push($array, $this->createSubMenu('外卖订单', $do, 'dlinorder', 'fa-angle-right', $cur_color, $storeid));
        }
           if($storeInfo['is_dn']==1){
            array_push($array, $this->createSubMenu('店内订单', $do, 'dlindnorder', 'fa-angle-right', $cur_color, $storeid));
        }

        if($storeInfo['is_yy']==1){
            array_push($array,$this->createSubMenu('预约订单', $do, 'dlinydorder', 'fa-angle-right', $cur_color, $storeid));
        }
      
        $do = $_GPC['do'];
        $navemenu = array();
        $cur_color = '#8d8d8d';
        $navemenu[0] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=start&m=zh_dianc" class="panel-title wytitle" id="yframe-0"><icon style="color:#8d8d8d;" class="fa fa-cog"></icon>  门店设置</a>',
            'items' => array(
                0 => $this->createSubMenu('数据概况', $do, 'start', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('门店信息 ', $do, 'dlstoreinfo', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('营业时间 ', $do, 'dlyingyetime', 'fa-angle-right', $cur_color, $storeid),
                3 => $this->createSubMenu('配送设置 ', $do, 'dlpeisongset', 'fa-angle-right', $cur_color, $storeid),
                4 => $this->createSubMenu('积分设置 ', $do, 'dlinjfset','fa-angle-right', $cur_color, $storeid),
                5 => $this->createSubMenu('支付设置', $do, 'dlinpay', 'fa-angle-right', $cur_color, $storeid),
            ),
            'icon' => 'fa fa-user-md'
        );
        $cur_color = '#8d8d8d';
        $navemenu[1] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlinorder&m=zh_dianc" class="panel-title wytitle" id="yframe-1"><icon style="color:' . $cur_color . ';" class="fa fa-bars"></icon>  订单管理</a>',
           
           /* 'items' => array(
                0 => $this->createSubMenu('外卖订单', $do, 'dlinorder', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('店内订单', $do, 'dlindnorder', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('预订订单', $do, 'dlinydorder', 'fa-angle-right', $cur_color, $storeid),
                3 => $this->createSubMenu('当面付订单', $do, 'dlindmorder', 'fa-angle-right', $cur_color, $storeid),
              
            )*/
            'items' =>$array

        );
        $cur_color = '#8d8d8d';
        $navemenu[2] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dldishes2&m=zh_dianc" class="panel-title wytitle" id="yframe-2"><icon style="color:' . $cur_color . ';" class="fa fa-trophy"></icon> 商品管理</a>',
            'items' => array(
                0 => $this->createSubMenu('商品列表 ', $do, 'dldishes2', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('商品分类', $do, 'dldishestype', 'fa-angle-right', $cur_color, $storeid),
               
            )
        );

        $cur_color = '#8d8d8d';

        if($storeInfo['is_dn']==1||$storeInfo['is_yy']==1){
            $navemenu[3] = array(
                'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dltable2&m=zh_dianc" class="panel-title wytitle" id="yframe-3"><icon style="color:' . $cur_color . ';" class="fa fa-binoculars"></icon>  餐桌管理</a>',
                'items' => array(
                    0 => $this->createSubMenu('餐桌列表 ', $do, 'dltable2', 'fa-angle-right', $cur_color, $storeid),
                    1 => $this->createSubMenu('餐桌类型', $do, 'dltabletype2', 'fa-angle-right', $cur_color, $storeid),
                     5 => $this->createSubMenu('餐桌设置', $do, 'dlintabelset', 'fa-angle-right', $cur_color, $storeid),
                ),
            );
   
        }
        $cur_color = '#8d8d8d';
        $navemenu[4] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlygquan&m=zh_dianc" class="panel-title wytitle" id="yframe-4"><icon style="color:' . $cur_color . ';" class="fa fa-gift"></icon>  营销设置</a>',
            'items' => array(
                0 => $this->createSubMenu('营销插件 ', $do, 'dlygquan', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('满减活动 ', $do, 'dlinjian', 'fa-angle-right', $cur_color, $storeid),
                2 => $this->createSubMenu('优惠券 ', $do, 'dlcoupons', 'fa-angle-right', $cur_color, $storeid),
                3 => $this->createSubMenu('代金券 ', $do, 'dlvoucher', 'fa-angle-right', $cur_color, $storeid),
                
                4 => $this->createSubMenu('短信通道 ', $do, 'dlinsms', 'fa-angle-right', $cur_color, $storeid),
                5 => $this->createSubMenu('达达配送 ', $do, 'dldada', 'fa-angle-right', $cur_color, $storeid),
                6 => $this->createSubMenu('UU跑腿 ', $do, 'dluuset','fa-angle-right', $cur_color, $storeid),
                7 => $this->createSubMenu('人人快递 ', $do, 'dlrrset','fa-angle-right', $cur_color, $storeid),
                8 => $this->createSubMenu('自动接单 ', $do, 'dllaoz','fa-angle-right', $cur_color, $storeid),
                9 => $this->createSubMenu('门店媒体 ', $do, 'dlmt','fa-angle-right', $cur_color, $storeid),
            )
        );

        $cur_color = '#8d8d8d';
        $navemenu[5] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlygdata&m=zh_dianc" class="panel-title wytitle" id="yframe-5"><icon style="color:' . $cur_color . ';" class="fa fa-key"></icon>  数据统计</a>',
            'items' => array(
                0 => $this->createSubMenu('销售统计', $do, 'dlygdata', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('消费排行 ', $do, 'dlygranking', 'fa-angle-right', $cur_color, $storeid),
                // 2 => $this->createSubMenu('经营分析 ', $do, 'dlinanalysis', 'fa-angle-right', $cur_color, $storeid),
            )
        );
        $cur_color = '#8d8d8d';
        $navemenu[6] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlintx&m=zh_dianc" class="panel-title wytitle" id="yframe-6"><icon style="color:' . $cur_color . ';" class="fa fa-money"></icon>  提现管理</a>',
            'items' => array(
                0 => $this->createSubMenu('申请提现', $do, 'dlintx', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('提现流水', $do, 'dlintxlist', 'fa-angle-right', $cur_color, $storeid),
                
            )
        );
        //   $cur_color = '#8d8d8d';
        // $navemenu[7] = array(
        //     'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlinpay&m=zh_dianc" class="panel-title wytitle" id="yframe-7"><icon style="color:' . $cur_color . ';" class="fa fa-jpy"></icon>  支付设置</a>',
        //     'items' => array(
        //         0 => $this->createSubMenu('支付设置', $do, 'dlinpay', 'fa-angle-right', $cur_color, $storeid),
               
        //     )
        // );
         $cur_color = '#8d8d8d';
        $navemenu[8] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlprint&m=zh_dianc" class="panel-title wytitle" id="yframe-8"><icon style="color:' . $cur_color . ';" class="fa fa-database"></icon>  打印设置</a>',
            'items' => array(
                0 => $this->createSubMenu('打印设备 ', $do, 'dlprint', 'fa-angle-right', $cur_color, $storeid),
                1 => $this->createSubMenu('添加打印 ', $do, 'dladdprint', 'fa-angle-right', $cur_color, $storeid),
            )
        );
          $cur_color = '#8d8d8d';
        $navemenu[9] = array(
            'title' => '<a href="zhstore.php?c=site&a=entry&op=display&do=dlassess2&m=zh_dianc" class="panel-title wytitle" id="yframe-9"><icon style="color:' . $cur_color . ';" class="fa fa-comments"></icon>  评论管理</a>',
            'items' => array(
                0 => $this->createSubMenu('评论管理 ', $do, 'dlassess2', 'fa-angle-right', $cur_color, $storeid),
            
            )
        );
        return $navemenu;
    }































    function createCoverMenu($title, $method, $op, $icon = "fa-image", $color = '#d9534f')
    {
        global $_GPC, $_W;
        $cur_op = $_GPC['op'];
        $color = ' style="color:'.$color.';" ';
        return array('title' => $title, 'url' => $op != $cur_op ? $this->createWebUrl($method, array('op' => $op)) : '',
            'active' => $op == $cur_op ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa fa-angle-right"></i>',
            )
        );
    }

    function createMainMenu($title, $do, $method, $icon = "fa-image", $color = '')
    {
        $color = ' style="color:'.$color.';" ';

        return array('title' => $title, 'url' => $do != $method ? $this->createWebUrl($method, array('op' => 'display')) : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i '.$color.' class="fa fa-angle-right"></i>',
            )
        );
    }

  /*  function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $storeid)
    {
        $color = ' style="color:'.$color.';" ';
        $url = $this->createWebUrl($method, array('op' => 'display', 'storeid' => $storeid));
        if ($method == 'stores') {
            $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid, 'storeid' => $storeid));
        }

        return array('title' => $title, 'url' => $do != $method ? $url : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa '.$icon.'"></i>',
            )
        );
    }

*/
    function createWebUrl2($do, $query = array()) {
        $query['do'] = $do;
        $query['m'] = strtolower($this->modulename);
      
        return $this->wurl('site/entry', $query);
    }

    function wurl($segment, $params = array()) {
      
    list($controller, $action, $do) = explode('/', $segment);
    $url = './zhstore.php?';
    if (!empty($controller)) {
        $url .= "c={$controller}&";
    }
    if (!empty($action)) {
        $url .= "a={$action}&";
    }
    if (!empty($do)) {
        $url .= "do={$do}&";
    }
    if (!empty($params)) {
        $queryString = http_build_query($params, '', '&');
        $url .= $queryString;
    }
    return $url;
}

        function createSubMenu($title, $do, $method, $icon = "fa-image", $color = '#d9534f', $storeid)
    {
        $color = ' style="color:'.$color.';" ';
        $url = $this->createWebUrl2($method, array('op' => 'display', 'storeid' => $storeid));
        if ($method == 'stores2') {
            $url = $this->createWebUrl2('stores2', array('op' => 'post', 'id' => $storeid, 'storeid' => $storeid));
        }



        return array('title' => $title, 'url' => $do != $method ? $url : '',
            'active' => $do == $method ? ' active' : '',
            'append' => array(
                'title' => '<i class="fa '.$icon.'"></i>',
            )
        );
    }
    public function getStoreById($id)
    {
        $store = pdo_fetch("SELECT * FROM " . tablename('wpdc_store') . " WHERE id=:id LIMIT 1", array(':id' => $id));
        return $store;
    }


    public function set_tabbar($action, $storeid)
    {
        $actions_titles = $this->actions_titles;
        $html = '<ul class="nav nav-tabs">';
        foreach ($actions_titles as $key => $value) {
            if ($key == 'stores') {
                $url = $this->createWebUrl('stores', array('op' => 'post', 'id' => $storeid));
            } else {
                $url = $this->createWebUrl($key, array('op' => 'display', 'storeid' => $storeid));
            }

            $html .= '<li class="' . ($key == $action ? 'active' : '') . '"><a href="' . $url . '">' . $value . '</a></li>';
        }
        $html .= '</ul>';
        return $html;
    }
}