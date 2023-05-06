<?php
//页面全局
$MailTipsFram = <<<Fram
[content]
<center>
<p><a href="{$G['config']['weburl']}" style="display:inline-block;padding:4px 30px;border-radius:1px;color:#0083ff;border:2px solid #0083ff;text-decoration:none;margin-top:20px;box-shadow: 1px 1px 2px #888888;" target="_blank">查询中心</a>&nbsp;  <a href="http://wpa.qq.com/msgrd?v=3&uin={$G['config']['adminqq']}&site=qq" style="display:inline-block;padding:4px 25px;border-radius:1px;color:#0083ff;border:2px solid #0083ff;text-decoration:none;margin-top:20px;box-shadow: 1px 1px 2px #888888;" target="_blank">联系客服</a></p>

<small><p>Powered by {$_SERVER['HTTP_HOST']}</p></small></center>
Fram;

//内容+标题模板行
$MailTipsCon = <<<CON
<div style="box-shadow: 1px 1px 2px #888888;background:#fbfbfb;padding:10px 20px;font-size:12px;border-left:3px solid #0083ff;margin-top:20px;">
[content]
</div>
CON;

//内容行
$MailTipsLine = <<<Lin
[content]<br>
Lin;


