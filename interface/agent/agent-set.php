<?php
/**
 * 接口：添加/设置人员
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //人员id
$data = $_POST;

if(!$data['pwd']){
    unset($data['pwd']);
}else{
    $data['pwd'] = md5($data['pwd']);
}
$group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
if(!$group['adds']){
    json(201,'无权限');
}
if(!$id){ //如果人员id是空 则是新增人员
    $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数

    $groups = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
    if(!$groups['groupsid']){
        json(201,'添加失败，不存在此用户组');
    }
    $datas = explode(',', $groups['groupsid']);
    if(!in_array($data['gid'],$datas,true)){
        json(201,'不存在此用户组');
    }

    $groupx = DB::table('group')->where(['id'=>$data['gid']])->find();
    if(!$groupx){
        json(201,'添加失败，不存在此用户组');
    }
    $ktjg = $groupx['ktjg'] - $groupx['ktjg'] * $groups['ktzk'] / 100;
    if($userinfo['money'] < $ktjg){
        json(201,'账户余额不足['.$ktjg.']元，无法开通此等级的代理');
    }
    $newmoney = $userinfo['money'] - $ktjg;
    $res = DB::table('admin')->where(['user'=>$data['user']])->find();
    if($res){
        json(201,'此账号已存在，请换个账号');
    }
    unset($res);

    $data['addtime'] = date('Y-m-d H:i:s',time());
    $data['aid'] = $userinfo['id'];
    $data['type'] = 1;
    $res = DB::table('admin')->add($data);
    if(!$res){
        json(201,'添加子代失败，请重试。');
    }
    if($ktjg){
        DB::table('admin')->where(['id'=>$userinfo['id']])->update(['money'=>$newmoney]);
        moneylog($userinfo['id'],$ktjg,6,0,$newmoney,'开通下级('.$data['user'].'),扣除余额['.$ktjg.']元.');
        $fjinfo = '，扣除账户余额['.$ktjg.']元';
    }
    json(200,'添加子代成功'.$fjinfo.'。');
}
unset($data['user']);
unset($data['gid']);
$res = DB::table('admin')->where(['id'=>$id,'aid'=>$userinfo['id']])->update($data);
if(!$res){
    json(201,'修改子代失败，请重试');
}
json(200,'修改子代成功');
?>