<?php
/**
 * 接口：删除软件
 * 时间：2022-07-14 16:50
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //软件id
    $res = DB::table('app')->where(['id'=>$id])->del();
    if(!$res){
        json(201,'删除软件失败');
    }
    DB::query('delete from `ty_user` where appid='.$id);
    DB::query('delete from `ty_card` where appid='.$id);
    DB::query('delete from `ty_cardtype` where appid='.$id);
    DB::query('delete from `ty_cardlog` where appid='.$id);
    DB::query('delete from `ty_apilog` where appid='.$id);
    DB::query('delete from `ty_applog` where appid='.$id);
    DB::query('delete from `ty_ver` where appid='.$id);
    DB::query('delete from `ty_variable` where appid='.$id);
    DB::query('delete from `ty_notice` where appid='.$id);
    DB::query('delete from `ty_md5` where appid='.$id);
    DB::query('delete from `ty_heartbeat` where appid='.$id);
    json(200,'删除软件成功');
?>