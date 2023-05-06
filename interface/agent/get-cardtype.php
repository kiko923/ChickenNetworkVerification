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
function whereOrs($key,$id = null){
    $nums = 1;
    $str = '';
    if($id){
        $str = ' where type=1 and a.appid='.$id;
    }else{
        if(is_array($key)){
            $count_key = count($key);
            foreach($key as $v){
                if($count_key == $nums){
                    $str .= "a.appid=$v";
                }else{
                    $str .= "a.appid=$v".' '.'or'.' ';
                }
                $nums++;
            }
            if($str != ''){
                $str = ' where '.$str.' and type=1';
            }
        }
    }
    return $str;
}
$id = isset($_GET['id']) ? purge($_GET['id']) : '';
if($userinfo['appsid']){
    $data = explode(',', $userinfo['appsid']);
    if($id){
        if(!in_array($id,$data,true)){
            die();
        }
        $where = whereOrs('', $id);
    }else {
        $where = whereOrs($data, $id);
    }
    $row = DB::query('select a.*,b.name as appname from ty_cardtype as a left join ty_app as b on a.appid=b.id'.$where);
}
if(count($row) <= 0){
    die();
}
$i = '<option value="">请选择卡类</option>';
foreach ($row as $value){
    $i .= '<option value="'.$value['id'].'">'.$value['appname'].' | '.$value['name'].'</option>';
}
die($i);

?>