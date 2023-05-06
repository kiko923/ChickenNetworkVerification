<?php
/**
 * 接口：软件列表
 * 时间：2022-07-18 11:30
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
function whereOrs($key){
    $nums = 1;
    $str = '';
    if(is_array($key)){
        $count_key = count($key);
        foreach($key as $v){
            if($count_key == $nums){
                $str .= "id=$v";
            }else{
                $str .= "id=$v".' '.'or'.' ';
            }
            $nums++;
        }
        if($str != ''){
            $str = ' where '.$str;
        }
    }
    return $str;
}
if($userinfo['appsid']){
    $data = explode(',', $userinfo['appsid']);
    $where = whereOrs($data);
    $row = DB::query('select * from ty_app '.$where);
}
if(count($row) <= 0){
    die();
}
$i = '<option value="">请选择软件</option>';
foreach ($row as $value){
    $i .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
}
die($i);

?>