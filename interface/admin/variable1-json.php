<?php
/**
 * 接口：变量列表JSON
 * 时间：2022-07-19 10:00
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::query('SELECT a.*,b.name as appname FROM `ty_variable1` as a left join `ty_app` as b on a.appid = b.id order by a.id limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('variable1')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['cloud_key'] = $value['cloud_key'];
        $newinfo['cloud_value'] = $value['cloud_value'];
        $newinfo['callsl'] = $value['callsl'];
        $newinfo['addtime'] = $value['addtime'];
        $newinfo['appname'] = $value['appname'] ?  $value['appname'] : '<span style="color:#A4A4A4">未绑定</span>';
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>