<?php
/**
 * 接口：卡类列表
 * 时间：2022-09-22 15:51
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('cardtype')->select();
if(count($row) <= 0){
    die();
}
$i = '<option value="">请选择卡类</option>';
foreach ($row as $value){
    $i .= '<option value="'.$value['id'].'">'.$value['name'].'（单价:'.$value['money'].'元）</option>';
}
die($i);

?>