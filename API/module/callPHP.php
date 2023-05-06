<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '调用云计算1';
$czzt = '调用失败';
require 'profiler.php';

require 'func.php';

$fun = $d['fun'];
$para = $d['para'];
$paras = explode(',', $para);
$ret = call_user_func_array($fun,$paras);
out(200,$ret,$app_res);
?>