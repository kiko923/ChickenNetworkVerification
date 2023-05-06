<?php

define('APP_DEBUG',0);//SQL输出
define('WEB_URL',(($_SERVER['SERVER_PORT']==443) ? 'https':'http').'://'.$_SERVER['SERVER_NAME']);
define('ROOT', str_replace("\\",'/', dirname(dirname(__FILE__)).'/'));
define('SYS_KEY', '9k0c$8sXz#k!');
$myurl = $_SERVER['SERVER_NAME'];
$g_date = date('Y-m-d H:i:s');
$g_date_rq = date('Y-m-d');
?>