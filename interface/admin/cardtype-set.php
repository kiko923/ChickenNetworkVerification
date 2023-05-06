<?php
/**
 * 接口：添加/设置充值卡类
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //充值卡类id
    $data = $_POST;
    if(!$data['appid']){
        json(201,'请选择卡类所属软件');
    }
    if(!$id){ //如果充值卡类id是空 则是新增卡类
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $data['addtime'] = date('Y-m-d H:i:s',time());
        $res = DB::table('cardtype')->add($data);
        if(!$res){
            json(201,'添加充值卡类失败，请重试。');
        }
        json(200,'添加充值卡类成功。');
    }
    $res = DB::table('cardtype')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改充值卡类失败，请重试。');
    }
    json(200,'修改充值卡类成功。');
?>