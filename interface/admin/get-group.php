<?php
/**
 * 接口：用户组列表
 * 时间：2022-09-23 15:53
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('group')->select();
if(count($row) <= 0){
    die();
}
$i = '<option value="">请选择用户组</option>';
foreach ($row as $value){
    $i .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}
die($i);

?>