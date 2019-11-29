<?php defined('IN_IA') or exit('Access Denied');?><div class="fui-navbar">
			<a href="<?php  echo mobileUrl('sns')?>" class="external nav-item <?php  if($_W['routes'] == 'sns') { ?>active<?php  } ?>">
				<span class="icon icon-home"></span>
				<span class="label">首页</span>
			</a>
			
			<a href="<?php  echo mobileUrl('sns/board/lists')?>" class="external nav-item <?php  if($_W['routes'] == 'sns.board.lists') { ?>active<?php  } ?>">
				<span class="icon icon-list"></span>
				<span class="label">版块</span>
			</a>
			
			<a href="<?php  echo mobileUrl('sns/user')?>" class="external nav-item <?php  if($_W['routes'] == 'sns.user') { ?>active<?php  } ?>">
				<span class="icon icon-person2"></span>
				<span class="label">我的</span>
			</a>

</div>

<!--OTEzNzAyMDIzNTAzMjQyOTE0-->