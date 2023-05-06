<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$km = !empty($d['card']) ? purge($d['card']) : '';
$user = !empty($d['user']) ? purge($d['user']) : '';

if($user == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:请输入账号.');
    out(201,'请输入账号。',$app_res);
}

$user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();

if($clientid == ''){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:客户端ID为空.');
    out(201,'客户端ID不可为空。',$app_res);
}

$res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
if($res['type']){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:版本过旧.');
    out(201,'当前版本已停用，请更新到最新版。',$app_res);
}

$res = DB::table('card')->where(['card'=>$km,'appid'=>$appid])->find();
if(!$res){
    $resx = DB::table('cardlog')->where(['card'=>$km,'appid'=>$appid])->find();
    if($resx){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:充值卡已被使用.');
        out(201,'此充值卡已被使用。',$app_res);
    }
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:充值卡号错误.');
    out(201,'充值卡号错误，请重新输入。',$app_res);
}
$user = DB::table('user')->where(['user'=>$user,'appid'=>$appid])->find();
if(!$user){
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:授权信息错误.');
    out(201,'验证失败，授权信息错误。',$app_res);
}
if($user['zt']!='1'){
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:被封禁,'.$user['reason'].'.');
    out(201,$user['reason'],$app_res);
}
if($user['gid']!=$res['gid'] && !$app_res['check_hc']){
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:充值卡不可混充.');
    out(201,'你所属的会员组和充值卡限制充值会员组不同，无法混充。',$app_res);
}
$resl = DB::table('cardlog')->where(['card'=>$km,'uid'=>$user['id'],'appid'=>$appid])->find();
if($resl){
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:已使用过此充值卡.');
    out(201,'您已使用过此充值卡。',$app_res);
}

$adddata = ['bz'=>$res['bz'],'appid'=>$res['appid'],'name'=>$res['name'],'uid'=>$user['id'],'card'=>$km,'rgtime'=>$res['rgtime'],'rgpoint'=>$res['rgpoint'],'addtime'=>$g_date,'data'=>$res['data'],'dk'=>$res['dk'],'gid'=>$res['gid']];
if($res['aid']){
    $adddata['aid'] = $res['aid'];
}
$row = DB::table('cardlog')->add($adddata);
if(!$row){
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:充值记录插入失败.');
    out(201,'充值失败，请重试。',$app_res);
}

unset($adddata);

$dqsj = time(); //取当前时间戳
$sqsj = strtotime($user['endtime']); //取用户时间
if($sqsj <= $dqsj){
    $sqsj = $dqsj;
}
$cz_sj = $sqsj + $res['rgtime'] * 60; //充值时间
$cz_sj = date('Y-m-d H:i:s', $cz_sj); //转换为日期时间格式
$cz_ds = $user['point'] + $res['rgpoint']; //充值点数

$updata = ['endtime'=>$cz_sj,'point'=>$cz_ds]; 
if($res['data']!=''){
    $updata['data'] = $res['data'];
}
if($res['aid'] && $user['aid'] != $res['aid']){
    $updata['aid'] = $res['aid'];
}
if($user['gid']!=$res['gid'] && $app_res['check_hc']){
    $updata['gid'] = $res['gid'];
}
$updata['dk'] = $res['dk'];
$updata['type'] = 1;
$ress = DB::table('user')->where(['id'=>$user['id']])->update($updata);
if(!$ress){
    DB::table('cardlog')->where(['id'=>$row])->del();
    insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值失败,原因:修改用户表失败.');
    out(201,'充值失败，请稍后重试。',$app_res);
}
if($res['second']>1){
    unset($updata);
    $sycs = $res['second'] - 1;
    $updata = ['second'=>$sycs];
    DB::table('card')->where(['id'=>$res['id']])->update($updata);
}else{
    DB::table('card')->where(['id'=>$res['id']])->del();
}
if($app_res['tjtype']){
    if($user['tid']){
        $tinfo = DB::table('user')->where(['id'=>$user['tid'],'appid'=>$appid])->find();
        if($app_res['tj_bl1']){
            $dqsj = time();
            $sqsj = strtotime($tinfo['endtime']);
            if($sqsj <= $dqsj){
                $sqsj = $dqsj;
            }
            $newtjr['endtime'] = $sqsj + $res['rgtime'] * 60 * ($app_res['tj_bl1'] / 100);
            $newtjr['endtime'] = date('Y-m-d H:i:s', $newtjr['endtime']);
        }
        if($app_res['tj_bl2']){
            $newtjr['point'] = $tinfo['point'] + $res['rgpoint'] * ($app_res['tj_bl2'] / 100);
        }
        DB::table('user')->where(['id'=>$tinfo['id']])->update($newtjr);
    }
}

insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[用户充值] > 充值成功.');
out(200,'充值成功，充值时间：'.$res['rgtime'].'分钟，充值点数：'.$res['rgpoint'].'点。',$app_res);

?>