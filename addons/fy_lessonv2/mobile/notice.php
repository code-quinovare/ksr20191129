<?php
/**
 * 定时课程提醒
 * ============================================================================
 * 版权所有 2015-2018 风影随行，并保留所有权利。
 * 网站地址: https://wx.haoshu888.com
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！不允许对程序代码以任何形式任何目的的再发布，作者将保留
 * 追究法律责任的权力和最终解释权。
 */

set_time_limit(300);

$list = pdo_fetchall("SELECT * FROM " .tablename($this->table_inform). " WHERE status=:status", array(':status'=>1));
foreach($list as $v){
	$tplmessage = pdo_fetch("SELECT newlesson FROM " .tablename($this->table_tplmessage). " WHERE uniacid=:uniacid", array(':uniacid'=>$v['uniacid']));

	$fans_list = pdo_fetchall("SELECT * FROM " .tablename($this->table_inform_fans). " WHERE inform_id=:inform_id LIMIT 0,100", array(':inform_id'=>$v['inform_id'],));

	if(empty($tplmessage['newlesson'])){
		continue;
	}
	if(empty($fans_list) || time()-86400 > $v['addtime']){
		pdo_update($this->table_inform, array('status'=>0), array('inform_id'=>$v['inform_id']));
		continue;
	}

	$data = json_decode($v['content'], true);	
	$message = array(
		'template_id' => $tplmessage['newlesson'],
		'url'		  => $_W['siteroot'] . 'app/' . $this->createMobileUrl('lesson', array('id'=>$v['lesson_id'])),
		'topcolor'	  => "#222222",
		'data'		  => array(
			'first'  => array(
				'value' => $data['first'],
				'color' => "#222222",
			),
			'keyword1' => array(
				'value' => $data['keyword1'],
				'color' => "#428BCA",
			),
			'keyword2' => array(
				'value' => $data['keyword2'],
				'color' => "#428BCA",
			),
			'keyword3' => array(
				'value' => $data['keyword3'],
				'color' => "#428BCA",
			),
			'keyword4' => array(
				'value' => $data['keyword4'],
				'color' => "#428BCA",
			),
			'remark' => array(
				'value' => $data['remark'],
				'color' => "#222222",
			),
		)
	);

	foreach($fans_list as $item){
		$message['touser'] = $item['openid'];
		$this->send_template_message(urldecode(json_encode($message)));
		pdo_delete($this->table_inform_fans, array('inform_fans_id'=>$item['inform_fans_id']));
		echo date('Y-m-d H:i:s');
		sleep(2);
	}

	if(count($fans_list) < 100){
		pdo_update($this->table_inform, array('status'=>0), array('inform_id'=>$v['inform_id']));
	}
}
exit();



?>