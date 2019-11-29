<?php

require_once "func.php";
$pay = getconfigbytype("type2", 'wxlm_appointment_config');
define('TEE_SITE_URL', 'https://teegon.com/');
define('TEE_API_URL', 'https://api.teegon.com/');
define('TEE_CLIENT_ID', $pay['teegon_client_id']);
define('TEE_CLIENT_SECRET', $pay['teegon_secret']);
