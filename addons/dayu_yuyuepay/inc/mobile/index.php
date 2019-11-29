<?php
		$id = intval($_GPC['id']);
		$returnUrl = urlencode($_W['siteurl']);
		if($id){
			$cate = pdo_get($this->tb_category, array('weid' => $weid, 'id' => $id), array());
			$color = !empty($cate['color']) ? iunserializer($cate['color']) : '';
			$nav_index = $color['nav_index'];
			$nav_page = $color['nav_page'];
			$nav_btn = $color['nav_btn'];
			$title = $cate['title'];
			$where.=" and cid='{$id}'";
			$list_num = !empty($cate['list']) ? $cate['list'] : 1;
			if ($cate['list']=='3'){
				$list_num = '4';
			}elseif ($cate['list']=='4'){
				$list_num = '3';
			}
		}else{
			$title = $setting['title'];
			$nav_index = $setting['color']['nav_index'];
			$nav_page = $setting['color']['nav_page'];
			$nav_btn = $setting['color']['nav_btn'];
			$list_num = !empty($setting['style']['list']) ? $setting['style']['list'] : 1;
		}
		$slide = pdo_fetchall("SELECT * FROM " . tablename($this->tb_slide) . " WHERE weid = :weid $where ORDER BY displayorder DESC", array(':weid' => $weid));
        foreach($slide AS $key => $val){
            $slide[$key]['thumb'] = tomedia($val['thumb']);	
        }
		$category = pdo_fetchall("select * from ".tablename($this->tb_category)." where weid = :weid ORDER BY id DESC", array(':weid' => $weid));
		
		$is_list .= " AND is_list = 1";	
		$yuyue = pdo_fetchAll("SELECT reid,weid,title,is_time,icon,thumb,subtitle,status,description,content,displayorder FROM".tablename($this->tb_yuyue)." WHERE status=1 AND weid='{$weid}' $is_list $where order by displayorder DESC,reid DESC");
        foreach($yuyue AS $index => $v){
			$yuyue[$index]['par'] = iunserializer($v['par']);
			$yuyue[$index]['num'] = $list_num=='4' ? '4' : '8';
//			$yuyue[$index]['link'] = $v['is_time']==2 ? $this->createMobileUrl('timelist',array('id' => $v['reid'])) : $this->createMobileUrl('dayu_yuyuepay',array('id' => $v['reid']));
			$yuyue[$index]['link'] = $this->createMobileUrl('dayu_yuyuepay',array('id' => $v['reid']));
			$yuyue[$index]['subtitle'] = !empty($yuyue[$index]['par']['subtitle']) ? mb_substr($yuyue[$index]['par']['subtitle'],0,$yuyue[$index]['num'],'utf-8') : mb_substr($v['title'],0,$yuyue[$index]['num'],'utf-8');
        }
		include $this->template('index');
?>