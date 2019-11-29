<?php

defined('IN_IA') or die('Access Denied');
define('ROOT_PATH', IA_ROOT . '/addons/sudu8_page/');
define('HTTPSHOST', $_W['attachurl']);
class Sudu8_pageModuleSite extends WeModuleSite
{
	public function hex2rgb($color)
	{
		$color = str_replace('#', '', $color);
		if (strlen($color) > 3) {
			$title_bg = hexdec(substr($color, 0, 2)) . ',' . hexdec(substr($color, 2, 2)) . ',' . hexdec(substr($color, 4, 2));
		} else {
			$color = $color;
			$r = substr($color, 0, 1) . substr($color, 0, 1);
			$g = substr($color, 1, 1) . substr($color, 1, 1);
			$b = substr($color, 2, 1) . substr($color, 2, 1);
			$title_bg = hexdec($r) . ',' . hexdec($g) . ',' . hexdec($b);
		}
		return $title_bg;
	}
	public function hex2rssdgb()
	{
		
	}
	public function RGBToHex($color)
	{
		$color = 'rgb(' . $color . ')';
		$regexp = '/^rgb\\(([0-9]{0,3})\\,\\s*([0-9]{0,3})\\,\\s*([0-9]{0,3})\\)/';
		$re = preg_match($regexp, $color, $match);
		$re = array_shift($match);
		$hexColor = '#';
		$hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
		$i = 0;
		qiTZx:
		if ($i >= 3) {
			return $hexColor;
		} else {
			$r = NULL;
			$c = $match[$i];
			$hexAr = array();
			NJZVf:
			if ($c <= 16) {
				array_push($hexAr, $hex[$c]);
				$ret = array_reverse($hexAr);
				$item = implode('', $ret);
				$item = str_pad($item, 2, '0', STR_PAD_LEFT);
				$hexColor .= $item;
				$i++;
				goto qiTZx;
			}
			$r = $c % 16;
			$c = $c / 16 >> 0;
			array_push($hexAr, $hex[$r]);
			goto NJZVf;
		}
	}
	public function doWebBase()
	{
		include ROOT_PATH . "inc/0BaCoTaDi.php";
	}
	public function doWebcopyright()
	{
		load()->func("tpl");
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'email', 'making');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '版权管理';
			$item = pdo_fetch('SELECT uniacid,copy_do,copyimg,copyright,tel_b FROM ' . tablename('sudu8_page_base') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			if (checksubmit('submit')) {
				$data = array('uniacid' => $_W['uniacid'], 'copy_do' => intval($_GPC['copy_do']), 'copyright' => $_GPC['copyright'], 'tel_b' => $_GPC['tel_b'], 'copyimg' => $_GPC['copyimg'], 'copy_id' => intval($_GPC['copy_id']));
				if (empty($item['uniacid'])) {
					message('请先填写基础信息!', $this->createWebUrl("base", array("op" => "display")), "error");
				} else {
					pdo_update('sudu8_page_base', $data, array('uniacid' => $uniacid));
				}
				message('版权信息更新成功!', $this->createWebUrl("copyright", array("op" => "display")), "success");
			}
		}
		if ($op == 'post') {
			$_W['page']['title'] = '版权内容';
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_copyright') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			if (checksubmit('submit')) {
				$data = array('copycon' => htmlspecialchars_decode($_GPC['copycon'], ENT_QUOTES), 'uniacid' => $uniacid);
				if (empty($item['id'])) {
					pdo_insert('sudu8_page_copyright', $data);
				} else {
					pdo_update('sudu8_page_copyright', $data, array('id' => $item['id']));
				}
				message('版权信息更新成功!', $this->createWebUrl("copyright", array("op" => "post")), "success");
			}
		}
		if ($op == 'email') {
			$item = pdo_fetch('SELECT uniacid,mail_user,mail_password,mail_user_name,mail_sendto FROM ' . tablename('sudu8_page_forms_config') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			if (checksubmit('submit')) {
				$data = array('uniacid' => $uniacid, 'mail_user' => $_GPC['mail_user'], 'mail_password' => $_GPC['mail_password'], 'mail_sendto' => $_GPC['mail_sendto'], 'mail_user_name' => $_GPC['mail_user_name']);
				if (empty($item['uniacid'])) {
					pdo_insert('sudu8_page_forms_config', $data);
				} else {
					pdo_update('sudu8_page_forms_config', $data, array('uniacid' => $uniacid));
				}
				message('表单配置成功!', $this->createWebUrl("copyright", array("op" => "email")), "success");
			}
		}
		if ($op == 'making') {
			$uniacid = $_W['uniacid'];
			if (checksubmit('submit')) {
				include ROOT_PATH . "making.php";
				$making_tmp = $_GPC['making_tmp'];
				$making = new Making();
				$return = $making->making_do($uniacid, $making_tmp);
				if ($return == 1) {
					message('一键制作成功!', $this->createWebUrl("copyright", array("op" => "making")), "success");
				}
			}
		}
		include $this->template("copyright");
	}
	public function doWebtabbar()
	{
		include ROOT_PATH . "inc/0SjdfDlfd.php";
	}
	public function doWebDiy()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '样式DIY';
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_base') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			$config = unserialize($item['config']);
			$item['newhead'] = $config['newhead'];
			$item['search'] = $config['search'];
			$item['bigadT'] = $config['bigadT'];
			$item['bigadC'] = $config['bigadC'];
			$item['bigadCTC'] = $config['bigadCTC'];
			$item['bigadCNN'] = $config['bigadCNN'];
			$item['miniadT'] = $config['miniadT'];
			$item['miniadC'] = $config['miniadC'];
			$item['miniadN'] = $config['miniadN'];
			$item['miniadB'] = $config['miniadB'];
			$item['copT'] = $config['copT'];
			$item['userFood'] = $config['userFood'];
			if (checksubmit('submit')) {
				if (is_null($_GPC['userFood'])) {
					$_GPC['userFood'] = 0;
				}
				$config = array('newhead' => $_GPC['newhead'], 'search' => $_GPC['search'], 'bigadT' => $_GPC['bigadT'], 'bigadC' => $_GPC['bigadC'], 'bigadCTC' => $_GPC['bigadCTC'], 'bigadCNN' => $_GPC['bigadCNN'], 'miniadT' => $_GPC['miniadT'], 'miniadC' => $_GPC['miniadC'], 'miniadN' => $_GPC['miniadN'], 'miniadB' => $_GPC['miniadB'], 'copT' => $_GPC['copT'], 'userFood' => $_GPC['userFood']);
				$config = serialize($config);
				$data = array('uniacid' => $_W['uniacid'], 'base_color' => $_GPC['base_color'], 'base_tcolor' => $_GPC['base_tcolor'], 'base_color2' => $_GPC['base_color2'], 'index_style' => $_GPC['index_style'], 'about_style' => $_GPC['about_style'], 'prolist_style' => $_GPC['prolist_style'], 'footer_style' => $_GPC['footer_style'], 'index_about_title' => $_GPC['index_about_title'], 'index_pro_btn' => $_GPC['index_pro_btn'], 'index_pro_lstyle' => $_GPC['index_pro_lstyle'], 'index_pro_tstyle' => $_GPC['index_pro_tstyle'], 'index_pro_ts_al' => $_GPC['index_pro_ts_al'], 'base_color_t' => $_GPC['base_color_t'], 'c_title' => $_GPC['c_title'], 'i_b_x_ts' => $_GPC['i_b_x_ts'], 'i_b_y_ts' => $_GPC['i_b_y_ts'], 'tel_box' => $_GPC['tel_box'], 'aboutCN' => $_GPC['aboutCN'], 'aboutCNen' => $_GPC['aboutCNen'], 'catename' => $_GPC['catename'], 'catenameen' => $_GPC['catenameen'], 'catename_x' => $_GPC['catename_x'], 'catenameen_x' => $_GPC['catenameen_x'], 'c_b_bg' => $_GPC['c_b_bg'], 'c_b_btn' => intval($_GPC['c_b_btn']), 'i_b_x_iw' => intval($_GPC['i_b_x_iw']), 'form_index' => intval($_GPC['form_index']), 'config' => $config);
				if (empty($item['uniacid'])) {
					message('请先填写基础信息!', $this->createWebUrl("base", array("op" => "display")), "error");
				} else {
					pdo_update('sudu8_page_base', $data, array('uniacid' => $uniacid));
				}
				message('DIY样式更新成功!', $this->createWebUrl("diy", array("op" => "display")), "success");
			}
		}
		include $this->template("diy");
	}
	public function doWebAbout()
	{
		include ROOT_PATH . "inc/1sdggsd.php";
	}
	public function doWebCate()
	{
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		if ($op == 'display') {
			$listV = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':cid' => 0));
			$listAll = array();
			foreach ($listV as $key => $val) {
				$id = intval($val['id']);
				$listP = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id = :id ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $id));
				$listS = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and cid = :id ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $id));
				$listP['data'] = $listS;
				array_push($listAll, $listP);
			}
		}
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$cate_list = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE cid = :cid and uniacid = :uniacid ', array(':cid' => 0, ':uniacid' => $uniacid));
			$cateConf = unserialize($item['cateconf']);
			$item['pmarb'] = $cateConf['pmarb'];
			$item['ptit'] = $cateConf['ptit'];
			if (checksubmit('submit')) {
				if (empty($_GPC['name'])) {
					message('请输入栏目标题！');
				}
				$list_style = intval($_GPC['list_style']);
				if ($_GPC['type'] == 'page') {
					if ($_GPC['list_type'] == 1) {
						$list_style = 3;
					}
				}
				$pmarb = $_GPC['pmarb'];
				$ptit = $_GPC['ptit'];
				if (is_null($pmarb)) {
					$pmarb = 10;
				}
				if (is_null($ptit)) {
					$ptit = 1;
				}
				$cateConf = array('pmarb' => $pmarb, 'ptit' => $ptit);
				$cateConf = serialize($cateConf);
				$data = array('uniacid' => $_W['uniacid'], 'cid' => intval($_GPC['cid']), 'name' => $_GPC['name'], 'name_n' => $_GPC['name_n'], 'ename' => $_GPC['ename'], 'cdesc' => $_GPC['cdesc'], 'catepic' => $_GPC['catepic'], 'type' => $_GPC['type'], 'show_i' => intval($_GPC['show_i']), 'statue' => intval($_GPC['statue']), 'num' => intval($_GPC['num']), 'list_type' => intval($_GPC['list_type']), 'list_style' => $list_style, 'list_tstyle' => intval($_GPC['list_tstyle']), 'list_tstylel' => intval($_GPC['list_tstylel']), 'list_stylet' => $_GPC['list_stylet'], 'pic_page_btn' => intval($_GPC['pic_page_btn']), 'content' => $_GPC['content'], 'cateconf' => $cateConf);
				if (empty($id)) {
					pdo_insert('sudu8_page_cate', $data);
				} else {
					pdo_update('sudu8_page_cate', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('栏目 添加/修改 成功!', $this->createWebUrl("cate", array("op" => "display")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('栏目不存在或是已经被删除！');
			}
			$row2 = pdo_fetch('SELECT id FROM ' . tablename('sudu8_page_cate') . ' WHERE cid = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if ($row2 != '') {
				message('请先删除二级栏目!', $this->createWebUrl("cate", array("op" => "display")), "error");
			}
			$row3 = pdo_fetch('SELECT id FROM ' . tablename('sudu8_page_products') . ' WHERE cid = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if ($row3 != '') {
				message('该栏目存在内容，无法删除!', $this->createWebUrl("cate", array("op" => "display")), "error");
			}
			pdo_delete('sudu8_page_cate', array('id' => $id, 'uniacid' => $uniacid));
			message('栏目删除成功!', $this->createWebUrl("cate", array("op" => "display")), "success");
		}
		include $this->template("cate");
	}
	public function doWebpics()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '图片管理';
			$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ' . tablename('sudu8_page_products') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showPic\' ORDER BY i.num DESC,i.id DESC');
			$cates = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showPic\' and cid = 0', array(':uniacid' => $uniacid));
			foreach ($cates as $key => &$res) {
				$res['ziji'] = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showPic\' and cid = :cid', array(':uniacid' => $uniacid, ':cid' => $res['id']));
			}
			if (checksubmit('submit')) {
				$sid = $_GPC['sid'];
				$skey = $_GPC['skey'];
				$where = '';
				if ($sid > 0) {
					$where .= ' and i.cid = ' . $sid;
				}
				if ($skey) {
					$where .= ' and i.title like \'%%' . $skey . '%%\'';
				}
				$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ' . tablename('sudu8_page_products') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showPic\' ' . $where . ' ORDER BY i.num DESC,i.id DESC');
			}
		}
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$item['text'] = unserialize($item['text']);
			$listV = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE cid = :cid and uniacid = :uniacid and type=\'showPic\' ORDER BY num DESC,id DESC', array(':cid' => 0, ':uniacid' => $uniacid));
			$listAll = array();
			foreach ($listV as $key => $val) {
				$cid = intval($val['id']);
				$listP = pdo_fetch('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id = :id and type=\'showPic\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listS = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and cid = :id and type=\'showPic\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listP['data'] = $listS;
				array_push($listAll, $listP);
			}
			if (!empty($id)) {
				if (empty($item)) {
					message('抱歉，图片不存在或是已经删除！', '', 'error');
				}
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				}
				$cid = intval($_GPC['cid']);
				$pcid = pdo_fetch('SELECT cid FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id =:id ', array(':uniacid' => $uniacid, ':id' => $cid));
				$pcid = implode('', $pcid);
				if ($pcid == 0) {
					$pcid = $cid;
				} else {
					$pcid = intval($pcid);
				}
				$data = array('uniacid' => $_W['uniacid'], 'cid' => intval($_GPC['cid']), 'pcid' => $pcid, 'num' => intval($_GPC['num']), 'type' => 'showPic', 'type_x' => intval($_GPC['type_x']), 'type_y' => intval($_GPC['type_y']), 'type_i' => intval($_GPC['type_i']), 'hits' => intval($_GPC['hits']), 'title' => addslashes($_GPC['title']), 'text' => serialize($_GPC['text']), 'thumb' => $_GPC['thumb'], 'desc' => $_GPC['desc'], 'ctime' => TIMESTAMP);
				if (!empty($_GPC['thumb'])) {
					$data['thumb'] = parse_path($_GPC['thumb']);
				}
				if (empty($id)) {
					pdo_insert('sudu8_page_products', $data);
				} else {
					unset($data['ctime']);
					$data['etime '] = TIMESTAMP;
					pdo_update('sudu8_page_products', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('图片 添加/修改 成功!', $this->createWebUrl("pics", array("op" => "display")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('图片不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_products', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("pics", array("op" => "display")), "success");
		}
		include $this->template("pics");
	}
	public function doWebItems()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '文章管理';
			$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ' . tablename('sudu8_page_products') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showArt\' ORDER BY i.num DESC,i.id DESC');
			$cates = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showArt\' and cid = 0', array(':uniacid' => $uniacid));
			foreach ($cates as $key => &$res) {
				$res['ziji'] = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showArt\' and cid = :cid', array(':uniacid' => $uniacid, ':cid' => $res['id']));
			}
			if (checksubmit('submit')) {
				$sid = $_GPC['sid'];
				$skey = $_GPC['skey'];
				$where = '';
				if ($sid > 0) {
					$where .= ' and i.cid = ' . $sid;
				}
				if ($skey) {
					$where .= ' and i.title like \'%%' . $skey . '%%\'';
				}
				$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ' . tablename('sudu8_page_products') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showArt\' ' . $where . ' ORDER BY i.num DESC,i.id DESC');
			}
		}
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$forms = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_formlist') . ' WHERE uniacid = :uniacid ORDER BY ID DESC', array(':uniacid' => $uniacid));
			$listV = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE cid = :cid and uniacid = :uniacid and type=\'showArt\' ORDER BY num DESC,id DESC', array(':cid' => 0, ':uniacid' => $uniacid));
			$listAll = array();
			foreach ($listV as $key => $val) {
				$cid = intval($val['id']);
				$listP = pdo_fetch('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id = :id and type=\'showArt\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listS = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and cid = :id and type=\'showArt\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listP['data'] = $listS;
				array_push($listAll, $listP);
			}
			if (!empty($id)) {
				if (empty($item)) {
					message('抱歉，文章不存在或是已经删除！', '', 'error');
				}
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				}
				$cid = intval($_GPC['cid']);
				$pcid = pdo_fetch('SELECT cid FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id =:id ', array(':uniacid' => $uniacid, ':id' => $cid));
				$pcid = implode('', $pcid);
				if ($pcid == 0) {
					$pcid = $cid;
				} else {
					$pcid = intval($pcid);
				}
				$data = array('uniacid' => $_W['uniacid'], 'cid' => intval($_GPC['cid']), 'pcid' => $pcid, 'type' => 'showArt', 'num' => intval($_GPC['num']), 'type_x' => intval($_GPC['type_x']), 'type_y' => intval($_GPC['type_y']), 'type_i' => intval($_GPC['type_i']), 'hits' => intval($_GPC['hits']), 'title' => addslashes($_GPC['title']), 'text' => htmlspecialchars_decode($_GPC['text'], ENT_QUOTES), 'thumb' => $_GPC['thumb'], 'video' => $_GPC['video'], 'desc' => $_GPC['desc'], 'ctime' => TIMESTAMP, 'formset' => $_GPC['formset']);
				if (!empty($_GPC['thumb'])) {
					$data['thumb'] = parse_path($_GPC['thumb']);
				}
				if (empty($id)) {
					pdo_insert('sudu8_page_products', $data);
				} else {
					unset($data['ctime']);
					$data['etime '] = TIMESTAMP;
					pdo_update('sudu8_page_products', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('文章 添加/修改 成功!', $this->createWebUrl("items", array("id" => $id, "op" => "post")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('文章不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_products', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("items", array("op" => "display")), "success");
		}
		include $this->template("items");
	}
	public function doWeborders()
	{
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$op = $_GPC['op'];
		$ops = array('display', 'yh', 'hx');
		$op = in_array($op, $ops) ? $op : 'display';
		$order = $_GPC['order'];
		if ($op == 'hx') {
			$data['custime'] = time();
			$data['flag'] = 2;
			$res = pdo_update('sudu8_page_order', $data, array('id' => $order));
			message('核销成功!', $this->createWebUrl("orders", array("op" => "display")), "success");
		}
		if ($op == 'yh') {
			$openid = $_GPC['openid'];
			$userinfo = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_user') . ' WHERE uniacid = :uniacid and openid=:openid', array(':uniacid' => $_W['uniacid'], ':openid' => $openid));
			$order_id = $_GPC['order_id'];
			if ($order_id) {
				$orderinfo = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_order') . ' WHERE order_id LIKE :order_id and uniacid = :uniacid and openid = :openid and is_more = 0', array(':order_id' => '%' . $order_id . '%', ':uniacid' => $uniacid, ':openid' => $openid));
				$total = count($orderinfo);
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize = 10;
				$p = ($pageindex - 1) * $pagesize;
				$pager = pagination($total, $pageindex, $pagesize);
				$orders = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_order') . ' WHERE order_id LIKE :order_id and uniacid = :uniacid and openid = :openid  and is_more = 0 LIMIT ' . $p . ',' . $pagesize, array(':order_id' => '%' . $order_id . '%', ':uniacid' => $uniacid, ':openid' => $openid));
				foreach ($orders as $res) {
					$arr[] = array('id' => $res['id'], 'order_id' => $res['order_id'], 'pid' => $res['pid'], 'thumb' => $_W['attachurl'] . $res['thumb'], 'product' => $res['product'], 'price' => $res['price'], 'num' => $res['num'], 'yhq' => $res['yhq'], 'true_price' => $res['true_price'], 'creattime' => date('Y-m-d H:i:s', $res['creattime']), 'custime' => $res['custime'] ? date('Y-m-d H:i:s', $res['custime']) : '未消费', 'flag' => $res['flag'], 'pro_user_name' => $res['pro_user_name'], 'pro_user_tel' => $res['pro_user_tel'], 'pro_user_txt' => $res['pro_user_txt'], 'overtime' => date('Y-m-d H:i:s', $res['overtime']));
				}
			} else {
				$all = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_order') . ' WHERE uniacid = :uniacid and openid = :openid  and is_more = 0 ORDER BY `creattime` DESC ', array(':uniacid' => $uniacid, ':openid' => $openid));
				$total = count($all);
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize = 10;
				$p = ($pageindex - 1) * $pagesize;
				$pager = pagination($total, $pageindex, $pagesize);
				$orders = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_order') . ' WHERE uniacid = :uniacid  and openid = :openid  and is_more = 0 ORDER BY `creattime` DESC LIMIT ' . $p . ',' . $pagesize, array(':uniacid' => $uniacid, ':openid' => $openid));
				foreach ($orders as $res) {
					$arr[] = array('id' => $res['id'], 'order_id' => $res['order_id'], 'pid' => $res['pid'], 'thumb' => $_W['attachurl'] . $res['thumb'], 'product' => $res['product'], 'price' => $res['price'], 'num' => $res['num'], 'yhq' => $res['yhq'], 'true_price' => $res['true_price'], 'creattime' => date('Y-m-d H:i:s', $res['creattime']), 'custime' => $res['custime'] ? date('Y-m-d H:i:s', $res['custime']) : '未消费', 'flag' => $res['flag'], 'pro_user_name' => $res['pro_user_name'], 'pro_user_tel' => $res['pro_user_tel'], 'pro_user_txt' => $res['pro_user_txt'], 'overtime' => date('Y-m-d H:i:s', $res['overtime']));
				}
			}
		}
		if ($op == 'display') {
			$order_id = $_GPC['order_id'];
			if ($order_id) {
				$orderinfo = pdo_fetchAll('SELECT id FROM ' . tablename('sudu8_page_order') . ' WHERE order_id LIKE :order_id and uniacid = :uniacid  and is_more = 0', array(':order_id' => '%' . $order_id . '%', ':uniacid' => $uniacid));
				$total = count($orderinfo);
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize = 10;
				$p = ($pageindex - 1) * $pagesize;
				$pager = pagination($total, $pageindex, $pagesize);
				$orders = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_order') . ' WHERE order_id LIKE :order_id and uniacid = :uniacid  and is_more = 0  LIMIT ' . $p . ',' . $pagesize, array(':order_id' => '%' . $order_id . '%', ':uniacid' => $uniacid));
				foreach ($orders as $res) {
					$arr[] = array('id' => $res['id'], 'order_id' => $res['order_id'], 'pid' => $res['pid'], 'thumb' => $_W['attachurl'] . $res['thumb'], 'product' => $res['product'], 'price' => $res['price'], 'num' => $res['num'], 'yhq' => $res['yhq'], 'true_price' => $res['true_price'], 'creattime' => date('Y-m-d H:i:s', $res['creattime']), 'custime' => $res['custime'] ? date('Y-m-d H:i:s', $res['custime']) : '未消费', 'flag' => $res['flag'], 'pro_user_name' => $res['pro_user_name'], 'pro_user_tel' => $res['pro_user_tel'], 'pro_user_add' => $res['pro_user_add'], 'pro_user_txt' => $res['pro_user_txt'], 'overtime' => date('Y-m-d H:i:s', $res['overtime']));
				}
			} else {
				$all = pdo_fetchall('SELECT id FROM ' . tablename('sudu8_page_order') . ' WHERE uniacid = :uniacid  and is_more = 0 ORDER BY `creattime` DESC ', array(':uniacid' => $uniacid));
				$total = count($all);
				$pageindex = max(1, intval($_GPC['page']));
				$pagesize = 10;
				$p = ($pageindex - 1) * $pagesize;
				$pager = pagination($total, $pageindex, $pagesize);
				$orders = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_order') . ' WHERE uniacid = :uniacid  and is_more = 0 ORDER BY `creattime` DESC LIMIT ' . $p . ',' . $pagesize, array(':uniacid' => $uniacid));
				foreach ($orders as $res) {
					$arr[] = array('id' => $res['id'], 'order_id' => $res['order_id'], 'pid' => $res['pid'], 'thumb' => $_W['attachurl'] . $res['thumb'], 'product' => $res['product'], 'price' => $res['price'], 'num' => $res['num'], 'yhq' => $res['yhq'], 'true_price' => $res['true_price'], 'creattime' => date('Y-m-d H:i:s', $res['creattime']), 'custime' => $res['custime'] ? date('Y-m-d H:i:s', $res['custime']) : '未消费', 'flag' => $res['flag'], 'pro_user_name' => $res['pro_user_name'], 'pro_user_tel' => $res['pro_user_tel'], 'pro_user_add' => $res['pro_user_add'], 'pro_user_txt' => $res['pro_user_txt'], 'overtime' => date('Y-m-d H:i:s', $res['overtime']));
				}
			}
		}
		include $this->template("orders");
	}
	public function doWebProducts()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'consumption', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '产品管理';
			$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type,i.is_more,i.buy_type FROM ' . tablename('sudu8_page_products') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showPro\' and i.is_more = 0 ORDER BY i.num DESC,i.id DESC');
			$cates = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showPro\' and cid = 0', array(':uniacid' => $uniacid));
			foreach ($cates as $key => &$res) {
				$res['ziji'] = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showPro\' and cid = :cid', array(':uniacid' => $uniacid, ':cid' => $res['id']));
			}
			if (checksubmit('submit')) {
				$sid = $_GPC['sid'];
				$skey = $_GPC['skey'];
				$where = '';
				if ($sid > 0) {
					$where .= ' and i.cid = ' . $sid;
				}
				if ($skey) {
					$where .= ' and i.title like \'%%' . $skey . '%%\'';
				}
				$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type,i.is_more,i.buy_type FROM ' . tablename('sudu8_page_products') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showPro\' ' . $where . ' ORDER BY i.num DESC,i.id DESC');
			}
		}
		if ($op == 'consumption') {
		}
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$orders_l = pdo_fetchall('SELECT num FROM ' . tablename('sudu8_page_order') . ' WHERE pid = :pid and uniacid = :uniacid and flag > 0', array(':pid' => $id, ':uniacid' => $uniacid));
			$forms = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_form_duo') . ' WHERE uniacid = :uniacid ORDER BY ID DESC', array(':uniacid' => $uniacid));
			$item['sale_tnum'] == 0;
			if ($orders_l) {
				$sum = 0;
				foreach ($orders_l as $rec) {
					$sum += intval($rec['num']);
				}
				$item['sale_tnum'] = $sum;
			}
			$item['text'] = unserialize($item['text']);
			if ($item['sale_time'] != 0) {
				$item['sale_time'] = date('Y-m-d H:i:s', $item['sale_time']);
			}
			$listV = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE cid = :cid and uniacid = :uniacid and type=\'showPro\' ORDER BY num DESC,id DESC', array(':cid' => 0, ':uniacid' => $uniacid));
			$listAll = array();
			foreach ($listV as $key => $val) {
				$cid = intval($val['id']);
				$listP = pdo_fetch('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id = :id and type=\'showPro\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listS = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and cid = :id and type=\'showPro\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listP['data'] = $listS;
				array_push($listAll, $listP);
			}
			if (!empty($id)) {
				if (empty($item)) {
					message('抱歉，产品不存在或是已经删除！', '', 'error');
				}
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				}
				if (empty($_GPC['buy_type'])) {
					message('自定义购买方式不能为空！');
				}
				$cid = intval($_GPC['cid']);
				$pcid = pdo_fetch('SELECT cid FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id =:id ', array(':uniacid' => $uniacid, ':id' => $cid));
				$pcid = implode('', $pcid);
				if ($pcid == 0) {
					$pcid = $cid;
				} else {
					$pcid = intval($pcid);
				}
				$data = array('uniacid' => $_W['uniacid'], 'cid' => intval($_GPC['cid']), 'pcid' => $pcid, 'num' => intval($_GPC['num']), 'type' => 'showPro', 'type_x' => intval($_GPC['type_x']), 'type_y' => intval($_GPC['type_y']), 'type_i' => intval($_GPC['type_i']), 'hits' => intval($_GPC['hits']), 'sale_num' => intval($_GPC['sale_num']), 'title' => addslashes($_GPC['title']), 'text' => serialize($_GPC['text']), 'thumb' => $_GPC['thumb'], 'desc' => $_GPC['desc'], 'ctime' => TIMESTAMP, 'price' => $_GPC['price'], 'market_price' => $_GPC['market_price'], 'score' => $_GPC['score'], 'pro_flag' => $_GPC['pro_flag'], 'pro_flag_tel' => $_GPC['pro_flag_tel'], 'pro_flag_add' => $_GPC['pro_flag_add'], 'pro_flag_data' => $_GPC['pro_flag_data'], 'pro_flag_data_name' => $_GPC['pro_flag_data_name'], 'pro_flag_time' => $_GPC['pro_flag_time'], 'pro_flag_ding' => $_GPC['pro_flag_ding'], 'pro_kc' => $_GPC['pro_kc'], 'pro_xz' => $_GPC['pro_xz'], 'product_txt' => htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES), 'sale_time' => strtotime($_GPC['sale_time']), 'labels' => $_GPC['labels'], 'buy_type' => $_GPC['buy_type'], 'formset' => $_GPC['formset'], 'con2' => $_GPC['con2'], 'con3' => $_GPC['con3']);
				if (!empty($_GPC['thumb'])) {
					$data['thumb'] = parse_path($_GPC['thumb']);
				}
				if (empty($id)) {
					pdo_insert('sudu8_page_products', $data);
				} else {
					unset($data['ctime']);
					$data['etime '] = TIMESTAMP;
					pdo_update('sudu8_page_products', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('产品 添加/修改 成功!', $this->createWebUrl("products", array("op" => "display")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('产品不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_products', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("products", array("op" => "display")), "success");
		}
		include $this->template("products");
	}
	public function doWebwxapps()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '小程序管理';
			$wxapps = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ' . tablename('sudu8_page_wxapps') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showWxapps\' ORDER BY i.num DESC,i.id DESC');
			$cates = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showWxapps\' and cid = 0', array(':uniacid' => $uniacid));
			foreach ($cates as $key => &$res) {
				$res['ziji'] = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and type = \'showWxapps\' and cid = :cid', array(':uniacid' => $uniacid, ':cid' => $res['id']));
			}
			if (checksubmit('submit')) {
				$sid = $_GPC['sid'];
				$skey = $_GPC['skey'];
				$where = '';
				if ($sid > 0) {
					$where .= ' and i.cid = ' . $sid;
				}
				if ($skey) {
					$where .= ' and i.title like \'%%' . $skey . '%%\'';
				}
				$wxapps = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.type FROM ' . tablename('sudu8_page_wxapps') . 'as i left join' . tablename('sudu8_page_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' and i.type =\'showWxapps\' ' . $where . ' ORDER BY i.num DESC,i.id DESC');
			}
		}
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_wxapps') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$listV = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE cid = :cid and uniacid = :uniacid and type=\'showWxapps\' ORDER BY num DESC,id DESC', array(':cid' => 0, ':uniacid' => $uniacid));
			$listAll = array();
			foreach ($listV as $key => $val) {
				$cid = intval($val['id']);
				$listP = pdo_fetch('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id = :id and type=\'showWxapps\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listS = pdo_fetchAll('SELECT id,cid,name FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and cid = :id and type=\'showWxapps\' ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid, ':id' => $cid));
				$listP['data'] = $listS;
				array_push($listAll, $listP);
			}
			if (!empty($id)) {
				if (empty($item)) {
					message('抱歉，小程序不存在或是已经删除！', '', 'error');
				}
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('小程序名字不能为空，请输入！');
				}
				$cid = intval($_GPC['cid']);
				$pcid = pdo_fetch('SELECT cid FROM ' . tablename('sudu8_page_cate') . ' WHERE uniacid = :uniacid and id =:id ', array(':uniacid' => $uniacid, ':id' => $cid));
				$pcid = implode('', $pcid);
				if ($pcid == 0) {
					$pcid = $cid;
				} else {
					$pcid = intval($pcid);
				}
				$data = array('uniacid' => $_W['uniacid'], 'cid' => intval($_GPC['cid']), 'pcid' => $pcid, 'type' => 'showWxapps', 'num' => intval($_GPC['num']), 'type_i' => intval($_GPC['type_i']), 'title' => addslashes($_GPC['title']), 'thumb' => $_GPC['thumb'], 'appId' => $_GPC['appId'], 'path' => $_GPC['path'], 'desc' => $_GPC['desc']);
				if (!empty($_GPC['thumb'])) {
					$data['thumb'] = parse_path($_GPC['thumb']);
				}
				if (empty($id)) {
					pdo_insert('sudu8_page_wxapps', $data);
				} else {
					pdo_update('sudu8_page_wxapps', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('小程序 添加/修改 成功!', $this->createWebUrl("wxapps", array("op" => "display")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_wxapps') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('小程序不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_wxapps', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("wxapps", array("op" => "display")), "success");
		}
		include $this->template("wxapps");
	}
	public function doWebForms()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('formAllL', 'formAllV', 'formAllD', 'formAllCL', 'formAllCP', 'formAllCD', 'formSysL', 'formSysV', 'formSysP', 'formSysD', 'formNotice');
		$op = in_array($op, $ops) ? $op : 'formAllL';
		$uniacid = $_W['uniacid'];
		if ($op == 'formAllL') {
			$_W['page']['title'] = '万能表单信息列表';
			$pindex = max(1, intval($_GPC['page']));
			$psize = 15;
			$formset = pdo_fetchall('SELECT id,cid,creattime,flag FROM ' . tablename('sudu8_page_formcon') . ' WHERE uniacid = :uniacid ORDER BY flag ASC, id DESC LIMIT ' . ($pindex - 1) * $psize . ',' . $psize, array(':uniacid' => $uniacid));
			if ($formset) {
				foreach ($formset as $key => &$res) {
					$title = pdo_fetch('SELECT title FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $res['cid'], ':uniacid' => $uniacid));
					$res['title'] = $title['title'];
					$res['creattime'] = date('Y-m-d H:i:s', $res['creattime']);
				}
			}
		}
		if ($op == 'formAllV') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_formcon') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if ($item) {
				$title = pdo_fetch('SELECT title FROM ' . tablename('sudu8_page_products') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $item['cid'], ':uniacid' => $uniacid));
				$item['title'] = $title['title'];
				$itemval = unserialize($item['val']);
				foreach ($itemval as $key => &$res) {
					if ($res['z_val']) {
						foreach ($res["z_val"] as $key => &$rek) {
							$rek = HTTPSHOST . $rek;
						}
					}
				}
				$item['val'] = $itemval;
				$item['creattime'] = date('Y-m-d H:i:s', $item['creattime']);
				if ($item['vtime']) {
					$item['vtime'] = date('Y-m-d H:i:s', $item['vtime']);
				}
			}
			if (empty($item)) {
				message('记录不存在或是已经被删除！');
			}
			if (checksubmit('submit')) {
				$data = array('flag' => 1, 'beizhu' => $_GPC['beizhu'], 'vtime' => TIMESTAMP);
				pdo_update('sudu8_page_formcon', $data, array('id' => $id, 'uniacid' => $uniacid));
				message('设置成功!', $this->createWebUrl("forms", array("op" => "formAllL")), "success");
			}
		}
		if ($op == 'formAllD') {
			$id = $_GPC['id'];
			pdo_delete('sudu8_page_formcon', array('id' => $id, 'uniacid' => $uniacid));
			message('信息删除成功!', $this->createWebUrl("forms", array("op" => "formAllL")), "success");
		}
		if ($op == 'formAllCL') {
			$_W['page']['title'] = '万能表单管理';
			$formset = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_formlist') . ' WHERE uniacid = :uniacid ORDER BY id DESC ', array(':uniacid' => $uniacid));
			foreach ($formset as $key => &$res) {
				$res['tp_text'] = unserialize($res['tp_text']);
			}
		}
		if ($op == 'formAllCP') {
			$id = $_GPC['id'];
			$formlet = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_formt') . ' WHERE flag = 1');
			$jieguo = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_formlist') . ' WHERE id = :id ORDER BY id', array(':id' => $id));
			$jieguo['tp_text'] = unserialize($jieguo['tp_text']);
			if (checksubmit('submit')) {
				$data['uniacid'] = $uniacid;
				$data['formname'] = $_GPC['formname'];
				$zd_name = array();
				$zd_name = $_GPC['zd_name'];
				$ck_box = array();
				$ck_box = $_GPC['ck_box'];
				$tp_text = array();
				$tp_text = $_GPC['tp_text'];
				$types = array();
				$types = $_GPC['types'];
				$allcount = count($zd_name);
				$formsValueAll = array();
				$formsValue = array();
				foreach ($zd_name as $key => &$res) {
					$formsValue['name'] = $res;
					$formsValue['type'] = $types[$key];
					$formsValue['ismust'] = $ck_box[$key];
					$formsValue['tp_text'] = $tp_text[$key];
					$formsValueAll[] = $formsValue;
				}
				$data['tp_text'] = serialize($formsValueAll);
				if ($id) {
					$res = pdo_update('sudu8_page_formlist', $data, array('id' => $id, 'uniacid' => $uniacid));
				} else {
					$res = pdo_insert('sudu8_page_formlist', $data);
				}
				message('万能表单 添加/修改 成功!', $this->createWebUrl("forms", array("op" => "formAllCL")), "success");
			}
		}
		if ($op == 'formAllCD') {
			$id = $_GPC['id'];
			$uniacid = $_W['uniacid'];
			pdo_delete('sudu8_page_formlist', array('id' => $id, 'uniacid' => $uniacid));
			message('表单删除成功!', $this->createWebUrl("forms", array("op" => "formAllCL")), "success");
		}
		if ($op == 'formSysL') {
			$_W['page']['title'] = '系统预约信息列表';
			$participators = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_forms') . ' WHERE uniacid = :uniacid ORDER BY id DESC', array(':uniacid' => $uniacid));
			$total = count($participators);
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 15;
			$pager = pagination($total, $pageindex, $pagesize);
			$p = ($pageindex - 1) * 15;
			$list = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_forms') . ' WHERE uniacid = :uniacid ORDER BY `id` DESC LIMIT ' . $p . ',' . $pagesize, array(':uniacid' => $uniacid));
		}
		if ($op == 'formSysV') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_forms_config') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			$v = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_forms') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$item['t5'] = unserialize($item['t5']);
			$item['t6'] = unserialize($item['t6']);
			$item['s2'] = unserialize($item['s2']);
			$item['c2'] = unserialize($item['c2']);
			$item['con2'] = unserialize($item['con2']);
			if (empty($v)) {
				message('记录不存在或是已经被删除！');
			}
			if (checksubmit('submit')) {
				$data = array('status' => 1, 'sss_beizhu' => $_GPC['sss_beizhu'], 'vtime' => TIMESTAMP);
				pdo_update('sudu8_page_forms', $data, array('id' => $id, 'uniacid' => $uniacid));
				message('设置成功!', $this->createWebUrl("forms", array("op" => "formSysL")), "success");
			}
		}
		if ($op == 'formSysD') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_forms') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('记录不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_forms', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("forms", array("op" => "formSysL")), "success");
		}
		if ($op == 'formSysP') {
			$_W['page']['title'] = '系统预约配置';
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_forms_config') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			$item['t5arr'] = unserialize($item['t5']);
			$item['t5n'] = $item['t5arr']['t5n'];
			$item['t5u'] = $item['t5arr']['t5u'];
			$item['t5m'] = $item['t5arr']['t5m'];
			$item['t5i'] = $item['t5arr']['t5i'];
			$item['t6arr'] = unserialize($item['t6']);
			$item['t6n'] = $item['t6arr']['t6n'];
			$item['t6u'] = $item['t6arr']['t6u'];
			$item['t6m'] = $item['t6arr']['t6m'];
			$item['t6i'] = $item['t6arr']['t6i'];
			$item['c2arr'] = unserialize($item['c2']);
			$item['c2n'] = $item['c2arr']['c2n'];
			$item['c2num'] = $item['c2arr']['c2num'];
			$item['c2v'] = $item['c2arr']['c2v'];
			$item['c2u'] = $item['c2arr']['c2u'];
			$item['c2m'] = $item['c2arr']['c2m'];
			$item['c2i'] = $item['c2arr']['c2i'];
			$item['s2arr'] = unserialize($item['s2']);
			$item['s2n'] = $item['s2arr']['s2n'];
			$item['s2num'] = $item['s2arr']['s2num'];
			$item['s2v'] = $item['s2arr']['s2v'];
			$item['s2u'] = $item['s2arr']['s2u'];
			$item['s2m'] = $item['s2arr']['s2m'];
			$item['s2i'] = $item['s2arr']['s2i'];
			$item['con2arr'] = unserialize($item['con2']);
			$item['con2n'] = $item['con2arr']['con2n'];
			$item['con2u'] = $item['con2arr']['con2u'];
			$item['con2m'] = $item['con2arr']['con2m'];
			$item['con2i'] = $item['con2arr']['con2i'];
			$item['img1arr'] = unserialize($item['img1']);
			$item['img1n'] = $item['img1arr']['img1n'];
			$item['img1u'] = $item['img1arr']['img1u'];
			$item['img1m'] = $item['img1arr']['img1m'];
			$item['img1i'] = $item['img1arr']['img1i'];
			$item['img1not'] = $item['img1arr']['img1not'];
			if (checksubmit('submit')) {
				if (empty($_GPC['forms_name'])) {
					message('请输入表单名称');
				}
				$t5arr = array('t5n' => $_GPC['t5n'], 't5u' => $_GPC['t5u'], 't5m' => $_GPC['t5m'], 't5i' => $_GPC['t5i']);
				$t5text = serialize($t5arr);
				$t6arr = array('t6n' => $_GPC['t6n'], 't6u' => $_GPC['t6u'], 't6m' => $_GPC['t6m'], 't6i' => $_GPC['t6i']);
				$t6text = serialize($t6arr);
				$c2arr = array('c2n' => $_GPC['c2n'], 'c2num' => $_GPC['c2num'], 'c2v' => $_GPC['c2v'], 'c2u' => $_GPC['c2u'], 'c2m' => $_GPC['c2m'], 'c2i' => $_GPC['c2i']);
				$c2text = serialize($c2arr);
				$s2arr = array('s2n' => $_GPC['s2n'], 's2num' => $_GPC['s2num'], 's2v' => $_GPC['s2v'], 's2u' => $_GPC['s2u'], 's2m' => $_GPC['s2m'], 's2i' => $_GPC['s2i']);
				$s2text = serialize($s2arr);
				$con2arr = array('con2n' => $_GPC['con2n'], 'con2u' => $_GPC['con2u'], 'con2m' => $_GPC['con2m'], 'con2i' => $_GPC['con2i']);
				$con2text = serialize($con2arr);
				$img1arr = array('img1n' => $_GPC['img1n'], 'img1u' => $_GPC['img1u'], 'img1m' => $_GPC['img1m'], 'img1i' => $_GPC['img1i'], 'img1not' => $_GPC['img1not']);
				$img1text = serialize($img1arr);
				$data = array('uniacid' => $uniacid, 'forms_head' => $_GPC['forms_head'], 'forms_head_con' => htmlspecialchars_decode($_GPC['forms_head_con'], ENT_QUOTES), 'forms_title_s' => $_GPC['forms_title_s'], 'forms_name' => $_GPC['forms_name'], 'forms_ename' => $_GPC['forms_ename'], 'success' => $_GPC['success'], 'name' => $_GPC['name'], 'name_must' => intval($_GPC['name_must']), 'tel' => $_GPC['tel'], 'tel_use' => intval($_GPC['tel_use']), 'tel_must' => intval($_GPC['tel_must']), 'wechat' => $_GPC['wechat'], 'wechat_use' => intval($_GPC['wechat_use']), 'wechat_must' => intval($_GPC['wechat_must']), 'address' => $_GPC['address'], 'address_use' => intval($_GPC['address_use']), 'address_must' => intval($_GPC['address_must']), 'date' => $_GPC['date'], 'date_use' => intval($_GPC['date_use']), 'date_must' => intval($_GPC['date_must']), 'time' => $_GPC['time'], 'time_use' => intval($_GPC['time_use']), 'time_must' => intval($_GPC['time_must']), 'single_n' => $_GPC['single_n'], 'single_num' => intval($_GPC['single_num']), 'single_v' => $_GPC['single_v'], 'single_use' => intval($_GPC['single_use']), 'single_must' => intval($_GPC['single_must']), 'checkbox_n' => $_GPC['checkbox_n'], 'checkbox_num' => intval($_GPC['checkbox_num']), 'checkbox_v' => $_GPC['checkbox_v'], 'checkbox_use' => intval($_GPC['checkbox_use']), 'checkbox_must' => intval($_GPC['checkbox_must']), 'content_n' => $_GPC['content_n'], 'content_use' => intval($_GPC['content_use']), 'content_must' => intval($_GPC['content_must']), 'mail_sendto' => $_GPC['mail_sendto'], 'forms_btn' => $_GPC['forms_btn'], 'forms_style' => intval($_GPC['forms_style']), 'forms_inps' => intval($_GPC['forms_inps']), 'subtime' => intval($_GPC['subtime']), 'tel_i' => intval($_GPC['tel_i']), 'wechat_i' => intval($_GPC['wechat_i']), 'address_i' => intval($_GPC['address_i']), 'date_i' => intval($_GPC['date_i']), 'time_i' => intval($_GPC['time_i']), 'single_i' => intval($_GPC['single_i']), 'checkbox_i' => intval($_GPC['checkbox_i']), 'content_i' => intval($_GPC['content_i']), 't5' => $t5text, 't6' => $t6text, 'c2' => $c2text, 's2' => $s2text, 'con2' => $con2text, 'img1' => $img1text);
				if (empty($item['uniacid'])) {
					pdo_insert('sudu8_page_forms_config', $data);
				} else {
					pdo_update('sudu8_page_forms_config', $data, array('uniacid' => $uniacid));
				}
				message('表单配置成功!', $this->createWebUrl("forms", array("op" => "formSysL")), "success");
			}
		}
		if ($op == 'formNotice') {
			$_W['page']['title'] = '提醒接收人';
			$item = pdo_fetch('SELECT uniacid,mail_sendto FROM ' . tablename('sudu8_page_forms_config') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			if (checksubmit('submit')) {
				$data = array('uniacid' => $uniacid, 'mail_sendto' => $_GPC['mail_sendto']);
				if (empty($item['uniacid'])) {
					pdo_insert('sudu8_page_forms_config', $data);
				} else {
					pdo_update('sudu8_page_forms_config', $data, array('uniacid' => $uniacid));
				}
				message('提醒接收人修改成功!', $this->createWebUrl("forms", array("op" => "formNotice")), "success");
			}
		}
		include $this->template("forms");
	}
	public function base2()
	{
	   }
	public function doWebNav()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('index', 'list', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'index';
		$uniacid = $_W['uniacid'];
		if ($op == 'index') {
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_nav') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			if ($item['title_bg']) {
				$item['title_bg'] = $this->RGBToHex($item["title_bg"]);
			}
			if (checksubmit('submit')) {
				if ($_GPC['title_bg']) {
					$title_bg = $this->hex2rgb($_GPC["title_bg"]);
				}
				$data = array('uniacid' => $_W['uniacid'], 'statue' => intval($_GPC['statue']), 'type' => intval($_GPC['type']), 'name' => $_GPC['name'], 'ename' => $_GPC['ename'], 'name_s' => intval($_GPC['name_s']), 'style' => intval($_GPC['style']), 'url' => $_GPC['url'], 'box_p_tb' => floatval($_GPC['box_p_tb']), 'box_p_lr' => floatval($_GPC['box_p_lr']), 'number' => intval($_GPC['number']), 'img_size' => floatval($_GPC['img_size']), 'title_color' => $_GPC['title_color'], 'title_position' => intval($_GPC['title_position']), 'title_bg' => $title_bg);
				if (empty($item['uniacid'])) {
					pdo_insert('sudu8_page_nav', $data);
				} else {
					pdo_update('sudu8_page_nav', $data, array('uniacid' => $uniacid));
				}
				message('导航添加/修改成功!', $this->createWebUrl("nav", array("op" => "index")), "success");
			}
		}
		if ($op == 'list') {
			$list = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_navlist') . ' WHERE uniacid = :uniacid ORDER BY num desc', array(':uniacid' => $uniacid));
		}
		if ($op == 'post') {
			$id = $_GPC['id'];
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_navlist') . ' WHERE uniacid = :uniacid and id = :id', array(':uniacid' => $uniacid, ':id' => $id));
			if (checksubmit('submit')) {
				if (is_null($_GPC['flag'])) {
					$_GPC['flag'] = 1;
				}
				$data = array('uniacid' => $_W['uniacid'], 'num' => intval($_GPC['num']), 'flag' => intval($_GPC['flag']), 'type' => intval($_GPC['type']), 'title' => $_GPC['title'], 'pic' => $_GPC['pic'], 'url' => $_GPC['url'], 'url2' => $_GPC['url2']);
				if (empty($item['id'])) {
					pdo_insert('sudu8_page_navlist', $data);
				} else {
					pdo_update('sudu8_page_navlist', $data, array('uniacid' => $uniacid, 'id' => $id));
				}
				message('导航添加/修改成功!', $this->createWebUrl("nav", array("op" => "list")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_navlist') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('导航不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_navlist', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("nav", array("op" => "list")), "success");
		}
		include $this->template("nav");
	}
	public function doWebUser()
	{
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$op = $_GPC['op'];
		$ops = array('display', 'couspon', 'cousponpass');
		$op = in_array($op, $ops) ? $op : 'display';
		if ($op == 'display') {
			$all = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_user') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
			$total = count($all);
			$pageindex = max(1, intval($_GPC['page']));
			$pagesize = 10;
			$p = ($pageindex - 1) * $pagesize;
			$pager = pagination($total, $pageindex, $pagesize);
			$user = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_user') . ' WHERE uniacid = :uniacid ORDER BY `id` desc  LIMIT ' . $p . ',' . $pagesize, array(':uniacid' => $uniacid));
			foreach ($user as &$row) {
				$orders = pdo_fetch('SELECT count(*) as n FROM ' . tablename('sudu8_page_order') . ' WHERE uniacid = :uniacid and openid = :openid', array(':uniacid' => $_W['uniacid'], ':openid' => $row['openid']));
				$row['orders'] = $orders['n'];
				$row2 = pdo_fetch('SELECT count(*) as n FROM ' . tablename('sudu8_page_coupon_user') . ' WHERE uniacid = :uniacid and flag = 0 and uid=:uid', array(':uid' => $row['id'], ':uniacid' => $uniacid));
				$row['coupon'] = $row2['n'];
			}
		}
		if ($op == 'couspon') {
			$uid = $_GPC['uid'];
			$coupon = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_coupon_user') . ' WHERE uniacid = :uniacid and uid = :uid', array(':uniacid' => $_W['uniacid'], ':uid' => $uid));
			foreach ($coupon as $key => &$res) {
				$couponinfo = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_coupon') . ' WHERE uniacid = :uniacid and id = :id', array(':uniacid' => $_W['uniacid'], ':id' => $res['cid']));
				$res['title'] = $couponinfo['title'];
			}
		}
		if ($op == 'cousponpass') {
			$id = $_GPC['id'];
			$uid = $_GPC['uid'];
			$data['utime'] = time();
			$data['flag'] = 1;
			$res = pdo_update('sudu8_page_coupon_user', $data, array('id' => $id));
			message('核销成功!', $this->createWebUrl("user", array("op" => "couspon", "uid" => $uid)), "success");
		}
		include $this->template("user");
	}
	public function doWebSales()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('rechargeShow', 'rechargePost', 'rechargeDel', 'couponShow', 'couponPost', 'couponDel', 'hxmm', 'jfgz');
		$op = in_array($op, $ops) ? $op : 'couponShow';
		$uniacid = $_W['uniacid'];
		if ($op == 'couponShow') {
			$_W['page']['title'] = '优惠券管理';
			$coupon = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_coupon') . ' WHERE uniacid = :uniacid ORDER BY num DESC,id DESC', array(':uniacid' => $_W['uniacid']));
			foreach ($coupon as $key => &$res) {
				$yhqs = pdo_fetch('SELECT count(*) as n FROM ' . tablename('sudu8_page_coupon_user') . ' WHERE uniacid = :uniacid and cid = :id', array(':uniacid' => $_W['uniacid'], ':id' => $res['id']));
				$res['kc'] = $res['counts'] - $yhqs['n'];
				$res['state1'] = $res['etime'] - time();
				if ($res['state1'] > 0) {
					$res['state'] = 1;
				} else {
					if ($res['state1'] < 0) {
						$res['state'] = 2;
						if ($res['etime'] == 0) {
							$res['state'] = 0;
						}
					}
				}
			}
		}
		if ($op == 'couponPost') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_coupon') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if ($item['btime'] != 0) {
				$item['btime'] = date('Y-m-d H:i:s', $item['btime']);
			}
			if ($item['etime'] != 0) {
				$item['etime'] = date('Y-m-d H:i:s', $item['etime']);
			}
			if (checksubmit('submit')) {
				if (!$_GPC['price']) {
					message('优惠价不能为空！');
				}
				$data = array('num' => $_GPC['num'], 'title' => $_GPC['title'], 'uniacid' => $uniacid, 'price' => $_GPC['price'], 'pay_money' => $_GPC['pay_money'], 'btime' => strtotime($_GPC['btime']), 'etime' => strtotime($_GPC['etime']), 'counts' => $_GPC['counts'], 'xz_count' => $_GPC['xz_count'], 'color' => $_GPC['color'], 'creattime' => time(), 'flag' => $_GPC['flag']);
				if (empty($id)) {
					pdo_insert('sudu8_page_coupon', $data);
				} else {
					pdo_update('sudu8_page_coupon', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('优惠券 添加/修改 成功!', $this->createWebUrl("sales", array("op" => "couponShow")), "success");
			}
		}
		if ($op == 'couponDel') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_coupon') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('优惠券不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_coupon', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("sales", array("op" => "couponShow")), "success");
		}
		if ($op == 'rechargeShow') {
			$guiz = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_recharge') . ' WHERE uniacid = :uniacid order by money asc', array(':uniacid' => $uniacid));
			$jifen = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_rechargeconf') . ' WHERE uniacid = :uniacid', array(':uniacid' => $uniacid));
			if (checksubmit('submit')) {
				if (!$_GPC['scroe']) {
					message('积分数不能为空！');
				}
				if (!$_GPC['money']) {
					message('兑换金额不能为空！');
				}
				if ($_GPC['scroe'] < 0) {
					$_GPC['scroe'] = 0;
				}
				if ($_GPC['money'] < 0) {
					$_GPC['money'] = 0;
				}
				$data = array('uniacid' => $uniacid, 'scroe' => $_GPC['scroe'], 'money' => $_GPC['money']);
				if ($jifen) {
					$res = pdo_update('sudu8_page_rechargeconf', $data, array('uniacid' => $uniacid));
				} else {
					$res = pdo_insert('sudu8_page_rechargeconf', $data);
				}
				message('充值基础信息更新成功!', $this->createWebUrl("sales", array("op" => "rechargeShow")), "success");
			}
		}
		if ($op == 'rechargePost') {
			$id = $_GPC['id'];
			$guiz = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_recharge') . ' WHERE id = :id', array(':id' => $id));
			if (checksubmit('submit')) {
				if (!$_GPC['money']) {
					message('充值金额不能为空！');
				}
				if ($_GPC['money'] < 0) {
					$_GPC['money'] = 0;
				}
				if ($_GPC['getmoney'] < 0) {
					$_GPC['getmoney'] = 0;
				}
				if ($_GPC['getscore'] < 0) {
					$_GPC['getscore'] = 0;
				}
				$data = array('uniacid' => $uniacid, 'money' => $_GPC['money'], 'getmoney' => $_GPC['getmoney'], 'getscore' => $_GPC['getscore']);
				if ($id) {
					$res = pdo_update('sudu8_page_recharge', $data, array('uniacid' => $uniacid, 'id' => $id));
				} else {
					$res = pdo_insert('sudu8_page_recharge', $data);
				}
				message('充值规则更新成功!', $this->createWebUrl("sales", array("op" => "rechargeShow")), "success");
			}
		}
		if ($op == 'rechargeDel') {
			$id = $_GPC['id'];
			$res = pdo_delete('sudu8_page_recharge', array('id' => $id, 'uniacid' => $uniacid));
			if ($res) {
				message('充值规则删除成功!', $this->createWebUrl("sales", array("op" => "rechargeShow")), "success");
			}
		}
		if ($op == 'hxmm') {
			$_W['page']['title'] = '核销密码';
			$hxmm = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_base') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
			if (checksubmit('submit')) {
				if (!$_GPC['hxmm']) {
					message('核销密码不能为空！');
				}
				$data = array('hxmm' => $_GPC['hxmm']);
				if (empty($uniacid)) {
					pdo_insert('sudu8_page_base', $data);
				} else {
					pdo_update('sudu8_page_base', $data, array('uniacid' => $uniacid));
				}
				message('核销密码 添加/修改 成功!', $this->createWebUrl("sales", array("op" => "hxmm")), "success");
			}
		}
		if ($op == 'jfgz') {
			$_W['page']['title'] = '积分规则';
			$jfgz = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_sign_con') . ' WHERE uniacid = :uniacid', array(':uniacid' => $_W['uniacid']));
			if (checksubmit('submit')) {
				if (!$_GPC['score']) {
					message('随机积分区间不能为空！');
				}
				if (!$_GPC['max_score']) {
					message('最大积分不能为空！');
				}
				$data = array('score' => $_GPC['score'], 'max_score' => $_GPC['max_score']);
				if (empty($uniacid)) {
					pdo_insert('sudu8_page_sign_con', $data);
				} else {
					pdo_update('sudu8_page_sign_con', $data, array('uniacid' => $uniacid));
				}
				message('签到积分 添加/修改 成功!', $this->createWebUrl("sales", array("op" => "jfgz")), "success");
			}
		}
		include $this->template("sales");
	}
	public function doWebStore()
	{
		include ROOT_PATH . "inc/26j26e62en.php";
	}
	public function doWebscoreshop()
	{
		global $_GPC, $_W;
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		$uniacid = $_W['uniacid'];
		if ($op == 'display') {
			$_W['page']['title'] = '产品管理';
			$products = pdo_fetchall('SELECT i.num,i.thumb,i.title,i.id,c.name,i.buy_type FROM ' . tablename('sudu8_page_score_shop') . 'as i left join' . tablename('sudu8_page_score_cate') . ' as c on i.cid = c.id WHERE i.uniacid = ' . $uniacid . ' ORDER BY i.num DESC,i.id DESC');
			$cates = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_score_cate') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));
		}
		if ($op == 'post') {
			$id = $_GPC['id'];
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_score_shop') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$item['labels'] = unserialize($item['labels']);
			$item['text'] = unserialize($item['text']);
			$listV = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_score_cate') . ' WHERE uniacid = :uniacid ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid));
			if (!empty($id)) {
				if (empty($item)) {
					message('抱歉，产品不存在或是已经删除！', '', 'error');
				}
			}
			if (checksubmit('submit')) {
				if (empty($_GPC['title'])) {
					message('标题不能为空，请输入标题！');
				}
				if (empty($_GPC['buy_type'])) {
					message('自定义购买方式不能为空！');
				}
				$cid = intval($_GPC['cid']);
				$pcid = pdo_fetch('SELECT cid FROM ' . tablename('sudu8_page_score_cate') . ' WHERE uniacid = :uniacid and id =:id ', array(':uniacid' => $uniacid, ':id' => $cid));
				$pcid = implode('', $pcid);
				if ($pcid == 0) {
					$pcid = $cid;
				} else {
					$pcid = intval($pcid);
				}
				$data = array('uniacid' => $_W['uniacid'], 'num' => intval($_GPC['num']), 'cid' => intval($_GPC['cid']), 'buy_type' => $_GPC['buy_type'], 'hits' => $_GPC['hits'], 'sale_num' => $_GPC['sale_num'], 'price' => $_GPC['price'], 'market_price' => $_GPC['market_price'], 'pro_kc' => $_GPC['pro_kc'], 'sale_tnum' => $_GPC['sale_tnum'], 'thumb' => $_GPC['thumb'], 'text' => serialize($_GPC['text']), 'labels' => serialize($_GPC['labels']), 'title' => addslashes($_GPC['title']), 'desk' => $_GPC['desc'], 'product_txt' => htmlspecialchars_decode($_GPC['product_txt'], ENT_QUOTES));
				if (!empty($_GPC['thumb'])) {
					$data['thumb'] = parse_path($_GPC['thumb']);
				}
				if (empty($id)) {
					pdo_insert('sudu8_page_score_shop', $data);
				} else {
					pdo_update('sudu8_page_score_shop', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('产品 添加/修改 成功!', $this->createWebUrl("scoreshop", array("op" => "display")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_score_shop') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('产品不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_score_shop', array('id' => $id, 'uniacid' => $uniacid));
			message('删除成功!', $this->createWebUrl("scoreshop", array("op" => "display")), "success");
		}
		include $this->template("scoreshop");
	}
	public function doWebscorecate()
	{
		global $_GPC, $_W;
		$uniacid = $_W['uniacid'];
		$op = $_GPC['op'];
		$ops = array('display', 'post', 'delete');
		$op = in_array($op, $ops) ? $op : 'display';
		if ($op == 'display') {
			$listV = pdo_fetchall('SELECT * FROM ' . tablename('sudu8_page_score_cate') . ' WHERE uniacid = :uniacid ORDER BY num DESC,id DESC', array(':uniacid' => $uniacid));
		}
		if ($op == 'post') {
			$id = intval($_GPC['id']);
			$item = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_score_cate') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			$cate_list = pdo_fetchAll('SELECT * FROM ' . tablename('sudu8_page_score_cate') . ' WHERE uniacid = :uniacid ', array(':uniacid' => $uniacid));
			if (checksubmit('submit')) {
				if (empty($_GPC['name'])) {
					message('请输入栏目标题！');
				}
				$data = array('uniacid' => $_W['uniacid'], 'num' => intval($_GPC['num']), 'name' => $_GPC['name'], 'catepic' => $_GPC['catepic']);
				if (empty($id)) {
					pdo_insert('sudu8_page_score_cate', $data);
				} else {
					pdo_update('sudu8_page_score_cate', $data, array('id' => $id, 'uniacid' => $uniacid));
				}
				message('栏目 添加/修改 成功!', $this->createWebUrl("scorecate", array("op" => "display")), "success");
			}
		}
		if ($op == 'delete') {
			$id = intval($_GPC['id']);
			$row = pdo_fetch('SELECT * FROM ' . tablename('sudu8_page_score_cate') . ' WHERE id = :id and uniacid = :uniacid ', array(':id' => $id, ':uniacid' => $uniacid));
			if (empty($row)) {
				message('栏目不存在或是已经被删除！');
			}
			pdo_delete('sudu8_page_score_cate', array('id' => $id, 'uniacid' => $uniacid));
			message('栏目删除成功!', $this->createWebUrl("scorecate", array("op" => "display")), "success");
		}
		include $this->template("scorecate");
	}
}