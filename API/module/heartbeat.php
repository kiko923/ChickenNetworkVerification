<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();

    if($clientid == ''){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:心跳ID为空.');
        out(201,'心跳失败，客户端ID不可为空。',$app_res);
    }

    $res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
    if($res['type']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:版本过旧.');
        out(201,'当前版本已停用，请更新到最新版。',$app_res);
    }
    
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }
    
    $tokenid = !empty($d['tokenid']) ? purge($d['tokenid']) : '';
    $token = DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->find();
    if(!$token){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:心跳ID不存在.');
        out(201,'本次登录已过期，请重新登录。(token不存在)',$app_res);
    }

    if($app_res['djzt']==1){
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:软件冻结中.');
        out(201,'软件维护中，请耐心等待维护结束。',$app_res);
    }
    
    $dqsj = time(); //取当前时间戳
    $sqsj = strtotime($token['hbtime']); //取上次心跳时间戳
    
    if($dqsj - $sqsj > $app_res['xttime']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:心跳已超时.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'本次登录已过期，请重新登录。(心跳已超时)',$app_res);
    }

    $user = DB::table('user')->where(['id'=>$token['uid']])->find();

    if(!$user){
        if($user_o){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:封包异常(心跳用户和登录用户不一致).');
            DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
            out(201, '当前登录已过期，请重新登录。', $app_res);
        }
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'本次登录已过期，请重新登录。(授权信息不存在)',$app_res);
    }

    if($user['zt'] != '1'){
        insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:被封禁,'.$user['reason'].'.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,$user['reason'],$app_res);
    }

    $dqsj = time(); //取当前时间戳
    $sqsj = strtotime($user['endtime']);
    if($dqsj>=$sqsj && $app_res['orcheck']==1){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:授权已到期.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'您的账户已到期，请续费后继续使用。',$app_res);
    }
    if(!$user['point'] && $app_res['orcheck']==2){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:点数不足.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'点数不足，请充值后继续使用。',$app_res);
    }
    if($user['mac'] != $mac && $app_res['bd_type'] == 1){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:设备码错误.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'设备码错误，请换绑后再登录。',$app_res);
    }
    if($user['ip'] != $ip && $app_res['bd_type'] == 2){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:设备IP错误.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'IP地址错误，请换绑后再登录。',$app_res);
    }
    
    $newdate = date('Y-m-d H:i:s', time()+1);
    $res = DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->update(['hbtime'=>$newdate]);
    if(!$res){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳失败,原因:心跳更新失败.');
        DB::table('heartbeat')->where(['id'=>$tokenid,'clientid'=>$clientid])->del();
        out(201,'本次登录已过期，请重新登录。',$app_res);
    }
    if($app_res['orcheck']==4){
        $mqsj = date('Y-m-d');
        $kd = DB::table('kdlog')->where(['uid'=>$user['id'],'appid'=>$appid,'mac'=>$mac,'ip'=>$ip,'clientid'=>$clientid,'kdsj'=>$mqsj])->find();
        if(!$kd){
            $kdlog['appid'] = $appid;
            $kdlog['ver'] = $ver;
            $kdlog['uid'] = $user['id'];
            $kdlog['mac'] = $mac;
            $kdlog['ip'] = $ip;
            $kdlog['clientid'] = $clientid;
            $kdlog['kdsj'] = $mqsj;
            $kdlog['addtime'] = date('Y-m-d H:i:s');
            DB::table('kdlog')->add($kdlog);
            $newp = $user['point'] - 1;
            DB::table('user')->where(['id'=>$user['id']])->update(['point'=>$newp]);
        }
    }
    $resx['user'] = $user['user'];
    $resx['endtime'] = $user['endtime'];
    $resx['point'] = $user['point'];
    $resx['ret_info'] = '心跳成功!';
    if($app_res['jl_xt']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户心跳] > 心跳成功.');
    }
    out(200,$resx,$app_res);
?>