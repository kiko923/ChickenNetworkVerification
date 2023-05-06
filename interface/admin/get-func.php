<?php

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$lx = isset($_GET['type']) ? purge($_GET['type']) : '';
if($lx==1){
    $file_path = ROOT."/API/module/func2.php";
}else{
    $file_path = ROOT."/API/module/func.php";
}
if(file_exists($file_path)){
    $str = file_get_contents($file_path);//将整个文件内容读入到一个字符串中
    die($str);
}
die();
?>