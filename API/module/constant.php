<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();
if($app_res['djzt']==1){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:软件冻结中.');
    out(201,'软件维护中，请耐心等待维护结束。',$app_res);
}
if($clientid == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:客户端ID为空.');
    out(201,'请传入客户端ID。',$app_res);
}
$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}
if($app_res['md5_check']){
    $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
    if(!$res){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序。',$app_res);
    }elseif($res['md5']!=$md5){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:MD5验证失败.');
        out(201,'MD5验证失败，请勿修改程序。',$app_res);
    }
}

$cloud_key = !empty($d['cloudkey']) ? purge($d['cloudkey']) : ''; //获取常量名
if(!$cloud_key){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:常量名为空.');
    out(201,'常量名不可为空。',$app_res);
}
$cloud = DB::table('variable')->where(['appid'=>$appid,'cloud_key'=>$cloud_key])->find();
if(!$cloud){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:不存在此常量.');
    out(201,'获取失败，不存在此常量。',$app_res);
}
if($cloud['islogin']==0){
    $retg['values'] = base64_encode($cloud['cloud_value']);
    $retg['ret_info'] = '获取成功!';
    $new_sl = $cloud['callsl'] + 1;
    DB::table('variable')->where(['id'=>$cloud['id']])->update(['callsl'=>$new_sl]);
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行成功,常量:'.$cloud_key.'.');
    out(200,$retg,$app_res);
}
$tokenid = !empty($d['tokenid']) ? purge($d['tokenid']) : '';
if($tokenid == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:心跳ID为空.');
    out(201,'心跳ID不可为空。',$app_res);
}
$token = DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->find();
if(!$token){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:当前心跳已超时.');
    out(201,'当前登录已过期，请重新登录。',$app_res);
}
$dqsj = time(); //取当前时间戳
$sqsj = strtotime($token['hbtime']); //取上次心跳时间戳
if($dqsj - $sqsj > $app_res['xttime']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:当前心跳已超时.');
    DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
    out(201,'当前登录已过期，请重新登录。',$app_res);
}
$user = DB::table('user')->where(['id'=>$token['uid']])->find();
if(!$user){
    if($user_o){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:封包异常(心跳用户和登录用户不一致).');
        DB::table('heartbeat')->where(['id' => $tokenid, 'clientid' => $clientid])->del();
        out(201, '当前登录已过期，请重新登录。', $app_res);
    }
    DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
    out(201,'当前登录已过期，请重新登录。',$app_res);
}
if($user['user']!=$account){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:封包异常(心跳用户和登录用户不一致).');
    DB::table('heartbeat')->where(['id' => $tokenid, 'clientid' => $clientid])->del();
    out(201, '当前登录已过期，请重新登录。', $app_res);
}
$dqsj = time(); //取当前时间戳
$sqsj = strtotime($user['endtime']);
if($dqsj>=$sqsj && $app_res['orcheck']==1){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:授权已到期.');
    DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
    out(201,'您的账户已到期，请续费后继续使用。',$app_res);
}
if(!$user['point'] && $app_res['orcheck']==2){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:点数不足.');
    DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
    out(201,'您的账户点数不足，请充值后继续使用。',$app_res);
}
if ($user['mac'] != $mac && $app_res['bd_type'] == 1) {
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:设备码错误.');
    out(201, '设备码错误，请换绑后再操作。', $app_res);
}
if ($user['ip'] != $ip && $app_res['bd_type'] == 2) {
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:设备IP错误.');
    out(201, '设备IP错误，请换绑后再操作。', $app_res);
}
if ($user['zt'] != '1') {
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行失败,原因:'.$user['reason'].'.');
    out(201, $user['reason'], $app_res);
}
$retg['values'] = base64_encode($cloud['cloud_value']);
$retg['ret_info'] = '获取成功!';
$new_sl = $cloud['callsl'] + 1;
DB::table('variable')->where(['id'=>$cloud['id']])->update(['callsl'=>$new_sl]);
insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取云常量] > 执行成功,常量:'.$cloud_key.'.');
out(200,$retg,$app_res);
?>