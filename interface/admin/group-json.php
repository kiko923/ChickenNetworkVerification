<?php
/**
 * 接口：用户组列表JSON
 * 时间：2022-09-23 15:05
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('group')->order('id')->limit(($_GET['page'] - 1) * $_GET['limit'],$_GET['limit'])->select();
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::table('group')->count();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['name'] = '<span style="color:'.$value['color'].'">'.$value['name'].'</span>';
    $newinfo['level'] = $value['level'].'%';
    $newinfo['rebate'] = $value['rebate'].'%';
    $newinfo['ktjg'] = $value['ktjg'] ? $value['ktjg'].'元' : '<span class="layui-badge layui-bg-gray">免费</span>';
    $newinfo['ktzk'] = $value['ktzk'] ? $value['ktzk'].'%' : '<span class="layui-badge layui-bg-gray">无折扣</span>';
    $newinfo['adds'] = $value['adds'] ? '<span class="layui-badge layui-bg-gray"><span style="color:lightseagreen">允许</span></span>' : '<span class="layui-badge layui-bg-gray">禁止</span>';;
    $newinfo['addtime'] = $value['addtime'];

    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>