<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$b_type = !empty($d['b_type']) ? purge($d['b_type']) : '';
$b_data = !empty($d['b_data']) ? purge($d['b_data']) : '';

$res = DB::table('black')->where(['appid'=>$appid,'type'=>$b_type,'data'=>$b_data])->find();

if(!$res){
    insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证云黑] > 验证成功,暂无拉黑.');
    out(201,'验证通过。',$app_res);
}

insert_userlog('',$appid,$alid,$g_date,$ver,$mac,$ip,$clientid,'[验证云黑] > 验证成功,已拉黑.');
out(200,'该数据已拉黑。',$app_res);

?>