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

$row = DB::query('SELECT a.*,b.name as aname,b.level as level,b.color as color,b.rebate as rebate,b.adds as adds,b.ktjg as ktjg,b.ktzk as ktzk FROM `ty_admin` as a left join `ty_group` as b on a.gid = b.id order by a.id desc limit ' .($_GET['page'] - 1) * $_GET['limit'].','.$_GET['limit']);
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
        $newinfo['ktzk'] = $value['ktzk'] ? $value['ktzk'].'%' : '<span class="layui-badge layui-bg-gray">无折扣</span>';
        $newinfo['consume'] = $value['consume'];
        $newinfo['aname'] = $value['aname'] ? '<span class="layui-badge layui-bg-gray"><span style="color:'.$value['color'].'">'.$value['aname'].'</span></span>' : '<span class="layui-badge layui-bg-gray"><span style="color:grey">未分组</span></span>';
        if($value['type']==0){
            $newinfo['type'] = '<span class="layui-badge layui-btn-danger">管理员</span>';
        }elseif($value['type']==1){
            $newinfo['type'] = '<span class="layui-badge layui-bg-green">代理账号</span>';
        }elseif($value['type']==2){
            $newinfo['type'] = '<span class="layui-badge layui-bg-blue">作者账号</span>';
        }elseif($value['type']==3){
            $newinfo['type'] = '<span class="layui-badge layui-bg-gray">普通用户</span>';
        }

        $newinfo['adds'] = $value['adds'] ? '<span class="layui-badge layui-bg-gray"><span style="color:lightseagreen">允许</span></span>' : '<span class="layui-badge layui-bg-gray">禁止</span>';;
        $newinfo['level'] = $value['level'] ? $value['level'].'%' : '';
        $newinfo['rebate'] = $value['rebate'] ? $value['rebate'].'%' : '';
        $newinfo['logintime'] = $value['logintime'];
        if($value['aid']){
            $res = DB::table('admin')->where(['id'=>$value['aid']])->find();
            if($res){
                $newinfo['aid'] = $res['user'];
            }
        }

        $newinfo['zt'] = $value['zt'] ? '<span class="layui-badge layui-bg-gray">正常</span>' : '<span class="layui-badge layui-bg-gray"><span style="color:red">封禁</span></span>';
        $newinfo['bz'] = $value['bz'];
        
        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>