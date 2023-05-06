<?php
/**
 * 接口：软件列表
 * 时间：2022-07-18 11:30
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('app')->select();
    if(count($row) <= 0){
        die();
    }
    $i = '<option value="">请选择软件</option>';
    foreach ($row as $value){
        $i .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
    }
    die($i);

?>