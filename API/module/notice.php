<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
    $user_o = DB::table('user')->where(['user'=>$account,'appid'=>$appid])->find();
    if($clientid == ''){
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取失败,原因:客户端ID为空.');
        out(201,'客户端ID不可为空。',$appinfo);
    }
    if($app_res['md5_check']){
        $res = DB::table('md5')->where(['appid'=>$appid,'ver'=>$ver])->find();
        if(!$res){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }elseif($res['md5']!=$md5){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取失败,原因:MD5验证失败.');
            out(201,'MD5验证失败，请勿修改程序',$app_res);
        }
    }

    $title = !empty($d['title']) ? purge($d['title']) : ''; //获取公告标题
    if($title){
        $notice = DB::table('notice')->where(['appid'=>$appid,'notice_title'=>$title])->find();
        if(!$notice){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取失败,原因:不存在此公告.');
            out(201,'不存在此标题公告。',$app_res);
        }
        $newinfo['id'] = $notice['id'];
        $newinfo['title'] = $notice['notice_title'];
        $newinfo['info'] = $notice['notice_info'];
        $newinfo['time'] = $notice['addtime'];
        $retg['data_list'][] = $newinfo;
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取成功.');
        out(200,$retg,$app_res);
    }else{
        $row = DB::table('notice')->where(['appid'=>$appid])->select();
        if(!$row){
            insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取失败,原因:暂无公告.');
            out(201,'暂无公告',$app_res);
        }
        foreach ($row as $value){
            $newinfo = array();
            $newinfo['id'] = $value['id'];
            $newinfo['title'] = $value['notice_title'];
            $newinfo['info'] = $value['notice_info'];
            $newinfo['time'] = $value['addtime'];
            $retg['data_list'][] = $newinfo;
        }
        $retg['ret_info'] = '获取成功!';
        insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[取公告信息] > 获取成功.');
        out(200,$retg,$app_res);
    }
?>