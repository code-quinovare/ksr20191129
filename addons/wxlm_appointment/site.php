<?php

//decode by QQ:10373458 https://www.010xr.com/
include_once "model/func.php";
include_once 'model/sql.php';
include 'model/api_sdk/aliyun-php-sdk-core/Config.php';
include_once 'model/api_sdk/Dysmsapi/Request/V20170525/QuerySendDetailsRequest.php';
include_once 'model/api_sdk/Dysmsapi/Request/V20170525/SendSmsRequest.php';
include_once 'model/phpqrcode.php';
include_once 'model/wxpay.php';
include_once 'model/config.php';
include_once 'model/lib/teegon.php';
define('nowDate', date('Y-m-d H:i:s', time()));
define('RES', "../addons/wxlm_appointment/template/");
defined('IN_IA') or exit('Access Denied');
class Wxlm_appointmentModuleSite extends WeModuleSite
{
	public function __construct()
	{
		$type = 'type1';
		$this->config = getconfigbytype($type, $this->tb_config);
		$this->config['system_name'] = empty($this->config['system_name']) ? '番瓜门店预约' : $this->config['system_name'];
	}
	private $config;
	private $index = 1;
	private $tb_ad = 'wxlm_appointment_ad';
	private $tb_admin = 'wxlm_appointment_admin';
	private $tb_business = 'wxlm_appointment_business';
	private $tb_card = 'wxlm_appointment_card';
	private $tb_circle = 'wxlm_appointment_circle';
	private $tb_comment = 'wxlm_appointment_comment';
	private $tb_config = 'wxlm_appointment_config';
	private $tb_dating = 'wxlm_appointment_dating';
	private $tb_fabulous = 'wxlm_appointment_fabulous';
	private $tb_order = 'wxlm_appointment_order';
	private $tb_orderrefund = 'wxlm_appointment_orderrefund';
	private $tb_project = 'wxlm_appointment_project';
	private $tb_staff = 'wxlm_appointment_staff';
	private $tb_store = 'wxlm_appointment_store';
	private $tb_storetype = 'wxlm_appointment_storetype';
	private $tb_vip = 'wxlm_appointment_vip';
	private $tb_work = 'wxlm_appointment_work';
	private $tb_switch = 'wxlm_appointment_switch';
	private $tb_ptype = 'wxlm_appointment_ptype';
	private $tb_march = 'wxlm_appointment_march';
	private $tb_settle = 'wxlm_appointment_settle';
	private $tb_show = 'wxlm_appointment_show';
	private $tb_showtype = 'wxlm_appointment_showtype';
	private $tb_collection = 'wxlm_appointment_collection';
	private $tb_archive = 'wxlm_appointment_archive';
	private $tb_visittype = 'wxlm_appointment_visittype';
	private $tb_visittpl = 'wxlm_appointment_visittpl';
	private $tb_consume = 'wxlm_appointment_consume';
	private $tb_visitlog = 'wxlm_appointment_visitlog';
	private $tb_scomment = 'wxlm_appointment_scomment';
	private $tb_scommenttag = 'wxlm_appointment_scommenttag';
	public function doWebSystem()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'base' : $_GPC['op'];
		if ($op == 'base') {
			$type = 'type1';
			$base = getconfigbytype($type, $this->tb_config);
			if (!empty($_POST['base'])) {
				$base_new = $_POST['base'];
				$result = updateconfigbytype($type, $base, $base_new, $this->tb_config);
				if ($result) {
					message('基础设置保存成功', $this->createWebUrl('system', array('op' => 'base')), 'success');
				}
			}
			include $this->template('system_base');
		} else {
			if ($op == 'pay') {
				$type = 'type2';
				$pay = getconfigbytype($type, $this->tb_config);
				if (!empty($_POST['pay'])) {
					$pay_new = $_POST['pay'];
					load()->func('file');
					mkdirs(ATTACHMENT_ROOT . '/cert');
					$r = true;
					$pemname = 'appointment' . $_W['uniacid'];
					if (!empty($pay_new['cert'])) {
						$pay_new['cert'] = chop($pay_new['cert']);
						$ret = file_put_contents(ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $pemname, trim($pay_new['cert']));
						$r = $r && $ret;
					}
					if (!empty($pay_new['key'])) {
						$pay_new['key'] = chop($pay_new['key']);
						$ret = file_put_contents(ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $pemname, trim($pay_new['key']));
						$r = $r && $ret;
					}
					if (!empty($pay_new['ca'])) {
						$pay_new['ca'] = chop($pay_new['ca']);
						$ret = file_put_contents(ATTACHMENT_ROOT . '/cert/rootca.pem.' . $pemname, trim($pay_new['ca']));
						$r = $r && $ret;
					}
					if (!$r) {
						message('证书保存失败, 请保证 /attachment/cert/ 目录可写');
					}
					$pay_new['pemname'] = $pemname;
					$result = updateconfigbytype($type, $pay, $pay_new, $this->tb_config);
					if ($result) {
						message('支付设置保存成功', $this->createWebUrl('system', array('op' => 'pay')), 'success');
					}
				}
				include $this->template('system_pay');
			} else {
				if ($op == 'notice') {
					$type = 'type5';
					$notice = getconfigbytype($type, $this->tb_config);
					if (!empty($_POST['notice'])) {
						$notice_new = $_POST['notice'];
						$result = updateconfigbytype($type, $notice, $notice_new, $this->tb_config);
						if ($result) {
							message('通知方式保存成功', $this->createWebUrl('system', array('op' => 'notice')), 'success');
						}
					}
					include $this->template('system_notice');
				} else {
					if ($op == 'template') {
						$type = 'type4';
						$tpl = getconfigbytype($type, $this->tb_config);
						if (!empty($_POST['tpl'])) {
							$tpl_new = $_POST['tpl'];
							$result = updateconfigbytype($type, $tpl, $tpl_new, $this->tb_config);
							if ($result) {
								message('模板消息保存生成', $this->createWebUrl('system', array('op' => 'template')), 'success');
							}
						}
						include $this->template('system_tpl');
					} else {
						if ($op == 'message') {
							$type = 'type3';
							$message = getconfigbytype($type, $this->tb_config);
							if (!empty($_POST['message'])) {
								$message_new = $_POST['message'];
								$result = updateconfigbytype($type, $message, $message_new, $this->tb_config);
								if ($result) {
									message('短信接口保存生成', $this->createWebUrl('system', array('op' => 'message')), 'success');
								}
							}
							include $this->template('system_message');
						} else {
							if ($op == 'business') {
								$type = 'type6';
								$business = getconfigbytype($type, $this->tb_config);
								if (!empty($_POST['business'])) {
									$business_new = $_POST['business'];
									$result = updateconfigbytype($type, $business, $business_new, $this->tb_config);
									if ($result) {
										message('商家入驻保存生成', $this->createWebUrl('system', array('op' => 'business')), 'success');
									}
								}
								include $this->template('system_business');
							}
						}
					}
				}
			}
		}
	}
	public function doWebCircle()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['circle']);
				}
				$_SESSION['search']['circle'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['circle'])) {
				$searchrecord = $_SESSION['search']['circle'];
				if (!empty($searchrecord['circle_address'])) {
					$searchrecord['circle_province'] = $searchrecord['circle_address']['province'];
					$searchrecord['circle_city'] = $searchrecord['circle_address']['city'];
					$searchrecord['circle_county'] = $searchrecord['circle_address']['county'];
				}
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectCircle($option);
			$circles = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			include $this->template('circle_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['circle'])) {
					$circle = $_POST['circle'];
					$circle['circle_uniacid'] = $_W['uniacid'];
					$circle['circle_province'] = $circle['circle_address']['province'];
					$circle['circle_city'] = $circle['circle_address']['city'];
					$circle['circle_county'] = $circle['circle_address']['district'];
					unset($circle['circle_address']);
					if (empty($circle['circle_id'])) {
						unset($circle['circle_id']);
						$circle['circle_time_add'] = nowDate;
						$circle['circle_time_update'] = nowDate;
						$result = pdo_insert($this->tb_circle, $circle);
						if ($result) {
							message('添加商圈成功', $this->createWebUrl('circle', array('op' => 'display')), 'success');
						}
					} else {
						$circle['circle_time_update'] = nowDate;
						$result = pdo_update($this->tb_circle, $circle, array('circle_id' => $circle['circle_id']));
						if ($result) {
							message('修改商圈成功', $this->createWebUrl('circle', array('op' => 'display')), 'success');
						}
					}
				}
				load()->func('tpl');
				include $this->template('circle_create');
			} else {
				if ($op == 'modify') {
					$circle_id = $_GPC['id'];
					$option['search']['circle_id'] = $circle_id;
					$result = selectCircle($option);
					$circle = end($result['records']);
					$circle['circle_address']['province'] = $circle['circle_province'];
					$circle['circle_address']['city'] = $circle['circle_city'];
					$circle['circle_address']['district'] = $circle['circle_county'];
					include $this->template('circle_create');
				} else {
					if ($op == 'delete') {
						$circle_id = $_GPC['id'];
						if ($circle_id) {
							$res = pdo_delete($this->tb_circle, array('circle_id' => $circle_id));
							if ($res) {
								message('删除商圈成功', $this->createWebUrl('circle', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebBusiness()
	{
		global $_W, $_GPC;
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['business']);
				}
				$_SESSION['search']['business'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['business'])) {
				$searchrecord = $_SESSION['search']['business'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectBusiness($option);
			$business = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$pcurl = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('pcLogin', array()));
			include $this->template('business_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['business'])) {
					$business = $_POST['business'];
					$business['business_uniacid'] = $_W['uniacid'];
					if (empty($business['business_id'])) {
						unset($business['business_id']);
						$business['business_time_add'] = nowDate;
						$business['business_time_update'] = nowDate;
						$result = pdo_insert($this->tb_business, $business);
						if ($result) {
							message('添加商家成功', $this->createWebUrl('business', array('op' => 'display')), 'success');
						}
					} else {
						$business['business_time_update'] = nowDate;
						$result = pdo_update($this->tb_business, $business, array('business_id' => $business['business_id']));
						if ($result) {
							message('修改商家成功', $this->createWebUrl('business', array('op' => 'display')), 'success');
						}
					}
				}
				include $this->template('business_create');
			} else {
				if ($op == 'modify') {
					$business_id = $_GPC['id'];
					$business = pdo_get($this->tb_business, array('business_uniacid' => $_W['uniacid'], 'business_id' => $business_id));
					include $this->template('business_create');
				} else {
					if ($op == 'delete') {
						$business_id = $_GPC['id'];
						if ($business_id) {
							$res = pdo_delete($this->tb_business, array('business_id' => $business_id));
							if ($res) {
								message('删除商家成功', $this->createWebUrl('business', array('op' => 'display')), 'success');
							}
						}
					} else {
						if ($op == 'admin') {
							$business_id = $_GPC['business_id'];
							if (empty($business_id)) {
								message('未获取商家信息', $this->createWebUrl('business', array('op' => 'display')), 'error');
							}
							$pindex = max(1, intval($_GPC['page']));
							$psize = 20;
							if (!empty($_POST['search'])) {
								if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
									$pindex = 1;
									unset($_SESSION['search']['admin']);
								}
								$_SESSION['search']['admin'] = $_GPC['search'];
							}
							$searchrecord = array();
							if (isset($_SESSION['search']['admin'])) {
								$searchrecord = $_SESSION['search']['admin'];
							}
							$search = $searchrecord;
							$option['search'] = $searchrecord;
							$option['search']['admin_businessid'] = $business_id;
							$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
							$result = selectAdmin($option);
							$admins = $result['records'];
							$total = $result['total'];
							$page = pagination($total, $pindex, $psize);
							include $this->template('business_admin');
						} else {
							if ($op == 'add') {
								if (!empty($_POST['admin'])) {
									$admin = $_POST['admin'];
									$admin['admin_uniacid'] = $_W['uniacid'];
									if (empty($admin['admin_businessid'])) {
										message('未获取到商家信息', $this->createWebUrl('business', array('op' => 'admin')), 'error');
										die;
									}
									$admin['admin_password'] = md5($admin['admin_password']);
									if (empty($admin['admin_id'])) {
										unset($admin['admin_id']);
										$log = pdo_get($this->tb_admin, array('admin_uniacid' => $_W['uniacid'], 'admin_account' => $admin['admin_account']));
										if ($log) {
											message('此账号已被使用', '', 'error');
										}
										$admin['admin_time_add'] = nowDate;
										$admin['admin_time_update'] = nowDate;
										$res = pdo_insert($this->tb_admin, $admin);
										if ($res) {
											message('添加商家账号成功', $this->createWebUrl('business', array('op' => 'admin', 'id' => $admin['admin_businessid'])), 'success');
										}
									} else {
										$admin['admin_time_update'] = nowDate;
										$res = pdo_update($this->tb_admin, $admin, array('admin_id' => $admin['admin_id']));
										if ($res) {
											message('修改商家账号成功', $this->createWebUrl('business', array('op' => 'admin', 'id' => $admin['admin_businessid'])), 'success');
										}
									}
								}
							} else {
								if ($op == 'admin_modify') {
									$admin_id = $_GPC['adminid'];
									$business_id = $_GPC['businessid'];
									if (empty($admin_id) || empty($business_id)) {
										$data['result'] = 'error';
										$data['state'] = '未获取到相关信息';
									}
									$admin = pdo_get($this->tb_admin, array('admin_id' => $admin_id, 'admin_businessid' => $business_id, 'admin_uniacid' => $_W['uniacid']));
									$admin['admin_avatarurl'] = tomedia($admin['admin_avatar']);
									if (empty($admin)) {
										$data['result'] = 'error';
										$data['state'] = '未获取到商家账号';
									} else {
										$data['result'] = 'ok';
										$data['admin'] = $admin;
									}
									echo json_encode($data);
								} else {
									if ($op == 'admin_delete') {
										$admin_id = $_GPC['id'];
										$business_id = $_GPC['businessid'];
										if (empty($admin_id)) {
											message('未获取到商家账号', $this->createWebUrl('business', array('op' => 'admin', 'id' => $business_id)), 'error');
										}
										$res = pdo_delete($this->tb_admin, array('admin_id' => $admin_id, 'admin_uniacid' => $_W['uniacid']));
										if ($res) {
											message('删除商家账号成功', $this->createWebUrl('business', array('op' => 'admin', 'id' => $business_id)), 'success');
										}
									} else {
										if ($op == 'settle') {
											$business_id = $_GPC['business_id'];
											$business = pdo_get($this->tb_business, array('business_uniacid' => $_W['uniacid'], 'business_id' => $business_id));
											if (empty($business)) {
												message('未获取到商家信息', '', 'error');
											}
											$pindex = max(1, intval($_GPC['page']));
											$psize = 20;
											if (!empty($_POST['search'])) {
												if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
													$pindex = 1;
													unset($_SESSION['search']['order']);
												}
												$_SESSION['search']['order'] = $_GPC['search'];
											}
											$searchrecord = array();
											if (isset($_SESSION['search']['order'])) {
												$searchrecord = $_SESSION['search']['order'];
											}
											$search = $searchrecord;
											$option['search'] = $searchrecord;
											$option['search']['order_businessid'] = $business_id;
											if ($_POST['action'] == 1) {
												$total = selectSettleTotal($option);
												$update = updateOrderSettle($option);
												if ($business['business_package'] == 4) {
													$packages = getconfigbytype('type6', $this->tb_config);
													$total = $total - $total * $packages['package4_price'] / 100;
												}
												if (!empty($update)) {
													$settle['settle_uniacid'] = $_W['uniacid'];
													$settle['settle_businessid'] = $business_id;
													$settle['settle_total'] = $total;
													$settle['settle_state'] = 1;
													$settle['settle_time_add'] = nowDate;
													$ins = pdo_insert($this->tb_settle, $settle);
													$settle_id = pdo_insertid();
													if ($ins) {
														if (empty($business['business_admin_openid'])) {
															message('未获取到负责人openid', $this->createWebUrl('business', array('op' => 'settle', 'business_id' => $business_id)), 'error');
															die;
														}
														$pay = getconfigbytype("type2", 'wxlm_appointment_config');
														$res_send = $this->sendMoney($pay, $business['business_admin_openid'], $total, '预约系统商户结算');
														if ($res_send['result_code'] == 'SUCCESS') {
															$settle_up = pdo_update($this->tb_settle, array('settle_state' => 2), array('settle_id' => $settle_id, 'settle_uniacid' => $_W['uniaicd']));
															if ($settle_up) {
																message('结算成功', $this->createWebUrl('business', array('op' => 'settle', 'business_id' => $business_id)), 'success');
															}
														} else {
															message('结算失败, 请检查参数是否填写正确', $this->createWebUrl('business', array('op' => 'settle', 'business_id' => $business_id)), 'error');
														}
													}
												} else {
													message('结算异常请稍后重试', $this->createWebUrl('business', array('op' => 'settle', 'business_id' => $business_id)), 'error');
												}
											} else {
												$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
												$result = selectSettle($option);
												$orders = $result['records'];
												$total = $result['total'];
												$finish = $result['finish'];
												$wait = $result['wait'];
												if ($business['business_package'] == 4) {
													$packages = getconfigbytype('type6', $this->tb_config);
													$finish = $finish - $finish * $packages['package4_price'] / 100;
													$wait = $wait - $wait * $packages['package4_price'] / 100;
												}
												unset($result);
												$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_businessid' => $business_id));
												$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid'], 'staff_businessid' => $business_id));
												$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $business_id));
												$page = pagination($total, $pindex, $psize);
												$orders = dealOrders($orders, $business, $stores, $staffs, $projects);
												include $this->template('business_settle');
											}
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	public function doWebWork()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$business_id = $_GPC['business_id'];
			if (empty($business_id)) {
				message('未获取商家信息', $this->createWebUrl('business', array('op' => 'display')), 'error');
			}
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['work']);
				}
				$_SESSION['search']['work'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['work'])) {
				$searchrecord = $_SESSION['search']['work'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['work_businessid'] = $business_id;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectWork($option);
			$works = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			include $this->template('business_work');
		}
	}
	public function doWebMarch()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['march']);
				}
				$_SESSION['search']['march'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['march'])) {
				$searchrecord = $_SESSION['search']['march'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectMarch($option);
			$marchs = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			include $this->template('business_march');
		} else {
			if ($op == 'pass') {
				$id = $_GPC['id'];
				$result = pdo_update($this->tb_march, array('march_state' => 2, 'march_time_update' => nowDate), array('march_uniacid' => $_W['uniacid'], 'march_id' => $id));
				if (!empty($result)) {
					$business = getconfigbytype('type6', $this->tb_config);
					$march = pdo_get($this->tb_march, array('march_id' => $id, 'march_uniacid' => $_W['uniacid']));
					$account_api = WeAccount::create();
					$openid = $march['march_openid'];
					$template_id = $business['business_tpl'];
					if (!empty($openid) && !empty($template_id)) {
						$data['first']['value'] = '商家入驻审核通知';
						$data['keyword1']['value'] = '审核通过';
						$data['keyword1']['color'] = '#173177';
						$data['keyword2']['value'] = nowDate;
						$data['keyword2']['color'] = '#173177';
						$data['remark']['value'] = '点击选取套餐, 完成申请';
						$url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('package', array('march_id' => $id)));
						$status = $account_api->sendTplNotice($openid, $template_id, $data, $url);
						if (is_error($status)) {
							message('发送模板消息异常:' . $status['message'], '', 'error');
						}
					} else {
						message('模板消息发送失败, 请检查是否填写模板ID', '', 'error');
					}
					message('申请通过成功', $this->createWebUrl('march'), 'success');
				}
			} else {
				if ($op == 'refuse') {
					$id = $_GPC['id'];
					$result = pdo_update($this->tb_march, array('march_state' => 3, 'march_time_update' => nowDate), array('march_uniacid' => $_W['uniacid'], 'march_id' => $id));
					if (!empty($result)) {
						message('申请已拒绝', $this->createWebUrl('march'), 'success');
					}
				} else {
					if ($op == 'modify') {
						$id = $_GPC['id'];
						$march = pdo_get($this->tb_march, array('march_id' => $id));
						if (empty($march)) {
							message('未获取到申请信息', $this->createWebUrl('march'), 'error');
						}
						$march['march_pic'] = json_decode($march['march_pic'], true);
						include $this->template('business_march_create');
					} else {
						if ($op == 'delete') {
							$id = $_GPC['id'];
							$result = pdo_delete($this->tb_march, array('march_id' => $id));
							if (!empty($result)) {
								message('申请删除成功', $this->createWebUrl('march'), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebPtype()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['ptype']);
				}
				$_SESSION['search']['ptype'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['ptype'])) {
				$searchrecord = $_SESSION['search']['ptype'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectPtype($option, 2);
			$ptypes = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			$result = selectBusiness();
			$business = $result['records'];
			unset($result);
			include $this->template('ptype_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['ptype'])) {
					$ptype = $_POST['ptype'];
					$ptype['ptype_uniacid'] = $_W['uniacid'];
					if (empty($ptype['ptype_id'])) {
						unset($ptype['ptype_id']);
						$ptype['ptype_time_add'] = nowDate;
						$result = pdo_insert($this->tb_ptype, $ptype);
						if ($result) {
							message('添加项目分类成功', $this->createWebUrl('ptype', array('op' => 'display')), 'success');
						}
					} else {
						$ptype['ptype_time_update'] = nowDate;
						$result = pdo_update($this->tb_ptype, $ptype, array('ptype_id' => $ptype['ptype_id']));
						if ($result) {
							message('修改项目分类成功', $this->createWebUrl('ptype', array('op' => 'display')), 'success');
						}
					}
				}
				$result = selectBusiness();
				$business = $result['records'];
				include $this->template('ptype_create');
			} else {
				if ($op == 'modify') {
					$ptype_id = $_GPC['id'];
					$ptype = pdo_get($this->tb_ptype, array('ptype_id' => $ptype_id, 'ptype_uniacid' => $_W['uniacid']));
					$result = selectBusiness();
					$business = $result['records'];
					include $this->template('ptype_create');
				} else {
					if ($op == 'delete') {
						$ptype_id = $_GPC['id'];
						if ($ptype_id) {
							$res = pdo_delete($this->tb_ptype, array('ptype_id' => $ptype_id, 'ptype_uniacid' => $_W['uniacid']));
							if ($res) {
								message('删除项目分类成功', $this->createWebUrl('ptype', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebProject()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['project']);
				}
				$_SESSION['search']['project'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['project'])) {
				$searchrecord = $_SESSION['search']['project'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectProject($option, 2);
			$projects = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$result = selectBusiness();
			$business = $result['records'];
			include $this->template('project_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['project'])) {
					$project = $_POST['project'];
					$project['project_uniacid'] = $_W['uniacid'];
					if (empty($project['project_id'])) {
						unset($project['project_id']);
						$project['project_time_add'] = nowDate;
						$project['project_time_update'] = nowDate;
						$result = pdo_insert($this->tb_project, $project);
						if ($result) {
							message('添加服务项目成功', $this->createWebUrl('project', array('op' => 'display')), 'success');
						}
					} else {
						$project['project_time_update'] = nowDate;
						$result = pdo_update($this->tb_project, $project, array('project_id' => $project['project_id']));
						if ($result) {
							message('修改服务项目成功', $this->createWebUrl('project', array('op' => 'display')), 'success');
						}
					}
				}
				$result = selectBusiness();
				$business = $result['records'];
				include $this->template('project_create');
			} else {
				if ($op == 'modify') {
					$project_id = $_GPC['id'];
					$project = pdo_get($this->tb_project, array('project_id' => $project_id, 'project_uniacid' => $_W['uniacid']));
					$result = selectBusiness();
					$business = $result['records'];
					$ptypes = pdo_getall($this->tb_ptype, array('ptype_businessid' => $project['project_businessid'], 'ptype_uniacid' => $_W['uniacid']));
					include $this->template('project_create');
				} else {
					if ($op == 'delete') {
						$project_id = $_GPC['id'];
						if ($project_id) {
							$res = pdo_delete($this->tb_project, array('project_id' => $project_id, 'project_uniacid' => $_W['uniacid']));
							if ($res) {
								message('服务项目删除成功', $this->createWebUrl('project', array('op' => 'display')), 'success');
							}
						}
					} else {
						if ($op == 'look') {
							$project_id = $_GPC['id'];
							$state = $_GPC['look'];
							$update = pdo_update($this->tb_project, array('project_state' => $state), array('project_id' => $project_id));
							if ($update) {
								if ($state == 2) {
									message('项目已通过审核', $this->createWebUrl('project', array('op' => 'display')), 'success');
								} else {
									message('项目已禁止', $this->createWebUrl('project', array('op' => 'display')), 'warning');
								}
							}
						} else {
							if ($op == 'ptype') {
								$business_id = $_GPC['business'];
								$ptypes = pdo_getall($this->tb_ptype, array('ptype_businessid' => $business_id, 'ptype_uniacid' => $_W['uniacid']));
								$str = makePtypeToOption($ptypes);
								echo $str;
							}
						}
					}
				}
			}
		}
	}
	public function doWebStaff()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['staff']);
				}
				$_SESSION['search']['staff'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['staff'])) {
				$searchrecord = $_SESSION['search']['staff'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectStaff($option, 2);
			$staffs = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$result = selectBusiness();
			$business = $result['records'];
			include $this->template('staff_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['staff'])) {
					$staff = $_POST['staff'];
					$staff['staff_gender'] = $_POST['gender'];
					$staff['staff_uniacid'] = $_W['uniacid'];
					if (empty($staff['staff_id'])) {
						unset($staff['staff_id']);
						$staff['staff_time_add'] = nowDate;
						$staff['staff_time_update'] = nowDate;
						$res = pdo_insert($this->tb_staff, $staff);
						if ($res) {
							message('添加员工成功', $this->createWebUrl('staff', array('op' => 'display')), 'success');
						}
					} else {
						$staff['staff_time_update'] = nowDate;
						$res = pdo_update($this->tb_staff, $staff, array('staff_id' => $staff['staff_id']));
						if ($res) {
							message('修改员工成功', $this->createWebUrl('staff', array('op' => 'display')), 'success');
						}
					}
				}
				$result = selectBusiness();
				$business = $result['records'];
				include $this->template('staff_create');
			} else {
				if ($op == 'modify') {
					$staff_id = $_GPC['id'];
					if ($staff_id) {
						$staff = pdo_get($this->tb_staff, array('staff_id' => $staff_id, 'staff_uniacid' => $_W['uniacid']));
					}
					$result = selectBusiness();
					$business = $result['records'];
					include $this->template('staff_create');
				} else {
					if ($op == 'delete') {
						$staff_id = $_GPC['id'];
						if ($staff_id) {
							$res = pdo_delete($this->tb_staff, array('staff_id' => $staff_id, 'staff_uniacid' => $_W['uniacid']));
							if ($res) {
								message('删除服务员工成功', $this->createWebUrl('staff', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebAjaxFans()
	{
		global $_W, $_GPC;
		$content = $_GPC['content'];
		$result = selectFansAndMember($content);
		$str = makeSearchToStr($result);
		echo $str;
	}
	public function doWebStore()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$storetype = pdo_getall($this->tb_storetype, array('storetype_uniacid' => $_W['uniacid'], 'storetype_type' => 2));
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['store']);
				}
				$_SESSION['search']['store'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['store'])) {
				$searchrecord = $_SESSION['search']['store'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectStore($option, 2);
			$stores = $result['records'];
			$stores = getCommentCount($stores);
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$result = selectCircle();
			$circles = $result['records'];
			$result = selectBusiness();
			$business = $result['records'];
			include $this->template('store_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['store'])) {
					$store = $_POST['store'];
					$store['store_uniacid'] = $_W['uniacid'];
					if (!empty($store['store_loc'])) {
						$store['store_log'] = $store['store_loc']['log'];
						$store['store_lat'] = $store['store_loc']['lat'];
					}
					unset($store['store_loc']);
					if (empty($store['store_id'])) {
						unset($store['store_id']);
						$store['store_time_add'] = nowDate;
						$store['store_time_update'] = nowDate;
						$res = pdo_insert($this->tb_store, $store);
						if ($res) {
							message('添加门店成功.', $this->createWebUrl('store', array('op' => 'display')), 'success');
						}
					} else {
						$store['store_time_update'] = nowDate;
						$res = pdo_update($this->tb_store, $store, array('store_id' => $store['store_id']));
						if ($res) {
							message('修改门店成功.', $this->createWebUrl('store', array('op' => 'display')), 'success');
						}
					}
				}
				$result = selectCircle();
				$circles = $result['records'];
				$result = selectBusiness();
				$business = $result['records'];
				$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
				$lat = 39.916527;
				$log = 116.397128;
				include $this->template('store_create');
			} else {
				if ($op == 'modify') {
					$store_id = $_GPC['id'];
					if (empty($store_id)) {
						message('未获取到门店信息', $this->createWebUrl('store', array()), 'error');
					}
					$store = pdo_get($this->tb_store, array('store_id' => $store_id, 'store_uniacid' => $_W['uniacid']));
					$result = selectCircle();
					$circles = $result['records'];
					$result = selectBusiness();
					$business = $result['records'];
					$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
					$lat = $store['store_lat'];
					$log = $store['store_log'];
					include $this->template('store_create');
				} else {
					if ($op == 'delete') {
						$store_id = $_GPC['id'];
						if (empty($store_id)) {
							message('未获取到门店信息', $this->createWebUrl('store', array()), 'error');
						}
						$res = pdo_delete($this->tb_store, array('store_id' => $store_id));
						if ($res) {
							message('删除门店成功', $this->createWebUrl('store', array('op' => 'display')), 'success');
						}
					}
				}
			}
		}
	}
	public function doWebAppointment()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['dating']);
				}
				$_SESSION['search']['dating'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['dating'])) {
				$searchrecord = $_SESSION['search']['dating'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectDating($option, 2);
			$datines = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$result = selectBusiness();
			$business = $result['records'];
			$result = selectStore();
			$stores = $result['records'];
			$result = selectStaff();
			$staffs = $result['records'];
			$result = selectProject();
			$projects = $result['records'];
			include $this->template('appointment_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['dating'])) {
					$dating = $_POST['dating'];
					$dating['dating_uniacid'] = $_W['uniacid'];
					$dating['dating_week'] = json_encode($dating['dating_week']);
					foreach ($dating['dating_time'] as $key => $item) {
						if (empty($item) || empty($item['start']) || empty($item['end'])) {
							unset($dating['dating_time'][$key]);
							continue;
						}
						if ($item['start'] >= $item['end']) {
							message('预约时间设置错误, 结束时间必须大于开始时间', '', 'error');
						}
						if (empty($item['count'])) {
							$dating['dating_time'][$key]['count'] = 1;
						}
					}
					$dating['dating_time'] = DatingTimeSort($dating['dating_time']);
					$dating['dating_time'] = json_encode($dating['dating_time']);
					if (empty($dating['dating_id'])) {
						unset($dating['dating_id']);
						$dating['dating_time_add'] = nowDate;
						$dating['dating_time_update'] = nowDate;
						$res = pdo_insert($this->tb_dating, $dating);
						if ($res) {
							message('添加预约设置成功.', $this->createWebUrl('appointment', array('op' => 'display')), 'success');
						}
					} else {
						$dating['dating_time_update'] = nowDate;
						$res = pdo_update($this->tb_dating, $dating, array('dating_id' => $dating['dating_id']));
						if ($res) {
							message('修改预约设置成功.', $this->createWebUrl('appointment', array('op' => 'display')), 'success');
						}
					}
				}
				$result = selectBusiness();
				$business = $result['records'];
				$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
				include $this->template('appointment_create');
			} else {
				if ($op == 'modify') {
					$dating_id = $_GPC['id'];
					if (!$dating_id) {
						message('未获取预约信息', $this->createWebUrl('appointment', array('display')), 'error');
					}
					$dating = pdo_get($this->tb_dating, array('dating_id' => $dating_id, 'dating_uniacid' => $_W['uniacid']));
					$dating['dating_week'] = json_decode($dating['dating_week'], true);
					$dating['dating_time'] = json_decode($dating['dating_time'], true);
					$result = selectBusiness();
					$business = $result['records'];
					$option1['search']['store_businessid'] = $dating['dating_businessid'];
					$result = selectStore($option1);
					$stores = $result['records'];
					$option2['search']['staff_businessid'] = $dating['dating_businessid'];
					$result = selectStaff($option2);
					$staffs = $result['records'];
					$option3['search']['project_businessid'] = $dating['dating_businessid'];
					$result = selectProject($option3);
					$projects = $result['records'];
					$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
					include $this->template('appointment_create');
				} else {
					if ($op == 'delete') {
						$dating_id = $_GPC['id'];
						if ($dating_id) {
							$res = pdo_delete($this->tb_dating, array('dating_id' => $dating_id, 'dating_uniacid' => $_W['uniacid']));
							if ($res) {
								message('删除预约成功.', $this->createWebUrl('appointment', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebGetDatingInfo()
	{
		global $_GPC, $_W;
		$businessid = $_GPC['businessid'];
		if (!empty($businessid)) {
			$stores = pdo_getall($this->tb_store, array('store_businessid' => $businessid, 'store_uniacid' => $_W['uniacid']));
			$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $businessid, 'staff_uniacid' => $_W['uniacid']));
			$projects = pdo_getall($this->tb_project, array('project_businessid' => $businessid, 'project_uniacid' => $_W['uniacid']));
		}
		$data['store'] = makeStoreToOption($stores);
		$data['staff'] = makeStaffToOption($staffs);
		$data['project'] = makeProjectToOption($projects);
		echo json_encode($data);
	}
	public function doWebRecord()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$base = getconfigbytype('type1', $this->tb_config);
		$ordercanceltime = $base['order_cancel_time'] != '' ? $base['order_cancel_time'] : 0;
		$ordercancel = $base['order_cancel'] != '' ? $base['order_cancel'] : 2;
		if ($ordercancel == 1 && $ordercanceltime != 0) {
			$olddate = date('Y-m-d H:i:s', strtotime('-' . $ordercanceltime . ' hours'));
			$nowdate = date('Y-m-d H:i:s');
			$sql = " update " . tablename($this->tb_order) . " set ";
			$sql .= " order_state = 5 ";
			$sql .= " where order_uniacid = " . $_W['uniacid'];
			$sql .= " and order_state = 1 ";
			$sql .= " and order_time_add < '" . $olddate . "'";
			pdo_query($sql);
		}
		if ($op == 'display') {
			session_start();
			$business = pdo_getall($this->tb_business, array('business_uniacid' => $_W['uniacid']));
			$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid']));
			$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid']));
			$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid']));
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['order']);
				}
				$_SESSION['search']['order'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['order'])) {
				$searchrecord = $_SESSION['search']['order'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			if ($_POST['excel'] == 1) {
				$result = selectOrder($option);
				$orders = $result['records'];
				$orders = dealOrders($orders, $business, $stores, $staffs, $projects);
				downloadRecord($orders);
			} else {
				$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
				$result = selectOrder($option);
				$orders = $result['records'];
				$total = $result['total'];
				unset($result);
				$page = pagination($total, $pindex, $psize);
				$orders = dealOrders($orders, $business, $stores, $staffs, $projects);
				load()->func('tpl');
				include $this->template('order_display');
			}
		} else {
			if ($op == 'create') {
				if (!empty($_POST['order'])) {
					$order = $_POST['order'];
					$order['order_uniacid'] = $_W['uniacid'];
					if (!empty($order['order_dating_time'])) {
						$time = explode('-', $order['order_dating_time']);
						$order['order_dating_start'] = $time[0];
						$order['order_dating_end'] = $time[1];
					}
					unset($order['order_dating_time']);
					$dating = pdo_get($this->tb_dating, array('dating_businessid' => $order['order_businessid'], 'dating_storeid' => $order['order_storeid'], 'dating_projectid' => $order['order_projectid'], 'dating_staffid' => $order['order_staffid'], 'dating_uniacid' => $_W['uniacid']));
					if (empty($dating)) {
						message('未获取到预约信息', '', 'error');
					}
					$dating['dating_time'] = json_decode($dating['dating_time'], true);
					$order_count = pdo_getall($this->tb_order, array('order_storeid' => $dating['dating_storeid'], 'order_projectid' => $dating['dating_projectid'], 'order_staffid' => $dating['dating_staffid'], 'order_dating_day' => $order['order_dating_day'], 'order_dating_start' => $order['order_dating_start'], 'order_dating_end' => $order['order_dating_end'], 'order_uniacid' => $_W['uniacid'], 'order_state <' => 2, 'order_id !=' => $order['order_id']), array('order_id'));
					foreach ($dating['dating_time'] as $key => $item) {
						if ($item['start'] == $order['order_dating_start'] && $item['end'] == $order['order_dating_end']) {
							if ($item['count'] <= count($order_count)) {
								message('当前时段预约人次已满, 请选择其他时段', '', 'error');
							}
						}
					}
					if (empty($order['order_id'])) {
						unset($order['order_id']);
						$order['order_time_add'] = nowDate;
						$order['order_time_update'] = nowDate;
						if ($order['order_pay_type'] == 2) {
							if ($_POST['send_state'] == 2) {
								$order['order_notice'] = 2;
							} else {
								$order['order_notice'] = 1;
							}
						} else {
							$order['order_notice'] = 2;
						}
						$res = pdo_insert($this->tb_order, $order);
						if ($res) {
							if ($_POST['send_state'] == 2) {
								$notice = getconfigbytype('type5', $this->tb_config);
								if ($notice['notice_way'] == 1) {
									$this->sendTpl($order['order_number']);
								} else {
									if ($notice['notice_way'] == 2) {
										$this->sendCustom($order['order_number']);
									} else {
										if ($notice['notice_way'] == 3) {
											$this->sendMessage($order['order_number']);
										}
									}
								}
							}
							message('添加预约订单成功.', $this->createWebUrl('record', array('op' => 'display')), 'success');
						}
					} else {
						$order['order_time_update'] = nowDate;
						$res = pdo_update($this->tb_order, $order, array('order_id' => $order['order_id']));
						if ($res) {
							if ($_POST['send_state'] == 2) {
								$notice = getconfigbytype('type5', $this->tb_config);
								if ($notice['notice_way'] == 1) {
									$this->sendTpl($order['order_number']);
								} else {
									if ($notice['notice_way'] == 2) {
										$this->sendCustom($order['order_number']);
									} else {
										if ($notice['notice_way'] == 3) {
											$this->sendMessage($order['order_number']);
										}
									}
								}
							}
							message('修改预约订单成功.', $this->createWebUrl('record', array('op' => 'display')), 'success');
						}
					}
				}
				$business = pdo_getall($this->tb_business, array('business_uniacid' => $_W['uniacid']));
				$number = getOrderNumber();
				if ($number == false) {
					message('订单异常请稍后再试', '', 'error');
				}
				include $this->template('order_create');
			} else {
				if ($op == 'modify') {
					$order_id = $_GPC['id'];
					if (empty($order_id)) {
						message('未获取到门店信息', $this->createWebUrl('record', array()), 'error');
					}
					$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']));
					$result = selectBusiness();
					$business = $result['records'];
					$stores = pdo_getall($this->tb_store, array('store_businessid' => $order['order_businessid'], 'store_uniacid' => $_W['uniacid']));
					$projects = pdo_getall($this->tb_project, array('project_businessid' => $order['order_businessid'], 'project_uniacid' => $_W['uniacid']));
					$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $order['order_businessid'], 'staff_uniacid' => $_W['uniacid']));
					$dating = pdo_get($this->tb_dating, array('dating_businessid' => $order['order_businessid'], 'dating_storeid' => $order['order_storeid'], 'dating_projectid' => $order['order_projectid'], 'dating_staffid' => $order['order_staffid'], 'dating_uniacid' => $_W['uniacid']));
					$dating['dating_week'] = json_decode($dating['dating_week']);
					$week = date('Y-m-d');
					$weeks = riqi($week);
					foreach ($weeks as $key => $item) {
						if (!in_array($key, $dating['dating_week'])) {
							unset($weeks[$key]);
						}
					}
					$dating['dating_time'] = json_decode($dating['dating_time'], true);
					$time_count = getTimeCount($dating, $order['order_dating_day']);
					if (!empty($order['order_id'])) {
						$order['time'] = $order['order_dating_start'] . '-' . $order['order_dating_end'];
					}
					$number = $order['order_number'];
					include $this->template('order_create');
				} else {
					if ($op == 'delete') {
						$order_id = $_GPC['id'];
						if (empty($order_id)) {
							message('未获取订单信息', $this->createWebUrl('record', array()), 'error');
						}
						$res = pdo_delete($this->tb_order, array('order_id' => $order_id));
						if ($res) {
							message('删除预约记录功', $this->createWebUrl('record', array('op' => 'display')), 'success');
						}
					} else {
						if ($op == 'settle') {
							$order_id = $_GPC['id'];
							$res = pdo_update($this->tb_order, array('order_settlement' => 2), array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']));
							if (!empty($res)) {
								message('订单结算成功', $this->createWebUrl('record'), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebGetDayInfo()
	{
		global $_GPC, $_W;
		$businessid = $_GPC['businessid'];
		$storeid = $_GPC['storeid'];
		$projectid = $_GPC['projectid'];
		$staffid = $_GPC['staffid'];
		$dating = pdo_get($this->tb_dating, array('dating_businessid' => $businessid, 'dating_storeid' => $storeid, 'dating_projectid' => $projectid, 'dating_staffid' => $staffid, 'dating_uniacid' => $_W['uniacid']));
		if (empty($dating)) {
			$data['result'] = 'fail';
			$data['error'] = "未获取到预约信息, 请检查是否设置此类预约";
		} else {
			$dating['dating_week'] = json_decode($dating['dating_week'], true);
			$week = date('Y-m-d');
			$weeks = riqi($week);
			foreach ($weeks as $key => $item) {
				if (!in_array($key, $dating['dating_week'])) {
					unset($weeks[$key]);
				}
			}
			$daystr = makeDayToOption($weeks);
			$data['result'] = 'success';
			$data['day'] = $daystr;
		}
		echo json_encode($data);
	}
	public function doWebGetTimeInfo()
	{
		global $_GPC, $_W;
		$businessid = $_GPC['businessid'];
		$storeid = $_GPC['storeid'];
		$projectid = $_GPC['projectid'];
		$staffid = $_GPC['staffid'];
		$day = $_GPC['day'];
		$dating = pdo_get($this->tb_dating, array('dating_businessid' => $businessid, 'dating_storeid' => $storeid, 'dating_projectid' => $projectid, 'dating_staffid' => $staffid, 'dating_uniacid' => $_W['uniacid']));
		if (empty($dating)) {
			$data['result'] = 'fail';
			$data['error'] = "未获取到预约信息, 请检查是否设置此类预约";
		} else {
			$dating['dating_time'] = json_decode($dating['dating_time'], true);
			$time_count = getTimeCount($dating, $day);
			$timestr = makeTimeToOption($dating['dating_time'], $time_count);
			$data['result'] = 'success';
			$data['time'] = $timestr;
		}
		echo json_encode($data);
	}
	public function doWebAd()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'manage' : $_GPC['op'];
		if ($op == 'manage') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectAd($option);
			$ads = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			include $this->template('ad_manage');
		} else {
			if ($op == 'create') {
				if ($_POST['ad']) {
					$ad = $_POST['ad'];
					$ad['ad_uniacid'] = $_W['uniacid'];
					if (empty($ad['ad_id'])) {
						$ad['ad_time_add'] = DATE_NOW;
						$ad['ad_time_update'] = DATE_NOW;
						$result = pdo_insert($this->tb_ad, $ad);
						if ($result) {
							message('添加广告成功', $this->createWebUrl('ad', array('op' => 'manage')), 'success');
						}
					} else {
						$ad['ad_time_update'] = DATE_NOW;
						$result = pdo_update($this->tb_ad, $ad, array('ad_id' => $ad['ad_id']));
						if ($result) {
							message('修改广告成功', $this->createWebUrl('ad', array('op' => 'manage')), 'success');
						}
					}
				}
				include $this->template('ad_create');
			} else {
				if ($op == 'modify') {
					$ad_id = $_GPC['id'];
					$option['search']['ad_id'] = $ad_id;
					$result = selectAd($option);
					$ad = end($result['records']);
					include $this->template('ad_create');
				} else {
					if ($op == 'delete') {
						$ad_id = $_GPC['id'];
						$result = pdo_delete($this->tb_ad, array('ad_id' => $ad_id));
						if ($result) {
							message('删除广告成功', $this->createWebUrl('ad', array('op' => 'manage')), 'success');
						}
					}
				}
			}
		}
	}
	public function doWebCard()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			if (!empty($_POST['card'])) {
				$card = $_POST['card'];
				$card['card_uniacid'] = $_W['uniacid'];
				if ($card['card_id']) {
					$res = pdo_update($this->tb_card, $card, array('card_id' => $card['card_id']));
					if ($res) {
						message('会员卡修改成功', $this->createWebUrl('card'), 'success');
					}
				} else {
					unset($card['card_id']);
					$res = pdo_insert($this->tb_card, $card);
					if ($res) {
						message('添加会员成功', $this->createWebUrl('card'), 'success');
					}
				}
			}
			$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
			include $this->template('card');
		} else {
			if ($op == 'vip_display') {
				session_start();
				$pindex = max(1, intval($_GPC['page']));
				$psize = 20;
				if (!empty($_POST['search'])) {
					if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
						$pindex = 1;
						unset($_SESSION['search']['vip']);
					}
					$_SESSION['search']['vip'] = $_GPC['search'];
				}
				$searchrecord = array();
				if (isset($_SESSION['search']['vip'])) {
					$searchrecord = $_SESSION['search']['vip'];
				}
				$search = $searchrecord;
				$option['search'] = $searchrecord;
				$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
				$result = selectVip($option, 2);
				$vips = $result['records'];
				$total = $result['total'];
				unset($result);
				$page = pagination($total, $pindex, $psize);
				include $this->template('vip_display');
			} else {
				if ($op == 'vip_create') {
					if (!empty($_POST['vip'])) {
						$vip = $_GPC['vip'];
						$vip['vip_uniacid'] = $_W['uniacid'];
						$vip['vip_credit_state'] = $vip['vip_pay'];
						if (empty($vip['vip_id'])) {
							unset($vip['vip_id']);
							$vip['vip_time_add'] = nowDate;
							$res = pdo_insert($this->tb_vip, $vip);
							if (!empty($res)) {
								message('添加会员成功', $this->createWebUrl('card', array('op' => 'vip_display')), 'success');
							}
						} else {
							$vip['vip_time_update'] = nowDate;
							$res = pdo_update($this->tb_vip, $vip, array('vip_id' => $vip['vip_id']));
							if (!empty($res)) {
								message('更新会员成功', $this->createWebUrl('card', array('op' => 'vip_display')), 'success');
							}
						}
					}
					$cards = pdo_getall($this->tb_card, array('card_uniacid' => $_W['uniacid']));
					$vip['vip_number'] = getVipNumber();
					if (!$vip['vip_number']) {
						message('订单异常, 请稍后再试', '', 'error');
					}
					include $this->template('vip_create');
				} else {
					if ($op == 'vip_modify') {
						$vip_id = $_GPC['id'];
						$vip = pdo_get($this->tb_vip, array('vip_id' => $vip_id, 'vip_uniacid' => $_W['uniacid']));
						$cards = pdo_getall($this->tb_card, array('card_uniacid' => $_W['uniacid']));
						include $this->template('vip_create');
					} else {
						if ($op == 'vip_delete') {
							$vip_id = $_GPC['id'];
							$res = pdo_delete($this->tb_vip, array('vip_id' => $vip_id, 'vip_uniacid' => $_W['uniacid']));
							if (!empty($res)) {
								message('删除会员成功', $this->createWebUrl('card', array('op' => 'vip_display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doWebstoretype()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$sql = " select * from " . tablename('wxlm_appointment_storetype');
		$sql .= " where storetype_uniacid = " . $_W['uniacid'];
		$sql .= " order by storetype_order desc ";
		$sql .= " limit 1 ";
		$orderlist = pdo_fetch($sql);
		$maxorder = empty($orderlist) ? 1 : $orderlist['storetype_order'] + 1;
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['storetype']);
				}
				$_SESSION['search']['storetype'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['storetype'])) {
				$searchrecord = $_SESSION['search']['storetype'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectStoretype($option);
			$storetype = $result['records'];
			foreach ($storetype as $k => $v) {
			}
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$result = selectCircle();
			$circles = $result['records'];
			$result = selectBusiness();
			$business = $result['records'];
			include $this->template('storetype_display');
		}
		if ($op == 'create') {
			if (checksubmit()) {
				$formrs = $_GPC['storetype'];
				$formrs['storetype_uniacid'] = $_W['uniacid'];
				$storetype_id = $formrs['storetype_id'];
				$_SESSION['form']['storetype'] = $formrs;
				unset($formrs['product_id']);
				if ($storetype_id != '') {
					$check_where['storetype_id !='] = $storetype_id;
				}
				$check_where['storetype_title'] = $formrs['storetype_title'];
				$storetype_check_list = pdo_get($this->tb_storetype, $check_where);
				if (!empty($storetype_check_list)) {
					message('类型名称已存在', $this->createWebUrl('storetype', array('op' => 'create', 'savesession' => 1)), 'error');
					die;
				}
				if ($storetype_id == "") {
					$formrs['storetype_time_add'] = date("Y-m-d h:i:s");
					$formrs['storetype_time_update'] = date("Y-m-d h:i:s");
					$result = pdo_insert($this->tb_storetype, $formrs);
					if ($result) {
						message('类型添加成功', $this->createWebUrl('storetype', array('op' => 'create')), 'success');
					} else {
						message('类型添加失败', $this->createWebUrl('storetype', array('op' => 'create', 'savesession' => 1)), 'error');
					}
				} else {
					$formrs['storetype_time_update'] = date("Y-m-d h:i:s");
					$result = pdo_update($this->tb_storetype, $formrs, array('storetype_id' => $storetype_id));
					if ($result) {
						message('类型修改成功', $this->createWebUrl('storetype', array('op' => 'display')), 'success');
					} else {
						message('类型修改失败', $this->createWebUrl('storetype', array('op' => 'create', 'savesession' => 1)), 'error');
					}
				}
			}
			if ($_GPC['savesession'] == 1) {
				$storetype = $_SESSION['form']['storetype'];
			} else {
				$storetypeid = $_GPC['storetype_id'];
				$storetype = array();
				if ($storetypeid != "") {
					$storetype = pdo_get($this->tb_storetype, array('storetype_uniacid' => $_W['uniacid'], 'storetype_id' => $storetypeid));
				}
			}
			load()->func('tpl');
			include $this->template('storetype_create');
		}
		if ($op == 'delete') {
			$storetype_id = $_GPC['storetype_id'];
			if (empty($storetype_id)) {
				message('未获取到类型信息', $this->createWebUrl('storetype', array()), 'error');
			}
			$res = pdo_delete($this->tb_storetype, array('storetype_id' => $storetype_id));
			if ($res) {
				message('删除门店成功', $this->createWebUrl('store', array('op' => 'display')), 'success');
			}
		}
	}
	public function doWebComment()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$store = pdo_get($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_id' => $_GPC['store_id']));
			if (empty($store)) {
				message('未获取到门店信息', '', 'error');
			}
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['comment']);
				}
				$_SESSION['search']['comment'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['comment'])) {
				$searchrecord = $_SESSION['search']['comment'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['comment_storeid'] = $store['store_id'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectComment($option);
			$comment = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			include $this->template('comment_display');
		}
		if ($op == 'changestate') {
			$base = getconfigbytype('type1', $this->tb_config);
			$cretid1 = $base['comment_cretid1'] != '' ? $base['comment_cretid1'] : 0;
			$commentstate = $base['comment_state'] != '' ? $base['comment_state'] : 2;
			$comment_id = $_GPC['comment_id'];
			$state = isset($_GPC['commentstate']) ? $_GPC['commentstate'] : 1;
			if ($comment_id == '') {
				$data['rs'] = '未获取到评论信息';
				$data['result'] = 'error';
				echo json_encode($data);
				die;
			}
			$comment_list = pdo_get($this->tb_comment, array('comment_uniacid' => $_W['uniacid'], 'comment_id' => $comment_id));
			if (empty($comment_list)) {
				$data['rs'] = '未获取到评论信息';
				$data['result'] = 'error';
				echo json_encode($data);
				die;
			}
			$result = pdo_update($this->tb_comment, array('comment_state' => $state), array('comment_uniacid' => $_W['uniacid'], 'comment_id' => $comment_id));
			if ($commentstate == 1 && $cretid1 != 0) {
				load()->model('mc');
				$fansuid = mc_openid2uid($comment_list['comment_openid']);
				mc_credit_update($fansuid, 'credit1', $cretid1, array($fansuid, "预约系统", 'wxlm_appointment'));
			}
			if ($result) {
				$data['rs'] = $state;
				$data['result'] = 'success';
			} else {
				$data['rs'] = '审核状态更改失败！';
				$data['result'] = 'error';
			}
			echo json_encode($data);
			die;
		}
		if ($op == 'delete') {
			$comment_id = $_GPC['comment_id'];
			$store_id = $_GPC['store_id'];
			if ($comment_id == '') {
				message('未获取到评论信息', $this->createWebUrl('comment'), 'error');
			}
			$res = pdo_delete($this->tb_comment, array('comment_id' => $comment_id, 'comment_uniacid' => $_W['uniacid']));
			if ($res) {
				message('评论信息已清理', $this->createWebUrl('comment', array('store_id' => $store_id)), 'success');
			}
		}
	}
	public function doWebWarning()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'one' : $_GPC['op'];
		if ($op == 'one') {
			$warning_time = time() - 30 * 24 * 60 * 60;
		} else {
			if ($op == 'two') {
				$warning_time = time() - 60 * 24 * 60 * 60;
			} else {
				if ($op == 'three') {
					$warning_time = time() - 90 * 24 * 60 * 60;
				}
			}
		}
		$sql = 'select * from ' . tablename($this->tb_archive) . " where archive_uniacid = " . $_W['uniacid'];
		$archives = pdo_fetchall($sql);
		$list = array();
		foreach ($archives as $key => $item) {
			$sql_lasttime = "select max(consume_date) from " . tablename($this->tb_consume) . " where consume_archiveid = :archiveid and consume_uniacid = :uniacid ";
			$item['lasttime'] = pdo_fetchcolumn($sql_lasttime, array(':archiveid' => $item['archive_id'], ':uniacid' => $_W['uniacid']));
			if (strtotime($item['lasttime']) >= $warning_time) {
				continue;
			}
			$list[] = $item;
		}
		include $this->template('warning_display');
	}
	public function doWebRefund()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$business = pdo_getall($this->tb_business, array('business_uniacid' => $_W['uniacid']));
			$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid']));
			$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid']));
			$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid']));
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['refund']);
				}
				$_SESSION['search']['refund'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['refund'])) {
				$searchrecord = $_SESSION['search']['refund'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectrefund($option);
			$orders = $result['records'];
			$orders = dealOrders($orders, $business, $stores, $staffs, $projects);
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$result = selectCircle();
			$circles = $result['records'];
			$result = selectBusiness();
			$business = $result['records'];
			include $this->template('orderrefund_display');
		}
		if ($op == 'changestate') {
			$orderrefund_id = $_GPC['id'];
			$orderrefund_list = pdo_get($this->tb_orderrefund, array('orderrefund_uniacid' => $_W['uniacid'], 'orderrefund_id' => $orderrefund_id));
			if (empty($orderrefund_list)) {
				message('没有获取到有效的退款记录', $this->createWebUrl('refund'), 'success');
			}
			$order_list = pdo_get($this->tb_order, array('order_uniacid' => $_W['uniacid'], 'order_number' => $orderrefund_list['orderrefund_number']));
			if (empty($order_list)) {
				message('没有获取到预约记录', $this->createWebUrl('refund'), 'success');
			}
			$pay = getconfigbytype("type2", $this->tb_config);
			if ($order_list['order_pay_state'] == 1) {
				pdo_update($this->tb_order, array('order_state' => 4), array('order_id' => $order_list['order_id']));
				pdo_update($this->tb_orderrefund, array('orderrefund_state' => 2), array('orderrefund_id' => $orderrefund_list['orderrefund_id']));
				message('退款成功', $this->createWebUrl('refund'), 'success');
			}
			if ($order_list['order_pay_state'] == 2) {
				message('暂不支持退款', $this->createWebUrl('refund'), 'error');
				die;
			}
			if ($order_list['order_pay_state'] == 3) {
				$url = 'http://www.zwechat.com/weixinpay/index.php/Fanqiejia/refund?b_id=' . $pay['b_id'] . '&bm_id=' . $pay['bm_id'] . '&s_no=' . $order_list['order_paynumber'];
				$result = _request($url);
				$result = json_decode($result, true);
				if ($result['status'] == 'success') {
					pdo_update($this->tb_order, array('order_state' => 4), array('order_id' => $order_list['order_id']));
					pdo_update($this->tb_orderrefund, array('orderrefund_state' => 2), array('orderrefund_id' => $orderrefund_list['orderrefund_id']));
					message('退款成功', $this->createWebUrl('refund'), 'success');
				} else {
					if ($result['msg'] == '此订单已经退款了') {
						pdo_update($this->tb_order, array('order_state' => 4), array('order_id' => $order_list['order_id']));
						pdo_update($this->tb_orderrefund, array('orderrefund_state' => 2), array('orderrefund_id' => $orderrefund_list['orderrefund_id']));
					}
					message($result['msg'], $this->createWebUrl('refund'), 'success');
				}
			}
		}
		if ($op == 'delete') {
			$comment_id = $_GPC['comment_id'];
			if ($comment_id == '') {
				message('未获取到评论信息', $this->createWebUrl('comment'), 'error');
			}
			$res = pdo_delete($this->tb_comment, array('comment_id' => $comment_id, 'comment_uniacid' => $_W['uniacid']));
			if ($res) {
				message('评论信息已清理', $this->createWebUrl('comment'), 'success');
			}
		}
	}
	public function doWebShow()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'show_display' : $_GPC['op'];
		if ($op == 'show_display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['show']);
				}
				$_SESSION['search']['show'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['show'])) {
				$searchrecord = $_SESSION['search']['show'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectShow($option);
			$shows = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			$result = selectShowType();
			$showtypes = $result['records'];
			unset($result);
			include $this->template('show_display');
		} else {
			if ($op == 'show_create') {
				if ($_POST['show']) {
					$show = $_POST['show'];
					$show['show_uniacid'] = $_W['uniacid'];
					if (empty($show['show_id'])) {
						$show['show_time_add'] = nowDate;
						$result = pdo_insert($this->tb_show, $show);
						if ($result) {
							message('添加作品成功', $this->createWebUrl('show', array('op' => 'show_display')), 'success');
						}
					} else {
						$show['show_time_update'] = nowDate;
						$result = pdo_update($this->tb_show, $show, array('show_id' => $show['show_id']));
						if ($result) {
							message('修改作品成功', $this->createWebUrl('show', array('op' => 'show_display')), 'success');
						}
					}
				}
				$result = selectShowType();
				$showtypes = $result['records'];
				unset($result);
				include $this->template('show_create');
			} else {
				if ($op == 'show_modify') {
					$id = $_GPC['id'];
					$show = pdo_get($this->tb_show, array('show_id' => $id, 'show_uniacid' => $_W['uniacid']));
					if (empty($show)) {
						message('未获取到作品信息', $this->createWebUrl('show', array('op' => 'show_display')), 'error');
					}
					$result = selectShowType();
					$showtypes = $result['records'];
					unset($result);
					include $this->template('show_create');
				} else {
					if ($op == 'show_delete') {
						$id = $_GPC['id'];
						$res = pdo_delete($this->tb_show, array('show_id' => $id));
						if (!empty($res)) {
							message('删除作品成功', $this->createWebUrl('show', array('op' => 'show_display')), 'success');
						} else {
							message('删除作品失败', $this->createWebUrl('show', array('op' => 'show_display')), 'error');
						}
					} else {
						if ($op == 'type_display') {
							session_start();
							$pindex = max(1, intval($_GPC['page']));
							$psize = 20;
							if (!empty($_POST['search'])) {
								if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
									$pindex = 1;
									unset($_SESSION['search']['showtype']);
								}
								$_SESSION['search']['showtype'] = $_GPC['search'];
							}
							$searchrecord = array();
							if (isset($_SESSION['search']['showtype'])) {
								$searchrecord = $_SESSION['search']['showtype'];
							}
							$search = $searchrecord;
							$option['search'] = $searchrecord;
							$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
							$result = selectShowType($option);
							$showtypes = $result['records'];
							$total = $result['total'];
							unset($result);
							$page = pagination($total, $pindex, $psize);
							include $this->template('showtype_display');
						} else {
							if ($op == 'type_create') {
								if ($_POST['showtype']) {
									$showtype = $_POST['showtype'];
									$showtype['showtype_uniacid'] = $_W['uniacid'];
									if (empty($showtype['showtype_id'])) {
										$showtype['showtype_time_add'] = nowDate;
										$result = pdo_insert($this->tb_showtype, $showtype);
										if ($result) {
											message('添加作品分类成功', $this->createWebUrl('show', array('op' => 'type_display')), 'success');
										}
									} else {
										$showtype['showtype_time_update'] = nowDate;
										$result = pdo_update($this->tb_showtype, $showtype, array('showtype_id' => $showtype['showtype_id']));
										if ($result) {
											message('修改作品分类成功', $this->createWebUrl('show', array('op' => 'type_display')), 'success');
										}
									}
								}
								include $this->template('showtype_create');
							} else {
								if ($op == 'type_modify') {
									$id = $_GPC['id'];
									$showtype = pdo_get($this->tb_showtype, array('showtype_id' => $id, 'showtype_uniacid' => $_W['uniacid']));
									if (empty($showtype)) {
										message('未获取到作品信息', $this->createWebUrl('show', array('op' => 'type_display')), 'error');
									}
									include $this->template('showtype_create');
								} else {
									if ($op == 'type_delete') {
										$id = $_GPC['id'];
										$res = pdo_delete($this->tb_showtype, array('showtype_id' => $id));
										if (!empty($res)) {
											message('删除作品成功', $this->createWebUrl('show', array('op' => 'showtype')), 'success');
										} else {
											message('删除作品失败', $this->createWebUrl('show', array('op' => 'showtype')), 'error');
										}
									}
								}
							}
						}
					}
				}
			}
		}
	}
	public function doWebArchive()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['archive']);
				}
				$_SESSION['search']['archive'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['archive'])) {
				$searchrecord = $_SESSION['search']['archive'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectArchive($option);
			$archives = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid']));
			include $this->template('archive_display');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$archive = $_POST['archive'];
					$archive['archive_uniacid'] = $_W['uniacid'];
					if (!empty($archive['archive_admin'])) {
						$archive['archive_admin'] = implode(',', $archive['archive_admin']);
					}
					if (empty($archive['archive_id'])) {
						$archive['archive_time_add'] = nowDate;
						$result = pdo_insert($this->tb_archive, $archive);
						if ($result) {
							message('添加档案成功', $this->createWebUrl('archive', array('op' => 'display')), 'success');
						}
					} else {
						$archive['archive_time_update'] = nowDate;
						$result = pdo_update($this->tb_archive, $archive, array('archive_id' => $archive['archive_id']));
						if ($result) {
							message('修改档案成功', $this->createWebUrl('archive', array('op' => 'display')), 'success');
						}
					}
				}
				$id = $_GPC['archive_id'];
				$archive = pdo_get($this->tb_archive, array('archive_id' => $id));
				if (!empty($archive)) {
					$archive['archive_admin'] = explode(',', $archive['archive_admin']);
				}
				$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid']));
				include $this->template('archive_create');
			} else {
				if ($op == 'delete') {
					$id = $_GPC['id'];
					$res = pdo_delete($this->tb_archive, array('archive_id' => $id));
					if (!empty($res)) {
						message('删除档案成功!', $this->createWebUrl('archive', array('op' => 'display')), 'success');
					} else {
						message('删除档案失败', $this->createWebUrl('archive', array('op' => 'display')), 'error');
					}
				}
			}
		}
	}
	public function doWebConsume()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$archive_id = $_GPC['archive_id'];
			$archive = pdo_get($this->tb_archive, array('archive_id' => $archive_id));
			if (empty($archive)) {
				message('未获取到档案信息', $this->createWebUrl('archive'), 'error');
			}
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['consume']);
				}
				$_SESSION['search']['consume'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['consume'])) {
				$searchrecord = $_SESSION['search']['consume'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['consume_archiveid'] = $archive_id;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectConsume($option);
			$consumes = $result['records'];
			$total = $result['total'];
			unset($result);
			foreach ($consumes as $key => $item) {
				$staff = pdo_get($this->tb_staff, array('staff_id' => $item['consume_staffid']), array('staff_name'));
				$consumes[$key]['staff_name'] = $staff['staff_name'];
				$store = pdo_getcolumn($this->tb_store, array('store_id' => $item['consume_storeid']), 'store_name');
				$consumes[$key]['store_name'] = $store;
				$item['consume_projectid'] = explode(',', $item['consume_projectid']);
				foreach ($item['consume_projectid'] as $value) {
					$consumes[$key]['project'][] = pdo_getcolumn($this->tb_project, array('project_id' => $value), 'project_name');
				}
			}
			$page = pagination($total, $pindex, $psize);
			$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid']));
			$sql = "select sum(consume_price) from " . tablename($this->tb_consume) . " where consume_uniacid = :uniacid and consume_archiveid = :archiveid";
			$total_price = pdo_fetchcolumn($sql, array(':uniacid' => $_W['uniacid'], ':archiveid' => $archive_id));
			include $this->template('consume_display');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$archive = $_POST['archive'];
					$archive['archive_uniacid'] = $_W['uniacid'];
					if (!empty($archive['archive_admin'])) {
						$archive['archive_admin'] = implode(',', $archive['archive_admin']);
					}
					if (empty($archive['archive_id'])) {
						$archive['archive_time_add'] = nowDate;
						$result = pdo_insert($this->tb_archive, $archive);
						if ($result) {
							message('添加档案成功', $this->createWebUrl('archive', array('op' => 'display')), 'success');
						}
					} else {
						$archive['archive_time_update'] = nowDate;
						$result = pdo_update($this->tb_archive, $archive, array('archive_id' => $archive['archive_id']));
						if ($result) {
							message('修改档案成功', $this->createWebUrl('archive', array('op' => 'display')), 'success');
						}
					}
				}
				$id = $_GPC['archive_id'];
				$archive = pdo_get($this->tb_archive, array('archive_id' => $id));
				if (!empty($archive)) {
					$archive['archive_admin'] = explode(',', $archive['archive_admin']);
				}
				$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid']));
				include $this->template('archive_create');
			} else {
				if ($op == 'delete') {
					$id = $_GPC['id'];
					$res = pdo_delete($this->tb_consume, array('id' => $id));
					if (!empty($res)) {
						message('删除消费记录成功!', $this->createWebUrl('consume', array('op' => 'display', 'archive_id' => $_GPC['archive_id'])), 'success');
					}
				}
			}
		}
	}
	public function doWebVisittype()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['visittype']);
				}
				$_SESSION['search']['visittype'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['visittype'])) {
				$searchrecord = $_SESSION['search']['visittype'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectVisittype($option, $this->tb_visittype);
			$visittypes = $result['records'];
			$total = $result['total'];
			unset($result);
			foreach ($visittypes as $key => $item) {
				$sql = "SELECT COUNT(*) FROM " . tablename($this->tb_visittpl) . " WHERE visittpl_uniacid = :uniacid and visittpl_typeid = :typeid";
				$params = array(':uniacid' => $_W['uniacid'], ':typeid' => $item['visittype_id']);
				$visittypes[$key]['visittype_count'] = pdo_fetchcolumn($sql, $params);
			}
			$page = pagination($total, $pindex, $psize);
			include $this->template('visittype_display');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$visittype = $_POST['visittype'];
					$visittype['visittype_uniacid'] = $_W['uniacid'];
					if (empty($visittype['visittype_id'])) {
						$visittype['visittype_time_add'] = nowDate;
						$result = pdo_insert($this->tb_visittype, $visittype);
						if ($result) {
							message('添加回访模板分类成功', $this->createWebUrl('visittype', array('op' => 'display')), 'success');
						}
					} else {
						$visittype['visittype_time_update'] = nowDate;
						$result = pdo_update($this->tb_visittype, $visittype, array('visittype_id' => $visittype['visittype_id']));
						if ($result) {
							message('修改回访模板分类成功', $this->createWebUrl('visittype', array('op' => 'display')), 'success');
						}
					}
				}
				$id = $_GPC['id'];
				$visittype = pdo_get($this->tb_visittype, array('visittype_id' => $id));
				include $this->template('visittype_create');
			} else {
				if ($op == 'delete') {
					$id = $_GPC['id'];
					$res = pdo_delete($this->tb_visittype, array('visittype_id' => $id));
					if (!empty($res)) {
						message('删除回访分类', $this->createWebUrl('visittype', array('op' => 'display')), 'success');
					} else {
						message('删除回访分类失败', $this->createWebUrl('visittype', array('op' => 'display')), 'error');
					}
				}
			}
		}
	}
	public function doWebVisittpl()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$types = pdo_getall($this->tb_visittype, array('visittype_uniacid' => $_W['uniacid']), array(), '', 'visittype_order asc');
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['visittpl']);
				}
				$_SESSION['search']['visittpl'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['visittpl'])) {
				$searchrecord = $_SESSION['search']['visittpl'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectVisittpl($option, $this->tb_visittpl);
			$visittpls = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			include $this->template('visittpl_display');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$visittpl = $_POST['visittpl'];
					$visittpl['visittpl_uniacid'] = $_W['uniacid'];
					if (empty($visittpl['visittpl_id'])) {
						$visittpl['visittpl_time_add'] = nowDate;
						$result = pdo_insert($this->tb_visittpl, $visittpl);
						if ($result) {
							message('添加回访模板分类成功', $this->createWebUrl('visittpl', array('op' => 'display', 'type_id' => $visittpl['visittpl_typeid'])), 'success');
						}
					} else {
						$visittpl['visittpl_time_update'] = nowDate;
						$result = pdo_update($this->tb_visittpl, $visittpl, array('visittpl_id' => $visittpl['visittpl_id']));
						if ($result) {
							message('修改回访模板分类成功', $this->createWebUrl('visittpl', array('op' => 'display', 'type_id' => $visittpl['visittpl_typeid'])), 'success');
						}
					}
				}
				$id = $_GPC['visittpl_id'];
				$visittpl = pdo_get($this->tb_visittpl, array('visittpl_id' => $id));
				include $this->template('visittpl_create');
			} else {
				if ($op == 'delete') {
					$id = $_GPC['id'];
					$res = pdo_delete($this->tb_visittpl, array('visittpl_id' => $id));
					if (!empty($res)) {
						message('删除回访模板成功', $this->createWebUrl('Visittpl', array('op' => 'display')), 'success');
					} else {
						message('删除回访模板失败', $this->createWebUrl('Visittpl', array('op' => 'display')), 'error');
					}
				}
			}
		}
	}
	public function doWebVisitLog()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['visitlog']);
				}
				$_SESSION['search']['visitlog'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['visitlog'])) {
				$searchrecord = $_SESSION['search']['visitlog'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectVisitlog($option, $this->tb_visitlog);
			$visitlogs = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			include $this->template('visitlog_display');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$visittpl = $_POST['visittpl'];
					$visittpl['visittpl_uniacid'] = $_W['uniacid'];
					if (empty($visittpl['visittpl_id'])) {
						$visittpl['visittpl_time_add'] = nowDate;
						$result = pdo_insert($this->tb_visittpl, $visittpl);
						if ($result) {
							message('添加回访模板分类成功', $this->createWebUrl('visittpl', array('op' => 'display', 'type_id' => $visittpl['visittpl_typeid'])), 'success');
						}
					} else {
						$visittpl['visittpl_time_update'] = nowDate;
						$result = pdo_update($this->tb_visittpl, $visittpl, array('visittpl_id' => $visittpl['visittpl_id']));
						if ($result) {
							message('修改回访模板分类成功', $this->createWebUrl('visittpl', array('op' => 'display', 'type_id' => $visittpl['visittpl_typeid'])), 'success');
						}
					}
				}
				$id = $_GPC['visittpl_id'];
				$visittpl = pdo_get($this->tb_visittpl, array('visittpl_id' => $id));
				include $this->template('visittpl_create');
			} else {
				if ($op == 'delete') {
					$id = $_GPC['id'];
					$res = pdo_delete($this->tb_visitlog, array('visitlog_id' => $id));
					if (!empty($res)) {
						message('删除回访记录成功', $this->createWebUrl('visitlog', array('op' => 'display')), 'success');
					} else {
						message('删除回访记录失败', $this->createWebUrl('visitlog', array('op' => 'display')), 'error');
					}
				}
			}
		}
	}
	public function doWebScomment()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			session_start();
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['scomment']);
				}
				$_SESSION['search']['scomment'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['scomment'])) {
				$searchrecord = $_SESSION['search']['scomment'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectScomment($option, $this->tb_scomment);
			$scomments = $result['records'];
			$total = $result['total'];
			unset($result);
			$tags = pdo_getall($this->tb_scommenttag, array('scommenttag_uniacid' => $_W['uniacid']));
			$tags_new = array();
			foreach ($tags as $key => $item) {
				$tags_new[$item['scommenttag_id']] = $item['scommenttag_title'];
			}
			foreach ($scomments as $key => $item) {
				if (!empty($item['scomment_tag'])) {
					$item['scomment_tag'] = explode(',', $item['scomment_tag']);
					foreach ($item['scomment_tag'] as $row) {
						$scomments[$key]['tag'][] = $tags_new[$row];
					}
				}
			}
			$page = pagination($total, $pindex, $psize);
			include $this->template('scomment_display');
		} else {
			if ($op == 'tagdisplay') {
				session_start();
				$pindex = max(1, intval($_GPC['page']));
				$psize = 20;
				if (!empty($_POST['search'])) {
					if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
						$pindex = 1;
						unset($_SESSION['search']['scommenttag']);
					}
					$_SESSION['search']['scommenttag'] = $_GPC['search'];
				}
				$searchrecord = array();
				if (isset($_SESSION['search']['scommenttag'])) {
					$searchrecord = $_SESSION['search']['scommenttag'];
				}
				$search = $searchrecord;
				$option['search'] = $searchrecord;
				$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
				$result = selectScommenttag($option, $this->tb_scommenttag);
				$scommenttags = $result['records'];
				$total = $result['total'];
				unset($result);
				$page = pagination($total, $pindex, $psize);
				include $this->template('scommenttag_display');
			} else {
				if ($op == 'tagcreate') {
					if (checksubmit()) {
						$scommenttag = $_POST['scommenttag'];
						$scommenttag['scommenttag_uniacid'] = $_W['uniacid'];
						if (empty($scommenttag['scommenttag_id'])) {
							$scommenttag['scommenttag_time_add'] = nowDate;
							$result = pdo_insert($this->tb_scommenttag, $scommenttag);
							if ($result) {
								message('添加评论标签成功', $this->createWebUrl('scomment', array('op' => 'tagdisplay')), 'success');
							}
						} else {
							$scommenttag['scommenttag_time_update'] = nowDate;
							$result = pdo_update($this->tb_scommenttag, $scommenttag, array('scommenttag_id' => $scommenttag['scommenttag_id']));
							if ($result) {
								message('修改评论标签成功', $this->createWebUrl('scomment', array('op' => 'tagdisplay')), 'success');
							}
						}
					}
					$id = $_GPC['id'];
					$scommenttag = pdo_get($this->tb_scommenttag, array('scommenttag_id' => $id));
					include $this->template('scommenttag_create');
				} else {
					if ($op == 'tagdelete') {
						$id = $_GPC['id'];
						$res = pdo_delete($this->tb_scommenttag, array('scommenttag_id' => $id));
						if (!empty($res)) {
							message('删除评论标签成功', $this->createWebUrl('scomment', array('op' => 'tagdisplay')), 'success');
						}
					} else {
						if ($op == 'delete') {
							$id = $_GPC['id'];
							$res = pdo_delete($this->tb_scomment, array('scomment_id' => $id));
							if (!empty($res)) {
								message('删除评论成功', $this->createWebUrl('scomment', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doMobilePcLogin()
	{
		global $_GPC, $_W;
		session_start();
		if (!empty($_SESSION['admin'])) {
			header('location:' . $this->createMobileUrl('pcProject', array('op' => 'display')));
		}
		if (!empty($_POST['username'])) {
			$username = $_POST['username'];
			$password = md5($_POST['password']);
			$admin = pdo_get($this->tb_admin, array('admin_account' => $username, 'admin_password' => $password, 'admin_uniacid' => $_W['uniacid']));
			if (!empty($admin)) {
				session_start();
				$business = pdo_get($this->tb_business, array('business_id' => $admin['admin_businessid']), array('business_logo'));
				$admin['business_logo'] = $business['business_logo'];
				$_SESSION['admin'] = $admin;
				$result['result'] = 'success';
				$work['work_uniacid'] = $_W['uniacid'];
				$work['work_businessid'] = $admin['admin_businessid'];
				$work['work_adminid'] = $admin['admin_id'];
				$work['work_action'] = 1;
				$work['work_time_add'] = nowDate;
				pdo_insert($this->tb_work, $work);
				$result['url'] = $this->createMobileUrl('pcProject', array('op' => 'display'));
			} else {
				$result['result'] = 'fail';
				$result['error'] = '请检查账号密码是否正确';
			}
			echo json_encode($result);
			die;
		}
		$backgroup = empty($this->config['system_pclogin']) ? RES . 'public/pc/images/bg-login.jpg' : tomedia($this->config['system_pclogin']);
		include $this->template('../pc/login');
	}
	public function doMobilePcLogout()
	{
		session_start();
		unset($_SESSION['admin']);
		header('location:' . $this->createMobileUrl('pcLogin'));
		die;
	}
	public function doMobilePcPtype()
	{
		global $_GPC, $_W;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['pcptype']);
				}
				$_SESSION['search']['pcptype'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['pcptype'])) {
				$searchrecord = $_SESSION['search']['pcptype'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['ptype_businessid'] = $_SESSION['admin']['admin_businessid'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectPtype($option, 2);
			$ptypes = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			include $this->template('../pc/ptype_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['ptype'])) {
					$ptype = $_POST['ptype'];
					$ptype['ptype_uniacid'] = $_W['uniacid'];
					$ptype['ptype_businessid'] = $_SESSION['admin']['admin_businessid'];
					if (empty($ptype['ptype_id'])) {
						unset($ptype['ptype_id']);
						$ptype['ptype_time_add'] = nowDate;
						$result = pdo_insert($this->tb_ptype, $ptype);
						if ($result) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'ptype';
							$work['work_action'] = 2;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('添加项目分类成功', $this->createMobileUrl('pcPtype', array('op' => 'display')), 'success');
						}
					} else {
						$ptype['ptype_time_update'] = nowDate;
						$result = pdo_update($this->tb_ptype, $ptype, array('ptype_id' => $ptype['ptype_id']));
						if ($result) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'ptype';
							$work['work_action'] = 4;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('修改项目分类成功', $this->createMobileUrl('pcPtype', array('op' => 'display')), 'success');
						}
					}
				}
				$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
				load()->func('tpl');
				include $this->template('../pc/ptype_create');
			} else {
				if ($op == 'modify') {
					$ptype_id = $_GPC['id'];
					$ptype = pdo_get($this->tb_ptype, array('ptype_id' => $ptype_id, 'ptype_uniacid' => $_W['uniacid']));
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
					include $this->template('../pc/ptype_create');
				} else {
					if (op == 'delete') {
						$ptype_id = $_GPC['id'];
						if ($ptype_id) {
							$res = pdo_delete($this->tb_ptype, array('ptype_id' => $ptype_id, 'ptype_uniacid' => $_W['uniacid']));
							if ($res) {
								$work['work_uniacid'] = $_W['uniacid'];
								$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
								$work['work_adminid'] = $_SESSION['admin']['admin_id'];
								$work['work_module'] = 'ptype';
								$work['work_action'] = 3;
								$work['work_time_add'] = nowDate;
								pdo_insert($this->tb_work, $work);
								$this->pcmessage('删除项目分类成功', $this->createMobileUrl('pcPtype', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doMobilePcProject()
	{
		global $_GPC, $_W;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['pcproject']);
				}
				$_SESSION['search']['pcproject'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['pcproject'])) {
				$searchrecord = $_SESSION['search']['pcproject'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['project_businessid'] = $_SESSION['admin']['admin_businessid'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectProject($option, 2);
			$projects = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			include $this->template('../pc/project_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['project'])) {
					$project = $_POST['project'];
					$project['project_businessid'] = $_SESSION['admin']['admin_businessid'];
					if ($_FILES["staff_avatar"]["error"] == 0) {
						$year = date('Y');
						$month = date('m');
						$fileName = '../attachment/images/' . $_W['uniacid'] . '/' . $year . '/' . $month . '/' . base64_encode($_FILES["staff_avatar"]["tmp_name"]) . '.png';
						if (move_uploaded_file($_FILES["staff_avatar"]["tmp_name"], $fileName)) {
							$project['project_pic'] = str_replace('../attachment/', '', $fileName);
						}
					}
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid']), array('business_look'));
					if ($business['business_look'] == 2) {
						$project['project_state'] = 1;
					} else {
						$project['project_state'] = 2;
					}
					$project['project_uniacid'] = $_W['uniacid'];
					if (empty($project['project_id'])) {
						unset($project['project_id']);
						$project['project_time_add'] = nowDate;
						$project['project_time_update'] = nowDate;
						$result = pdo_insert($this->tb_project, $project);
						if ($result) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'project';
							$work['work_action'] = 2;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('添加服务项目成功', $this->createMobileUrl('pcProject', array('op' => 'display')), 'success');
						}
					} else {
						$project['project_time_update'] = nowDate;
						$result = pdo_update($this->tb_project, $project, array('project_id' => $project['project_id']));
						if ($result) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'project';
							$work['work_action'] = 4;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('修改服务项目成功', $this->createMobileUrl('pcProject', array('op' => 'display')), 'success');
						}
					}
				}
				$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
				load()->func('tpl');
				include $this->template('../pc/project_create');
			} else {
				if ($op == 'modify') {
					$project_id = $_GPC['id'];
					$project = pdo_get($this->tb_project, array('project_id' => $project_id, 'project_uniacid' => $_W['uniacid']));
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
					include $this->template('../pc/project_create');
				} else {
					if (op == 'delete') {
						$project_id = $_GPC['id'];
						if ($project_id) {
							$res = pdo_delete($this->tb_project, array('project_id' => $project_id, 'project_uniacid' => $_W['uniacid']));
							if ($res) {
								$work['work_uniacid'] = $_W['uniacid'];
								$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
								$work['work_adminid'] = $_SESSION['admin']['admin_id'];
								$work['work_module'] = 'project';
								$work['work_action'] = 3;
								$work['work_time_add'] = nowDate;
								pdo_insert($this->tb_work, $work);
								$this->pcmessage('服务项目删除成功', $this->createMobileUrl('pcProject', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doMobilePcStaff()
	{
		global $_GPC, $_W;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['pcstaff']);
				}
				$_SESSION['search']['pcstaff'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['pcstaff'])) {
				$searchrecord = $_SESSION['search']['pcstaff'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['staff_businessid'] = $_SESSION['admin']['admin_businessid'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectStaff($option, 2);
			$staffs = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
			include $this->template('../pc/staff_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['staff'])) {
					$staff = $_POST['staff'];
					if ($_FILES["staff_avatar"]["error"] == 0) {
						$year = date('Y');
						$month = date('m');
						$fileName = '../attachment/images/' . $_W['uniacid'] . '/' . $year . '/' . $month . '/' . base64_encode($_FILES["staff_avatar"]["tmp_name"]) . '.png';
						if (move_uploaded_file($_FILES["staff_avatar"]["tmp_name"], $fileName)) {
							$staff['staff_avatar'] = str_replace('../attachment/', '', $fileName);
						}
					}
					if ($_FILES["staff_pic"]["error"] == 0) {
						$year = date('Y');
						$month = date('m');
						$fileName2 = '../attachment/images/' . $_W['uniacid'] . '/' . $year . '/' . $month . '/' . base64_encode($_FILES["staff_pic"]["tmp_name"]) . '.png';
						if (move_uploaded_file($_FILES["staff_pic"]["tmp_name"], $fileName2)) {
							$staff['staff_pic'] = str_replace('../attachment/', '', $fileName2);
						}
					}
					$staff['staff_uniacid'] = $_W['uniacid'];
					$staff['staff_businessid'] = $_SESSION['admin']['admin_businessid'];
					if (empty($staff['staff_id'])) {
						unset($staff['staff_id']);
						$staff['staff_time_add'] = nowDate;
						$staff['staff_time_update'] = nowDate;
						$res = pdo_insert($this->tb_staff, $staff);
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'staff';
							$work['work_action'] = 2;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('添加员工成功', $this->createMobileUrl('pcStaff', array('op' => 'display')), 'success');
						}
					} else {
						$staff['staff_time_update'] = nowDate;
						$res = pdo_update($this->tb_staff, $staff, array('staff_id' => $staff['staff_id']));
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'staff';
							$work['work_action'] = 4;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('修改员工成功', $this->createMobileUrl('pcStaff', array('op' => 'display')), 'success');
						}
					}
				}
				$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
				include $this->template('../pc/staff_create');
			} else {
				if ($op == 'modify') {
					$staff_id = $_GPC['id'];
					if ($staff_id) {
						$staff = pdo_get($this->tb_staff, array('staff_id' => $staff_id, 'staff_uniacid' => $_W['uniacid']));
					}
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
					include $this->template('../pc/staff_create');
				} else {
					if ($op == 'delete') {
						$staff_id = $_GPC['id'];
						if ($staff_id) {
							$res = pdo_delete($this->tb_staff, array('staff_id' => $staff_id, 'staff_uniacid' => $_W['uniacid']));
							if ($res) {
								$work['work_uniacid'] = $_W['uniacid'];
								$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
								$work['work_adminid'] = $_SESSION['admin']['admin_id'];
								$work['work_module'] = 'staff';
								$work['work_action'] = 3;
								$work['work_time_add'] = nowDate;
								pdo_insert($this->tb_work, $work);
								$this->pcmessage('删除服务员工成功', $this->createMobileUrl('pcStaff', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doMobileAjaxFans()
	{
		global $_W, $_GPC;
		$content = $_GPC['content'];
		$result = selectFansAndMember($content);
		$str = makeSearchToStr($result);
		echo $str;
	}
	public function doMobilePcStore()
	{
		global $_W, $_GPC;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$storetype = pdo_getall($this->tb_storetype, array('storetype_uniacid' => $_W['uniacid'], 'storetype_type' => 2));
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['pcstore']);
				}
				$_SESSION['search']['pcstore'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['pcstore'])) {
				$searchrecord = $_SESSION['search']['pcstore'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['store_businessid'] = $_SESSION['admin']['admin_businessid'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectStore($option, 2);
			$stores = $result['records'];
			$total = $result['total'];
			unset($result);
			$page = pagination($total, $pindex, $psize);
			$stores = getCommentCount($stores);
			$result = selectCircle();
			$circles = $result['records'];
			unset($result);
			$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
			include $this->template('../pc/store_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['store'])) {
					$store = $_POST['store'];
					if ($_FILES["store_pic"]["error"] == 0) {
						$year = date('Y');
						$month = date('m');
						$fileName = '../attachment/images/' . $_W['uniacid'] . '/' . $year . '/' . $month . '/' . base64_encode($_FILES["store_pic"]["tmp_name"]) . '.png';
						if (move_uploaded_file($_FILES["store_pic"]["tmp_name"], $fileName)) {
							$store['store_pic'] = str_replace('../attachment/', '', $fileName);
						}
					}
					$store['store_uniacid'] = $_W['uniacid'];
					$store['store_businessid'] = $_SESSION['admin']['admin_businessid'];
					if (empty($store['store_id'])) {
						unset($store['store_id']);
						$store['store_time_add'] = nowDate;
						$store['store_time_update'] = nowDate;
						$res = pdo_insert($this->tb_store, $store);
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'store';
							$work['work_action'] = 2;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('添加门店成功.', $this->createMobileUrl('pcStore', array('op' => 'display')), 'success');
						}
					} else {
						$store['store_time_update'] = nowDate;
						$res = pdo_update($this->tb_store, $store, array('store_id' => $store['store_id']));
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'store';
							$work['work_action'] = 4;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('修改门店成功.', $this->createMobileUrl('pcStore', array('op' => 'display')), 'success');
						}
					}
				}
				$result = selectCircle();
				$circles = $result['records'];
				$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
				$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
				$lat = 39.916527;
				$log = 116.397128;
				include $this->template('../pc/store_create');
			} else {
				if ($op == 'modify') {
					$store_id = $_GPC['id'];
					if (empty($store_id)) {
						message('未获取到门店信息', $this->createMobileUrl('pcStore', array()), 'error');
					}
					$store = pdo_get($this->tb_store, array('store_id' => $store_id, 'store_uniacid' => $_W['uniacid']));
					$result = selectCircle();
					$circles = $result['records'];
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
					$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
					$lat = $store['store_lat'];
					$log = $store['store_log'];
					include $this->template('../pc/store_create');
				} else {
					if ($op == 'delete') {
						$store_id = $_GPC['id'];
						if (empty($store_id)) {
							$this->pcmessage('未获取到门店信息', $this->createMobileUrl('pcstore'), 'error');
						}
						$res = pdo_delete($this->tb_store, array('store_id' => $store_id));
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'store';
							$work['work_action'] = 3;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('删除门店成功', $this->createMobileUrl('pcstore'), 'success');
						}
					}
				}
			}
		}
	}
	public function doMobilePcAppointment()
	{
		global $_W, $_GPC;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['pcdating']);
				}
				$_SESSION['search']['pcdating'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['pcdating'])) {
				$searchrecord = $_SESSION['search']['pcdating'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['dating_businessid'] = $_SESSION['admin']['admin_businessid'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectDating($option, 2);
			$datines = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
			$stores = pdo_getall($this->tb_store, array('store_businessid' => $_SESSION['admin']['admin_businessid'], 'store_uniacid' => $_W['uniacid']));
			$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $_SESSION['admin']['admin_businessid'], 'staff_uniacid' => $_W['uniacid']));
			$projects = pdo_getall($this->tb_project, array('project_businessid' => $_SESSION['admin']['admin_businessid'], 'project_uniacid' => $_W['uniacid']));
			include $this->template('../pc/appointment_display');
		} else {
			if ($op == 'create') {
				if (!empty($_POST['dating'])) {
					$dating = $_POST['dating'];
					$dating['dating_uniacid'] = $_W['uniacid'];
					$dating['dating_week'] = json_encode($dating['dating_week']);
					$dating['dating_businessid'] = $_SESSION['admin']['admin_businessid'];
					foreach ($dating['dating_time'] as $key => $item) {
						if (empty($item) || empty($item['start']) || empty($item['end'])) {
							unset($dating['dating_time'][$key]);
							continue;
						}
						if ($item['start'] >= $item['end']) {
							$this->pcmessage('预约时间设置错误, 结束时间必须大于开始时间', '', 'error');
						}
						if (empty($item['count'])) {
							$dating['dating_time'][$key]['count'] = 1;
						}
					}
					$dating['dating_time'] = DatingTimeSort($dating['dating_time']);
					$dating['dating_time'] = json_encode($dating['dating_time']);
					if (empty($dating['dating_id'])) {
						unset($dating['dating_id']);
						$dating['dating_time_add'] = nowDate;
						$dating['dating_time_update'] = nowDate;
						$res = pdo_insert($this->tb_dating, $dating);
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'appointment';
							$work['work_action'] = 2;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('添加预约设置成功.', $this->createMobileUrl('pcAppointment', array('op' => 'display')), 'success');
						}
					} else {
						$dating['dating_time_update'] = nowDate;
						$res = pdo_update($this->tb_dating, $dating, array('dating_id' => $dating['dating_id']));
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'appointment';
							$work['work_action'] = 4;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('修改预约设置成功.', $this->createMobileUrl('pcAppointment', array('op' => 'display')), 'success');
						}
					}
				}
				$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
				$stores = pdo_getall($this->tb_store, array('store_businessid' => $_SESSION['admin']['admin_businessid'], 'store_uniacid' => $_W['uniacid']));
				$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $_SESSION['admin']['admin_businessid'], 'staff_uniacid' => $_W['uniacid']));
				$projects = pdo_getall($this->tb_project, array('project_businessid' => $_SESSION['admin']['admin_businessid'], 'project_uniacid' => $_W['uniacid']));
				$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
				include $this->template('../pc/appointment_create');
			} else {
				if ($op == 'modify') {
					$dating_id = $_GPC['id'];
					if (!$dating_id) {
						message('未获取预约信息', $this->createWebUrl('appointment', array('display')), 'error');
					}
					$dating = pdo_get($this->tb_dating, array('dating_id' => $dating_id, 'dating_uniacid' => $_W['uniacid']));
					$dating['dating_week'] = json_decode($dating['dating_week'], true);
					$dating['dating_time'] = json_decode($dating['dating_time'], true);
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
					$stores = pdo_getall($this->tb_store, array('store_businessid' => $_SESSION['admin']['admin_businessid'], 'store_uniacid' => $_W['uniacid']));
					$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $_SESSION['admin']['admin_businessid'], 'staff_uniacid' => $_W['uniacid']));
					$projects = pdo_getall($this->tb_project, array('project_businessid' => $_SESSION['admin']['admin_businessid'], 'project_uniacid' => $_W['uniacid']));
					$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
					include $this->template('../pc/appointment_create');
				} else {
					if ($op == 'delete') {
						$dating_id = $_GPC['id'];
						if ($dating_id) {
							$res = pdo_delete($this->tb_dating, array('dating_id' => $dating_id, 'dating_uniacid' => $_W['uniacid']));
							if ($res) {
								$work['work_uniacid'] = $_W['uniacid'];
								$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
								$work['work_adminid'] = $_SESSION['admin']['admin_id'];
								$work['work_module'] = 'appointment';
								$work['work_action'] = 3;
								$work['work_time_add'] = nowDate;
								pdo_insert($this->tb_work, $work);
								$this->pcmessage('删除预约订单成功.', $this->createMobileUrl('pcRecord', array('op' => 'display')), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doMobilePcRecord()
	{
		global $_W, $_GPC;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
			$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_businessid' => $_SESSION['admin']['admin_businessid']));
			$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid'], 'staff_businessid' => $_SESSION['admin']['admin_businessid']));
			$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $_SESSION['admin']['admin_businessid']));
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['pcorder']);
				}
				$_SESSION['search']['pcorder'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['pcorder'])) {
				$searchrecord = $_SESSION['search']['pcorder'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['order_businessid'] = $_SESSION['admin']['admin_businessid'];
			if ($_POST['excel'] == 1) {
				$result = selectOrder($option);
				$orders = $result['records'];
				$orders = dealOrders($orders, $business, $stores, $staffs, $projects, 2);
				downloadRecord($orders);
			} else {
				$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
				$result = selectOrder($option);
				$orders = $result['records'];
				$total = $result['total'];
				unset($result);
				$page = pagination($total, $pindex, $psize);
				$orders = dealOrders($orders, $business, $stores, $staffs, $projects, 2);
				include $this->template('../pc/order_display');
			}
		} else {
			if ($op == 'create') {
				if (!empty($_POST['order'])) {
					$order = $_POST['order'];
					$order['order_uniacid'] = $_W['uniacid'];
					if (!empty($order['order_dating_time'])) {
						$time = explode('-', $order['order_dating_time']);
						$order['order_dating_start'] = $time[0];
						$order['order_dating_end'] = $time[1];
					}
					unset($order['order_dating_time']);
					$dating = pdo_get($this->tb_dating, array('dating_businessid' => $order['order_businessid'], 'dating_storeid' => $order['order_storeid'], 'dating_projectid' => $order['order_projectid'], 'dating_staffid' => $order['order_staffid'], 'dating_uniacid' => $_W['uniacid']));
					if (empty($dating)) {
						$this->pcmessage('未获取到预约信息', '', 'error');
					}
					$dating['dating_time'] = json_decode($dating['dating_time'], true);
					$order_count = pdo_getall($this->tb_order, array('order_storeid' => $dating['dating_storeid'], 'order_projectid' => $dating['dating_projectid'], 'order_staffid' => $dating['dating_staffid'], 'order_dating_day' => $order['order_dating_day'], 'order_dating_start' => $order['order_dating_start'], 'order_dating_end' => $order['order_dating_end'], 'order_uniacid' => $_W['uniacid'], 'order_state <' => 2, 'order_id !=' => $order['order_id']), array('order_id'));
					foreach ($dating['dating_time'] as $key => $item) {
						if ($item['start'] == $order['order_dating_start'] && $item['end'] == $order['order_dating_end']) {
							if ($item['count'] <= count($order_count)) {
								$this->pcmessage('当前时段预约人次已满, 请选择其他时段', '', 'error');
							}
						}
					}
					$order['order_businessid'] = $_SESSION['admin']['admin_businessid'];
					if (empty($order['order_id'])) {
						unset($order['order_id']);
						$order['order_time_add'] = nowDate;
						$order['order_time_update'] = nowDate;
						if ($order['order_pay_type'] == 2) {
							if ($_POST['send_state'] == 2) {
								$order['order_notice'] = 2;
							} else {
								$order['order_notice'] = 1;
							}
						} else {
							$order['order_notice'] = 2;
						}
						$res = pdo_insert($this->tb_order, $order);
						if ($res) {
							if ($_POST['send_state'] == 2) {
								$notice = getconfigbytype('type5', $this->tb_config);
								if ($notice['notice_way'] == 1) {
									$this->sendTpl($order['order_number']);
								} else {
									if ($notice['notice_way'] == 2) {
										$this->sendCustom($order['order_number']);
									} else {
										if ($notice['notice_way'] == 3) {
											$this->sendMessage($order['order_number']);
										}
									}
								}
							}
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'order';
							$work['work_action'] = 2;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('添加预约订单成功.', $this->createMobileUrl('pcrecord', array('op' => 'display')), 'success');
						}
					} else {
						$order['order_time_update'] = nowDate;
						$res = pdo_update($this->tb_order, $order, array('order_id' => $order['order_id']));
						if ($res) {
							if ($_POST['send_state'] == 2) {
								$notice = getconfigbytype('type5', $this->tb_config);
								if ($notice['notice_way'] == 1) {
									$this->sendTpl($order['order_number']);
								} else {
									if ($notice['notice_way'] == 2) {
										$this->sendCustom($order['order_number']);
									} else {
										if ($notice['notice_way'] == 3) {
											$this->sendMessage($order['order_number']);
										}
									}
								}
							}
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'order';
							$work['work_action'] = 4;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('修改预约订单成功.', $this->createMobileUrl('pcrecord', array('op' => 'display')), 'success');
						}
					}
				}
				$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
				$stores = pdo_getall($this->tb_store, array('store_businessid' => $_SESSION['admin']['admin_businessid'], 'store_uniacid' => $_W['uniacid']));
				$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $_SESSION['admin']['admin_businessid'], 'staff_uniacid' => $_W['uniacid']));
				$projects = pdo_getall($this->tb_project, array('project_businessid' => $_SESSION['admin']['admin_businessid'], 'project_uniacid' => $_W['uniacid']));
				$number = getOrderNumber();
				if ($number == false) {
					$this->pcmessage('订单异常请稍后再试', '', 'error');
				}
				include $this->template('../pc/order_create');
			} else {
				if ($op == 'modify') {
					$order_id = $_GPC['id'];
					if (empty($order_id)) {
						$this->pcmessage('未获取到订单信息', $this->createMobileUrl('pcrecord'), 'error');
					}
					$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']));
					$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
					$stores = pdo_getall($this->tb_store, array('store_businessid' => $order['order_businessid'], 'store_uniacid' => $_W['uniacid']));
					$projects = pdo_getall($this->tb_project, array('project_businessid' => $order['order_businessid'], 'project_uniacid' => $_W['uniacid']));
					$staffs = pdo_getall($this->tb_staff, array('staff_businessid' => $order['order_businessid'], 'staff_uniacid' => $_W['uniacid']));
					$dating = pdo_get($this->tb_dating, array('dating_businessid' => $order['order_businessid'], 'dating_storeid' => $order['order_storeid'], 'dating_projectid' => $order['order_projectid'], 'dating_staffid' => $order['order_staffid'], 'dating_uniacid' => $_W['uniacid']));
					$dating['dating_week'] = json_decode($dating['dating_week']);
					$week = date('Y-m-d');
					$weeks = riqi($week);
					foreach ($weeks as $key => $item) {
						if (!in_array($key, $dating['dating_week'])) {
							unset($weeks[$key]);
						}
					}
					$dating['dating_time'] = json_decode($dating['dating_time'], true);
					$time_count = getTimeCount($dating, $order['order_dating_day']);
					$number = $order['order_number'];
					include $this->template('../pc/order_create');
				} else {
					if ($op == 'delete') {
						$order_id = $_GPC['id'];
						if (empty($order_id)) {
							$this->pcmessage('未获取订单信息', $this->createWebUrl('pcRecord', array()), 'error');
						}
						$res = pdo_delete($this->tb_order, array('order_id' => $order_id));
						if ($res) {
							$work['work_uniacid'] = $_W['uniacid'];
							$work['work_businessid'] = $_SESSION['admin']['admin_businessid'];
							$work['work_adminid'] = $_SESSION['admin']['admin_id'];
							$work['work_module'] = 'order';
							$work['work_action'] = 3;
							$work['work_time_add'] = nowDate;
							pdo_insert($this->tb_work, $work);
							$this->pcmessage('删除预约记录功', $this->createWebUrl('pcRecord', array('op' => 'display')), 'success');
						}
					}
				}
			}
		}
	}
	public function doMobilePccomment()
	{
		global $_W, $_GPC;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$store = pdo_get($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_id' => $_GPC['store_id']));
			if (empty($store)) {
				message('未获取到门店信息', '', 'error');
			}
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['comment']);
				}
				$_SESSION['search']['comment'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['comment'])) {
				$searchrecord = $_SESSION['search']['comment'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['comment_storeid'] = $store['store_id'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectComment($option, 1);
			$comment = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			include $this->template('../pc/comment_display');
		}
		if ($op == 'changestate') {
			$base = getconfigbytype('type1', $this->tb_config);
			$cretid1 = $base['comment_cretid1'] != '' ? $base['comment_cretid1'] : 0;
			$commentstate = $base['comment_state'] != '' ? $base['comment_state'] : 2;
			$comment_id = $_GPC['comment_id'];
			$state = isset($_GPC['commentstate']) ? $_GPC['commentstate'] : 1;
			if ($comment_id == '') {
				$data['rs'] = '未获取到评论信息';
				$data['result'] = 'error';
				echo json_encode($data);
				die;
			}
			$comment_list = pdo_get($this->tb_comment, array('comment_uniacid' => $_W['uniacid'], 'comment_id' => $comment_id));
			if (empty($comment_list)) {
				$data['rs'] = '未获取到评论信息';
				$data['result'] = 'error';
				echo json_encode($data);
				die;
			}
			$result = pdo_update($this->tb_comment, array('comment_state' => $state), array('comment_uniacid' => $_W['uniacid'], 'comment_id' => $comment_id));
			if ($commentstate == 1 && $cretid1 != 0) {
				load()->model('mc');
				$fansuid = mc_openid2uid($comment_list['comment_openid']);
				mc_credit_update($fansuid, 'credit1', $cretid1, array($fansuid, "预约系统评论奖励", 'wxlm_appointment'));
			}
			if ($result) {
				$data['rs'] = $state;
				$data['result'] = 'success';
			} else {
				$data['rs'] = '审核状态更改失败！';
				$data['result'] = 'error';
			}
			echo json_encode($data);
			die;
		}
		if ($op == 'delete') {
			$comment_id = $_GPC['id'];
			$store_id = $_GPC['store_id'];
			if ($comment_id == '') {
				$this->pcmessage('未获取到评论信息！', $this->createMobileUrl('pccomment', array('op' => 'display', 'store_id' => $store_id)), 'error');
			}
			$res = pdo_delete($this->tb_comment, array('comment_id' => $comment_id, 'comment_uniacid' => $_W['uniacid']));
			if ($res) {
				$this->pcmessage('删除成功', $this->createMobileUrl('pccomment', array('op' => 'display', 'store_id' => $store_id)), 'success');
			} else {
				$this->pcmessage('删除失败', $this->createMobileUrl('pccomment', array('op' => 'display', 'store_id' => $store_id)), 'error');
			}
		}
	}
	public function doMobilePcrefund()
	{
		global $_W, $_GPC;
		$this->checkLogin();
		session_start();
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$pindex = max(1, intval($_GPC['page']));
			$psize = 20;
			if (!empty($_POST['search'])) {
				if (isset($_GPC['searchflag']) && $_GPC['searchflag'] == '1') {
					$pindex = 1;
					unset($_SESSION['search']['refund']);
				}
				$_SESSION['search']['refund'] = $_GPC['search'];
			}
			$searchrecord = array();
			if (isset($_SESSION['search']['refund'])) {
				$searchrecord = $_SESSION['search']['refund'];
			}
			$search = $searchrecord;
			$option['search'] = $searchrecord;
			$option['search']['order_businessid'] = $_SESSION['admin']['admin_businessid'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectrefund($option, 2);
			$orders = $result['records'];
			$total = $result['total'];
			$page = pagination($total, $pindex, $psize);
			unset($result);
			$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
			$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_businessid' => $_SESSION['admin']['admin_businessid']));
			$staffs = pdo_getall($this->tb_staff, array('staff_uniacid' => $_W['uniacid'], 'staff_businessid' => $_SESSION['admin']['admin_businessid']));
			$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $_SESSION['admin']['admin_businessid']));
			$orders = dealOrders($orders, $business, $stores, $staffs, $projects, 2);
			include $this->template('../pc/orderrefund_display');
		}
		if ($op == 'changestate') {
			$orderrefund_id = $_GPC['id'];
			$orderrefund_list = pdo_get($this->tb_orderrefund, array('orderrefund_uniacid' => $_W['uniacid'], 'orderrefund_id' => $orderrefund_id));
			if (empty($orderrefund_list)) {
				$this->pcmessage('没有获取到有效的退款记录', $this->createMobileUrl('pcrefund', array('op' => 'display')), 'error');
			}
			$order_list = pdo_get($this->tb_order, array('order_uniacid' => $_W['uniacid'], 'order_number' => $orderrefund_list['orderrefund_number']));
			if (empty($order_list)) {
				$this->pcmessage('没有获取到预约记录', $this->createMobileUrl('pcrefund', array('op' => 'display')), 'error');
			}
			$pay = getconfigbytype("type2", $this->tb_config);
			if ($order_list['order_pay_state'] == 1) {
				$this->pcmessage('暂不支持退款', $this->createMobileUrl('pcrefund', array('op' => 'display')), 'error');
				die;
			}
			if ($order_list['order_pay_state'] == 2) {
				$this->pcmessage('暂不支持退款', $this->createMobileUrl('pcrefund', array('op' => 'display')), 'error');
				die;
			}
			if ($order_list['order_pay_state'] == 3) {
				$url = 'http://www.zwechat.com/weixinpay/index.php/Fanqiejia/refund?b_id=' . $pay['b_id'] . '&bm_id=' . $pay['bm_id'] . '&s_no=' . $order_list['order_paynumber'];
				$result = _request($url);
				$result = json_decode($result, true);
				if ($result['status'] == 'success') {
					pdo_update($this->tb_order, array('order_state' => 4), array('order_id' => $order_list['order_id']));
					pdo_update($this->tb_orderrefund, array('orderrefund_state' => 2), array('orderrefund_id' => $orderrefund_list['orderrefund_id']));
					$this->pcmessage('退款成功', $this->createMobileUrl('pcrefund', array('op' => 'display')), 'success');
					die;
				} else {
					$this->pcmessage('退款操作失败', $this->createMobileUrl('pcrefund', array('op' => 'display')), 'error');
					die;
				}
			}
		}
	}
	public function doMobileGetDayInfo()
	{
		global $_GPC, $_W;
		$businessid = $_GPC['businessid'];
		$storeid = $_GPC['storeid'];
		$projectid = $_GPC['projectid'];
		$staffid = $_GPC['staffid'];
		$dating = pdo_get($this->tb_dating, array('dating_businessid' => $businessid, 'dating_storeid' => $storeid, 'dating_projectid' => $projectid, 'dating_staffid' => $staffid, 'dating_uniacid' => $_W['uniacid']));
		if (empty($dating)) {
			$data['result'] = 'fail';
			$data['error'] = "未获取到预约信息, 请检查是否设置此类预约";
		} else {
			$dating['dating_week'] = json_decode($dating['dating_week'], true);
			$week = date('Y-m-d');
			$weeks = riqi($week);
			foreach ($weeks as $key => $item) {
				if (!in_array($key, $dating['dating_week'])) {
					unset($weeks[$key]);
				}
			}
			$daystr = makeDayToOption($weeks);
			$data['result'] = 'success';
			$data['day'] = $daystr;
		}
		echo json_encode($data);
	}
	public function doMobileGetTimeInfo()
	{
		global $_GPC, $_W;
		$businessid = $_GPC['businessid'];
		$storeid = $_GPC['storeid'];
		$projectid = $_GPC['projectid'];
		$staffid = $_GPC['staffid'];
		$day = $_GPC['day'];
		$dating = pdo_get($this->tb_dating, array('dating_businessid' => $businessid, 'dating_storeid' => $storeid, 'dating_projectid' => $projectid, 'dating_staffid' => $staffid, 'dating_uniacid' => $_W['uniacid']));
		if (empty($dating)) {
			$data['result'] = 'fail';
			$data['error'] = "未获取到预约信息, 请检查是否设置此类预约";
		} else {
			$dating['dating_time'] = json_decode($dating['dating_time'], true);
			$time_count = getTimeCount($dating, $day);
			$timestr = makeTimeToOption($dating['dating_time'], $time_count);
			$data['result'] = 'success';
			$data['time'] = $timestr;
		}
		echo json_encode($data);
	}
	public function checkLogin()
	{
		global $_W;
		session_start();
		if (empty($_SESSION['admin'])) {
			header('location:' . $this->createMobileUrl('pcLogin'));
		}
		$business = pdo_get($this->tb_business, array('business_id' => $_SESSION['admin']['admin_businessid'], 'business_uniacid' => $_W['uniacid']));
		if (!empty($business['business_package'])) {
			if ($business['business_package'] == 1) {
				$date_value = 365 * 24 * 60 * 60 - $business['business_time_use'];
			} else {
				if ($business['business_package'] == 2) {
					$date_value = 90 * 24 * 60 * 60 - $business['business_time_use'];
				} else {
					if ($business['business_package'] == 3) {
						$date_value = 30 * 24 * 60 * 60 - $business['business_time_use'];
					}
				}
			}
			$date_value = $date_value / 60 / 60 / 24;
		} else {
			$date_value = 'YJ';
		}
	}
	public function doMobilePcMessage()
	{
		global $_W, $_GPC;
		session_start();
		$content = $_SESSION['remind']['content'];
		$url = $_SESSION['remind']['url'];
		$state = $_SESSION['remind']['state'];
		include $this->template('../pc/message');
	}
	public function pcmessage($content, $url, $state = 'success')
	{
		global $_W;
		session_start();
		$_SESSION['remind']['content'] = $content;
		$_SESSION['remind']['url'] = $url;
		$_SESSION['remind']['state'] = $state;
		header('location:' . $this->createMobileUrl('pcMessage', array()));
	}
	public function doMobileIndex()
	{
		global $_W, $_GPC;
		session_start();
		$_SESSION['index'] = 1;
		$op = empty($_GPC['op']) ? 'location' : $_GPC['op'];
		if ($_W['uniaccount']['level'] != 4) {
			$op == 'main';
		}
		if ($op == 'location') {
			$url = $_W['siteurl'];
			$url = str_replace('location', 'main', $url);
			include $this->template('location');
		} else {
			if ($op == 'main') {
				$ads = pdo_getall($this->tb_ad, array('ad_uniacid' => $_W['uniacid'], 'ad_state' => 2), array(), '', 'ad_order ASC');
				$storetype = pdo_getall($this->tb_storetype, array('storetype_state' => 1, 'storetype_uniacid' => $_W['uniacid']), array(), '', 'storetype_order asc');
				foreach ($storetype as $k => $v) {
					if ($v['storetype_type'] == 2) {
						$store = pdo_get($this->tb_store, array('store_typeid' => $v['storetype_id'], 'store_uniacid' => $_W['uniacid']));
						if (empty($store)) {
							unset($storetype[$k]);
						} else {
							$storetype[$k]['storetype_url'] = $this->createMobileUrl('storelist', array('store_typeid' => $v['storetype_id']));
						}
					}
				}
				$pindex = max(1, intval($_GPC['page']));
				$psize = $this->config['storenumber'] != '' ? $this->config['storenumber'] : 10;
				if (!empty($_GPC['circle_id'])) {
					$option['search']['store_circleid'] = $_GPC['circle_id'];
					$circle = pdo_get($this->tb_circle, array('circle_id' => $_GPC['circle_id'], 'circle_uniacid' => $_W['uniacid']));
				}
				if (empty($_GPC['log']) || empty($_GPC['lat'])) {
					$location = $this->locationByIP(CLIENT_IP);
					$_GPC['log'] = $location['lng'];
					$_GPC['lat'] = $location['lat'];
				}
				$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
				$option['dingwei'] = array('log' => $_GPC['log'], 'lat' => $_GPC['lat']);
				$result = selectStore2($option);
				$stores = $result['records'];
				foreach ($stores as $key => $item) {
					$stores[$key]['dis'] = round($item['dis'], 2);
					$business = pdo_get($this->tb_business, array('business_id' => $item['store_businessid'], 'business_uniacid' => $_W['uniacid']));
					if (!empty($business['business_package'])) {
						$value = time() - $business['business_time_use'];
						if ($business['business_package'] == 1) {
							if ($value > 365 * 24 * 60 * 60) {
								unset($stores[$key]);
							}
						} else {
							if ($business['business_package'] == 2) {
								if ($value > 90 * 24 * 60 * 60) {
									unset($stores[$key]);
								}
							} else {
								if ($business['business_package'] == 3) {
									if ($value > 30 * 24 * 60 * 60) {
										unset($stores[$key]);
									}
								}
							}
						}
					}
				}
				$total = $result['total'];
				unset($result);
				$pindex2 = max(1, intval($_GPC['page']));
				$psize2 = $this->config['storenumber'] != '' ? $this->config['storenumber'] : 10;
				$option2["limit"] = " limit " . ($pindex2 - 1) * $psize2 . "," . $psize2 . " ";
				$results = selectStore3($option2);
				$storesa = $results['records'];
				foreach ($storesa as $key => $item) {
					$storesa[$key]['time'] = floor((time() - strtotime($item['dating_time_update'])) / (7 * 24 * 60 * 60)) + 1;
					$business = pdo_get($this->tb_business, array('business_id' => $item['store_businessid'], 'business_uniacid' => $_W['uniacid']));
					if (!empty($business['business_package'])) {
						$value = time() - $business['business_time_use'];
						if ($business['business_package'] == 1) {
							if ($value > 365 * 24 * 60 * 60) {
								unset($storesa[$key]);
							}
						} else {
							if ($business['business_package'] == 2) {
								if ($value > 90 * 24 * 60 * 60) {
									unset($storesa[$key]);
								}
							} else {
								if ($business['business_package'] == 3) {
									if ($value > 30 * 24 * 60 * 60) {
										unset($storesa[$key]);
									}
								}
							}
						}
					}
				}
				unset($results);
				$store_index = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_index' => 2));
				$store_list = array();
				foreach ($store_index as $k => $v) {
					$ks = ceil(($k + 1) / 3) - 1;
					$store_list[$ks][$k % 3] = $v;
				}
				foreach ($store_list as $kn => $vn) {
					if (count($vn) < 3) {
						unset($store_list[$kn]);
					}
				}
				$project_index = pdo_getall($this->tb_project, array('project_state =' => 2, 'project_index' => 2, 'project_uniacid' => $_W['uniacid']), array(), '', 'project_order DESC', array(1, 8));
				foreach ($project_index as $key => $item) {
					$business = pdo_get($this->tb_business, array('business_id' => $item['project_businessid'], 'business_uniacid' => $_W['uniacid']));
					if (!empty($business['business_package'])) {
						$value = time() - $business['business_time_use'];
						if ($business['business_package'] == 1) {
							if ($value > 365 * 24 * 60 * 60) {
								unset($project_index[$key]);
							}
						} else {
							if ($business['business_package'] == 2) {
								if ($value > 90 * 24 * 60 * 60) {
									unset($project_index[$key]);
								}
							} else {
								if ($business['business_package'] == 3) {
									if ($value > 30 * 24 * 60 * 60) {
										unset($project_index[$key]);
									}
								}
							}
						}
					}
				}
				include $this->template('index');
			}
		}
	}
	public function doMobilestorelist()
	{
		global $_W, $_GPC;
		$ads = pdo_getall($this->tb_ad, array('ad_uniacid' => $_W['uniacid'], 'ad_state' => 2));
		$pindex = max(1, intval($_GPC['page']));
		$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_typeid' => $_GPC['store_typeid']));
		if (empty($_GPC['log']) || empty($_GPC['lat'])) {
			$location = $this->locationByIP(CLIENT_IP);
			$_GPC['log'] = $location['lng'];
			$_GPC['lat'] = $location['lat'];
		}
		if (!empty($_GPC['log']) && !empty($_GPC['lat'])) {
			$stores = LBSStore($stores, $_GPC['log'], $_GPC['lat']);
		}
		include $this->template('storelist');
	}
	public function doMobileAjaxStore()
	{
		global $_GPC, $_W;
		$circle_id = $_GPC['circle_id'];
		$content = $_GPC['content'];
		$option['search']['store_name'] = $content;
		$option['search']['store_circleid'] = $circle_id;
		$result = selectStore($option, 2);
		$stores = $result['records'];
		$str = '';
		if (!empty($stores)) {
			if ($_W['uniaccount']['level'] == 4 && !empty($_GPC['log']) && !empty($_GPC['lat'])) {
				$stores = LBSStore($stores, $_GPC['log'], $_GPC['lat']);
			}
			foreach ($stores as $key => $item) {
				$str .= ' <a href="' . $this->createMobileUrl('info', array('store_id' => $item['store_id'])) . '">
                <li>
                    <div class="con02-image col-xs-4">

                        <img src="' . tomedia($item['store_pic']) . '">

                    </div>
                    <ul class="con02-r col-xs-7">
                        <li>
                            <div class="con02-text02">' . $item['store_name'] . '</div>
                           
                        </li>
                        <li>
                            <div class="con02-text05">' . $item['circle_name'] . '</div>
                        </li>
                        <li>
                            <div class="con02-text06">' . $item['store_tel'] . '</div>';
				if (!empty($item['distance'])) {
					$str .= '<div class="con02-text07">
                                <div class="con02-text08">' . $item['distance'] . 'km</div>
                                <img src="' . RES . 'mobile/images/location.png">
                            </div>';
				}
				$str .= ' </li>
                    </ul>
                </li>
            </a>';
			}
		} else {
			$str .= '<li style="padding: 10px;text-align: center">
                <img src="' . RES . 'mobile/images/clear.png" style="height: 50px" alt="">
                <p>未找到相关门店</p>
            </li>';
		}
		echo $str;
	}
	public function doMobileLoadStore()
	{
		global $_GPC, $_W;
		$lat = $_GPC['lat'];
		$log = $_GPC['log'];
		$circle_id = $_GPC['circle_id'];
		$page = $_GPC['page'];
		if (!empty($page)) {
			$pindex = $page;
			$psize = 10;
			$option['search']['store_circleid'] = $_GPC['circle_id'];
			$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectStore($option, 2);
			$stores = $result['records'];
			foreach ($stores as $key => $item) {
				$business = pdo_get($this->tb_business, array('business_id' => $item['store_businessid'], 'business_uniacid' => $_W['uniacid']));
				if (!empty($business['business_package'])) {
					$value = time() - $business['business_time_use'];
					if ($business['business_package'] == 1) {
						if ($value > 365 * 24 * 60 * 60) {
							unset($stores[$key]);
						}
					} else {
						if ($business['business_package'] == 2) {
							if ($value > 90 * 24 * 60 * 60) {
								unset($stores[$key]);
							}
						} else {
							if ($business['business_package'] == 3) {
								if ($value > 30 * 24 * 60 * 60) {
									unset($stores[$key]);
								}
							}
						}
					}
				}
			}
			$total = $result['total'];
			if (empty($stores)) {
				$data['result'] = 'fail';
				$data['error'] = '为获取相关门店';
			} else {
				if ($_W['uniaccount']['level'] == 4 && !empty($_GPC['log']) && !empty($_GPC['lat'])) {
					$stores = LBSStore($stores, $_GPC['log'], $_GPC['lat']);
				}
				$str = '';
				foreach ($stores as $key => $item) {
					$str .= ' <a href="' . $this->createMobileUrl('info', array('store_id' => $item['store_id'])) . '">
                <li>
                    <div class="con02-image col-xs-4">

                        <img src="' . tomedia($item['store_pic']) . '">

                    </div>
                    <ul class="con02-r col-xs-7">
                        <li>
                            <div class="con02-text02">' . $item['store_name'] . '</div>
                           
                        </li>
                        <li>
                            <div class="con02-text05">' . $item['circle_name'] . '</div>
                        </li>
                        <li>
                            <div class="con02-text06">' . $item['store_tel'] . '</div>';
					if (!empty($item['distance'])) {
						$str .= '<div class="con02-text07">
                                <div class="con02-text08">' . $item['distance'] . 'km</div>
                                <img src="' . RES . 'mobile/images/location.png">
                            </div>';
					}
					$str .= ' </li>
                    </ul>
                </li>
            </a>';
				}
				$data['result'] = 'success';
				$data['store'] = $str;
				if ($total > $page) {
					$data['page'] = $page + 1;
				} else {
					$data['page'] = 0;
				}
			}
		} else {
			$data['result'] = 'fail';
			$data['error'] = '为获取到到页数';
		}
		echo json_encode($data);
	}
	public function doMobileCircle()
	{
		global $_W, $_GPC;
		$log = $_GPC['log'];
		$lat = $_GPC['lat'];
		if (!empty($log) && !empty($lat)) {
			$url = 'http://api.map.baidu.com/geocoder/v2/?callback=renderReverse&location=' . $lat . ',' . $log . '&output=json&pois=1&ak=DFeb602c2287c0365ddc5776ee79af22';
			$result = _request($url, false);
			$result = str_replace('renderReverse&&renderReverse(', '', $result);
			$result = str_replace(')', '', $result);
			$result = json_decode($result, true);
			$now_city = $result['result']['addressComponent']['city'];
		}
		$circle = "select distinct circle_city from " . tablename($this->tb_circle) . " where circle_uniacid = " . $_W['uniacid'] . " ORDER BY circle_id desc ";
		$res = pdo_fetchall($circle);
		if (!empty($now_city)) {
			foreach ($res as $key => $value) {
				if ($value['circle_city'] == $now_city) {
					unset($res[$key]);
					array_unshift($res, $value);
				}
			}
		}
		foreach ($res as $key => $item) {
			$circle = pdo_getall($this->tb_circle, array('circle_city' => $item['circle_city'], 'circle_uniacid' => $_W['uniacid']), array('circle_name', 'circle_id'));
			$res[$key]['circles'] = $circle;
		}
		include $this->template('circle');
	}
	public function doMobileAjaxCircle()
	{
		global $_W, $_GPC;
		$option['search']['circle_name'] = $_GPC['content'];
		$result = selectCircle($option);
		$circles = $result['records'];
		$str = '';
		if (!empty($circles)) {
			foreach ($circles as $key => $item) {
				$str .= '<div class="tc-c">
                        <a href="' . $this->createMobileUrl('index', array('circle_id' => $item['circle_id'])) . '"><div class="tc-text02">' . $item['circle_name'] . '</div></a> </div>';
			}
		} else {
			$str = '<div class="tc-c">
                        <div class="tc-text02">未找到相关商圈</div>
                    </div>';
		}
		echo $str;
	}
	public function doMobileInfo()
	{
		global $_GPC, $_W;
		$openid = $_W['openid'];
		$store_id = $_GPC['store_id'];
		if (empty($store_id)) {
			message('未获取到门店信息');
		}
		$option['search']['store_id'] = $store_id;
		$result = selectStore($option);
		$store = end($result['records']);
		$store['store_info'] = html_entity_decode($store['store_info']);
		$urladdr = "http://apis.map.qq.com/tools/poimarker?type=0&";
		$urladdr .= "marker=coord:" . $store['store_lat'] . "," . $store['store_log'] . ";";
		$urladdr .= "title:" . $store['store_address'] . ";";
		$urladdr .= "addr:" . $store['store_address'];
		$urladdr .= "&key=OB4BZ-D4W3U-B7VVO-4PJWW-6TKDJ-WPB77&referer=myapp";
		$order_list = array();
		if ($openid != '') {
			$where['order_storeid'] = $store_id;
			$where['order_uniacid'] = $_W['uniacid'];
			$where['order_state >'] = 1;
			$where['order_state <'] = 4;
			$where['order_useropenid'] = $openid;
			$order_list = pdo_getall($this->tb_order, $where);
		}
		$ordercount = count($order_list);
		$sql = "select * from " . tablename($this->tb_collection) . " where collection_uniacid = :uniacid and collection_openid = :openid and collection_storeid = :storeid and collection_projectid is null and collection_staffid is null";
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':storeid' => $store_id);
		$collection = pdo_fetch($sql, $params);
		include $this->template('info');
	}
	public function doMobileAjaxCollection()
	{
		global $_W, $_GPC;
		$storeid = $_POST['storeid'];
		$projectid = $_POST['projectid'];
		$staffid = $_POST['staffid'];
		if (!empty($storeid)) {
			$collection['collection_storeid'] = $storeid;
		}
		if (!empty($projectid)) {
			$collection['collection_projectid'] = $projectid;
		}
		if (!empty($staffid)) {
			$collection['collection_staffid'] = $staffid;
		}
		$collection['collection_openid'] = $_W['openid'];
		$collection['collection_uniacid'] = $_W['uniacid'];
		$log = pdo_get($this->tb_collection, $collection);
		if (empty($log)) {
			$collection['collection_time_add'] = nowDate;
			$res = pdo_insert($this->tb_collection, $collection);
			$state = 1;
		} else {
			$res = pdo_delete($this->tb_collection, array('collection_id' => $log['collection_id']));
			$state = 2;
		}
		if ($res) {
			echo $state;
		}
	}
	public function doMobileconmmentlist()
	{
		global $_W, $_GPC;
		$store_id = $_GPC['store_id'];
		$pagesize = $_GPC['pageSize'];
		$lastID = $_GPC['lastID'];
		$store_list = pdo_get($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_id' => $store_id));
		$sql = " SElECT * FROM " . tablename($this->tb_comment);
		$sql .= " where comment_uniacid=:comment_uniacid ";
		$sql .= " and comment_id<:comment_id ";
		$sql .= " and comment_storeid =:comment_storeid ";
		$sql .= " and comment_state = 2 ";
		$params = array(':comment_uniacid' => $_W['uniacid'], ':comment_id' => $lastID, ':comment_storeid' => $store_id);
		$sql .= " order by comment_id desc limit 0," . $pagesize;
		$rs = pdo_fetchall($sql, $params);
		foreach ($rs as $k => $v) {
			$sss = getnicknameavatar($v['comment_openid']);
			$rs[$k]['fans_avatar'] = $sss['avatar'];
			$rs[$k]['fans_nickname'] = $sss['nickname'];
		}
		if (!empty($rs)) {
			$data['rs'] = $rs;
			$data['result'] = 'success';
		} else {
			$data['result'] = 'error';
		}
		echo json_encode($data);
	}
	public function doMobileComment()
	{
		global $_W, $_GPC;
		$formrs = $_GPC['comment'];
		$openid = $_W['openid'];
		$store_id = $formrs['comment_storeid'];
		if ($openid == '') {
			message('没有获取到粉丝信息');
		}
		$sql = " select * from " . tablename($this->tb_order);
		$sql .= " where order_storeid =" . $store_id;
		$sql .= " and order_uniacid = " . $_W['uniacid'];
		$sql .= " and order_state = 3 ";
		$sql .= " and order_useropenid = '" . $openid . "' ";
		$order_one_list = pdo_fetch($sql);
		if (empty($order_one_list)) {
			message('请完成预约后才可以评论哦!');
		}
		$store = pdo_get($this->tb_store, array('store_id' => $store_id));
		$insert_comment = $formrs;
		$insert_comment['comment_openid'] = $openid;
		$insert_comment['comment_nickname'] = $_W['fans']['nickname'];
		$insert_comment['comment_uniacid'] = $_W['uniacid'];
		if ($store['store_comment_state'] == 2) {
			$insert_comment['comment_state'] = 1;
		} else {
			$insert_comment['comment_state'] = 2;
			$cretid1 = $this->config['comment_cretid1'];
			if ($cretid1 > 0) {
				load()->model('mc');
				$fansuid = mc_openid2uid($openid);
				mc_credit_update($fansuid, 'credit1', $cretid1, array($fansuid, "预约系统评论奖励", 'wxlm_appointment'));
			}
		}
		$insert_comment['comment_time_add'] = date('Y-m-d H:i:s');
		$result = pdo_insert($this->tb_comment, $insert_comment);
		$comment_id = pdo_insertid();
		if ($result) {
			$update['order_commentstate'] = 2;
			$result2 = pdo_update($this->tb_order, $update, array('order_id' => $order_one_list['order_id']));
			if ($store['store_comment_state'] == 2) {
				message('评论成功, 等待审核！', '', 'success');
			} else {
				message('评论成功！', '', 'success');
			}
		}
	}
	public function doMobileProject()
	{
		global $_W, $_GPC;
		$store_id = $_GPC['store_id'];
		$store = pdo_get($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_id' => $store_id));
		if (empty($store)) {
			message('未获取到门店信息', $this->createMobileUrl('index', array()), 'error');
		}
		$ptypes = pdo_getall($this->tb_ptype, array('ptype_uniacid' => $_W['uniacid'], 'ptype_businessid' => $store['store_businessid']), array(), '', 'ptype_order DESC');
		$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $store['store_businessid'], 'project_state =' => 2), array(), '', 'project_order DESC');
		foreach ($projects as $key => $item) {
			$business = pdo_get($this->tb_business, array('business_id' => $item['project_businessid'], 'business_uniacid' => $_W['uniacid']));
			if (!empty($business['business_package'])) {
				$value = time() - $business['business_time_use'];
				if ($business['business_package'] == 1) {
					if ($value > 365 * 24 * 60 * 60) {
						unset($projects[$key]);
					}
				} else {
					if ($business['business_package'] == 2) {
						if ($value > 90 * 24 * 60 * 60) {
							unset($projects[$key]);
						}
					} else {
						if ($business['business_package'] == 3) {
							if ($value > 30 * 24 * 60 * 60) {
								unset($projects[$key]);
							}
						}
					}
				}
			}
		}
		if (empty($projects)) {
			message('该门店暂未提预约何服务项目', $this->createMobileUrl('index', array()), 'error');
		}
		include $this->template('project');
	}
	public function doMobilePtype()
	{
		global $_GPC, $_W;
		$ptype_id = $_POST['type'];
		$store_id = $_POST['store'];
		$business_id = $_POST['business'];
		if ($ptype_id == 0) {
			$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $business_id, 'project_state =' => 2), array(), '', 'project_order DESC');
		} else {
			$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $business_id, 'project_state =' => 2, 'project_type' => $ptype_id), array(), '', 'project_order DESC');
		}
		foreach ($projects as $key => $item) {
			$business = pdo_get($this->tb_business, array('business_id' => $item['project_businessid'], 'business_uniacid' => $_W['uniacid']));
			if (!empty($business['business_package'])) {
				$value = time() - $business['business_time_use'];
				if ($business['business_package'] == 1) {
					if ($value > 365 * 24 * 60 * 60) {
						unset($projects[$key]);
					}
				} else {
					if ($business['business_package'] == 2) {
						if ($value > 90 * 24 * 60 * 60) {
							unset($projects[$key]);
						}
					} else {
						if ($business['business_package'] == 3) {
							if ($value > 30 * 24 * 60 * 60) {
								unset($projects[$key]);
							}
						}
					}
				}
			}
		}
		$str = '';
		foreach ($projects as $key => $item) {
			if (empty($item['project_pic'])) {
				$str .= '<li class="col-xs-6">';
				if ($item['project_info_state'] == 2) {
					$str .= '<a href="' . $this->createMobileUrl('projectInfo', array('project_id' => $item['project_id'], 'store_id' => $store_id)) . '">' . $item['project_name'] . '</a></li>';
				} else {
					$str .= ' <a href="' . $this->createMobileUrl('staff', array('project_id' => $item['project_id'], 'store_id' => $store_id)) . '">' . $item['project_name'] . '</a></li>';
				}
			} else {
				$str .= ' <li class="col-xs-12">';
				if ($item['project_info_state'] == 2) {
					$str .= '<a href="' . $this->createMobileUrl('projectInfo', array('project_id' => $item['project_id'], 'store_id' => $store_id)) . '">
                    <img src="' . tomedia($item['project_pic']) . '">
                </a></li>';
				} else {
					$str .= '<a href="' . $this->createMobileUrl('staff', array('project_id' => $item['project_id'], 'store_id' => $store_id)) . '">
                    <img src="' . tomedia($item['project_pic']) . '">
                </a></li>';
				}
			}
		}
		echo $str;
	}
	public function doMobileProjectInfo()
	{
		global $_W, $_GPC;
		$store_id = $_GPC['store_id'];
		$project_id = $_GPC['project_id'];
		$project = pdo_get($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_id' => $project_id));
		if (empty($project)) {
			message('未获取项目信息', '', 'error');
		}
		$sql = "select * from " . tablename($this->tb_collection) . " where collection_uniacid = :uniacid and collection_openid = :openid and collection_storeid = :storeid and collection_projectid = :projectid and collection_staffid is null";
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':storeid' => $store_id, ':projectid' => $project_id);
		$collection = pdo_fetch($sql, $params);
		include $this->template('projectInfo');
	}
	public function doMobileStaff()
	{
		global $_W, $_GPC;
		$store_id = $_GPC['store_id'];
		$project_id = $_GPC['project_id'];
		$store = pdo_get($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_id' => $store_id), array('store_name'));
		$project = pdo_get($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_id' => $project_id), array('project_name'));
		$datings = pdo_getall($this->tb_dating, array('dating_uniacid' => $_W['uniacid'], 'dating_storeid' => $store_id, 'dating_projectid' => $project_id), array('dating_staffid', 'dating_id'));
		if (empty($datings)) {
			message('项目暂时未提供预约服务', '', 'error');
		}
		foreach ($datings as $key => $item) {
			$business = pdo_get($this->tb_business, array('business_id' => $item['dating_businessid'], 'business_uniacid' => $_W['uniacid']));
			if (!empty($business['business_package'])) {
				$value = time() - $business['business_time_use'];
				if ($business['business_package'] == 1) {
					if ($value > 365 * 24 * 60 * 60) {
						unset($datings[$key]);
						continue;
					}
				} else {
					if ($business['business_package'] == 2) {
						if ($value > 90 * 24 * 60 * 60) {
							unset($datings[$key]);
							continue;
						}
					} else {
						if ($business['business_package'] == 3) {
							if ($value > 30 * 24 * 60 * 60) {
								unset($datings[$key]);
								continue;
							}
						}
					}
				}
			}
			$staff = pdo_get($this->tb_staff, array('staff_uniacid' => $_W['uniacid'], 'staff_id' => $item['dating_staffid']));
			$fabulous_where['fabulous_staffid'] = $item['dating_staffid'];
			$fabulous_where['fabulous_uniacid'] = $_W['uniacid'];
			$fabulous_list = pdo_getall($this->tb_fabulous, $fabulous_where);
			$point = $staff['staff_pointnumber'] != '' ? $staff['staff_pointnumber'] : 0;
			$count = $point;
			if (floatval(count($fabulous_list)) > floatval($point)) {
				$count = count($fabulous_list);
			}
			$sss = '';
			if (floatval($count) >= floatval(10000)) {
				$sss = round($count / 10000, 2) . '00W';
			} else {
				if (floatval($count) >= floatval(1000)) {
					$sss = round($count / 1000, 2) . 'K';
				} else {
					$sss = $count;
				}
			}
			$datings[$key]['staff'] = $staff;
			$datings[$key]['count'] = $sss;
		}
		include $this->template('staff');
	}
	public function doMobileDating()
	{
		global $_GPC, $_W;
		$dating_id = $_GPC['dating_id'];
		$dating = pdo_get($this->tb_dating, array('dating_id' => $dating_id, 'dating_uniacid' => $_W['uniacid']), array('dating_time', 'dating_pay_money', 'dating_week', 'dating_staffid', 'dating_id', 'dating_pay_state', 'dating_storeid'));
		if (empty($dating)) {
			message('未获取到预约信息', '', 'error');
		}
		$staff = pdo_get($this->tb_staff, array('staff_id' => $dating['dating_staffid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('未获取到员工信息', '', 'error');
		}
		$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_staffid' => $staff['staff_id']));
		$tags = pdo_getall($this->tb_scommenttag, array('scommenttag_uniacid' => $_W['uniacid']));
		$tags_new = array();
		foreach ($tags as $key => $item) {
			$tags_new[$item['scommenttag_id']] = $item['scommenttag_title'];
		}
		foreach ($scomments as $key => $item) {
			if (!empty($item['scomment_tag'])) {
				$item['scomment_tag'] = explode(',', $item['scomment_tag']);
				foreach ($item['scomment_tag'] as $row) {
					$scomments[$key]['tag'][] = $tags_new[$row];
				}
			}
		}
		$sql_1 = "select count(*) from " . tablename($this->tb_scomment) . " where scomment_uniacid = :uniacid and scomment_staffid = :staffid and scomment_level = :level ";
		$total_5 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 5));
		$total_4 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 4));
		$total_3 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 3));
		$total_2 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 2));
		$total_1 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 1));
		$times = json_decode($dating['dating_time'], true);
		$dating['dating_week'] = json_decode($dating['dating_week'], true);
		$count = 0;
		foreach ($times as $key => $item) {
			$count += $item['count'];
		}
		$week = date('Y-m-d');
		$weeks = riqi($week);
		foreach ($weeks as $key => $item) {
			if (!in_array($key, $dating['dating_week'])) {
				unset($weeks[$key]);
			}
		}
		$week_ch = array(0 => '周日', 1 => '周一', 2 => '周二', 3 => '周三', 4 => '周四', 5 => '周五', 6 => '周六');
		if ($dating['dating_pay_state'] == 3) {
			$store = pdo_get($this->tb_store, array('store_id' => $dating['dating_storeid']), array('store_card_count'));
			$vip = pdo_get($this->tb_vip, array('vip_openid' => $_W['openid'], 'vip_pay' => 2, 'vip_credit_state' => 2, 'vip_uniacid' => $_W['uniacid']));
			if (!empty($vip)) {
				$sql = "SELECT COUNT(*) AS vip_count FROM " . tablename($this->tb_order) . " WHERE order_uniacid = :uniacid AND order_pay_type = :order_pay_type AND order_useropenid = :order_useropenid AND order_state != 4 ";
				$params = array(':uniacid' => $_W['uniacid'], ':order_pay_type' => 3, ':order_useropenid' => $_W['openid']);
				$vip_count = pdo_fetch($sql, $params);
			}
		}
		$order_list = array();
		$fabulous_list = array();
		$fabulous1 = 2;
		if ($_W['openid'] != '') {
			$order_where['order_storeid'] = $dating['dating_storeid'];
			$order_where['order_staffid'] = $dating['dating_staffid'];
			$order_where['order_uniacid'] = $_W['uniacid'];
			$order_where['order_useropenid'] = $_W['openid'];
			$order_where['order_state'] = 3;
			$order_list = pdo_getall($this->tb_order, $order_where);
			if (empty($order_list)) {
				$fabulous1 = 1;
			}
		} else {
			$fabulous1 = 1;
		}
		if ($fabulous1 == 2) {
			$fabulous_where['fabulous_staffid'] = $dating['dating_staffid'];
			$fabulous_where['fabulous_uniacid'] = $_W['uniacid'];
			$fabulous_where['fabulous_openid'] = $_W['openid'];
			$fabulous_where['fabulous_storeid'] = $dating['dating_storeid'];
			$fabulous_list = pdo_getall($this->tb_fabulous, $fabulous_where);
			if (empty($fabulous_list)) {
				$fabulous2 = 2;
			} else {
				$fabulous2 = 1;
			}
		}
		$sql = "select * from " . tablename($this->tb_collection) . " where collection_uniacid = :uniacid and collection_openid = :openid and collection_staffid = :staffid ";
		$params = array(':uniacid' => $_W['uniacid'], ':openid' => $_W['openid'], ':staffid' => $dating_id);
		$collection = pdo_fetch($sql, $params);
		include $this->template('dating');
	}
	public function doMobileGetScomment()
	{
		global $_W, $_GPC;
		$staff_id = $_GPC['staff'];
		$level = $_GPC['level'];
		if (empty($level)) {
			$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_staffid' => $staff_id));
		} else {
			$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_staffid' => $staff_id, 'scomment_level' => $level));
		}
		$tags = pdo_getall($this->tb_scommenttag, array('scommenttag_uniacid' => $_W['uniacid']));
		$tags_new = array();
		foreach ($tags as $key => $item) {
			$tags_new[$item['scommenttag_id']] = $item['scommenttag_title'];
		}
		foreach ($scomments as $key => $item) {
			if (!empty($item['scomment_tag'])) {
				$item['scomment_tag'] = explode(',', $item['scomment_tag']);
				foreach ($item['scomment_tag'] as $row) {
					$scomments[$key]['tag'][] = $tags_new[$row];
				}
			}
		}
		$str = '';
		foreach ($scomments as $key => $item) {
			$str .= '<li class="dz-app-listli">
                <div class="dz-app-listli-left">
                    <img src="' . tomedia($item['scomment_avatar']) . '">
                </div>
                <div class="dz-app-listli-right">
                    <p>' . $item['scomment_nickname'] . ' <span style="float:right;color:#6b6b6b;">' . $item['scomment_time_add'] . '</span></p>
                    <fieldset class="starability-grow starability-grow2">
                        <span style="font-size:14px;margin-top:-4px;">打分</span>
                        <label for="rate5-3" title="Amazing" class="lable-list ';
			if ($item['scomment_level'] == 5) {
				$str .= 'this-lable-list';
			}
			$str .= '">5 stars</label>
                        <label for="rate4-3" title="Very good" class="lable-list ';
			if ($item['scomment_level'] >= 4) {
				$str .= 'this-lable-list';
			}
			$str .= '">4 stars</label>
                        <label for="rate3-3" title="Average" class="lable-list ';
			if ($item['scomment_level'] >= 3) {
				$str .= 'this-lable-list';
			}
			$str .= '">3 stars</label>
                        <label for="rate2-3" title="Not good" class="lable-list ';
			if ($item['scomment_level'] >= 2) {
				$str .= 'this-lable-list';
			}
			$str .= '">2 stars</label>
                        <label for="rate1-3" title="Terrible" class="lable-list ';
			if ($item['scomment_level'] >= 1) {
				$str .= 'this-lable-list';
			}
			$str .= '">1 star</label>
                    </fieldset>
                    <p>';
			if (!empty($item['tag'])) {
				foreach ($item['tag'] as $row) {
					$str .= ' <span style="margin-right: 10px">' . $row . '</span>';
				}
			}
			$str .= '</p>
                    <p>' . $item['scomment_content'] . '</p>
                </div>
                <ul class="clear"></ul>
            </li>';
		}
		echo $str;
	}
	public function doMobileFabulous()
	{
		global $_GPC, $_W;
		$dating_id = $_GPC['dating_id'];
		$dating = pdo_get($this->tb_dating, array('dating_id' => $dating_id, 'dating_uniacid' => $_W['uniacid']), array('dating_time', 'dating_pay_money', 'dating_week', 'dating_staffid', 'dating_id', 'dating_pay_state', 'dating_storeid'));
		if (empty($dating)) {
			$data['result'] = 'error';
			$data['rs'] = '未获取到预约信息';
			echo json_encode($data);
			die;
		}
		$staff = pdo_get($this->tb_staff, array('staff_id' => $dating['dating_staffid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			$data['result'] = 'error';
			$data['rs'] = '未获取到员工信息';
			echo json_encode($data);
			die;
		}
		$fabulous_where['fabulous_staffid'] = $dating['dating_staffid'];
		$fabulous_where['fabulous_uniacid'] = $_W['uniacid'];
		$fabulous_where['fabulous_openid'] = $_W['openid'];
		$fabulous_where['fabulous_storeid'] = $dating['dating_storeid'];
		$fabulous_list = pdo_getall($this->tb_fabulous, $fabulous_where);
		if (empty($fabulous_list)) {
			$fabulous_insert['fabulous_staffid'] = $dating['dating_staffid'];
			$fabulous_insert['fabulous_uniacid'] = $_W['uniacid'];
			$fabulous_insert['fabulous_openid'] = $_W['openid'];
			$fabulous_insert['fabulous_storeid'] = $dating['dating_storeid'];
			$fabulous_insert['fabulous_time_add'] = date('Y-m-d H:i:s');
			$result = pdo_insert($this->tb_fabulous, $fabulous_insert);
			if ($result) {
				$data['result'] = 'success';
				$data['rs'] = '点赞成功！';
				echo json_encode($data);
				die;
			} else {
				$data['result'] = 'error';
				$data['rs'] = '点赞失败！';
				echo json_encode($data);
				die;
			}
		} else {
			$data['result'] = 'success';
			$data['rs'] = '点赞成功！';
			echo json_encode($data);
			die;
		}
	}
	public function doMobileTime()
	{
		global $_W, $_GPC;
		$time = $_GPC['time'];
		$dating_id = $_GPC['dating_id'];
		$dating = pdo_get($this->tb_dating, array('dating_uniacid' => $_W['uniacid'], 'dating_id' => $dating_id));
		if (empty($dating)) {
			message('未获取到预约信息', '', 'error');
		}
		$dating['dating_time'] = json_decode($dating['dating_time'], true);
		$time_count = getTimeCount($dating, $time);
		foreach ($dating['dating_time'] as $key => $item) {
			$switch_sql = "select * from " . tablename($this->tb_switch) . " where switch_uniacid = :uniacid and switch_state = 2 and switch_day = :switch_day and switch_day_start = :switch_day_start and switch_day_end = :switch_day_end and switch_staffid = :staffid ";
			$switch_params = array(':uniacid' => $_W['uniacid'], ':switch_day' => $time, ':switch_day_start' => $item['start'], ':switch_day_end' => $item['end'], ':staffid' => $dating['dating_staffid']);
			$switch = pdo_fetch($switch_sql, $switch_params);
			if (!empty($switch)) {
				$switch['switch_datingid'] = json_decode($switch['switch_datingid'], true);
				if (in_array($dating['dating_id'], $switch['switch_datingid'])) {
					$dating['dating_time'][$key]['switch'] = 2;
				}
			}
		}
		include $this->template('time');
	}
	public function doMobileOrder()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : 'post';
		if ($op == 'display') {
			$day = $_GPC['day'];
			$start = $_GPC['start'];
			$end = $_GPC['end'];
			$dating_id = $_GPC['dating_id'];
			$dating = pdo_get($this->tb_dating, array('dating_id' => $dating_id));
			if (empty($dating)) {
				message('未获取到预约信息', '', 'error');
			}
			$project = pdo_get($this->tb_project, array('project_id' => $dating['dating_projectid'], 'project_uniacid' => $_W['uniacid']), array('project_name'));
			$staff = pdo_get($this->tb_staff, array('staff_id' => $dating['dating_staffid'], 'staff_uniacid' => $_W['uniacid']), array('staff_name'));
			load()->model('mc');
			$uid = mc_openid2uid($_W['openid']);
			$fans = pdo_get('mc_members', array('uid' => $uid, 'uniacid' => $_W['uniacid']), array('mobile', 'realname', 'avatar', 'nickname'));
			if ($dating['dating_pay_state'] == 2 && $dating['dating_add_pay'] == 2) {
				$vip = pdo_get($this->tb_vip, array('vip_openid' => $_W['openid'], 'vip_pay' => 2, 'vip_credit_state' => 2, 'vip_uniacid' => $_W['uniacid']));
			}
			include $this->template('order');
		} else {
			if ($op == 'post') {
				if (checksubmit()) {
					if ($_POST['order']) {
						$order = $_POST['order'];
						$dating_id = $_POST['dating_id'];
						$dating = pdo_get($this->tb_dating, array('dating_id' => $dating_id));
						if (empty($dating)) {
							message('未获取到预约信息', '', 'error');
						}
						$dating['dating_time'] = json_decode($dating['dating_time'], true);
						if (strtotime($order['order_dating_day'] . ' ' . $order['order_dating_start']) - time() < 0) {
							message('预约时间已过, 请选择其他时间预约', '', 'error');
						}
						if (strtotime($order['order_dating_day'] . ' ' . $order['order_dating_start']) - time() < $dating['dating_delay'] * 60) {
							message('请提前 ' . $dating['dating_delay'] . '分钟预约', '', 'error');
						}
						if ($dating['dating_pay_state'] == 3 || $_POST['pay_action'] == 2) {
							$vip = pdo_get($this->tb_vip, array('vip_openid' => $_W['openid'], 'vip_pay' => 2, 'vip_credit_state' => 2, 'vip_uniacid' => $_W['uniacid']));
							if (empty($vip)) {
								message('本次预约需要会员卡, 前往购买', $this->createMobileUrl('card'), 'error');
							}
							if ($vip['vip_type'] == 1) {
								$sql = "SELECT COUNT(*) AS vip_count FROM " . tablename($this->tb_order) . " WHERE order_uniacid = :uniacid AND order_pay_type = :order_pay_type AND order_useropenid = :order_useropenid AND order_state != 4 ";
								$params = array(':uniacid' => $_W['uniacid'], ':order_pay_type' => 3, ':order_useropenid' => $_W['openid']);
								$vip_count = pdo_fetch($sql, $params);
								$store = pdo_get($this->tb_store, array('store_id' => $dating['dating_storeid']), array('store_card_count'));
								if ($vip_count['vip_count'] >= $store['store_card_count']) {
									message('您的预约会员卡使用次数已达上限, 请联系门店负责人或上门咨询', '', 'error');
								}
							}
						}
						$order_count = pdo_getall($this->tb_order, array('order_storeid' => $dating['dating_storeid'], 'order_projectid' => $dating['dating_projectid'], 'order_staffid' => $dating['dating_staffid'], 'order_dating_day' => $order['order_dating_day'], 'order_dating_start' => $order['order_dating_start'], 'order_dating_end' => $order['order_dating_end'], 'order_uniacid' => $_W['uniacid'], 'order_state >' => 1, 'order_state <' => 3), array('order_id'));
						foreach ($dating['dating_time'] as $key => $item) {
							if ($item['start'] == $order['order_dating_start'] && $item['end'] == $order['order_dating_end']) {
								if ($item['count'] <= count($order_count)) {
									message('当前时段预约人次已满, 请选择其他时段', '', 'error');
								}
							}
						}
						$number = getOrderNumber();
						if ($number == false) {
							message('订单异常请稍后再试', '', 'error');
						}
						if ($dating['dating_pay_state'] == 2) {
							if ($_POST['pay_action'] == 2) {
								$notice_state = 2;
								$pay_state = 2;
								$dating['dating_pay_state'] = 3;
							} else {
								$pay_state = 1;
								if ($dating['dating_notice_time'] == 1) {
									$notice_state = 2;
								} else {
									$notice_state = 1;
								}
							}
						} else {
							$notice_state = 2;
							$pay_state = 2;
						}
						$order['order_uniacid'] = $_W['uniacid'];
						$order['order_number'] = $number;
						$order['order_useropenid'] = $_W['openid'];
						$order['order_businessid'] = $dating['dating_businessid'];
						$order['order_storeid'] = $dating['dating_storeid'];
						$order['order_projectid'] = $dating['dating_projectid'];
						$order['order_staffid'] = $dating['dating_staffid'];
						$order['order_pay_type'] = $dating['dating_pay_state'];
						$order['order_pay_money'] = $dating['dating_pay_money'];
						$order['order_state'] = $pay_state;
						$order['order_notice'] = $notice_state;
						$order['order_time_add'] = nowDate;
						$order['order_time_update'] = nowDate;
						$order['order_commentstate'] = 1;
						$order['order_look'] = 1;
						$order['order_settlement'] = 1;
						$result = pdo_insert($this->tb_order, $order);
						if ($result) {
							$archive = pdo_get($this->tb_archive, array('archive_uniacid' => $_W['uniacid'], 'archive_openid' => $_W['openid']));
							if (empty($archive)) {
								$archive['archive_uniacid'] = $_W['uniacid'];
								$archive['archive_openid'] = $_W['openid'];
								$archive['archive_name'] = $order['order_username'];
								$archive['archive_tel'] = $order['order_userphone'];
								$avatar = $_W['fans']['avatar'];
								if (empty($avatar)) {
									$account_api = WeAccount::create();
									$info = $account_api->fansQueryInfo($_W['openid']);
									$avatar = $info["headimgurl"];
								}
								$archive['archive_avatar'] = $avatar;
								$archive['archive_admin'] = $order['order_staffid'];
								$archive['archive_time_add'] = nowDate;
								pdo_insert($this->tb_archive, $archive);
							} else {
								$archive_admin = explode(',', $archive['archive_admin']);
								if (!in_array($order['order_staffid'], $archive_admin)) {
									$archive_admin[] = $order['order_staffid'];
								}
								pdo_update($this->tb_archive, array('archive_admin' => implode(',', $archive_admin)), array('archive_id' => $archive['archive_id']));
							}
							if ($_POST['sync'] == 2) {
								load()->model('mc');
								$uid = mc_openid2uid($_W['openid']);
								pdo_update('mc_members', array('mobile' => $order['order_userphone'], 'realname' => $order['order_username']), array('uid' => $uid, 'uniacid' => $_W['uniacid']));
							}
							if ($notice_state == 2) {
								$notice = getconfigbytype('type5', $this->tb_config);
								if ($notice['notice_way'] == 1) {
									$this->sendTpl($number);
								} else {
									if ($notice['notice_way'] == 2) {
										$this->sendCustom($number);
									} else {
										if ($notice['notice_way'] == 3) {
											$this->sendMessage($number);
										}
									}
								}
							}
							if ($dating['dating_pay_state'] == 2) {
								header('location:' . $this->createMobileUrl('pay', array('order_number' => $number)));
								die;
							} else {
								message('订单已经完成', $this->createMobileUrl('mine', array()), 'success');
							}
						}
					}
				}
			}
		}
	}
	public function doMobilePay()
	{
		global $_W, $_GPC;
		$number = $_GPC['order_number'];
		$order = pdo_get($this->tb_order, array('order_number' => $number, 'order_uniacid' => $_W['uniacid']));
		if (empty($order)) {
			message('未获取到订单信息', '', 'error');
		}
		if ($order['order_state'] > 1) {
			message('订单已经支付或已关闭, 请选择其他订单', '', 'error');
		}
		$now_day = date('Y-m-d');
		if (strtotime($now_day) > strtotime($order['order_dating_day'])) {
			message('预约时间已过, 请选择其他预约时间', '', 'error');
		}
		$pay = getconfigbytype("type2", $this->tb_config);
		if ($pay['pay_way'] == 1 || empty($pay['pay_way'])) {
			$notify_url = $_W['siteroot'] . 'payment/wechat/notify.php';
			$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('payReturn', array('order_number' => $number, 'way' => 1)));
			$jspai = wxpay($order['order_pay_money'], 'wxlm_appointment', $number, $notify_url);
		} else {
			if ($pay['pay_way'] == 2) {
				$url = 'http://www.zwechat.com/weixinpay/index.php/FanqiejiaOauth/index/bm_id/' . $pay['bm_id'] . '/return_url/';
				$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('pingan')) . "&order_id=" . $order['order_id'];
				$return_url = str_replace("?", "&&", $return_url);
				$url .= base64_encode($return_url);
			} else {
				if ($pay['pay_way'] == 3) {
					$teegonUrl = $this->createMobileUrl('teegon', array('order_number' => $number));
				}
			}
		}
		include $this->template('pay');
	}
	public function doMobileCheckOrder()
	{
		global $_GPC, $_W;
		$order_number = $_GPC['order_number'];
		$order = pdo_get($this->tb_order, array('order_number' => $order_number, 'order_uniacid' => $_W['uniacid']), array('order_state'));
		if ($order['order_state'] == 1) {
			echo 1;
		} else {
			echo 2;
		}
	}
	public function doMobileTeegon()
	{
		global $_GPC, $_W;
		$number = $_GPC['order_number'];
		$order = pdo_get($this->tb_order, array('order_number' => $number, 'order_uniacid' => $_W['uniacid']));
		$notify_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('payNotify', array('way' => 2)));
		$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('payReturn', array('order_number' => $number)));
		$param['order_no'] = $order['order_number'];
		$param['channel'] = 'wxpay_jsapi';
		$param['return_url'] = $return_url;
		$param['amount'] = $order['order_pay_money'];
		$param['subject'] = '支付';
		$param['metadata'] = '';
		$param['notify_url'] = $notify_url;
		$param['wx_openid'] = '';
		$srv = new TeegonService(TEE_API_URL);
		echo $srv->pay($param, false);
		exit;
	}
	public function doMobilePingan()
	{
		global $_GPC, $_W;
		$pay = getconfigbytype("type2", $this->tb_config);
		$openid = $_GPC['openid'];
		$order_id = $_GPC['order_id'];
		$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']), array('order_pay_money', 'order_number'));
		if (empty($order)) {
			message('未获取到订单信息', $this->createMobileUrl('mine'), 'error');
		}
		$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('payReturn', array('order_number' => $order['order_number'])));
		$notify_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('payNotify', array('way' => '3')));
		$account_api = WeAccount::create();
		$token = $account_api->getAccessToken();
		if (is_error($token)) {
			message('获取Access token 失败');
		}
		$url = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token=' . $token;
		$longurl = $return_url;
		$data_http = '{"action":"long2short","long_url":"' . $longurl . '"}';
		$result = httpPost($url, $data_http);
		$result = json_decode($result, true);
		$return_url = $result['short_url'];
		$url = 'http://www.zwechat.com/weixinpay/index.php/Fanqiejia/getOrderInfo';
		$data['b_id'] = $pay['b_id'];
		$data['bm_id'] = $pay['bm_id'];
		$data['openid'] = $openid;
		$data['price'] = $order['order_pay_money'];
		$data['order_no'] = $order['order_number'];
		$data['notify_url'] = $notify_url;
		$result = _request($url, true, 'post', $data);
		$result = json_decode($result, true);
		header('location:' . 'https://openapi-liquidation.51fubei.com/payPage/?prepay_id=' . $result['prepay_id'] . '&callback_url=' . $return_url);
	}
	public function doMobilePayNotify()
	{
		global $_GPC, $_W;
		$order_number = $_GPC['order_no'];
		$way = $_GPC['way'];
		if (!empty($order_number)) {
			if ($way == 1) {
				$order_paynumber = $_GPC['transaction_id'];
			}
			if ($way == 2) {
				$order_paynumber = $_GPC['charge_id'];
			}
			if ($way == 3) {
				if (!empty($_GPC['order_info'])) {
					$order_paynumber = $_POST['order_sn'];
				}
			}
			$res = pdo_update($this->tb_order, array('order_state' => 2, 'order_paynumber' => $order_paynumber, 'order_pay_state' => $way), array('order_number' => $order_number, 'order_uniacid' => $_W['uniacid']));
		}
	}
	public function doMobilePayReturn()
	{
		global $_GPC, $_W;
		$order_number = $_GPC['order_number'];
		$order = pdo_get($this->tb_order, array('order_uniacid' => $_W['uniacid'], 'order_number' => $order_number), array('order_state', 'order_notice'));
		if ($order['order_state'] == 1) {
			if ($_GPC['way'] == 1) {
				$pay_log = pdo_get('core_paylog', array('tid' => $order_number, 'module' => 'wxlm_appointment'));
				if ($pay_log['uniontid'] != '') {
					$order_update['order_paynumber'] = $pay_log['uniontid'];
				}
				$order_update['order_pay_state'] = 1;
				pdo_update($this->tb_order, $order_update, array('order_number' => $order_number, 'order_uniacid' => $_W['uniacid']));
				$weixinpay = new WeiXinPay();
				$pay = getconfigbytype("type2", 'wxlm_appointment_config');
				$weixinpay->wxpay = array('appid' => $pay['appid'], 'mch_id' => $pay['mchid'], 'key' => $pay['apikey']);
				$result = $weixinpay->queryOrder($pay_log['uniontid'], 2);
				if ($result['result_code'] == 'SUCCESS') {
					pdo_update($this->tb_order, array('order_state' => 2), array('order_number' => $order_number));
				}
			}
		}
		if ($order['order_notice'] == 1) {
			$notice = getconfigbytype('type5', $this->tb_config);
			if ($notice['notice_way'] == 1) {
				$this->sendTpl($order_number);
			} else {
				if ($notice['notice_way'] == 2) {
					$this->sendCustom($order_number);
				} else {
					if ($notice['notice_way'] == 3) {
						$this->sendMessage($order_number);
					}
				}
			}
			pdo_update($this->tb_order, array('order_notice' => '2'), array('order_number' => $order_number, 'order_uniacid' => $_W['uniacid']));
		}
		message('支付成功', $this->createMobileUrl('mine', array('op' => 'payok')), 'success');
	}
	public function doMobileRefund()
	{
		global $_W, $_GPC;
		$pay = getconfigbytype("type2", $this->tb_config);
		$order = pdo_get($this->tb_order, array('order_state' => 2, 'order_id' => $_GPC['order_id']));
		if (empty($order)) {
			message('您的订单无法退款, 请联系商家.', $this->createMobileUrl('mine'), 'error');
		}
		$orderrefund_list = pdo_get($this->tb_orderrefund, array('orderrefund_uniacid' => $_W['uniacid'], 'orderrefund_useropenid' => $order['order_useropenid'], 'orderrefund_number' => $order['order_number']));
		$result = true;
		if ($order['order_pay_state'] == 2) {
			message('暂不支持退款, 请联系商家', $this->createMobileUrl('min'), 'error');
			die;
		}
		if (empty($orderrefund_list)) {
			$insert_refund = array();
			$insert_refund['orderrefund_uniacid'] = $_W['uniacid'];
			$insert_refund['orderrefund_useropenid'] = $order['order_useropenid'];
			$insert_refund['orderrefund_number'] = $order['order_number'];
			$insert_refund['orderrefund_money'] = $order['order_pay_money'];
			$insert_refund['orderrefund_state'] = 1;
			$insert_refund['orderrefund_addtime'] = date('Y-m-d H:i:s');
			$insert_refund['orderrefund_updatetime'] = date('Y-m-d H:i:s');
			$result = pdo_insert($this->tb_orderrefund, $insert_refund);
			message('退款成功,等待后台审核', $this->createMobileUrl('mine'), 'success');
		} else {
			if ($orderrefund_list['orderrefund_state'] == 2) {
				message('已成功退款！', $this->createMobileUrl('mine'), 'error');
				die;
			}
			if ($orderrefund_list['orderrefund_state'] == 1) {
				message('已申请退款，请耐心等待审核!', $this->createMobileUrl('mine'), 'error');
			}
		}
	}
	public function doMobileMine()
	{
		global $_W, $_GPC;
		if (empty($_W['openid'])) {
			message('未获取到用户信息');
		}
		$archive = pdo_get($this->tb_archive, array('archive_uniacid' => $_W['uniacid'], 'archive_openid' => $_W['openid']));
		if (empty($archive)) {
			load()->model('mc');
			$uid = mc_openid2uid($_W['openid']);
			$fans = pdo_get('mc_members', array('uid' => $uid, 'uniacid' => $_W['uniacid']), array('mobile', 'realname', 'avatar', 'nickname'));
			if (empty($fans['avater']) || empty($fans['nickname'])) {
				$userinfo = mc_oauth_userinfo();
				$archive['archive_name'] = $userinfo['nickname'];
				$archive['archive_avatar'] = $userinfo['headimgurl'];
			}
		}
		if (empty($archive['archive_avatar'])) {
			$archive['archive_avatar'] = RES . 'mobile/images/avatar.png';
		}
		include $this->template('center');
	}
	public function doMobileMineOrder()
	{
		global $_W, $_GPC;
		if (empty($_W['openid'])) {
			message('未获取到用户信息');
		}
		$op = empty($_GPC['op']) ? 'all' : $_GPC['op'];
		$base = getconfigbytype('type1', $this->tb_config);
		$ordercanceltime = $base['order_cancel_time'] != '' ? $base['order_cancel_time'] : 0;
		$ordercancel = $base['order_cancel'] != '' ? $base['order_cancel'] : 2;
		$orderrefundtime = $base['order_refund_time'] != '' ? $base['order_refund_time'] : 0;
		$orderrefund = $base['order_refund'] != '' ? $base['order_refund'] : 2;
		if ($ordercancel == 1 && $ordercanceltime != 0) {
			$olddate = date('Y-m-d H:i:s', strtotime('-' . $ordercanceltime . ' hours'));
			$nowdate = date('Y-m-d H:i:s');
			$sql = " update " . tablename($this->tb_order) . " set ";
			$sql .= " order_state = 5 ";
			$sql .= " where order_uniacid = " . $_W['uniacid'];
			$sql .= " and order_state = 1 ";
			$sql .= " and order_useropenid = '" . $_W['openid'] . "' ";
			$sql .= " and order_time_add < '" . $olddate . "'";
			pdo_query($sql);
		}
		if ($op == 'all') {
			$order_state = '';
		} else {
			if ($op == 'payok') {
				$order_state = 2;
			} else {
				if ($op == 'payno') {
					$order_state = 1;
				} else {
					if ($op == 'refund') {
						$refund = 1;
					} else {
						if ($op == 'finish') {
							$order_state = 3;
						}
					}
				}
			}
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$option['search']['order_state'] = $order_state;
		$option['search']['order_useropenid'] = $_W['openid'];
		$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
		if ($refund == 1) {
			$option_refund['search']['order_useropenid'] = $_W['openid'];
			$option_refund['search']['orderrefund_state'] = 1;
			$option_refund["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
			$result = selectrefund($option);
		} else {
			$result = selectOrder($option);
		}
		$orders = $result['records'];
		$total = $result['total'];
		unset($result);
		$page = pagination($total, $pindex, $psize);
		if (!empty($orders)) {
			foreach ($orders as $key => $item) {
				if ($refund != 1) {
					$refund_id = pdo_get($this->tb_orderrefund, array('orderrefund_number' => $item['order_number']), array('orderrefund_id'));
					$orders[$key]['orderrefund_id'] = $refund_id['orderrefund_id'];
				}
				$project = pdo_get($this->tb_project, array('project_id' => $item['order_projectid'], 'project_uniacid' => $_W['uniacid']), array('project_name'));
				$orders[$key]['project_name'] = $project['project_name'];
				$store = pdo_get($this->tb_store, array('store_id' => $item['order_storeid'], 'store_uniacid' => $_W['uniacid']), array('store_pic', 'store_name', 'store_tel'));
				$orders[$key]['store_pic'] = $store['store_pic'];
				$orders[$key]['store_name'] = $store['store_name'];
				$orders[$key]['store_tel'] = $store['store_tel'];
				if ($orderrefund == 1 && $orderrefundtime != '' && $item['order_state'] == 2) {
					$refolddate = strtotime('-' . $orderrefundtime . ' minutes');
					$order1 = strtotime($item['order_time_add']);
					$cha = floatval($order1) - floatval($refolddate);
					if ($cha < 0) {
						$orders[$key]['order_refund'] = 2;
					} else {
						$orders[$key]['order_refund'] = 1;
					}
				}
				if ($item['order_state'] == 3) {
					$fabulous = pdo_get($this->tb_fabulous, array('fabulous_orderid' => $item['order_id'], 'fabulous_uniacid' => $_W['uniacid'], 'fabulous_openid' => $_W['openid']), array('fabulous_id'));
					if (empty($fabulous)) {
						$orders[$key]['fabulous'] = 1;
					} else {
						$orders[$key]['fabulous'] = 2;
					}
				}
			}
		}
		include $this->template('mineorder');
	}
	public function doMobileMineArchive()
	{
		global $_GPC, $_W;
		$openid = $_W['openid'];
		if (empty($openid)) {
			message('未获取到用户信息', $this->createMobileUrl('mine'), 'error');
		}
		if (checksubmit()) {
			$archive = $_POST['archive'];
			$archive['archive_time_update'] = nowDate;
			pdo_update($this->tb_archive, $archive, array('archive_openid' => $openid));
			message('个人档案修改成功', $this->createMobileUrl('mineArchive'), 'success');
		}
		$archive = pdo_get($this->tb_archive, array('archive_uniacid' => $_W['uniacid'], 'archive_openid' => $openid));
		if (empty($archive)) {
			if (empty($archive)) {
				$archive['archive_uniacid'] = $_W['uniacid'];
				$archive['archive_openid'] = $openid;
				$archive['archive_name'] = $_W['fans']['nickname'];
				$archive['archive_avatar'] = $_W['fans']['avatar'];
				if (empty($archive['archive_name']) || empty($archive['archive_avatar'])) {
					$account_api = WeAccount::create();
					$fans = $account_api->fansQueryInfo($openid);
					$archive['archive_name'] = $fans['nickname'];
					$archive['archive_avatar'] = $fans['headimgurl'];
				}
				$archive['archive_time_add'] = nowDate;
				pdo_insert($this->tb_archive, $archive);
				$archive['archive_id'] = pdo_insertid();
			}
		}
		include $this->template('minearchive');
	}
	public function doMobileMineScomment()
	{
		global $_W, $_GPC;
		$openid = $_W['openid'];
		$level = $_GPC['level'];
		if (!empty($level)) {
			$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_openid' => $openid, 'scomment_level' => $level));
		} else {
			$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_openid' => $openid));
		}
		$tags = pdo_getall($this->tb_scommenttag, array('scommenttag_uniacid' => $_W['uniacid']));
		$tags_new = array();
		foreach ($tags as $key => $item) {
			$tags_new[$item['scommenttag_id']] = $item['scommenttag_title'];
		}
		foreach ($scomments as $key => $item) {
			if (!empty($item['scomment_tag'])) {
				$item['scomment_tag'] = explode(',', $item['scomment_tag']);
				foreach ($item['scomment_tag'] as $row) {
					$scomments[$key]['tag'][] = $tags_new[$row];
				}
			}
		}
		$sql_1 = "select count(*) from " . tablename($this->tb_scomment) . " where scomment_uniacid = :uniacid and scomment_openid = :openid and scomment_level = :level ";
		$total_5 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':level' => 5));
		$total_4 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':level' => 4));
		$total_3 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':level' => 3));
		$total_2 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':level' => 2));
		$total_1 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':openid' => $openid, ':level' => 1));
		include $this->template('minescomment');
	}
	public function doMobileDianZan()
	{
		global $_GPC, $_W;
		$order_id = $_GPC['orderid'];
		$log = pdo_get($this->tb_fabulous, array('fabulous_uniacid' => $_W['uniacid'], 'fabulous_orderid' => $order_id, 'fabulous_openid' => $_W['openid']));
		if (empty($log)) {
			$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']));
			$staff_id = $order['order_staffid'];
			$store_id = $order['order_storeid'];
			$fabulous_insert['fabulous_staffid'] = $staff_id;
			$fabulous_insert['fabulous_uniacid'] = $_W['uniacid'];
			$fabulous_insert['fabulous_openid'] = $_W['openid'];
			$fabulous_insert['fabulous_storeid'] = $store_id;
			$fabulous_insert['fabulous_orderid'] = $order_id;
			$fabulous_insert['fabulous_time_add'] = date('Y-m-d H:i:s');
			$result = pdo_insert($this->tb_fabulous, $fabulous_insert);
			if ($result) {
				echo 1;
				die;
			} else {
				echo 2;
				die;
			}
		} else {
			echo 1;
			die;
		}
	}
	public function doMobileOrderInfo()
	{
		global $_W, $_GPC;
		$order_id = $_GPC['order_id'];
		$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']));
		if (empty($order)) {
			message('未获取到相关订单', '', 'error');
		}
		$staff = pdo_get($this->tb_staff, array('staff_id' => $order['order_staffid'], 'staff_uniacid' => $_W['uniacid']), array('staff_name'));
		$project = pdo_get($this->tb_project, array('project_id' => $order['order_projectid'], 'project_uniacid' => $_W['uniacid']), array('project_name'));
		$store = pdo_get($this->tb_store, array('store_id' => $order['order_storeid'], 'store_uniacid' => $_W['uniacid']), array('store_name'));
		include $this->template('order-info');
	}
	public function doMobileCode()
	{
		global $_W, $_GPC;
		$order_id = $_GPC['order_id'];
		$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid']));
		if (empty($order)) {
			message('未获取到相关订单', '', 'error');
		}
		if ($order['order_state'] != 2) {
			message('请检查订单是否支付', '', 'error');
		}
		$errorCorrectionLevel = 'L';
		$matrixPointSize = 6;
		$url = $_W['siteroot'] . "app/" . str_replace('./', '', $this->createMobileUrl('closure', array('order_id' => $order['order_id'])));
		QRcode::png($url, 'qrcode' . $order['order_id'] . '.png', $errorCorrectionLevel, $matrixPointSize, 2);
		$order['order_code'] = 'qrcode' . $order['order_id'] . '.png';
		include $this->template('code');
	}
	public function doMobileVerification()
	{
		global $_W, $_GPC;
		$order_id = $_GPC['order_id'];
		$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_state' => '3', 'order_uniacid' => $_W['uniacid']));
		if (empty($order)) {
			echo 1;
		} else {
			echo 2;
		}
	}
	public function doMobileClosure()
	{
		global $_GPC, $_W;
		$order_id = $_GPC['order_id'];
		if ($order_id) {
			$order = pdo_get($this->tb_order, array('order_id' => $order_id, 'order_uniacid' => $_W['uniacid'], 'order_state' => '2'));
			if (!empty($order)) {
				$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid'], 'staff_businessid' => $order['order_businessid']));
				if (empty($staff)) {
					message('您不是本商家的员工', $this->createMobileUrl('close'), 'error');
					die;
				}
				$res = pdo_update($this->tb_order, array('order_state' => 3), array('order_id' => $order['order_id'], 'order_uniacid' => $order['order_uniacid']));
				if ($res) {
					$archive = pdo_get($this->tb_archive, array('archive_openid' => $order['order_useropenid'], 'archive_uniacid' => $_W['uniacid']));
					if (!empty($archive)) {
						$consume['consume_archiveid'] = $archive['archive_id'];
						$consume['consume_uniacid'] = $_W['uniacid'];
						$consume['consume_storeid'] = $order['order_storeid'];
						$consume['consume_projectid'] = $order['order_projectid'];
						$consume['consume_staffid'] = $order['order_staffid'];
						$consume['consume_price'] = $order['order_pay_money'];
						$consume['consume_date'] = date('Y-m-d', time());
						$consume['consume_time_add'] = nowDate;
						pdo_insert($this->tb_consume, $consume);
					}
					message('核销成功', $this->createMobileUrl('close'), 'success');
				}
			} else {
				message('未获取到订单信息', $this->createMobileUrl('close'), 'error');
			}
		}
	}
	public function doMobileShow()
	{
		global $_W, $_GPC;
		$result = selectShowType();
		$showtypes = $result['records'];
		$total = count($showtypes);
		$type_id = $_GPC['type_id'];
		if (empty($type_id)) {
			$index = 1;
		} else {
			foreach ($showtypes as $key => $item) {
				if ($item['showtype_id'] == $type_id) {
					$index = $key + 1;
					break;
				}
			}
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
		$option['search']['show_typeid'] = $type_id;
		$result = selectShow($option);
		$shows = $result['records'];
		$total = $result['total'];
		if ($total < $psize) {
			$page = 0;
		} else {
			$page = 1;
		}
		unset($result);
		include $this->template('show');
	}
	public function doMobileLoadShow()
	{
		global $_GPC, $_W;
		$pindex = $_GPC['page'];
		$typid = $_GPC['type'];
		$psize = 10;
		$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
		$option['search']['show_typeid'] = $typid;
		$result = selectShow($option);
		$shows = $result['records'];
		$str = '';
		foreach ($shows as $key => $item) {
			$str .= ' <a href="' . $item['show_url'] . '"><img src="' . tomedia($item['show_pic']) . '" alt=""></a>';
		}
		return $str;
	}
	public function doMobileCollection()
	{
		global $_W, $_GPC;
		$openid = $_W['openid'];
		if (empty($openid)) {
			message('未获取到用户信息', '', 'error');
		}
		$pindex = max(1, intval($_GPC['page']));
		$psize = 10;
		$option["limit"] = " limit " . ($pindex - 1) * $psize . "," . $psize . " ";
		$option["search"]['collection_openid'] = $openid;
		$result = selectCollection($option);
		$collections = $result['records'];
		$total = $result['total'];
		if ($total < $psize) {
			$page = 0;
		} else {
			$page = 1;
		}
		unset($result);
		$collection_res = array();
		foreach ($collections as $key => $item) {
			if (!empty($item['collection_storeid']) && empty($item['collection_staffid']) && empty($item['collection_projectid'])) {
				$store = pdo_get($this->tb_store, array('store_id' => $item['collection_storeid'], 'store_uniacid' => $_W['uniacid']));
				$new['type'] = 1;
				$new['url'] = $this->createMobileUrl('info', array('store_id' => $item['collection_storeid']));
				$new['name'] = $store['store_name'];
				$collection_res[] = $new;
				continue;
			}
			if (!empty($item['collection_storeid']) && !empty($item['collection_projectid']) && empty($item['collection_staffid'])) {
				$project = pdo_get($this->tb_project, array('project_id' => $item['collection_projectid'], 'project_uniacid' => $_W['uniacid']));
				$new['type'] = 2;
				$new['url'] = $this->createMobileUrl('projectInfo', array('store_id' => $item['collection_storeid'], 'project_id' => $item['collection_projectid']));
				$new['name'] = $project['project_name'];
				$collection_res[] = $new;
				continue;
			}
			if (!empty($item['collection_staffid'])) {
				$dating = pdo_get($this->tb_dating, array('dating_id' => $item['collection_staffid'], 'dating_uniacid' => $_W['uniacid']), array('dating_time', 'dating_pay_money', 'dating_week', 'dating_staffid', 'dating_id', 'dating_pay_state', 'dating_storeid'));
				$staff = pdo_get($this->tb_staff, array('staff_id' => $dating['dating_staffid'], 'staff_uniacid' => $_W['uniacid']));
				$new['type'] = 3;
				$new['url'] = $this->createMobileUrl('dating', array('dating_id' => $item['collection_staffid']));
				$new['name'] = $staff['staff_name'];
				$collection_res[] = $new;
				continue;
			}
		}
		include $this->template('collection');
	}
	public function doMobileLoadCollection()
	{
		global $_W, $_GPC;
		$page = $_GPC['page'];
		$psize = 10;
		$option["limit"] = " limit " . ($page - 1) * $psize . "," . $psize . " ";
		$option["search"]['collection_openid'] = $_W['openid'];
		$result = selectCollection($option);
		$collections = $result['records'];
		$collection_res = array();
		foreach ($collections as $key => $item) {
			if (!empty($item['collection_storeid']) && empty($item['collection_staffid']) && empty($item['collection_projectid'])) {
				$store = pdo_get($this->tb_store, array('store_id' => $item['collection_storeid'], 'store_uniacid' => $_W['uniacid']));
				$new['type'] = 1;
				$new['url'] = $this->createMobileUrl('info', array('store_id' => $item['collection_storeid']));
				$new['name'] = $store['store_name'];
				$collection_res[] = $new;
				continue;
			}
			if (!empty($item['collection_storeid']) && !empty($item['collection_projectid']) && empty($item['collection_staffid'])) {
				$project = pdo_get($this->tb_project, array('project_id' => $item['collection_projectid'], 'project_uniacid' => $_W['uniacid']));
				$new['type'] = 2;
				$new['url'] = $this->createMobileUrl('projectInfo', array('store_id' => $item['collection_storeid'], 'project_id' => $item['collection_projectid']));
				$new['name'] = $project['project_name'];
				$collection_res[] = $new;
				continue;
			}
			if (!empty($item['collection_staffid'])) {
				$dating = pdo_get($this->tb_dating, array('dating_id' => $item['collection_staffid'], 'dating_uniacid' => $_W['uniacid']), array('dating_time', 'dating_pay_money', 'dating_week', 'dating_staffid', 'dating_id', 'dating_pay_state', 'dating_storeid'));
				$staff = pdo_get($this->tb_staff, array('staff_id' => $dating['dating_staffid'], 'staff_uniacid' => $_W['uniacid']));
				$new['type'] = 3;
				$new['url'] = $this->createMobileUrl('dating', array('dating_id' => $item['collection_staffid']));
				$new['name'] = $staff['staff_name'];
				$collection_res[] = $new;
				continue;
			}
		}
		$str = '';
		foreach ($collection_res as $key => $item) {
			$str .= ' <a href="' . $item['url'] . '">
            <div class="lw-clooect">
            <div class="lw-clooect-left lw-clooect-left-' . $item['type'] . '"></div>
            <div class="lw-clooect-center"><span>' . $item['name'] . '</span></div>
            <div class="lw-clooect-right"> <img src="' . RES . 'mobile/images/right.png" alt=""> </div>
            <li class="clear"></li>
        </div>
    </a>';
		}
		echo $str;
	}
	public function doMobileAdmin()
	{
		global $_W, $_GPC;
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		$store_id = pdo_get($this->tb_dating, array('dating_uniacid' => $_W['uniacid'], 'dating_staffid' => $staff['staff_id'], 'dating_default_store' => 2), array('dating_storeid'));
		$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_businessid' => $staff['staff_businessid']));
		if (empty($store_id)) {
			foreach ($stores as $key => $item) {
				$sql = "select distinct dating_projectid from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_staffid = :staffid and dating_storeid = :storeid ORDER BY dating_id desc ";
				$params = array(':staffid' => $staff['staff_id'], ':storeid' => $item['store_id']);
				$res = pdo_fetchall($sql, $params);
				if (!empty($res)) {
					$default_store = $item;
					break;
				}
			}
		} else {
			$default_store = pdo_get($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_id' => $store_id));
			$sql = "select distinct dating_projectid from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_staffid = :staffid and dating_storeid = :storeid ORDER BY dating_id desc ";
			$params = array(':staffid' => $staff['staff_id'], ':storeid' => $default_store['store_id']);
			$res = pdo_fetchall($sql, $params);
		}
		$projects = array();
		foreach ($res as $key => $item) {
			$project = pdo_get($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_id' => $item['dating_projectid']));
			$sqlcount = "select count(*) as total from " . tablename($this->tb_order) . " where order_state = :orderstate and order_uniacid = :uniacid and order_storeid = :storeid and order_staffid = :staffid and order_projectid = :projectid and order_look = :look ";
			$params = array(':orderstate' => 2, ':uniacid' => $_W['uniacid'], ':storeid' => $default_store['store_id'], ':staffid' => $staff['staff_id'], ':projectid' => $item['dating_projectid'], ':look' => 1);
			$count = pdo_fetch($sqlcount, $params);
			$project['look'] = $count['total'];
			$projects[] = $project;
		}
		include $this->template('admin');
	}
	public function doMobileAjaxProject()
	{
		global $_GPC, $_W;
		if (!empty($_POST['store']) && !empty($_POST['staff'])) {
			$staff_id = $_POST['staff'];
			$store_id = $_POST['store'];
			$sql = "select distinct dating_projectid from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_staffid = :staffid and dating_storeid = :storeid ORDER BY dating_id desc ";
			$params = array(':staffid' => $staff_id, ':storeid' => $store_id);
			$res = pdo_fetchall($sql, $params);
			$projects = array();
			foreach ($res as $key => $item) {
				$project = pdo_get($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_id' => $item['dating_projectid']));
				$sqlcount = "select count(*) as total from " . tablename($this->tb_order) . " where order_state = :orderstate and order_uniacid = :uniacid and order_storeid = :storeid and order_staffid = :staffid and order_projectid = :projectid and order_look = :look ";
				$params = array(':orderstate' => 2, ':uniacid' => $_W['uniacid'], ':storeid' => $store_id, ':staffid' => $staff_id, ':projectid' => $item['dating_projectid'], ':look' => 1);
				$count = pdo_fetch($sqlcount, $params);
				$project['look'] = $count['total'];
				$projects[] = $project;
			}
			$str = '';
			if (!empty($projects)) {
				foreach ($projects as $key => $item) {
					$str .= ' <a href="javascript:getStore(\'' . $item["project_id"] . '\')"><li class="project-listinfo"><div class="project-listinfo-left">' . $item['project_name'] . '</div>
<div class="project-listinfo-right"><img src="' . RES . 'mobile/images/admin_right.png" alt=""></div>';
					if (!empty($item['look'])) {
						$str .= '<div class="project-listinfo-num">' . $item['look'] . '</div>';
					}
					$str .= '<div class="clear"></div></li></a>';
				}
			}
			echo $str;
		}
	}
	public function doMobileSelfCode()
	{
		global $_W, $_GPC;
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		$code_type = 2;
		if ($code_type == 1) {
			$value = $_W['siteroot'] . "app/" . str_replace('./', '', $this->createMobileUrl('StaffComment', array('op' => 'create', 'staffid' => $staff['staff_id'])));
			$errorCorrectionLevel = 'L';
			$matrixPointSize = 6;
			QRcode::png($value, 'act_qrcode.png', $errorCorrectionLevel, $matrixPointSize, 2);
			$staff['staff_codeurl'] = 'act_qrcode.png?time=' . time();
		} else {
			if (empty($staff['staff_codeurl'])) {
				$code = $this->getQrcodeAll('番瓜门店预约', 'wxlm_appointment', $staff['staff_id']);
				$res = pdo_update($this->tb_staff, array('staff_codeurl' => $code['codeurl']), array('staff_id' => $staff['staff_id']));
				if (!empty($res)) {
					$staff['staff_code'] = $code['codeurl'];
				}
			}
		}
		include $this->template('selfcode');
	}
	public function doMobileStaffComment()
	{
		global $_GPC, $_W;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
			if (empty($staff)) {
				message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
				die;
			}
			$level = $_GPC['level'];
			if (!empty($level)) {
				$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_staffid' => $staff['staff_id'], 'scomment_level' => $level));
			} else {
				$scomments = pdo_getall($this->tb_scomment, array('scomment_uniacid' => $_W['uniacid'], 'scomment_staffid' => $staff['staff_id']));
			}
			$tags = pdo_getall($this->tb_scommenttag, array('scommenttag_uniacid' => $_W['uniacid']));
			$tags_new = array();
			foreach ($tags as $key => $item) {
				$tags_new[$item['scommenttag_id']] = $item['scommenttag_title'];
			}
			foreach ($scomments as $key => $item) {
				if (!empty($item['scomment_tag'])) {
					$item['scomment_tag'] = explode(',', $item['scomment_tag']);
					foreach ($item['scomment_tag'] as $row) {
						$scomments[$key]['tag'][] = $tags_new[$row];
					}
				}
			}
			$sql_1 = "select count(*) from " . tablename($this->tb_scomment) . " where scomment_uniacid = :uniacid and scomment_staffid = :staffid and scomment_level = :level ";
			$total_5 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 5));
			$total_4 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 4));
			$total_3 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 3));
			$total_2 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 2));
			$total_1 = pdo_fetchcolumn($sql_1, array(':uniacid' => $_W['uniacid'], ':staffid' => $staff['staff_id'], ':level' => 1));
			include $this->template('staffcomment_display');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$account_api = WeAccount::create();
					$openid = $_W['openid'];
					if (empty($openid)) {
						message('未获取到用户信息', $this->createMobileUrl('close'), 'error');
					}
					$archive = pdo_get($this->tb_archive, array('archive_openid' => $openid));
					$scomment = $_POST['scomment'];
					$scomment['scomment_uniacid'] = $_W['uniacid'];
					$scomment['scomment_openid'] = $openid;
					$scomment['scomment_nickname'] = $archive['archive_name'];
					$scomment['scomment_avatar'] = $archive['archive_avatar'];
					if (empty($scomment['scomment_nickname']) || empty($scomment['scomment_avatar'])) {
						$fans = $account_api->fansQueryInfo($openid);
						$scomment['scomment_nickname'] = $fans['nickname'];
						$scomment['scomment_avatar'] = $fans['headimgurl'];
					}
					$scomment['scomment_time_add'] = nowDate;
					if (!empty($scomment['scomment_tag'])) {
						$scomment['scomment_tag'] = implode(',', $scomment['scomment_tag']);
					}
					$res = pdo_insert($this->tb_scomment, $scomment);
					if (empty($archive)) {
						$archive['archive_uniacid'] = $_W['uniacid'];
						$archive['archive_openid'] = $openid;
						$archive['archive_name'] = $scomment['scomment_nickname'];
						$archive['archive_avatar'] = $scomment['scomment_avatar'];
						$archive['archive_admin'] = $scomment['scomment_staffid'];
						$archive['archive_time_add'] = nowDate;
						pdo_insert($this->tb_archive, $archive);
						$archive['archive_id'] = pdo_insertid();
					} else {
						$archive_admin = explode(',', $archive['archive_admin']);
						if (!in_array($scomment['scomment_staffid'], $archive_admin)) {
							$archive_admin[] = $scomment['scomment_staffid'];
							pdo_update($this->tb_archive, array('archive_admin' => implode(',', $archive_admin)), array('archive_id' => $archive['archive_id']));
						}
					}
					if (!empty($res)) {
						$staff = pdo_get($this->tb_staff, array('staff_id' => $scomment['scomment_staffid'], 'staff_uniacid' => $_W['uniacid']));
						$tpl = getconfigbytype('type4', $this->tb_config);
						$template_id = $tpl['tpl2_id'];
						if (!empty($template_id)) {
							$data['first']['value'] = empty($tpl['tpl2_first']) ? '您好, 客户已对您的服务做出评价' : $tpl['tpl2_first'];
							$data['keyword1']['value'] = $archive['archive_name'];
							$data['keyword1']['color'] = '#173177';
							$data['keyword2']['value'] = $archive['archive_tel'];
							$data['keyword2']['color'] = '#173177';
							$data['keyword3']['value'] = nowDate;
							$data['keyword3']['color'] = '#173177';
							$data['keyword4']['value'] = $staff['staff_name'];
							$data['keyword4']['color'] = '#173177';
							$data['keyword5']['value'] = $scomment['scomment_content'];
							$data['keyword5']['color'] = '#173177';
							$data['remark']['value'] = empty($tpl['tpl2_remark']) ? '点击查看档案信息。' : $tpl['tpl2_remark'];
							$staffurl = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('archiveInfo', array('archive_id' => $archive['archive_id'])));
							$status = $account_api->sendTplNotice($staff['staff_openid'], $template_id, $data, $staffurl);
						}
						message('员工点评成功!', $this->createMobileUrl('close'), 'success');
					}
				}
				$staff_id = $_GPC['staffid'];
				if (empty($staff_id)) {
					message('未获取到员工信息', $this->createMobileUrl('close'), 'error');
				}
				$staff = pdo_get($this->tb_staff, array('staff_id' => $staff_id));
				$tags = pdo_getall($this->tb_scommenttag, array('scommenttag_uniacid' => $_W['uniacid']), array(), '', 'scommenttag_order asc');
				include $this->template('staffcomment_create');
			}
		}
	}
	public function doMobileArchive()
	{
		global $_W, $_GPC;
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and archive_uniacid = " . $_W['uniacid'];
		$archives = pdo_fetchall($sql);
		$archives_list = array();
		foreach ($archives as $key => $item) {
			$str = getfirstchar($item['archive_name']);
			if (!empty($item['archive_admin'])) {
				$item['archive_admin'] = explode(',', $item['archive_admin']);
				foreach ($item['archive_admin'] as $key2 => $value) {
					$name = pdo_getcolumn($this->tb_staff, array('staff_id' => $value), 'staff_name');
					$item['archive_staff'][] = $name;
				}
			}
			$sql_lasttime = "select max(consume_date) from " . tablename($this->tb_consume) . " where consume_archiveid = :archiveid and consume_uniacid = :uniacid ";
			$item['lasttime'] = pdo_fetchcolumn($sql_lasttime, array(':archiveid' => $item['archive_id'], ':uniacid' => $_W['uniacid']));
			$archives_list[$str][] = $item;
		}
		ksort($archives_list);
		include $this->template('archive');
	}
	public function doMobileSearchArchive()
	{
		global $_W, $_GPC;
		$keyword = $_POST['keyword'];
		$staff_id = $_POST['staff'];
		if (empty($keyword)) {
			$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff_id . ",archive_admin) and archive_uniacid = " . $_W['uniacid'];
		} else {
			if (!empty($keyword)) {
				$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff_id . ",archive_admin) and archive_uniacid = " . $_W['uniacid'] . " and archive_name like  '%" . $keyword . "%'";
			}
		}
		$archives = pdo_fetchall($sql);
		$archives_list = array();
		foreach ($archives as $key => $item) {
			$str = getfirstchar($item['archive_name']);
			if (!empty($item['archive_admin'])) {
				$item['archive_admin'] = explode(',', $item['archive_admin']);
				foreach ($item['archive_admin'] as $key2 => $value) {
					$name = pdo_getcolumn($this->tb_staff, array('staff_id' => $value), 'staff_name');
					$item['archive_staff'][] = $name;
				}
			}
			$archives_list[$str][] = $item;
		}
		ksort($archives_list);
		$str = '';
		foreach ($archives_list as $key => $item) {
			$str .= '<ul>
                        <div class="visit-box-title">' . $key . '</div>';
			foreach ($item as $key2 => $item2) {
				$str .= '<a href="' . $this->createMobileUrl('archiveInfo', array('archive_id' => $item2['archive_id'])) . '">
                            <li >
                            <div class="visit-box2-left">
                                <img src="' . tomedia($item2['archive_avatar']) . '">
                            </div>
                            <div class="visit-box2-right">
                                <div>
                                    <span>' . $item2['archive_name'] . '</span>
                                    <img src="' . RES . 'mobile/images/connect.png">';
				foreach ($item2['archive_staff'] as $row) {
					$str .= '<span>' . $row . '</span>';
				}
				$str .= '</div>
                               <div>
                                    <span><img src="' . RES . 'mobile/images/clock_new.png">上次到店时间:2017-10-10</span>
                                    <object> <a href="tel:' . $item2['archive_tel'] . '"><img src="' . RES . 'mobile/images/tel.png"></a></object>
                               </div>
                               <p class="clear"></p>
                            </div>
                            <p class="clear"></p>
                        </li>
                        </a>    
                    </ul>';
			}
		}
		return $str;
	}
	public function doMobileWarning()
	{
		global $_W, $_GPC;
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		$op = empty($_GPC['op']) ? 'one' : $_GPC['op'];
		if ($op == 'one') {
			$warning_time = time() - 30 * 24 * 60 * 60;
		} else {
			if ($op == 'two') {
				$warning_time = time() - 60 * 24 * 60 * 60;
			} else {
				if ($op == 'three') {
					$warning_time = time() - 90 * 24 * 60 * 60;
				}
			}
		}
		$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and archive_uniacid = " . $_W['uniacid'];
		$archives = pdo_fetchall($sql);
		$archives_list = array();
		foreach ($archives as $key => $item) {
			$sql_lasttime = "select max(consume_date) from " . tablename($this->tb_consume) . " where consume_archiveid = :archiveid and consume_uniacid = :uniacid ";
			$item['lasttime'] = pdo_fetchcolumn($sql_lasttime, array(':archiveid' => $item['archive_id'], ':uniacid' => $_W['uniacid']));
			if (strtotime($item['lasttime']) >= $warning_time) {
				continue;
			}
			$str = getfirstchar($item['archive_name']);
			if (!empty($item['archive_admin'])) {
				$item['archive_admin'] = explode(',', $item['archive_admin']);
				foreach ($item['archive_admin'] as $key2 => $value) {
					$name = pdo_getcolumn($this->tb_staff, array('staff_id' => $value), 'staff_name');
					$item['archive_staff'][] = $name;
				}
			}
			$archives_list[$str][] = $item;
		}
		ksort($archives_list);
		include $this->template('warning');
	}
	public function doMobileBirthday()
	{
		global $_W, $_GPC;
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		$M = date('M', time());
		$m = date('m', time());
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and archive_uniacid = " . $_W['uniacid'] . " and `archive_birthday` like  '%-" . $m . "-%'";
		$archives = pdo_fetchall($sql);
		$archives_list = array();
		foreach ($archives as $key => $item) {
			$str = getfirstchar($item['archive_name']);
			if (!empty($item['archive_admin'])) {
				$item['archive_admin'] = explode(',', $item['archive_admin']);
				foreach ($item['archive_admin'] as $key2 => $value) {
					$name = pdo_getcolumn($this->tb_staff, array('staff_id' => $value), 'staff_name');
					$item['archive_staff'][] = $name;
				}
			}
			$archives_list[$str][] = $item;
		}
		ksort($archives_list);
		include $this->template('birthday');
	}
	public function doMobileArchiveInfo()
	{
		global $_GPC, $_W;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		if (!empty($_GPC['archive_id'])) {
			$archive_id = $_GPC['archive_id'];
			$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and archive_id = " . $archive_id . " and archive_uniacid = " . $_W['uniacid'];
			$archive = pdo_fetch($sql);
		}
		if ($op == 'display') {
			if (empty($archive)) {
				message('请选择一个档案', $this->createMobileUrl('archive'), 'error');
			}
			include $this->template('archive_info');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$archive = $_POST['archive'];
					$archive['archive_uniacid'] = $_W['uniacid'];
					if (empty($archive['archive_id'])) {
						unset($archive['archive_id']);
						$archive['archive_add_time'] = date('Y-m-d H:i:s', time());
						$res = pdo_insert($this->tb_archive, $archive);
					} else {
						$archive['archive_time_update'] = date('Y-m-d H:i:s', time());
						$res = pdo_update($this->tb_archive, $archive, array('archive_id' => $archive['archive_id']));
					}
					if (!empty($res)) {
						message('档案信息保存成功', $this->createMobileUrl('archive'), 'success');
					}
				}
				include $this->template('archive_create');
			}
		}
	}
	public function doMobileVisit()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			if (!empty($_GPC['tpl_id'])) {
				$tpl = pdo_get($this->tb_visittpl, array('visittpl_id' => $_GPC['tpl_id']));
			}
			$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
			if (empty($staff)) {
				message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
				die;
			}
			$archive_id = $_GPC['archive_id'];
			$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and archive_uniacid = " . $_W['uniacid'] . " and archive_id = " . $archive_id;
			$archive = pdo_fetch($sql);
			if (empty($archive)) {
				message('未获取到档案信息', $this->createMobileUrl('archive'), 'error');
			}
			$tpltypes = pdo_getall($this->tb_visittype, array('visittype_uniacid' => $_W['uniacid']), array(), '', 'visittype_order ASC');
			foreach ($tpltypes as $key => $value) {
				$sql_count = "select count(*) from " . tablename($this->tb_visittpl) . " WHERE visittpl_typeid = :typeid ";
				$tpltypes[$key]['count'] = pdo_fetchcolumn($sql_count, array(':typeid' => $value['visittype_id']));
			}
			include $this->template('visit');
		} else {
			if ($op == 'tpl') {
				$typeid = $_GPC['type_id'];
				$archive_id = $_GPC['archive_id'];
				$tpls = pdo_getall($this->tb_visittpl, array('visittpl_uniacid' => $_W['uniacid'], 'visittpl_typeid' => $typeid));
				include $this->template('visit_tpl');
			}
		}
		if ($op == 'save') {
			$sql = "select max(visittpl_order) from " . tablename($this->tb_visittpl) . " where visittpl_uniacid = " . $_W['uniacid'];
			$order = pdo_fetchcolumn($sql);
			$tpl['visittpl_order'] = $order + 1;
			$tpl['visittpl_content'] = $_POST['content'];
			$tpl['visittpl_typeid'] = $_POST['typeid'];
			$tpl['visittpl_uniacid'] = $_W['uniacid'];
			$tpl['visittpl_time_add'] = date('Y-m-d H:i:s', time());
			$res = pdo_insert($this->tb_visittpl, $tpl);
			if (!empty($res)) {
				echo 1;
			} else {
				echo 2;
			}
		}
	}
	public function doMobileVisitLog()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		if ($op == 'display') {
			$sql = 'select * from ' . tablename($this->tb_visitlog) . " left join " . tablename($this->tb_archive) . " on archive_id = visitlog_archiveid left join " . tablename($this->tb_staff) . " on staff_id = visitlog_staffid where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and visitlog_uniacid = " . $_W['uniacid'];
			$visitlogs = pdo_fetchall($sql);
			include $this->template('visit_log');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$visitlog = $_POST['visit'];
					$visitlog['visitlog_uniacid'] = $_W['uniacid'];
					$visitlog['visitlog_time_add'] = date('Y-m-d H:i:s', time());
					$res = pdo_insert($this->tb_visitlog, $visitlog);
					if (!empty($res)) {
						message('回访内容已经复制，粘贴即可发送至客户。', $this->createMobileUrl('archive', array('archive_id' => $visitlog['visitlog_id'])));
					}
				}
			}
		}
	}
	public function doMobileConsume()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		$archive_id = $_GPC['archive_id'];
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		if ($op == 'display') {
			$sql = 'select * from ' . tablename($this->tb_archive) . " where FIND_IN_SET(" . $staff['staff_id'] . ",archive_admin) and archive_uniacid = " . $_W['uniacid'] . " and archive_id = " . $archive_id;
			$archive = pdo_fetch($sql);
			if (empty($archive)) {
				message('未获取到档案信息', $this->createMobileUrl('archive'), 'error');
			}
			$sql_2 = "select * from " . tablename($this->tb_consume) . " left join " . tablename($this->tb_store) . " on store_id = consume_storeid where consume_uniacid = :uniacid and consume_archiveid = :archiveid";
			$consumes = pdo_fetchall($sql_2, array(':uniacid' => $_W['uniacid'], ':archiveid' => $archive_id));
			foreach ($consumes as $key => $item) {
				$staff = pdo_get($this->tb_staff, array('staff_id' => $item['consume_staffid']));
				$consumes[$key]['staff_name'] = $staff['staff_name'];
				$item['consume_projectid'] = explode(',', $item['consume_projectid']);
				foreach ($item['consume_projectid'] as $value) {
					$consumes[$key]['project'][] = pdo_getcolumn($this->tb_project, array('project_id' => $value), 'project_name');
				}
			}
			include $this->template('consume');
		} else {
			if ($op == 'create') {
				if (checksubmit()) {
					$consume = $_POST['consume'];
					$consume['consume_uniacid'] = $_W['uniacid'];
					if ($consume['consume_projectid']) {
						$consume['consume_projectid'] = implode(',', $consume['consume_projectid']);
					}
					if (empty($consume['consume_staffid'])) {
						$consume['consume_staffid'] = $staff['staff_id'];
					}
					if (empty($consume['consume_id'])) {
						unset($consume['consume_id']);
						$consume['consume_time_add'] = date('Y-m-d H:i:s', time());
						$res = pdo_insert($this->tb_consume, $consume);
					} else {
						$consume['consume_time_update'] = date('Y-m-d H:i:s', time());
						$res = pdo_insert($this->tb_consume, $consume, array('consume_id' => $consume['consume_id']));
					}
					if (!empty($res)) {
						message('消费记录保存成功', $this->createMobileUrl('consume', array('op' => 'display', 'archive_id' => $consume['consume_archiveid'])), 'success');
					}
				}
				$stores = pdo_getall($this->tb_store, array('store_uniacid' => $_W['uniacid'], 'store_businessid' => $staff['staff_businessid']));
				$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_businessid' => $staff['staff_businessid']));
				if (!empty($_GPC['consume_id'])) {
					$consume = pdo_get($this->tb_consume, array('consume_uniacid' => $_W['uniacid'], 'consume_id' => $_GPC['consume_id']));
					if (!empty($consume['consume_projectid'])) {
						$consume['consume_projectid'] = explode(',', $consume['consume_projectid']);
					}
				}
				include $this->template('consume_create');
			}
		}
	}
	public function doMobileSetting()
	{
		global $_GPC, $_W;
		$staff = pdo_get($this->tb_staff, array('staff_openid' => $_W['openid'], 'staff_uniacid' => $_W['uniacid']));
		if (empty($staff)) {
			message('您不是当前系统的员工', $this->createMobileUrl('close'), 'error');
			die;
		}
		$store_id = $_GPC['storeid'];
		$project_id = $_GPC['projectid'];
		pdo_update($this->tb_order, array('order_look' => 2), array('order_state' => 2, 'order_uniacid' => $_W['uniacid'], 'order_storeid' => $store_id, 'order_staffid' => $staff['staff_id'], 'order_projectid' => $project_id, 'order_look' => 1));
		$dating = pdo_get($this->tb_dating, array('dating_uniacid' => $_W['uniacid'], 'dating_staffid' => $staff['staff_id'], 'dating_storeid' => $store_id, 'dating_projectid' => $project_id));
		if (empty($dating)) {
			message('未获取到预约信息', '', 'error');
		}
		$times = json_decode($dating['dating_time'], true);
		$dating['dating_week'] = json_decode($dating['dating_week'], true);
		$week = date('Y-m-d');
		$weeks = riqi($week, 2);
		foreach ($weeks as $key => $item) {
			if (!in_array($key, $dating['dating_week'])) {
				unset($weeks[$key]);
			}
		}
		$week_ch = array(0 => '周日', 1 => '周一', 2 => '周二', 3 => '周三', 4 => '周四', 5 => '周五', 6 => '周六');
		$default_week = reset($weeks);
		foreach ($times as $key => $item) {
			$switch_sql = "select * from " . tablename($this->tb_switch) . " where switch_uniacid = :uniacid and switch_state = 2 and switch_day = :switch_day and switch_day_start = :switch_day_start and switch_day_end = :switch_day_end and switch_staffid = :staffid ";
			$switch_params = array(':uniacid' => $_W['uniacid'], ':switch_day' => $week, ':switch_day_start' => $item['start'], ':switch_day_end' => $item['end'], ':staffid' => $staff['staff_id']);
			$switch = pdo_fetch($switch_sql, $switch_params);
			if (!empty($switch)) {
				$switch['switch_datingid'] = json_decode($switch['switch_datingid'], true);
				if (in_array($dating['dating_id'], $switch['switch_datingid'])) {
					$times[$key]['switch'] = 2;
				}
			}
		}
		$sql_order = " select * from " . tablename($this->tb_order) . " where order_uniacid = :uniacid and order_storeid = :storeid and order_staffid = :staffid and order_projectid = :projectid and order_state = :order_state ORDER BY order_id desc limit 0, 10 ";
		$parmas_order = array(':uniacid' => $_W['uniacid'], ':storeid' => $store_id, ':staffid' => $staff['staff_id'], ':projectid' => $project_id, ':order_state' => 2);
		$orders_wait = pdo_fetchall($sql_order, $parmas_order);
		$parmas_order[':order_state'] = 3;
		$orders_finish = pdo_fetchall($sql_order, $parmas_order);
		include $this->template('setting');
	}
	public function doMobileAjaxTime()
	{
		global $_GPC, $_W;
		if (!empty($_POST)) {
			$dating_id = $_POST['dating'];
			$date = $_POST['date'];
			$date = str_replace("月", '-', $date);
			$date = str_replace("日", '', $date);
			$year = date('Y', time());
			$date = $year . "-" . $date;
			$dating = pdo_get($this->tb_dating, array('dating_uniacid' => $_W['uniacid'], 'dating_id' => $dating_id));
			$times = json_decode($dating['dating_time'], true);
			foreach ($times as $key => $item) {
				$switch_sql = "select * from " . tablename($this->tb_switch) . " where switch_uniacid = :uniacid and switch_state = 2 and switch_day = :switch_day and switch_day_start = :switch_day_start and switch_day_end = :switch_day_end and switch_staffid = :staffid ";
				$switch_params = array(':uniacid' => $_W['uniacid'], ':switch_day' => $date, ':switch_day_start' => $item['start'], ':switch_day_end' => $item['end'], ':staffid' => $dating['dating_staffid']);
				$switch = pdo_fetch($switch_sql, $switch_params);
				if (!empty($switch)) {
					$switch['switch_datingid'] = json_decode($switch['switch_datingid'], true);
					if (in_array($dating['dating_id'], $switch['switch_datingid'])) {
						$times[$key]['switch'] = 2;
					}
				}
			}
			$str = '';
			foreach ($times as $key => $item) {
				$str .= '<a href="javascript:switchState(\'' . $item['start'] . '\',\'' . $item['end'] . '\',\'' . $dating['dating_id'] . '\',\'' . $key . '\')">';
				$str .= '<li id="time_' . $key . '" class="li-me-list';
				if ($item['switch'] == 2) {
					$str .= ' li-me-list2">';
				} else {
					$str .= '">';
				}
				$str .= '<p>' . $item['start'] . '-' . $item['end'] . '</p>';
				$str .= '<p>预约' . $item['count'] . '</p>';
				$str .= '</li></a>';
			}
			$str .= '<div class="clear"></div>';
			echo $str;
		}
	}
	public function doMobileAjaxSwitch()
	{
		global $_GPC, $_W;
		if (!empty($_POST)) {
			$dating_id = $_POST['dating'];
			$date = $_POST['date'];
			$date = str_replace("月", '-', $date);
			$date = str_replace("日", '', $date);
			$year = date('Y', time());
			$date = $year . "-" . $date;
			$start = $_POST['start'];
			$end = $_POST['end'];
			$store = $_POST['store'];
			$staff = $_POST['staff'];
			$together = $_POST['together'];
			$switch = pdo_get($this->tb_switch, array('switch_day' => $date, 'switch_day_start' => $start, 'switch_day_end' => $end, 'switch_uniacid' => $_W['uniacid'], 'switch_staffid' => $staff));
			if (empty($switch)) {
				unset($switch);
				$switch['switch_uniacid'] = $_W['uniacid'];
				if ($together == 1) {
					$switch['switch_datingid'][] = $dating_id;
				} else {
					if ($together == 2) {
						$sql = "select distinct dating_id from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_staffid = :staffid and dating_storeid = :storeid ORDER BY dating_id desc ";
						$params = array(':staffid' => $staff, ':storeid' => $store);
						$res = pdo_fetchall($sql, $params);
						foreach ($res as $key => $item) {
							$switch['switch_datingid'][] = $item['dating_id'];
						}
					}
				}
				$switch['switch_day'] = $date;
				$switch['switch_day_start'] = $start;
				$switch['switch_day_end'] = $end;
				$switch['switch_state'] = 2;
				$switch['switch_staffid'] = $staff;
				$switch['switch_time_add'] = nowDate;
				$switch['switch_datingid'] = json_encode($switch['switch_datingid']);
				$res = pdo_insert($this->tb_switch, $switch);
				if (!empty($res)) {
					$result['state'] = 'success';
					$result['switch'] = '2';
					echo json_encode($result);
					die;
				}
			} else {
				$datings = json_decode($switch['switch_datingid'], true);
				if ($together == 2) {
					if (empty($datings)) {
						$sql = "select distinct dating_id from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_staffid = :staffid and dating_storeid = :storeid ORDER BY dating_id desc ";
						$params = array(':staffid' => $staff, ':storeid' => $store);
						$resdatingid = pdo_fetchall($sql, $params);
						foreach ($resdatingid as $key => $item) {
							$datings[] = $item['dating_id'];
							$result['switch'] = '2';
						}
					} else {
						if (in_array($dating_id, $datings)) {
							$datings = array();
							$result['switch'] = '1';
						} else {
							$sql = "select distinct dating_id from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_staffid = :staffid and dating_storeid = :storeid ORDER BY dating_id desc ";
							$params = array(':staffid' => $staff, ':storeid' => $store);
							$resdatingid = pdo_fetchall($sql, $params);
							foreach ($resdatingid as $key => $item) {
								$datings[] = $item['dating_id'];
								$result['switch'] = '2';
							}
						}
					}
				} else {
					if (in_array($dating_id, $datings)) {
						foreach ($datings as $key => $item) {
							if ($item == $dating_id) {
								unset($datings[$key]);
							}
						}
						$result['switch'] = '1';
					} else {
						$datings[] = $dating_id;
						$result['switch'] = '2';
					}
				}
				$datings = json_encode($datings);
				$res = pdo_update($this->tb_switch, array('switch_datingid' => $datings, 'switch_time_update' => nowDate), array('switch_id' => $switch));
				if (!empty($res)) {
					$result['state'] = 'success';
					echo json_encode($result);
				}
			}
		}
	}
	public function doMobileAjaxLoad()
	{
		global $_W, $_GPC;
		if (!empty($_POST)) {
			$type = $_POST['type'];
			if ($type == 1) {
				$state = 2;
			} else {
				if ($type == 2) {
					$state = 3;
				}
			}
			$storeid = $_POST['store'];
			$staffid = $_POST['staff'];
			$projectid = $_POST['projectid'];
			$page = $_GPC['page'];
			$limit_start = ($page - 1) * 10;
			$sql_order = " select * from " . tablename($this->tb_order) . " where order_uniacid = :uniacid and order_storeid = :storeid and order_staffid = :staffid and order_projectid = :projectid and order_state = :order_state ORDER BY order_id desc limit " . $limit_start . ", 10 ";
			$parmas_order = array(':uniacid' => $_W['uniacid'], ':storeid' => $storeid, ':staffid' => $staffid, ':projectid' => $projectid, ':order_state' => $state);
			$orders = pdo_fetchall($sql_order, $parmas_order);
			$sql_count = "select count(*) as total from " . tablename($this->tb_order) . " where  order_uniacid = :uniacid and order_storeid = :storeid and order_staffid = :staffid and order_projectid = :projectid and order_state = :order_state";
			$count = pdo_fetch($sql_count, $parmas_order);
			$str = '';
			if (!empty($orders)) {
				foreach ($orders as $key => $item) {
					$str .= '<div class="li-dd-info">
                 <p>订单编号：' . $item['order_number'] . '</p>
                 <p><span>预约人：' . $item['order_username'] . '</span><span style="float: right;padding-right: 20px;">手机号：' . $item['order_userphone'] . '</span></p>
                 <p>预约时间：' . $item['order_dating_day'] . $item['order_dating_start'] . '-' . $item['order_dating_end'] . '</p>
                 <p>提交时间: ' . $item['order_time_add'] . '</p>';
					if ($type == 1) {
						$str .= ' <span class="li-dd-info-span1"></span>
             </div>';
					} else {
						$str .= ' <span class="li-dd-info-span2"></span>
             </div>';
					}
				}
			}
			echo $str;
		}
	}
	public function doMobileCard()
	{
		global $_W, $_GPC;
		$op = empty($_GPC['op']) ? 'display' : $_GPC['op'];
		if ($op == 'display') {
			$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid']));
			if (empty($card)) {
				message('暂无会员卡, 尽请期待', '', 'error');
			}
			if (empty($_W['openid'])) {
				message('未获取到用户信息', '', 'error');
			}
			$myCard = pdo_get($this->tb_vip, array('vip_uniacid' => $_W['uniacid'], 'vip_openid' => $_W['openid'], 'vip_pay' => 2, 'vip_credit_state' => 2));
			if (!empty($myCard)) {
				message('您已经购买过此卡', '', 'error');
			}
			load()->model('mc');
			$uid = mc_openid2uid($_W['openid']);
			$credit = mc_credit_fetch($uid, array('credit1'));
			include $this->template('card');
		} else {
			if ($op == 'card_order') {
				$card_id = $_GPC['card_id'];
				$vip_number = getVipNumber();
				if ($vip_number == false) {
					message('购买订单出现错误, 请重新尝试', $this->createMobileUrl('card'), 'error');
				}
				$card = pdo_get($this->tb_card, array('card_uniacid' => $_W['uniacid'], 'card_id' => $card_id));
				if (empty($card)) {
					message('会员卡信息有误, 请重新尝试', $this->createMobileUrl('card'), 'error');
				}
				load()->model('mc');
				$uid = mc_openid2uid($_W['openid']);
				$credit = mc_credit_fetch($uid, array('credit1'));
				if ($credit < $card['card_credit1']) {
					message('积分不足无法购买', '', 'error');
				}
				$myCard = pdo_get($this->tb_vip, array('vip_uniacid' => $_W['uniacid'], 'vip_openid' => $_W['openid'], 'vip_pay' => 1, 'vip_cardid' => $card_id));
				if ($myCard) {
					header('location:' . $this->createMobileUrl('cardPay', array('vip_number' => $myCard['vip_number'])));
					die;
				}
				$vip['vip_uniacid'] = $_W['uniacid'];
				$vip['vip_number'] = $vip_number;
				$vip['vip_cardid'] = $card_id;
				$vip['vip_openid'] = $_W['openid'];
				$vip['vip_name'] = $_W['fans']['nickname'];
				$vip['vip_money'] = $card['card_price'];
				$vip['vip_credit1'] = $card['card_credit1'];
				$vip['vip_credit_state'] = 1;
				$vip['vip_pay'] = 1;
				$vip['vip_type'] = 1;
				$vip['vip_time_add'] = nowDate;
				$vip['vip_time_update'] = nowDate;
				$res = pdo_insert($this->tb_vip, $vip);
				if ($res) {
					header('location:' . $this->createMobileUrl('cardPay', array('vip_number' => $vip_number)));
				}
			}
		}
	}
	public function doMobileCardPay()
	{
		global $_W, $_GPC;
		$vip_number = $_GPC['vip_number'];
		$vip = pdo_get($this->tb_vip, array('vip_uniacid' => $_W['uniacid'], 'vip_number' => $vip_number));
		if (empty($vip)) {
			message('未获取到购买信息', '', 'error');
		}
		if ($vip['vip_credit_state'] != 2) {
			load()->model('mc');
			$uid = mc_openid2uid($vip['vip_openid']);
			$credit = mc_credit_update($uid, 'credit1', '-' . $vip['vip_credit1'], array($uid, '预约会员卡兑换', 'wxlm_appointment'));
			if ($credit) {
				$update = pdo_update($this->tb_vip, array('vip_credit_state' => 2), array('vip_number' => $vip_number, 'vip_uniacid' => $_W['uniacid']));
			}
		}
		if ($vip['vip_pay'] == 2) {
			message('会员卡已经支付', '', 'error');
		}
		if ($vip['vip_money'] == 0) {
			$pay_state = pdo_update($this->tb_vip, array('vip_pay' => 2), array('vip_number' => $vip_number, 'vip_uniacid' => $_W['uniacid']));
			if ($pay_state) {
				message('支付成功', $this->createMobileUrl('index'), 'success');
			}
		}
		if ($update || $vip['vip_credit_state'] == 2) {
			$pay = getconfigbytype("type2", $this->tb_config);
			if ($pay['pay_way'] == 1 || empty($pay['pay_way'])) {
				$notify_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipNotify', array('order_no' => $vip['vip_number'])));
				$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipReturn', array('vip_number' => $vip['vip_number'])));
				$jspai = wxpay($vip['vip_money'], 'wxlm_appointment', $vip['vip_number'], $notify_url);
			} else {
				if ($pay['pay_way'] == 2) {
					$url = 'http://www.zwechat.com/weixinpay/index.php/FanqiejiaOauth/index/bm_id/' . $pay['bm_id'] . '/return_url/';
					$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipPingan', array('vip_number' => $vip['vip_number'])));
					$return_url = str_replace("?", "&&", $return_url);
					$url .= base64_encode($return_url);
					header('location:' . $url);
					die;
				} else {
					if ($pay['pay_way'] == 3) {
						$teegonUrl = $this->createMobileUrl('vipTeegon', array('vip_number' => $vip['vip_number']));
					}
				}
			}
			include $this->template('card_pay');
		} else {
			message('积分不足', '', 'error');
		}
	}
	public function doMobileVipTeegon()
	{
		global $_W, $_GPC;
		$number = $_GPC['vip_number'];
		$vip = pdo_get($this->tb_vip, array('vip_number' => $number, 'vip_uniacid' => $_W['uniacid']));
		$notify_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipNotify', array()));
		$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipReturn', array('vip_number' => $number)));
		$param['order_no'] = $vip['vip_number'];
		$param['channel'] = 'wxpay_jsapi';
		$param['return_url'] = $return_url;
		$param['amount'] = $vip['vip_money'];
		$param['subject'] = '支付';
		$param['metadata'] = '';
		$param['notify_url'] = $notify_url;
		$param['wx_openid'] = '';
		$srv = new TeegonService(TEE_API_URL);
		echo $srv->pay($param, false);
		exit;
	}
	public function doMobileVipPingan()
	{
		global $_GPC, $_W;
		$pay = getconfigbytype("type2", $this->tb_config);
		$openid = $_GPC['openid'];
		$vip_number = $_GPC['vip_number'];
		$vip = pdo_get($this->tb_vip, array('vip_number' => $vip_number, 'vip_uniacid' => $_W['uniacid']), array('vip_money'));
		if (empty($vip)) {
			message('未获取到订单信息', '', 'error');
		}
		$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipReturn', array('vip_number' => $vip['vip_number'])));
		$notify_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('vipNotify'));
		$account_api = WeAccount::create();
		$token = $account_api->getAccessToken();
		if (is_error($token)) {
			message('获取Access token 失败');
		}
		$url = 'https://api.weixin.qq.com/cgi-bin/shorturl?access_token=' . $token;
		$longurl = $return_url;
		$data_http = '{"action":"long2short","long_url":"' . $longurl . '"}';
		$result = httpPost($url, $data_http);
		$result = json_decode($result, true);
		$return_url = $result['short_url'];
		$url = 'http://www.zwechat.com/weixinpay/index.php/Fanqiejia/getOrderInfo';
		$data['b_id'] = $pay['b_id'];
		$data['bm_id'] = $pay['bm_id'];
		$data['openid'] = $openid;
		$data['price'] = $vip['vip_money'];
		$data['order_no'] = $vip_number;
		$data['notify_url'] = $notify_url;
		$result = _request($url, true, 'post', $data);
		$result = json_decode($result, true);
		header('location:' . 'https://openapi-liquidation.51fubei.com/payPage/?prepay_id=' . $result['prepay_id'] . '&callback_url=' . $return_url);
	}
	public function doMobileVipNotify()
	{
		global $_GPC, $_W;
		$vip_number = $_GPC['order_no'];
		if (!empty($vip_number)) {
			$res = pdo_update($this->tb_vip, array('vip_pay' => 2), array('vip_number' => $vip_number, 'vip_uniacid' => $_W['uniacid']));
		}
	}
	public function doMobileVipReturn()
	{
		global $_W, $_GPC;
		$vip_number = $_GPC['vip_number'];
		$vip = pdo_get($this->tb_vip, array('vip_number' => $vip_number, 'vip_uniacid' => $_W['uniacid']));
		if ($vip) {
			if ($vip['vip_pay'] == 1) {
				pdo_update($this->tb_vip, array('vip_pay' => 2), array('vip_number' => $vip_number, 'vip_uniacid' => $_W['uniacid']));
			}
		}
		message('预约会员卡购买成功', $this->createMobileUrl('index'), 'success');
	}
	public function doMobileMarch()
	{
		global $_W, $_GPC;
		$business = getconfigbytype('type6', $this->tb_config);
		if ($business['business_into'] == 2) {
			message('商家自动入驻功能暂未开启', $this->createMobileUrl('close'), 'error');
		}
		if (!empty($_POST['march'])) {
			$march = $_POST['march'];
			$business = pdo_get($this->tb_business, array('business_uniacid' => $_W['uniacid'], 'business_name' => $march['march_business_name']));
			if (!empty($business)) {
				message('商家名已存在, 请修改后提交验证', '', 'error');
				die;
			}
			$number = getMarchNumber();
			if (!$number) {
				message('申请异常, 请稍后重试!');
			}
			$march['march_openid'] = $_W['openid'];
			$march['march_uniacid'] = $_W['uniacid'];
			$march['march_number'] = $number;
			$march['march_state'] = 1;
			if (!empty($_FILES['file'])) {
				$tmp_names = $_FILES['file']['tmp_name'];
				foreach ($tmp_names as $key => $item) {
					$year = date('Y');
					$month = date('m');
					$fileName = '../attachment/images/' . $_W['uniacid'] . '/' . $year . '/' . $month . '/' . base64_encode($item) . '.png';
					if (move_uploaded_file($item, $fileName)) {
						$pic[] = str_replace('../attachment/', '', $fileName);
					}
				}
				$march['march_pic'] = json_encode($pic);
			}
			$march['march_time_add'] = nowDate;
			$result = pdo_insert($this->tb_march, $march);
			if (!empty($result)) {
				message('申请成功, 等待审核!', $this->createMobileUrl('march'), 'success');
			}
		}
		include $this->template('march');
	}
	public function doMobilePackage()
	{
		global $_W, $_GPC;
		$business = getconfigbytype('type6', $this->tb_config);
		if ($business['business_into'] == 2) {
			message('商家自动入驻功能暂未开启', $this->createMobileUrl('close'), 'error');
		}
		if (!empty($_POST['march_id']) && !empty($_POST['package'])) {
			$march_id = $_POST['march_id'];
			$package = $_POST['package'];
			$key = 'package' . $package . "_price";
			$money = $business[$key];
			$march = pdo_get($this->tb_march, array('march_id' => $march_id));
			$res = pdo_update($this->tb_march, array('march_package' => $package, 'march_money' => $money), array('march_id' => $march_id, 'march_uniacid' => $_W['uniacid']));
			if (!empty($res)) {
				header('location:' . $this->createMobileUrl('marchPay', array('march_id' => $march_id)));
				die;
			}
		}
		$march_id = $_GPC['march_id'];
		$march = pdo_get($this->tb_march, array('march_id' => $march_id, 'march_uniacid' => $_W['uniacid']));
		if ($march['march_state'] == 1) {
			message('申请待审核, 请耐心等待!', $this->createMobileUrl('close'), 'error');
		}
		if ($march['march_state'] == 3) {
			message('申请未通过!', $this->createMobileUrl('close'), 'error');
		}
		if ($march['march_state'] == 4) {
			$business = pdo_get($this->tb_business, array('business_marchid' => $march['march_id']));
			header('location:' . $this->createMobileUrl('marchInfo', array('business_id' => $business['business_id'])));
		}
		include $this->template('package');
	}
	public function doMobileMarchPay()
	{
		global $_W, $_GPC;
		$march_id = $_GPC['march_id'];
		$march = pdo_get($this->tb_march, array('march_id' => $march_id));
		if (empty($march)) {
			message('未获取到申请记录', $this->createMobileUrl('close'), 'error');
		}
		if ($march['march_state'] == 1 || $march['march_state'] == 3) {
			message('审核未通过, 暂时无法支付', $this->createMobileUrl('close'), 'error');
		}
		if ($march['march_state'] == 4) {
			$business = pdo_get($this->tb_business, array('business_marchid' => $march['march_id']));
			header('location:' . $this->createMobileUrl('marchInfo', array('business_id' => $business['business_id'])));
		}
		if ($march['march_package'] == 4) {
			header('location:' . $this->createMobileUrl('marchReturn', array('march_number' => $march['march_number'])));
		}
		$pay = getconfigbytype("type2", $this->tb_config);
		$return_url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('MarchReturn', array('march_number' => $march['march_number'])));
		$jspai = wxpay($march['march_money'], 'wxlm_appointment', $march['march_number'], $_W['siteroot'] . 'payment/wechat/notify.php');
		include $this->template('march_pay');
	}
	public function doMobileMarchReturn()
	{
		global $_GPC, $_W;
		$march_number = $_GPC['march_number'];
		$march = pdo_get($this->tb_march, array('march_number' => $march_number, 'march_uniacid' => $_W['uniacid']));
		if ($march['march_state'] == 4) {
			$business = pdo_get($this->tb_business, array('business_marchid' => $march['march_id']));
			header('location:' . $this->createMobileUrl('marchInfo', array('business_id' => $business['business_id'])));
		}
		$pay_log = pdo_get('core_paylog', array('tid' => $march_number, 'module' => 'wxlm_appointment'));
		if (!empty($pay_log) || $march['march_package'] == 4) {
			$weixinpay = new WeiXinPay();
			$pay = getconfigbytype("type2", 'wxlm_appointment_config');
			$weixinpay->wxpay = array('appid' => $pay['appid'], 'mch_id' => $pay['mchid'], 'key' => $pay['apikey']);
			$result = $weixinpay->queryOrder($pay_log['uniontid'], 2);
			if ($result['result_code'] == 'SUCCESS' || $march['march_package'] == 4) {
				$paystate = pdo_update($this->tb_march, array('march_state' => 4), array('march_number' => $march_number));
				if (!empty($paystate)) {
					$business['business_uniacid'] = $_W['uniacid'];
					$business['business_look'] = 2;
					$business['business_tel'] = $march['march_admin_tel'];
					$business['business_admin'] = $march['march_admin_name'];
					$business['business_admin_openid'] = $march['march_openid'];
					$business['business_name'] = $march['march_business_name'];
					$business['business_package'] = $march['march_package'];
					$business['business_time_use'] = time();
					$business['business_marchid'] = $march['march_id'];
					$business['business_time_add'] = nowDate;
					$inster = pdo_insert($this->tb_business, $business);
					$business_id = pdo_insertid();
					message('支付成功', $this->createMobileUrl('marchInfo', array('business_id' => $business_id)), 'success');
				}
			}
		} else {
			message('支付异常', '', 'error');
		}
	}
	public function doMobileMarchInfo()
	{
		global $_W, $_GPC;
		$business_id = $_GPC['business_id'];
		$business = pdo_get($this->tb_business, array('business_id' => $business_id, 'business_uniacid' => $_W['uniacid']));
		$march = pdo_get($this->tb_march, array('march_id' => $business['business_marchid'], 'march_uniacid' => $_W['uniacid']));
		if ($march['march_state'] != 4) {
			message('请检查申请状态', '', 'error');
		}
		$admin = pdo_get($this->tb_admin, array('admin_businessid' => $business_id, 'admin_uniacid' => $_W['uniacid']));
		if (empty($admin)) {
			$admin['admin_uniacid'] = $_W['uniacid'];
			$admin['admin_businessid'] = $business_id;
			$admin['admin_name'] = $march['march_admin_name'];
			$account = getAdmin();
			if (!$account) {
				message('信息生成异常, 请刷新尝试!', '', 'error');
			}
			$admin['admin_account'] = $account;
			$password = getRandStr(8);
			$admin['admin_password'] = md5($password);
			$admin['admin_level'] = 1;
			$admin['admin_time_add'] = nowDate;
			$res = pdo_insert($this->tb_admin, $admin);
		} else {
			$password = $admin['admin_password'];
		}
		$url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('pcLogin'));
		include $this->template('marchInfo');
	}
//本=模=块=来=自=新=睿=社=区！	
	public function doMobileOther()
	{
		global $_W, $_GPC;
		session_start();
		$_SESSION['index'] = 2;
		$level = $_W['uniaccount']['level'];
		$ads = pdo_getall($this->tb_ad, array('ad_uniacid' => $_W['uniacid'], 'ad_state' => 2), array(), '', 'ad_order ASC');
		$ptypes = pdo_getall($this->tb_ptype, array('ptype_uniacid' => $_W['uniacid']), array(), '', 'ptype_order DESC');
		$projects = pdo_getall($this->tb_project, array('project_uniacid' => $_W['uniacid'], 'project_state =' => 2), array(), '', 'project_order DESC');
		foreach ($projects as $key => $item) {
			$business = pdo_get($this->tb_business, array('business_id' => $item['project_businessid'], 'business_uniacid' => $_W['uniacid']));
			if (!empty($business['business_package'])) {
				$value = time() - $business['business_time_use'];
				if ($business['business_package'] == 1) {
					if ($value > 365 * 24 * 60 * 60) {
						unset($projects[$key]);
					}
				} else {
					if ($business['business_package'] == 2) {
						if ($value > 90 * 24 * 60 * 60) {
							unset($projects[$key]);
						}
					} else {
						if ($business['business_package'] == 3) {
							if ($value > 30 * 24 * 60 * 60) {
								unset($projects[$key]);
							}
						}
					}
				}
			}
		}
		include $this->template('other');
	}
	public function doMobileOtherStore()
	{
		global $_GPC, $_W;
		$project_id = $_GPC['project_id'];
		$project = pdo_get($this->tb_project, array('project_id' => $project_id, 'project_uniacid' => $_W['uniacid']));
		if (empty($project)) {
			message('未获取到项目类型', '', 'error');
		}
		$sql = "select distinct dating_storeid from " . tablename($this->tb_dating) . " where dating_uniacid = " . $_W['uniacid'] . " and dating_projectid = " . $project_id . " ORDER BY dating_id desc ";
		$res = pdo_fetchall($sql);
		$stores = array();
		foreach ($res as $key => $item) {
			$store = pdo_get($this->tb_store, array('store_id' => $item['dating_storeid'], 'store_uniacid' => $_W['uniacid']));
			$stores[] = $store;
		}
		foreach ($stores as $key => $item) {
			$storesa[$key]['time'] = floor((time() - strtotime($item['dating_time_update'])) / (7 * 24 * 60 * 60)) + 1;
			$business = pdo_get($this->tb_business, array('business_id' => $item['store_businessid'], 'business_uniacid' => $_W['uniacid']));
			if (!empty($business['business_package'])) {
				$value = time() - $business['business_time_use'];
				if ($business['business_package'] == 1) {
					if ($value > 365 * 24 * 60 * 60) {
						unset($storesa[$key]);
					}
				} else {
					if ($business['business_package'] == 2) {
						if ($value > 90 * 24 * 60 * 60) {
							unset($storesa[$key]);
						}
					} else {
						if ($business['business_package'] == 3) {
							if ($value > 30 * 24 * 60 * 60) {
								unset($storesa[$key]);
							}
						}
					}
				}
			}
		}
		if (empty($_GPC['log']) || empty($_GPC['lat'])) {
			$location = $this->locationByIP(CLIENT_IP);
			$_GPC['log'] = $location['lng'];
			$_GPC['lat'] = $location['lat'];
		}
		$stores = LBSStore($stores, $_GPC['log'], $_GPC['lat']);
		$pindex2 = max(1, intval($_GPC['page']));
		$psize2 = $this->config['storenumber'] != '' ? $this->config['storenumber'] : 10;
		$option2["limit"] = " limit " . ($pindex2 - 1) * $psize2 . "," . $psize2 . " ";
		$option2['search']['order_projectid'] = $project_id;
		$results = selectStore3($option2);
		$storesa = $results['records'];
		foreach ($storesa as $key => $item) {
			$storesa[$key]['time'] = floor((time() - strtotime($item['dating_time_update'])) / (7 * 24 * 60 * 60)) + 1;
			$business = pdo_get($this->tb_business, array('business_id' => $item['store_businessid'], 'business_uniacid' => $_W['uniacid']));
			if (!empty($business['business_package'])) {
				$value = time() - $business['business_time_use'];
				if ($business['business_package'] == 1) {
					if ($value > 365 * 24 * 60 * 60) {
						unset($storesa[$key]);
					}
				} else {
					if ($business['business_package'] == 2) {
						if ($value > 90 * 24 * 60 * 60) {
							unset($storesa[$key]);
						}
					} else {
						if ($business['business_package'] == 3) {
							if ($value > 30 * 24 * 60 * 60) {
								unset($storesa[$key]);
							}
						}
					}
				}
			}
		}
		unset($results);
		include $this->template('otherStore');
	}
	public function doMobileClose()
	{
		include $this->template('closeWindow');
	}
	public function sendTpl($number)
	{
		global $_W;
		$order = pdo_get($this->tb_order, array('order_number' => $number, 'order_uniacid' => $_W['uniacid']));
		$project = pdo_get($this->tb_project, array('project_id' => $order['order_projectid'], 'project_uniacid' => $_W['uniacid']), array('project_name'));
		$store = pdo_get($this->tb_store, array('store_id' => $order['order_storeid'], 'store_uniacid' => $_W['uniacid']), array('store_admin_openid', 'store_admin_name'));
		$staff = pdo_get($this->tb_staff, array('staff_id' => $order['order_staffid'], 'staff_uniacid' => $_W['uniacid']), array('staff_openid', 'staff_name', 'staff_tel'));
		$account_api = WeAccount::create();
		$openid = $order['order_useropenid'];
		$tpl = getconfigbytype('type4', $this->tb_config);
		$template_id = $tpl['tpl_id'];
		$data['first']['value'] = empty($tpl['tpl_first']) ? '预约通知' : $tpl['tpl_first'];
		$data['keyword1']['value'] = $order['order_username'];
		$data['keyword1']['color'] = '#173177';
		$data['keyword2']['value'] = $project['project_name'];
		$data['keyword2']['color'] = '#173177';
		$data['keyword3']['value'] = $order['order_dating_day'] . " " . $order['order_dating_start'] . "-" . $order['order_dating_end'];
		$data['keyword3']['color'] = '#173177';
		$data['remark']['value'] = empty($tpl['tpl_remark']) ? '请保证预约时间前到达，不要让对方久等。' : $tpl['tpl_remark'];
		$fansurl = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('mine'));
		$staffurl = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('admin'));
		$status = $account_api->sendTplNotice($openid, $template_id, $data, $fansurl);
		if (is_error($status)) {
			message('发送模板消息异常:' . $status['message'], '', 'error');
		}
		$openid = $staff['staff_openid'];
		$status = $account_api->sendTplNotice($openid, $template_id, $data, $staffurl);
		if (is_error($status)) {
			message('发送模板消息异常:' . $status['message'], '', 'error');
		}
		$openid = $store['store_admin_openid'];
		$status = $account_api->sendTplNotice($openid, $template_id, $data, $staffurl);
		if (is_error($status)) {
			message('发送模板消息异常:' . $status['message'], '', 'error');
		}
	}
	public function sendCustom($number)
	{
		global $_W;
		$order = pdo_get($this->tb_order, array('order_number' => $number, 'order_uniacid' => $_W['uniacid']));
		$project = pdo_get($this->tb_project, array('project_id' => $order['order_projectid'], 'project_uniacid' => $_W['uniacid']), array('project_name'));
		$store = pdo_get($this->tb_store, array('store_id' => $order['order_storeid'], 'store_uniacid' => $_W['uniacid']), array('store_admin_openid', 'store_admin_name'));
		$staff = pdo_get($this->tb_staff, array('staff_id' => $order['order_staffid'], 'staff_uniacid' => $_W['uniacid']), array('staff_openid', 'staff_name', 'staff_tel'));
		$account_api = WeAccount::create();
		$info = "预约通知
        
预约人：" . $order['order_username'] . "
预约项目：" . $project['project_name'] . "
预约时间：" . $order['order_dating_day'] . " " . $order['order_dating_start'] . "-" . $order['order_dating_end'] . "
请准时登录平台提供咨询，不要让对方久等。";
		$message = array('msgtype' => 'text', 'text' => array('content' => urlencode($info)), 'touser' => $order['order_useropenid']);
		$status = $account_api->sendCustomNotice($message);
		$message = array('msgtype' => 'text', 'text' => array('content' => urlencode($info)), 'touser' => $staff['staff_openid']);
		$status = $account_api->sendCustomNotice($message);
		$message = array('msgtype' => 'text', 'text' => array('content' => urlencode($info)), 'touser' => $store['store_admin_openid']);
		$status = $account_api->sendCustomNotice($message);
	}
	public function sendMessage($number)
	{
		global $_W;
		$order = pdo_get($this->tb_order, array('order_number' => $number, 'order_uniacid' => $_W['uniacid']));
		$project = pdo_get($this->tb_project, array('project_id' => $order['order_projectid'], 'project_uniacid' => $_W['uniacid']), array('project_name'));
		$store = pdo_get($this->tb_store, array('store_id' => $order['order_storeid'], 'store_uniacid' => $_W['uniacid']), array('store_admin_openid', 'store_admin_name', 'store_tel'));
		$staff = pdo_get($this->tb_staff, array('staff_id' => $order['order_staffid'], 'staff_uniacid' => $_W['uniacid']), array('staff_openid', 'staff_name', 'staff_tel'));
		$message = getconfigbytype('type3', $this->tb_config);
		$accessKeyId = $message['message_keyid'];
		$accessKeySecret = $message['message_keysecret'];
		$product = "Dysmsapi";
		$domain = "dysmsapi.aliyuncs.com";
		$region = "cn-hangzhou";
		$profile = DefaultProfile::getProfile($region, $accessKeyId, $accessKeySecret);
		DefaultProfile::addEndpoint("cn-hangzhou", "cn-hangzhou", $product, $domain);
		$acsClient = new DefaultAcsClient($profile);
		$request = new Dysmsapi\Request\V20170525\SendSmsRequest();
		$request->setSignName($message['message_signname']);
		$request->setTemplateCode($message['message_code']);
		$data['key1'] = $order['order_username'];
		$data['key2'] = $project['project_name'];
		$data['key3'] = $order['order_dating_day'];
		$data['key4'] = $order['order_dating_start'] . "-" . $order['order_dating_end'];
		$data['remark'] = '仔细留意预约时间';
		$request->setTemplateParam(json_encode($data));
		$request->setOutId($order['order_number']);
		if (!empty($order['order_userphone'])) {
			$request->setPhoneNumbers($order['order_userphone']);
			$acsResponse = $acsClient->getAcsResponse($request);
		}
		if (!empty($staff['staff_tel'])) {
			$request->setPhoneNumbers($staff['staff_tel']);
			$acsResponse = $acsClient->getAcsResponse($request);
		}
		if (!empty($store['store_tel'])) {
			$request->setPhoneNumbers($store['store_tel']);
			$acsResponse = $acsClient->getAcsResponse($request);
		}
	}
	private function async($url, $params = array(), $encode = true, $method = 1)
	{
		$ch = curl_init();
		if ($method == 1) {
			$url = $url . '?' . http_build_query($params);
			$url = $encode ? $url : urldecode($url);
			curl_setopt($ch, CURLOPT_URL, $url);
		} else {
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		}
		curl_setopt($ch, CURLOPT_REFERER, '百度地图referer');
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (iPhone; CPU iPhone OS 7_0 like Mac OS X; en-us) AppleWebKit/537.51.1 (KHTML, like Gecko) Version/7.0 Mobile/11A465 Safari/9537.53');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$resp = curl_exec($ch);
		curl_close($ch);
		return $resp;
	}
	public function locationByIP($ip)
	{
		if (!filter_var($ip, FILTER_VALIDATE_IP)) {
			throw new Exception('ip地址不合法');
		}
		$params = array('ak' => 'DFeb602c2287c0365ddc5776ee79af22', 'ip' => $ip, 'coor' => 'bd09ll');
		$api = 'http://api.map.baidu.com/location/ip';
		$resp = $this->async($api, $params);
		$data = json_decode($resp, true);
		if ($data['status'] != 0) {
			throw new Exception($data['message']);
		}
		return array('address' => $data['content']['address'], 'province' => $data['content']['address_detail']['province'], 'city' => $data['content']['address_detail']['city'], 'district' => $data['content']['address_detail']['district'], 'street' => $data['content']['address_detail']['street'], 'street_number' => $data['content']['address_detail']['street_number'], 'city_code' => $data['content']['address_detail']['city_code'], 'lng' => $data['content']['point']['x'], 'lat' => $data['content']['point']['y']);
	}
	private function sendMoney($wechat, $openid, $money, $desc, $trade_no = '')
	{
		$desc = isset($desc) ? $desc : '商户结账';
		$money = $money * 100;
		$url = "https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/transfers";
		$pars = array();
		$pars['mch_appid'] = $wechat['appid'];
		$pars['mchid'] = $wechat['mchid'];
		$pars['nonce_str'] = random(32);
		$pars['partner_trade_no'] = empty($trade_no) ? $wechat['mchid'] . date('Ymd') . rand(1000000000, 9999999999.0) : $trade_no;
		$pars['openid'] = $openid;
		$pars['check_name'] = 'NO_CHECK';
		$pars['amount'] = $money;
		$pars['desc'] = $desc;
		$pars['spbill_create_ip'] = isset($wechat['ip']) ? $wechat['ip'] : $_SERVER['SERVER_ADDR'];
		ksort($pars, SORT_STRING);
		$string1 = '';
		foreach ($pars as $k => $v) {
			$string1 .= "{$k}={$v}&";
		}
		$string1 .= "key={$wechat['apikey']}";
		$pars['sign'] = strtoupper(md5($string1));
		$xml = array2xml($pars);
		$extras = array();
		$extras['CURLOPT_CAINFO'] = ATTACHMENT_ROOT . '/cert/rootca.pem.' . $wechat['pemname'];
		$extras['CURLOPT_SSLCERT'] = ATTACHMENT_ROOT . '/cert/apiclient_cert.pem.' . $wechat['pemname'];
		$extras['CURLOPT_SSLKEY'] = ATTACHMENT_ROOT . '/cert/apiclient_key.pem.' . $wechat['pemname'];
		load()->func('communication');
		$procResult = null;
		$response = ihttp_request($url, $xml, $extras);
		if ($response['code'] == 200) {
			$responseObj = simplexml_load_string($response['content'], 'SimpleXMLElement', LIBXML_NOCDATA);
			$responseObj = (array) $responseObj;
			$return['code'] = $responseObj['return_code'];
			$return['result_code'] = $responseObj['result_code'];
			$return['err_code'] = $responseObj['err_code'];
			$return['msg'] = $responseObj['return_msg'];
			$return['trade_no'] = $pars['partner_trade_no'];
			return $return;
		}
	}
	public function getQrcodeAll($name, $module, $staff_id = '', $rid = '')
	{
		global $_W;
		load()->func('communication');
		$acid = pdo_fetchcolumn("SELECT acid FROM " . tablename('account_wechats') . " WHERE uniacid =" . $_W['uniacid']);
		$uniacccount = WeAccount::create($acid);
		$barcode['action_info']['scene']['scene_str'] = 'appointment' . $staff_id;
		$barcode['action_name'] = 'QR_LIMIT_STR_SCENE';
		$result = $uniacccount->barCodeCreateFixed($barcode);
		$imgs = 'https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=' . $result['ticket'];
		$ticketstr = $result['ticket'];
		$urlstr = $result['url'];
		$qrcode = array('uniacid' => $_W['uniacid'], 'acid' => $acid, 'name' => $name, 'scene_str' => 'appointment' . $staff_id, 'keyword' => "预约员工点评", 'model' => 2, 'ticket' => $ticketstr, 'createtime' => time(), 'status' => 1, 'url' => $urlstr);
		pdo_insert('qrcode', $qrcode);
		if ($rid == '') {
			$check_rul = pdo_get('rule_keyword', array('module' => $module, 'content' => '预约员工点评', 'uniacid' => $_W['uniacid']));
			if (empty($check_rul)) {
				$rule_data = array('uniacid' => $_W['uniacid'], 'name' => $name, 'module' => $module, 'status' => 1, 'displayorder' => 254);
				pdo_insert('rule', $rule_data);
				$rid = pdo_insertid();
				$rule_key = array('uniacid' => $_W['uniacid'], 'module' => $module, 'content' => '预约员工点评', 'type' => '1', 'displayorder' => 254, 'status' => 1);
				$rule_key['rid'] = $rid;
				pdo_insert('rule_keyword', $rule_key);
			}
		}
		return array('codeurl' => $imgs, 'rid' => $rid);
	}
}