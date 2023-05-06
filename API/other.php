<?php

header("content-type:text/html; charset=utf-8");
date_default_timezone_set('PRC');

include 'include/config.php';
include 'include/core.im.php';
include 'include/db.class.php';
include 'include/function.php';
include 'version.php';

function Arr_sign($arr,$key){//数组签名
    unset($arr['sign']);
    unset($arr['act']);
    unset($arr['appid']);
    $sign = '';
    foreach ($arr as $k => $v) {
        $sign = $sign.$k.'='.$v.'&';
    }
    $newdata = substr($sign,0,strlen($sign)-1);
    $newdata = str_replace('[data]',$newdata,$key['khd_sign']);
    $newdata = str_replace('[key]',$key['appkey'],$newdata);
    return md5($newdata);
}

function txt_Arr($txt){//文本转数组
    $arr = explode('&', $txt);
    $array = [];
    foreach($arr as $value){
        $tmp_arr = explode('=',$value);
        if(is_array($tmp_arr) && count($tmp_arr) == 2){
            $array = array_merge($array,[$tmp_arr[0]=>$tmp_arr[1]]);
        }
    }
    return $array;
}

function mi_rc4($data,$pwd,$t=0) {//t=0加密，1=解密
    $cipher = '';
    $key[] = "";
    $box[] = "";
    $pwd = mi_rc4_encode($pwd);
    $data = mi_rc4_encode($data);
    $pwd_length = strlen($pwd);
    if($t == 1){
        $data = hex2bin($data);
    }
    $data_length = strlen($data);
    for ($i = 0; $i < 256; $i++) {
        $key[$i] = ord($pwd[$i % $pwd_length]);
        $box[$i] = $i;
    }
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $key[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    for ($a = $j = $i = 0; $i < $data_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $k = $box[(($box[$a] + $box[$j]) % 256)];
        $cipher .= chr(ord($data[$i]) ^ $k);
    }
    if($t == 1){
        return $cipher;
    }else{
        return bin2hex($cipher);
    }
}

function mi_rc4_encode($str,$turn = 0){//turn=0,utf8转gbk,1=gbk转utf8
    if(is_array($str)){
        foreach($str as $k => $v){
            $str[$k] = array_iconv($v);
        }
        return $str;
    }else{
        if(is_string($str) && $turn == 0){
            return mb_convert_encoding($str,'GBK','UTF-8');
        }elseif(is_string($str) && $turn == 1){
            return mb_convert_encoding($str,'UTF-8','GBK');
        }else{
            return $str;
        }
    }
}

function RSA_SMI($data,$key,$t=0) {//RSA私钥加解密
    require_once 'include/class/Rsa.php';//引入RSA加解密类
    if(!$t){
        $mi_data = Rsa::privateEncrypt($data,$key);//使用私钥将数据加密
    }else{
        $mi_data = Rsa::privateDecrypt($data,$key);//使用私钥将数据解密
    }
    return $mi_data;
}

function mi_sign($arr,$key,$md5 = true){ //数组签名
    $sign = '';
    foreach ($arr as $k => $v) {
        $sign = $sign.$k . '='. $v .'&';
    }
    $sign = $sign.$key;
    if($md5){
        return md5($sign);
    }else{
        return $sign;
    }
}


function out($code,$msg = null,$mi = null) {
    global $khd_uuid;
    global $khd_token;
    $time = time();
    $new_token = md5($khd_token.$time);
    if($mi['return_type']==0){
        if(!is_array($msg)){
            $msgx['ret_info'] = $msg;
        }else{
            $msgx = $msg;
        }
        $jdata = array('code'=>$code,'result'=>$msgx,'uuid'=>$khd_uuid,'token'=>$new_token,'t'=>$time);
        $data = json_encode($jdata);
        if($mi && is_array($mi) && isset($mi['mi_type'])){
            if($mi['mi_type']==1){
                $data = mi_rc4($data,$mi['mi_rc4_key']);
            }elseif($mi['mi_type']==2){
                $data = RSA_SMI($data,$mi['mi_rsa_private_key'],0);
            }elseif($mi['mi_type']==3){
                $data = base64_encode($data);
            }else if($mi['mi_type'] == 4){//自定义加解密
                include 'API/encode.php';
            }else{
                $data = array('code'=>$code,'result'=>$msgx,'uuid'=>$khd_uuid,'token'=>$new_token,'t'=>$time);
            }
        }else{
            $data = array('code'=>$code,'result'=>$msgx,'uuid'=>$khd_uuid,'token'=>$new_token,'t'=>$time);
        }
        $sign = str_replace('[data]',$data,$mi['fwd_sign']);
        $sign = str_replace('[key]',$mi['appkey'],$sign);
        $sign = md5($sign);
        $rets = array('data'=>$data,'sign'=>$sign);
        echo json_encode($rets);
        exit;
    }elseif($mi['return_type']==1){
        include 'include/class/Xml.php';//引入类配置信息
        header("Content-type: text/html; charset=utf-8");
        $xml = new Array_to_Xml();//实例化类
        if(!is_array($msg)){
            $msgx['ret_info'] = $msg;
        }else{
            $msgx = $msg;
        }
        $res = array('code'=>$code,'result'=>$msgx,'uuid'=>$khd_uuid,'token'=>$new_token,'t'=>$time);
        $data = $xml->toXml($res);
        if($mi && is_array($mi) && isset($mi['mi_type'])){
            if($mi['mi_type'] ==1){
                $data = mi_rc4($data,$mi['mi_rc4_key']);
            }elseif($mi['mi_type'] ==2){
                $data = RSA_SMI($data,$mi['mi_rsa_private_key']);
            }elseif($mi['mi_type']==3){
                $data = base64_encode($data);
            }else if($mi['mi_type'] == 4){//自定义加解密
                include 'API/encode.php';
            }else{
                $data = array('code'=>$code,'result'=>$msgx,'uuid'=>$khd_uuid,'token'=>$new_token,'t'=>$time);
            }
        }else{
            $data = array('code'=>$code,'result'=>$msgx,'uuid'=>$khd_uuid,'token'=>$new_token,'t'=>$time);
        }
        $sign = str_replace('[data]',$data,$mi['fwd_sign']);
        $sign = str_replace('[key]',$mi['appkey'],$sign);
        $sign = md5($sign);
        $rets = array('data'=>$data,'sign'=>$sign);
        echo $xml->toXml($rets);
        exit;
    }
    exit;
}

if(!file_exists('install/install.lock')) {
    out(201,'您还未安装程序，请先安装。');
}

$res = DB::table('core')->select();
foreach($res as $value){
    $G['config'][$value['config_key']] = $value['config_value'];
}

$appid = isset($_GET['appid']) ? intval($_GET['appid']) : 0;//appid
$sign = isset($_POST['sign']) ? (purge($_POST['sign'])) : (isset($_GET['sign']) ? purge($_GET['sign']) : '');//数据签名 POST或GET
$data = isset($_POST['data']) ? (purge($_POST['data'])) : (isset($_GET['data']) ? purge($_GET['data']) : '');//加密数据 POST或GET

$app_res = DB::table('app')->where(['id'=>$appid])->find();
if(!$app_res){
    out(201,'软件不存在');//软件不存在
}

if($app_res['orcheck'] == 0){
    out(201,'软件维护中',$app_res);
}

if($app_res['mi_type'] == 0){//明文模式
	$data_arr = $_REQUEST;//将POST或GET数据移交给data_arr
	if($app_res['mi_sign'] == 1){//数据签名
		if($sign == '')out(201,'签名为空',$app_res);//签名为空
		$s = Arr_sign($data_arr,$app_res);//生成签名
		if($s != strtolower($sign))out(201,'签名有误',$app_res);//签名有误
	}
}else if($app_res['mi_type'] == 1){//RC4加密
	if($data=='')out(201,'数据为空',$app_res);//数据为空
    if($app_res['mi_sign'] == 1){//数据签名
        if($sign == '')out(201,'签名为空',$app_res);//签名为空
        $sign1 = str_replace('[data]',$data,$app_res['khd_sign']);
        $sign1 = str_replace('[key]',$app_res['appkey'],$sign1);
        $sign1 = md5($sign1);
        if($sign1!=strtolower($sign))out(201,'签名有误',$app_res);
    }
    $de_data = mi_rc4($data,$app_res['mi_rc4_key'],1);//RC4解密
	$data_arr = txt_Arr($de_data);//将rc4解密后的数据转为数组移交给data_arr
}else if($app_res['mi_type'] == 2){//RSA2加密
	if($data=='')out(201,'数据为空',$app_res);//数据为空
    if($app_res['mi_sign'] == 1){//数据签名
        if($sign == '')out(201,'签名为空',$app_res);//签名为空
        $sign1 = str_replace('[data]',$data,$app_res['khd_sign']);
        $sign1 = str_replace('[key]',$app_res['appkey'],$sign1);
        $sign1 = md5($sign1);
        if($sign1!=strtolower($sign))out(201,'签名有误',$app_res);
    }
    $de_data = RSA_SMI($data,$app_res['mi_rsa_private_key'],1);//RSA私钥解密
	$data_arr = txt_Arr($de_data);//将rsa解密后的数据转为数组移交给data_arr
}else if($app_res['mi_type'] == 3){//base64加密
	if($data=='')out(201,'数据为空',$app_res);//数据为空
    if($app_res['mi_sign'] == 1){//数据签名
        if($sign == '')out(201,'签名为空',$app_res);//签名为空
        $sign1 = str_replace('[data]',$data,$app_res['khd_sign']);
        $sign1 = str_replace('[key]',$app_res['appkey'],$sign1);
        $sign1 = md5($sign1);
        if($sign1!=strtolower($sign))out(201,'签名有误',$app_res);
    }
	$de_data = base64_decode($data);//base64解密
	$data_arr = txt_Arr($de_data);//将base64解密后的数据转为数组移交给data_arr
}else if($app_res['mi_type'] == 4){//自定义加解密
    if($data=='')out(201,'数据为空',$app_res);//数据为空
    if($app_res['mi_sign'] == 1){//数据签名
        if($sign == '')out(201,'签名为空',$app_res);//签名为空
        $sign1 = str_replace('[data]',$data,$app_res['khd_sign']);
        $sign1 = str_replace('[key]',$app_res['appkey'],$sign1);
        $sign1 = md5($sign1);
        if($sign1!=strtolower($sign))out(201,'签名有误',$app_res);
    }
    include 'API/decode.php';
    $data_arr = txt_Arr($de_data);//将解密后的数据转为数组移交给data_arr
}

$d = $data_arr;
$khd_uuid = isset($d['uuid']) ? purge($d['uuid']) : '';  //客户端uuid
$khd_token = isset($d['token']) ? purge($d['token']) : '';  //客户端token
$clientid = isset($d['clientid']) ? purge($d['clientid']) : ''; //客户端ID
$account = isset($d['user']) ? purge($d['user']) : '';  //用户账号
$ver = isset($d['ver']) ? purge($d['ver']) : '';  //版本号
$mac = isset($d['mac']) ? purge($d['mac']) : '';  //设备码
$ip = isset($d['ip']) ? purge($d['ip']) : '';  //设备IP
$md5 = isset($d['md5']) ? purge($d['md5']) : '';  //软件MD5

$res = DB::table('api')->where(['ec_api'=>$d['action']])->find();
if($res){
    $sl = $res['callsl'] + 1;
    DB::table('api')->where(['id'=>$res['id']])->update(['callsl'=>$sl]);
    $d['action'] = $res['in_api'];
}else{
    out(201,'接口不存在。',$app_res);
}

function insert_userlog($uid,$appid,$alid,$date,$ver,$mac,$ip,$clientid,$info){
    global $app_res;
    global $d;
    $adds = ['uid'=>$uid,'alid'=>$alid,'appid'=>$appid,'addtime'=>$date,'ver'=>$ver,'mac'=>$mac,'ip'=>$ip,'clientid'=>$clientid,'info'=>$info];
    if($app_res['jl_xt'] && $d['action']=='heartbeat'){
        DB::table('applog')->add($adds);
    }elseif($app_res['jl_sy'] && $d['action']!='heartbeat'){
        DB::table('applog')->add($adds);
    }
}

if($d['action']){
	if(file_exists('API/module/'.$d['action'].'.php')){
	    $ap['appid'] = $appid;
        $ap['apiid'] = $res['id'];
        $ap['mac'] = $mac;
        $ap['ip'] = $ip;
        $ap['ver'] = $ver;
        $ap['data'] = json_encode($data_arr);
        $ap['addtime'] = date('Y-m-d H:i:s');
        if($app_res['jl_xt'] && $d['action']=='heartbeat'){
            $alid = DB::table('apilog')->add($ap);
        }elseif($app_res['jl_sy'] && $d['action']!='heartbeat'){
            $alid = DB::table('apilog')->add($ap);
        }
        unset($ap);
		require 'API/module/'.$d['action'].'.php';
	}else{
		out(201,'接口不存在。',$app_res);
	}
}


?>