<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $users = isset($d['user']) ? purge($d['user']) : '';
    $pwd = isset($d['pwd']) ? md5($d['pwd']) : md5('123456');
    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();

    if($app_res['djzt']==1){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证失败,原因:软件冻结中.');
        out(201,'软件维护中，请耐心等待维护结束。',$app_res);
    }

    if($clientid == ''){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证失败,原因:客户端ID为空.');
        out(201,'客户端ID不可为空。',$app_res);
    }
    $res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
    if($res['type']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证失败,原因:版本过旧.');
        out(201,'当前版本已停用，请更新到最新版。',$app_res);
    }
    unset($res);
    
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }
    
	if($app_res['dl_type']==0){
		$user = DB::table('user')->where(['user'=>$users,'pwd'=>$pwd,'appid'=>$appid])->find();
	}else{
		$user = DB::table('user')->where(['user'=>$users,'appid'=>$appid])->find();
	}

    if(!$user){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证失败,原因:账号或密码错误.');
        out(201,'账号或密码错误，请重新输入',$app_res);
    }
    if(!$user['zt']){
        out(201,$user['reason'],$app_res);
    }
    unset($user['id']);
    unset($user['pwd']);
    unset($user['appid']);
    unset($user['aid']);
    unset($user['oid']);
    unset($user['addtime']);
    $user['ret_info'] = '验证通过!';
    insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证授权(快捷)] > 验证成功,成功返回授权数据.');
    out(200,$user,$app_res);

?>