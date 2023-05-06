<?php

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

    $udata = $_POST;
    foreach($udata  as $key => $value){
	    $res = DB::table('core')->where('config_key',$key)->update(['config_value'=>$value]);
	    if(!$res){
	        $count = DB::table('core')->where('config_key',$key)->count();
	        if($count<=0){
	            DB::table('core')->add(['config_key'=>$key,'config_value'=>$value]);
	        }
	    }
	}
	json(201,'修改成功');

?>