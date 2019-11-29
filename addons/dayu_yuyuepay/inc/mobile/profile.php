<?php
	include MODULE_ROOT."/model/tpl.mod.php";
	$profile = mc_fetch($_W['member']['uid']);
	if($_W['container']=='wechat' && !empty($_W['openid'])) {
		$map_fans = pdo_getcolumn('mc_mapping_fans', array('uniacid' => $_W['uniacid'], 'openid' => $_W['openid']), 'tag');
		if(!empty($map_fans)) {
			if (is_base64($map_fans)){
				$map_fans = base64_decode($map_fans);
			}
			if (is_serialized($map_fans)) {
				$map_fans = iunserializer($map_fans);
			}
			if(!empty($map_fans) && is_array($map_fans)) {
				empty($profile['nickname']) ? ($data['nickname'] = strip_emoji($map_fans['nickname'])) : '';
				empty($profile['gender']) ? ($data['gender'] = $map_fans['sex']) : '';
				empty($profile['residecity']) ? ($data['residecity'] = ($map_fans['city']) ? $map_fans['city'] . '市' : '') : '';
				empty($profile['resideprovince']) ? ($data['resideprovince'] = ($map_fans['province']) ? $map_fans['province'] . '省' : '') : '';
				empty($profile['nationality']) ? ($data['nationality'] = $map_fans['country']) : '';
				empty($profile['avatar']) ? ($data['avatar'] = $map_fans['headimgurl']) : '';
				if(!empty($data)) {
					mc_update($_W['member']['uid'], $data);
				}
			}
		}
	}
//	$profile = pdo_get('mc_members', array('uniacid' => $_W['uniacid'], 'uid' => $_W['member']['uid']));
	$sql = 'SELECT `mf`.*, `pf`.`field` FROM ' . tablename('mc_member_fields') . ' AS `mf` JOIN ' . tablename('profile_fields') . " AS `pf`
			ON `mf`.`fieldid` = `pf`.`id` WHERE `mf`.`uniacid` = :uniacid AND `mf`.`available` = :available";
	$params = array(':uniacid' => $_W['uniacid'], ':available' => '1');
	$mcFields = pdo_fetchall($sql, $params, 'field');

	if ($_W['ispost']) {
		if (!empty($_GPC)) {
			$_GPC['createtime'] = TIMESTAMP;
			foreach ($_GPC as $field => $value) {
				if (!isset($value) || in_array($field, array('uid','act', 'name', 'token', 'submit', 'session'))) {
					unset($_GPC[$field]);
					continue;
				}
			}
			mc_update($_W['member']['uid'], $_GPC);
//			message('更新资料成功！', referer(), 'success');
		}
		message('更新资料成功！', $this->createMobileUrl('my'), 'success');
	}
		$title="更新资料";
		$jquery=1;
		$jqueryweui=1;
		$footer=1;
        include $this->template('member/profile');
?>