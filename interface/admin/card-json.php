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

    $infos = isset($_GET['infos']) ? purge($_GET['infos']) : '';
    $type = isset($_GET['type']) ? purge($_GET['type']) : '';
    $appid = isset($_GET['appid']) ? purge($_GET['appid']) : '';
    $where['a.appid'] = $appid;
    if($type){
        if($type=='user'){
            $where['c.'.$type] = $infos;
        }else{
            $where['a.'.$type] = $infos;
        }
    }
    $where = array_filter($where,'filterfunction');

    $row = DB::query('SELECT a.*,b.name as appname,c.user as auser,b.dl_type as dl_type,d.name as gname,d.color as color FROM `ty_card` as a left join `ty_app` as b on a.appid = b.id left join `ty_admin` as c on a.aid=c.id left join `ty_usergroup` as d on a.gid=d.id'.whereStr($where).' order by a.id desc limit '.($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::query('SELECT count(*) FROM `ty_card` as a left join `ty_app` as b on a.appid = b.id left join `ty_admin` as c on a.aid=c.id left join `ty_usergroup` as d on a.gid=d.id'.whereStr($where).' order by a.id desc');
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
        $newinfo['type'] = $value['type'] ? '<span class="layui-badge layui-bg-gray"><span style="color:darkorchid"><b>已售出</b></span></span>' : '<span class="layui-badge layui-bg-gray"><span style="color:blue"><b>未售出</b></span></span>';
        $newinfo['bz'] = $value['bz'];
        $newinfo['appname'] = $value['appname'] ? $value['appname'] : '<span style="color:#A4A4A4">未绑定</span>';

        $newinfo['aid'] = $value['auser'];
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>