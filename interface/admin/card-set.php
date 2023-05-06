<?php
/**
 * 接口：添加/设置充值卡
 * 时间：2022-07-14 16:55
 */
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$id = isset($_GET['id']) ? purge($_GET['id']) : ''; //充值卡id
    $data = $_POST;

    if(!$data['appid']){
        json(201,'请选择充值卡所属软件');
    }
    if($data['agent']){
        $agent = DB::table('admin')->where(['user'=>$data['agent']])->find();
        if($agent){
            $data['aid'] = $agent['id'];
        }else{
            json(201,'未找到此人员信息，请修改所属制卡人员。');
        }
    }
    unset($data['agent']);
    if(!$id){ //如果充值卡id是空 则是新增充值卡
        $data = array_filter($data,'filterfunction'); //清空POST接收数据的数组中所有为空的参数
        $addsl = $data['sl'];
        if($addsl <= 0){
            $addsl = 1;
        }
        unset($data['sl']);//删除成功数量参数
        $res = DB::table('cardtype')->where(['id'=>$data['cardtype']])->find();
        if(!$res){
            json(201,'生成失败，未查询到此卡类信息');
        }
        $res['bz'] = $data['bz'];
        if($data['aid']){
            $res['aid'] = $data['aid'];
        }else{
            $res['aid'] = $userinfo['id'];
        }
        unset($data);
        $data = $res;
        $kt = $res['kt'];
        $ck = $res['length'];
        unset($data['type']);
        unset($data['id']);
        unset($data['kt']);
        unset($data['money']);
        unset($data['length']);
        $carkey = '';
        for($i=1; $i<=$addsl; $i++) {
            $data['card'] = $kt.get_str($ck,3,0);
            $data['addtime'] = date('Y-m-d H:i:s',time());
            $res = DB::table('card')->add($data);
            if($res){
                if(!$carkey){
                    $carkey = $data['card'];
                }else{
                    $carkey = $carkey.'<br>'.$data['card'];
                }
            }
        }
        json(200,$carkey);
    }
    $res = DB::table('card')->where(['id'=>$id])->update($data);
    if(!$res){
        json(201,'修改充值卡失败，请重试');
    }
    json(200,'修改充值卡成功');
?>