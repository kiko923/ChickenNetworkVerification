<?php
/**
 * 接口：删除公告
 * 时间：2022-07-19 10:50
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //公告id
    $res = DB::table('notice')->where(['id'=>$id])->del();
    if(!$res){
        json(201,'删除公告失败');
    }
    json(200,'删除公告成功');
?>