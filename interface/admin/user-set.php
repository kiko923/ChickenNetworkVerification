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
    if(!$data['appid']){
        json(201,'请选择授权所属软件');
    }

    if(!$data['pwd']){
        unset($data['pwd']);
    }else{
        $data['pwd'] = md5($data['pwd']);
    }

    if($data['agent']){
        $agent = DB::table('admin')->where(['user'=>$data['agent']])->find();
        if($agent){
            $data['aid'] = $agent['id'];
        }else{
            json(201,'未找到此代理，请修改所属代理账号。');
        }
    }
    unset($data['agent']);

    if(!$id){ //如果授权id是空 则是新增授权
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $res = DB::table('user')->where(['user'=>$data['user'],'appid'=>$data['appid']])->find();
        if($res){
            json(201,'此授权用户已存在，请重新填写');
        }
        unset($res);
        if(!$data['endtime']){
            $data['endtime'] = date('Y-m-d H:i:s',time());
        }
        $data['addtime'] = date('Y-m-d H:i:s',time());
        $res = DB::table('user')->add($data);
        if(!$res){
            json(201,'添加授权失败，请重试。');
        }
        json(200,'添加授权成功。');
    }
    $res = DB::table('user')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改授权失败，请重试');
    }
    json(200,'修改授权成功');
?>