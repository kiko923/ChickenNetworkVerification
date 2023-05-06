<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $users = !empty($d['user']) ? purge($d['user']) : '';
    $pwd = !empty($d['pwd']) ? md5($d['pwd']) : md5('123456');
    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();

    if($app_res['djzt']==1){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:软件冻结中.');
        out(201,'软件维护中，请耐心等待维护结束。',$app_res);
    }

    $res = DB::table('black')->where(['appid'=>$appid,'type'=>0,'data'=>$users])->find();
    if($res){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:账号被拉黑.');
        out(201,'该账号已被拉黑，如有疑问请联系客服咨询。',$app_res);
    }

    if($clientid == ''){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:客户端ID为空.');
        out(201,'客户端ID不可为空。',$app_res);
    }
    
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }

    $nver = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
    if($nver['type']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:版本过旧.');
        out(201,'当前版本已停用，请更新到最新版。',$app_res);
    }
    
	if($app_res['dl_type']==0){
		$user = DB::table('user')->where(['user'=>$users,'pwd'=>$pwd,'appid'=>$appid])->find();
	}else{
		$user = DB::table('user')->where(['user'=>$users,'appid'=>$appid])->find();
	}

    if(!$user && $app_res['dl_type']==1){ //充值卡登录模式
        $res = DB::table('card')->where(['card'=>$users,'appid'=>$appid])->find();
        if($res){
            $dqsj = time(); //取当前时间戳
            $cz_sj = $dqsj + $res['rgtime'] * 60; //充值时间
            $cz_sj = date('Y-m-d H:i:s', $cz_sj); //转换为日期时间格式
            $cz_ds = $res['rgpoint']; //充值点数
            $add = ['endtime'=>$cz_sj,'iscode'=>1,'type'=>1,'point'=>$cz_ds,'ver'=>$ver,'ip'=>$ip,'mac'=>$mac,'rgip'=>$ip,'rgmac'=>$mac,'addtime'=>$g_date,'appid'=>$appid,'user'=>$users,'dk'=>$res['dk'],'data'=>$res['data']];
            if($res['aid']){
                $add['aid'] = $res['aid'];
            }
            if(!$res['gid']){
                if($app_res['gid']){
                    $add['gid'] = $app_res['gid'];
                }
            }else{
                $add['gid'] = $res['gid'];
            }
            $is = DB::table('user')->add($add);
            if($is){
                $adddata = ['bz'=>$res['bz'],'appid'=>$res['appid'],'name'=>$res['name'],'uid'=>$is,'card'=>$users,'rgtime'=>$res['rgtime'],'rgpoint'=>$res['rgpoint'],'addtime'=>$g_date,'data'=>$res['data'],'dk'=>$res['dk'],'gid'=>$res['gid']];
                if($res['aid']){
                    $adddata['aid'] = $res['aid'];
                }
                DB::table('cardlog')->add($adddata);
                DB::table('card')->where(['id'=>$res['id']])->del();
                $user = DB::table('user')->where(['user'=>$users,'appid'=>$appid])->find();
            }
        }
    }
    if(!$user){
        $res = DB::table('user')->where(['user'=>$users,'appid'=>$appid])->find();
        insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:密码错误.');
        out(201,'登录失败，账号或密码错误。',$app_res);
    }
    if($user['zt']!='1'){
        insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录失败,原因:被封禁,'.$user['reason'].'.');
        out(201,$user['reason'],$app_res);
    }

    //在线列表检测
    $res_new = DB::table('heartbeat')->where(['uid'=>$user['id'],'appid'=>$app_res['id']])->select();
    foreach ($res_new as $value){
        $row_new = DB::table('app')->where(['id'=>$value['appid']])->find();
        if(!$row_new){
            DB::table('heartbeat')->where(['id'=>$value['id']])->del();
        }else{
            $xt_time = $row_new['xttime'];
            $dqsj = time(); //取当前时间戳
            $xtsj = strtotime($value['hbtime']);
            if($dqsj - $xtsj > $xt_time){
                DB::table('heartbeat')->where(['id'=>$value['id']])->del();
            }
        }
        unset($row_new);
    }
    
    //开始登录
    $dqsj = time(); //取当前时间戳
    $sqsj = strtotime($user['endtime']);
    if($dqsj>=$sqsj && $app_res['orcheck']==1){
        insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:授权已到期.');
        out(201,'已到期，请续费后再登录。',$app_res);
    }
    if(!$user['point'] && $app_res['orcheck']==2){
        insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:点数不足.');
        out(201,'点数不足，请充值后再登录。',$app_res);
    }
    if(!$user['point'] && $app_res['orcheck']==4){
        insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:点数不足.');
        out(201,'点数不足，请充值后再登录。',$app_res);
    }
    if($user['mac']){
        if($user['mac'] != $mac && $app_res['bd_type'] == 1){
            insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:设备码错误.');
            out(201,'设备码错误，请换绑后再登录。',$app_res);
        }
        if($user['mac'] != $mac){
            $upuser['mac'] = $mac;
        }
    }else{
        $upuser['mac'] = $mac;
    }
    if($user['ip']){
        if($user['ip'] != $ip && $app_res['bd_type'] == 2){
            insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:设备IP错误.');
            out(201,'设备IP错误，请换绑后再登录。',$app_res);
        }
        if($user['ip'] != $ip){
            $upuser['ip'] = $ip;
        }
    }else{
        $upuser['ip'] = $ip;
    }
    if(!$user['rgip']){
        $upuser['rgip'] = $ip;
    }
    if(!$user['rgmac']){
        $upuser['rgmac'] = $mac;
    }
    
    $rel = DB::table('heartbeat')->where(['appid'=>$appid,'uid'=>$user['id']])->count();
    if($rel > 0){
        if($rel >= $user['dk']){
            if($app_res['dl_type2']==1){
                $rxx = DB::table('heartbeat')->where(['appid'=>$appid,'uid'=>$user['id']])->order('logintime')->find();
                DB::table('heartbeat')->where(['id'=>$rxx['id']])->del();
            }else{
                insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:当前授权在线数量已达上限.');
                out(201,'登录失败，当前会员在线数量已达上限，如已离线请耐心等待'.$app_res['xt_time'].'秒后再登录。',$app_res);
            }
        }
    }
    $add = ['appid'=>$appid,'uid'=>$user['id'],'logintime'=>$g_date,'hbtime'=>$g_date,'ip'=>$ip,'mac'=>$mac,'clientid'=>$clientid,'ver'=>$ver];
    $tokenid = DB::table('heartbeat')->add($add);
    if(!$tokenid){
        insert_userlog($user['id'], $appid,$alid, $g_date, $ver, $mac, $ip, $clientid, '[用户登录] > 登录失败,原因:未知错误.');
        out(201,'登录失败，未知错误。',$app_res);
    }
    $retginfo['tokenid'] = $tokenid;
    $retginfo['clientid'] = $clientid;

    $upuser['logintime'] = $g_date;
    $upuser['ver'] = $ver;
    DB::table('user')->where(['id'=>$user['id']])->update($upuser);
    $user = DB::table('user')->where(['user'=>$users,'appid'=>$appid])->find();
    $retginfo['user'] = $user['user'];
    $retginfo['endtime'] = $user['endtime'];
    $retginfo['point'] = $user['point'];
    $retginfo['mac'] = $user['mac'];
    $retginfo['ip'] = $user['ip'];
    $retginfo['dk'] = $user['dk'];
    $retginfo['email'] = $user['email'];
    $retginfo['userqq'] = $user['userqq'];
    $retginfo['ver'] = $user['ver'];
    $retginfo['addtime'] = $user['addtime'];
    $retginfo['logintime'] = $user['logintime'];
    $retginfo['data'] = base64_encode($user['data']);
    if($user['gid']){
        $usergroup = DB::table('usergroup')->where(['id'=>$user['gid']])->find();
        if($usergroup){
            $retginfo['group'] = $usergroup['name'];
            $retginfo['groupdata'] = base64_encode($usergroup['data']);
        }
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
    $retginfo['ret_info'] = '登录成功!';
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户登录] > 登录成功!');

    out(200,$retginfo,$app_res);
?>