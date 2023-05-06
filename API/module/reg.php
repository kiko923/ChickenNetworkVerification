<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$km = !empty($d['card']) ? purge($d['card']) : '';
$user = !empty($d['user']) ? purge($d['user']) : '';
$pwds = !empty($d['pwd']) ? purge($d['pwd']) : '123456';
$user_pwd = !empty($d['pwd']) ? md5($d['pwd']) : md5('123456');
$qq = !empty($d['userqq']) ? purge($d['userqq']) : '';
$email = !empty($d['email']) ? purge($d['email']) : '';
$tjr = !empty($d['tjr']) ? purge($d['tjr']) : '';

if($clientid == ''){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:客户端ID为空.');
    out(201,'客户端ID不可为空。',$app_res);
}

if($app_res['zc_type']==0){
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:服务器关闭.');
    out(201,'服务器已关闭注册，请耐心等待开放。',$app_res);
}

$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}

if(strlen($user)<$app_res['cd_zh'] && $app_res['cd_zh']){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:账号长度过短.');
    out(201,'账号长度过短，请设置最少'.$app_res['cd_zh'].'位数的账号。',$app_res);
}
if(strlen($pwds)<$app_res['cd_mm'] && $app_res['cd_mm']){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:密码长度过短.');
    out(201,'密码长度过短，请设置最少'.$app_res['cd_zh'].'位数的密码。',$app_res);
}

if($app_res['zc_type']==3){
    $res = DB::table('user')->where(['rgmac'=>$mac,'appid'=>$appid])->find();
    if($res){
        insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:设备注册唯一.');
        out(201,'此设备已注册过账号，无法再次注册。',$app_res);
    }
}
if($app_res['zc_type']==4){
    $res = DB::table('user')->where(['rgip'=>$ip,'appid'=>$appid])->find();
    if($res){
        insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:IP注册唯一.');
        out(201,'此IP已注册过账号，无法再次注册。',$app_res);
    }
}

$sfzs = 1;
if($app_res['rgtype']){
    $count = DB::table('user')->where(['rgip'=>$ip,'appid'=>$appid])->count();
    $count1 = DB::table('user')->where(['rgmac'=>$mac,'appid'=>$appid])->count();
    if($app_res['regip']<=$count && $app_res['regmac']<=$count1){
        $sfzs = 0;
    }
}

if($user == ''){
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:未输入账号.');
    out(201,'请输入账号。',$app_res);
}
if($user_pwd == ''){
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:未输入密码.');
    out(201,'请输入密码。',$app_res);
}

if($app_res['zc_type']==2 && $km==''){
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:需要充值卡才可以注册.');
    out(201,'需要充值卡才可注册哦。',$app_res);
}
if($km != ''){
    $res = DB::table('card')->where(['card'=>$km,'appid'=>$appid])->find();
    if(!$res){
        $resx = DB::table('cardlog')->where(['card'=>$km,'appid'=>$appid])->find();
        if($resx){
            insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:此充值卡已被使用.');
            out(201,'此充值卡已被使用。',$app_res);
        }
        insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:充值卡号有误.');
        out(201,'充值卡号有误，请重新输入。',$app_res);
    }
    $addcardlog = ['bz'=>$res['bz'],'appid'=>$res['appid'],'name'=>$res['name'],'card'=>$km,'rgtime'=>$res['rgtime'],'rgpoint'=>$res['rgpoint'],'addtime'=>$g_date,'data'=>$res['data'],'dk'=>$res['dk']];
    if($res['aid']){
        $adddata['aid'] = $res['aid'];
    }
}

$userinfo = DB::table('user')->where(['user'=>$user,'appid'=>$appid])->find();
if($userinfo){
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:账号已被注册.');
    out(201,'此账号已被注册，请换个账号注册。',$app_res);
}
unset($userinfo);

if($tjr){
    $tinfo = DB::table('user')->where(['user'=>$tjr,'appid'=>$appid])->find();
    if(!$tinfo){
        insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:推荐人不存在.');
        out(201,'推荐人不存在!',$app_res);
    }
}

if($app_res['reggive'] && $sfzs){
    $xtime = time() + $app_res['reggive'] * 60;//赠送时间
    $xtime = date('Y-m-d H:i:s', $xtime);//转换为日期时间格式
}else{
    $xtime = $g_date;
}
if($app_res['reggive1'] && $sfzs){
    $xjf = $app_res['reggive1'];
}else{
    $xjf = '0';
}

$adddata = ['appid'=>$appid,'user'=>$user,'endtime'=>$xtime,'point'=>$xjf,'addtime'=>$g_date,'zt'=>'1','pwd'=>$user_pwd];
if($tjr && $tinfo){
    $adddata['tid'] = $tinfo['id'];
}
if($qq != ''){
    $adddata['userqq'] = $qq;
}
if($email != ''){
    $adddata['email'] = $email;
}
if($mac != ''){
    $adddata['mac'] = $mac;
    $adddata['rgmac'] = $mac;
}
if($ip != ''){
    $adddata['ip'] = $ip;
    $adddata['rgip'] = $ip;
}
if($app_res['ctid']){
    $ctd = DB::table('cardtype')->where(['id'=>$app_res['ctid']])->find();
    if($ctd && $ctd['data']!=''){
        $adddata['data'] = $ctd['data'];
    }
}
if(!$km && $app_res['gid']){
    $adddata['gid'] = $app_res['gid'];
}

$addid = DB::table('user')->add($adddata);
if(!$addid){
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:新增用户失败.');
    out(201,'注册失败，请稍后再试。',$app_res);
}

if($km != ''){
    $userinfo = DB::table('user')->where('id',$addid)->find();
    $dqsj = time();
    $sqsj = strtotime($userinfo['endtime']); //取用户时间
    if($sqsj <= $dqsj){
        $sqsj = $dqsj;
    }
    
    $cz_sj = $sqsj + $res['rgtime'] * 60; //充值时间
    $cz_sj = date('Y-m-d H:i:s', $cz_sj); //转换为日期时间格式
    $cz_ds = $userinfo['point'] + $res['rgpoint']; //充值点数
    
    $updata = ['endtime'=>$cz_sj,'point'=>$cz_ds];
    if($res['data']!=''){
        $updata['data'] = $res['data'];
    }
    $updata['dk'] = $res['dk'];
    $updata['type'] = 1;
    if($res['aid']){
        $updata['aid'] = $res['aid'];
    }

    if(!$res['gid']){
        if($app_res['gid']){
            $updata['gid'] = $app_res['gid'];
        }
    }else{
        $updata['gid'] = $res['gid'];
    }

    $ress = DB::table('user')->where('id',$userinfo['id'])->update($updata);
    if(!$ress){
        DB::table('user')->where(['id'=>$userinfo['id']])->del();
        out(201,'注册失败，请稍后再试。',$app_res);
    }
    $addcardlog['uid'] = $addid;
    $row = DB::table('cardlog')->add($addcardlog);
    if(!$row){
        DB::table('user')->where(['id'=>$userinfo['id']])->del();
        insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:新增充值卡充值日志失败.');
        out(201,'注册失败，请稍后再试。',$app_res);
    }
    if($res['second']>1){
        unset($updata);
        $sycs = $res['second'] - 1;
        $updata = ['second'=>$sycs];
        $upcard = DB::table('card')->where(['id'=>$res['id']])->update($updata);
        if(!$upcard){
            DB::table('user')->where(['id'=>$userinfo['id']])->del();
            DB::table('cardlog')->where(['id'=>$row])->del();
            insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:修改充值卡循环充值次数失败.');
            out(201,'注册失败，请稍后再试。',$app_res);
        }
    }else{
        $upcard = DB::table('card')->where(['id'=>$res['id']])->del();
        if(!$upcard){
            DB::table('user')->where(['id'=>$userinfo['id']])->del();
            DB::table('cardlog')->where(['id'=>$row])->del();
            insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册失败,原因:删除使用的充值卡失败.');
            out(201,'注册失败，请稍后再试。',$app_res);
        }
    }
    insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册成功->使用充值卡('.$km.').');
    out(200,'恭喜您注册成功，充值时间：'.$res['rgtime'].'分钟，充值点数：'.$res['rgpoint'].'点。',$app_res);
}
insert_userlog($addid,$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[注册用户] > 注册成功!');
out(200,'恭喜您注册成功。',$app_res);
?>