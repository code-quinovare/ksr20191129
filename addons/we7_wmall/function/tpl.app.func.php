<?php

//http://www.shuotupu.com
//说图谱网
defined('IN_IA') || exit('Access Denied');
function tpl_select($title, $name, $value, $selects, $filter = array('id', 'title'), $multi = false) 
{
	if (empty($selects)) 
	{
		return false;
	}
	$items = array();
	$value_cn = '请选择';
	foreach ($selects as $select ) 
	{
		$items[] = array('title' => $select[$filter[1]], 'value' => $select[$filter[0]]);
		if ($select[$filter[0]] == $value) 
		{
			$value_cn = $select[$filter[1]];
		}
	}
	$container = 'tpl-select-' . $name;
	$params = json_encode(array('title' => $title, 'multi' => $multi, 'items' => $items));
	$html = "\r\n\t\t" . '<div class="tpl-select ' . $container . '">' . "\r\n\t\t\t" . '<span>' . $value_cn . '</span>' . "\r\n\t\t\t" . '<input type="hidden" class="select-value" name="' . $name . '" value="' . $value . '"/>' . "\r\n\t\t\t" . '<input type="hidden" class="select-title" name="' . $name . '_cn" value="' . $value . '"/>' . "\r\n\t\t" . '</div>' . "\r\n\t\t" . '<script type="text/javascript">' . "\r\n\t\t\t" . '$(".' . $container . '").select(' . $params . ');' . "\r\n\t\t" . '</script>' . "\r\n\t";
	return $html;
}
function tpl_image($name, $value) 
{
	$url = ((empty($value) ? WE7_WMALL_TPL_URL . 'static/img/add_pic.png' : tomedia($value)));
	if (!(defined('TPL_INIT_TINY_IMAGE'))) 
	{
		$html = "\r\n\t\t" . '<script>' . "\r\n\t\t\t" . 'function uploadImage(obj){' . "\r\n\t\t\t\t" . 'tiny.image(obj, function(obj, data){' . "\r\n\t\t\t\t\t" . 'var img_value = data.message ? data.message : data.attachment;' . "\r\n\t\t\t\t\t" . 'obj.find("img").attr("src", data.url);' . "\r\n\t\t\t\t\t" . 'obj.find("input").val(img_value);' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_IMAGE', true);
	}
	$html .= "\r\n\t\t" . '<div class="row image-container tpl-image">' . "\r\n\t\t\t" . '<div class="col-25 image-item image-add" onclick="uploadImage(this)">' . "\r\n\t\t\t\t" . '<input type="hidden" name="' . $name . '" value="' . $value . '"/>' . "\r\n\t\t\t\t" . '<img src="' . $url . '" alt=""/>';
	if (!(is_weixin())) 
	{
		$html .= '<input type="file" accept="image*/" multiple="false" @change="upload">';
	}
	$html .= '</div></div>';
	return $html;
}
function tpl_mutil_image($name, $values, $file_nums = 9) 
{
	if (!(defined('TPL_INIT_TINY_MUTIL_IMAGE'))) 
	{
		$html = "\r\n\t\t" . '<script>' . "\r\n\t\t\t" . 'var fileNum = ' . $file_nums . ';' . "\r\n\t\t\t" . 'var options = {' . "\r\n\t\t\t\t" . 'fileNum: ' . $file_nums . "\r\n\t\t\t" . '};' . "\r\n\t\t\t" . 'var fileNum = options.fileNum;' . "\r\n\t\t\t" . 'function uploadMutilImage(obj){' . "\r\n\t\t\t\t" . 'var $parent = $(obj).parents(".tpl-image");' . "\r\n\t\t\t\t" . 'var nowFileNum = $parent.find(".image-edit").size();' . "\r\n\t\t\t\t" . 'options.fileNum = fileNum - nowFileNum;' . "\r\n\t\t\t\t" . 'require(["tiny"], function(tiny){' . "\r\n\t\t\t\t\t" . 'if(nowFileNum >= fileNum) {' . "\r\n\t\t\t\t\t\t" . '$.toast("最多能上传" + fileNum + "张图片");' . "\r\n\t\t\t\t\t\t" . 'return false;' . "\r\n\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t" . 'tiny.image(obj, function(obj, data){' . "\r\n\t\t\t\t\t\t" . 'var img_value = data.message ? data.message : data.attachment;' . "\r\n\t\t\t\t\t\t" . 'if(obj.hasClass("image-edit")) {' . "\r\n\t\t\t\t\t\t\t" . 'obj.parent().find("img").attr("src", data.url);' . "\r\n\t\t\t\t\t\t\t" . 'obj.parent().find("input").val(img_value);' . "\r\n\t\t\t\t\t\t" . '} else {' . "\r\n\t\t\t\t\t\t\t" . 'obj.before(\'<div class="col-25 image-item"><img src="\'+data.url+\'" class="image-edit" onclick="uploadMutilImage(this)" alt=""/><input type="hidden" name="' . $name . '" value="\'+img_value+\'"/><i class="icon icon-close" onclick="delMutilImage(this)"></i></div>\')' . "\r\n\t\t\t\t\t\t" . '}' . "\r\n\t\t\t\t\t" . '}, options);' . "\r\n\t\t\t\t" . '});' . "\r\n\t\t\t" . '}' . "\r\n\t\t\t" . 'function delMutilImage(obj){' . "\r\n\t\t\t\t" . 'var $parent = $(obj).parents(".image-item");' . "\r\n\t\t\t\t" . '$parent.remove();' . "\r\n\t\t\t\t" . 'event.stopPropagation();' . "\r\n\t\t\t\t" . 'return false;' . "\r\n\t\t\t" . '}' . "\r\n\t\t" . '</script>';
		define('TPL_INIT_TINY_MUTIL_IMAGE', true);
	}
	$name = $name . '[]';
	$html .= '<div class="row image-container tpl-image border-1px-tb">';
	if (!(empty($values))) 
	{
		foreach ($values as $value ) 
		{
			$html .= "\r\n\t\t\t\t" . '<div class="col-25 image-item">' . "\r\n\t\t\t\t\t" . '<input type="hidden" name="' . $name . '" value="' . $value . '"/>' . "\r\n\t\t\t\t\t" . '<img src="' . tomedia($value) . '" class="image-edit" onclick="uploadMutilImage(this)" alt=""/>' . "\r\n\t\t\t\t\t" . '<i class="icon icon-close" onclick="delMutilImage(this)"></i>' . "\r\n\t\t\t\t" . '</div>' . "\r\n\t\t\t";
		}
	}
	$src = WE7_WMALL_TPL_URL . 'static/img/add_pic.png';
	$html .= "\r\n\t\t" . '<div class="col-25 image-item image-add" onclick="uploadMutilImage(this)">' . "\r\n\t\t\t" . '<img src="' . $src . '" alt=""/>' . "\r\n\t";
	if (!(is_weixin())) 
	{
		$html .= '<input type="file" accept="image*/" multiple="true" @change="upload">';
	}
	$html .= '</div></div>';
	return $html;
}
?>