<?php
/**
 * 接口：后台登录
 * 时间：2022-07-06 10:00
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

if (is_file(ROOT. '/include/360safe/360webscan.php')) {
    require_once ROOT . '/include/360safe/360webscan.php';
}
$user = isset($_POST['user']) ? purge($_POST['user']) : '';
$pwd = isset($_POST['pwd']) ? purge($_POST['pwd']) : '';
$code = isset($_POST['code']) ? purge($_POST['code']) : '';
$pwd = md5($pwd);
if(!$code || $code!=$_SESSION['vs_code']){
    json(201,'验证码错误，请重新输入。');
}
$row = DB::table('admin')->where(['user'=>$user,'pwd'=>$pwd,'type'=>1])->find();
if(!$row){
    json(201,'登录失败，账号或密码错误。');
}
$session = md5($user.'ty_zjsq'.$pwd.time());
$newtime = date('Y-m-d H:i:s',time());
$ip = getIp();
$cookie = authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
DB::table('admin')->where(['id'=>$row['id']])->update(['cookie'=>$session,'logintime'=>$newtime,'ip'=>$ip]);
setcookie("cookie_agent", $cookie, time() + 86400);
json(200,$cookie);
?>