<?php
/**
 * 接口：用户列表JSON
 * 时间：2022-07-06 10:00
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

    $infos = isset($_GET['infos']) ? purge($_GET['infos']) : '';
    $type = isset($_GET['type']) ? purge($_GET['type']) : '';
    $appid = isset($_GET['appid']) ? purge($_GET['appid']) : '';
    $iscode = isset($_GET['iscode']) ? purge($_GET['iscode']) : '';
    $where['a.appid'] = $appid;
    if($type){
        $where['a.'.$type] = $infos;
    }
    if($iscode){
        $where['a.code'] = $iscode;
    }
    $where = array_filter($where,'filterfunction');

    $row = DB::query('SELECT a.*,b.name as appname,b.dl_type,c.user as tjr,d.name as gname,d.color as color FROM `ty_user` as a left join `ty_app` as b on a.appid=b.id left join `ty_user` as c on a.tid=c.id left join `ty_usergroup` as d on a.gid=d.id'.whereStr($where).' order by a.id desc limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::query('SELECT count(*) FROM `ty_user` as a left join `ty_app` as b on a.appid=b.id left join `ty_user` as c on a.tid=c.id left join `ty_usergroup` as d on a.gid=d.id'.whereStr($where).' order by a.id desc');
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['appid'] = $value['appid'];
        $newinfo['user'] = $value['user'];
        $newinfo['endtime'] = $value['endtime'];
        $newinfo['point'] = $value['point'];
        $newinfo['integral'] = $value['integral'];
        $newinfo['userqq'] = $value['userqq'];
        $newinfo['logintime'] = $value['logintime'];
        $newinfo['addtime'] = $value['addtime'];
        $newinfo['gname'] = $value['gname'] ? '<span style="color:'.$value['color'].'">'.$value['gname'].'</span>' : '<span class="layui-badge layui-bg-gray">未绑定</span>';
        $newinfo['zt'] = $value['zt'] ? '<span class="layui-badge layui-bg-blue">正常</span>' : '<span class="layui-badge layui-bg-red">封禁</span>';
        $newinfo['mac'] = $value['mac'];
        $newinfo['ip'] = $value['ip'];
        $newinfo['rgmac'] = $value['rgmac'];
        $newinfo['rgip'] = $value['rgip'];
        $newinfo['email'] = $value['email'];
        $newinfo['ver'] = $value['ver'];
        if($value['tjr']){
            $newinfo['tjr'] = $value['tjr'];
        }
        $newinfo['type'] = $value['type']==1 ? '<span class="layui-badge layui-bg-gray">收费</span>' : '<span class="layui-badge layui-bg-gray">免费</span>';
        
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
        $newinfo['appname'] = $value['appname'] ? $value['appname'].'<span style="font-size: 10px">['.$newinfo['logintype'].']</span>' : '<span style="color:#A4A4A4">未绑定</span>';
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>