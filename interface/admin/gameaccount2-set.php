<?php
/**
 * 接口：导入数据
 * 时间：2023-02-14 15:32
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
$count = 0;
$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //索引id
$data = $_POST['gameaccounts'];//取出导入数据
if($data){
    $Arr = explode("\n", $data);
    foreach ($Arr as $values) {
        $Arr_n = explode("----", $values);
        if(count($Arr_n)==7){
            $add = array(
                'c1' => $Arr_n[0],
                'c2' => $Arr_n[1],
                'c3' => $Arr_n[2],
                'c4' => $Arr_n[3],
                'c5' => $Arr_n[4],
                'c6' => $Arr_n[5],
                'c7' => $Arr_n[6]
            );
            $res = DB::table('gameaccount2')->add($add);
            if($res){
                ++$count;
            }
        }
    }
}

json(200,'导入成功,成功导入'.$count.'条');
?>