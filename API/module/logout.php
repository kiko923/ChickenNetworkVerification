<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $tokenid = !empty($d['tokenid']) ? purge($d['tokenid']) : '';
    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();
    
    if($clientid == ''){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注销登录] > 注销失败,原因:客户端ID为空.');
        out(201,'客户端ID不可为空。',$app_res);
    }
    
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注销登录] > 注销失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注销登录] > 注销失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }
    
    $res = DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->find();

    DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
    
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注销登录] > 注销成功,账号已退出登录.');
    out(200,'注销登录成功。',$app_res);
?>