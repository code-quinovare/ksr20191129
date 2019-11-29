<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script>document.title = "我的产品"; </script>
<div class="fui-page fui-page-current page-commission-log">
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">我的产品</div>
    </div>
    
    <div class="fui-content">
        

        <div class='content-empty' style='display:none;'>
            <i class='icon icon-manageorder'></i><br/>暂时没有任何数据
        </div>
        <div class="fui-list-group" id="container"></div>
        <div class='infinite-loading'><span class='fui-preloader'></span><span class='text'> 正在加载...</span></div>



<script id='tpl_cashier_lineup_list' type='text/html'>
    <%each list as log%>
        <div class="fui-list">
            <div class="fui-list-inner">
                <div class="row">
                     <p>产 品 名 称：<%log.productname%></p>
                    
                </div>
                <div class="row">
                    <p >注册器编号：<%log.zcode%></p>
                </div>
                <div class="subtitle" style="color: #999;">
                    <p>注　册　码：<%log.num%>　</p>
                   <p>您已在<%log.createtime%>完成产品注册，并获赠五年延保！</p> 
                </div>
            </div>
        </div>
    <%/each%>
</script>
   </div>

<script language='javascript'>
    require(['../addons/ewei_shopv2/plugin/product/static/js/list.js'], function (modal) {
        modal.init();
    });
</script>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>