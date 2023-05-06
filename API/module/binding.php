<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $users = !empty($d['user']) ? purge($d['user']) : '';
    $pwd = !empty($d['pwd']) ? md5($d['pwd']) : md5('123456');   
    $newuser = !empty($d['newuser']) ? purge($d['newuser']) : '';
    $newmac = !empty($d['newmac']) ? purge($d['newmac']) : '';
    $newip = !empty($d['newip']) ? purge($d['newip']) : '';
    $newuserqq = !empty($d['newuserqq']) ? purge($d['newuserqq']) : '';

    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();
    if($app_res['djzt']==1){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:软件冻结中.');
        out(201,'软件维护中，请耐心等待维护结束。',$app_res);
    }
    if($clientid == ''){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:客户端ID为空.');
        out(201,'客户端ID不可为空。',$app_res);
    }

    $res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
    if($res['type']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:版本过旧.');
        out(201,'当前版本已停用，请更新到最新版。',$app_res);
    }
    unset($res);

    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }
    
    $user = DB::table('user')->where(['user'=>$users,'pwd'=>$pwd,'appid'=>$appid])->find();
    if(!$user){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:账号或密码错误.');
        out(201,'授权信息验证未通过。',$app_res);
    }

    if($app_res['hb_ks']){
        $dqsj = strtotime($user['endtime']);
        $time = time();
        $ks = $app_res['hb_ks'] * 60;
        if($dqsj - $ks < $time){
            insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:授权时间不足.');
            out(201,'授权到期时间不足'.$app_res['hb_ks'].'分钟，无法换绑。',$app_res);
        }
        $ndate = $dqsj - $ks;
        $upuser['endtime'] = date('Y-m-d H:i:s', $ndate);
    }
    if($app_res['hb_ks1']){
        $dqsj = $user['point'];
        $ks = $app_res['hb_ks1'];
        if($dqsj - $ks < 0){
            insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:点数余额不足.');
            out(201,'点数余额不足'.$app_res['hb_ks'].'点，无法换绑。',$app_res);
        }
        $ndate = $dqsj - $ks;
        $upuser['point'] = $ndate;
    }
    $ghsl = 0;
    $cfsl = 0;
    if($newuser){
        if($app_res['dl_type']==1){
            out(201,'非常抱歉，充值卡号无法修改',$app_res);
        }
        ++$ghsl;
        if($newdata['user'] == $newuser){
            ++$cfsl;
        }else{
            $newdata['user'] = $newuser;
        }
    }
    if($newmac){
        ++$ghsl;
        if($newdata['mac'] == $newmac){
            ++$cfsl;
        }else{
            $newdata['mac'] = $newmac;
        }
    }
    if($newip){
        ++$ghsl;
        if($newdata['ip'] == $newip){
            ++$cfsl;
        }else{
            $newdata['ip'] = $newip;
        }
    }
    if($newuserqq){
        ++$ghsl;
        if($newdata['userqq'] == $newuserqq){
            ++$cfsl;
        }else{
            $newdata['userqq'] = $newuserqq;
        }
    }
    if(count($newdata)<=0){
        insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:新授权信息未填写.');
        out(201,'请填写要修改的授权信息。',$app_res);
    }
    if($ghsl==$cfsl){
        insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:授权信息无变动.');
        json(201,'授权信息无变动，无需修改。');
    }
    if(count($upuser)>0){
        $res = DB::table('user')->where(['id'=>$user['id']])->update($upuser);
        if(!$res){
            insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑失败,原因:扣除时间&点数失败.');
            out(201,'换绑失败，请稍后再试。',$app_res);
        }
    }
    $resx = DB::table('user')->where(['id'=>$user['id']])->update($newdata);
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[换绑信息] > 换绑成功(新数据:'.json_decode($newdata).').');
    out(200,'修改授权信息成功。',$app_res);
?>