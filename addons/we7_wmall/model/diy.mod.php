<?php
/**
 * 外送系统
 * @author 说图谱网
 * @url http://www.shuotupu.com/
 */
defined('IN_IA') or exit('Access Denied');

function get_wxapp_diy($pageOrid, $mobile = false, $extra = array()) {
	global $_W;
	if(is_array($pageOrid)) {
		$page = $pageOrid;
	} else {
		$id = intval($pageOrid);
		if(empty($id)) {
			return false;
		}
		$table_name = 'tiny_wmall_wxapp_page';
		$params = array(
			'uniacid' => $_W['uniacid'],
			'id' => $id
		);
		if(!empty($extra) && $extra['from'] == 'wap') {
			$table_name = 'tiny_wmall_diypage';
			$params['version'] = 2;
		}
		$page = pdo_get($table_name, $params);
	}
	if(empty($page)) {
		return false;
	}
	$page['data'] = base64_decode($page['data']);
	$page['data'] = json_decode($page['data'], true);
	$page['parts'] = array();
	$page['is_has_location'] = $page['is_has_allstore'] = $page['is_show_cart'] = $page['is_show_redpacket'] = 0;
	$page['danmu'] = array();
	foreach($page['data']['items'] as $item) {
		$page['parts'][] = $item['id'];
		if($item['id'] == 'fixedsearch') {
			$page['is_has_location'] = 1;
		} elseif($item['id'] == 'waimai_allstores') {
			$page['is_has_allstore'] = 1;
			$page['stores_list']['diyitems'] = $item;
			$page['stores_list']['orderbys'] = store_orderbys();
			$page['stores_list']['discounts'] = store_discounts();
		} elseif($item['id'] == 'cart') {
			if($item['params']['showcart'] == 1) {
				$page['is_show_cart'] = 1;
			}
		} elseif($item['id'] == 'redpacket') {
			if($item['params']['showredpacket'] == 1) {
				$page['is_show_redpacket'] = 1;
			}
		}
	}
	if(!$mobile) {
		if(!empty($page['data']['items']) && is_array($page['data']['items'])) {
			foreach($page['data']['items'] as $itemid => &$item) {
				if($item['id'] == 'waimai_goods') {
					$item['data'] = get_wxapp_waimai_goods($item);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'waimai_stores') {
					$item['data'] = get_wxapp_waimai_store($item);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'notice') {
					$item['data'] = get_wxapp_notice($item);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'bargain') {
					$result = get_wxapp_bargains($item);
					$item['data'] = $result['data'];
					$item['data_num'] = $result['data_num'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'selective') {
					$result = get_wxapp_waimai_recommend_store($item);
					$item['data'] = $result['data'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'navs') {
					$result = get_wxapp_navs($item);
					$item['data'] = $result['data'];
					$item['data_num'] = $result['data_num'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'richtext') {
					$item['params']['content'] = htmlspecialchars_decode($item['params']['content']);
				}  elseif($item['id'] == 'activity') {
					$result = get_wxapp_cubes($item);
					$item['data'] = $result['data'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'picture') {
					if(empty($item['style'])) {
						$item['style'] = array(
							'background' => '#ffffff',
							'paddingtop' => '0',
							'paddingleft' => '0'
						);
					}
					if(empty($item['params'])) {
						$item['params'] = array(
							'picturedata' => 0,
						);
					}
					$result = get_wxapp_slides($item);
					$item['data'] = $result['data'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} else {
					if($item['id'] == 'picturew') {
						if(empty($item['style'])) {
							$item['style'] = array(
								'background' => '#ffffff',
								'paddingtop' => '0',
								'paddingleft' => '0'
							);
						}
					} elseif(empty($item['id'])) {
						unset($page['data']['items'][$itemid]);
					}
				}
			}
			unset($item);
			pdo_update($table_name, array('data' => base64_encode(json_encode($page['data']))), array('uniacid' => $_W['uniacid'], 'id' => $id));
		}
	} else {
		if(!empty($page['data']['items']) && is_array($page['data']['items'])) {
			foreach($page['data']['items'] as $itemid => &$item) {
				if($item['id'] == 'richtext') {
					$item['params']['content'] = base64_decode($item['params']['content']);
				} elseif($item['id'] == 'waimai_goods') {
					$item['data'] = get_wxapp_waimai_goods($item, true);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'waimai_stores') {
					$item['data'] = get_wxapp_waimai_store($item, true);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'selective') {
					$result = get_wxapp_waimai_recommend_store($item, true);
					$item['data'] = $result['data'];
					$item['data_num'] = $result['data_num'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'bargain') {
					$result = get_wxapp_bargains($item, true);
					$item['data'] = $result['data'];
					$item['data_num'] = $result['data_num'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif(in_array($item['id'], array('copyright', 'notice', 'img_card'))) {
					$item['params']['imgurl'] = tomedia($item['params']['imgurl']);
					if($item['id'] == 'notice') {
						$item['data'] = get_wxapp_notice($item, true);
						if(empty($item['data'])) {
							unset($page['data']['items'][$itemid]);
						}
					}
				} elseif(in_array($item['id'], array('banner', 'graphic')) && !empty($item['data'])) {
					foreach($item['data'] as &$v) {
						$v['imgurl'] = tomedia($v['imgurl']);
					}
				} elseif($item['id'] == 'picturew' && !empty($item['data'])) {
					foreach($item['data'] as &$v) {
						$v['imgurl'] = tomedia($v['imgurl']);
					}
					$item['data_num'] = count($item['data']);
					if($item['params']['row'] == 1) {
						$item['data'] = array_values($item['data']);
					} else {
						if($item['params']['showtype'] == 1 && count($item['data']) > $item['params']['pagenum']) {
							$item['data'] = array_chunk($item['data'], $item['params']['pagenum']);
							$item['style']['rows_num'] = ceil($item['params']['pagenum']/$item['params']['row']);
							$row_base_height = array(
								'2' => 122,
								'3' => 85,
								'4' => 65,
							);
							$item['style']['base_height'] = $row_base_height[$item['params']['row']];
						}
					}
				} elseif($item['id'] == 'navs' && !empty($item['data'])) {
					$result = get_wxapp_navs($item, true);
					$item['data'] = $result['data'];
					$item['data_num'] = $result['data_num'];
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'danmu') {
					$config_danmu['params'] = $item['params'];
					$result = get_wxapp_danmu($config_danmu);
					$item['members'] = $result['members'];
					$page['danmu'] = $result['members'];
				} elseif($item['id'] == 'memberHeader') {
					$item['member'] = $_W['member'];
					if($item['params']['headerstyle'] == 'img') {
						$item['params']['backgroundimgurl'] = tomedia($item['params']['backgroundimgurl']);
					}
				} elseif($item['id'] == 'memberBindMobile') {
					if(!empty($_W['member']['mobile'])) {
						$item['has_mobile'] = 1;
					}
				} elseif($item['id'] == 'blockNav') {
					if(!empty($item['data'])) {
						foreach($item['data'] as &$value) {
							$value['imgurl'] = tomedia($value['imgurl']);
							if($value['linkurl'] == 'pages/member/redPacket/index') {
								$redpacket_nums = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_activity_redpacket_record') . ' where uniacid = :uniacid and uid = :uid and status = 1', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'])));
								if($redpacket_nums > 0) {
									$value['placeholder'] = "{$redpacket_nums}个未使用";
								}
							} elseif($value['linkurl'] == 'pages/member/coupon/index') {
								$coupon_nums = intval(pdo_fetchcolumn('select count(*) from ' . tablename('tiny_wmall_activity_coupon_record') . ' where uniacid = :uniacid and uid = :uid and status = 1', array(':uniacid' => $_W['uniacid'], ':uid' => $_W['member']['uid'])));
								if($coupon_nums > 0) {
									$value['placeholder'] = "{$coupon_nums}个未使用";
								}
							} elseif($value['linkurl'] == 'pages/deliveryCard/index') {
								$deliveryCard_status = check_plugin_perm('deliveryCard') && get_plugin_config('deliveryCard.card_apply_status');
								$value['placeholder'] = '暂未购买';
								if($deliveryCard_status && $_W['member']['setmeal_id'] > 0 && $_W['member']['setmeal_endtime'] > TIMESTAMP) {
									$value['placeholder'] = '已购买';
								}
							}
						}
					}
				} elseif($item['id'] == 'activity') {
					$result = get_wxapp_cubes($item);
					$item['data'] = array_values($result['data']);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				} elseif($item['id'] == 'picture') {
					$result = get_wxapp_slides($item);
					$item['data'] = array_values($result['data']);
					if(empty($item['data'])) {
						unset($page['data']['items'][$itemid]);
					}
				}
			}
			unset($item);
		}
	}
	return $page;
}

function get_wap_defaultpage($type = 'home') {
	global $_W;
	$pages = array(
		'home' => array (
			'uniacid' => $_W['uniacid'],
			'name' => '自定义DIY',
			'type' => '1',
			'data' => 'eyJwYWdlIjp7InR5cGUiOiIxIiwidGl0bGUiOiJcdThiZjdcdThmOTNcdTUxNjVcdTk4NzVcdTk3NjJcdTY4MDdcdTk4OTgiLCJuYW1lIjoiamRraiIsImRlc2MiOiIiLCJrZXl3b3JkIjoiIiwiYmFja2dyb3VuZCI6IiNGM0YzRjMiLCJkaXlnb3RvcCI6IjAiLCJuYXZpZ2F0aW9uYmFja2dyb3VuZCI6IiMwMDAwMDAiLCJuYXZpZ2F0aW9udGV4dGNvbG9yIjoiI2ZmZmZmZiJ9LCJpdGVtcyI6eyJNMTUzMjUwNjQ1NDM5OSI6eyJwYXJhbXMiOnsibG9jYXRpb24iOiJcdTViOWFcdTRmNGQiLCJ0ZXh0IjoiXHU4YmY3XHU4ZjkzXHU1MTY1XHU1NTQ2XHU2MjM3XHU2MjE2XHU1NTQ2XHU1NGMxXHU1NDBkXHU3OWYwIn0sInN0eWxlIjp7ImxvY3N0eWxlIjoicmFkaXVzIiwic2VhcmNoc3R5bGUiOiJyYWRpdXMiLCJmaXhlZGJhY2tncm91bmQiOiIjZmYyYjRkIiwibG9jYmFja2dyb3VuZCI6IiM5OTk5OTkiLCJzZWFyY2hiYWNrZ3JvdW5kIjoiI2Y0ZjRmNCIsImxvY2NvbG9yIjoiI2ZmZmZmZiIsInNlYXJjaGNvbG9yIjoiIzY1NjU2NSJ9LCJtYXgiOiIxIiwiaXN0b3AiOiIxIiwiaWQiOiJmaXhlZHNlYXJjaCJ9LCJNMTUzMzAzMTU4MDMxMCI6eyJwYXJhbXMiOnsicGljdHVyZWRhdGEiOiIxIn0sInN0eWxlIjp7InBhZGRpbmd0b3AiOiIxMCIsInBhZGRpbmdsZWZ0IjoiMTAiLCJkb3RiYWNrZ3JvdW5kIjoiI2ZmMmQ0YiIsImJhY2tncm91bmQiOiIjZmFmYWZhIn0sImRhdGEiOnsiQzEwMjgzNTcxODQiOnsibGlua3VybCI6IiIsImltZ3VybCI6Imh0dHBzOlwvXC8xLnhpbnp1b3dsLmNvbVwvYXR0YWNobWVudFwvaW1hZ2VzXC8xXC8yMDE3XC8wMlwva2s5TWRJWUg1aEh5NkdnaUc1Tm5PSUtoSTk2bzhpLmpwZyJ9LCJDMTMxMDg5MDM0OCI6eyJsaW5rdXJsIjoiaHR0cHM6XC9cLzEueGluenVvd2wuY29tXC9hcHBcL2luZGV4LnBocD9pPTEmYz1lbnRyeSZjdHJsPWZyZWVMdW5jaCZhYz1mcmVlTHVuY2gmb3A9aW5kZXgmZG89bW9iaWxlJm09d2U3X3dtYWxsIiwiaW1ndXJsIjoiaHR0cHM6XC9cLzEueGluenVvd2wuY29tXC9hdHRhY2htZW50XC9pbWFnZXNcLzFcLzIwMTdcLzAyXC93VzdwN2xZN2JRWUJiaDhTMEJselUzcVY3dlVWNzMuanBnIn19LCJpZCI6InBpY3R1cmUifSwiTTE1MzI1Nzc4OTM3MjgiOnsicGFyYW1zIjp7InNob3d0eXBlIjoiMSIsInNob3dkb3QiOiIxIiwicm93bnVtIjoiNSIsInBhZ2VudW0iOiI4IiwibmF2c2RhdGEiOiIxIiwibmF2c251bSI6IjE2In0sInN0eWxlIjp7Im1hcmdpbnRvcCI6IjAiLCJuYXZzdHlsZSI6IiIsImRvdGJhY2tncm91bmQiOiIjZmYyZDRiIn0sImRhdGEiOnsiQzEyOTQ0MzQxNzEiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9MSIsInRleHQiOiJcdTcwZWRcdTUzNTZcdTdmOGVcdTk4ZGYiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL3UwMGg2MjZQNkgxODkxTHNQeXk5NlB4SHphWVRoeC5wbmcifSwiQzEwMDY0MTk3ODYiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9MiIsInRleHQiOiJcdTg0MjVcdTUxN2JcdTY1ZTlcdTk5MTAiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL3VVNjZLblJmNm5nNnY2TXY2Q1ZLbjdSbGxhclZyai5wbmcifSwiQzEyODM5OTczMjUiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9OCIsInRleHQiOiJcdTljOWNcdTgyYjFcdTdjZDVcdTcwYjkiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL1lrZnBCV3c1eWlQanhKUnF6cmpEaWpnendCcWRlay5wbmcifSwiQzEwMDkyOTgwNTIiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9NiIsInRleHQiOiJcdTdjYmVcdTU0YzFcdTVjMGZcdTU0MDMiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL0o0OGk0SUtLcEo4NzhKRUZ6M3JSOGZ6WGZaN2l4ei5wbmcifSwiQzEyNTE3MzU3MTAiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9NCIsInRleHQiOiJcdTRlMmRcdTg5N2ZcdTVmZWJcdTk5MTAiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL2Zia05TdnpzMHo2NVY1QTU3ZFcwNmt5NGF3bno3ZC5wbmcifSwiQzExOTYxODUxNjIiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9NyIsInRleHQiOiJcdTdmOGVcdTU0NzNcdTU5MWNcdTViYjUiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL20xMzVjZ2tsOG44dGdvVEtPS0c4VzMxMTM4NVJTbi5wbmcifSwiQzEyODU3NDkzMTQiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9MyIsInRleHQiOiJcdTc1MWNcdTcwYjlcdTk5NmVcdTU0YzEiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDFcL3RTRHZOY2NoOUFTajl2dUpoWkpNcDk4Y25QOE52SC5wbmcifSwiQzEzMjg0MTAyMzIiOnsibGlua3VybCI6InBhZ2VzXC9ob21lXC9jYXRlZ29yeT9jaWQ9MTUiLCJ0ZXh0IjoiXHU3NTFmXHU5YzljIiwiaW1ndXJsIjoiaHR0cHM6XC9cLzEueGluenVvd2wuY29tXC9hdHRhY2htZW50XC9pbWFnZXNcLzFcLzIwMTdcLzAxXC9KZ1RBNWJHdGcyazFDYWlUR3c1OTFHNW9NZ21jNEMucG5nIn0sIkMxMjA1MDMyNzA0Ijp7Imxpbmt1cmwiOiJwYWdlc1wvaG9tZVwvY2F0ZWdvcnk/Y2lkPTI0IiwidGV4dCI6Ilx1OGQyN1x1NTIzMFx1NGVkOFx1NmIzZSIsImltZ3VybCI6Imh0dHBzOlwvXC8xLnhpbnp1b3dsLmNvbVwvYXR0YWNobWVudFwvaW1hZ2VzXC8xXC8yMDE3XC8wMVwvUzZPODZ0TU9pMThrS1VQUDh1blR0dDh0UnU0NjMxLnBuZyJ9LCJDMTM1OTUyMDU0MSI6eyJsaW5rdXJsIjoicGFnZXNcL2hvbWVcL2NhdGVnb3J5P2NpZD00OCIsInRleHQiOiJcdTUyOWVcdTUxNmNcdTY1ODdcdTUxNzciLCJpbWd1cmwiOiIifX0sImlkIjoibmF2cyIsImRhdGFfbnVtIjoxMH0sIk0xNTMyNjAyNTUyODM1Ijp7InBhcmFtcyI6eyJub3RpY2VkYXRhIjoiMCIsIm5vdGljZW51bSI6IjEwIiwic3BlZWQiOiIzIiwiaW1ndXJsIjoiLi5cL2FkZG9uc1wvd2U3X3dtYWxsXC9wbHVnaW5cL3d4YXBwXC9zdGF0aWNcL2ltZ1wvZGVmYXVsdFwvaG90ZG90LnBuZyJ9LCJzdHlsZSI6eyJwYWRkaW5ndG9wIjoiMCIsInBhZGRpbmdsZWZ0IjoiMCIsInRleHRjb2xvciI6IiM2NjY2NjYiLCJpY29uY29sb3IiOiIjZmQ1NDU0IiwiYmFja2dyb3VuZCI6IiNmZmZmZmYifSwiZGF0YSI6eyJDMTI3NzA4OTQ4NSI6eyJpZCI6IjMiLCJ0aXRsZSI6Ilx1N2VhN1x1N2VhMlx1ODE4Zlx1NTkyN1x1NGU0Y1x1OWY5ZjE4XHU1M2VhOTlcdTUxNDNcdTMwMTEgXHU1NDA0XHU1NzMwXHU1OTdkXHU4N2Y5XHU2NzAwXHU1NDBlXHU0ZTAwXHU2Y2UyIiwibGlua3VybCI6IiJ9LCJDMTMzMjc2NTE3NSI6eyJpZCI6IjgiLCJ0aXRsZSI6Ilx1NTkyYVx1NTM5Zlx1NTMzYVx1NTdkZlx1NTE2Y1x1NTQ0YSIsImxpbmt1cmwiOiIifSwiQzEyOTUyODUxMzYiOnsiaWQiOiIzNiIsInRpdGxlIjoiZGRkIiwibGlua3VybCI6IiJ9fSwiaWQiOiJub3RpY2UifSwiTTE1MzI2ODA4OTA0NDAiOnsic3R5bGUiOnsiYmFja2dyb3VuZCI6IiNmZmZmZmYiLCJtYXJnaW5Ub3AiOiIxMCIsIm1hcmdpbkJvdHRvbSI6IjAifSwicGFyYW1zIjp7ImFjdGl2aXR5ZGF0YSI6IjEifSwiZGF0YSI6eyJDMTI3ODU3ODY3NSI6eyJsaW5rdXJsIjoiLlwvaW5kZXgucGhwP2k9MSZjPWVudHJ5JmN0cmw9d21hbGwmYWM9aG9tZSZvcD1zZWFyY2gmZG89bW9iaWxlJm09d2U3X3dtYWxsJmRpcz1tYWxsTmV3TWVtYmVyIiwidGV4dCI6Ilx1N2FjYlx1NTFjZlx1NGYxOFx1NjBlMCIsImltZ3VybCI6Imh0dHBzOlwvXC8xLnhpbnp1b3dsLmNvbVwvYXR0YWNobWVudFwvaW1hZ2VzXC8xXC8yMDE2XC8xMlwvbTNDQzNDNGpCQkNiR1VzYkVDQjNCNHZaYkNnUWdiLmpwZyIsInBsYWNlaG9sZGVyIjoiXHU2ZWUxXHU3YWNiXHU1MWNmXHU0ZjE4XHU2MGUwIiwiY29sb3IiOiIjZmYyZDRiIiwicGxhY2Vob2xkZXJDb2xvciI6IiM3YjdiN2IifSwiQzEyOTY0NjE0NzIiOnsibGlua3VybCI6Imh0dHBzOlwvXC8xLnhpbnp1b3dsLmNvbVwvYXBwXC9pbmRleC5waHA/aT0xJmM9ZW50cnkmY3RybD1mcmVlTHVuY2gmYWM9ZnJlZUx1bmNoJm9wPWluZGV4JmRvPW1vYmlsZSZtPXdlN193bWFsbCIsInRleHQiOiJcdTk3MzhcdTczOGJcdTk5MTAiLCJpbWd1cmwiOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxN1wvMDRcL0NmR3RnM3FRenRHaVBRMGtGUW4zaTBnbjBvUUdHTi5qcGciLCJwbGFjZWhvbGRlciI6Ilx1OTczOFx1NzM4Ylx1OTkxMCIsImNvbG9yIjoiI2ZmMmQ0YiIsInBsYWNlaG9sZGVyQ29sb3IiOiIjN2I3YjdiIn19LCJpZCI6ImFjdGl2aXR5In0sIk0xNTMxOTg1OTYwMTcyIjp7InBhcmFtcyI6eyJzaG93dHlwZSI6IjAiLCJwYWdlbnVtIjoiNiIsInN0b3JlZGF0YSI6IjEiLCJzdG9yZW51bSI6IjYiLCJ0aXRsZSI6Ilx1NGUzYVx1NjBhOFx1NGYxOFx1OTAwOSJ9LCJzdHlsZSI6eyJtYXJnaW50b3AiOiIxMCIsInRpdGxlY29sb3IiOiIjMzMzMzMzIiwic3RvcmVjb2xvciI6IiMzMzMzMzMiLCJkb3RiYWNrZ3JvdW5kIjoiI2ZmMmQ0YiIsInNob3dkb3QiOiIwIn0sImRhdGEiOnsiQzExMTIwNjQ2ODgiOnsiaWQiOiIzIiwidGl0bGUiOiJcdTgzMzZcdTRlMGRcdTYwMWQiLCJsb2dvIjoiaHR0cDpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxNlwvMTJcL2VjYzlFdTBMSXlyNjJhb09pQzZnb1U2YUxBY0lJQy5qcGciLCJmb3J3YXJkX21vZGUiOiIxIiwiZm9yd2FyZF91cmwiOiIiLCJ1cmwiOiJcL3BhZ2VzXC9zdG9yZVwvaG9tZT9zaWQ9MyIsInN0b3JlX2lkIjoiMyJ9LCJDMTA0ODM1NDg4MCI6eyJpZCI6IjU1NyIsInRpdGxlIjoiXHU2NTg3XHU1MTc3XHU3NTI4XHU1NGMxXHU1ZTk3IiwibG9nbyI6Imh0dHA6XC9cLzEueGluenVvd2wuY29tXC9hdHRhY2htZW50XC9pbWFnZXNcLzFcLzIwMTdcLzEyXC9JVnlWb2lpT3JXWFNiOG5Jam5yRUh3SUUyNXo5RXkuanBnIiwiZm9yd2FyZF9tb2RlIjoiMCIsImZvcndhcmRfdXJsIjoiIiwidXJsIjoiXC9wYWdlc1wvc3RvcmVcL2dvb2RzP3NpZD01NTciLCJzdG9yZV9pZCI6IjU1NyJ9LCJDMTM1MDYxMDQyOCI6eyJpZCI6IjY5IiwidGl0bGUiOiJcdTY4NDNcdTZlOTBcdTk4ZGZcdTVlOTciLCJsb2dvIjoiaHR0cHM6XC9cLzEueGluenVvd2wuY29tXC9hdHRhY2htZW50XC9pbWFnZXNcLzFcLzIwMTZcLzA4XC9LTjdlVTZzbmFGOWU2NkM1bjU0cG5qRzU2NHo3OTUuanBnIiwiZm9yd2FyZF9tb2RlIjoiMCIsImZvcndhcmRfdXJsIjoiIiwidXJsIjoiXC9wYWdlc1wvc3RvcmVcL2dvb2RzP3NpZD02OSIsInN0b3JlX2lkIjoiNjkifSwiQzExNzcyNzYyMDEiOnsiaWQiOiI4OSIsInRpdGxlIjoiXHU1MWM5XHU1YzcxXHU5OGNlXHU1NDczIiwibG9nbyI6Imh0dHBzOlwvXC8xLnhpbnp1b3dsLmNvbVwvYXR0YWNobWVudFwvaW1hZ2VzXC8xXC8yMDE2XC8wOFwvTTNyczNTeFI5MUE0RkE5TkZac0tVWjc3VTFVOFNSLnBuZyIsImZvcndhcmRfbW9kZSI6IjAiLCJmb3J3YXJkX3VybCI6IiIsInVybCI6IlwvcGFnZXNcL3N0b3JlXC9nb29kcz9zaWQ9ODkiLCJzdG9yZV9pZCI6Ijg5In0sIkMxMzcxMTA4NjkzIjp7ImlkIjoiOTgiLCJ0aXRsZSI6Ilx1N2VkZFx1NTQ3M1x1OWUyZFx1ODExNiIsImxvZ28iOiJodHRwczpcL1wvMS54aW56dW93bC5jb21cL2F0dGFjaG1lbnRcL2ltYWdlc1wvMVwvMjAxNlwvMDhcL2YzZE03bU02YkM0YWQ0Ym1BWXZGQjM4Q0x5YjRDVy5wbmciLCJmb3J3YXJkX21vZGUiOiIwIiwiZm9yd2FyZF91cmwiOiIiLCJ1cmwiOiJcL3BhZ2VzXC9zdG9yZVwvZ29vZHM/c2lkPTk4Iiwic3RvcmVfaWQiOiI5OCJ9fSwiaWQiOiJzZWxlY3RpdmUifSwiTTE1MzI2ODA4NTAwMDEiOnsicGFyYW1zIjp7InNob3d0eXBlIjoiMCIsInBhZ2VudW0iOiI0IiwidGl0bGUiOiJcdTU5MjlcdTU5MjlcdTcyNzlcdTRlZjciLCJiYXJnYWlubnVtIjoiOCJ9LCJzdHlsZSI6eyJtYXJnaW50b3AiOiIxMCIsImRvdGJhY2tncm91bmQiOiIjZmYyZDRiIiwidGl0bGVjb2xvciI6IiMzMzMzMzMiLCJnb29kc25hbWVjb2xvciI6IiMzMzMzMzMifSwiZGF0YSI6eyJDMTAxNTI2NzMyNyI6eyJ0aHVtYiI6Imh0dHBzOlwvXC8xLnhpbnp1b3dsLmNvbVwvYXR0YWNobWVudFwvaW1hZ2VzXC8xXC8yMDE3XC8xMlwvYjc3azIyN3lLMkJpcjVCUFY3TG9CbHo3NTdZN3k5LmpwZyIsImRpc2NvdW50IjoxMCwiZ29vZHNfaWQiOiI5ODE2IiwiYmFyZ2Fpbl9pZCI6IjQiLCJ0aXRsZSI6Ilx1NWMzYVx1NWI1MCIsImRpc2NvdW50X3ByaWNlIjoiMyIsInByaWNlIjoiMyIsInNpZCI6IjU1NyJ9fSwiaWQiOiJiYXJnYWluIiwiZGF0YV9udW0iOjF9LCJNMTUzMTk4NTk2NTIzNyI6eyJwYXJhbXMiOnsic2hvd2NhcnQiOiIxIn0sIm1heCI6IjEiLCJpZCI6ImNhcnQifSwiTTE1MzE5ODU5NjE0MDMiOnsicGFyYW1zIjp7InNob3dkaXNjb3VudCI6IjEiLCJzaG93aG90Z29vZHMiOiIxIiwiaG90Z29vZHNudW0iOiIzIn0sInN0eWxlIjp7Im1hcmdpbnRvcCI6IjEwIiwidGl0bGVjb2xvciI6IiMzMzMiLCJzY29yZWNvbG9yIjoiI2ZmMmQ0YiIsImRlbGl2ZXJ5dGl0bGViZ2NvbG9yIjoiI2ZmMmQ0YiIsImRlbGl2ZXJ5dGl0bGVjb2xvciI6IiNmZmYifSwiZGF0YSI6eyJDMTUzMTk4NTk2MTQwMyI6eyJzdG9yZV9pZCI6IjAiLCJsb2dvIjoiLi5cL2FkZG9uc1wvd2U3X3dtYWxsXC9wbHVnaW5cL3d4YXBwXC9zdGF0aWNcL2ltZ1wvZGVmYXVsdFwvc3RvcmUtMS5qcGciLCJ0aXRsZSI6Ilx1OGZkOVx1OTFjY1x1NjYyZlx1OTVlOFx1NWU5N1x1NTQwZFx1NzlmMCIsInNjb3JlIjoiNSIsInNhaWxlZCI6Ijg4OCIsInNlbmRfcHJpY2UiOiIxNSIsImRlbGl2ZXJ5X3ByaWNlIjoiNSIsImRlbGl2ZXJ5X3RpdGxlIjoiXHU1ZTczXHU1M2YwXHU0ZTEzXHU5MDAxIiwiZGVsaXZlcnlfdGltZSI6IjMwIiwiYWN0aXZpdHkiOnsiaXRlbXMiOnsiQzAxMjM0NTY3ODkxMDEiOnsidHlwZSI6ImRpc2NvdW50IiwidGl0bGUiOiJcdTZlZTEzNVx1NTFjZjEyO1x1NmVlMTYwXHU1MWNmMjAifSwiQzAxMjM0NTY3ODkxMDIiOnsidHlwZSI6ImNvdXBvbkNvbGxlY3QiLCJ0aXRsZSI6Ilx1NTNlZlx1OTg4NjJcdTUxNDNcdTRlZTNcdTkxZDFcdTUyMzgifX0sIm51bSI6IjIifSwiaG90X2dvb2RzIjp7IkMwMTIzNDU2Nzg5MTAxIjp7InNpZCI6IjAiLCJ0aHVtYiI6Ii4uXC9hZGRvbnNcL3dlN193bWFsbFwvcGx1Z2luXC93eGFwcFwvc3RhdGljXC9pbWdcL2RlZmF1bHRcL2dvb2RzLTEuanBnIiwicHJpY2UiOiIyMC4wMCIsIm9sZF9wcmljZSI6IjEwLjAwIiwidGl0bGUiOiJcdThmZDlcdTkxY2NcdTY2MmZcdTU1NDZcdTU0YzFcdTY4MDdcdTk4OTgiLCJzdG9yZV90aXRsZSI6Ilx1OGZkOVx1OTFjY1x1NjYyZlx1OTVlOFx1NWU5N1x1NTQwZFx1NzlmMCIsImRpc2NvdW50IjoiNSIsInNhaWxlZCI6IjIwIiwiY29tbWVudF9nb29kX3BlcmNlbnQiOiI4OCUifSwiQzAxMjM0NTY3ODkxMDIiOnsic2lkIjoiMCIsInRodW1iIjoiLi5cL2FkZG9uc1wvd2U3X3dtYWxsXC9wbHVnaW5cL3d4YXBwXC9zdGF0aWNcL2ltZ1wvZGVmYXVsdFwvZ29vZHMtMi5qcGciLCJwcmljZSI6IjIwLjAwIiwib2xkX3ByaWNlIjoiMTAuMDAiLCJ0aXRsZSI6Ilx1OGZkOVx1OTFjY1x1NjYyZlx1NTU0Nlx1NTRjMVx1NjgwN1x1OTg5OCIsInN0b3JlX3RpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU5NWU4XHU1ZTk3XHU1NDBkXHU3OWYwIiwiZGlzY291bnQiOiI1Iiwic2FpbGVkIjoiMjAiLCJjb21tZW50X2dvb2RfcGVyY2VudCI6Ijg4JSJ9LCJDMDEyMzQ1Njc4OTEwMyI6eyJzaWQiOiIwIiwidGh1bWIiOiIuLlwvYWRkb25zXC93ZTdfd21hbGxcL3BsdWdpblwvd3hhcHBcL3N0YXRpY1wvaW1nXC9kZWZhdWx0XC9nb29kcy0zLmpwZyIsInByaWNlIjoiMjAuMDAiLCJvbGRfcHJpY2UiOiIxMC4wMCIsInRpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU1NTQ2XHU1NGMxXHU2ODA3XHU5ODk4Iiwic3RvcmVfdGl0bGUiOiJcdThmZDlcdTkxY2NcdTY2MmZcdTk1ZThcdTVlOTdcdTU0MGRcdTc5ZjAiLCJkaXNjb3VudCI6IjUiLCJzYWlsZWQiOiIyMCIsImNvbW1lbnRfZ29vZF9wZXJjZW50IjoiODglIn19fSwiQzE1MzE5ODU5NjE0MDQiOnsic3RvcmVfaWQiOiIwIiwibG9nbyI6Ii4uXC9hZGRvbnNcL3dlN193bWFsbFwvcGx1Z2luXC93eGFwcFwvc3RhdGljXC9pbWdcL2RlZmF1bHRcL3N0b3JlLTIuanBnIiwidGl0bGUiOiJcdThmZDlcdTkxY2NcdTY2MmZcdTk1ZThcdTVlOTdcdTU0MGRcdTc5ZjAiLCJzY29yZSI6IjUiLCJzYWlsZWQiOiI4ODgiLCJzZW5kX3ByaWNlIjoiMTUiLCJkZWxpdmVyeV9wcmljZSI6IjUiLCJkZWxpdmVyeV90aXRsZSI6Ilx1NWU3M1x1NTNmMFx1NGUxM1x1OTAwMSIsImRlbGl2ZXJ5X3RpbWUiOiI0NSIsImhvdF9nb29kcyI6eyJDMDEyMzQ1Njc4OTEwMSI6eyJzaWQiOiIwIiwidGh1bWIiOiIuLlwvYWRkb25zXC93ZTdfd21hbGxcL3BsdWdpblwvd3hhcHBcL3N0YXRpY1wvaW1nXC9kZWZhdWx0XC9nb29kcy0xLmpwZyIsInByaWNlIjoiMjAuMDAiLCJvbGRfcHJpY2UiOiIxMC4wMCIsInRpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU1NTQ2XHU1NGMxXHU2ODA3XHU5ODk4Iiwic3RvcmVfdGl0bGUiOiJcdThmZDlcdTkxY2NcdTY2MmZcdTk1ZThcdTVlOTdcdTU0MGRcdTc5ZjAiLCJkaXNjb3VudCI6IjUiLCJzYWlsZWQiOiIyMCIsImNvbW1lbnRfZ29vZF9wZXJjZW50IjoiODglIn0sIkMwMTIzNDU2Nzg5MTAyIjp7InNpZCI6IjAiLCJ0aHVtYiI6Ii4uXC9hZGRvbnNcL3dlN193bWFsbFwvcGx1Z2luXC93eGFwcFwvc3RhdGljXC9pbWdcL2RlZmF1bHRcL2dvb2RzLTIuanBnIiwicHJpY2UiOiIyMC4wMCIsIm9sZF9wcmljZSI6IjEwLjAwIiwidGl0bGUiOiJcdThmZDlcdTkxY2NcdTY2MmZcdTU1NDZcdTU0YzFcdTY4MDdcdTk4OTgiLCJzdG9yZV90aXRsZSI6Ilx1OGZkOVx1OTFjY1x1NjYyZlx1OTVlOFx1NWU5N1x1NTQwZFx1NzlmMCIsImRpc2NvdW50IjoiNSIsInNhaWxlZCI6IjIwIiwiY29tbWVudF9nb29kX3BlcmNlbnQiOiI4OCUifSwiQzAxMjM0NTY3ODkxMDMiOnsic2lkIjoiMCIsInRodW1iIjoiLi5cL2FkZG9uc1wvd2U3X3dtYWxsXC9wbHVnaW5cL3d4YXBwXC9zdGF0aWNcL2ltZ1wvZGVmYXVsdFwvZ29vZHMtMy5qcGciLCJwcmljZSI6IjIwLjAwIiwib2xkX3ByaWNlIjoiMTAuMDAiLCJ0aXRsZSI6Ilx1OGZkOVx1OTFjY1x1NjYyZlx1NTU0Nlx1NTRjMVx1NjgwN1x1OTg5OCIsInN0b3JlX3RpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU5NWU4XHU1ZTk3XHU1NDBkXHU3OWYwIiwiZGlzY291bnQiOiI1Iiwic2FpbGVkIjoiMjAiLCJjb21tZW50X2dvb2RfcGVyY2VudCI6Ijg4JSJ9fX0sIkMxNTMxOTg1OTYxNDA1Ijp7InN0b3JlX2lkIjoiMCIsImxvZ28iOiIuLlwvYWRkb25zXC93ZTdfd21hbGxcL3BsdWdpblwvd3hhcHBcL3N0YXRpY1wvaW1nXC9kZWZhdWx0XC9zdG9yZS0zLmpwZyIsInRpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU5NWU4XHU1ZTk3XHU1NDBkXHU3OWYwIiwic2NvcmUiOiI1Iiwic2FpbGVkIjoiODg4Iiwic2VuZF9wcmljZSI6IjE1IiwiZGVsaXZlcnlfcHJpY2UiOiI1IiwiZGVsaXZlcnlfdGl0bGUiOiJcdTVlNzNcdTUzZjBcdTRlMTNcdTkwMDEiLCJkZWxpdmVyeV90aW1lIjoiNTUiLCJob3RfZ29vZHMiOnsiQzAxMjM0NTY3ODkxMDEiOnsic2lkIjoiMCIsInRodW1iIjoiLi5cL2FkZG9uc1wvd2U3X3dtYWxsXC9wbHVnaW5cL3d4YXBwXC9zdGF0aWNcL2ltZ1wvZGVmYXVsdFwvZ29vZHMtNC5qcGciLCJwcmljZSI6IjIwLjAwIiwib2xkX3ByaWNlIjoiMTAuMDAiLCJ0aXRsZSI6Ilx1OGZkOVx1OTFjY1x1NjYyZlx1NTU0Nlx1NTRjMVx1NjgwN1x1OTg5OCIsInN0b3JlX3RpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU5NWU4XHU1ZTk3XHU1NDBkXHU3OWYwIiwiZGlzY291bnQiOiI1Iiwic2FpbGVkIjoiMjAiLCJjb21tZW50X2dvb2RfcGVyY2VudCI6Ijg4JSJ9LCJDMDEyMzQ1Njc4OTEwMiI6eyJzaWQiOiIwIiwidGh1bWIiOiIuLlwvYWRkb25zXC93ZTdfd21hbGxcL3BsdWdpblwvd3hhcHBcL3N0YXRpY1wvaW1nXC9kZWZhdWx0XC9nb29kcy01LmpwZyIsInByaWNlIjoiMjAuMDAiLCJvbGRfcHJpY2UiOiIxMC4wMCIsInRpdGxlIjoiXHU4ZmQ5XHU5MWNjXHU2NjJmXHU1NTQ2XHU1NGMxXHU2ODA3XHU5ODk4Iiwic3RvcmVfdGl0bGUiOiJcdThmZDlcdTkxY2NcdTY2MmZcdTk1ZThcdTVlOTdcdTU0MGRcdTc5ZjAiLCJkaXNjb3VudCI6IjUiLCJzYWlsZWQiOiIyMCIsImNvbW1lbnRfZ29vZF9wZXJjZW50IjoiODglIn19fX0sIm1heCI6IjEiLCJpc2JvdHRvbSI6IjEiLCJwcmlvcml0eSI6IjEiLCJpZCI6IndhaW1haV9hbGxzdG9yZXMifX19',
			'updatetime' => 1531985983,
			'version' => 2,
		)
	);
	return $pages[$type];
}

function get_wxapp_waimai_goods($item, $mobile = false) {
	global $_W;
	if($item['params']['goodsdata'] == '0') {
		if(!empty($item['data']) && is_array($item['data'])) {
			$goodsids = array();
			foreach($item['data'] as $data) {
				if(!empty($data['goods_id'])) {
					$goodsids[] = $data['goods_id'];
				}
			}
			if(!empty($goodsids)) {
				$item['data'] = array();
				$goodsids_str = implode(',', $goodsids);
				$goods = pdo_fetchall('select a.*, b.title as store_title from ' . tablename('tiny_wmall_goods') . ' as a left join ' . tablename('tiny_wmall_store') .
					" as b on a.sid = b.id where a.uniacid = :uniacid and a.status = 1 and b.agentid = :agentid and a.id in ({$goodsids_str}) order by a.displayorder desc", array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
				if(!empty($goods)) {
					foreach($goodsids as $goodsid) {
						foreach($goods as $good) {
							if($good['id'] == $goodsid) {
								$childid = rand(1000000000, 9999999999);
								$childid = "C{$childid}";
								$item['data'][$childid] = array(
									'goods_id' => $good['id'],
									'sid' => $good['sid'],
									'store_title' => $good['store_title'],
									'thumb' => tomedia($good['thumb']),
									'title' => $good['title'],
									'price' => $good['price'],
									'old_price' => $good['old_price'] ? $good['old_price'] : $good['price'],
									'sailed' => $good['sailed'],
									'total' => ($good['total'] != -1 ? $good['total'] : '无限'),
									'discount' => ($good['old_price'] == 0 ? 0 : (round(($good['price'] / $good['old_price']) * 10, 1))),
									'comment_good_percent' => ($good['comment_total'] == 0 ? 0 : (round(($good['comment_good'] / $good['comment_total']) * 100, 2) . "%")),
								);
							}
						}
					}
				}
			}
		}
	} elseif($item['params']['goodsdata'] == '1') {
		if(empty($mobile)) {
			return $item['data'];
		}
		//在手机端获取数据
		$item['data'] = array();
		$condition = ' where a.uniacid = :uniacid and a.agentid = :agentid and a.status= 1';
		$params = array(
			':uniacid' => $_W['uniacid'],
			':agentid' => $_W['agentid'],
		);
		$limit = intval($item['params']['goodsnum']);
		$limit = $limit ? $limit : 20;
		$goods = pdo_fetchall('select a.discount_price,a.goods_id,a.discount_available_total,b.* from ' . tablename('tiny_wmall_activity_bargain_goods') . ' as a left join ' . tablename('tiny_wmall_goods') . " as b on a.goods_id = b.id {$condition} order by a.mall_displayorder desc limit {$limit}", $params);
		if(!empty($goods)) {
			$stores = pdo_fetchall('select distinct(a.sid),b.title as store_title,b.is_rest from ' . tablename('tiny_wmall_activity_bargain') . ' as a left join ' . tablename('tiny_wmall_store') . ' as b on a.sid = b.id where a.uniacid = :uniacid and a.agentid = :agentid and a.status = 1', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']), 'sid');
			foreach($goods as &$good) {
				$childid = rand(1000000000, 9999999999);
				$childid = "C{$childid}";
				$item['data'][$childid] = array(
					'goods_id' => $good['id'],
					'sid' => $good['sid'],
					'store_title' => $stores[$good['sid']]['store_title'],
					'thumb' => tomedia($good['thumb']),
					'title' => $good['title'],
					'price' => $good['discount_price'],
					'old_price' => $good['old_price'] ? $good['old_price'] : $good['price'],
					'sailed' => $good['sailed'],
					'total' => ($good['discount_available_total'] != -1 ? $good['discount_available_total'] : '无限'),
					'discount' => ($good['old_price'] == 0 ? 0 : (round(($good['discount_price'] / $good['old_price']) * 10, 1))),
					'comment_good_percent' => ($good['comment_total'] == 0 ? 0 : (round(($good['comment_good'] / $good['comment_total']) * 100, 2) . "%")),
				);
			}
		}
	}
	return $item['data'];
}

function get_wxapp_waimai_recommend_store($item, $mobile = false) {
	global $_W;
	if($item['params']['storedata'] == '0') {
		if(!empty($item['data']) && is_array($item['data'])) {
			$storeids = array();
			foreach($item['data'] as $data) {
				if(!empty($data['store_id'])) {
					$storeids[] = $data['store_id'];
				}
			}
			if(!empty($storeids)) {
				$item['data'] = array();
				$storeids_str = implode(',', $storeids);
				$stores = pdo_fetchall('select id, title, logo, is_rest, forward_mode, forward_url from ' . tablename('tiny_wmall_store') . "where uniacid = :uniacid and agentid = :agentid and id in ({$storeids_str}) order by is_rest asc", array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
			}
		}
	} elseif($item['params']['storedata'] == '1') {
		$limit = intval($item['params']['storenum']);
		$limit = $limit ? $limit : 20;
		$stores = pdo_fetchall('select id, title, logo, forward_mode, forward_url from ' . tablename('tiny_wmall_store') . "where uniacid = :uniacid and agentid = :agentid and is_recommend = 1 order by is_rest asc, displayorder desc limit {$limit}", array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
	}
	$item['data'] = array();
	if(!empty($stores)) {
		foreach($stores as &$row) {
			$row['url'] = store_forward_url($row['id'], $row['forward_mode'], $row['forward_url']);
			$row['store_id'] = $row['id'];
			$row['logo'] = tomedia($row['logo']);
			$childid = rand(1000000000, 9999999999);
			$childid = "C{$childid}";
			$item['data'][$childid] = $row;
			unset($row);
		}
	}
	$item['data_num'] = count($item['data']);
	if($mobile && ($item['params']['showtype'] == 1 && count($item['data']) > $item['params']['pagenum'])) {
		$item['data'] = array_chunk($item['data'], $item['params']['pagenum']);
	}
	$result = array(
		'data' => $item['data'],
		'data_num' => $item['data_num']
	);
	return $result;
}

function get_wxapp_waimai_store($item, $mobile = false) {
	global $_W, $_GPC;
	if($item['params']['storedata'] == '0') {
		if(!empty($item['data']) && is_array($item['data'])) {
			$storeids = array();
			foreach($item['data'] as $data) {
				if(!empty($data['store_id'])) {
					$storeids[] = $data['store_id'];
				}
			}
			if(!empty($storeids)) {
				$item['data'] = array();
				$storeids_str = implode(',', $storeids);
				$stores = pdo_fetchall('select id, title, logo, delivery_free_price, score, is_rest,delivery_time,sailed,delivery_mode,label, forward_mode, forward_url from ' . tablename('tiny_wmall_store') . "where uniacid = :uniacid and agentid = :agentid and id in ({$storeids_str}) order by is_rest asc", array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
			}
		}
	} elseif($item['params']['storedata'] == '1') {
		if(empty($mobile)) {
			return $item['data'];
		}
		$limit = intval($item['params']['storenum']);
		$limit = $limit ? $limit : 20;
		$stores = pdo_fetchall('select id, title, logo, delivery_free_price, score, is_rest,delivery_time,sailed,delivery_mode,label, forward_mode, forward_url from ' . tablename('tiny_wmall_store') . "where uniacid = :uniacid and agentid = :agentid and is_recommend = 1 order by is_rest asc, displayorder desc limit {$limit}", array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
	} elseif($item['params']['storedata'] == '2') {
		$condition = ' where uniacid = :uniacid and agentid = :agentid';
		$params = array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']);
		$limit = intval($item['params']['storenum']);
		$limit = $limit ? $limit : 20;
		if($item['params']['categoryid'] > 0) {
			$condition .= ' and cid like :cid';
			$params[':cid'] = "%|{$item['params']['categoryid']}|%";
		}
		$stores = pdo_fetchall('select id, title, logo, delivery_free_price, score,is_rest,delivery_time,sailed,delivery_mode,label, forward_mode, forward_url from ' . tablename('tiny_wmall_store') . $condition  . " order by is_rest asc, displayorder desc limit {$limit}", $params);
	} elseif($item['params']['storedata'] == '3') {
		unset($item['data']);
		$store_activity = pdo_getall('tiny_wmall_store_activity', array('uniacid' => $_W['uniacid'], 'status' => 1, 'type' => $item['params']['activitytype']), array('sid'), 'sid');
		if(!empty($store_activity)) {
			$store_ids = array_keys($store_activity);
			$storeids_str = implode(',', $store_ids);
			$condition = " where uniacid = :uniacid and agentid = :agentid and id in ({$storeids_str})";
			$params = array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']);
			$limit = intval($item['params']['storenum']);
			$limit = $limit ? $limit : 20;
			$stores = pdo_fetchall('select id, title, logo, delivery_free_price, score,is_rest,delivery_time,sailed,delivery_mode,label, forward_mode, forward_url from ' . tablename('tiny_wmall_store') . $condition  . " order by is_rest asc, displayorder desc limit {$limit}", $params);
		}
	}
	$item['data'] = array();
	if(!empty($stores)) {
		$_config_mall = $_W['we7_wmall']['config']['mall'];
		if(empty($_config_mall['delivery_title'])) {
			$_config_mall['delivery_title'] = '平台专送';
		}
		$store_label = category_store_label();
		foreach($stores as &$row) {
			$row['url'] = store_forward_url($row['id'], $row['forward_mode'], $row['forward_url']);
			$row['store_id'] = $row['id'];
			if($row['label'] > 0) {
				$row['label_color'] = $store_label[$row['label']]['color'];
				$row['label_cn'] = $store_label[$row['label']]['title'];
			}
			$row['logo'] = tomedia($row['logo']);
			$row['price'] = store_order_condition($row['id']);
			$row['send_price'] = $row['price']['send_price'];
			$row['delivery_price'] = $row['price']['delivery_price'];
			if($row['delivery_mode'] == 1){
				$row['delivery_title'] = '商家自送';
			} else {
				$row['delivery_title'] = $_config_mall['delivery_title'];
			}
			$row['score_cn'] = round($row['score'] / 5, 2) * 100;
			$row['hot_goods'] = array();
			$hot_goods = pdo_fetchall('select id,title,price,old_price,thumb from ' . tablename('tiny_wmall_goods') . ' where uniacid = :uniacid and sid = :sid and is_hot = 1 and status = 1 limit 3', array(':uniacid' => $_W['uniacid'], ':sid' => $row['id']));
			if(!empty($hot_goods)) {
				foreach($hot_goods as &$goods) {
					$goods['thumb'] = tomedia($goods['thumb']);
					if($goods['old_price'] != 0) {
						$goods['discount'] = round(($goods['price'] / $goods['old_price']) * 10, 1);
					} else {
						$goods['discount'] = 0;
					}
					$childid = rand(1000000000, 9999999999);
					$childid = "C{$childid}";
					$row['hot_goods'][$childid] = $goods;
				}
				$row['hot_goods_num'] = count($row['hot_goods']);
				unset($hot_goods);
			}
			$row['activity'] = array();
			$activitys = store_fetch_activity($row['id']);
			if(!empty($activitys['items'])) {
				foreach($activitys['items'] as $avtivity_item) {
					if(empty($avtivity_item['title'])) {
						continue;
					}
					$row['activity']['items'][] = array(
						'type' => $avtivity_item['type'],
						'title' => $avtivity_item['title'],
					);
				}
				$row['activity']['num'] = $activitys['num'];
				$row['activity']['is_show_all'] = 0;
				unset($activitys);
			}
			$childid = rand(1000000000, 9999999999);
			$childid = "C{$childid}";
			$item['data'][$childid] = $row;
			unset($row);
		}
	}
	return $item['data'];
}

function get_wxapp_notice($item, $mobile = false){
	global $_W;
	if($item['params']['noticedata'] == 0) {
		$noticenum = $item['params']['noticenum'];
		$notice = pdo_fetchall('select id, title, displayorder, link, status from' .tablename('tiny_wmall_notice'). 'where status = 1 and uniacid = :uniacid and agentid = :agentid and type = :type order by displayorder desc limit '.$noticenum, array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid'], ':type' => 'member'));
		$item['data'] = array();
		if (!empty($notice)) {
			foreach ($notice as &$data) {
				$childid = rand(1000000000, 9999999999);
				$childid = "C{$childid}";
				$item['data'][$childid] = array(
					'id' => $data['id'],
					'title' => $data['title'],
					'linkurl' => $data['link'],
				);
			}
		}
	}
	return $item['data'];
}
function get_wxapp_bargains($item, $mobile = false) {
	global $_W;
	$limit = intval($item['params']['bargainnum']);
	$limit = $limit ? $limit : 20;
	$bargains = pdo_fetchall('select a.discount_price,a.goods_id, a.bargain_id,b.title,b.thumb,b.price,b.sid,c.is_rest from ' . tablename('tiny_wmall_activity_bargain_goods') . ' as a left join ' . tablename('tiny_wmall_goods') . ' as b on a.goods_id = b.id left join ' . tablename('tiny_wmall_store') . "as c on b.sid = c.id where a.uniacid = :uniacid and a.agentid = :agentid and a.status = 1 and b.status = 1 order by c.is_rest asc, a.mall_displayorder desc limit {$limit}", array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
	$item['data'] = array();
	if(!empty($bargains)) {
		foreach($bargains as $val) {
			$childid = rand(1000000000, 9999999999);
			$childid = "C{$childid}";
			$item['data'][$childid] = array(
				'thumb' => tomedia($val['thumb']),
				'discount' => round(($val['discount_price'] / $val['price'] * 10), 1),
				'goods_id'=> $val['goods_id'],
				'bargain_id'=> $val['bargain_id'],
				'title'=> $val['title'],
				'discount_price'=> $val['discount_price'],
				'price'=> $val['price'],
				'sid'=> $val['sid'],
			);
		}
	}
	$item['data_num'] = count($item['data']);
	if($mobile && $item['params']['showtype'] == 1 && count($item['data']) > $item['params']['pagenum']) {
		$item['data'] = array_chunk($item['data'], $item['params']['pagenum']);
	}
	$result = array(
		'data' => $item['data'],
		'data_num' => $item['data_num'],
	);
	return $result;
}
function get_wxapp_navs($item, $mobile = false) {
	global $_W;
	if($item['params']['navsdata'] == 0) {
		if(!empty($item['data'])) {
			foreach($item['data'] as &$val) {
				$val['imgurl'] = tomedia($val['imgurl']);
			}
		}
	} else {
		$limit = intval($item['params']['navsnum']) ? intval($item['params']['navsnum']) : 4;
		$navs = pdo_fetchall('select id,title,thumb,wxapp_link from' .tablename('tiny_wmall_store_category'). 'where uniacid = :uniacid and agentid = :agentid and status = 1 order by displayorder desc limit ' . $limit, array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
		$item['data'] = array();
		if(!empty($navs)){
			foreach($navs as $val) {
				$childid = rand(1000000000, 9999999999);
				$childid = "C{$childid}";
				$item['data'][$childid] = array(
					'linkurl' => empty($val['wxapp_link']) ? "pages/home/category?cid={$val['id']}" : $val['wxapp_link'],
					'text' => $val['title'],
					'imgurl' => tomedia($val['thumb']),
				);
			}
		}
	}
	$item['data_num'] = count($item['data']);
	if($mobile && $item['params']['showtype'] == 1 && $item['data_num'] > $item['params']['pagenum']) {
		$item['data'] = array_chunk($item['data'], $item['params']['pagenum']);
	}
	$result = array(
		'data' => $item['data'],
		'data_num' => $item['data_num'],
	);
	return $result;
}

function get_wxapp_danmu($config_danmu = array()) {
	global $_W;
	if(empty($config_danmu)) {
		$config_danmu = get_plugin_config('diypage.danmu');
	}
	if(!is_array($config_danmu) || !$config_danmu['params']['status']) {
		return error(-1, '');
	}
	if($config_danmu['params']['dataType'] == 0) {
		$members = pdo_fetchall('select nickname, avatar from ' . tablename('tiny_wmall_members') . " where uniacid = :uniacid and nickname != '' and avatar != '' order by id desc limit 10;", array(':uniacid' => $_W['uniacid']));
	} else {
		$members = pdo_fetchall('select b.nickname, b.avatar from ' . tablename('tiny_wmall_order') . " as a left join " . tablename('tiny_wmall_members') .  " as b on a.uid = b.uid where a.uniacid = :uniacid and b.nickname != '' and b.avatar != '' order by a.id desc limit 10;", array(':uniacid' => $_W['uniacid']));
	}
	if(!empty($members)) {
		foreach($members as &$val) {
			$val['avatar'] = tomedia($val['avatar']);
			$val['time'] = mt_rand($config_danmu['params']['starttime'], $config_danmu['params']['endtime']);
			if($val['time'] <= 0) {
				$val['time'] = '刚刚';
			} elseif($val['time'] > 0 && $val['time'] < 60) {
				$val['time'] = "{$val['time']}秒前";
			} elseif($val['time'] > 60) {
				$val['time'] = floor($val['time'] / 60);
				$val['time'] = "{$val['time']}分钟前";
			}
		}
	}
	$config_danmu['members'] = $members;
	return $config_danmu;
}

function get_wxapp_cubes($item, $mobile = false) {
	global $_W;
	if(empty($item['params']['activitydata'])) {
		if(!empty($item['data'])) {
			foreach($item['data'] as &$val) {
				$val['imgurl'] = tomedia($val['imgurl']);
			}
		}
	} else {
		$cubes = pdo_fetchall('select id,title,tips,thumb,wxapp_link,link from' .tablename('tiny_wmall_cube'). ' where uniacid = :uniacid and agentid = :agentid order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid']));
		$item['data'] = array();
		if(!empty($cubes)){
			foreach($cubes as $val) {
				$childid = rand(1000000000, 9999999999);
				$childid = "C{$childid}";
				$item['data'][$childid] = array(
					'linkurl' => $val['link'],
					'text' => $val['title'],
					'imgurl' => tomedia($val['thumb']),
					'placeholder' => $val['tips'],
					'color' => '#ff2d4b',
					'placeholderColor' => '#7b7b7b',
				);
			}
		}
	}
	$result = array(
		'data' => $item['data']
	);
	return $result;
}

function get_wxapp_slides($item) {
	global $_W;
	if(empty($item['params']['picturedata'])) {
		if(!empty($item['data'])) {
			foreach($item['data'] as &$val) {
				$val['imgurl'] = tomedia($val['imgurl']);
			}
		}
	} else {
		$slides = pdo_fetchall('select id,title,thumb,wxapp_link,link from' .tablename('tiny_wmall_slide'). ' where uniacid = :uniacid and agentid = :agentid and status = 1 and type = :type order by displayorder desc', array(':uniacid' => $_W['uniacid'], ':agentid' => $_W['agentid'], ':type' => 'homeTop'));
		$item['data'] = array();
		if(!empty($slides)){
			foreach($slides as $val) {
				$childid = rand(1000000000, 9999999999);
				$childid = "C{$childid}";
				$item['data'][$childid] = array(
					'linkurl' => $val['link'],
					'imgurl' => tomedia($val['thumb']),
				);
			}
		}
	}
	$result = array(
		'data' => $item['data']
	);
	return $result;
}

function get_wxapp_pages($filter = array(), $search = array('*')) {
	global $_W;
	$condition = ' where uniacid = :uniacid';
	$params = array(
		':uniacid' => $_W['uniacid'],
	);
	$table = 'tiny_wmall_wxapp_page';
	if($filter['from'] == 'wechat') {
		$table = 'tiny_wmall_diypage';
		$condition .= ' and `version` = :version';
		$params[':version'] = 2;
	}
	if(!empty($filter) && !empty($filter['type'])) {
		$condition .= ' and type = :type';
		$params[':type'] = intval($filter['type']);
	}
	if(!empty($search)) {
		$search = implode(',', $search);
	}
	$pages = pdo_fetchall("select {$search} from " . tablename($table) . $condition, $params);
	return $pages;
}