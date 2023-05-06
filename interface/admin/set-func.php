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
$data = file_get_contents('php://input');
$file = fopen($file_path,'w+');
if(!fwrite($file,$data)){
    json(201,'修改失败');
}
json(200,'修改成功');
?>