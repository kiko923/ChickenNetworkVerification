<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>软件信息</title>
  <meta name="renderer" content="webkit">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <link rel="stylesheet" href="../layuiadmin/layui/css/layui.css" media="all">
</head>
<body>
    <div class="layui-card-body" >
        <form class="layui-form layui-form-pane" lay-filter="layuiadmin-form-admin">
          <div class="layui-tab layui-tab-card">
            <ul class="layui-tab-title">
              <li class="layui-this">基础配置</li>
              <li class="">安全配置</li>
              <li>注册配置</li>
              <li>其他配置</li>
              <li>静态数据</li>
            </ul>
            <div class="layui-tab-content" style="padding: 10px 10px 0 10px;">
              <div class="layui-tab-item layui-show">
              <div class="layui-form-item">
                  <label class="layui-form-label">软件名称</label>
                  <div class="layui-input-block">
                    <input type="text" name="name" lay-verify="required" placeholder="必填" autocomplete="off" class="layui-input">
                  </div>
              </div>
              <div class="layui-form-item">
                <label class="layui-form-label">服务状态</label>
                <div class="layui-input-block">
                  <select name="orcheck">
                    <option value=""></option>
                    <option value="0">停服维护</option>
                    <option value="3">免费模式</option>
                    <option value="1">计时模式</option>
                    <option value="4">计点模式(每天自动扣除1点)</option>
                    <option value="2">扣点模式(手动调用接口扣点)</option>
                  </select>
                </div>
              </div>

            <div class="layui-form-item">
            <label class="layui-form-label">登录方式</label>
            <div class="layui-input-block">
              <select name="dl_type">
                <option value=""></option>
                <option value="0">账号密码</option>
                <option value="1">充值卡</option>
                <option value="2">QQ号</option>
                <option value="3">域名</option>
                <option value="4">设备码</option>
                <option value="5">设备IP</option>
                <option value="6">标识(自定义)</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">绑定模式</label>
            <div class="layui-input-block">
              <select name="bd_type">
                <option value=""></option>
                <option value="0">不绑定</option>
                <option value="1">设备码</option>
                <option value="2">设备IP</option>
              </select>
            </div>
          </div>

            <div class="layui-form-item">
            <label class="layui-form-label">注册模式</label>
            <div class="layui-input-block">
              <select name="zc_type">
                <option value=""></option>
                <option value="0">关闭注册</option>
                <option value="1">完全开放</option>
                <option value="2">需充值卡</option>
                <option value="3">设备码唯一</option>
                <option value="4">设备IP唯一</option>
              </select>
            </div>
            </div>
          <div class="layui-form-item">
            <label class="layui-form-label">强制登录</label>
            <div class="layui-input-block">
              <select name="dl_type2">
                <option value=""></option>
                <option value="0">关闭</option>
                <option value="1">开启</option>
              </select>
            </div>
          </div>

            <div class="layui-form-item">
            <label class="layui-form-label">自助换绑</label>
            <div class="layui-input-block">
              <select name="hb_type">
                <option value=""></option>
                <option value="1">开启</option>
                <option value="0">关闭</option>
              </select>
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">换绑扣时</label>
            <div class="layui-input-block">
              <input type="text" name="hb_ks" placeholder="可留空,留空默认为0,单位:分钟" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <label class="layui-form-label">换绑扣分</label>
            <div class="layui-input-block">
              <input type="text" name="hb_ks1" placeholder="可留空,留空默认为0" class="layui-input">
            </div>
          </div>
          <div class="layui-form-item">
            <blockquote class="layui-elem-quote" style="color:grey;">此处设置的公告为获取软件初始化接口返回的公告，非公告管理内的公告配置。</blockquote>
          </div>
          <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">公告内容</label>
            <div class="layui-input-block">
              <textarea type="text" name="notice" autocomplete="off" class="layui-textarea" style="height:100px;"></textarea>
            </div>
          </div>
                  <div class="layui-form-item layui-hide" >
                      <input type="button" lay-submit lay-filter="LAY-user-front-submit" id="LAY-user-back-submit" value="确认">
                  </div>

              </div>
              <div class="layui-tab-item">
                <div class="layui-form-item">
                  <label class="layui-form-label">数据传输</label>
                  <div class="layui-input-block">
                    <select name="mi_type">
                      <option value=""></option>
                      <option value="0">明文</option>
                      <option value="1">rc4</option>
                      <option value="2">rsa2</option>
                      <option value="3">base64</option>
                      <option value="4">自定义</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">回复格式</label>
                  <div class="layui-input-block">
                    <select name="return_type">
                      <option value=""></option>
                      <option value="0">json</option>
                      <option value="1">xml</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">数据签名</label>
                  <div class="layui-input-block">
                    <select name="mi_sign">
                      <option value=""></option>
                      <option value="0">不验签名</option>
                      <option value="1">验证签名</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">客户端签名</label>
                  <div class="layui-input-block">
                    <input type="text" name="khd_sign" class="layui-input" placeholder="客户端的签名算法，留空默认[data]123[key]456">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">服务端签名</label>
                  <div class="layui-input-block">
                    <input type="text" name="fwd_sign" class="layui-input" placeholder="服务端的签名算法，留空默认[data]567[key]789">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">校验md5</label>
                  <div class="layui-input-block">
                    <select name="md5_check">
                      <option value=""></option>
                      <option value="0">关闭</option>
                      <option value="1">开启</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">心跳时间</label>
                  <div class="layui-input-block">
                    <input type="text" name="xttime" class="layui-input" placeholder="留空默认60秒超时">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">软件密钥</label>
                  <div class="layui-input-block">
                    <input type="text" name="appkey" placeholder="可留空,留空自动生成" autocomplete="off" class="layui-input">
                  </div>
                </div>

                <div class="layui-form-item">
                  <blockquote class="layui-elem-quote" style="color:grey;">当数据传输选择为RC4时只需填写RC4秘钥，为RSA2时请填写公钥和私钥。</blockquote>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">RC4秘钥</label>
                  <div class="layui-input-block">
                    <input type="text" name="mi_rc4_key" class="layui-input" placeholder="数据RC4加密时自动生成">
                  </div>
                </div>
                <div class="layui-form-item layui-form-text">
                  <label class="layui-form-label">RSA2公钥</label>
                  <div class="layui-input-block">
                    <textarea type="text" name="mi_rsa_public_key" autocomplete="off" class="layui-textarea" style="height:100px;"></textarea>
                  </div>
                </div>
                <div class="layui-form-item layui-form-text">
                  <label class="layui-form-label">RSA2私钥</label>
                  <div class="layui-input-block">
                    <textarea type="text" name="mi_rsa_private_key" autocomplete="off" class="layui-textarea" style="height:100px;"></textarea>
                  </div>
                </div>

              </div>
              <div class="layui-tab-item">
                <div class="layui-form-item">
                  <label class="layui-form-label">注册送时</label>
                  <div class="layui-input-block">
                    <input type="text" name="reggive" class="layui-input" placeholder="单位:分钟,留空不赠送">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">注册送分</label>
                  <div class="layui-input-block">
                    <input type="text" name="reggive1" class="layui-input" placeholder="赠送点数,留空不赠送">
                  </div>
                </div>
                <div class="layui-form-item">
                  <blockquote class="layui-elem-quote" style="color:grey;">注册组别在无卡注册或注册时卡密没有设置用户组时生效。</blockquote>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">注册组别</label>
                  <div class="layui-input-block">
                    <select id="grouplist" name="gid" lay-search></select>
                  </div>
                </div>
                  <div class="layui-form-item">
                      <label class="layui-form-label">注册送卡</label>
                      <div class="layui-input-block">
                          <select id="cardtype" name="ctid" lay-search></select>
                      </div>
                  </div>
                <div class="layui-form-item">
                  <blockquote class="layui-elem-quote" style="color:grey;">注册时需同时满足了两种条件，才会不再赠送。</blockquote>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">赠送限制</label>
                  <div class="layui-input-block">
                    <select name="rgtype">
                      <option value=""></option>
                      <option value="0">关闭</option>
                      <option value="1">开启</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">IP限制</label>
                  <div class="layui-input-block">
                    <input type="text" name="regip" class="layui-input" placeholder="每个IP允许试用几次">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">设备限制</label>
                  <div class="layui-input-block">
                    <input type="text" name="regmac" class="layui-input" placeholder="每台设备允许试用几次">
                  </div>
                </div>
              </div>
              <div class="layui-tab-item">
                <div class="layui-form-item">
                  <blockquote class="layui-elem-quote" style="color:grey;">推荐功能的提成时间和提成点数为百分比模式，当你推荐的人使用了充值卡充值时，你可以获得百分比的时间和点数赠送。 </blockquote>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">推荐功能</label>
                  <div class="layui-input-block">
                    <select name="tjtype">
                      <option value=""></option>
                      <option value="0">关闭</option>
                      <option value="1">开启</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">更改推荐</label>
                  <div class="layui-input-block">
                    <select name="tjup">
                      <option value=""></option>
                      <option value="0">关闭</option>
                      <option value="1">开启</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">提成时间</label>
                  <div class="layui-input-block">
                    <input type="text" name="tj_bl1" class="layui-input" placeholder="推荐人获得时间提成百分比">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">提成点数</label>
                  <div class="layui-input-block">
                    <input type="text" name="tj_bl2" class="layui-input" placeholder="推荐人获得点数提成百分比">
                  </div>
                </div>
                <hr class="layui-bg-cyan">
                  <div class="layui-form-item">
                      <blockquote class="layui-elem-quote" style="color:grey;">注册账户时限制的账号长度和密码长度。</blockquote>
                  </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">账号长度</label>
                  <div class="layui-input-block">
                    <input type="text" name="cd_zh" class="layui-input" placeholder="注册账号长度最少位数">
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label">密码长度</label>
                  <div class="layui-input-block">
                    <input type="text" name="cd_mm" class="layui-input" placeholder="注册密码长度最少位数">
                  </div>
                </div>
                <hr class="layui-bg-cyan">
                  <div class="layui-form-item">
                      <label class="layui-form-label"><a tabindex="-1" href="javascript:;" onclick="layer.alert('<b>可填写固定积分值或范围型积分值</b><br>填写:1,获得积分固定为1<br>填写:1~3,获得的积分在1到3积分之间.',{title:'提示'})"><i class="layui-icon layui-icon-help text-gray" style="color:red"></i></a>签到积分</label>
                      <div class="layui-input-block">
                          <input type="text" name="qdjf" class="layui-input" placeholder="每日签到获得的积分">
                      </div>
                  </div>
                <div class="layui-form-item">
                  <label class="layui-form-label"><a tabindex="-1" href="javascript:;" onclick="layer.alert('开启后，不同用户组的卡密可以混充.',{title:'提示'})"><i class="layui-icon layui-icon-help text-gray" style="color:dodgerblue"></i></a>卡密混充</label>
                  <div class="layui-input-block">
                    <select name="check_hc">
                      <option value=""></option>
                      <option value="0">关闭</option>
                      <option value="1">开启</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label"><a tabindex="-1" href="javascript:;" onclick="layer.alert('心跳成功是否记录成功日志(接口记录同步关闭).',{title:'提示'})"><i class="layui-icon layui-icon-help text-gray" style="color:dodgerblue"></i></a>心跳日志</label>
                  <div class="layui-input-block">
                    <select name="jl_xt">
                      <option value=""></option>
                      <option value="0">不记录</option>
                      <option value="1">记录</option>
                    </select>
                  </div>
                </div>
                <div class="layui-form-item">
                  <label class="layui-form-label"><a tabindex="-1" href="javascript:;" onclick="layer.alert('关闭后心跳日志也会同时关闭(接口记录同步关闭).',{title:'提示'})"><i class="layui-icon layui-icon-help text-gray" style="color:dodgerblue"></i></a>软件日志</label>
                  <div class="layui-input-block">
                    <select name="jl_sy">
                      <option value=""></option>
                      <option value="0">不记录</option>
                      <option value="1">记录</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="layui-tab-item">
                <div class="layui-form-item">
                  <blockquote class="layui-elem-quote" style="color:grey;">静态数据为获取软件初始化接口返回的数据，可放置一些非关键数据。</blockquote>
                </div>
                <div class="layui-form-item layui-form-text">
                  <label class="layui-form-label">静态数据</label>
                  <div class="layui-input-block">
                    <textarea type="text" name="data" autocomplete="off" class="layui-textarea" style="height:200px;"></textarea>
                  </div>
                </div>
              </div>
            </div></div>
        </form>
      </div>

  <script src="../layuiadmin/layui/layui.js"></script>  
  <script src="../layuiadmin/layui/jquery.min.js"></script>
  <script>
  layui.config({
    base: '../layuiadmin/' //静态资源所在路径
  }).extend({
    index: 'lib/index' //主入口模块
  }).use(['index', 'form', 'laydate'], function(){
    var admin = layui.admin
    ,element = layui.element
    ,layer = layui.layer
    ,laydate = layui.laydate
    ,form = layui.form;
    
    $.ajax({
        url: '../interface/ajax.php?t=admin&a=login-ck',
        type: 'POST',
        dataType: 'json',
        data: '',
        success: function (res) {
            if(res.code == '201') {
                top.location.href="login.php";  
            }
        }
    });

    var idd = GetQueryString("id");
    if (idd != null) {
        var load = layer.load();
        $.ajax({
            type:'GET',
            url:'../interface/ajax.php?t=admin&a=app-get&id=' + idd,
            dataType: 'json',
            cache: false,
            success: function (data) {
                form.val('layuiadmin-form-admin', data.msg);
                form.render();
                }
        });
        $.ajax({
          url: '../interface/ajax.php?t=admin&a=get-cardtype&id='+idd,
          type: 'POST',
          dataType: 'html',
          data: '',
          success: function (res) {
            $('#cardtype').html(res);
            form.render('select');
          },
          error: function (res) {
            layer.msg('请求失败' + res);
          }
        });
        $.ajax({
            url: '../interface/ajax.php?t=admin&a=get-usergroup&id='+idd,
            type: 'POST',
            dataType: 'html',
            data: '',
            success: function (res) {
                $('#grouplist').html(res);
                form.render('select');
            },
            error: function (res) {
                layer.msg('请求失败' + res);
            }
        });
        layer.close(load);
    }
    });
    
    function GetQueryString(name) {
        var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)");
        var r = window.location.search.substr(1).match(reg);
        if (r != null)
            return decodeURI(r[2]);
        return null;
    };
  </script>
</body>
</html>
