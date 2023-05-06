<?php
/**
 * 接口：添加/设置版本
 * 时间：2022-07-19 11:05
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

    $id = isset($_GET['id']) ? purge($_GET['id']) : ''; //版本id
    $data = $_POST;

    if(!$data['appid']){
        json(201,'请选择版本绑定的软件');
    }
    if(!$id){ //如果版本id是空 则是新增版本
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $res = DB::table('ver')->where(['current_ver'=>$data['current_ver'],'appid'=>$data['appid']])->find();
        if($res){
            json(201,'此版本已存在，请重新填写');
        }
        unset($res);
        if($data['update_text']){
            $data['update_text'] = base64_encode($data['update_text']);
        }
        $res = DB::table('ver')->add($data);
        json(200,'新增版本成功');
    }
    if($data['update_text']){
        $data['update_text'] = base64_encode($data['update_text']);
    }
    $res = DB::table('ver')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改版本失败，请重试');
    }
    json(200,'修改版本成功');
?>