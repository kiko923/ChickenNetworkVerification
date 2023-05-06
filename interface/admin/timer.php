<?php

require_once '../../include/config.php';
require_once '../../include/core.im.php';
require_once '../../include/db.class.php';

    $res = DB::table('heartbeat')->select();
    foreach ($res as $value){
        $tokenid = $value['id'];
        $appid = $value['appid'];
        $row = DB::table('app')->where(['id'=>$appid])->find();
        if(!$row){
            DB::table('heartbeat')->where(['id'=>$tokenid])->del();
        }else{
            $xt_time = $row['xttime'];
            $dqsj = time(); //取当前时间戳
            $xtsj = strtotime($value['hbtime']);
            if($dqsj - $xtsj > $xt_time){
                DB::table('heartbeat')->where(['id'=>$tokenid])->del();
            }
        }
        unset($row);
    }
    $arr['code'] = 200;
    $arr['msg'] = 'Yes';
    echo json_encode($arr);
?>