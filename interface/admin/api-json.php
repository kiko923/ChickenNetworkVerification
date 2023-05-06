<?php
/**
 * 接口：加密接口列表JSON
 * 时间：2022-08-17 15:35
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}


$row = DB::table('api')->limit(($_GET['page'] - 1) * $_GET['limit'],$_GET['limit'])->select();
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('api')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['type'] = $value['type']==0 ? '<span style="color:green">非加密</span>' : '<span style="color:blue">已加密</span>';
        $newinfo['name'] = $value['name'];
        $newinfo['apiname'] = $value['in_api'];
        $port = $_SERVER['SERVER_PORT'];
        if($port == '443'){
            $port = 'https://';
        }else{
            $port = 'http://';
        }
        $newinfo['url'] = $port.$_SERVER['SERVER_NAME'].'/api.php';
        $newinfo['callsl'] = $value['callsl'];
        $newinfo['addtime'] = $value['addtime'];
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>