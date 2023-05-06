<?php

//数组过滤为where条件
function whereStr($key){
    $nums = 1;
    $str = '';
    if(is_array($key)){
        $count_key = count($key);
        foreach($key as $k=>$v){
            if($count_key == $nums){
                $str .= "$k ='$v'";
            }else{
                $str .= "$k ='$v'".' '.'and'.' ';
            }
            $nums++;
        }
        if($str != ''){
            $str = ' where '.$str;
        }
    }
    return $str;
}

//回调过滤为空的数组
function filterfunction($arr){
    if($arr == '' || $arr == null){
        return false;
    }
    return true;
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

header("content-type:text/html; charset=utf-8");

require_once '../include/config.php';
require_once '../include/core.im.php';
require_once '../include/db.class.php';
require_once '../include/function.php';
require_once '../version.php';

error_reporting(0);

session_start();
date_default_timezone_set('PRC');

define('ROOT_PATH', dirname(__FILE__));

$res = DB::table('core')->select();
foreach($res as $value){
    $G['config'][$value['config_key']] = $value['config_value'];
}

function curl_gets($url){
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
    curl_setopt($ch, CURLOPT_TIMEOUT, 1);
    $content=curl_exec($ch);
    curl_close($ch);
    return($content);
}

function moneylog($aid,$scje,$type,$xtype,$syje,$info,$glid=null){
    $date = date('Y-m-d H:i:s', time());
    $add = ['aid'=>$aid,'money'=>$scje,'type'=>$type,'x_type'=>$xtype,'syje'=>$syje,'info'=>$info,'addtime'=>$date,'glid'=>$glid];
    $rid = DB::table('moneylog')->add($add);
    return $rid;
}

if(!file_exists('../install/install.lock')) {
    json(201,'<meta http-equiv="refresh" content="1;url=../install">程序未安装，正在跳转安装界面中...');
    exit(0);
}

$act = isset($_GET['a']) ? purge($_GET['a']) : null;
$type = isset($_GET['t']) ? purge($_GET['t']) : null;

if($act && $type){
	if(file_exists($type.'/'.$act.'.php')){
	    if($act!='login' && $act!='login-ck'){
	        require $type.'/login-ck.php'; //如果接口不是登录接口或验证登录接口，则引入验证登录接口
	    }
        if($type!='admin'){
            if (is_file(ROOT. '/include/360safe/360webscan.php')) {
                require_once ROOT . '/include/360safe/360webscan.php';
            }
        }
		require $type.'/'.$act.'.php';
	}else{
        json(201,'NULL');
	}
}else{
	json(201,'NULL');
}
?>