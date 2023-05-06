<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$users = !empty($d['user']) ? purge($d['user']) : '';
$pwd = !empty($d['pwd']) ? md5($d['pwd']) : md5('123456');
$tjr = !empty($d['tjr']) ? purge($d['tjr']) : '';

$user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();
if($app_res['djzt']==1){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:软件冻结中.');
    out(201,'软件维护中，请耐心等待维护结束。',$app_res);
}
if($clientid == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:客户端ID为空.');
    out(201,'客户端ID不可为空。',$app_res);
}

$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}
unset($res);

if($app_res['md5_check']){
    $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
    if(!$res){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序',$app_res);
    }elseif($res['md5']!=$md5){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序',$app_res);
    }
}

$user = DB::table('user')->where(['user'=>$users,'pwd'=>$pwd,'appid'=>$appid])->find();
if(!$user){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:账号或密码错误.');
    out(201,'授权信息验证未通过。',$app_res);
}
$tinfo = DB::table('user')->where(['user'=>$tjr,'appid'=>$appid])->find();
if(!$tinfo){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:推荐人不存在.');
    out(201,'推荐人不存在。',$app_res);
}
if(!$app_res['tjup'] && $user['tid']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:已经绑定推荐人,系统限制不可更改.');
    out(201,'你已经绑定了推荐人，不可更改。',$app_res);
}
if($tinfo['id']==$user['tid']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:新绑定推荐人和旧推荐人相同.');
    out(201,'该用户已经是你的推荐人了。',$app_res);
}
$res = DB::table('user')->where(['id'=>$user['id']])->update(['tid'=>$tinfo['id']]);
if(!$res){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[绑定推荐人] > 绑定失败,原因:修改推荐人失败.');
    out(201,'绑定失败，请稍后再试。',$app_res);
}
out(201,'绑定成功。',$app_res);
?>