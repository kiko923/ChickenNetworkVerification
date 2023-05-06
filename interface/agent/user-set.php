<?php
/**
 * 接口：添加/设置授权
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //授权id
    $data = $_POST;

    if(!$data['pwd']){
        unset($data['pwd']);
    }else{
        $data['pwd'] = md5($data['pwd']);
    }

    $data['aid'] = $userinfo['id'];

    if(!$id){ //如果授权id是空 则是新增授权
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        if(!$data['cardtypeid']){
            json(201,'请选择卡类');
        }
        $res = DB::table('cardtype')->where(['id'=>$data['cardtypeid']])->find();
        if(!$res){
            json(201,'不存在此卡类');
        }
        if($userinfo['appsid']){
            $datas = explode(',', $userinfo['appsid']);
            if(!in_array($res['appid'],$datas,true)){
                json(201,'不存在此卡类');
            }
        }else{
            json(201,'不存在此卡类');
        }
        if($userinfo['gid']){
            $group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
        }
        $kcye = $res['money'] - $res['money'] * $group['level'] / 100;
        $flje = $kcye * $group['rebate'] / 100;
        if($userinfo['money'] < $kcye){
            json(201,'当前账户余额少于'.$kcye.'元，无法添加授权');
        }

        $newinfo['money'] = $userinfo['money'] - $kcye;
        $newinfo['consume'] = $userinfo['consume'] + $kcye;
        $data['appid'] = $res['appid'];
        $data['dk'] = $res['dk'];
        $data['data'] = $res['data'];
        $newtime = time() + $res['rgtime'] * 60;
        $newpoint = $res['rgpoint'];
        unset($res);
        unset($data['cardtypeid']);
        $res = DB::table('user')->where(['user'=>$data['user'],'appid'=>$data['appid']])->find();
        if($res){
            json(201,'此授权用户已存在，请重新填写');
        }
        unset($res);
        $data['endtime'] = date('Y-m-d H:i:s',$newtime);
        $data['point'] = $newpoint;
        $data['type'] = 1;
        $data['addtime'] = date('Y-m-d H:i:s',time());
        $res = DB::table('user')->add($data);
        if(!$res){
            json(201,'添加授权失败，请重试。');
        }
        DB::table('admin')->where(['id'=>$userinfo['id']])->update($newinfo);
        $glid = moneylog($userinfo['id'],$kcye,2,0,$newinfo['money'],'添加授权账户('.$data['user'].')扣除余额['.$kcye.']元.');
        if($userinfo['aid'] && $flje>0){
            $ax = DB::table('admin')->where(['id'=>$userinfo['aid']])->find();
            $newdqje = $flje + $ax['money'];
            DB::table('admin')->where(['id'=>$userinfo['aid']])->update(['money'=>$newdqje]);
            moneylog($userinfo['aid'],$flje,3,1,$newdqje,'下级代理添加授权账户获得返利.',$glid);
        }
        json(200,'添加授权成功，扣除账户余额'.$kcye.'元。');
    }
    if($data['pwd']){
        $update['pwd'] = $data['pwd'];
    }
    $update['mac'] = $data['mac'];
    $update['ip'] = $data['ip'];
    $update['userqq'] = $data['userqq'];
    $update['email'] = $data['email'];
    $update['zt'] = $data['zt'];
    $update['reason'] = $data['reason'];
    $res = DB::table('user')->where(['id'=>$id,'aid'=>$userinfo['id']])->update($update);
    if(!$res){
        json(201,'修改授权失败，请重试');
    }
    json(200,'修改授权成功');
?>