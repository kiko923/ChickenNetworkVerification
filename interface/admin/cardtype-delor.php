<?php

/**
 * 接口：删除卡类(选中)
 * 时间：2022-07-25 10:54
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$data = $_POST['data'];
$arr = json_decode($data, true);
$count = 0;
foreach ($arr as $key => $value) {
    $res = DB::query('delete from `ty_cardtype` where id=' . $value['id']);
    if ($res) {
        $count++;
    }
}
json(200, '执行删除卡类成功,成功删除卡类数量[' . $count . ']条');
