<?php
/**
 * 接口：接口日志列表JSON
 * 时间：2022-08-22 09:23
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::query('SELECT a.*,b.name as appname,b.dl_type as dl_type,c.name as apiname,c.ec_api as ec_api,c.in_api as in_api,c.type as type FROM `ty_apilog` as a left join `ty_app` as b on a.appid = b.id left join `ty_api` as c on a.apiid = c.id order by id desc limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('apilog')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['apiname'] = $value['apiname'].'('.$value['in_api'].')';
        $newinfo['appname'] = $value['appname'];
        $port = $_SERVER['SERVER_PORT'];
        if($port == '443'){
            $port = 'https://';
        }else{
            $port = 'http://';
        }
        $newinfo['url'] = $port.$_SERVER['SERVER_NAME'].'/api.php?act='.$value['ec_api'];
        
        $newinfo['type'] = $value['type']==0 ? '<span style="color:green">非加密</span>' : '<span style="color:blue">已加密</span>';
        $newinfo['mac'] = $value['mac'];
        $newinfo['ip'] = $value['ip'];
        $newinfo['ver'] = $value['ver'];
        $newinfo['data'] = $value['data'];
        $newinfo['addtime'] = $value['addtime'];
        if($value['dl_type'] == 0){
            $newinfo['logintype'] = '<span style="color:green">账号密码</span>';
        }elseif($value['dl_type'] == 1){
            $newinfo['logintype'] = '<span style="color:#A901DB">充值卡</span>';
        }elseif($value['dl_type'] == 2){
            $newinfo['logintype'] = '<span style="color:#DF013A">QQ号</span>';
        }elseif($value['dl_type'] == 3){
            $newinfo['logintype'] = '<span style="color:#CE5023">域名</span>';
        }elseif($value['dl_type'] == 4){
            $newinfo['logintype'] = '<span style="color:blue">设备码</span>';
        }elseif($value['dl_type'] == 5){
            $newinfo['logintype'] = '<span style="color:#0B6138">设备IP</span>';
        }elseif($value['dl_type'] == 6){
            $newinfo['logintype'] = '<span style="color:#0080FF">标识</span>';
        }
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>