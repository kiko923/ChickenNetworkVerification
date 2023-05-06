<?php
/**
 * 接口：添加/设置充值卡
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$data = $_POST;
if(!$data['appid']){
    json(201,'请选择充值卡所属软件');
}
if(!$data['cardtype']){
    json(201,'请选择充值卡类型');
}
if($userinfo['appsid']){
    $appsid = explode(',', $userinfo['appsid']);
    if(!in_array($data['appid'],$appsid,true)){
        json(201,'不存在此软件');
    }
}else{
    json(201,'不存在此软件');
}
$res = DB::table('cardtype')->where(['id'=>$data['cardtype'],'type'=>1,'appid'=>$data['appid']])->find();
if(!$res){
    json(201,'不存在此充值卡类');
}

$data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
$addsl = $data['sl'];
if($addsl <= 0){
    $addsl = 1;
}
if($userinfo['gid']){
    $group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
}
$zkdj = $res['money'] - $res['money'] * $group['level'] / 100; //制卡单价
$kcye = ($res['money'] - $res['money'] * $group['level'] / 100) * $addsl; //制卡总价
if($userinfo['money'] < $kcye){
    json(201,'当前账户余额少于'.$kcye.'元，无法生成'.$addsl.'张['.$res['name'].']');
}
$zkfl = $zkdj * $group['rebate'] / 100; //制卡单张返利
$flje = $zkdj * $group['rebate'] / 100 * $addsl; //制卡总返利

$newinfo['money'] = $userinfo['money'] - $kcye;
$newinfo['consume'] = $userinfo['consume'] + $kcye;

$res['bz'] = $data['bz'];//移交备注信息
unset($data);
$data = $res;
$kt = $res['kt'];
$ck = $res['length'];
unset($data['id']);
unset($data['kt']);
unset($data['length']);
unset($data['money']);
unset($data['type']);
$carkey = '';
$data['aid'] = $userinfo['id'];
$data['scje'] = $zkdj;
if($flje>0 && $userinfo['aid']){
    $data['flje'] = $zkfl;
    $data['flid'] = $userinfo['aid'];
}
for($i=1; $i<=$addsl; $i++) {
    $data['card'] = $kt.get_str($ck,3,0);
    $data['addtime'] = date('Y-m-d H:i:s',time());
    $res = DB::table('card')->add($data);
    if($res){
        if(!$carkey){
            $carkey = $data['card'];
        }else{
            $carkey = $carkey.'<br>'.$data['card'];
        }
    }
}
$ret_arr['code'] = 200;
$ret_arr['msg'] = $carkey;
$ret_arr['info'] = '生成'.$addsl.'张['.$data['name'].']成功，扣除账户余额'.$kcye.'元。';
DB::table('admin')->where(['id'=>$userinfo['id']])->update($newinfo);
$glid = moneylog($userinfo['id'],$kcye,1,0,$newinfo['money'],'制作卡密('.$data['name'].')'.$addsl.'张,扣除余额['.$kcye.']元.');
if($userinfo['aid'] && $flje>0){
    $ax = DB::table('admin')->where(['id'=>$userinfo['aid']])->find();
    $newdqje = $flje + $ax['money'];
    DB::table('admin')->where(['id'=>$userinfo['aid']])->update(['money'=>$newdqje]);
    moneylog($userinfo['aid'],$flje,3,1,$newdqje,'下级代理制作卡密获得返利.',$glid);
}
die(json_encode($ret_arr));
?>