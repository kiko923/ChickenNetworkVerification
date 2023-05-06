<?php

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$res = DB::table('core')->select();
foreach($res as $value){
    $newinfo[$value['config_key']] = $value['config_value'];
}
json(200,$newinfo);

?>