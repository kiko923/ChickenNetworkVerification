<?php
/**
 * 接口：商品列表JSON
 * 时间：2023-02-17 22:23
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::query('select a.* from ty_goods as a left join ty_cardtype as b on a.cid=b.id order by a.id desc limit ' .($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::table('goods')->count();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['name'] = '<span style="color:'.$value['color'].'">'.$value['name'].'</span>';
    if($value['type']==0){//发卡
        $newinfo['type'] = '<span class="layui-badge layui-bg-gray">卡密</span>';
    }elseif($value['type']==1){//直充
        $newinfo['type'] = '<span class="layui-badge layui-bg-gray">账户直充</span>';
    }elseif($value['type']==2){//代理充值
        $newinfo['type'] = '<span class="layui-badge layui-bg-gray">代理余额</span>';
    }
    $newinfo['sale'] = $value['sale'];
    $newinfo['money'] = $value['money'].'元';
    $newinfo['zt'] = $value['zt']==0 ? '<span class="layui-badge layui-bg-blue">销售中</span>' : '<span class="layui-badge layui-bg-red">已停售</span>';
    $newinfo['quota'] = $value['quota']==0 ? '<span class="layui-badge layui-bg-gray">不限购</span>' : '<span class="layui-badge layui-bg-cyan">限购</span>';
    $newinfo['addtime'] = $value['addtime'];
    $newinfo['introduce'] = $value['introduce'];
    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>