<?php

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$sysmac = DB::table('core')->where(['config_key'=>'sysmac'])->find();
$sysid = DB::table('core')->where(['config_key'=>'sysid'])->find();
$url = 'https://subscribe.wxplugin.com/api.php?act=checkauth&appid=1&user='.$_SERVER['SERVER_NAME'].'&t='.time().'&ver='.$version['ver'].'&ip='.$_SERVER["REMOTE_ADDR"].'&mac='.$sysmac['config_value'].'&clientID='.$sysid['config_value'];
$rtdata = curl_get($url);
$res = json_decode($rtdata, true);
if($res['code']==201){
    json(201,$res['msg']['ret_info']);
}elseif($res['code']==200){
    $endtime = strtotime($res['msg']['endtime']);
    if($endtime<=time()){
        json(201,'NULL');
    }
}

if(!class_exists('ZipArchive',false) || defined("SAE_ACCESSKEY") || defined("BAE_ENV_APPID")) {
    json(201,'您的空间不支持自动更新，请在群内手动下载更新包并覆盖到程序根目录！');
}

$url = 'https://subscribe.wxplugin.com/api.php?act=ver&appid=1&user='.$_SERVER['SERVER_NAME'].'&t='.time().'&ver='.$version['ver'].'&ip='.$_SERVER["REMOTE_ADDR"].'&mac='.$sysmac['config_value'].'&clientID='.$sysid['config_value'];
$rtdata = curl_get($url);
$res = json_decode($rtdata, true);
if($res['code']=='201'){
    json(201,$res['msg']['ret_info']);
}
json(200,'<span style="color:blue">检测到有新版本，是否更新？</span><br/><br/>当前版本：'.$version['ver'].'<br>更新版本：'.$res['msg']['new_ver'].'<br><br/><span style="font-size: 12px;color:darkcyan;">'.$res['msg']['update_info'].'</span>');
?>