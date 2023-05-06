<?php
/**
 * 接口：日志列表JSON
 * 时间：2022-07-20 09:45
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::query('SELECT a.*,b.name as appname,b.dl_type as dl_type,c.user as user FROM `ty_applog` as a left join `ty_app` as b on a.appid = b.id left join `ty_user` as c on a.uid=c.id order by a.id desc limit ' .($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('applog')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['clientID'] = $value['clientID'];
        $newinfo['addtime'] = $value['addtime'];
        $newinfo['mac'] = $value['mac'];
        $newinfo['ip'] = $value['ip'];
        $newinfo['ver'] = $value['ver'];
        if($value['user']){
            $newinfo['info'] = '[用户:<span style="font-size:12px;color:#1E90FF">'.$value['user'].'</span>] > '.$value['info'];
        }else{
            $newinfo['info'] = $value['info'];
        }
        
        
        if($value['dl_type'] == 0){
            $newinfo['logintype'] = '<span style="color:#088A29">账号密码</span>';
        }elseif($value['dl_type'] == 1){
            $newinfo['logintype'] = '<span style="color:#A901DB">充值卡</span>';
        }elseif($value['dl_type'] == 2){
            $newinfo['logintype'] = '<span style="color:#08298A">QQ号</span>';
        }elseif($value['dl_type'] == 3){
            $newinfo['logintype'] = '<span style="color:#CE5023">域名</span>';
        }elseif($value['dl_type'] == 4){
            $newinfo['logintype'] = '<span style="color:#8A4B08">标识</span>';
        }
        $newinfo['appname'] = $value['appname'] ? $value['appname'].'<span style="font-size: 10px">['.$newinfo['logintype'].']</span>' : '<span style="color:#A4A4A4">未绑定</span>';

        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>