<?php
/**
 * 接口：人员列表JSON
 * 时间：2022-07-15 08:35
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$group = DB::table('group')->where(['id'=>$userinfo['gid']])->find();
if(!$group['adds']){
    json(201,'无权限');
}
$row = DB::query('SELECT a.*,b.name as aname,b.level as level,b.color as color,b.rebate as rebate,b.adds as adds FROM `ty_admin` as a left join `ty_group` as b on a.gid = b.id where a.aid='.$userinfo['id'].' order by a.id desc limit ' .($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('admin')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['name'] = $value['name'];
        $newinfo['user'] = $value['user'];
        $newinfo['money'] = $value['money'];
        $newinfo['consume'] = $value['consume'];
        $newinfo['aname'] = $value['aname'] ? '<span class="layui-badge layui-bg-gray"><span style="color:'.$value['color'].'">'.$value['aname'].'</span></span>' : '<span class="layui-badge layui-bg-gray"><span style="color:grey">未分组</span></span>';

        $newinfo['level'] = $value['level'] ? $value['level'].'%' : '';
        $newinfo['rebate'] = $value['rebate'] ? $value['rebate'].'%' : '';
        $newinfo['logintime'] = $value['logintime'];

        $newinfo['zt'] = $value['zt'] ? '<span class="layui-badge layui-bg-gray">正常</span>' : '<span class="layui-badge layui-bg-gray"><span style="color:red">封禁</span></span>';
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>