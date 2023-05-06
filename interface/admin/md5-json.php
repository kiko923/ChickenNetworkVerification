<?php
/**
 * 接口：md5列表JSON
 * 时间：2022-07-28 10:38
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
    $row = DB::query('SELECT a.*,b.name as appname FROM `ty_md5` as a left join `ty_app` as b on a.appid = b.id '.$where.' order by a.id limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('md5')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['appid'] = $value['appid'];
        $newinfo['ver'] = $value['ver'];
        $newinfo['md5'] = $value['md5'];
        $newinfo['addtime'] = $value['addtime'];
        $newinfo['appname'] = $value['appname'] ?  $value['appname'] : '<span style="color:#A4A4A4">未绑定</span>';
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>