<?php
/**
 * 接口：删除充值卡类
 * 时间：2022-07-15 00:06
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //充值卡类id
    $res = DB::table('cardtype')->where(['id'=>$id])->del();
    if(!$res){
        json(201,'删除充值卡类失败。');
    }
    json(200,'删除充值卡类成功。');
?>