<?php
/**
 * 接口：修改组别授权
 * 时间：2022-10-21 12:58
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //组别id
$data = $_POST['data'];
$arr = json_decode($data,true);
$appids = '';

foreach ($arr as $v){
    if(!$appids){
        $appids = $v['value'];
    }else{
        $appids = $appids.','.$v['value'];
    }
}

$res = DB::table('group')->where(['id'=>$id])->update(['groupsid'=>$appids]);
if(!$res){
    json(201,'修改授权组别失败');
}
json(200,'修改授权组别成功');
?>