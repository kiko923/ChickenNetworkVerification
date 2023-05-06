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

if($data['agent']){
    $agent = DB::table('admin')->where(['user'=>$data['agent']])->find();
    if($agent){
        $data['aid'] = $agent['id'];
    }else{
        json(201,'未找到此代理，请修改所属代理账号。');
    }
}
unset($data['agent']);

if(!$id){ //如果人员id是空 则是新增人员
    $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
    $res = DB::table('admin')->where(['user'=>$data['user']])->find();
    if($res){
        json(201,'此人员已存在，请重新填写');
    }
    unset($res);
    $data['addtime'] = date('Y-m-d H:i:s',time());
    $res = DB::table('admin')->add($data);
    if(!$res){
        json(201,'添加人员失败，请重试。');
    }
    json(200,'添加人员成功。');
}

$res = DB::table('admin')->where(['id'=>$id])->update($data);
if(!$res){
    json(201,'修改人员失败，请重试');
}
json(200,'修改人员成功');
?>