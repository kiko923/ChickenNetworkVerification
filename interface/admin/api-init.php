<?php
/**
 * 接口：初始化接口
 * 时间：2022-08-22 09:08
 */

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$arr_api = array(
    '用户注册' => 'reg',
    '用户登录' => 'login',
    '用户充值' => 'recharge',
    '换绑信息' => 'binding',
    '更改密码' => 'uppwd',
    '注销登录' => 'logout',
    '在线心跳' => 'heartbeat',
    '验证授权' => 'checkauth',
    '扣除点数' => 'deductpoints',
    '取用户信息' => 'getuser',
    '取软件信息' => 'init',
    '取软件公告' => 'notice',
    '取版本信息' => 'ver',
    '日志记录' => 'addlog',
    '数据转发' => 'relay',
    '取云常量' => 'constant',
    '取云变量' => 'getvariable',
    '写云变量' => 'setvariable',
    '删云变量' => 'delvariable',
    '取云端数据' => 'getudata',
    '存云端数据' => 'setudata',
    '取云端数据2' => 'getudata2',
    '存云端数据2' => 'setudata2',
    '验证软件MD5' => 'md5',
    '调用云计算1' => 'callPHP',
    '调用云计算2' => 'callPHP2',
    '查询黑名单' => 'getblack',
    '添加黑名单' => 'setblack',
    '绑定推荐人' => 'bindreferrer',
    '取用账号' => 'takegaccount',
    '归还账号' => 'stillgaccount',
    '取用账号2' => 'takegaccount2',
    '归还账号2' => 'stillgaccount2',
    '取游戏账号列表' => 'getgameaccount'
);
        
    foreach($arr_api as $key => $value){
        $res = DB::table('api')->where(['name'=>$key,'in_api'=>$value,'type'=>0])->find();
        if(!$res){
            $data['name'] = $key;
            $data['ec_api'] = $value;
            $data['in_api'] = $value;
            $data['addtime'] = date('Y-m-d H:i:s',time());
            DB::table('api')->add($data);
        }
        unset($res);
	}
    
    json(200,'初始化接口成功。');

?>