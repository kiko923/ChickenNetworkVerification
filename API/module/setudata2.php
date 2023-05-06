<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$cztype = '存云数据2';
$czzt = '存储失败';

require 'profiler.php';

$udata = !empty($d['udata']) ? purge($d['udata']) : '';

$res = DB::table('user')->where(['id' => $token['uid']])->update(['data3'=>$udata]);
insert_userlog($user_o['id'],$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[存云数据2] > 存储成功.');
out(200, '用户数据存储至云端成功。', $app_res);

?>
