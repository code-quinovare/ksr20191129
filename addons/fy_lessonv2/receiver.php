<?php
/**
 * 微课堂V2模块订阅器
 */
defined('IN_IA') or exit('Access Denied');

class Fy_lessonv2ModuleReceiver extends WeModuleReceiver {
	public $table_lesson_parent = 'fy_lesson_parent';
	public $table_fans = 'mc_mapping_fans';

	public function receive() {
		global $_W;

		$type = $this->message['type'];
		$event = $this->message['event'];
		$from = $this->message['from']; /*ojZYr0lREzm3YWtWnw3aj5vs_nD8*/
		$to = $this->message['to']; /*gh_111807fbfdfa*/
		$scene = $this->message['scene']; /*lesson_48*/
		$uniacid = $_W['uniacid'];

		/* 用户关注事件 */
		if($event=="subscribe" || $type=="qr"){
			if(strstr($scene, "lesson_")){
				$this->sendLessonNews($uniacid, $scene, $from);
			}
		}
	}

	/**
	 * 用户关注公众号发送图文消息
	 * 场景：用户在课程详情页关注公众号
	 */
	private function sendLessonNews($uniacid, $scene, $from){
		global $_W;
		load()->func('logging');

		$lessonid = str_replace("lesson_", "", $scene);
		$lesson = pdo_fetch("SELECT id,bookname,images,share FROM " .tablename($this->table_lesson_parent). " WHERE id=:id", array(':id'=>$lessonid));
		if(!$lesson){
			logging_run('用户关注公众号(uniacid:'.$uniacid.')发送课程图文消息失败，原因：课程(id:'.$lessonid.')不存在', 'trace', 'fylessonv2');
			return;
		}
		$share = json_decode($lesson['share'], true);

		$fans = pdo_fetch("SELECT nickname FROM " .tablename($this->table_fans). " WHERE uniacid=:uniacid AND openid=:openid", array(':uniacid'=>$uniacid,':openid'=>$from));
		$nickname = isset($fans['nickname']) ? $fans['nickname']."，" : "";
		$title = !empty($share['title']) ? $share['title'] : "欢迎继续回来，点击继续学习《{$lesson['bookname']}》课程";
		$description = !empty($share['descript']) ? $share['descript'] : "点击继续学习《{$lesson['bookname']}》";

		$message = array(
			'touser' => $from,
			'msgtype' => 'news',
			'news' => array(
				'articles' => array(
					'0' => array(
						'title' => $nickname.$title,
						'description' => $description,
						'url' => $_W['siteroot'].$this->createMobileUrl('lesson', array('id'=>$lessonid)),
						'picurl' => !empty($share['images']) ? $_W['attachurl'].$share['images'] : $_W['attachurl'].$lesson['images']
					)
				)
			)
		);
		$account_api = WeAccount::create();
		$token = $account_api->getAccessToken();
		if(is_error($token)){
			logging_run('用户关注公众号(uniacid:'.$uniacid.')发送课程图文消息失败，原因：获取access_token失败', 'trace', 'fylessonv2');
			return;
		}

		$url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$token;
		$result = ihttp_request($url, json_encode($message, JSON_UNESCAPED_UNICODE));
		logging_run(print_r($result, true), 'info', 'fylessonv2');
	}

}