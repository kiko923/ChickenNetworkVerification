<?php
/**
 * 接口：基础信息JSON
 * 时间：2022-07-15 08:52
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$newinfo = array();
    $newinfo['code'] = 200;
    $newinfo['loginip'] = getIp();
    $newinfo['card'] = DB::table('card')->count();              //卡密数量
    $newinfo['cardlog'] = DB::table('cardlog')->count();        //充值数量
    $newinfo['agent'] = DB::table('admin')->where(['type'=>1])->count();            //代理数量
    $newinfo['app'] = DB::table('app')->count();                //软件数量
    $newinfo['user'] = DB::table('user')->count();              //用户数量
    $newinfo['heartbeat'] = DB::table('heartbeat')->count();    //在线数量
    $newinfo['ver'] = $version['ver'];
    $newinfo['cuid'] = $G['config']['sysmac'];
    $newinfo['loginuser'] = $userinfo['user'];
    $newinfo['logintime'] = $userinfo['logintime'];
    $newinfo['datetime'] = date('Y-m-d H:i:s').'(如果时间不对请调整)';
    $newinfo['dategs'] = 'Y-m-d H:i:s';

    die(json_encode($newinfo));
?>