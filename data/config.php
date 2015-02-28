<?php

if(is_file($_SERVER['DOCUMENT_ROOT'].'/360safe/360webscan.php')){
    require_once($_SERVER['DOCUMENT_ROOT'].'/360safe/360webscan.php');
} // ×¢ÒâÎÄ¼þÂ·¾¶

// database host
$db_host   = "localhost:3306";

// database name
$db_name   = "benhu1231";

// database username
$db_user   = "root";

// database password
$db_pass   = "root";

// table prefix
$prefix    = "ecs_";

$timezone    = "Asia/Shanghai";

$cookie_path    = "/";

$cookie_domain    = "";

$session = "1440";

define('EC_CHARSET','utf-8');

define('ADMIN_PATH','admin');

define('AUTH_KEY', 'this is a key');

define('OLD_AUTH_KEY', '');

define('API_TIME', '2015-02-28 13:30:42');

define('DEFAULT_PAYID','4'); //alipay,Á¢¼´Ö§¸¶Ìø×ªºóÄ¬ÈÏµÄÖ§¸¶·½Ê½

define('ADDRESS_NUM',10);
?>