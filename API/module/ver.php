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
            insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[获取版本] > 获取成功,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序。',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[获取版本] > 获取成功,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序。',$app_res);
        }
    }

    $res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
    if(!$res){
        insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[获取版本] > 获取成功,暂无更新.');
        out(201,'暂无更新.',$app_res);
    }
    
    unset($res['id']);
    unset($res['appid']);
    $res['ret_info'] = '有新版本!';
    if($res['update_text']){
        $res['update_text'] = base64_decode($res['update_text']);
    }
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[获取版本] > 获取成功,检测到新版本.');
    out(200,$res,$app_res);

?>