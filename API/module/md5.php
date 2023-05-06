<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证MD5] > 验证失败,原因:服务端未查询到此版本的MD5.');
            out(201,'服务端未查询到此版本的MD5。',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证MD5] > 验证失败,原因:服务端未查询到此版本的MD5.');
            out(201,'MD5验证失败，请勿修改程序。',$app_res);
        }
    }
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证MD5] > 验证通过.');
    out(200,'MD5验证通过。',$app_res);
?>