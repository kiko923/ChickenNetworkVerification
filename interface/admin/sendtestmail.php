<?php

if($myurl != $_SERVER['SERVER_NAME']){ //拦截未通过认证的调用
    header("content-type:text/html; charset=utf-8");
    $udata = array('code'=>201,'msg'=>'null');
    $jdata = json_encode($udata);
    die($jdata);
}

$udata = $_POST;
    $s_title = isset($udata['title']) ? $udata['title'] : '测试邮件';
    $s_content = isset($udata['content']) ? $udata['content'] : '如果您已收到此邮件则代表邮件系统配置正常！';
    $T['title'] = '测试邮件';
    $T['content'][] = '如果您已收到此邮件则代表邮件系统配置正常！';
    $MailTips[] = $T;
    if (!SendTipsMail($G['config']['SMTP_User'],$MailTips,$back)){
        json(201,'请求超时或返回的数据解析失败：'.$back);
    }else{
		json(200,'邮件已发送至您开通授权时候设置的站长邮箱，请检查收件箱和垃圾箱是否已收到文件');
    }

?>