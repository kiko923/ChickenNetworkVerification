<?php
/**
 * 接口：充值卡列表JSON
 * 时间：2022-07-07 20:42
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$card = isset($_GET['card']) ? purge($_GET['card']) : '';
    $appid = isset($_GET['appid']) ? purge($_GET['appid']) : '';
    $where['a.appid'] = $appid;
    $where['card'] = $card;
    $where['a.aid'] = $userinfo['id'];
    $where = array_filter($where,'filterfunction');

    $row = DB::query('SELECT a.*,b.name as appname,c.user as auser,b.dl_type as dl_type,d.name as gname,d.color as color FROM `ty_card` as a left join `ty_app` as b on a.appid = b.id left join `ty_admin` as c on a.aid=c.id left join `ty_usergroup` as d on a.gid=d.id'.whereStr($where).' order by a.id desc limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = count(DB::query('SELECT count(a.*) FROM `ty_card` as a left join `ty_app` as b on a.appid = b.id left join `ty_admin` as c on a.aid=c.id'.whereStr($where).' order by a.id desc'));
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['name'] = $value['name'];
        $newinfo['gname'] = $value['gname'] ? '<span style="color:'.$value['color'].'">'.$value['gname'].'</span>' : '<span class="layui-badge layui-bg-gray">未设置</span>';
        $newinfo['card'] = $value['card'];
        $newinfo['rgtime'] = $value['rgtime'].'分钟（'.number_format($value['rgtime'] / 1440,2).'天）';
        $newinfo['rgpoint'] = $value['rgpoint'].'点';
        $newinfo['addtime'] = $value['addtime'];
        $newinfo['scje'] = $value['scje'] ? $value['scje'].'元' : '免费';
        $newinfo['bz'] = $value['bz'];
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
        
        $newinfo['aid'] = $value['auser'];
        $newinfo['appname'] = $value['appname'] ? $value['appname'].'<span style="font-size: 10px">['.$newinfo['logintype'].']</span>' : '<span style="color:#A4A4A4">未绑定</span>';
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>