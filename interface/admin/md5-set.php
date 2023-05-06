<?php
/**
 * 接口：添加/设置md5
 * 时间：2022-07-28 10:39
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //md5id
    $data = $_POST;

    if(!$data['appid']){
        json(201,'请选择版本MD5绑定的软件');
    }
    if(!$id){ //如果md5id是空 则是新增md5
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $res = DB::table('md5')->where(['ver'=>$data['ver'],'appid'=>$data['appid']])->find();
        if($res){
            json(201,'此软件版本的MD5已存在，请重新填写');
        }
        unset($res);
        $data['addtime'] = date('Y-m-d H:i:s',time());
        $res = DB::table('md5')->add($data);
        if($res){
            json(200,'新增版本MD5成功');
        }
        json(200,'新增版本MD5失败，请重试');
    }
    $res = DB::table('md5')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改版本MD5失败，请重试');
    }
    json(200,'修改版本MD5成功');
?>