<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="fui-page order-express-page">
    <div class="fui-header">
	<div class="fui-header-left">
	    <a class="back"></a>
	</div>
	<div class="title">物流信息</div> 
	<div class="fui-header-right">&nbsp;</div>
    </div>
    <div class='fui-content'>
    <div class="fui-list-group info-list">  
	<div class="fui-list">
	    <a class="fui-list-media back">
		<img src="<?php  echo tomedia($goods['thumb'])?>">
		<div class="title">1件商品</div>
	    </a>
	    <div class="fui-list-inner">
		<div class="title state">物流状态 
		    <?php  if(!empty($expresslist)) { ?>
		       <?php  if(strexists($expresslist[0]['step'],'已签收')) { ?>
			  <span class="text-danger2">已签收</span></div>
		       <?php  } else if(count($expresslist)<=2) { ?>
			  <span class="text-primary">备货中</span></div>
		       <?php  } else { ?>
			 <span class="text-success">配送中</span></div>
		       <?php  } ?>
		     <?php  } ?>
		<div class="text expcom">
		    <p>快递公司：<?php  echo $log['expresscom'];?></p>
		    <p>快递单号：<?php  echo $log['expresssn'];?></p>
		</div>
	    </div>
	</div>
    </div>
    
	<?php  if(empty($expresslist)) { ?>
	<div class='content-empty'>
	    <i class='icon icon-deliver1'></i><br/><span class='text'>暂时没有物流信息</span>
	</div>
	<?php  } else { ?>
	<div class="fui-list-group express-list" style="margin-top: 0.5rem;">
	<?php  if(is_array($expresslist)) { foreach($expresslist as $k => $ex) { ?>
	    	<div class="fui-list <?php  if($k==0) { ?>current<?php  } ?>">
	    		<div class="fui-list-inner">
			    <div class="text step"><?php  echo $ex['step'];?></div>
	    		    <div class="text time"><?php  echo $ex['time'];?></div>
	    		</div>
	    	</div>
                    <?php  } } ?>
	    </div>
	<?php  } ?>
	
    
         </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--OTEzNzAyMDIzNTAzMjQyOTE0-->