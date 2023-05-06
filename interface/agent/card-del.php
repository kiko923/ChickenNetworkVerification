<?php
/**
 * 接口：删除充值卡
 * 时间：2022-07-14 16:50
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //充值卡id
$cardinfo = DB::table('card')->where(['id'=>$id,'aid'=>$userinfo['id']])->find();
if(!$cardinfo){
    json(201,'此充值卡不存在');
}
if($cardinfo['scje']){
    $scje = $cardinfo['scje'];
    $newinfo['money']  = $userinfo['money'] + $cardinfo['scje'];
    $newinfo['consume']  = $userinfo['consume'] - $cardinfo['scje'];
    $x = DB::table('admin')->where(['id'=>$userinfo['id']])->update($newinfo);
    if(!$x){
        json(201,'退卡失败，请稍后再试');
    }
}else{
    $scje = '0';
}
$res = DB::table('card')->where(['id'=>$id,'aid'=>$userinfo['id']])->del();
if(!$res){
    json(201,'退卡失败，请稍后再试');
}
if($cardinfo['scje']){
    $glid = moneylog($userinfo['id'],$scje,4,4,$newinfo['money'],'退回充值卡('.$cardinfo['name'].'),返还余额['.$cardinfo['scje'].']元.');
}
if($cardinfo['flje'] && $cardinfo['flid'] && $glid){
    $flje = $cardinfo['flje'];
    $fla = DB::table('admin')->where(['id'=>$cardinfo['flid']])->find();
    if($fla){
        $flamoney = $fla['money'] - $flje;
        DB::table('admin')->where(['id'=>$cardinfo['flid']])->update(['money'=>$flamoney]);
        moneylog($cardinfo['flid'],$flje,5,0,$flamoney,'下级退回充值卡,扣除余额['.$flje.']元.',$glid);
    }
}
json(200,'退卡成功，返还制卡金额'.$scje.'元。');
?>