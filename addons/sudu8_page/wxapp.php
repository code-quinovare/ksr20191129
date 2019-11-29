<?php

defined("IN_IA") or die("Access Denied");
define("HTTPSHOST", $_W["attachurl"]);
define("ROOT_PATH", IA_ROOT . "/addons/sudu8_page/");
class Sudu8_pageModuleWxapp extends WeModuleWxapp
{
	public function doPageAppbase()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$code = $_GPC["code"];
		$app = pdo_fetch("SELECT * FROM " . tablename("account_wxapp") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
		$appid = $app["key"];
		$appsecret = $app["secret"];
		$url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $appsecret . "&js_code=" . $code . "&grant_type=authorization_code";
		$weixin = file_get_contents($url);
		$jsondecode = json_decode($weixin);
		$array = get_object_vars($jsondecode);
		$openid = $array["openid"];
		if ($openid) {
			$data = array("uniacid" => $uniacid, "openid" => $openid, "createtime" => time());
			$user = pdo_fetch("SELECT count(*) as n FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $_W["uniacid"]));
			if ($user["n"] == 0) {
				pdo_insert("sudu8_page_user", $data);
				return $this->result(0, "success", $data);
			} else {
				return $this->result(0, "success", $data);
			}
		} else {
			var_dump($weixin);
		}
	}
	public function doPageUseupdate()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $_W["uniacid"]));
		$data = array("uniacid" => $uniacid, "nickname" => $_GPC["nickname"], "avatar" => $_GPC["avatarUrl"], "gender" => $_GPC["gender"], "resideprovince" => $_GPC["province"], "residecity" => $_GPC["city"], "nationality" => $_GPC["country"]);
		$res = pdo_update("sudu8_page_user", $data, array("openid" => $openid, "uniacid" => $uniacid));
	}
	public function doPageBase()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$baseInfo = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_base") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$baseInfo["ot"] = pdo_fetch("SELECT forms_name FROM " . tablename("sudu8_page_forms_config") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if ($baseInfo["ot"]["forms_name"] == '') {
			$baseInfo["ot"]["forms_name"] = "请配置表单名称";
		}
		$config = unserialize($baseInfo["config"]);
		$baseInfo["bigadT"] = $config["bigadT"];
		$baseInfo["bigadC"] = $config["bigadC"];
		$baseInfo["bigadCTC"] = intval($config["bigadCTC"]);
		$baseInfo["bigadCNN"] = $config["bigadCNN"];
		$baseInfo["miniadT"] = $config["miniadT"];
		$baseInfo["newhead"] = $config["newhead"];
		$baseInfo["search"] = $config["search"];
		$baseInfo["copT"] = $config["copT"];
		$baseInfo["userFood"] = $config["userFood"];
		if ($baseInfo["banner"]) {
			if (!stristr($baseInfo["banner"], "http")) {
				$baseInfo["banner"] = HTTPSHOST . $baseInfo["banner"];
			}
		}
		if (!($baseInfo["index_style"] == "slide")) {
			bJpdY:
			if (!($baseInfo["index_style"] == "newslide")) {
				XcV_0:
				if (!($config["bigadT"] == "1")) {
					g468S:
					if (!($config["bigadT"] == "2")) {
						D1wOk:
						if (!($config["miniadT"] == "1" || $config["miniadT"] == "2")) {
							dvNtY:
							if (!stristr($baseInfo["logo"], "http")) {
								$baseInfo["logo"] = HTTPSHOST . $baseInfo["logo"];
							}
							if (!stristr($baseInfo["logo2"], "http")) {
								$baseInfo["logo2"] = HTTPSHOST . $baseInfo["logo2"];
							}
							if ($baseInfo["copyimg"]) {
								if (!stristr($baseInfo["copyimg"], "http")) {
									$baseInfo["copyimg"] = HTTPSHOST . $baseInfo["copyimg"];
								}
							}
							if ($baseInfo["video"]) {
								include "videoInfo.php";
								$videoInfo = new videoInfo();
								$videodata = $videoInfo->getVideoInfo($baseInfo["video"]);
								$baseInfo["video"] = $videodata["url"];
							}
							if ($baseInfo["v_img"]) {
								if (!stristr($baseInfo["v_img"], "http")) {
									$baseInfo["v_img"] = HTTPSHOST . $baseInfo["v_img"];
								}
							}
							if ($baseInfo["c_b_bg"]) {
								if (!stristr($baseInfo["c_b_bg"], "http")) {
									$baseInfo["c_b_bg"] = HTTPSHOST . $baseInfo["c_b_bg"];
								}
							}
							$baseInfo["tabbar"] = unserialize($baseInfo["tabbar"]);
							$i = 0;
							lGZ6t:
							if ($i > 4) {
								$baseInfo["color_bar"] = "1px solid " . $baseInfo["color_bar"];
								return $this->result(0, "success", $baseInfo);
								goto c2jzL;
							}
							$baseInfo["tabbar"][$i] = unserialize($baseInfo["tabbar"][$i]);
							if (is_numeric($baseInfo["tabbar"][$i]["tabbar_l"])) {
								$cate_type = pdo_fetch("SELECT id,type,list_type FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :id", array(":uniacid" => $uniacid, ":id" => $baseInfo["tabbar"][$i]["tabbar_l"]));
								if ($cate_type["type"] == "page") {
									$baseInfo["tabbar"][$i]["type"] = "page";
								}
								if ($cate_type["type"] == "coupon") {
									$baseInfo["tabbar"][$i]["type"] = "coupon";
								}
								if ($cate_type["list_type"] == 0 && $cate_type["type"] != "page" && $cate_type["type"] != "coupon") {
									$baseInfo["tabbar"][$i]["type"] = "listCate";
								} else {
									if ($cate_type["list_type"] == 1 && $cate_type["type"] != "page" && $cate_type["type"] != "coupon") {
										$baseInfo["tabbar"][$i]["type"] = "list" . substr($cate_type["type"], 4, strlen($cate_type["type"]));
									}
								}
							}
							if ($baseInfo["tabbar"][$i]["tabbar_l"] == "webpage") {
								$baseInfo["tabbar"][$i]["tabbar_url"] = urlencode($baseInfo["tabbar"][$i]["tabbar_url"]);
							}
							$i++;
							goto lGZ6t;
						}
						$slide = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_banner") . " WHERE uniacid = :uniacid and type = 'miniad' and flag = 1  ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
						$num = count($slide);
						$baseInfo["miniad"] = array();
						$i = 0;
						kckxZ:
						if ($i >= $num) {
							$baseInfo["miniadN"] = $config["miniadN"];
							$baseInfo["miniadB"] = $config["miniadB"];
							goto dvNtY;
						}
						$baseInfo["miniad"][$i] = array();
						if (stristr($slide[$i]["pic"], "http")) {
							$baseInfo["miniad"][$i]["pic"] = $slide[$i]["pic"];
						} else {
							$baseInfo["miniad"][$i]["pic"] = HTTPSHOST . $slide[$i]["pic"];
						}
						$baseInfo["miniad"][$i]["descp"] = $slide[$i]["descp"];
						$baseInfo["miniad"][$i]["url"] = $slide[$i]["url"];
						$i++;
						goto kckxZ;
					}
					$slide = pdo_fetchall("SELECT pic,url FROM " . tablename("sudu8_page_banner") . " WHERE uniacid = :uniacid and type = 'bigad' and flag = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
					$num = count($slide);
					$baseInfo["bigad"] = array();
					$i = 0;
					ds8Rf:
					if ($i >= $num) {
						goto D1wOk;
					}
					if (stristr($slide[$i]["pic"], "http")) {
						$baseInfo["bigad"][$i]["pic"] = $slide[$i]["pic"];
					} else {
						$baseInfo["bigad"][$i]["pic"] = HTTPSHOST . $slide[$i]["pic"];
					}
					$baseInfo["bigad"][$i]["url"] = $slide[$i]["url"];
					$i++;
					goto ds8Rf;
				}
				$slide = pdo_fetchall("SELECT pic FROM " . tablename("sudu8_page_banner") . " WHERE uniacid = :uniacid and type = 'bigad' and flag = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
				$num = count($slide);
				$baseInfo["bigad"] = array();
				$i = 0;
				XVSNS:
				if ($i >= $num) {
					goto g468S;
				}
				if (stristr($slide[$i]["pic"], "http")) {
					$baseInfo["bigad"][$i] = $slide[$i]["pic"];
				} else {
					$baseInfo["bigad"][$i] = HTTPSHOST . $slide[$i]["pic"];
				}
				$i++;
				goto XVSNS;
			}
			$slide = pdo_fetchall("SELECT pic,url FROM " . tablename("sudu8_page_banner") . " WHERE uniacid = :uniacid and type = 'banner' ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
			$num = count($slide);
			$baseInfo["slide"] = array();
			$i = 0;
			ioJfV:
			if ($i >= $num) {
				goto XcV_0;
			}
			if (stristr($slide[$i]["pic"], "http")) {
				$baseInfo["slide"][$i]["pic"] = $slide[$i]["pic"];
			} else {
				$baseInfo["slide"][$i]["pic"] = HTTPSHOST . $slide[$i]["pic"];
			}
			$baseInfo["slide"][$i]["url"] = $slide[$i]["url"];
			$i++;
			goto ioJfV;
		}
		$baseInfo["slide"] = unserialize($baseInfo["slide"]);
		$num = count($baseInfo["slide"]);
		$slide = array();
		$slide = $baseInfo["slide"];
		$baseInfo["slide"] = array();
		$i = 0;
		vRgkb:
		if ($i >= $num) {
			goto bJpdY;
		}
		if (stristr($slide[$i], "http")) {
			$baseInfo["slide"][$i] = $slide[$i];
		} else {
			$baseInfo["slide"][$i] = HTTPSHOST . $slide[$i];
		}
		$i++;
		goto vRgkb;
		c2jzL:
	}
	public function doPageAbout()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$aboutInfo = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_about") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if (!($aboutInfo["header"] == "2")) {
			Gwc6j:
			if (!($aboutInfo["header"] == "3")) {
				WplRT:
				return $this->result(0, "success", $aboutInfo);
				goto VuFPC;
			}
			$slide = pdo_fetchall("SELECT pic,url FROM " . tablename("sudu8_page_banner") . " WHERE uniacid = :uniacid and type = 'banner' ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
			$num = count($slide);
			$aboutInfo["slide"] = array();
			$i = 0;
			hS7Gb:
			if ($i >= $num) {
				goto WplRT;
			}
			if (stristr($slide[$i]["pic"], "http")) {
				$aboutInfo["slide"][$i]["pic"] = $slide[$i]["pic"];
			} else {
				$aboutInfo["slide"][$i]["pic"] = HTTPSHOST . $slide[$i]["pic"];
			}
			$aboutInfo["slide"][$i]["url"] = $slide[$i]["url"];
			$i++;
			goto hS7Gb;
		}
		$slideAll = pdo_fetch("SELECT slide FROM " . tablename("sudu8_page_base") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$aboutInfo["slide"] = unserialize($slideAll["slide"]);
		$num = count($aboutInfo["slide"]);
		$i = 0;
		Legyf:
		if ($i >= $num) {
			goto Gwc6j;
		}
		if (!stristr($aboutInfo["slide"][$i], "http")) {
			$aboutInfo["slide"][$i] = HTTPSHOST . $aboutInfo["slide"][$i];
		}
		$i++;
		goto Legyf;
		VuFPC:
	}
	public function doPageCommon()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$copyright = pdo_fetch("SELECT copyright,tel,tel_b,latitude,longitude,name,address FROM " . tablename("sudu8_page_base") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		return $this->result(0, "success", $copyright);
	}
	public function doPageProducts()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$products = pdo_fetchall("SELECT id,type,num,title,thumb,`desc`,buy_type FROM " . tablename("sudu8_page_products") . " WHERE uniacid = :uniacid ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
		foreach ($products as &$row) {
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
		}
		return $this->result(0, "success", $products);
	}
	public function doPageProductsList()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
		$ProductsList = pdo_fetchall("SELECT id,type,num,title,thumb,`desc`,buy_type FROM " . tablename("sudu8_page_products") . "WHERE uniacid = :uniacid ORDER BY num DESC,id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $uniacid));
		foreach ($ProductsList as &$row) {
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
		}
		return $this->result(0, "success", $ProductsList);
	}
	public function doPageProductsDetail()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = intval($_GPC["id"]);
		$ProductsDetail = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$data = array("hits" => $ProductsDetail["hits"] + 1);
		pdo_update("sudu8_page_products", $data, array("id" => $id, "uniacid" => $uniacid));
		if ($ProductsDetail["etime"]) {
			$ProductsDetail["etime"] = date("Y-m-d H:i:s", $ProductsDetail["etime"]);
		} else {
			$ProductsDetail["etime"] = date("Y-m-d H:i:s", $ProductsDetail["ctime"]);
		}
		$ProductsDetail["ctime"] = date("Y-m-d H:i:s", $ProductsDetail["ctime"]);
		if ($ProductsDetail["video"]) {
			include ROOT_PATH . "videoInfo.php";
			$videoInfo = new videoInfo();
			$videodata = $videoInfo->getVideoInfo($ProductsDetail["video"]);
			$ProductsDetail["video"] = $videodata["url"];
		}
		$ProductsDetail["btn"] = pdo_fetch("SELECT pic_page_btn FROM " . tablename("sudu8_page_cate") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $ProductsDetail["cid"], ":uniacid" => $uniacid));
		$cateConf = pdo_fetch("SELECT cateconf FROM " . tablename("sudu8_page_cate") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $ProductsDetail["cid"], ":uniacid" => $uniacid));
		$cateConf = unserialize($cateConf["cateconf"]);
		$ProductsDetail["pmarb"] = $cateConf["pmarb"];
		$ProductsDetail["ptit"] = $cateConf["ptit"];
		$formset = $ProductsDetail["formset"];
		if ($formset != 0 && $formset != '') {
			$forms = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_formlist") . " WHERE id = :id", array(":id" => $formset));
			$forms2 = unserialize($forms["tp_text"]);
			foreach ($forms2 as $key => &$res) {
				if ($res["tp_text"]) {
					$res["tp_text"] = explode(",", $res["tp_text"]);
				}
				$res["val"] = '';
			}
		} else {
			$forms2 = "NULL";
		}
		$ProductsDetail["forms"] = $forms2;
		return $this->result(0, "success", $ProductsDetail);
	}
	public function doPageFormsConfig()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$formsConfig = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_forms_config") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$formsConfig["t5"] = unserialize($formsConfig["t5"]);
		$formsConfig["t6"] = unserialize($formsConfig["t6"]);
		$formsConfig["c2"] = unserialize($formsConfig["c2"]);
		$formsConfig["s2"] = unserialize($formsConfig["s2"]);
		$formsConfig["con2"] = unserialize($formsConfig["con2"]);
		if (!($formsConfig["forms_head"] == "slide")) {
			c4A8P:
			if (!($formsConfig["forms_head"] == "newslide")) {
				ChTQi:
				if (!empty($formsConfig["single_num"]) and $formsConfig["single_num"] != 0) {
					$single_num = 100 / $formsConfig["single_num"];
					if ($single_num > 100 or $single_num < 20) {
						$formsConfig["single_num"] = 100;
					} else {
						$formsConfig["single_num"] = $single_num;
					}
				} else {
					$formsConfig["single_num"] = 100;
				}
				if (!empty($formsConfig["s2"]["s2num"]) and $formsConfig["s2"]["s2num"] != 0) {
					$single_num2 = 100 / $formsConfig["s2"]["s2num"];
					if ($single_num2 > 100 or $single_num2 < 20) {
						$formsConfig["s2"]["s2num"] = 100;
					} else {
						$formsConfig["s2"]["s2num"] = $single_num2;
					}
				} else {
					$formsConfig["s2"]["s2num"] = 100;
				}
				if (!empty($formsConfig["checkbox_num"]) and $formsConfig["checkbox_num"] != 0) {
					$checkbox_num = 100 / $formsConfig["checkbox_num"];
					if ($checkbox_num > 100 or $checkbox_num < 20) {
						$formsConfig["checkbox_num"] = 100;
					} else {
						$formsConfig["checkbox_num"] = $checkbox_num;
					}
				} else {
					$formsConfig["checkbox_num"] = 100;
				}
				if (!empty($formsConfig["c2"]["c2num"]) and $formsConfig["c2"]["c2num"] != 0) {
					$checkbox_num2 = 100 / $formsConfig["c2"]["c2num"];
					if ($checkbox_num2 > 100 or $checkbox_num2 < 20) {
						$formsConfig["c2"]["c2num"] = 100;
					} else {
						$formsConfig["c2"]["c2num"] = $checkbox_num2;
					}
				} else {
					$formsConfig["c2"]["c2num"] = 100;
				}
				return $this->result(0, "success", $formsConfig);
				goto EC3Cn;
			}
			$slide = pdo_fetchall("SELECT pic,url FROM " . tablename("sudu8_page_banner") . " WHERE uniacid = :uniacid and type = 'banner' ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
			$num = count($slide);
			$formsConfig["slide"] = array();
			$i = 0;
			lqijL:
			if ($i >= $num) {
				goto ChTQi;
			}
			if (stristr($slide[$i]["pic"], "http")) {
				$formsConfig["slide"][$i]["pic"] = $slide[$i]["pic"];
			} else {
				$formsConfig["slide"][$i]["pic"] = HTTPSHOST . $slide[$i]["pic"];
			}
			$formsConfig["slide"][$i]["url"] = $slide[$i]["url"];
			$i++;
			goto lqijL;
		}
		$slideAll = pdo_fetch("SELECT slide FROM " . tablename("sudu8_page_base") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$formsConfig["slide"] = unserialize($slideAll["slide"]);
		$num = count($formsConfig["slide"]);
		$i = 0;
		XnNqS:
		if ($i >= $num) {
			goto c4A8P;
		}
		if (!stristr($formsConfig["slide"][$i], "http")) {
			$formsConfig["slide"][$i] = HTTPSHOST . $formsConfig["slide"][$i];
		}
		$i++;
		goto XnNqS;
		EC3Cn:
	}
	public function doPageAddForms()
	{
		require_once "inc/class.phpmailer.php";
		require_once "inc/class.smtp.php";
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$formsConfig = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_forms_config") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$formsConfig["t5"] = unserialize($formsConfig["t5"]);
		$formsConfig["t6"] = unserialize($formsConfig["t6"]);
		$formsConfig["c2"] = unserialize($formsConfig["c2"]);
		$formsConfig["s2"] = unserialize($formsConfig["s2"]);
		$formsConfig["con2"] = unserialize($formsConfig["con2"]);
		$data = array("uniacid" => $_W["uniacid"], "name" => $_GPC["name"], "tel" => $_GPC["tel"], "wechat" => $_GPC["wechat"], "address" => $_GPC["address"], "date" => $_GPC["date"], "timef" => $_GPC["time"], "single" => $_GPC["single"], "checkbox" => $_GPC["checkbox"], "content" => $_GPC["content"], "t5" => $_GPC["t5"], "t6" => $_GPC["t6"], "s2" => $_GPC["s2"], "c2" => $_GPC["c2"], "con2" => $_GPC["con2"], "time" => TIMESTAMP);
		$result = pdo_insert("sudu8_page_forms", $data);
		if ($formsConfig["mail_user"] && $formsConfig["mail_sendto"]) {
			$mail_sendto = array();
			$mail_sendto = explode(",", $formsConfig["mail_sendto"]);
			$row_mail_user = $formsConfig["mail_user"];
			$row_mail_pass = $formsConfig["mail_password"];
			$row_mail_name = $formsConfig["mail_user_name"];
			$row_name = $formsConfig["name"] . "： " . $_GPC["name"] . "<br />";
			if ($formsConfig["tel_use"]) {
				$row_tel = $formsConfig["tel"] . "： " . $_GPC["tel"] . "<br />";
			}
			if ($formsConfig["wechat_use"]) {
				$row_wechat = $formsConfig["wechat"] . "： " . $_GPC["wechat"] . "<br />";
			}
			if ($formsConfig["address_use"]) {
				$row_address = $formsConfig["address"] . "： " . $_GPC["address"] . "<br />";
			}
			if ($formsConfig["t5"]["t5u"]) {
				$row_t5 = $formsConfig["t5"]["t5n"] . "： " . $_GPC["t5"] . "<br />";
			}
			if ($formsConfig["t6"]["t6u"]) {
				$row_t6 = $formsConfig["t6"]["t6n"] . "： " . $_GPC["t6"] . "<br />";
			}
			if ($formsConfig["date_use"]) {
				$row_date = $formsConfig["date"] . "： " . $_GPC["date"] . "<br />";
			}
			if ($formsConfig["time_use"]) {
				$row_time = $formsConfig["time"] . "： " . $_GPC["time"] . "<br />";
			}
			if ($formsConfig["single_use"]) {
				$row_single = $formsConfig["single_n"] . "： " . $_GPC["single"] . "<br />";
			}
			if ($formsConfig["s2"]["s2u"]) {
				$row_s2 = $formsConfig["s2"]["s2n"] . "： " . $_GPC["s2"] . "<br />";
			}
			if ($formsConfig["checkbox_use"]) {
				$row_checkbox = $formsConfig["checkbox_n"] . "： " . $_GPC["checkbox"] . "<br />";
			}
			if ($formsConfig["c2"]["c2u"]) {
				$row_c2 = $formsConfig["c2"]["c2n"] . "： " . $_GPC["c2"] . "<br />";
			}
			if ($formsConfig["content_use"]) {
				$row_content = $formsConfig["content_n"] . "： " . $_GPC["content"] . "<br />";
			}
			if ($formsConfig["con2"]["con2u"]) {
				$row_con2 = $formsConfig["con2"]["con2n"] . "： " . $_GPC["con2"] . "<br />";
			}
			$mail = new PHPMailer();
			$mail->CharSet = "utf-8";
			$mail->Encoding = "base64";
			$mail->SMTPSecure = "ssl";
			$mail->IsSMTP();
			$mail->Port = 465;
			$mail->Host = "smtp.qq.com";
			$mail->SMTPAuth = true;
			$mail->SMTPDebug = false;
			$mail->Username = $row_mail_user;
			$mail->Password = $row_mail_pass;
			$mail->setFrom($row_mail_user, $row_mail_name);
			foreach ($mail_sendto as $v) {
				$mail->AddAddress($v);
			}
			$mail->Subject = date("m-d", time()) . " - " . $_GPC["name"];
			$mail->isHTML(true);
			$mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>详细内容：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_name . $row_tel . $row_wechat . $row_address . $row_t5 . $row_t6 . $row_date . $row_time . $row_single . $row_s2 . $row_checkbox . $row_c2 . $row_content . $row_con2 . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
			if (!$mail->send()) {
				$result = "send_err";
			} else {
				$result = "send_ok";
			}
		}
		return $this->result(0, "success", $result);
	}
	public function doPageNav()
	{
		global $_GPC, $_W;
		$type = $_GPC["type"];
		$uniacid = $_W["uniacid"];
		$nav = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_nav") . " WHERE uniacid = :uniacid and type = :type", array(":uniacid" => $uniacid, ":type" => $type));
		$nav["number"] = 100 / $nav["number"] - $nav["box_p_lr"] * 2;
		if ($nav["statue"] == 1) {
			$nav_list = explode(",", $nav["url"]);
			$nav["url"] = array();
			foreach ($nav_list as $row) {
				$cate_list = pdo_fetch("SELECT id,cid,catepic,name,name_n,type,list_type FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :id", array(":uniacid" => $uniacid, ":id" => $row));
				if ($cate_list["type"] == "page") {
					$cate_list["list_type"] = "page";
				} else {
					if ($cate_list["list_type"] == 0) {
						$cate_list["list_type"] = "listCate";
					} else {
						if ($cate_list["list_type"] == 1) {
							if ($cate_list["type"] == "showPro") {
								$cate_list["list_type"] = "listPro";
							} else {
								$cate_list["list_type"] = "listPic";
							}
						}
					}
				}
				if (empty($cate_list["name_n"])) {
					$cate_list["name_n"] = $cate_list["name"];
				}
				if (!stristr($cate_list["catepic"], "http")) {
					$cate_list["catepic"] = HTTPSHOST . $cate_list["catepic"];
				}
				array_push($nav["url"], $cate_list);
			}
		} else {
			if ($nav["statue"] == 2) {
				$nav["url"] = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_navlist") . " WHERE uniacid = :uniacid  and flag = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
				foreach ($nav["url"] as &$row) {
					if ($row["type"] == 5) {
						$row["url"] = urlencode($row["url"]);
					}
					if (!stristr($row["pic"], "http")) {
						$row["pic"] = HTTPSHOST . $row["pic"];
					}
				}
			}
		}
		return $this->result(0, "success", $nav);
	}
	public function doPageindexCop()
	{
		global $_GPC, $_W;
		$type = $_GPC["type"];
		$uniacid = $_W["uniacid"];
		$now = time();
		$indexCopAll = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_coupon") . " WHERE (etime > " . $now . " or etime =0) and uniacid = :uniacid  and flag = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
		$indexCopOne = $indexCopAll["0"];
		if ($indexCopOne) {
			if ($indexCopOne["btime"]) {
				$indexCopOne["btime"] = date("Y-m-d", $indexCopOne["btime"]);
			}
			if ($indexCopOne["etime"]) {
				$indexCopOne["etime"] = date("Y-m-d", $indexCopOne["etime"]);
			}
		}
		return $this->result(0, "success", $indexCopOne);
	}
	public function doPageIndex_hot()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$list_x = pdo_fetchall("SELECT id,type,num,title,thumb,`desc`,buy_type,is_more FROM " . tablename("sudu8_page_products") . " WHERE type_x=1 and uniacid = :uniacid ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
		foreach ($list_x as &$row) {
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
			if ($row["type"] == "showPro" && $row["is_more"] == 1) {
				$row["type"] = "showPro_lv";
			}
		}
		$list_y = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,buy_type,is_more FROM " . tablename("sudu8_page_products") . " WHERE type_y=1 and flag = 1 and uniacid = :uniacid ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
		foreach ($list_y as &$row) {
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
			$row["ctime"] = date("y-m-d H:i:s", $row["ctime"]);
			if ($row["type"] == "showPro" && $row["is_more"] == 1) {
				$row["type"] = "showPro_lv";
			}
		}
		$Index_hot = array();
		$Index_hot["list_x"] = $list_x;
		$Index_hot["list_y"] = $list_y;
		return $this->result(0, "success", $Index_hot);
	}
	public function doPageIndex_cate()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$index_cate = pdo_fetchall("SELECT id,cid,num,name,ename,type,list_type,list_style,list_tstyle,list_stylet FROM " . tablename("sudu8_page_cate") . " WHERE cid=0 and uniacid = :uniacid and show_i = 1 and statue =1   ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
		foreach ($index_cate as $key => $row) {
			$id = $row["id"];
			if (!stristr($row["catepic"], "http")) {
				$row["catepic"] = HTTPSHOST . $row["catepic"];
			}
			if ($row["type"] == "showPic" or $row["type"] == "showArt" or $row["type"] == "showPro") {
				if ($row["list_type"] == 0) {
					$index_cate[$key]["l_type"] = "listCate";
					$index_cate[$key]["list"] = array();
					$index_cate[$key]["list"] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle,type FROM " . tablename("sudu8_page_cate") . " WHERE cid=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":cid" => $id));
					foreach ($index_cate[$key]["list"] as $key2 => $row2) {
						if ($index_cate[$key]["list"][$key2]["type"] == "showPro") {
							$index_cate[$key]["list"][$key2]["type"] = "listPro";
						} else {
							$index_cate[$key]["list"][$key2]["type"] = "listPic";
						}
						if (stristr($row2["catepic"], "http")) {
							$index_cate[$key]["list"][$key2]["catepic"] = $row2["catepic"];
						} else {
							$index_cate[$key]["list"][$key2]["catepic"] = HTTPSHOST . $row2["catepic"];
						}
					}
				} else {
					if ($row["list_type"] == 1) {
						if ($index_cate[$key]["type"] == "showPro") {
							$index_cate[$key]["l_type"] = "listPro";
						} else {
							$index_cate[$key]["l_type"] = "listPic";
						}
						$index_cate[$key]["list"] = array();
						$index_cate[$key]["list"] = pdo_fetchall("SELECT id,num,type_i,title,thumb,hits,type,ctime,`desc`,price,market_price,sale_num,is_more,buy_type,sale_tnum FROM " . tablename("sudu8_page_products") . " WHERE  pcid= :pcid and flag = 1 and uniacid = :uniacid and type_i = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":pcid" => $id));
						foreach ($index_cate[$key]["list"] as $key2 => $row2) {
							$index_cate[$key]["list"][$key2]["ctime"] = date("y-m-d H:i:s", $index_cate[$key]["list"][$key2]["ctime"]);
							if (stristr($row2["thumb"], "http")) {
								$index_cate[$key]["list"][$key2]["thumb"] = $row2["thumb"];
							} else {
								$index_cate[$key]["list"][$key2]["thumb"] = HTTPSHOST . $row2["thumb"];
							}
							$index_cate[$key]["list"][$key2]["sale_num"] = intval($index_cate[$key]["list"][$key2]["sale_num"]) + intval($index_cate[$key]["list"][$key2]["sale_tnum"]);
							if ($row2["is_more"] == 1 && $row2["type"] == "showPro") {
								$index_cate[$key]["list"][$key2]["type"] = "showPro_lv";
							}
						}
					}
				}
			} else {
				if ($row["type"] == "showWxapps") {
					if ($row["list_type"] == 0) {
						$index_cate[$key]["l_type"] = "listCate";
						$index_cate[$key]["list"] = array();
						$index_cate[$key]["list"] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle FROM " . tablename("sudu8_page_cate") . " WHERE cid=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":cid" => $id));
						foreach ($index_cate[$key]["list"] as $key2 => $row2) {
							if (stristr($row2["catepic"], "http")) {
								$index_cate[$key]["list"][$key2]["catepic"] = $row2["catepic"];
							} else {
								$index_cate[$key]["list"][$key2]["catepic"] = HTTPSHOST . $row2["catepic"];
							}
						}
					} else {
						if ($row["list_type"] == 1) {
							$index_cate[$key]["l_type"] = "listPic";
							$index_cate[$key]["list"] = array();
							$index_cate[$key]["list"] = pdo_fetchall("SELECT id,num,title,type,thumb,appId,path,`desc` FROM " . tablename("sudu8_page_wxapps") . " WHERE  pcid= :pcid and uniacid = :uniacid and type_i = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":pcid" => $id));
							foreach ($index_cate[$key]["list"] as $key2 => $row2) {
								if (stristr($row2["thumb"], "http")) {
									$index_cate[$key]["list"][$key2]["thumb"] = $row2["thumb"];
								} else {
									$index_cate[$key]["list"][$key2]["thumb"] = HTTPSHOST . $row2["thumb"];
								}
							}
						}
					}
				} else {
					if ($row["type"] == "page") {
						if ($row["list_type"] == 0) {
							$index_cate[$key]["l_type"] = "page";
							$index_cate[$key]["list"] = array();
							$index_cate[$key]["list"] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle,type FROM " . tablename("sudu8_page_cate") . " WHERE cid=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":cid" => $id));
							foreach ($index_cate[$key]["list"] as $key2 => $row2) {
								if (stristr($row2["catepic"], "http")) {
									$index_cate[$key]["list"][$key2]["catepic"] = $row2["catepic"];
								} else {
									$index_cate[$key]["list"][$key2]["catepic"] = HTTPSHOST . $row2["catepic"];
								}
							}
						} else {
							if ($row["list_type"] == 1) {
								$index_cate[$key]["l_type"] = "page";
								$index_cate[$key]["list"] = array();
								$index_cate[$key]["list"] = pdo_fetchall("SELECT id,cid,num,name,ename,catepic,cdesc,list_style,list_tstyle FROM " . tablename("sudu8_page_cate") . " WHERE id=:cid and uniacid = :uniacid and statue =1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":cid" => $id));
								foreach ($index_cate[$key]["list"] as $key2 => $row2) {
									if (stristr($row2["catepic"], "http")) {
										$index_cate[$key]["list"][$key2]["catepic"] = $row2["catepic"];
									} else {
										$index_cate[$key]["list"][$key2]["catepic"] = HTTPSHOST . $row2["catepic"];
									}
									$index_cate[$key]["list"][$key2]["type"] = "page";
								}
							}
						}
					}
				}
			}
		}
		return $this->result(0, "success", $index_cate);
	}
	public function doPagelistPic()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$pindex = max(1, intval($_GPC["page"]));
		$cid = intval($_GPC["cid"]);
		$psize = 10;
		$cateinfo = pdo_fetch("SELECT id,cid,type FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :cid", array(":uniacid" => $uniacid, ":cid" => $cid));
		if ($cateinfo["cid"] == 0) {
			$pcid = $cateinfo["id"];
			$slid = "pcid";
		} else {
			$pcid = $cateinfo["cid"];
			$slid = "cid";
		}
		$cateinfo = pdo_fetch("SELECT id,name,ename,type,list_type,list_style,list_tstyle,list_tstylel,list_stylet FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :cid", array(":uniacid" => $uniacid, ":cid" => $pcid));
		$cate_first = pdo_fetch("SELECT id,name FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :cid", array(":uniacid" => $uniacid, ":cid" => $pcid));
		$cate_first["name"] = "全部";
		$cateinfo["cate"] = pdo_fetchall("SELECT id,num,name FROM " . tablename("sudu8_page_cate") . "WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":cid" => $pcid));
		array_unshift($cateinfo["cate"], $cate_first);
		$cateinfo["this"] = pdo_fetch("SELECT id,name,ename,type,list_type,list_style,list_tstyle,list_tstylel,list_stylet FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :cid", array(":uniacid" => $uniacid, ":cid" => $cid));
		if ($cateinfo["type"] == "showArt" or $cateinfo["type"] == "showPic" or $cateinfo["type"] == "showPro") {
			$cateinfo["num"] = pdo_fetchall("SELECT id FROM " . tablename("sudu8_page_products") . "WHERE uniacid = :uniacid and flag = 1 and " . $slid . " = :cid", array(":uniacid" => $uniacid, ":cid" => $cid));
			$cateinfo["list"] = pdo_fetchall("SELECT id,type,num,title,thumb,ctime,hits,`desc`,price,market_price,sale_num,is_more,buy_type FROM " . tablename("sudu8_page_products") . "WHERE uniacid = :uniacid and flag = 1 and " . $slid . " = :cid ORDER BY num DESC,id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $uniacid, ":cid" => $cid));
			foreach ($cateinfo["list"] as &$row) {
				$row["ctime"] = date("y-m-d H:i:s", $row["ctime"]);
				if (!stristr($row["thumb"], "http")) {
					$row["thumb"] = HTTPSHOST . $row["thumb"];
				}
				if ($row["is_more"] == 1) {
					$row["type"] = "showPro_lv";
				}
			}
		} else {
			if ($cateinfo["type"] == "showWxapps") {
				$cateinfo["num"] = pdo_fetchall("SELECT id FROM " . tablename("sudu8_page_wxapps") . "WHERE uniacid = :uniacid and " . $slid . " = :cid", array(":uniacid" => $uniacid, ":cid" => $cid));
				$cateinfo["list"] = pdo_fetchall("SELECT id,type,num,title,thumb,appId,path,`desc` FROM " . tablename("sudu8_page_wxapps") . "WHERE uniacid = :uniacid and " . $slid . " = :cid ORDER BY num DESC,id DESC LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $uniacid, ":cid" => $cid));
				foreach ($cateinfo["list"] as &$row) {
					if (!stristr($row["thumb"], "http")) {
						$row["thumb"] = HTTPSHOST . $row["thumb"];
					}
				}
			}
		}
		return $this->result(0, "success", $cateinfo);
	}
	public function doPagelistCate()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$pindex = max(1, intval($_GPC["page"]));
		$cid = intval($_GPC["cid"]);
		$cateinfo = pdo_fetch("SELECT id,name,ename,type,list_type,type,list_style,list_tstyle,list_tstylel,list_stylet FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :cid", array(":uniacid" => $uniacid, ":cid" => $cid));
		$cateinfo["list"] = pdo_fetchall("SELECT id,name,catepic,cdesc,list_style,list_tstyle,list_stylet,list_tstylel FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and cid = :cid ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid, ":cid" => $cid));
		if ($cateinfo["type"] == "showPro") {
			$cateinfo["l_type"] = "listPro";
		} else {
			$cateinfo["l_type"] = "listPic";
		}
		foreach ($cateinfo["list"] as &$row) {
			if (!stristr($row["catepic"], "http")) {
				$row["catepic"] = HTTPSHOST . $row["catepic"];
			}
		}
		return $this->result(0, "success", $cateinfo);
	}
	public function doPageshowPic()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = intval($_GPC["id"]);
		$pics = pdo_fetch("SELECT title,text,hits,cid,`desc`,buy_type FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$pics["btn"] = pdo_fetch("SELECT pic_page_btn FROM " . tablename("sudu8_page_cate") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $pics["cid"], ":uniacid" => $uniacid));
		$data = array("hits" => $pics["hits"] + 1);
		pdo_update("sudu8_page_products", $data, array("id" => $id, "uniacid" => $uniacid));
		$pics["text"] = unserialize($pics["text"]);
		$num = count($pics["text"]);
		$i = 0;
		iffOl:
		if ($i >= $num) {
			return $this->result(0, "success", $pics);
		} else {
			if (!stristr($pics["text"][$i], "http")) {
				$pics["text"][$i] = HTTPSHOST . $pics["text"][$i];
			}
			$i++;
			goto iffOl;
		}
	}
	public function doPageshowPro()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = intval($_GPC["id"]);
		$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$data = array("hits" => $pro["hits"] + 1);
		pdo_update("sudu8_page_products", $data, array("id" => $id, "uniacid" => $uniacid));
		$pro["text"] = unserialize($pro["text"]);
		$num = count($pro["text"]);
		$i = 0;
		jxXJJ:
		if ($i >= $num) {
			$orders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :id and uniacid = :uniacid and flag >0", array(":id" => $id, ":uniacid" => $uniacid));
			if ($pro["is_more"] == 1) {
				if ($orders) {
					$allnum = 0;
					foreach ($orders as $rec) {
						$duo = $rec["order_duo"];
						$newduo = unserialize($duo);
						foreach ($newduo as $key => &$res) {
							$allnum[$key] += $res[5];
						}
					}
				}
			}
			$sale_num = 0;
			if ($orders) {
				foreach ($orders as $rec) {
					$sale_num += $rec["num"];
				}
			}
			$pro["sale_num"] = $pro["sale_num"] + $sale_num;
			$openid = $_GPC["openid"];
			$myorders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :id and openid = :openid and uniacid = :uniacid and flag>=0", array(":id" => $id, ":openid" => $openid, ":uniacid" => $uniacid));
			$my_num = 0;
			$collectcount = 0;
			if ($openid) {
				$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
				$uid = $user["id"];
				$collect = pdo_fetch("SELECT count(*) as n FROM " . tablename("sudu8_page_collect") . " WHERE uniacid = :uniacid and uid = :uid and type = :type and cid = :cid", array(":uniacid" => $uniacid, ":uid" => $uid, ":type" => "showPro", ":cid" => $id));
				if ($collect["n"] > 0) {
					$collectcount = 1;
				}
			}
			$pro["collectcount"] = $collectcount;
			if ($pro["pro_kc"] >= 0 && $pro["is_more"] == 0) {
				$now = time();
				$onum = 0;
				$allorders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :pid  and uniacid = :uniacid and flag = 0 and overtime < :nowtime", array(":pid" => $id, ":uniacid" => $uniacid, ":nowtime" => $now));
				if ($allorders) {
					foreach ($allorders as $rec) {
						$onum += $rec["num"];
						$kdata["flag"] = -1;
						$kdata["reback"] = 1;
						pdo_update("sudu8_page_order", $kdata, array("order_id" => $rec["order_id"], "uniacid" => $uniacid));
					}
					$ndata["pro_kc"] = $pro["pro_kc"] + $onum;
					pdo_update("sudu8_page_products", $ndata, array("id" => $id, "uniacid" => $uniacid));
				}
			} else {
				if ($pro["pro_kc"] < 0 && $pro["is_more"] == 0) {
					$now = time();
					$allorders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :pid  and uniacid = :uniacid and flag = 0 and overtime < :nowtime", array(":pid" => $id, ":uniacid" => $uniacid, ":nowtime" => $now));
					if ($allorders) {
						foreach ($allorders as $rec) {
							$kdata["flag"] = -1;
							$kdata["reback"] = 1;
							pdo_update("sudu8_page_order", $kdata, array("order_id" => $rec["order_id"], "uniacid" => $uniacid));
						}
					}
				}
			}
			if ($pro["is_more"] == 1) {
				$now = time();
				if ($now > $orders["overtime"] && $orders["flag"] == 0) {
					$kdata["flag"] = -1;
					pdo_update("sudu8_page_order", $kdata, array("order_id" => $id, "uniacid" => $uniacid));
				}
			}
			if ($myorders) {
				foreach ($myorders as $res) {
					$my_num += $res["num"];
				}
			}
			$pro["my_num"] = $my_num;
			$now = time();
			if ($pro["sale_time"] == 0) {
				$pro["is_sale"] = 1;
			} else {
				if ($pro["sale_time"] > $now) {
					$pro["is_sale"] = 0;
				} else {
					$pro["is_sale"] = 1;
				}
			}
			if (!stristr($pro["thumb"], "http")) {
				$pro["thumb"] = HTTPSHOST . $pro["thumb"];
			}
			if ($pro["labels"] && $pro["is_more"] == 0) {
				$labels = explode(",", $pro["labels"]);
				$pro["labels"] = $labels;
			} else {
				if ($pro["labels"] && $pro["is_more"] == 1) {
					$labels = unserialize($pro["labels"]);
					$arrkk = array();
					foreach ($labels as $key => $res) {
						$vvkk = array($key, $res);
						array_push($arrkk, $vvkk);
					}
					$pro["labels"] = $arrkk;
				} else {
					$pro["labels"] = array();
				}
			}
			if ($pro["more_type"]) {
				$more_type = unserialize($pro["more_type"]);
				$newmore = array_chunk($more_type, 4);
				$pro["more_type"] = $newmore;
			}
			if ($pro["more_type_x"]) {
				$more_type_x = unserialize($pro["more_type_x"]);
				$pro["more_type_x"] = $more_type_x;
			}
			if ($pro["more_type_num"]) {
				$more_type_num = unserialize($pro["more_type_num"]);
				$pro["more_type_num"] = $more_type_num;
			}
			$formset = $pro["formset"];
			if ($formset != 0 && $formset != '') {
				$forms = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_formlist") . " WHERE id = :id", array(":id" => $formset));
				$forms2 = unserialize($forms["tp_text"]);
				foreach ($forms2 as $key => &$res) {
					if ($res["tp_text"] && $res["type"] != 2 && $res["type"] != 5) {
						$vals = explode(",", $res["tp_text"]);
						$kk = array();
						foreach ($vals as $key => &$rec) {
							$kk["yval"] = $rec;
							$kk["checked"] = "false";
							$rec = $kk;
						}
						$res["tp_text"] = $vals;
					}
					if ($res["tp_text"] && $res["type"] == 2) {
						$vals = explode(",", $res["tp_text"]);
						$res["tp_text"] = $vals;
					}
					$res["val"] = '';
				}
			} else {
				$forms2 = "NULL";
			}
			$pro["forms"] = $forms2;
			return $this->result(0, "success", $pro);
		} else {
			if (!stristr($pro["text"][$i], "http")) {
				$pro["text"][$i] = HTTPSHOST . $pro["text"][$i];
			}
			$i++;
			goto jxXJJ;
		}
	}
	public function doPageDingd()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = $_GPC["id"];
		$flags = true;
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $_GPC["openid"], ":uniacid" => $uniacid));
		$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		if ($pro["more_type_num"]) {
			$more_type_num = unserialize($pro["more_type_num"]);
		}
		if ($pro["is_more"] == "1" or $pro["is_more"] == 1) {
			$num = $_GPC["num"];
			$newnum = explode(",", substr($num, 1, strlen($num) - 2));
			$numarr = array();
			foreach ($newnum as $rec) {
				$nnn = explode(":", $rec);
				$numarr[] = $nnn[1];
			}
			$guig = unserialize($pro["more_type_x"]);
			foreach ($guig as $key => &$rec) {
				$rec[] = $numarr[$key];
			}
			$newgg = serialize($guig);
			$order = $_GPC["order"];
			if ($_GPC["order"]) {
				$order = $_GPC["order"];
			} else {
				$now = time();
				$order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
			}
			$overtime = time() + 30 * 60;
			$data = array("uniacid" => $_W["uniacid"], "order_id" => $order, "uid" => $user["id"], "openid" => $_GPC["openid"], "pid" => $_GPC["id"], "thumb" => $pro["thumb"], "product" => $pro["title"], "yhq" => $_GPC["youhui"], "true_price" => $_GPC["zhifu"], "creattime" => time(), "flag" => 0, "pro_user_name" => $_GPC["pro_name"], "pro_user_tel" => $_GPC["pro_tel"], "pro_user_add" => $_GPC["pro_address"], "pro_user_txt" => $_GPC["pro_txt"], "overtime" => $overtime, "is_more" => 1, "order_duo" => $newgg, "coupon" => $_GPC["yhqid"]);
			if ($_GPC["pagedata"] && $_GPC["pagedata"] !== "NULL") {
				$forms = stripslashes(html_entity_decode($_GPC["pagedata"]));
				$forms = json_decode($forms, TRUE);
				$data["beizhu_val"] = serialize($forms);
			}
			if ($_GPC["order"]) {
				$res = pdo_update("sudu8_page_order", $data, array("order_id" => $order, "uniacid" => $uniacid));
			} else {
				$res = pdo_insert("sudu8_page_order", $data);
			}
			if ($res) {
				$data["success"] = 1;
				$data["xg"] = $pro["pro_xz"];
				return $this->result(0, "success", $data);
			}
		}
		$openid = $_GPC["openid"];
		$pid = $orders["pid"];
		$myorders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :pid and openid = :openid and uniacid = :uniacid and flag>=0", array(":pid" => $pid, ":openid" => $openid, ":uniacid" => $uniacid));
		$my_num = 0;
		if ($myorders) {
			foreach ($myorders as $res) {
				$my_num += $res["num"];
			}
		}
		$num = $_GPC["count"];
		$orderid = $_GPC["order"];
		if (!$orderid) {
			if ($pro["pro_kc"] == -1) {
				$flags = true;
				$syl = $pro["pro_kc"];
			} else {
				if ($pro["pro_kc"] + $my_num == 0) {
					$syl = 0;
					$flags = false;
				}
				if ($pro["pro_kc"] + $my_num != 0) {
					if ($pro["pro_xz"] == 0) {
						if ($num > $pro["pro_kc"]) {
							$syl = $pro["pro_kc"];
							$flags = false;
						}
					} else {
						if ($my_num + $num > $pro["pro_xz"] || $num > $pro["pro_kc"]) {
							$syl = $pro["pro_kc"];
							$flags = false;
						}
					}
				}
			}
		} else {
			$oinfo = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :order and uniacid = :uniacid", array(":order" => $orderid, ":uniacid" => $uniacid));
			$ddnum = $oinfo["num"];
			if ($pro["pro_kc"] == -1) {
				$flags = true;
				$syl = $pro["pro_kc"];
			} else {
				$cha = $ddnum - $num;
				$new_num = $my_num - $cha;
				if ($new_num < 0) {
					$absnum = abs($new_num);
					if ($my_num + $absnum > $pro["pro_xz"] || $absnum > $pro["pro_kc"]) {
						$syl = $pro["pro_kc"];
						$flags = false;
					}
				} else {
					$flags = true;
				}
			}
		}
		if ($flags && $pro["pro_kc"] >= 0) {
			if ($_GPC["order"]) {
				$order = $_GPC["order"];
				$oinfo = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :order and uniacid = :uniacid", array(":order" => $order, ":uniacid" => $uniacid));
				$onum = $oinfo["num"];
				$newnum = $num - $onum;
				$ndata["pro_kc"] = $pro["pro_kc"] - $newnum;
				pdo_update("sudu8_page_products", $ndata, array("id" => $id, "uniacid" => $uniacid));
			} else {
				$now = time();
				$order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
				$ndata["pro_kc"] = $pro["pro_kc"] - $num;
				pdo_update("sudu8_page_products", $ndata, array("id" => $id, "uniacid" => $uniacid));
			}
			$overtime = time() + 30 * 60;
			$data = array("uniacid" => $_W["uniacid"], "order_id" => $order, "uid" => $user["id"], "openid" => $_GPC["openid"], "pid" => $_GPC["id"], "thumb" => $pro["thumb"], "product" => $pro["title"], "price" => $_GPC["price"], "num" => $_GPC["count"], "yhq" => $_GPC["youhui"], "true_price" => $_GPC["zhifu"], "creattime" => time(), "flag" => 0, "pro_user_name" => $_GPC["pro_name"], "pro_user_tel" => $_GPC["pro_tel"], "pro_user_add" => $_GPC["pro_address"], "pro_user_txt" => $_GPC["pro_txt"], "overtime" => $overtime, "coupon" => $_GPC["yhqid"]);
			if ($_GPC["pagedata"] && $_GPC["pagedata"] !== "NULL") {
				$forms = stripslashes(html_entity_decode($_GPC["pagedata"]));
				$forms = json_decode($forms, TRUE);
				$data["beizhu_val"] = serialize($forms);
			}
			if ($_GPC["order"]) {
				$res = pdo_update("sudu8_page_order", $data, array("order_id" => $order, "uniacid" => $uniacid));
			} else {
				$res = pdo_insert("sudu8_page_order", $data);
			}
			if ($res) {
				$data["success"] = 1;
				$data["xg"] = $pro["pro_xz"];
				return $this->result(0, "success", $data);
			}
		}
		if ($flags && $pro["pro_kc"] < 0) {
			if ($_GPC["order"]) {
				$order = $_GPC["order"];
			} else {
				$now = time();
				$order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
			}
			$overtime = time() + 30 * 60;
			$data = array("uniacid" => $_W["uniacid"], "order_id" => $order, "uid" => $user["id"], "openid" => $_GPC["openid"], "pid" => $_GPC["id"], "thumb" => $pro["thumb"], "product" => $pro["title"], "price" => $_GPC["price"], "num" => $_GPC["count"], "yhq" => $_GPC["youhui"], "true_price" => $_GPC["zhifu"], "creattime" => time(), "flag" => 0, "pro_user_name" => $_GPC["pro_name"], "pro_user_tel" => $_GPC["pro_tel"], "pro_user_add" => $_GPC["pro_address"], "pro_user_txt" => $_GPC["pro_txt"], "overtime" => $overtime, "coupon" => $_GPC["yhqid"]);
			if ($_GPC["pagedata"] && $_GPC["pagedata"] !== "NULL") {
				$forms = stripslashes(html_entity_decode($_GPC["pagedata"]));
				$forms = json_decode($forms, TRUE);
				$data["beizhu_val"] = serialize($forms);
			}
			if ($_GPC["order"]) {
				$res = pdo_update("sudu8_page_order", $data, array("order_id" => $order, "uniacid" => $uniacid));
			} else {
				$res = pdo_insert("sudu8_page_order", $data);
			}
			if ($res) {
				$data["success"] = 1;
				$data["xg"] = $pro["pro_xz"];
				return $this->result(0, "success", $data);
			}
		}
		if (!$flags) {
			$data["success"] = 0;
			$data["syl"] = $syl;
			$data["id"] = $id;
			return $this->result(0, "error", $data);
		}
	}
	public function doPageOrderinfo()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = $_GPC["order"];
		$orders = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $orders["pid"], ":uniacid" => $uniacid));
		if (!stristr($orders["thumb"], "http")) {
			$orders["thumb"] = HTTPSHOST . $orders["thumb"];
		}
		$openid = $orders["openid"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
		$money = $user["money"];
		$score = $user["score"];
		$jf_gz = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_rechargeconf") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if (!$jf_gz) {
			$jf_gz["scroe"] = 10000;
			$jf_gz["money"] = 1;
		}
		$jf_money = intval($score / $jf_gz["scroe"]) * $jf_gz["money"];
		$jf_pro = intval($pro["score_num"] / $jf_gz["scroe"]) * $jf_gz["money"];
		$dikou_jf = 0;
		if ($jf_pro >= $jf_money) {
			$dikou_jf = $jf_money;
			if ($dikou_jf * 1000 > $orders["true_price"] * 1000) {
				$dikou_jf = $orders["true_price"];
			} else {
				$dikou_jf = $dikou_jf;
			}
		} else {
			$dikou_jf = $jf_pro;
			if ($dikou_jf * 1000 > $orders["true_price"] * 1000) {
				$dikou_jf = $orders["true_price"];
			} else {
				$dikou_jf = $dikou_jf;
			}
		}
		$jf_score = $dikou_jf / $jf_gz["money"] * $jf_gz["scroe"];
		if ($pro["pro_kc"] >= 0 && $pro["is_more"] == 0) {
			$now = time();
			if ($now > $orders["overtime"] && $orders["reback"] == 0 && $orders["flag"] == 0) {
				$onum = $orders["num"];
				$kdata["flag"] = -1;
				$kdata["reback"] = 1;
				pdo_update("sudu8_page_order", $kdata, array("order_id" => $id, "uniacid" => $uniacid));
				$ndata["pro_kc"] = $pro["pro_kc"] + $onum;
				pdo_update("sudu8_page_products", $ndata, array("id" => $orders["pid"], "uniacid" => $uniacid));
			}
		} else {
			if ($pro["pro_kc"] < 0 && $pro["is_more"] == 0) {
				$now = time();
				if ($now > $orders["overtime"] && $orders["reback"] == 0 && $orders["flag"] == 0) {
					$kdata["flag"] = -1;
					$kdata["reback"] = 1;
					pdo_update("sudu8_page_order", $kdata, array("order_id" => $id, "uniacid" => $uniacid));
				}
			}
		}
		if ($pro["is_more"] == "1" or $pro["is_more"] == 1) {
			$now = time();
			if ($now > $orders["overtime"] && $orders["flag"] == 0) {
				$kdata["flag"] = -1;
				pdo_update("sudu8_page_order", $kdata, array("order_id" => $id, "uniacid" => $uniacid));
			}
		}
		$new_orders = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$mycoupon = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_coupon_user") . " WHERE id = :cid and uniacid = :uniacid", array(":cid" => $new_orders["coupon"], ":uniacid" => $uniacid));
		$coupon = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_coupon") . " WHERE id = :cid and uniacid = :uniacid", array(":cid" => $mycoupon["cid"], ":uniacid" => $uniacid));
		$openid = $_GPC["openid"];
		$pid = $new_orders["pid"];
		$myorders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :pid and openid = :openid and uniacid = :uniacid and flag>=0", array(":pid" => $pid, ":openid" => $openid, ":uniacid" => $uniacid));
		$my_num = 0;
		if ($myorders) {
			foreach ($myorders as $res) {
				$my_num += $res["num"];
			}
		}
		$cdd = count($myorders);
		$orders_l = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE pid = :pid and uniacid = :uniacid and flag>0", array(":pid" => $pid, ":uniacid" => $uniacid));
		$sale_num = 0;
		if ($orders_l) {
			foreach ($orders_l as $rec) {
				$sale_num += $rec["num"];
			}
		}
		$new_orders["sale_num"] = $new_orders["sale_num"] + $sale_num;
		$now = time();
		$overtime = $orders["overtime"];
		if ($now > $overtime) {
			$new_orders["isover"] = 1;
		} else {
			$new_orders["isover"] = 0;
		}
		$new_orders["my_num"] = $my_num;
		$new_orders["mcount"] = $cdd;
		$new_orders["pro_flag"] = $pro["pro_flag"];
		$new_orders["pro_flag_tel"] = $pro["pro_flag_tel"];
		$new_orders["pro_flag_add"] = $pro["pro_flag_add"];
		$new_orders["pro_flag_data"] = $pro["pro_flag_data"];
		$new_orders["pro_flag_data_name"] = $pro["pro_flag_data_name"];
		$new_orders["pro_flag_time"] = $pro["pro_flag_time"];
		$new_orders["pro_flag_ding"] = $pro["pro_flag_ding"];
		$new_orders["pro_kc"] = $pro["pro_kc"];
		$new_orders["pro_xz"] = $pro["pro_xz"];
		if (!stristr($new_orders["thumb"], "http")) {
			$new_orders["thumb"] = HTTPSHOST . $new_orders["thumb"];
		}
		$new_orders["more_type_x"] = unserialize($new_orders["order_duo"]);
		$new_orders["chuydate"] = date("Y-m-d", $new_orders["overtime"]);
		$new_orders["chuytime"] = date("H:i", $new_orders["overtime"]);
		$new_orders["more_type_num"] = unserialize($pro["more_type_num"]);
		$new_orders["couponid"] = $new_orders["coupon"];
		$new_orders["is_score"] = $pro["is_score"];
		$new_orders["jf_score"] = $jf_score;
		if ($coupon) {
			$new_orders["coupon"] = $coupon;
		} else {
			$coupon["price"] = 0;
			$new_orders["coupon"] = $coupon;
		}
		$new_orders["shengyutime"] = intval(($overtime - time()) / 60);
		$fomeval = unserialize($orders["beizhu_val"]);
		foreach ($fomeval as $key => &$res) {
			if ($res["type"] == 3) {
				foreach ($res["tp_text"] as &$val) {
					if (in_array($val["yval"], $res["val"])) {
						$val["checked"] = "true";
					} else {
						$val["checked"] = "false";
					}
				}
			}
			if ($res["type"] == 4) {
				foreach ($res["tp_text"] as &$val) {
					$kk = array();
					if ($val["yval"] == $res["val"]) {
						$val["checked"] = "true";
					} else {
						$val["checked"] = "false";
					}
				}
			}
			if ($res["type"] == 5) {
				$imgall = $res["z_val"];
				foreach ($imgall as $key => &$rec) {
					$rec = HTTPSHOST . $rec;
				}
				$res["z_val"] = $imgall;
			}
		}
		$new_orders["beizhu_val"] = $fomeval;
		$new_orders["my_money"] = $money;
		$new_orders["dikou_jf"] = $dikou_jf;
		return $this->result(0, "success", $new_orders);
	}
	public function doPageorderpayover()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = $_GPC["order_id"];
		$my_pay_money = $_GPC["my_pay_money"];
		$orders = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $orders["pid"], ":uniacid" => $uniacid));
		$coupondata = array("flag" => 1);
		pdo_update("sudu8_page_coupon_user", $coupondata, array("id" => $orders["coupon"], "uniacid" => $uniacid));
		$jifen = $_GPC["jf_score"];
		$jf_gz = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_rechargeconf") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if (!$jf_gz) {
			$jf_gz["scroe"] = 10000;
			$jf_gz["money"] = 1;
		}
		$jf_score = $jifen / $jf_gz["money"] * $jf_gz["scroe"];
		$openid = $orders["openid"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
		$money = $user["money"];
		$true_money = ($user["money"] * 1000 - $my_pay_money * 1000) / 1000;
		$true_score = $user["score"] - $jf_score;
		$tprice["money"] = $true_money;
		$tprice["score"] = $true_score;
		pdo_update("sudu8_page_user", $tprice, array("openid" => $openid, "uniacid" => $uniacid));
		$jdata["uniacid"] = $uniacid;
		$jdata["orderid"] = $id;
		$jdata["uid"] = $user["id"];
		$jdata["type"] = "del";
		$jdata["score"] = $my_pay_money;
		$jdata["message"] = "消费";
		$jdata["creattime"] = time();
		pdo_insert("sudu8_page_money", $jdata);
		$kdata["uniacid"] = $uniacid;
		$kdata["orderid"] = $id;
		$kdata["uid"] = $user["id"];
		$kdata["type"] = "del";
		$kdata["score"] = $jf_score;
		$kdata["message"] = "消费";
		$kdata["creattime"] = time();
		pdo_insert("sudu8_page_score", $kdata);
		if ($pro["is_more"] == 1) {
			$duock = 0;
			$more_type_num = unserialize($pro["more_type_num"]);
			$num = unserialize($orders["order_duo"]);
			$numarr = array();
			foreach ($num as $res) {
				array_push($numarr, $res[5]);
			}
			foreach ($more_type_num as $key => &$value) {
				if ($value["shennum"] >= $numarr[$key]) {
					$value["shennum"] = $value["shennum"] - $numarr[$key];
					$value["salenum"] = $value["salenum"] + $numarr[$key];
					$duock = 1;
				} else {
					$duock = 0;
				}
			}
			if ($duock == 1) {
				$pid = $orders["pid"];
				$prodata["more_type_num"] = serialize($more_type_num);
				pdo_update("sudu8_page_products", $prodata, array("id" => $pid, "uniacid" => $uniacid));
				if ($pro["pro_flag_ding"] == 0) {
					$data = array("flag" => 1);
				}
				if ($pro["pro_flag_ding"] == 1) {
					$data = array("flag" => 3);
				}
				$res = pdo_update("sudu8_page_order", $data, array("order_id" => $_GPC["order_id"], "uniacid" => $uniacid));
			} else {
				return $this->result(0, "error", $data);
			}
		}
		if ($pro["pro_kc"] >= 0 && $pro["is_more"] == 0) {
			$now = time();
			if ($orders["overtime"] < $now) {
				if ($orders["reback"] == 0) {
					$ndata["pro_kc"] = $pro["pro_kc"] + $orders["num"];
					pdo_update("sudu8_page_products", $ndata, array("id" => $orders["pid"], "uniacid" => $uniacid));
					$cdata["reback"] = 1;
					pdo_update("sudu8_page_order", $cdata, array("order_id" => $id, "uniacid" => $uniacid));
				}
				$data = array("flag" => -2);
			} else {
				$data = array("flag" => 1);
			}
			$res = pdo_update("sudu8_page_order", $data, array("order_id" => $id, "uniacid" => $uniacid));
		} else {
			if ($pro["pro_kc"] < 0 && $pro["is_more"] == 0) {
				$data = array("flag" => 1);
				$res = pdo_update("sudu8_page_order", $data, array("order_id" => $id, "uniacid" => $uniacid));
			}
		}
		if ($res) {
			return $this->result(0, "success", 1);
		}
	}
	public function doPageDpass()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = $_GPC["order"];
		$data = array("flag" => 1);
		$orders = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$now = time();
		$over = $orders["overtime"];
		$flag = $orders["flag"];
		$num = $orders["num"];
		$pid = $orders["pid"];
		$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $pid, ":uniacid" => $uniacid));
		if ((int) $pro["pro_kc"] >= 0) {
			if ($flag == 0 && $over > $now) {
				$kc = $pro["pro_kc"];
				$ndata["pro_kc"] = $num + $kc;
				pdo_update("sudu8_page_products", $ndata, array("id" => $pid, "uniacid" => $uniacid));
			}
		}
		$res = pdo_delete("sudu8_page_order", array("order_id" => $id, "uniacid" => $uniacid));
		if ($res) {
			return $this->result(0, "success", 1);
		}
	}
	public function doPageMyorder()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$type = $_GPC["type"];
		$where = '';
		if ($type != 9) {
			$where = " and flag = " . $type;
		}
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
		$OrdersList["list"] = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . "WHERE uniacid = :uniacid and openid = :openid " . $where . " ORDER BY creattime DESC,flag  LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $uniacid, ":openid" => $openid));
		foreach ($OrdersList["list"] as &$row) {
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
		}
		$alls = pdo_fetchall("SELECT id FROM " . tablename("sudu8_page_order") . "WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
		$OrdersList["allnum"] = count($alls);
		return $this->result(0, "success", $OrdersList);
	}
	public function doPageweixinpay()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = $_GPC["order_id"];
		$orders = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_order") . " WHERE order_id = :id and uniacid = :uniacid", array(":id" => $id, ":uniacid" => $uniacid));
		$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $orders["pid"], ":uniacid" => $uniacid));
		$more_type_num = unserialize($pro["more_type_num"]);
		$num = unserialize($orders["order_duo"]);
		$openid = $_GPC["openid"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $_GPC["openid"], ":uniacid" => $uniacid));
		$uid = $user["id"];
		$yhqs = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_coupon_user") . " WHERE uniacid = :uniacid and uid = :uid and flag = 0 and etime>0", array(":uniacid" => $_W["uniacid"], ":uid" => $uid));
		$nowtime = time();
		foreach ($yhqs as $key => &$res) {
			if ($nowtime > $res["etime"]) {
				$updatas = array("flag" => 2);
				pdo_update("sudu8_page_coupon_user", $updatas, array("id" => $res["id"], "uniacid" => $uniacid));
			}
		}
		if ($orders["coupon"] != 0) {
			$coupon = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_coupon_user") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $orders["coupon"], ":uniacid" => $uniacid));
			$couponinfo = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_coupon") . " WHERE id = :id and uniacid = :uniacid", array(":id" => $coupon["cid"], ":uniacid" => $uniacid));
			if ($coupon["flag"] == 2) {
				$data = array("message" => "该优惠券已过期！");
				$true_price = $orders["true_price"];
				$yhjg = $couponinfo["price"];
				$newtrueprice = $true_price + $yhjg;
				$dataorder = array("true_price" => $newtrueprice, "coupon" => 0);
				pdo_update("sudu8_page_order", $dataorder, array("order_id" => $id, "uniacid" => $uniacid));
				return $this->result(0, "error", $data);
			}
			if ($coupon["flag"] == 1) {
				$data = array("message" => "该优惠券已经使用过了！");
				$true_price = $orders["true_price"];
				$yhjg = $couponinfo["price"];
				$newtrueprice = $true_price + $yhjg;
				$dataorder = array("true_price" => $newtrueprice, "coupon" => 0);
				pdo_update("sudu8_page_order", $dataorder, array("order_id" => $id, "uniacid" => $uniacid));
				return $this->result(0, "error", $data);
			}
		}
		if ($pro["is_more"] == 1) {
			$numarr = array();
			foreach ($num as $res) {
				array_push($numarr, $res[5]);
			}
			$duock = 0;
			foreach ($more_type_num as $key => &$value) {
				if ($value["shennum"] >= $numarr[$key]) {
					$duock = 1;
				} else {
					$duock = 0;
				}
			}
			if ($duock == 1) {
				$app = pdo_fetch("SELECT * FROM " . tablename("account_wxapp") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
				$paycon = pdo_fetch("SELECT * FROM " . tablename("uni_settings") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
				$datas = unserialize($paycon["payment"]);
				include "WeixinPay.php";
				$appid = $app["key"];
				$openid = $_GPC["openid"];
				$mch_id = $datas["wechat"]["mchid"];
				$key = $datas["wechat"]["signkey"];
				$out_trade_no = $_GPC["order_id"];
				$body = "商品支付";
				$total_fee = $_GPC["price"] * 100;
				$weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
				$return = $weixinpay->pay();
				return $this->result(0, "success", $return);
			} else {
				$data = array("message" => "库存不足！");
				return $this->result(0, "error", $data);
			}
		} else {
			$app = pdo_fetch("SELECT * FROM " . tablename("account_wxapp") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
			$paycon = pdo_fetch("SELECT * FROM " . tablename("uni_settings") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
			$datas = unserialize($paycon["payment"]);
			include "WeixinPay.php";
			$appid = $app["key"];
			$openid = $_GPC["openid"];
			$mch_id = $datas["wechat"]["mchid"];
			$key = $datas["wechat"]["signkey"];
			$out_trade_no = $_GPC["order_id"];
			$body = "商品支付";
			$total_fee = $_GPC["price"] * 100;
			$weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
			$return = $weixinpay->pay();
			return $this->result(0, "success", $return);
		}
	}
	public function doPagePage()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = intval($_GPC["id"]);
		$pageInfo = pdo_fetch("SELECT name,ename,content FROM " . tablename("sudu8_page_cate") . " WHERE uniacid = :uniacid and id = :id ", array(":uniacid" => $uniacid, ":id" => $id));
		return $this->result(0, "success", $pageInfo);
	}
	public function doPagecopycon()
	{
		global $_GPC, $_W;
		$id = intval($_GPC["id"]);
		$copycon = pdo_fetch("SELECT copycon FROM " . tablename("sudu8_page_copyright") . " WHERE id = :id ", array(":id" => $id));
		return $this->result(0, "success", $copycon);
	}
	public function doPagesendMail_order()
	{
		require "inc/class.phpmailer.php";
		require "inc/class.smtp.php";
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$order_id = $_GPC["order_id"];
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM " . tablename("sudu8_page_forms_config") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$mail_sendto = array();
		$mail_sendto = explode(",", $formsConfig["mail_sendto"]);
		$row_mail_user = $formsConfig["mail_user"];
		$row_mail_pass = $formsConfig["mail_password"];
		$row_mail_name = $formsConfig["mail_user_name"];
		$ord = pdo_fetch("SELECT order_id,product,price,num,true_price,pro_user_name,pro_user_tel,pro_user_txt FROM " . tablename("sudu8_page_order") . " WHERE uniacid = :uniacid AND order_id = :oid", array(":uniacid" => $uniacid, ":oid" => $order_id));
		$row_oid = "订单编号：" . $ord["order_id"] . "<br />";
		$row_pro = "产品名称：" . $ord["product"] . "<br />";
		$row_prc = "购买金额：" . $ord["price"] . " x " . $ord["num"] . " = " . $ord["true_price"] . "<br />";
		$row_nam = "联系姓名：" . $ord["pro_user_name"] . "<br />";
		$row_tel = "联系电话：" . $ord["pro_user_tel"] . "<br />";
		$row_txt = "留言备注：" . $ord["pro_user_txt"] . "<br />";
		$mail = new PHPMailer();
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64";
		$mail->SMTPSecure = "ssl";
		$mail->IsSMTP();
		$mail->Port = 465;
		$mail->Host = "smtp.qq.com";
		$mail->SMTPAuth = true;
		$mail->SMTPDebug = false;
		$mail->Username = $row_mail_user;
		$mail->Password = $row_mail_pass;
		$mail->setFrom($row_mail_user, $row_mail_name);
		foreach ($mail_sendto as $v) {
			$mail->AddAddress($v);
		}
		$mail->Subject = "新订单 - " . date("Y-m-d H:i:s", time());
		$mail->isHTML(true);
		$mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_tim . $row_pro . $row_prc . $row_nam . $row_tel . $row_txt . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
		if (!$mail->send()) {
			$result = "send_err";
		} else {
			$result = "send_ok";
		}
		return $this->result(0, "success", $result);
	}
	public function doPagesendMail_foodorder()
	{
		require "inc/class.phpmailer.php";
		require "inc/class.smtp.php";
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$order_id = $_GPC["order_id"];
		$formsConfig = pdo_fetch("SELECT mail_sendto,mail_user,mail_password,mail_user_name FROM " . tablename("sudu8_page_forms_config") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$mail_sendto = array();
		$mail_sendto = explode(",", $formsConfig["mail_sendto"]);
		$row_mail_user = $formsConfig["mail_user"];
		$row_mail_pass = $formsConfig["mail_password"];
		$row_mail_name = $formsConfig["mail_user_name"];
		$ord = pdo_fetch("SELECT order_id,username,usertel,address,userbeiz,usertime,creattime,price,val FROM " . tablename("sudu8_page_food_order") . " WHERE uniacid = :uniacid AND order_id = :oid", array(":uniacid" => $uniacid, ":oid" => $order_id));
		$pro = array();
		$pro = unserialize($ord["val"]);
		foreach ($pro as $v) {
			$row_con = $v["title"] . "x" . $v["num"] . " = " . $v["price"] . "<br/>" . $row_con;
		}
		$row_oid = "订单编号：" . $ord["order_id"] . "<br />";
		$row_pro = "订单内容：<br />" . $row_con . "<br />";
		$row_prc = "支付金额：" . $ord["price"] . "<br />";
		$row_nam = "联系姓名：" . $ord["username"] . "<br />";
		$row_tel = "联系电话：" . $ord["usertel"] . "<br />";
		$row_add = "预定地址：" . $ord["address"] . "<br />";
		$row_time = "预定时间：" . $ord["usertime"] . "<br />";
		$row_txt = "留言备注：" . $ord["userbeiz"] . "<br />";
		$mail = new PHPMailer();
		$mail->CharSet = "utf-8";
		$mail->Encoding = "base64";
		$mail->SMTPSecure = "ssl";
		$mail->IsSMTP();
		$mail->Port = 465;
		$mail->Host = "smtp.qq.com";
		$mail->SMTPAuth = true;
		$mail->SMTPDebug = false;
		$mail->Username = $row_mail_user;
		$mail->Password = $row_mail_pass;
		$mail->setFrom($row_mail_user, $row_mail_name);
		foreach ($mail_sendto as $v) {
			$mail->AddAddress($v);
		}
		$mail->Subject = "新订单 - " . date("Y-m-d H:i:s", time());
		$mail->isHTML(true);
		$mail->Body = "<div style='height:40px;line-height:40px;font-size:16px;font-weight:bold;background:#7030A0;color:#fff;text-indent:10px;'>订单详情：</div><div style='line-height:30px;padding:15px;background:#f6f6f6'>" . $row_oid . $row_pro . $row_prc . $row_nam . $row_tel . $row_add . $row_time . $row_txt . "<div style='line-height:40px;margin-top:10px;text-align:center;color:#888;font-size:12px'>" . $row_mail_name . "</div></div>";
		if (!$mail->send()) {
			$result = "send_err";
		} else {
			$result = "send_ok";
		}
		return $this->result(0, "success", $result);
	}
	public function doPagecoupon()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		if ($openid) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
		}
		$uid = $user["id"];
		$coupon = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_coupon") . " WHERE uniacid = :uniacid and flag = 1 ORDER BY num DESC,id DESC", array(":uniacid" => $uniacid));
		foreach ($coupon as $key => &$res) {
			$isover = 1;
			if ($res["counts"] == 0) {
				$isover = 0;
			} else {
				$isover = 1;
			}
			$res["isover"] = $isover;
			$isover_time = 1;
			$nowtime = time();
			if ($res["btime"] != 0 && $res["etime"] != 0) {
				if ($nowtime >= $res["btime"] && $nowtime <= $res["etime"]) {
					$isover_time = 1;
				} else {
					$isover_time = 0;
				}
			}
			if ($res["btime"] != 0 && $res["etime"] == 0) {
				if ($nowtime >= $res["btime"]) {
					$isover_time = 1;
				} else {
					$isover_time = 0;
				}
			}
			if ($res["btime"] == 0 && $res["etime"] != 0) {
				if ($nowtime <= $res["btime"]) {
					$isover_time = 1;
				} else {
					$isover_time = 0;
				}
			}
			if ($res["btime"] == 0 && $res["etime"] == 0) {
				$isover_time = 1;
			}
			$res["isover_time"] = $isover_time;
			$is_get = 1;
			$yhqbuy = pdo_fetch("SELECT count(*) as n FROM " . tablename("sudu8_page_coupon_user") . " WHERE uniacid = :uniacid and cid = :id and uid = :uid", array(":uniacid" => $_W["uniacid"], ":id" => $res["id"], ":uid" => $uid));
			if ($res["xz_count"] == 0) {
				$coupon[$key]["nowCount"] = "无限";
			} else {
				$coupon[$key]["nowCount"] = intval($res["xz_count"]) - intval($yhqbuy["n"]);
			}
			if ($res["xz_count"] > 0 && $yhqbuy["n"] >= $res["xz_count"]) {
				$is_get = 0;
			}
			$res["is_get"] = $is_get;
			$yhqs = pdo_fetch("SELECT count(*) as n FROM " . tablename("sudu8_page_coupon_user") . " WHERE uniacid = :uniacid and cid = :id", array(":uniacid" => $_W["uniacid"], ":id" => $res["id"]));
			$res["kc"] = $res["counts"];
			if ($res["btime"] != 0) {
				$res["btime"] = date("Y-m-d", $res["btime"]);
			}
			if ($res["etime"] != 0) {
				$res["etime"] = date("Y-m-d", $res["etime"]);
			}
		}
		return $this->result(0, "success", $coupon);
	}
	public function doPagegetcoupon()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$id = $_GPC["id"];
		if ($openid) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
		}
		$uid = $user["id"];
		$coupon = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_coupon") . " WHERE uniacid = :uniacid and id = :id", array(":uniacid" => $uniacid, ":id" => $id));
		$data = array("uniacid" => $uniacid, "uid" => $uid, "cid" => $id, "ltime" => time(), "flag" => 0, "btime" => $coupon["btime"], "etime" => $coupon["etime"]);
		if ($coupon["counts"] > 0 || $coupon["counts"] == -1) {
			$res = pdo_insert("sudu8_page_coupon_user", $data);
			if ($coupon["counts"] == -1) {
				$counts = -1;
			} else {
				$counts = $coupon["counts"] - 1;
			}
			$data2 = array("nownum" => $coupon["nownum"] + 1, "counts" => $counts);
			pdo_update("sudu8_page_coupon", $data2, array("id" => $id, "uniacid" => $uniacid));
			return $this->result(0, "success", 1);
		} else {
			return $this->result(0, "success", 2);
		}
	}
	public function doPagemycoupon()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$flag = $_GPC["flag"];
		$tiaojian = "and flag = 0";
		if ($flag == 0) {
			$tiaojian = "and flag = 0";
		}
		if ($flag == 1) {
			$tiaojian = '';
		}
		if ($openid) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
		}
		$uid = $user["id"];
		$yhqs = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_coupon_user") . " WHERE uniacid = :uniacid and uid = :id  " . $tiaojian . " ORDER BY id DESC", array(":uniacid" => $_W["uniacid"], ":id" => $uid));
		foreach ($yhqs as $key => &$res) {
			$arrs = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_coupon") . " WHERE uniacid = :uniacid and id = :id ", array(":uniacid" => $uniacid, "id" => $res["cid"]));
			if ($arrs["btime"] != 0) {
				$arrs["btime"] = date("Y-m-d", $arrs["btime"]);
			}
			if ($arrs["etime"] != 0) {
				$arrs["etime"] = date("Y-m-d", $arrs["etime"]);
			}
			$res["coupon"] = $arrs;
		}
		return $this->result(0, "success", $yhqs);
	}
	public function doPageCollect()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$cid = $_GPC["id"];
		$openid = $_GPC["openid"];
		$type = $_GPC["types"];
		if ($openid) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
		}
		$uid = $user["id"];
		$collect = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_collect") . " WHERE uniacid = :uniacid and uid = :uid and type = :type and cid = :cid", array(":uniacid" => $uniacid, ":uid" => $uid, ":type" => $type, ":cid" => $cid));
		if ($collect) {
			$res = pdo_delete("sudu8_page_collect", array("uniacid" => $uniacid, "uid" => $uid, "type" => $type, "cid" => $cid));
			if ($res) {
				return $this->result(0, "success", "取消收藏成功");
			}
		} else {
			$data = array("uid" => $uid, "type" => $type, "cid" => $cid, "uniacid" => $uniacid);
			$res = pdo_insert("sudu8_page_collect", $data);
			if ($res) {
				return $this->result(0, "success", "收藏成功");
			}
		}
	}
	public function doPagegetCollect()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
		if ($openid) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
			$uid = $user["id"];
			$collect = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_collect") . " WHERE uniacid = :uniacid and uid = :uid LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $uniacid, ":uid" => $uid));
			$all = pdo_fetch("SELECT count(*) as n FROM " . tablename("sudu8_page_collect") . " WHERE uniacid = :uniacid and uid = :uid ", array(":uniacid" => $uniacid, ":uid" => $uid));
			$num = $all["n"];
			$arr = array();
			foreach ($collect as $key => &$rec) {
				$pro = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_products") . " WHERE id = :id and uniacid = :uniacid and flag = 1", array(":id" => $rec["cid"], ":uniacid" => $uniacid));
				if (!stristr($pro["thumb"], "http")) {
					$pro["thumb"] = HTTPSHOST . $pro["thumb"];
				}
				$arr["list"][] = $pro;
			}
			$arr["num"] = ceil($num / $psize);
			return $this->result(0, "success", $arr);
		}
	}
	public function doPagestoreConf()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$store = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_storeconf") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if ($store == false) {
			$store["flag"] = 0;
		}
		return $this->result(0, "success", $store);
	}
	public function doPageStore()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$radius = 6378.135;
		$store["list"] = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_store") . " WHERE uniacid = :uniacid ORDER BY id DESC", array(":uniacid" => $uniacid));
		$store["num"] = pdo_fetchall("SELECT count(title) as num FROM " . tablename("sudu8_page_store") . " WHERE uniacid = :uniacid ORDER BY id DESC", array(":uniacid" => $uniacid));
		foreach ($store["list"] as $key => &$res) {
			$res["logo"] = HTTPSHOST . $res["logo"];
			$rad = doubleval(M_PI / 180.0);
			$lat1 = doubleval($_GPC["lat"]) * $rad;
			$lon1 = doubleval($_GPC["lon"]) * $rad;
			$lat2 = doubleval($res["lat"]) * $rad;
			$lon2 = doubleval($res["lon"]) * $rad;
			$theta = $lon2 - $lon1;
			$dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
			if ($dist < 0) {
				$dist += M_PI;
			}
			$dist = $dist * $radius;
			$formatted = round($dist, 2);
			$res["kms"] = $formatted;
		}
		$arry = $store["list"];
		$i = 0;
		rdihR:
		if ($i >= count($arry)) {
			$store["list"] = $arry;
			return $this->result(0, "success", $store);
		} else {
			$j = $i + 1;
			rqdU9:
			if ($j >= count($arry)) {
				$i++;
				goto rdihR;
			}
			if ($arry[$i]["kms"] > $arry[$j]["kms"]) {
				$new = $arry[$i];
				$arry[$i] = $arry[$j];
				$arry[$j] = $new;
			}
			$j++;
			goto rqdU9;
		}
	}
	public function doPageStoreNew()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$radius = 6378.135;
		$city = $_GPC["currentCity"];
		$store["list"] = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_store") . " WHERE uniacid = :uniacid and city = :city ORDER BY id DESC", array(":uniacid" => $uniacid, ":city" => $city));
		$store["num"] = pdo_fetchall("SELECT count(title) as num FROM " . tablename("sudu8_page_store") . " WHERE uniacid = :uniacid and city = :city ORDER BY id DESC", array(":uniacid" => $uniacid, ":city" => $city));
		foreach ($store["list"] as $key => &$res) {
			if (!stristr($res["logo"], "http")) {
				$res["logo"] = HTTPSHOST . $res["logo"];
			}
			$rad = doubleval(M_PI / 180.0);
			$lat1 = doubleval($_GPC["lat"]) * $rad;
			$lon1 = doubleval($_GPC["lon"]) * $rad;
			$lat2 = doubleval($res["lat"]) * $rad;
			$lon2 = doubleval($res["lon"]) * $rad;
			$theta = $lon2 - $lon1;
			$dist = acos(sin($lat1) * sin($lat2) + cos($lat1) * cos($lat2) * cos($theta));
			if ($dist < 0) {
				$dist += M_PI;
			}
			$dist = $dist * $radius;
			$formatted = round($dist, 2);
			$res["kms"] = $formatted;
		}
		$arry = $store["list"];
		$i = 0;
		uzKpX:
		if ($i >= count($arry)) {
			$store["list"] = $arry;
			return $this->result(0, "success", $store);
		} else {
			$j = $i + 1;
			U7lCU:
			if ($j >= count($arry)) {
				$i++;
				goto uzKpX;
			}
			if ($arry[$i]["kms"] > $arry[$j]["kms"]) {
				$new = $arry[$i];
				$arry[$i] = $arry[$j];
				$arry[$j] = $new;
			}
			$j++;
			goto U7lCU;
		}
	}
	public function doPageShowstore()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$id = $_GPC["id"];
		$store = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_store") . " WHERE uniacid = :uniacid and id = :id ORDER BY id DESC", array(":uniacid" => $uniacid, ":id" => $id));
		if (!stristr($store["thumb"], "http")) {
			$store["thumb"] = HTTPSHOST . $store["thumb"];
		}
		if (stristr($store["logo"], "http")) {
			$store["logo"] = $store["logo"];
		} else {
			$store["logo"] = HTTPSHOST . $store["logo"];
		}
		$imgs = unserialize($store["text"]);
		$newimgs = array();
		foreach ($imgs as $key => &$res) {
			if (stristr($res, "http")) {
				$newimgs[] = $res;
			} else {
				$newimgs[] = HTTPSHOST . $res;
			}
		}
		$store["text"] = $newimgs;
		return $this->result(0, "success", $store);
	}
	public function doPageProductsearch()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$title = "%" . $_GPC["title"] . "%";
		$flag = 1;
		$product = pdo_fetchall("SELECT id,title,thumb,type,`desc`,ctime,buy_type,price,sale_num,hits,is_more FROM " . tablename("sudu8_page_products") . " WHERE uniacid = :uniacid and flag = :flag and title like :title  ORDER BY id DESC", array(":uniacid" => $uniacid, ":flag" => $flag, ":title" => $title));
		foreach ($product as &$row) {
			if ($row["is_more"] == 1) {
				$row["type"] = "showPro_lv";
			}
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
			$row["ctime"] = date("Y-m-d", $row["ctime"]);
		}
		return $this->result(0, "success", $product);
	}
	public function doPageDingtype()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$types = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_food_cate") . " WHERE uniacid = :uniacid  order by num,id desc", array(":uniacid" => $uniacid));
		return $this->result(0, "success", $types);
	}
	public function doPageDingcai()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$cates = pdo_fetchall("SELECT a.cid,b.title FROM " . tablename("sudu8_page_food") . "as a LEFT JOIN" . tablename("sudu8_page_food_cate") . "as b on a.cid = b.id WHERE a.uniacid = :uniacid GROUP BY a.cid ORDER BY b.num,b.id desc ", array(":uniacid" => $uniacid));
		foreach ($cates as $key => &$rec) {
			$pro = pdo_fetchall("SELECT *,a.id as oid,a.title AS otitle FROM " . tablename("sudu8_page_food") . "as a LEFT JOIN" . tablename("sudu8_page_food_cate") . "as b on a.cid = b.id WHERE a.uniacid = :uniacid and a.cid = :cid ORDER BY b.num,b.id desc", array(":uniacid" => $uniacid, ":cid" => $rec["cid"]));
			$arr = $this->gaichang($pro);
			$rec["val"] = $arr;
		}
		return $this->result(0, "success", $cates);
	}
	function gaichang($pro)
	{
		if ($pro) {
			foreach ($pro as $key => &$res) {
				$res["text"] = unserialize($res["text"]);
				$labels = unserialize($res["labels"]);
				$lab = $this->clabels($labels);
				$res["labels"] = $lab;
				if (!stristr($res["thumb"], "http")) {
					$res["thumb"] = HTTPSHOST . $res["thumb"];
				}
				if ($res["descimg"]) {
					if (!stristr($res["descimg"], "http")) {
						$res["descimg"] = HTTPSHOST . $res["descimg"];
					}
				} else {
					$res["descimg"] = $res["thumb"];
				}
				if (empty($res["desccon"])) {
					$res["desccon"] = $res["otitle"];
				}
			}
		}
		return $pro;
	}
	function clabels($labels)
	{
		if ($labels) {
			$arr = array();
			foreach ($labels as $key => &$res) {
				$kk = explode(":", $res);
				$k1 = $kk[0];
				$k2 = $kk[1];
				if ($k2) {
					$karr = explode("&", $k2);
				}
				$arr[$key]["title"] = $k1;
				$arr[$key]["val"] = $karr;
			}
			return $arr;
		} else {
			return $arr;
		}
	}
	function doPageOrderpaymoney()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$allprice = $_GPC["price"];
		$now = time();
		$order_id = $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
		$app = pdo_fetch("SELECT * FROM " . tablename("account_wxapp") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
		$paycon = pdo_fetch("SELECT * FROM " . tablename("uni_settings") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
		$datas = unserialize($paycon["payment"]);
		include "WeixinPay.php";
		$appid = $app["key"];
		$openid = $_GPC["openid"];
		$mch_id = $datas["wechat"]["mchid"];
		$key = $datas["wechat"]["signkey"];
		$out_trade_no = $order_id;
		$body = "商品支付";
		$total_fee = $_GPC["price"] * 100;
		$weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
		$return = $weixinpay->pay();
		$return["order_id"] = $order_id;
		return $this->result(0, "success", $return);
	}
	function doPageZhifdingd()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$gwc = $_GPC["gwc"];
		$order_id = $_GPC["order_id"];
		$openid = $_GPC["openid"];
		$my_pay_money = $_GPC["money_mypay"];
		$allprice = $_GPC["price"];
		$score = $_GPC["jifen_score"];
		$zh = $_GPC["zh"];
		$gwc = stripslashes(html_entity_decode($gwc));
		$gwc = json_decode($gwc, TRUE);
		$newgwc = serialize($gwc);
		$xinxi = $_GPC["xinxi"];
		$xinxi = stripslashes(html_entity_decode($xinxi));
		$xinxi = json_decode($xinxi, TRUE);
		$data["username"] = $xinxi["username"];
		$data["usertel"] = $xinxi["usertel"];
		$data["address"] = $xinxi["address"];
		$data["usertime"] = $xinxi["userdate"] . " " . $xinxi["usertime"];
		$data["userbeiz"] = $xinxi["userbeiz"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $uniacid));
		$money_u = $user["money"];
		$score_u = $user["score"];
		$kdata["money"] = $money_u - $my_pay_money;
		$kdata["score"] = $score_u - $score;
		$data["order_id"] = $order_id;
		$data["uniacid"] = $uniacid;
		$data["uid"] = $user["id"];
		$data["openid"] = $openid;
		$data["val"] = $newgwc;
		$data["price"] = $allprice;
		$data["creattime"] = time();
		$data["flag"] = 1;
		$data["zh"] = $zh;
		pdo_update("sudu8_page_user", $kdata, array("openid" => $openid, "uniacid" => $uniacid));
		pdo_insert("sudu8_page_food_order", $data);
	}
	function doPageMycai()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$oepnid = $_GPC["openid"];
		$orders = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_food_order") . " WHERE uniacid = :uniacid and openid = :openid ORDER BY `creattime` DESC ", array(":uniacid" => $uniacid, ":openid" => $oepnid));
		foreach ($orders as &$res) {
			$res["creattime"] = date("Y-m-d H:i:s", $res["creattime"]);
			$res["val"] = $this->chuli(unserialize($res["val"]));
		}
		return $this->result(0, "success", $orders);
	}
	function chuli($arr)
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		if ($arr) {
			foreach ($arr as $key => &$res) {
				$products = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_food") . " WHERE uniacid = :uniacid and id = :id", array(":uniacid" => $uniacid, ":id" => $res["id"]));
				if (stristr($products["thumb"], "http")) {
					$res["thumb"] = $products["thumb"];
				} else {
					$res["thumb"] = HTTPSHOST . $products["thumb"];
				}
			}
			return $arr;
		}
	}
	function doPageShangjbs()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$shangjbase = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_food_sj") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if ($shangjbase["thumb"]) {
			$shangjbase["thumb"] = HTTPSHOST . $shangjbase["thumb"];
		}
		if ($shangjbase["tags"]) {
			$shangjbase["tags"] = explode(",", $shangjbase["tags"]);
		}
		$openid = $_GPC["openid"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
		$money = $user["money"];
		$score = $user["score"];
		$jf_gz = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_rechargeconf") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		if (!$jf_gz) {
			$jf_gz["scroe"] = 10000;
			$jf_gz["money"] = 1;
		}
		$jf_money = intval($score / $jf_gz["scroe"]) * $jf_gz["money"];
		$jf_pro = intval($shangjbase["score"] / $jf_gz["scroe"]) * $jf_gz["money"];
		$dikou_jf = 0;
		if ($jf_pro >= $jf_money) {
			$dikou_jf = $jf_money;
		} else {
			$dikou_jf = $jf_pro;
		}
		$jf_score = $dikou_jf / $jf_gz["money"] * $jf_gz["scroe"];
		$shangjbase["user_money"] = $money;
		$shangjbase["dk_money"] = $dikou_jf;
		$shangjbase["dk_score"] = $jf_score;
		$shangjbase["jf_gz"] = $jf_gz;
		return $this->result(0, "success", $shangjbase);
	}
	function doPageFormval()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$cid = $_GPC["id"];
		$pagedata = $_GPC["pagedata"];
		$datas = stripslashes(html_entity_decode($_GPC["datas"]));
		$datas = json_decode($datas, TRUE);
		if ($_GPC["pagedata"] && $_GPC["pagedata"] !== "NULL") {
			$forms = stripslashes(html_entity_decode($_GPC["pagedata"]));
			$forms = json_decode($forms, TRUE);
		}
		$data = array("uniacid" => $uniacid, "cid" => $cid, "creattime" => time(), "val" => serialize($forms), "flag" => 0);
		$res = pdo_insert("sudu8_page_formcon", $data);
		if ($res) {
			return $this->result(0, "success", "提交成功");
		}
	}
	function doPageBalance()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$money = $_GPC["money"];
		$now = time();
		$order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
		$app = pdo_fetch("SELECT * FROM " . tablename("account_wxapp") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$paycon = pdo_fetch("SELECT * FROM " . tablename("uni_settings") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$datas = unserialize($paycon["payment"]);
		include "WeixinPay.php";
		$appid = $app["key"];
		$openid = $openid;
		$mch_id = $datas["wechat"]["mchid"];
		$key = $datas["wechat"]["signkey"];
		$out_trade_no = $order_id;
		$body = "账户充值";
		$total_fee = $money * 100;
		$weixinpay = new WeixinPay($appid, $openid, $mch_id, $key, $out_trade_no, $body, $total_fee);
		$return = $weixinpay->pay();
		$return["order_id"] = $order_id;
		return $this->result(0, "success", $return);
	}
	function doPagePay_cz()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$money = $_GPC["money"];
		$order_id = $_GPC["order_id"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
		$uid = $user["id"];
		$my_money = $user["money"];
		$my_score = $user["score"];
		$new_money = ($my_money * 1000 + $money * 1000) / 1000;
		$new_score = $my_score;
		$guize = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_recharge") . " WHERE uniacid = :uniacid order by money asc", array(":uniacid" => $uniacid));
		if ($guize) {
			$key = count($guize) - 1;
			$i = 0;
			O7AlR:
			if ($i >= count($guize)) {
				if ($money < $guize[0]["money"]) {
					$new_money = $new_money + 0;
					$new_score = $new_score + 0;
				}
				if (!($money >= $guize[$key]["money"])) {
					goto UEehU;
				}
				$new_money = ($new_money * 1000 + $guize[$key]["getmoney"] * 1000) / 1000;
				$new_score = ($new_score * 1000 + $guize[$key]["getscore"] * 1000) / 1000;
				goto UEehU;
			}
			if ($money * 1000 >= $guize[$i]["money"] * 1000 && $money * 1000 < $guize[$i + 1]["money"] * 1000 && $i + 1 <= count($guize)) {
				$new_money = ($new_money * 1000 + $guize[$i]["getmoney"] * 1000) / 1000;
				$new_score = ($new_score * 1000 + $guize[$i]["getscore"] * 1000) / 1000;
			}
			$i++;
			goto O7AlR;
		}
		$new_money = $new_money + 0;
		$new_score = $new_score + 0;
		UEehU:
		$data["money"] = $new_money;
		$data["score"] = $new_score;
		$res = pdo_update("sudu8_page_user", $data, array("openid" => $openid, "uniacid" => $uniacid));
		$jdata["uniacid"] = $uniacid;
		$jdata["orderid"] = $order_id;
		$jdata["uid"] = $uid;
		$jdata["type"] = "add";
		$jdata["score"] = $money;
		$jdata["message"] = "充值";
		$jdata["creattime"] = time();
		pdo_insert("sudu8_page_money", $jdata);
	}
	function doPageMymoney()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$user = pdo_fetch("SELECT money,score,uniacid,openid FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
		return $this->result(0, "success", $user);
	}
	function doPageGuiz()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$guize["list"] = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_recharge") . " WHERE uniacid = :uniacid order by money asc", array(":uniacid" => $uniacid));
		$guize["conf"] = pdo_fetch("SELECT title,uniacid FROM " . tablename("sudu8_page_rechargeconf") . " WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$guize["user"] = pdo_fetch("SELECT money,score,uniacid,openid FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
		return $this->result(0, "success", $guize);
	}
	public function doPageZjkk()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$now = time();
		$order_id = $order = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
		$gwc = $_GPC["gwc"];
		$order_id = $order_id;
		$my_pay_money = $_GPC["money_mypay"];
		$allprice = $_GPC["price"];
		$score = $_GPC["jifen_score"];
		$zh = $_GPC["zh"];
		$gwc = stripslashes(html_entity_decode($gwc));
		$gwc = json_decode($gwc, TRUE);
		$newgwc = serialize($gwc);
		$xinxi = $_GPC["xinxi"];
		$xinxi = stripslashes(html_entity_decode($xinxi));
		$xinxi = json_decode($xinxi, TRUE);
		$data["username"] = $xinxi["username"];
		$data["usertel"] = $xinxi["usertel"];
		$data["address"] = $xinxi["address"];
		$data["usertime"] = $xinxi["userdate"] . " " . $xinxi["usertime"];
		$data["userbeiz"] = $xinxi["userbeiz"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $uniacid));
		$money_u = $user["money"];
		$score_u = $user["score"];
		$kdata["money"] = $money_u - $my_pay_money;
		$kdata["score"] = $score_u - $score;
		$data["order_id"] = $order_id;
		$data["uniacid"] = $uniacid;
		$data["uid"] = $user["id"];
		$data["openid"] = $openid;
		$data["val"] = $newgwc;
		$data["price"] = $allprice;
		$data["creattime"] = time();
		$data["flag"] = 1;
		$data["zh"] = $zh;
		pdo_update("sudu8_page_user", $kdata, array("openid" => $openid, "uniacid" => $uniacid));
		pdo_insert("sudu8_page_food_order", $data);
	}
	public function doPageHxmm()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$hxmm = $_GPC["hxmm"];
		$order_id = $_GPC["order_id"];
		$hxmmarr = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_base") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
		if ($hxmmarr["hxmm"] != $hxmm) {
			return $this->result(0, "success", 0);
		} else {
			$data["custime"] = time();
			$data["flag"] = 2;
			$res = pdo_update("sudu8_page_order", $data, array("order_id" => $order_id));
			return $this->result(0, "success", 1);
		}
	}
	public function doPageHxyhq()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$hxmm = $_GPC["hxmm"];
		$youhqid = $_GPC["youhqid"];
		$hxmmarr = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_base") . " WHERE uniacid = :uniacid", array(":uniacid" => $_W["uniacid"]));
		if ($hxmmarr["hxmm"] != $hxmm) {
			return $this->result(0, "success", 0);
		} else {
			$data["utime"] = time();
			$data["flag"] = 1;
			$res = pdo_update("sudu8_page_coupon_user", $data, array("id" => $youhqid));
			return $this->result(0, "success", 1);
		}
	}
	public function doPageWxupimg()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		load()->func("file");
		$path = file_upload($_FILES["file"]);
		echo json_encode($path);
	}
	public function dopageShoppay_duo()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$ordermoeny = $_GPC["ordermoeny"];
		$yuemoney = $_GPC["yuemoney"];
		$money = $_GPC["money"];
		$order_id = $_GPC["order_id"];
		if (empty($order_id)) {
			$now = time();
			$order_id = date("Y", $now) . date("m", $now) . date("d", $now) . date("H", $now) . date("i", $now) . date("s", $now) . rand(1000, 9999);
		}
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $uniacid));
		$money_u = $user["money"];
		$kdata["money"] = $money_u - $yuemoney;
		pdo_update("sudu8_page_user", $kdata, array("openid" => $openid, "uniacid" => $uniacid));
		$ddata["uniacid"] = $uniacid;
		$ddata["orderid"] = $order_id;
		$ddata["uid"] = $user["id"];
		$ddata["type"] = "del";
		$ddata["score"] = $ordermoeny;
		$ddata["message"] = "消费";
		$ddata["creattime"] = time();
		pdo_insert("sudu8_page_money", $ddata);
	}
	public function dopageShoppay_cz()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$money = $_GPC["money"];
		$order_id = $_GPC["order_id"];
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $uniacid));
		$money_u = $user["money"];
		$kdata["money"] = $money_u + $money;
		pdo_update("sudu8_page_user", $kdata, array("openid" => $openid, "uniacid" => $uniacid));
		$ddata["uniacid"] = $uniacid;
		$ddata["orderid"] = $order_id;
		$ddata["uid"] = $user["id"];
		$ddata["type"] = "add";
		$ddata["score"] = $money;
		$ddata["message"] = "充值";
		$ddata["creattime"] = time();
		pdo_insert("sudu8_page_money", $ddata);
	}
	public function dopageShoppay_jilu()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$types = $_GPC["types"];
		if ($types == 1) {
			$where = '';
		}
		if ($types == 2) {
			$where = " and type = 'del'";
		}
		if ($types == 3) {
			$where = " and type = 'add'";
		}
		$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :id and uniacid = :uniacid", array(":id" => $openid, ":uniacid" => $uniacid));
		$userid = $user["id"];
		$jilu = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_money") . " WHERE uid = :uid and uniacid = :uniacid" . $where . " ORDER BY creattime DESC", array(":uid" => $userid, ":uniacid" => $uniacid));
		if ($jilu) {
			foreach ($jilu as $key => &$res) {
				$res["creattime"] = date("Y-m-d H:i:s", $res["creattime"]);
			}
		}
		return $this->result(0, "success", $jilu);
	}
	public function dopageDzborder()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$type = $_GPC["type"];
		$where = '';
		if ($type != 9) {
			$where = " and flag = " . $type;
		}
		$pindex = max(1, intval($_GPC["page"]));
		$psize = 10;
		$OrdersList["list"] = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_order") . "WHERE uniacid = :uniacid and openid = :openid " . $where . " and flag != -1 and flag != -2 and flag != 0 and flag != 3 ORDER BY creattime DESC,flag  LIMIT " . ($pindex - 1) * $psize . "," . $psize, array(":uniacid" => $uniacid, ":openid" => $openid));
		foreach ($OrdersList["list"] as &$row) {
			if (!stristr($row["thumb"], "http")) {
				$row["thumb"] = HTTPSHOST . $row["thumb"];
			}
		}
		$alls = pdo_fetchall("SELECT id FROM " . tablename("sudu8_page_order") . "WHERE uniacid = :uniacid and openid = :openid", array(":uniacid" => $uniacid, ":openid" => $openid));
		$OrdersList["allnum"] = count($alls);
		return $this->result(0, "success", $OrdersList);
	}
	public function dopageMysign()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$year = $_GPC["year"] ? $_GPC["year"] : date("Y", time());
		$month = $_GPC["month"] ? $_GPC["month"] : date("m", time());
		$days = date("t", strtotime($year . "-" . $month . "-1"));
		$rbeing = $year . "-" . $month . "-1" . " 00:00:00";
		$rend = $year . "-" . $month . "-" . $days . " 23:59:59";
		$begintime = strtotime($rbeing);
		$endtime = strtotime($rend);
		$alls = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_sign") . "WHERE uniacid = :uniacid and openid = :openid and creattime >= :btime and creattime <= :etime", array(":uniacid" => $uniacid, ":openid" => $openid, ":btime" => $begintime, ":etime" => $endtime));
		$choiceday = array();
		foreach ($alls as $key => &$res) {
			$choiceday[] = date("d", $res["creattime"]);
		}
		$dayarr = array();
		$nowarr = array();
		$i = 1;
		Ps8Kk:
		if ($i > $days) {
			return $this->result(0, "success", $dayarr);
		} else {
			$nowarr["day"] = $i;
			if (in_array($i, $choiceday)) {
				$nowarr["choosed"] = true;
			} else {
				$nowarr["choosed"] = false;
			}
			$dayarr[] = $nowarr;
			$i++;
			goto Ps8Kk;
		}
	}
	public function dopageMysignjl()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$alls = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_sign") . "WHERE uniacid = :uniacid and openid = :openid order by creattime desc limit 0,5", array(":uniacid" => $uniacid, ":openid" => $openid));
		foreach ($alls as $key => &$res) {
			$res["creattime"] = date("Y-m-d", $res["creattime"]);
		}
		return $this->result(0, "success", $alls);
	}
	public function dopageQiandao()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$dateriqi = time();
		$guize = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_sign_con") . "WHERE uniacid = :uniacid", array(":uniacid" => $uniacid));
		$sj = explode("/", $guize["score"]);
		$smval = $sj[0];
		$upval = $sj[1];
		$score = rand($smval, $upval);
		$rbeing = $datas . " 00:00:00";
		$rend = $datas . " 23:59:59";
		$begintime = strtotime($rbeing);
		$endtime = strtotime($rend);
		$res = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_sign") . "WHERE uniacid = :uniacid and openid = :openid and creattime >= :btime and creattime <= :etime", array(":uniacid" => $uniacid, ":openid" => $openid, ":btime" => $begintime, ":etime" => $endtime));
		if ($res) {
			return $this->result(0, "success", 1);
		} else {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $openid, ":uniacid" => $uniacid));
			$user_score = $user["score"];
			if ($guize["max_score"] > $user_score) {
				$jiascor = $user_score + $score;
				if ($jiascor >= $guize["max_score"]) {
					$score = $guize["max_score"] - $user_score;
				} else {
					$score = $score;
				}
			} else {
				$score = 0;
			}
			$udata["score"] = $user_score + $score;
			pdo_update("sudu8_page_user", $udata, array("openid" => $openid, "uniacid" => $uniacid));
			$data["uniacid"] = $uniacid;
			$data["openid"] = $openid;
			$data["creattime"] = time();
			$data["score"] = $score;
			pdo_insert("sudu8_page_sign", $data);
			$cleiji = pdo_fetch("SELECT count(*) as n FROM " . tablename("sudu8_page_sign") . "WHERE uniacid = :uniacid and openid = :openid ", array(":uniacid" => $uniacid, ":openid" => $openid));
			$yesterday = date("Y-m-d", strtotime("-1 day"));
			$ybeing = $yesterday . " 00:00:00";
			$yend = $yesterday . " 23:59:59";
			$ybegintime = strtotime($rbeing);
			$yendtime = strtotime($rend);
			$yres = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_sign") . "WHERE uniacid = :uniacid and openid = :openid and creattime >= :btime and creattime <= :etime", array(":uniacid" => $uniacid, ":openid" => $openid, ":btime" => $ybegintime, ":etime" => $yendtime));
			$lxqd = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_sign_lx") . "WHERE uniacid = :uniacid and openid = :openid ", array(":uniacid" => $uniacid, ":openid" => $openid));
			if (!$lxqd) {
				$ldata["uniacid"] = $uniacid;
				$ldata["openid"] = $openid;
				$ldata["count"] = 0;
				$ldata["max_count"] = 0;
				pdo_insert("sudu8_page_sign_lx", $ldata);
			}
			$newlxqd = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_sign_lx") . "WHERE uniacid = :uniacid and openid = :openid ", array(":uniacid" => $uniacid, ":openid" => $openid));
			if ($yres) {
				$newcount = $newlxqd["count"] + 1;
				$maxcount = $newlxqd["max_count"];
				$lx["count"] = $newcount;
				if ($newcount > $maxcount) {
					$lx["max_count"] = $newcount;
				} else {
					$lx["max_count"] = $maxcount;
				}
				$lx["all_count"] = $cleiji["n"];
				pdo_update("sudu8_page_sign_lx", $lx, array("openid" => $openid, "uniacid" => $uniacid));
			} else {
				$lx["count"] = 1;
				$lx["all_count"] = $cleiji["n"];
				pdo_update("sudu8_page_sign_lx", $lx, array("openid" => $openid, "uniacid" => $uniacid));
			}
			return $this->result(0, "success", 0);
		}
	}
	public function dopageMysigntj()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$openid = $_GPC["openid"];
		$lxqd = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_sign_lx") . "WHERE uniacid = :uniacid and openid = :openid ", array(":uniacid" => $uniacid, ":openid" => $openid));
		$arr = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_sign_lx") . "WHERE uniacid = :uniacid order by all_count desc,id desc", array(":uniacid" => $uniacid));
		if ($lxqd) {
			$data["lianq"] = $lxqd["count"];
			$data["maxlianq"] = $lxqd["max_count"];
			$data["all_count"] = $lxqd["all_count"];
			$paix = 0;
			foreach ($arr as $key => &$res) {
				if ($res["openid"] == $lxqd["openid"]) {
					$paix = $key + 1;
					break;
				}
			}
			$data["paix"] = $paix;
		} else {
			$data["lianq"] = 0;
			$data["maxlianq"] = 0;
			$data["all_count"] = 0;
			$data["paix"] = 0;
		}
		return $this->result(0, "success", $data);
	}
	public function dopagePaihb()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$arr = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_sign_lx") . "WHERE uniacid = :uniacid order by all_count desc,id desc limit 0, 5", array(":uniacid" => $uniacid));
		foreach ($arr as $key => &$res) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $res["openid"], ":uniacid" => $uniacid));
			$res["avatar"] = $user["avatar"];
			$res["nickname"] = $user["nickname"];
		}
		return $this->result(0, "success", $arr);
	}
	public function dopageZxqd()
	{
		global $_GPC, $_W;
		$uniacid = $_W["uniacid"];
		$arr = pdo_fetchall("SELECT * FROM " . tablename("sudu8_page_sign") . "WHERE uniacid = :uniacid order by creattime desc", array(":uniacid" => $uniacid));
		foreach ($arr as $key => &$res) {
			$user = pdo_fetch("SELECT * FROM " . tablename("sudu8_page_user") . " WHERE openid = :openid and uniacid = :uniacid", array(":openid" => $res["openid"], ":uniacid" => $uniacid));
			$res["avatar"] = $user["avatar"];
			$res["nickname"] = $user["nickname"];
			$res["creattime"] = date("Y-m-d", $res["creattime"]);
		}
		return $this->result(0, "success", $arr);
	}
}