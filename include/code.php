<?php
session_start();
define('ROOT_PATH', dirname(__FILE__));
require 'class/ValidateCode.class.php';
$_vc = new ValidateCode();
$_vc->doimg();
$_SESSION['vs_code'] = $_vc->getCode();
?>