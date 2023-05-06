<?php
/**
 * 接口：修改人员授权软件
 * 时间：2022-09-15 20:21
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
    $id = isset($_GET['id']) ? purge($_GET['id']) : ''; //人员id
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

    $res = DB::table('admin')->where(['id'=>$id])->update(['appsid'=>$appids]);
    if(!$res){
        json(201,'修改授权软件失败');
    }
    json(200,'修改授权软件成功');
?>