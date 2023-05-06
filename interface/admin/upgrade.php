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

function zipExtract ($src, $dest){
    $zip = new ZipArchive();
    if ($zip->open($src)===true)
    {
        $zip->extractTo($dest);
        $zip->close();
        return true;
    }
    return false;
}

$url = 'https://subscribe.wxplugin.com/api.php?act=ver&appid=1&user='.$_SERVER['SERVER_NAME'].'&t='.time().'&ver='.$version['ver'].'&ip='.$_SERVER["REMOTE_ADDR"].'&mac='.$sysmac['config_value'].'&clientID='.$sysid['config_value'];
$rtdata = curl_get($url);
$res = json_decode($rtdata, true);
if($res['code']=='201'){
    json(201,$res['msg']['ret_info']);
}
$RemoteFile = $res['msg']['update_url'];
if($RemoteFile){
    $ZipFile = "Archive.zip";
    if(!copy($RemoteFile,$ZipFile)){
        json(201,'无法下载更新包文件，请稍后重试！');
    }
    if(zipExtract($ZipFile,ROOT)) {
        if(function_exists("opcache_reset"))@opcache_reset();
        if(!empty($res['msg']['update_text'])){
            $sql=explode(";",$res['msg']['update_text']);
            $t=0; $e=0; $error='';
            $sbsql = '';
            for($i=0;$i<count($sql);$i++) {
                if (trim($sql[$i])=='')continue;
                if(DB::im_sql($sql[$i])!==false) {
                    ++$t;
                } else {
                    $sbsql = $sbsql.'<br/>'.$sql[$i];
                    ++$e;
                }
            }
            if($e){
                $addstr='<br/> 数据库更新成功，SQL成功'.$t.'句/失败'.$e.'句<br/><br/> 【失败语句】'.$sbsql;
            }else{
                $addstr='<br/> 数据库更新成功，SQL成功'.$t.'句/失败'.$e.'句';
            }

        }
        unlink($ZipFile);
        json(200,'程序更新成功！'.$addstr);
    }
    else {
        if (file_exists($ZipFile))
            unlink($ZipFile);
        json(201,'无法解压文件！');
    }
}else{
    if(function_exists("opcache_reset"))@opcache_reset();
    if(!empty($res['msg']['update_text'])){
        $sql=explode(";",$res['msg']['update_text']);
        $t=0; $e=0; $error='';
        $sbsql = '';
        for($i=0;$i<count($sql);$i++) {
            if (trim($sql[$i])=='')continue;
            if(DB::im_sql($sql[$i])!==false) {
                ++$t;
            } else {
                $sbsql = $sbsql.'<br/>'.$sql[$i];
                ++$e;
            }
        }
        if($e){
            $addstr='<br/> 数据库更新成功，SQL成功'.$t.'句/失败'.$e.'句<br/><br/> 【失败语句】'.$sbsql;
        }else{
            $addstr='<br/> 数据库更新成功，SQL成功'.$t.'句/失败'.$e.'句';
        }
    }
    json(200,'程序更新成功！'.$addstr);
}


?>