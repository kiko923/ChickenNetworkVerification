<?php
/**
 * 接口：添加/设置公告
 * 时间：2022-07-19 10:50
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //公告id
    $data = $_POST;

    if(!$data['appid']){
        json(201,'请选择公告绑定的软件');
    }
    if(!$id){ //如果公告id是空 则是新增公告
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $res = DB::table('notice')->where(['notice_title'=>$data['notice_title'],'appid'=>$data['appid']])->find();
        if($res){
            json(201,'此标题的公告已存在，请重新填写');
        }
        unset($res);
        $data['addtime'] = date('Y-m-d H:i:s',time());
        $res = DB::table('notice')->add($data);
        json(200,'新增公告成功');
    }
    $res = DB::table('notice')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改公告失败，请重试');
    }
    json(200,'修改公告成功');
?>