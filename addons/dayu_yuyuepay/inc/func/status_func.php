<?php
function echoStatus($status=0)
{
	switch ($status) {
		case 0:
			echo "待受理";
			break;
		case 1:
			echo "受理中";
			break;
		case 2:
			echo "取消";
			break;
		case 3:
			echo "完成";
			break;
		case 9:
			echo "拒绝";
			break;
		default:
			echo "异常";
			break;
	}
}