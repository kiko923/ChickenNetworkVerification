<?php
/**
 * 接口：卡类信息
 * 时间：2022-09-22 16:49
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //卡类id
if(!$id){ //如果软件id是空
    die();
}
$res = DB::table('cardtype')->where(['id'=>$id,'type'=>1])->find();
if(!$res){
    die();
}
if($userinfo['appsid']){
    $data = explode(',', $userinfo['appsid']);
    if(!in_array($res['appid'],$data,true)){
        die();
    }
}else{
    die();
}
$i = '<span style="color:seagreen">制卡金额：'.$res['money'].'元</span>';
$i = $i.'<br><span style="color:blue">多开数量：'.$res['dk'].'台</span>';
$i = $i.'<br><span style="color:salmon">循环充值：'.$res['second'].'次</span>';
$i = $i.'<br>充值点数：'.$res['rgpoint'].'点';
$i = $i.'<br>充值时间：'.$res['rgtime'].'分钟（'.number_format($res['rgtime'] / 1440,2).'天）';

die($i);

?>