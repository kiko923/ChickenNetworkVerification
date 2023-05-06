<?php
/**
 * 接口：添加/设置软件
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //软件id
    $data = $_POST;

    if(!$id){ //如果软件id是空 则是新增软件
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        if(!$data['appkey']){
            $data['appkey'] = get_str(16,3,0);
        }
        if($data['mi_type'] == 1){
            $data['mi_rc4_key'] = get_str(24,3,4);
        }
        $res = DB::table('app')->add($data);
        if(!$res){
            json(201,'添加软件失败，请重试');
        }
        json(200,'添加软件成功');
    }
    if(!$data['appkey']){
        $data['appkey'] = get_str(16,3,0);
    }
    if($data['mi_type'] == 1 && !$data['mi_rc4_key']){
        $data['mi_rc4_key'] = get_str(24,3,4);
    }
    $res = DB::table('app')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改软件失败，请重试');
    }
    json(200,'修改软件成功');
?>