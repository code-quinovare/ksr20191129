<?php
/**
 * 外送系统
 * @author 说图谱网
 * @url http://www.shuotupu.com/
 */
defined('IN_IA') || exit('Access Denied');
function tpl_form_field_fans($name, $value, $scene = 'notify', $required = false) 
{
	global $_W;
	if (empty($default)) 
	{
		$default = './resource/images/nopic.jpg';
	}
	$s = '';
	if (!(defined('TPL_INIT_TINY_FANS'))) 
	{
		$option = array('scene' => $scene);
		$option = json_encode($option);
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function showFansDialog(elm) {' . "\r\n\t\t\t\t" . 'var btn = $(elm);' . "\r\n\t\t\t\t" . 'var openid_wxapp = btn.parent().prev();' . "\r\n\t\t\t\t" . 'var openid = btn.parent().prev().prev();' . "\r\n\t\t\t\t" . 'var avatar = btn.parent().prev().prev().prev();' . "\r\n\t\t\t\t" . 'var nickname = btn.parent().prev().prev().prev().prev();' . "\r\n\t\t\t\t" . 'var img = btn.parent().parent().next().find("img");' . "\r\n\t\t\t\t" . 'irequire(["web/tiny"], function(tiny){' . "\r\n\t\t\t\t\t" . 'tiny.selectfan(function(fans){' . "\r\n\t\t\t\t\t\t" . 'console.log(fans);' . "\r\n\t\t\t\t\t\t" . 'if(img.length > 0){' . "\r\n\t\t\t\t\t\t\t" . 'img.get(0).src = fans.avatar;' . "\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t\t" . 'openid_wxapp.val(fans.openid_wxapp);' . "\r\n\t\t\t\t\t\t" . 'openid.val(fans.openid);' . "\r\n\t\t\t\t\t\t" . 'avatar.val(fans.avatar);' . "\r\n\t\t\t\t\t\t" . 'nickname.val(fans.nickname);' . "\r\n\t\t\t\t\t" . '}, ' . $option . ');' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_FANS', true);
	}
	$s .= "\r\n\t\t" . '<div class="input-group">' . "\r\n\t\t\t" . '<input type="text" name="' . $name . '[nickname]" value="' . $value['nickname'] . '" class="form-control" readonly ' . (($required ? 'required' : '')) . '>' . "\r\n\t\t\t" . '<input type="hidden" name="' . $name . '[avatar]" value="' . $value['avatar'] . '">' . "\r\n\t\t\t" . '<input type="hidden" name="' . $name . '[openid]" value="' . $value['openid'] . '">' . "\r\n\t\t\t" . '<input type="hidden" name="' . $name . '[openid_wxapp]" value="' . $value['openid_wxapp'] . '">' . "\r\n\t\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t\t" . '<button class="btn btn-default" type="button" onclick="showFansDialog(this);">选择粉丝</button>' . "\r\n\t\t\t" . '</span>' . "\r\n\t\t" . '</div>' . "\r\n\t\t" . '<div class="input-group" style="margin-top:.5em;">' . "\r\n\t\t\t" . '<img src="' . $value['avatar'] . '" onerror="this.src=\'' . $default . '\'; this.title=\'头像未找到.\'" class="img-responsive img-thumbnail" width="150" />' . "\r\n\t\t" . '</div>';
	return $s;
}
function itpl_form_field_daterange($name, $value = array(), $time = false) 
{
	global $_GPC;
	$placeholder = ((isset($value['placeholder']) ? $value['placeholder'] : ''));
	$s = '';
	if (empty($time) && !(defined('TPL_INIT_TINY_DATERANGE_DATE'))) 
	{
		$s = "\r\n" . '<script type="text/javascript">' . "\r\n\t" . 'require(["daterangepicker"], function() {' . "\r\n\t\t" . '$(".daterange.daterange-date").each(function(){' . "\r\n\t\t\t" . 'var elm = this;' . "\r\n\t\t\t" . 'var container =$(elm).parent().prev();' . "\r\n\t\t\t" . '$(this).daterangepicker({' . "\r\n\t\t\t\t" . 'format: "YYYY-MM-DD"' . "\r\n\t\t\t" . '}, function(start, end){' . "\r\n\t\t\t\t" . '$(elm).find(".date-title").html(start.toDateStr() + " 至 " + end.toDateStr());' . "\r\n\t\t\t\t" . 'container.find(":input:first").val(start.toDateTimeStr());' . "\r\n\t\t\t\t" . 'container.find(":input:last").val(end.toDateTimeStr());' . "\r\n\t\t\t" . '});' . "\r\n\t\t" . '});' . "\r\n\t" . '});' . "\r\n\r\n\t" . 'function clearTime(obj){' . "\r\n\t\t" . '$(obj).prev().html("<span class=date-title>" + $(obj).attr("placeholder") + "</span>");' . "\r\n\t\t" . '$(obj).parent().prev().find("input").val("");' . "\r\n\t" . ' }' . "\r\n" . '</script>';
		define('TPL_INIT_TINY_DATERANGE_DATE', true);
	}
	if (!(empty($time)) && !(defined('TPL_INIT_TINY_DATERANGE_TIME'))) 
	{
		$s = "\r\n" . '<script type="text/javascript">' . "\r\n\t" . 'require(["daterangepicker"], function($){' . "\r\n\t\t" . '$(function(){' . "\r\n\t\t\t" . '$(".daterange.daterange-time").each(function() {' . "\r\n\t\t\t\t" . 'var elm = this;' . "\r\n\t\t\t\t" . 'var container =$(elm).parent().prev();' . "\r\n\t\t\t\t" . '$(this).daterangepicker({' . "\r\n\t\t\t\t\t" . 'format: "YYYY-MM-DD HH:mm",' . "\r\n\t\t\t\t\t" . 'timePicker: true,' . "\r\n\t\t\t\t\t" . 'timePicker12Hour : false,' . "\r\n\t\t\t\t\t" . 'timePickerIncrement: 1,' . "\r\n\t\t\t\t\t" . 'minuteStep: 1' . "\r\n\t\t\t\t" . '}, function(start, end){' . "\r\n\t\t\t\t\t" . '$(elm).find(".date-title").html(start.toDateTimeStr() + " 至 " + end.toDateTimeStr());' . "\r\n\t\t\t\t\t" . 'container.find(":input:first").val(start.toDateTimeStr());' . "\r\n\t\t\t\t\t" . 'container.find(":input:last").val(end.toDateTimeStr());' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '});' . "\r\n\t\t" . '});' . "\r\n\t" . '});' . "\r\n\r\n\t" . 'function clearTime(obj){' . "\r\n\t\t" . '$(obj).prev().html("<span class=date-title>" + $(obj).attr("placeholder") + "</span>");' . "\r\n\t\t" . '$(obj).parent().prev().find("input").val("");' . "\r\n\t" . ' }' . "\r\n" . '</script>';
		define('TPL_INIT_TINY_DATERANGE_TIME', true);
	}
	$str = $placeholder;
	$value['starttime'] = ((isset($value['starttime']) ? $value['starttime'] : (($_GPC[$name]['start'] ? $_GPC[$name]['start'] : ''))));
	$value['endtime'] = ((isset($value['endtime']) ? $value['endtime'] : (($_GPC[$name]['end'] ? $_GPC[$name]['end'] : ''))));
	if ($value['starttime'] && $value['endtime']) 
	{
		if (empty($time)) 
		{
			$str = date('Y-m-d', strtotime($value['starttime'])) . '至 ' . date('Y-m-d', strtotime($value['endtime']));
		}
		else 
		{
			$str = date('Y-m-d H:i', strtotime($value['starttime'])) . ' 至 ' . date('Y-m-d  H:i', strtotime($value['endtime']));
		}
	}
	$s .= "\r\n\t\t" . '<div style="float:left">' . "\r\n\t\t\t" . '<input name="' . $name . '[start]' . '" type="hidden" value="' . $value['starttime'] . '" />' . "\r\n\t\t\t" . '<input name="' . $name . '[end]' . '" type="hidden" value="' . $value['endtime'] . '" />' . "\r\n\t\t" . '</div>' . "\r\n\t\t" . '<div class="btn-group" style="padding-right:0;">' . "\r\n\t\t\t" . '<button style="width:240px" class="btn btn-default daterange ' . ((!(empty($time)) ? 'daterange-time' : 'daterange-date')) . '"  type="button"><span class="date-title">' . $str . '</span></button>' . "\r\n\t\t\t" . '<button class="btn btn-default" type="button" onclick="clearTime(this)" placeholder="' . $placeholder . '"><i class="fa fa-remove"></i></button>' . "\r\n\t\t" . '</div>';
	return $s;
}
function tpl_form_field_tiny_link($name, $value = '', $options = array()) 
{
	global $_GPC;
	$s = '';
	if (!(defined('TPL_INIT_TINY_LINK'))) 
	{
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function showTinyLinkDialog(elm) {' . "\r\n\t\t\t\t" . 'irequire(["web/tiny"], function(tiny){' . "\r\n\t\t\t\t\t" . 'var ipt = $(elm).parent().prev();' . "\r\n\t\t\t\t\t" . 'tiny.selectLink(function(href){' . "\r\n\t\t\t\t\t\t" . 'ipt.val(href);' . "\r\n\t\t\t\t\t" . '});' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_LINK', true);
	}
	$s .= "\r\n\t" . '<div class="input-group">' . "\r\n\t\t" . '<input type="text" value="' . $value . '" name="' . $name . '" class="form-control ' . $options['css']['input'] . '" autocomplete="off">' . "\r\n\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t" . '<button class="btn btn-default ' . $options['css']['btn'] . '" type="button" onclick="showTinyLinkDialog(this);">选择链接</button>' . "\r\n\t\t" . '</span>' . "\r\n\t" . '</div>' . "\r\n\t";
	return $s;
}
function tpl_form_field_tiny_wxapp_link($name, $value = '', $options = array()) 
{
	global $_GPC;
	$s = '';
	if (!(defined('TPL_INIT_TINY_WXAPP_LINK'))) 
	{
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function showTinyWxappLinkDialog(elm) {' . "\r\n\t\t\t\t" . 'irequire(["web/tiny"], function(tiny){' . "\r\n\t\t\t\t\t" . 'var ipt = $(elm).parent().prev();' . "\r\n\t\t\t\t\t" . 'tiny.selectWxappLink(function(href){' . "\r\n\t\t\t\t\t\t" . 'ipt.val(href);' . "\r\n\t\t\t\t\t" . '});' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_WXAPP_LINK', true);
	}
	$s .= "\r\n\t" . '<div class="input-group">' . "\r\n\t\t" . '<input type="text" value="' . $value . '" name="' . $name . '" class="form-control ' . $options['css']['input'] . '" autocomplete="off">' . "\r\n\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t" . '<button class="btn btn-default ' . $options['css']['btn'] . '" type="button" onclick="showTinyWxappLinkDialog(this);">选择链接</button>' . "\r\n\t\t" . '</span>' . "\r\n\t" . '</div>' . "\r\n\t";
	return $s;
}
function tpl_form_field_tiny_coordinate($field, $value = array(), $required = false) 
{
	global $_W;
	$s = '';
	if (!(defined('TPL_INIT_TINY_COORDINATE'))) 
	{
		$s .= '<script type="text/javascript">' . "\r\n\t\t\t\t" . 'function showCoordinate(elm) {' . "\r\n\t\t\t\t\t" . 'irequire(["web/tiny"], function(tiny){' . "\r\n\t\t\t\t\t\t" . 'var val = {};' . "\r\n\t\t\t\t\t\t" . 'val.lng = parseFloat($(elm).parent().prev().prev().find(":text").val());' . "\r\n\t\t\t\t\t\t" . 'val.lat = parseFloat($(elm).parent().prev().find(":text").val());' . "\r\n\t\t\t\t\t\t" . 'tiny.map(val, function(r){' . "\r\n\t\t\t\t\t\t\t" . '$(elm).parent().prev().prev().find(":text").val(r.lng);' . "\r\n\t\t\t\t\t\t\t" . '$(elm).parent().prev().find(":text").val(r.lat);' . "\r\n\t\t\t\t\t\t" . '});' . "\r\n\t\t\t\t\t" . '});' . "\r\n\t\t\t\t" . '}' . "\r\n\t\t\t" . '</script>';
		define('TPL_INIT_TINY_COORDINATE', true);
	}
	$s .= "\r\n\t\t" . '<div class="row row-fix">' . "\r\n\t\t\t" . '<div class="col-xs-4 col-sm-4">' . "\r\n\t\t\t\t" . '<input type="text" name="' . $field . '[lng]" value="' . $value['lng'] . '" placeholder="地理经度"  class="form-control" ' . (($required ? 'required' : '')) . '/>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t\t" . '<div class="col-xs-4 col-sm-4">' . "\r\n\t\t\t\t" . '<input type="text" name="' . $field . '[lat]" value="' . $value['lat'] . '" placeholder="地理纬度"  class="form-control" ' . (($required ? 'required' : '')) . '/>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t\t" . '<div class="col-xs-4 col-sm-4">' . "\r\n\t\t\t\t" . '<button onclick="showCoordinate(this);" class="btn btn-default" type="button">选择坐标</button>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t" . '</div>';
	return $s;
}
function cloud_w_upgrade_version($family, $version, $release) 
{
	$verfile = MODULE_ROOT . '/version.php';
	$verdat = '<?php' . "\r\n" . '/**' . "\r\n" . ' * 外送系统' . "\r\n" . ' * @author 说图谱网' . "\r\n" . ' * @QQ 63779278' . "\r\n" . ' * @url http://www.shuotupu.com/' . "\r\n" . ' */' . "\r\n" . 'defined(\'IN_IA\') or exit(\'Access Denied\');' . "\r\n" . 'define(\'MODULE_FAMILY\', \'' . $family . '\');' . "\r\n" . 'define(\'MODULE_VERSION\', \'' . $version . '\');' . "\r\n" . 'define(\'MODULE_RELEASE_DATE\', \'' . $release . '\');';
	file_put_contents($verfile, trim($verdat));
}
function tpl_select2($name, $data, $value = 0, $filter = array('id', 'title'), $default = '请选择') 
{
	$element_id = 'select2-' . $name;
	$json_data = array();
	foreach ($data as $da ) 
	{
		$json_data[] = array('id' => $da[$filter[0]], 'text' => $da[$filter[1]]);
	}
	$json_data = json_encode($json_data);
	$html = '<select name="' . $name . '" class="form-control" id="' . $element_id . '"></select>';
	$html .= '<script type="text/javascript">' . "\r\n\t\t\t\t\t" . 'require(["jquery", "select2"], function($) {' . "\r\n\t\t\t\t\t\t" . '$("#' . $element_id . '").select2({' . "\r\n\t\t\t\t\t\t\t" . 'placeholder: "' . $default . '",' . "\r\n\t\t\t\t\t\t\t" . 'data: ' . $json_data . ',' . "\r\n\t\t\t\t\t\t\t" . 'val: ' . $value . "\r\n\t\t\t\t\t\t" . '});' . "\r\n\t\t\t\t\t" . '});' . "\r\n\t\t\t" . '  </script>';
	return $html;
}
function tpl_form_field_tiny_image($name, $value = '') 
{
	global $_W;
	$default = '';
	$val = $default;
	if (!(empty($value))) 
	{
		$val = tomedia($value);
	}
	if (!(empty($options['global']))) 
	{
		$options['global'] = true;
	}
	else 
	{
		$options['global'] = false;
	}
	if (empty($options['class_extra'])) 
	{
		$options['class_extra'] = '';
	}
	if (isset($options['dest_dir']) && !(empty($options['dest_dir']))) 
	{
		if (!(preg_match('/^\\w+([\\/]\\w+)?$/i', $options['dest_dir']))) 
		{
			exit('图片上传目录错误,只能指定最多两级目录,如: "we7_store","we7_store/d1"');
		}
	}
	$options['direct'] = true;
	$options['multiple'] = false;
	if (isset($options['thumb'])) 
	{
		$options['thumb'] = !(empty($options['thumb']));
	}
	$s = '';
	if (!(defined('TPL_INIT_TINY_IMAGE'))) 
	{
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function showImageDialog(elm, opts, options) {' . "\r\n\t\t\t\t" . 'require(["util"], function(util){' . "\r\n\t\t\t\t\t" . 'var btn = $(elm);' . "\r\n\t\t\t\t\t" . 'var ipt = btn.parent().prev();' . "\r\n\t\t\t\t\t" . 'var val = ipt.val();' . "\r\n\t\t\t\t\t" . 'var img = ipt.parent().parent().find(".input-group-addon img");' . "\r\n\t\t\t\t\t" . 'options = ' . str_replace('"', '\'', json_encode($options)) . ';' . "\r\n\t\t\t\t\t" . 'util.image(val, function(url){' . "\r\n\t\t\t\t\t\t" . 'if(url.url){' . "\r\n\t\t\t\t\t\t\t" . 'if(img.length > 0){' . "\r\n\t\t\t\t\t\t\t\t" . 'img.get(0).src = url.url;' . "\r\n\t\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t\t\t" . 'ipt.val(url.attachment);' . "\r\n\t\t\t\t\t\t\t" . 'ipt.attr("filename",url.filename);' . "\r\n\t\t\t\t\t\t\t" . 'ipt.attr("url",url.url);' . "\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t\t" . 'if(url.media_id){' . "\r\n\t\t\t\t\t\t\t" . 'if(img.length > 0){' . "\r\n\t\t\t\t\t\t\t\t" . 'img.get(0).src = "";' . "\r\n\t\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t\t\t" . 'ipt.val(url.media_id);' . "\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t" . '}, null, options);' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t\t" . 'function deleteImage(elm){' . "\r\n\t\t\t\t" . 'require(["jquery"], function($){' . "\r\n\t\t\t\t\t" . '$(elm).prev().attr("src", "./resource/images/nopic.jpg");' . "\r\n\t\t\t\t\t" . '$(elm).parent().prev().find("input").val("");' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_IMAGE', true);
	}
	$s .= "\r\n\t\t" . '<div class="input-group ' . $options['class_extra'] . '">' . "\r\n\t\t\t" . '<div class="input-group-addon">' . "\r\n\t\t\t\t" . '<img src="' . $val . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" width="20" height="20" />' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t\t" . '<input type="text" name="' . $name . '" value="' . $value . '" class="form-control" autocomplete="off">' . "\r\n\t\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t\t" . '<button class="btn btn-default" type="button" onclick="showImageDialog(this);">选择图片</button>' . "\r\n\t\t\t" . '</span>' . "\r\n\t\t" . '</div>';
	return $s;
}
function tpl_form_field_store($name, $value = '', $option = array('mutil' => 0)) 
{
	global $_W;
	if (empty($default)) 
	{
		$default = './resource/images/nopic.jpg';
	}
	if (!(is_array($value))) 
	{
		$value = intval($value);
		$value = array($value);
	}
	$value_ids = implode(',', $value);
	$stores_temp = pdo_fetchall('select id, title, logo from ' . tablename('tiny_wmall_store') . ' where uniacid = :uniacid and id in (' . $value_ids . ')', array(':uniacid' => $_W['uniacid']));
	$stores = array();
	if (!(empty($stores_temp))) 
	{
		foreach ($stores_temp as $row ) 
		{
			$row['logo'] = tomedia($row['logo']);
			$stores[] = $row;
		}
	}
	$definevar = 'TPL_INIT_TINY_STORE';
	$function = 'showStoreDialog';
	if (!(empty($option['mutil']))) 
	{
		$definevar = 'TPL_INIT_TINY_MUTIL_STORE';
		$function = 'showMutilStoreDialog';
	}
	$s = '';
	if (!(defined($definevar))) 
	{
		$option_json = json_encode($option);
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function ' . $function . '(elm) {' . "\r\n\t\t\t\t" . 'var btn = $(elm);' . "\r\n\t\t\t\t" . 'var value_cn = btn.parent().prev();' . "\r\n\t\t\t\t" . 'var logo = btn.parent().parent().next().find("img");' . "\r\n\t\t\t\t" . 'irequire(["web/tiny"], function(tiny){' . "\r\n\t\t\t\t\t" . 'tiny.selectstore(function(stores, option){' . "\r\n\t\t\t\t\t\t" . 'if(option.mutil == 1) {' . "\r\n\t\t\t\t\t\t\t" . '$.each(stores, function(idx, store){' . "\r\n\t\t\t\t\t\t\t\t" . '$(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+store.logo+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+store.id+\'"><em class="close" title="删除该门店" onclick="deleteStore(this)">×</em><span>\'+store.title+\'</span></div>\');' . "\r\n\t\t\t\t\t\t\t" . '});' . "\r\n\t\t\t\t\t\t" . '} else {' . "\r\n\t\t\t\t\t\t\t" . 'value_cn.val(stores.title);' . "\r\n\t\t\t\t\t\t\t" . 'logo[0].src = stores.logo;' . "\r\n\t\t\t\t\t\t\t" . 'logo.prev().val(stores.id);' . "\r\n\t\t\t\t\t\t\t" . 'logo.next().removeClass("hide").html(stores.title);' . "\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t" . '}, ' . $option_json . ');' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\r\n\t\t\t" . 'function deleteMutilStore(elm){' . "\r\n\t\t\t\t" . '$(elm).parent().remove();' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define($definevar, true);
	}
	$s .= "\r\n\t\t" . '<div class="input-group">' . "\r\n\t\t\t" . '<input type="text" class="form-control store-cn" readonly value="' . $stores[0]['title'] . '">' . "\r\n\t\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t\t" . '<button class="btn btn-default" type="button" onclick="' . $function . '(this);">选择商家</button>' . "\r\n\t\t\t" . '</span>' . "\r\n\t\t" . '</div>';
	if (empty($option['mutil'])) 
	{
		$s .= "\r\n\t\t" . '<div class="input-group single-item" style="margin-top:.5em;">' . "\r\n\t\t\t" . '<input type="hidden" name="' . $name . '" value="' . $value[0] . '">' . "\r\n\t\t\t" . '<img src="' . $stores[0]['logo'] . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" width="150" />' . "\r\n\t\t";
		if (empty($stores[0]['title'])) 
		{
			$s .= '<span class="hide"></span>';
		}
		else 
		{
			$s .= '<span>' . $stores[0]['title'] . '</span>';
		}
		$s .= '</div>';
	}
	else 
	{
		$s .= '<div class="input-group multi-img-details">';
		foreach ($stores as $store ) 
		{
			$s .= "\r\n\t\t\t" . '<div class="multi-item">' . "\r\n\t\t\t\t" . '<img src="' . $store['logo'] . '" title="' . $store['title'] . '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">' . "\r\n\t\t\t\t" . '<input type="hidden" name="' . $name . '[]" value="' . $store['id'] . '">' . "\r\n\t\t\t\t" . '<em class="close" title="删除该门店" onclick="deleteMutilStore()">×</em>' . "\r\n\t\t\t\t" . '<span>' . $store['title'] . '</span>' . "\r\n\t\t\t" . '</div>';
		}
		$s .= '</div>';
	}
	return $s;
}
function tpl_form_field_mutil_store($name, $value = '') 
{
	return tpl_form_field_store($name, $value, $option = array('mutil' => 1));
}
function tpl_form_field_goods($name, $value = '', $option = array( 'mutil' => 0, 'sid' => 0, 'ignore' => array() )) 
{
	global $_W;
	if (!(isset($option['mutil']))) 
	{
		$option['mutil'] = 0;
	}
	if (empty($default)) 
	{
		$default = './resource/images/nopic.jpg';
	}
	if (!(is_array($value))) 
	{
		$value = intval($value);
		$value = array($value);
	}
	$condition = ' where uniacid = :uniacid';
	$params = array(':uniacid' => $_W['uniacid']);
	$value_ids = implode(',', $value);
	$condition .= ' and id in (' . $value_ids . ')';
	$goods_temp = pdo_fetchall('select id, title, thumb from ' . tablename('tiny_wmall_goods') . $condition, $params);
	$goods = array();
	if (!(empty($goods_temp))) 
	{
		foreach ($goods_temp as $row ) 
		{
			$row['thumb'] = tomedia($row['thumb']);
			$goods[] = $row;
		}
	}
	$definevar = 'TPL_INIT_TINY_GOODS';
	$function = 'showGoodsDialog';
	if (!(empty($option['mutil']))) 
	{
		$definevar = 'TPL_INIT_TINY_MUTIL_GOODS';
		$function = 'showMutilGoodsDialog';
	}
	$s = '';
	if (!(defined($definevar))) 
	{
		$option_json = json_encode($option);
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function ' . $function . '(elm) {' . "\r\n\t\t\t\t" . 'var btn = $(elm);' . "\r\n\t\t\t\t" . 'var value_cn = btn.parent().prev();' . "\r\n\t\t\t\t" . 'var thumb = btn.parent().parent().next().find("img");' . "\r\n\t\t\t\t" . 'tiny.selectgoods(function(goods, option){' . "\r\n\t\t\t\t\t" . 'if(option.mutil == 1) {' . "\r\n\t\t\t\t\t\t" . '$.each(goods, function(idx, good){' . "\r\n\t\t\t\t\t\t\t" . '$(elm).parent().parent().next().append(\'<div class="multi-item"><img onerror="this.src=\\\'./resource/images/nopic.jpg\\\'; this.title=\\\'图片未找到.\\\'" src="\'+store.good+\'" class="img-responsive img-thumbnail"><input type="hidden" name="\'+name+\'[]" value="\'+good.id+\'"><em class="close" title="删除该商品" onclick="deleteStore(this)">×</em><span>\'+good.title+\'</span></div>\');' . "\r\n\t\t\t\t\t\t" . '});' . "\r\n\t\t\t\t\t" . '} else {' . "\r\n\t\t\t\t\t\t" . 'value_cn.val(goods.title);' . "\r\n\t\t\t\t\t\t" . 'thumb[0].src = goods.thumb;' . "\r\n\t\t\t\t\t\t" . 'thumb.prev().val(goods.id);' . "\r\n\t\t\t\t\t\t" . 'thumb.next().removeClass("hide").html(goods.title);' . "\r\n\t\t\t\t\t" . '}' . "\r\n\t\t\t\t" . '}, ' . $option_json . ');' . "\r\n\t\t\t" . '}' . "\r\n\r\n\t\t\t" . 'function deleteMutilGoods(elm){' . "\r\n\t\t\t\t" . '$(elm).parent().remove();' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define($definevar, true);
	}
	$s .= "\r\n\t\t" . '<div class="input-group">' . "\r\n\t\t\t" . '<input type="text" class="form-control store-cn" readonly value="' . $goods[0]['title'] . '">' . "\r\n\t\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t\t" . '<button class="btn btn-default" type="button" onclick="' . $function . '(this);">选择商品</button>' . "\r\n\t\t\t" . '</span>' . "\r\n\t\t" . '</div>';
	if (empty($option['mutil'])) 
	{
		$s .= "\r\n\t\t" . '<div class="input-group single-item" style="margin-top:.5em;">' . "\r\n\t\t\t" . '<input type="hidden" name="' . $name . '" value="' . $value[0] . '">' . "\r\n\t\t\t" . '<img src="' . $goods[0]['thumb'] . '" onerror="this.src=\'' . $default . '\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail" width="150" />' . "\r\n\t\t";
		if (empty($goods[0]['title'])) 
		{
			$s .= '<span class="hide"></span>';
		}
		else 
		{
			$s .= '<span>' . $goods[0]['title'] . '</span>';
		}
		$s .= '</div>';
	}
	else 
	{
		$s .= '<div class="input-group multi-img-details">';
		foreach ($goods as $good ) 
		{
			$s .= "\r\n\t\t\t" . '<div class="multi-item">' . "\r\n\t\t\t\t" . '<img src="' . $good['thumb'] . '" title="' . $good['title'] . '" onerror="this.src=\'./resource/images/nopic.jpg\'; this.title=\'图片未找到.\'" class="img-responsive img-thumbnail">' . "\r\n\t\t\t\t" . '<input type="hidden" name="' . $name . '[]" value="' . $good['id'] . '">' . "\r\n\t\t\t\t" . '<em class="close" title="删除该商品" onclick="deleteMutilStore()">×</em>' . "\r\n\t\t\t\t" . '<span>' . $good['title'] . '</span>' . "\r\n\t\t\t" . '</div>';
		}
		$s .= '</div>';
	}
	return $s;
}
function tpl_form_field_mutil_goods($name, $value = '', $option = array( 'sid' => 0, 'ignore' => array() )) 
{
	if (!(isset($option['mutil']))) 
	{
		$option['mutil'] = 1;
	}
	return tpl_form_field_goods($name, $value, $option);
}
function tpl_form_filter_hidden($ctrls, $do = 'web') 
{
	global $_W;
	$html = "\r\n\t\t" . '<input type="hidden" name="c" value="site">' . "\r\n\t\t" . '<input type="hidden" name="a" value="entry">' . "\r\n\t\t" . '<input type="hidden" name="m" value="we7_wmall">' . "\r\n\t\t" . '<input type="hidden" name="i" value="' . $_W['uniacid'] . '">' . "\r\n\t\t" . '<input type="hidden" name="do" value="' . $do . '"/>' . "\r\n\t";
	list($ctrl, $ac, $op, $ta) = explode('/', $ctrls);
	if (!(empty($ctrl))) 
	{
		$html .= '<input type="hidden" name="ctrl" value="' . $ctrl . '"/>';
		if (!(empty($ac))) 
		{
			$html .= '<input type="hidden" name="ac" value="' . $ac . '"/>';
			if (!(empty($ac))) 
			{
				$html .= '<input type="hidden" name="op" value="' . $op . '"/>';
				if (!(empty($ta))) 
				{
					$html .= '<input type="hidden" name="ta" value="' . $ta . '"/>';
				}
			}
		}
	}
	return $html;
}
function tpl_form_field_tiny_account($name, $value = 0, $required = false) 
{
	$account = array();
	if (!(empty($value))) 
	{
		$account = pdo_get('account_wechats', array('uniacid' => $value));
	}
	$s = '';
	if (!(defined('TPL_INIT_TINY_ACCOUNT'))) 
	{
		$s = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'function showTinyAccountDialog(elm) {' . "\r\n\t\t\t\t" . 'irequire(["web/tiny"], function(tiny){' . "\r\n\t\t\t\t\t" . 'var $uniacid = $(elm).parent().prev();' . "\r\n\t\t\t\t\t" . 'var $name = $(elm).parent().prev().prev();' . "\r\n\t\t\t\t\t" . 'tiny.selectaccount(function(account){' . "\r\n\t\t\t\t\t\t" . '$uniacid.val(account.uniacid);' . "\r\n\t\t\t\t\t\t" . '$name.val(account.name);' . "\r\n\t\t\t\t\t" . '});' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_ACCOUNT', true);
	}
	$s .= "\r\n\t" . '<div class="input-group">' . "\r\n\t\t" . '<input type="text" name="' . $name . '_cn" value="' . $account['name'] . '" class="form-control" autocomplete="off" readonly>' . "\r\n\t\t" . '<input type="hidden" name="' . $name . '" value="' . $value . '">' . "\r\n\t\t" . '<span class="input-group-btn">' . "\r\n\t\t\t" . '<button class="btn btn-default" type="button" onclick="showTinyAccountDialog(this);">选择公众号</button>' . "\r\n\t\t" . '</span>' . "\r\n\t" . '</div>' . "\r\n\t";
	return $s;
}
function tpl_form_field_tiny_category_2level($name, $parents, $children, $parentid, $childid) 
{
	$html = "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . 'window._' . $name . ' = ' . json_encode($children) . ';' . "\r\n\t\t" . '</script>';
	if (!(defined('TPL_INIT_TINY_CATEGORY'))) 
	{
		$html .= "\r\n\t\t\t\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t\t\t\t" . 'function irenderCategory(obj, name){' . "\r\n\t\t\t\t\t\t\t" . 'var index = obj.options[obj.selectedIndex].value;' . "\r\n\t\t\t\t\t\t\t" . 'require([\'jquery\', \'util\'], function($, u){' . "\r\n\t\t\t\t\t\t\t\t" . '$selectChild = $(\'#\'+name+\'_child\');' . "\r\n\t\t\t\t\t\t\t\t" . 'var html = \'<option value="0">请选择二级分类</option>\';' . "\r\n\t\t\t\t\t\t\t\t" . 'console.log(index);' . "\r\n\t\t\t\t\t\t\t\t" . 'console.log(_category);' . "\r\n\r\n\t\t\t\t\t\t\t\t" . 'if (!window[\'_\'+name] || !window[\'_\'+name][index]) {' . "\r\n\t\t\t\t\t\t\t\t\t" . '$selectChild.html(html);' . "\r\n\t\t\t\t\t\t\t\t\t" . 'return false;' . "\r\n\t\t\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t\t\t\t" . 'for(var i in window[\'_\'+name][index]){' . "\r\n\t\t\t\t\t\t\t\t\t" . 'html += \'<option value="\'+window[\'_\'+name][index][i][\'id\']+\'">\'+window[\'_\'+name][index][i][\'name\']+\'</option>\';' . "\r\n\t\t\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t\t\t\t" . '$selectChild.html(html);' . "\r\n\t\t\t\t\t\t\t" . '});' . "\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t" . '</script>' . "\r\n\t\t\t\t\t";
		define('TPL_INIT_TINY_CATEGORY', true);
	}
	$html .= '<div class="row row-fix tpl-category-container">' . "\r\n\t" . '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">' . "\r\n\t\t" . '<select class="form-control tpl-category-parent" id="' . $name . '_parent" name="' . $name . '[parentid]" onchange="irenderCategory(this,\'' . $name . '\')">' . "\r\n\t\t\t\t\t" . '<option value="0">请选择一级分类</option>';
	$ops = '';
	foreach ($parents as $row ) 
	{
		$html .= "\r\n\t\t\t\t\t" . '<option value="' . $row['id'] . '" ' . (($row['id'] == $parentid ? 'selected="selected"' : '')) . '>' . $row['name'] . '</option>';
	}
	$html .= "\r\n\t\t\t\t" . '</select>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t\t" . '<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">' . "\r\n\t\t\t\t" . '<select class="form-control tpl-category-child" id="' . $name . '_child" name="' . $name . '[childid]">' . "\r\n\t\t\t\t\t" . '<option value="0">请选择二级分类</option>';
	if (!(empty($parentid)) && !(empty($children[$parentid]))) 
	{
		foreach ($children[$parentid] as $row ) 
		{
			$html .= "\r\n\t\t\t\t\t" . '<option value="' . $row['id'] . '"' . (($row['id'] == $childid ? 'selected="selected"' : '')) . '>' . $row['name'] . '</option>';
		}
	}
	$html .= "\r\n\t\t\t\t" . '</select>' . "\r\n\t\t\t" . '</div>' . "\r\n\t\t" . '</div>' . "\r\n\t";
	return $html;
}
function wxapp_urls($type = '') 
{
	global $_W;
	global $_GPC;
	$data['takeout']['sys'] = array( 'title' => '外卖链接', 'items' => array( array('title' => '平台首页', 'url' => 'pages/home/index'), array('title' => '搜索商家', 'url' => 'pages/home/search'), array('title' => '会员中心', 'url' => 'pages/member/mine'), array('title' => '我的订单', 'url' => 'pages/order/index'), array('title' => '我的代金券', 'url' => 'pages/member/coupon/index'), array('title' => '我的红包', 'url' => 'pages/member/redPacket/index'), array('title' => '我的收货地址', 'url' => 'pages/member/address'), array('title' => '我的收藏', 'url' => 'pages/member/favorite'), array('title' => '配送会员卡', 'url' => 'pages/deliveryCard/index'), array('title' => '领券中心', 'url' => 'pages/channel/coupon'), array('title' => '余额充值', 'url' => 'pages/member/recharge'), array('title' => '天天特价', 'url' => 'pages/bargain/index'), array('title' => '购物车', 'url' => 'pages/order/cart'), array('title' => '为您优选', 'url' => 'pages/channel/brand'), array('title' => '帮助中心', 'url' => 'pages/home/help'), array('title' => '客服中心', 'url' => 'pages/home/help') ) );
	$data['other'] = array();
	if (check_plugin_perm('spread')) 
	{
		$data['other']['spread'] = array( 'title' => '啦啦推广', 'items' => array( array('title' => '推广中心', 'url' => 'pages/spread/index') ) );
	}
	if (check_plugin_perm('ordergrant')) 
	{
		$data['other']['ordergrant'] = array( 'title' => '下单有礼', 'items' => array( array('title' => '下单有礼', 'url' => 'pages/ordergrant/index') ) );
	}
	if (check_plugin_perm('creditshop')) 
	{
		$data['other']['creditshop'] = array( 'title' => '积分商城', 'items' => array( array('title' => '积分商城', 'url' => 'pages/creditshop/index') ) );
	}
	if (check_plugin_perm('superRedpacket')) 
	{
		$data['other']['superredpacket_meal'] = array( 'title' => '套餐红包', 'items' => array( array('title' => '套餐红包', 'url' => 'pages/superredpacket/mealindex') ) );
	}
	if (check_plugin_perm('freeLunch')) 
	{
		$data['other']['freelunch'] = array( 'title' => '霸王餐', 'items' => array( array('title' => '霸王餐', 'url' => 'pages/freelunch/index') ) );
	}
	if (check_plugin_perm('errander')) 
	{
		$data['errander'] = array( array( 'title' => '平台链接', 'items' => array( array('title' => '跑腿首页（旧版，以后不维护）', 'url' => 'pages/errander/index'), array('title' => '跑腿首页（新版）', 'url' => 'pages/paotui/guide'), array('title' => '跑腿订单', 'url' => 'pages/errander/order') ) ) );
		$data['errander']['business'] = array( 'title' => '业务链接（2018.6.20以后下架，请使用跑腿场景）', 'items' => array() );
		$categorys = pdo_getall('tiny_wmall_errander_category', array('uniacid' => $_W['uniacid'], 'status' => 1), array('id', 'title'));
		if (!(empty($categorys))) 
		{
			foreach ($categorys as $category ) 
			{
				$data['errander']['business']['items'][] = array('title' => $category['title'] . '（后期不在维护）', 'url' => 'pages/errander/category?id=' . $category['id']);
			}
		}
		$data['errander']['scene'] = array( 'title' => '跑腿场景（新版）', 'items' => array() );
		$scenes = pdo_getall('tiny_wmall_errander_page', array('uniacid' => $_W['uniacid'], 'type' => 'scene'), array('id', 'name'));
		if (!(empty($scenes))) 
		{
			foreach ($scenes as $scene ) 
			{
				$data['errander']['scene']['items'][] = array('title' => $scene['name'], 'url' => 'pages/paotui/diy?id=' . $scene['id']);
			}
		}
	}
	if (check_plugin_perm('diypage')) 
	{
		if (!($type)) 
		{
			$diypages = pdo_getall('tiny_wmall_wxapp_page', array('uniacid' => $_W['uniacid']), array('id', 'name'));
		}
		else 
		{
			$diypages = pdo_getall('tiny_wmall_diypage', array('uniacid' => $_W['uniacid'], 'version' => 2), array('id', 'name'));
		}
		if (!(empty($diypages))) 
		{
			$data['diyPages'] = $diypages;
		}
	}
	$data['operation']['scanCode'] = array( 'title' => '扫码', 'items' => array( array('title' => '扫码', 'url' => 'wx:scanCode') ) );
	$data['store'] = array( array( 'title' => '商户', 'items' => array( array('title' => '门店详情', 'url' => 'pages/store/home?sid=' . $_GPC['__sid']), array('title' => '点外卖', 'url' => 'pages/store/goods?sid=' . $_GPC['__sid']), array('title' => '预定', 'url' => 'pages/reserve/index?sid=' . $_GPC['__sid']), array('title' => '当面付', 'url' => 'pages/store/paybill?sid=' . $_GPC['__sid']) ) ) );
	return $data;
}
?>