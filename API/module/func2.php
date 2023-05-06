<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
//以下为演示函数,无需登录即可调用

//减法
function jian($c1,$c2){
	return $c1 - $c2;
}

?>