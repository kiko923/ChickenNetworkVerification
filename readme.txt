炸鸡网络验证系统
版权所有：云舒
QQ：3624867753
QQ群：650651692 

RPO1.3E [2023/02/24 14:20]
更新内容：
1.[新增]用户定制功能(取还账号,此功能适用于租号机制,和之前的定制功能的取还不同,此功能适用于选择账号租用)
2.[更新]API接口列表
3.[更新]开发文档接口
4.[优化]优化接口传输速度,基本秒响应
5.[优化]常量列表和变量列表移入高级功能菜单内
新增接口：
1.取用账号2(takegaccount2)<需登录>
2.归还账号2(stillgaccount2)<需登录>
3.取游戏账号列表(getgameaccount)<需登录>


PRO1.3D [2023/02/20 19:42]
更新内容：
1.[新增]软件配置新用户注册默认用户组(无卡注册或注册时卡密没有设置用户组时)
2.[新增]单码用户列表(更新后,后续卡密登录的用户都将自动转为单码用户)
3.[修改]注册送卡改为注册后自动充值该类型卡一张
4.[修复]代理生产卡密失败的问题
5.[修复]运营模式显示错误的问题
6.[修复]手动扣除点数后,记录错误的问题
7.[恢复]明文传输协议

PRO1.3C [2023/02/18 22:20]
更新内容：
1.[新增]卡类卡头设置
2.[新增]卡密长度设置
3.[新增]用户云端数据2(适配一些开淘宝网店的用户使用)
4.[优化]用户列表管理按钮缩减显示,可通过更多按钮来调出下拉框菜单
5.[优化]取云端信息和存云端信息更改为取云端数据和存云端数据
变更接口:
1.取用户信息接口新增推荐人信息取出
新增接口:
1.取云端数据2(getudata2)<需登录>
2.写云端数据2(setudata2)<需登录>

PRO1.3B [2023/02/12 21:34]
更新内容：
1.[新增]用户定制功能(取还游戏账号,此功能适用于租号机制)
2.[更新]API接口列表
3.[更新]开发文档接口归档更新(清晰界面)
新增接口：
1.取用账号(takegaccount)<需登录>
2.归还账号(stillgaccount)<需登录>

PRO1.3A [2023/02/07 21:06]
更新内容：
1.[新增]后台用户计点日志页面(自动计点和手动调用接口扣除)
2.[新增]登录和心跳接口新增计点的版本和软件的数据记录
3.[新增]用户积分字段(将在下个版本开放签到获得积分)
4.[新增]软件配置签到获得积分数量(软件配置其他设置页面内)
5.[修复]用户列表和卡密列表界面搜索显示页面的问题

PRO1.3 [2023/02/03 11:50]
更新内容：
1.[新增]API接口自定义加解密算法(需后台编写加解密算法,高级功能->自定义加解密)
2.[新增]软件冻结功能(冻结时软件不可登录,在线用户将会自动离线,解除冻结后该软件下的所有用户将会自动获得该软件冻结时间的使用时间,例如:冻结了10分钟,在软件解除冻结后,该软件下所有用户都会赠送10分钟的时间)
3.[新增]接口限制,大部分接口在软件冻结时不可使用,都会提示软件维护中
4.[优化]添加软件界面
5.[删除]暂时屏蔽防火墙页面(暂未开启)

PRO1.2 [2023/02/02 22:27]
更新内容：
1.[新增]计点模式服务方式,每天登录只扣1点数,多次登录不会重复扣除
2.[新增]临时性&永久性云变量功能(如何使用请自行决定)
3.[优化]管理登录页和代理登录页面
4.[优化]扣点模式服务方式,需手动调用扣点接口,调用几次扣除几次
5.[重构]管理后台和代理后台文件,由html更改为php
6.[重构]管理后台和代理后台登录验证机制,同时修改登录过期时间为1天
7.[优化]站点套cdn后导致客户端登陆后偶现的异常掉线
8.[重构]云端变量改为云端常量(本身此功能无法通过接口修改,只能读取)
9.[优化]开发文档重做
10.[修复]接口文件漏洞
重构接口：
1.取云常量接口名由variable改为constant(老接口不会删除,请勿在后台删除老接口名,删除后无法重新添加且软件调用报错)
新增接口：
1.取云变量(getvariable)<需登录>
2.写云变量(setvariable)此接口会检测是否存在此变量名,如果不存在此变量则会自动创建<需登录>
3.删云变量(delvariable)不管是否存在此变量都会返回删除成功<需登录>

(PRO版本以前全部变更为免费版)

V2.1.130免费版
1.[新增]云计算自定义函数1(需登录)
2.[新增]云计算自定义函数2(无需登录)
3.[新增]数据转发功能和接口(无需登录)
4.[新增]数据封包一次性过期
5.[新增]计点模式(自动)服务方式,每天登录只扣1点数,多次登录不会重复扣除(该功能将在下个版本开放)
6.[重构]返回数据封包
7.[重构]接口文件
8.[修正]已知问题

V1.0.206免费版
1.[新增]云计算自定义函数(接口待下个版本开放)
2.[修正]已知BUG

V1.0.205免费版
1.[新增]RSA2加解密通讯
2.[新增]易语言模块完善四种方式对接
3.[优化]修改应用改名为软件
4.[优化]修改所有接口名称由应用改名为软件(需手动重新初始化一次)

V1.0.204免费版
1.[修正]已知BUG
2.[新增]接口总开关(软件编辑->其他设置)
3.[新增]心跳记录,关闭后同时关闭记录接口数据
4.[新增]充值卡查询条件(卡名称/制卡人)

V1.0.203免费版
1.新增软件卡密混充开关(不同会员组可混充)
2.新增卡类会员组设置(当会员的会员组与卡密设置会员组不同时,不可充值)
3.新增已生成的卡密会员组设置
4.新增充值记录内卡密会员组的显示

V1.0.202免费版
1.新增自定义会员组分组
2.新增会员可绑定会员组
3.新增回车键登录
4.新增卡类时间点击选择填写

V1.0.201免费版
1.管理后台和代理后台登录新增验证码校验
2.新增检测更新页面
3.新增心跳成功日志是否记录
4.新增记录数据接口,可记录客户端用户操作的一些记录等(自由发挥记录)
5.新增子代权限组开通价格和开通下级折扣
6.初始化接口只会新增不存在的未加密的接口,不会重复增加已有接口
7.修正管理后台控制台页面代理数量不统计问题
8.修正添加用户组时,不显示颜色选择器的问题

V2.0.4(20221024)
1.更改程序内核
2.修正已知BUG

V2.0.2(20221023)
1.软件点数模式开启
2.软件免费模式开启
3.新增扣除点数(deductpoints)接口
4.易语言模块新增函数(到期检测_从缓存),该函数不调用任何接口
5.新增推荐人更改开关(软件设置面板)
6.新增注册账号/注册密码长度限制(软件设置面板)
7.修正已知BUG

V2.0.1(20221023)
1.注册赠送限制功能配置
2.推荐人功能
3.注册接口(reg)增加推荐人参数
4.新增推荐人绑定接口(bindreferrer)
5.充值接口(recharge)更新推荐人提成机制

V2.0(20221022)
1.代理功能(订阅版功能)
    1> 代理无限上下级
    2> 代理可编辑下级
    3> 代理可管理/查看名下授权
    4> 代理可管理/查看名下授权在线
    5> 代理可管理/查看名下卡密
    6> 代理可查看名下卡密充值记录
    7> 代理可查看名下代理的消费返利明细
    8> 代理退卡将会扣除当时生成此卡时获得返利金额的代理的余额
    9> 代理可查看自己自己账户消费和获得&扣除返利的明细
    10> 代理下级返利&返利扣除明细可查看关联的下级代理的消费记录
    11> 代理可在后台通过选择卡类，直接添加授权账户
    12> 代理可在后台设置下级代理的授权软件
2.换绑信息接口增加换绑传入的新信息是否完全一致，完全一致将不修改且提示无需修改
3.软件列表界面将显示每个软件的用户量和在线量
4.用户组可自定义名称颜色
4.修正易语言模块已知问题

V1.31(20221015)
1.初始化接口、登录接口、心跳接口新增自动检测新版本机制，如有新版本且强制更新模式，则接口回复201状态码并提示版本过期
2.修正所有已知BUG

V1.3(20221014)
1.新增API接口文档(非易语言用户请自行封装接口)
2.取软件信息接口和登录接口新增系统自动黑名单检测
3.新增添加黑名单接口、验证程序MD5接口
4.后台接口更名（查询云黑数据->查询黑名单）
5.重构API接口数据结构[以后不再变动]，更新后必须使用V1.3版本及以上的模块
6.修正所有已知BUG

V1.2(20221013)
1.更新接口文件,接口返回的数据改为全加密(原返回数据为只msg加密)。
2.修正部分服务器搭建登录后提示error问题。
3.修正部分API接口的已知问题。

V1.1(20221011)
1.新增rsa类文件自行构建
2.新增换绑信息接口扣除点数和时间的设置

V1.1(20221010)
1.更新所有接口文件。
2.更新数据库类文件。
3.修正注册接口注册IP错误录入为设备码的问题。

V1.0(20221007)
1.基础核心完成
2.易语言模块制作完成(仅适用于RC4加解密)
3.新增人员管理功能
4.新增卡类管理功能
5.卡密生产直接关联选择卡类
6.新增接口调用数据记录(入参原始数据)
7.新增接口调用日志记录(回复成功失败等返回数据)
8.新增接口管理功能
9.新增Base64加解密
10.新增xml数据格式返回