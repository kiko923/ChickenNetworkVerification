<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $users = !empty($d['user']) ? purge($d['user']) : '';
    $pwd = !empty($d['pwd']) ? md5($d['pwd']) : md5('123456');   
    $newpwd = !empty($d['newpwd']) ? md5($d['newpwd']) : '';

    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();

    if($clientid == ''){
		insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[更改密码] > 更改失败,原因:客户端ID为空.');
        out(201,'客户端ID不可为空。',$app_res);
    }

    $res = DB::table('ver')->where(['appid'=>$appid,'current_ver'=>$ver])->find();
    if($res['type']){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[添加云黑] > 添加失败,原因:版本过旧.');
        out(201,'当前版本已停用，请更新到最新版。',$app_res);
    }
    
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
			insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[更改密码] > 更改失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
			insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[更改密码] > 更改失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }
    
    $user = DB::table('user')->where(['user'=>$users,'pwd'=>$pwd,'appid'=>$appid])->find();
    if(!$user){
		insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[更改密码] > 更改失败,原因:账号或密码错误.');
        out(201,'授权信息验证未通过。',$app_res);
    }
    
    if($newpwd){
        $newdata['pwd'] = $newpwd;
    }else{
		insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[更改密码] > 更改失败,原因:新密码不可为空.');
        out(201,'新密码不可为空。',$app_res);
    }
    $resx = DB::table('user')->where(['id'=>$user['id']])->update($newdata);
	insert_userlog($user['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[更改密码] > 更改成功.');
    out(200,'修改密码成功。',$app_res);
?>