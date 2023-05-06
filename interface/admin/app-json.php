<?php
/**
 * 接口：软件列表JSON
 * 时间：2022-07-07 20:42
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('app')->order('id' )->limit(($_GET['page'] - 1) * $_GET['limit'],$_GET['limit'])->select();
    if(!$row){
        json(201,'暂无数据');
    }
    $jsondata['code'] = 200;
    $jsondata['msg'] = '';
    $jsondata['count'] = DB::table('app')->count();
    foreach ($row as $value){
        $newinfo = array();
        $newinfo['id'] = $value['id'];
        $newinfo['name'] = $value['name'];
        $newinfo['appkey'] = $value['appkey'];
        if($value['orcheck']==1){
            $newinfo['orcheck'] = '<span class="layui-badge layui-bg-green">计时模式</span>';
        }elseif($value['orcheck']==3){
            $newinfo['orcheck'] = '<span class="layui-badge layui-bg-blue">免费模式</span>';
        }elseif($value['orcheck']==2){
            $newinfo['orcheck'] = '<span class="layui-badge layui-bg-green">扣点模式</span>';
        }elseif($value['orcheck']==4){
            $newinfo['orcheck'] = '<span class="layui-badge layui-bg-green">计点模式</span>';
        }else{
            $newinfo['orcheck'] = '<span class="layui-badge layui-bg-orange">停止运营</span>';
        }
        if($value['djzt']==1){
            $newinfo['orcheck'] = '<span class="layui-badge layui-bg-danger">已被冻结</span>';
        }
        $newinfo['hb_type'] = $value['hb_type']==1 ? '<span class="layui-badge layui-bg-blue">开启</span>' : '<span class="layui-badge layui-bg-gray">关闭</span>';
        $newinfo['md5_check'] = $value['md5_check']==1 ? '<span class="layui-badge layui-bg-blue">开启</span>' : '<span class="layui-badge layui-bg-gray">关闭</span>';
        $newinfo['mi_sign'] = $value['mi_sign']==1 ? '<span class="layui-badge layui-bg-blue">开启</span>' : '<span class="layui-badge layui-bg-gray">关闭</span>';
        $newinfo['xttime'] = '<span class="layui-badge layui-bg-gray">'.$value['xttime'].'秒</span>';
        if($value['mi_type']==0){
            $newinfo['mi_type'] = '<span class="layui-badge layui-bg-gray">明文</span>';
        }else if($value['mi_type']==1){
            $newinfo['mi_type'] = '<span class="layui-badge layui-bg-gray">RC4</span>';
        }else if($value['mi_type']==2){
            $newinfo['mi_type'] = '<span class="layui-badge layui-bg-gray">RSA2</span>';
        }else if($value['mi_type']==3){
            $newinfo['mi_type'] = '<span class="layui-badge layui-bg-gray">Base64</span>';
        }else if($value['mi_type']=4){
            $newinfo['mi_type'] = '<span class="layui-badge layui-bg-gray">自定义</span>';
        }
        $newinfo['bd_type'] = $value['bd_type']==0 ? '<span class="layui-badge layui-bg-gray">不绑定</span>' : ($value['bd_type']==1 ? '<span class="layui-badge layui-bg-gray"><span style="color:#088A29">设备码</span></span>' : '<span class="layui-badge layui-bg-gray"><span style="color:#088A29">设备IP</span></span>');
        
        
        if($value['dl_type'] == 0){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">账号密码</span>';
        }elseif($value['dl_type'] == 1){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">充值卡</span>';
        }elseif($value['dl_type'] == 2){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">QQ号</span>';
        }elseif($value['dl_type'] == 3){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">域名</span>';
        }elseif($value['dl_type'] == 4){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">设备码</span>';
        }elseif($value['dl_type'] == 5){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">设备IP</span>';
        }elseif($value['dl_type'] == 6){
            $newinfo['logintype'] = '<span class="layui-badge layui-bg-gray">标识</span>';
        }

        $usersl = DB::table('user')->where(['appid'=>$value['id']])->count();
        $newinfo['usersl'] = $usersl;
        $hbsl = DB::table('heartbeat')->where(['appid'=>$value['id']])->count();
        $newinfo['hbsl'] = $hbsl;
        $newinfo['tj_sl'] = '<span style="color:#006dcc">'.$hbsl.'</span> / '.$usersl;

        $jsondata['data'][] = $newinfo;
    }
    die(json_encode($jsondata));
?>