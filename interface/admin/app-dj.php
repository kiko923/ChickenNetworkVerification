<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //软件id
$type = isset($_GET['type']) ? purge($_GET['type']) : ''; //0解冻 1冻结
if($type==1){
    $res = DB::table('app')->where(['id'=>$id])->find();
    if(!$res){
        json(201,'不存在此软件');
    }
    if($res['djzt']==1){
        json(201,'此软件已经在冻结中');
    }
    $res = DB::table('app')->where(['id'=>$id])->update(['djzt'=>1,'djsj'=>$g_date]);
    if(!$res){
        json(201,'冻结软件失败，请重试');
    }
    json(200,'冻结软件成功');
}else{
    $res = DB::table('app')->where(['id'=>$id])->find();
    if(!$res){
        json(201,'不存在此软件');
    }
    if($res['djzt']==0){
        json(201,'此软件不在冻结中');
    }
    $resu = DB::table('app')->where(['id'=>$id])->update(['djzt'=>0]);
    if(!$resu){
        json(201,'解冻软件失败，请重试');
    }
    if($res['orcheck']==1){//计时模式补偿时间
        $zjsj = time() - strtotime($res['djsj']);
        $row = DB::table('user')->where(['appid'=>$res['id']])->select();
        foreach ($row as $value){
            $newsj = strtotime($value['endtime']) + $zjsj;
            $newsj = date('Y-m-d H:i:s',$newsj);
            DB::table('user')->where(['id'=>$value['id']])->update(['endtime'=>$newsj]);
        }
        $sjx = $zjsj / 60;
        $sjx = ceil($sjx);
        $fjinfo = '，补偿每位用户时间约:'.$sjx.'分钟';
    }
    json(200,'解冻软件成功'.$fjinfo);
}