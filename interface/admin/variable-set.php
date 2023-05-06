<?php
/**
 * 接口：添加/设置常量
 * 时间：2022-07-19 10:00
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //常量id
    $data = $_POST;

    if(!$data['appid']){
        json(201,'请选择常量绑定的软件');
    }
    if(!$id){ //如果变量id是空 则是新增变量
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $res = DB::table('variable')->where(['cloud_key'=>$data['cloud_key'],'appid'=>$data['appid']])->find();
        if($res){
            json(201,'此常量已存在，请重新填写');
        }
        unset($res);
        $data['addtime'] = date('Y-m-d H:i:s',time());
        $res = DB::table('variable')->add($data);
        json(200,'新增常量成功');
    }
    $res = DB::table('variable')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改常量失败，请重试');
    }
    json(200,'修改常量成功');
?>