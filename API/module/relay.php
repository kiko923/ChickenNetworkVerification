<?php
if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}
function url_get($url){
    $ch=curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT , 7);
    curl_setopt($ch, CURLOPT_TIMEOUT, 7);
    $content=curl_exec($ch);
    curl_close($ch);
    return($content);
}
function url_post($url,$post_data) {
    $postdata = http_build_query($post_data);
    $options = array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-type:application/x-www-form-urlencoded',
            'content' => $postdata,
            'timeout' => 7 // 超时时间（单位:s）
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    return $result;
}
$urldata = http_build_query($d);
$relay_url = DB::table('core')->where(['config_key'=>'relay_url'])->find();
$relay_type = DB::table('core')->where(['config_key'=>'relay_type'])->find();
$urls = $relay_url['config_value'];
if($relay_type['config_value']==1){
    $rtdata = url_post($urls,$urldata);
}else{
    $rtdata = url_get($urls.'?'.$urldata);
}
out(200,$rtdata,$app_res);
?>