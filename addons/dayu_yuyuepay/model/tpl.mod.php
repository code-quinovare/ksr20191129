<?php
defined('IN_IA') or exit('Access Denied');

function tpl_app_form_avatar_thumb($name, $value = '', $id, $mode) {
	global $_W;
	$val = tomedia("headimg_".$_W['uniacid'].".jpg");
	if (!empty($value)) {
		$val = tomedia($value);
	}
	if ($mode=='member') {
		$width = "width:80px;height:80px;";
	}else{
		$width = "width:60px;height:60px;";
	}
	$html = '
		<a class="weui_media_hd js-avatar-'.$name.'">
			<img class="weui_media_appmsg_thumb circle" src="' . $val. '" style="'.$width.'" class="img-max center">
		</a>
	';
	if ($mode=='card') {
		switch ($name) {
			case 'idcard':
				$title = "身份证";
				break;
			case 'licence':
				$title = "驾驶证";
				break;
			case 'driving':
				$title = "行驶证";
				break;
		}
		$width = "width:100%;height:auto;";
		$html = '
				<div class="weui_cell">
					<div class="weui_cell_bd weui_cell_primary">
						<div class="weui-flex">
							<div class="weui-flex-item">
								<div class="weui_tabbar_item">
									<a class="weui_media_hd js-avatar-'.$name.'" style="padding:0;margin:0;">
										<img class="weui_media_appmsg_thumb" src="' . $val. '" style="'.$width.'" class="img-max center">
									</a>
									<p class="weui_tabbar_label f-black" style="margin-top:5px;">'.$title.'</p>
								</div>
							</div>
						</div>
					</div>
				</div>
		';
	}
	$href = url('entry', array('do' => 'upthumb', 'uid' => $id, 'm' => 'dayu_form','mode' => $mode,'field' => $name), true, true);
	$html .= "<script>
		util.image($('.js-avatar-{$name}'), function(url){
			$('.js-avatar-{$name} img').attr('src', url.url);
			$.post('" . $href . "', {'thumb' : url.attachment}, function(data) {
				if (data.message.status == 'success') {
					util.toast(data.message.msg);
				} else {
					util.toast(data.message.msg);
				}
			},'json')
		}, {
			crop : true
		});
	</script>";
	return $html;
}

function profile_fans_form($field, $value = '', $placeholder = '', $type = '') {
	$placeholders[$field] = '请填写' . $placeholder;
	if(in_array($field, array('birth', 'reside', 'gender', 'education', 'constellation', 'zodiac', 'bloodtype'))) {
		$placeholders[$field] = '请选择' . $placeholder;
	}
	if($field == 'height') {
		$placeholders[$field] = '请填写' . $placeholder . '(单位:cm)';
	} elseif ($field == 'weight') {
		$placeholders[$field] = '请填写' . $placeholder . '(单位:kg)';
	}
	switch ($field) {
		case 'avatar':
			$html = tpl_app_form_field_avatar('avatar', $value);
			break;
		case 'birth':
		case 'birthyear':
		case 'birthmonth':
		case 'birthday':
			$html = profile_app_form_field_calendar('birth', $value);
			break;
		case 'reside':
		case 'resideprovince':
		case 'residecity':
		case 'residedist':
			$html = profile_app_form_field_district('reside', $value);
			break;
		case 'bio':
		case 'interest':
			$html = '<textarea id="'.$field.'" name="'.$field.'" rows="3" placeholder="'.$placeholders[$field].'">'.$value.'</textarea>';
			break;
		case 'gender':
		case 'education':
		case 'constellation':
		case 'zodiac':
		case 'bloodtype':
			if($field == 'gender') {
				$options = array(
					'0' => '保密',
					'1' => '男',
					'2' => '女',
				);
				$text_value = $options[$value];
			} else {
				if ($field == 'bloodtype') {
					$options = array('A', 'B', 'AB', 'O', '其它');
				} elseif ($field == 'zodiac') {
					$options = array('鼠', '牛', '虎', '兔', '龙', '蛇', '马', '羊', '猴', '鸡', '狗', '猪');
				} elseif ($field == 'constellation') {
					$options = array('水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座', '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座');
				} elseif ($field == 'education') {
					$options = array('博士', '硕士', '本科', '专科', '中学', '小学', '其它');
				}
				$text_value = $value;
			}
			$data = array();
			foreach($options as $key => $option) {
				if(!$option) {
					continue;
				}
				if($field == 'gender') {
					$data[] = array(
						'text' => $option,
						'value' => $key
					);
				} else {
					$data[] = array(
						'text' => $option,
						'value' => $option
					);
				}
			}
			if($field != 'gender') {
				$text_value = $value;
				unset($options);
			}
			$html = '
				<input class="mui-'.$field.'-picker weui_input" type="text" value="'.$text_value.'" readonly placeholder="'.$placeholders[$field].'"/>
				<input type="hidden" id="'.$field.'" name="'.$field.'" value="'.$value.'"/>
				<script type="text/javascript">
					$(".mui-'. $field .'-picker").on("tap", function(){
						var $this = $(this);
						util.poppicker({data: '. json_encode($data) .'}, function(items){
							$this.val(items[0].text).next().val(items[0].value);
						});
					});
				</script>';
			break;
		case 'mobile':
			if (!empty($type)){
				$html = '<input class="weui_input" type="text" id="'.$field.'" name="'.$field.'" value="'.$value.'"  placeholder="'.$placeholders[$field].'"/>
						</div>
					</div>
					<div class="weui_cell weui_vcode">
						<input type="hidden" id="htel">
						<input type="hidden" id="hsms">
						<div class="weui_cell_hd"><label class="weui_label weui-start">验证码</label></div>
						<div class="weui_cell_bd weui_cell_primary">
							<input class="weui_input" id="sms" name="sms" type="tel" placeholder="请输入验证码">
						</div>
						<div class="weui_cell_ft">
							<a href="javascript:settime();" class="weui-vcode-btn" id="sendsms"><small id="code">获取验证码</small></a>';
			}else{
				$html = '<input class="weui_input" type="text" id="'.$field.'" name="'.$field.'" value="'.$value.'"  placeholder="'.$placeholders[$field].'"/>';
			}
			break;
		case 'address':
			if (!empty($type)){
				$html = '<input class="weui_input" type="text" id="'.$field.'" name="'.$field.'" value="'.$value.'"  placeholder="'.$placeholders[$field].'"/>
						</div>
						<div class="weui_cell_ft"><a href="javascript:void(0);" onclick="getLocation(this);">
							<svg class="icon f18" aria-hidden="true">
								<use xlink:href="#icon-Geo-fence"></use>
							</svg>
						</a>';
			}else{
				$html = '<input class="weui_input" type="text" id="'.$field.'" name="'.$field.'" value="'.$value.'"  placeholder="'.$placeholders[$field].'"/>';
			}
			break;
		case 'nickname':
		case 'realname':
		case 'qq':
		case 'msn':
		case 'email':
		case 'telephone':
		case 'taobao':
		case 'alipay':
		case 'studentid':
		case 'grade':
		case 'graduateschool':
		case 'idcard':
		case 'zipcode':
		case 'site':
		case 'affectivestatus':
		case 'lookingfor':
		case 'nationality':
		case 'height':
		case 'weight':
		case 'company':
		case 'occupation':
		case 'position':
		case 'revenue':
		default:
			$html = '<input class="weui_input" type="text" id="'.$field.'" name="'.$field.'" value="'.$value.'"  placeholder="'.$placeholders[$field].'"/>';
			break;
	}
	return $html;
}

function profile_app_form_field_calendar($name, $values = array()) {
	$value = (empty($values['year']) || empty($values['month']) || empty($values['day'])) ? '' : implode('-', $values);
	$html = '';
	$html .= '<input class="mui-calendar-picker weui_input" type="text" placeholder="请选择日期" readonly value="' . $value . '" name="' . $name . '" />';
	$html .= '<input type="hidden" value="' . $values['year'] . '" name="' . $name . '[year]"/>';
	$html .= '<input type="hidden" value="' . $values['month'] . '" name="' . $name . '[month]"/>';
	$html .= '<input type="hidden" value="' . $values['day'] . '" name="' . $name . '[day]"/>';
	if (!defined('TPL_INIT_CALENDAR')) {
		$html .= '
			<script type="text/javascript">
				$(document).on("tap", ".mui-calendar-picker", function(){
					var $this = $(this);
					util.datepicker({
						type: "date", 
						beginYear: 1910, 
						endYear: 2060, 
						selected : {
							year : "' . $values['year'] . '", month : "' . $values['month'] . '", day : "' . $values['day'] . '"}
						}, function(rs){
							$this.val(rs.value)
							.next().val(rs.y.text)
							.next().val(rs.m.text)
							.next().val(rs.d.text)
					});
				});
			</script>';
		define('TPL_INIT_CALENDAR', true);
	}
	return $html;
}

function profile_app_form_field_district($name, $values = array()) {
	$value = (empty($values['province']) || empty($values['city']) || empty($values['district'])) ? '' : implode(' ', $values);
	$html = '';
	$html .= '<input class="mui-district-picker-'.$name.'  weui_input" id="'.$name.'" placeholder="请选择地区" type="text" readonly value="' . $value . '"/>';
	$html .= '<input type="hidden" value="'.$values['province'].'" id="province" name="'.$name.'[province]"/>';
	$html .= '<input type="hidden" value="'.$values['city'].'" id="city" name="'.$name.'[city]"/>';
	$html .= '<input type="hidden" value="'.$values['district'].'" id="district" name="'.$name.'[district]"/>';
	$html .= '
		<script type="text/javascript">
			$(document).on("tap", ".mui-district-picker-' . $name . '", function(){
				var $this = $(this);
				util.districtpicker(function(item){
					$this.val(item[0].text+" "+item[1].text+" "+item[2].text)
					.next().val(item[0].text)
					.next().val(item[1].text)
					.next().val(item[2].text);
				}, {province : "'.$values['province'].'", city : "'.$values['city'].'", district : "'.$values['district'].'"});
			});
		</script>';
	return $html;
}