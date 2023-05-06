<?php
/**
 * 接口：版本列表JSON
 * 时间：2022-07-19 11:05
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? $_GET['id'] : '';
    if($id){
        $where = 'where a.appid='.$id;
    }else{
        $where = '';
    }
    $row = DB::query('SELECT a.*,b.name as appname FROM `ty_ver` as a left join `ty_app` as b on a.appid = b.id '.$where.' order by a.id limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('ver')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['appid'] = $value['appid'];
        $newinfo['current_ver'] = $value['current_ver'];
        $newinfo['new_ver'] = $value['new_ver'];
        $newinfo['type'] = $value['type'] ? '<span class="layui-badge layui-bg-red">强制更新</span>' : '<span class="layui-badge layui-bg-blue">自行选择</span>';
        $newinfo['update_time'] = $value['update_time'];
        $newinfo['update_url'] = $value['update_url'];
        $newinfo['appname'] = $value['appname'] ?  $value['appname'] : '<span style="color:#A4A4A4">未绑定</span>';
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>