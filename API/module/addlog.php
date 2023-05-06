<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$infos = !empty($d['infos']) ? purge($d['infos']) : '';

$user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();
if($app_res['djzt']==1){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[日志记录] > 记录失败,原因:软件冻结中.');
    out(201,'软件维护中，请耐心等待维护结束。',$app_res);
}
if($clientid == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[日志记录] > 记录失败,原因:客户端ID为空.');
    out(201,'客户端ID不可为空。',$app_res);
}

$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[日志记录] > 记录失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}
unset($res);

if($app_res['md5_check']){
$res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
    if(!$res){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[日志记录] > 记录失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序',$app_res);
    }elseif($res['md5']!=$md5){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[日志记录] > 记录失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序',$app_res);
    }
}
insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[日志记录] > '.$infos);
out(200,'记录成功。',$app_res);
?>