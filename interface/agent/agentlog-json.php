<?php
/**
 * 接口：消费明细JSON
 * 时间：2022-07-07 20:42
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$row = DB::table('moneylog')->where(['aid'=>$userinfo['id']])->order('id desc')->limit(($_GET['page'] - 1) * $_GET['limit'],$_GET['limit'])->select();
if(!$row){
    json(201,'暂无数据');
}
$jsondata['code'] = 200;
$jsondata['msg'] = '';
$jsondata['count'] = DB::table('moneylog')->where(['aid'=>$userinfo['id']])->count();
foreach ($row as $value){
    $newinfo = array();
    $newinfo['id'] = $value['id'];
    $newinfo['money'] = $value['money'].'元';
    $newinfo['syje'] = '<u>'.$value['syje'].'元</u>';
    $newinfo['addtime'] = $value['addtime'];
    $newinfo['info'] = $value['info'];
    if($value['type']==0){
        $newinfo['type'] = '转账';
    }elseif($value['type']==1){
        $newinfo['type'] = '制卡';
    }elseif($value['type']==2){
        $newinfo['type'] = '加授权';
    }elseif($value['type']==3){
        $newinfo['type'] = '下级返利';
    }elseif($value['type']==4){
        $newinfo['type'] = '退卡';
    }elseif($value['type']==5){
        $newinfo['type'] = '返利扣除';
    }
    if($value['x_type']==0){
        if($value['type']==5){
            $newinfo['x_type'] = '<span style="color:deeppink">扣除</span>';
        }else{
            $newinfo['x_type'] = '<span style="color:#A901DB">消费</span>';
        }
    }else{
        if($value['type']==3){
            $newinfo['x_type'] = '<span style="color:blue">提成</span>';
        }else{
            $newinfo['x_type'] = '<span style="color:seagreen">返还</span>';
        }
    }

    $jsondata['data'][] = $newinfo;
}
die(json_encode($jsondata));
?>