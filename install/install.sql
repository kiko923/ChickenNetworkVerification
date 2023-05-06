CREATE TABLE `ty_admin` (
  `id` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pwd` varchar(50) DEFAULT 'e10adc3949ba59abbe56e057f20f883e',
  `logintime` datetime DEFAULT NULL,
  `addtime` datetime DEFAULT NULL,
  `cookie` varchar(50) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT '1' COMMENT '0管理员 1代理商',
  `money` varchar(50) DEFAULT '0.00' COMMENT '余额',
  `gid` varchar(10) DEFAULT NULL,
  `consume` varchar(50) DEFAULT '0.00' COMMENT '消费',
  `aid` int(11) DEFAULT NULL,
  `zt` int(11) DEFAULT '1',
  `bz` text,
  `appsid` text COMMENT '授权软件id集'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_api` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` int(11) DEFAULT '0',
  `ec_api` varchar(255) NOT NULL,
  `in_api` varchar(255) NOT NULL,
  `callsl` int(11) DEFAULT '0',
  `addtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_apilog` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `apiid` int(11) NOT NULL,
  `addtime` datetime NOT NULL,
  `mac` varchar(255) DEFAULT NULL,
  `ip` varchar(255) DEFAULT NULL,
  `ver` varchar(255) DEFAULT NULL,
  `data` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_app` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `appkey` text NOT NULL COMMENT '识别码',
  `orcheck` int(11) DEFAULT '1' COMMENT '1收费运营 2积分运营 3免费运营 0停服维护',
  `mi_type` int(11) DEFAULT '0' COMMENT '0:明文 1:rc4 2:rsa2',
  `mi_sign` int(11) DEFAULT '0' COMMENT '0:不验签名 1:验证签名',
  `xttime` int(11) DEFAULT '180' COMMENT '心跳超时时间',
  `dl_type2` int(11) DEFAULT '0' COMMENT '0:离线登录 1:强制登录',
  `dl_type` int(11) DEFAULT '0' COMMENT '0:账号密码 1:充值卡 2:QQ号 3:域名 4:设备码 5:设备IP 6:标识(自定义)',
  `bd_type` int(11) DEFAULT '0' COMMENT '0:不绑定 1:设备码 2:设备IP',
  `zc_type` int(11) DEFAULT '1' COMMENT '0关闭注册 1完全开放 2需充值卡 3设备码唯一 4设备IP唯一',
  `hb_type` int(11) DEFAULT '0' COMMENT '0:禁止换绑 1:可换绑',
  `hb_ks` int(11) DEFAULT '0' COMMENT '换绑扣时',
  `hb_ks1` int(11) DEFAULT '0' COMMENT '换绑扣分',
  `md5_check` int(11) DEFAULT '0' COMMENT '0:不校验md5 1:校验md5',
  `reggive` varchar(20) DEFAULT '0' COMMENT '注册赠送时间',
  `reggive1` varchar(20) DEFAULT '0',
  `ctid` varchar(20) DEFAULT '0',
  `rgtype` varchar(20) DEFAULT '0',
  `regip` varchar(20) DEFAULT NULL,
  `regmac` varchar(20) DEFAULT NULL,
  `mi_rc4_key` text COMMENT 'rc4密钥',
  `mi_rsa_private_key` text COMMENT 'rsa2私钥',
  `mi_rsa_public_key` text COMMENT 'rsa2公钥',
  `notice` text COMMENT '公告内容',
  `data` text,
  `return_type` int(11) DEFAULT '0',
  `tjtype` varchar(20) DEFAULT '0',
  `tjup` varchar(20) DEFAULT '0' COMMENT '修改推荐人',
  `tj_bl1` varchar(20) DEFAULT NULL COMMENT '推荐人赠送时间比例',
  `tj_bl2` varchar(20) DEFAULT NULL COMMENT '推荐人赠送积分比例',
  `cd_zh` varchar(20) DEFAULT '6',
  `cd_mm` varchar(20) DEFAULT '6',
  `jl_xt` varchar(5) DEFAULT '1' COMMENT '心跳成功记录 0关闭 1开启',
  `jl_sy` varchar(20) DEFAULT '1' COMMENT '记录所有接口日志',
  `check_hc` varchar(20) DEFAULT '0',
  `khd_sign` varchar(255) DEFAULT '[data]123[key]456',
  `fwd_sign` varchar(255) DEFAULT '[data]567[key]789',
  `djsj` datetime DEFAULT NULL,
  `djzt` int(11) NOT NULL DEFAULT '0',
  `qdjf` varchar(50) DEFAULT '1',
  `gid` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_applog` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `alid` int(11) DEFAULT NULL COMMENT 'api日志id',
  `appid` int(11) NOT NULL,
  `addtime` datetime NOT NULL,
  `ver` varchar(20) DEFAULT NULL,
  `mac` varchar(50) DEFAULT NULL,
  `ip` varchar(50) DEFAULT NULL,
  `clientID` varchar(50) DEFAULT NULL,
  `info` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_black` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0账号 1设备码 2设备IP 3自定义',
  `data` varchar(100) NOT NULL,
  `bz` text,
  `addtime` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_card` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `appid` int(11) NOT NULL,
  `gid` varchar(20) DEFAULT NULL,
  `card` varchar(255) NOT NULL,
  `rgtime` int(11) DEFAULT '0' COMMENT '单位:分钟',
  `rgpoint` int(11) DEFAULT '0',
  `dk` int(11) DEFAULT '1',
  `second` int(11) DEFAULT '1',
  `addtime` datetime NOT NULL,
  `data` text COMMENT '自定义参数',
  `aid` int(11) DEFAULT NULL COMMENT '生成卡人id,留空为作者',
  `bz` varchar(255) DEFAULT NULL,
  `scje` varchar(20) DEFAULT NULL COMMENT '代理生成金额',
  `flje` varchar(20) DEFAULT NULL COMMENT '返利金额',
  `flid` varchar(20) DEFAULT NULL COMMENT '返利id',
  `type` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_cardlog` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `appid` int(11) NOT NULL,
  `gid` varchar(20) DEFAULT NULL,
  `uid` int(11) NOT NULL,
  `card` varchar(50) NOT NULL,
  `rgtime` int(11) DEFAULT NULL,
  `rgpoint` int(11) DEFAULT NULL,
  `dk` int(11) DEFAULT '1',
  `aid` int(11) DEFAULT NULL,
  `addtime` datetime NOT NULL,
  `data` text,
  `bz` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_cardtype` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `appid` int(11) NOT NULL,
  `gid` varchar(20) DEFAULT NULL,
  `kt` varchar(50) DEFAULT NULL COMMENT '卡头',
  `rgtime` int(11) DEFAULT '0' COMMENT '单位:分钟',
  `rgpoint` int(11) DEFAULT '0',
  `dk` int(11) DEFAULT '1',
  `second` int(11) DEFAULT '1',
  `addtime` datetime NOT NULL,
  `data` text COMMENT '自定义参数',
  `type` int(11) DEFAULT '0' COMMENT '0代理不可用 1代理可用',
  `money` varchar(50) NOT NULL COMMENT '制卡价格',
  `length` int(11) DEFAULT '18'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_core` (
  `id` int(11) NOT NULL,
  `config_key` varchar(50) NOT NULL,
  `config_value` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_gameaccount` (
  `id` int(11) NOT NULL,
  `c1` varchar(100) DEFAULT NULL COMMENT '游戏账号',
  `c2` varchar(100) DEFAULT NULL COMMENT '游戏密码',
  `c3` varchar(100) DEFAULT NULL COMMENT '授权文件名',
  `c4` varchar(100) DEFAULT NULL COMMENT '所属游戏',
  `zt` int(11) DEFAULT '0' COMMENT '0未占用 1占用',
  `cs` int(11) DEFAULT '0' COMMENT '取用次数'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ty_gameaccount2` (
  `id` int(11) NOT NULL,
  `c1` varchar(100) DEFAULT NULL COMMENT '账号',
  `c2` varchar(100) DEFAULT NULL COMMENT '密码',
  `c3` varchar(100) DEFAULT NULL COMMENT '授权邮箱',
  `c4` varchar(100) DEFAULT NULL COMMENT '邮箱密码',
  `c5` varchar(100) DEFAULT NULL COMMENT '所属游戏',
  `c6` text COMMENT '账号介绍',
  `c7` text COMMENT '附加信息',
  `zt` int(11) DEFAULT '0' COMMENT '0正常 1占用 2锁定',
  `cs` int(11) DEFAULT '0' COMMENT '租用次数',
  `zuser` varchar(50) DEFAULT NULL COMMENT '最后租用账号'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ty_goods` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `zt` int(11) DEFAULT '0' COMMENT '0正常 1停售',
  `type` int(11) DEFAULT '0' COMMENT '0发卡 1直充 2代理充值',
  `cid` int(11) DEFAULT NULL COMMENT '充值卡类id',
  `money` varchar(50) NOT NULL DEFAULT '0.00',
  `quota` int(11) DEFAULT '0' COMMENT '0不限 限购数量',
  `quota1` int(11) DEFAULT '1' COMMENT '当限购数量打开后,此处的限购数量为每位用户的限购数量',
  `addtime` datetime DEFAULT NULL,
  `sale` varchar(50) DEFAULT '0' COMMENT '销量',
  `color` varchar(50) DEFAULT NULL COMMENT '商品名颜色',
  `introduce` text COMMENT '商品介绍'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `ty_group` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(20) DEFAULT '#2d3032',
  `level` varchar(50) DEFAULT '0' COMMENT '制卡折扣%',
  `rebate` varchar(50) DEFAULT NULL COMMENT '返利比例%',
  `ktjg` varchar(20) DEFAULT NULL COMMENT '开通价格',
  `ktzk` varchar(20) DEFAULT NULL COMMENT '开通折扣',
  `adds` int(11) DEFAULT '0',
  `addtime` datetime NOT NULL,
  `groupsid` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_heartbeat` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `clientid` varchar(50) NOT NULL,
  `hbtime` datetime NOT NULL,
  `logintime` datetime NOT NULL,
  `appid` int(11) NOT NULL,
  `ver` varchar(50) NOT NULL,
  `mac` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_kdlog` (
  `id` int(11) NOT NULL,
  `uid` varchar(20) DEFAULT NULL,
  `mac` varchar(50) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `clientid` varchar(100) DEFAULT NULL,
  `kdsj` date NOT NULL,
  `addtime` datetime NOT NULL,
  `appid` int(11) NOT NULL,
  `kdsl` varchar(20) DEFAULT '1',
  `ver` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_md5` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `ver` varchar(50) NOT NULL,
  `md5` varchar(50) NOT NULL,
  `addtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_moneylog` (
  `id` int(11) NOT NULL,
  `aid` int(11) NOT NULL COMMENT '所属id',
  `x_type` int(11) NOT NULL DEFAULT '1' COMMENT '0减扣 1增加',
  `money` varchar(20) DEFAULT NULL COMMENT '金额',
  `addtime` datetime NOT NULL COMMENT '消费时间',
  `type` int(11) NOT NULL COMMENT '0转账 1制卡 2加授权 3下级返利 4退卡 5返利扣除 6开通下级',
  `glid` varchar(20) DEFAULT NULL COMMENT '返利关联id',
  `syje` varchar(50) NOT NULL COMMENT '代理剩余金额',
  `info` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_notice` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `notice_title` varchar(255) NOT NULL,
  `notice_info` text NOT NULL,
  `addtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_user` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `user` varchar(50) NOT NULL,
  `pwd` varchar(50) DEFAULT 'e10adc3949ba59abbe56e057f20f883e' COMMENT '二级密码，可用于登录或修改授权账号',
  `endtime` datetime DEFAULT NULL,
  `point` varchar(50) DEFAULT '0',
  `mac` varchar(50) DEFAULT NULL COMMENT '绑定设备',
  `ip` varchar(50) DEFAULT NULL COMMENT '绑定IP',
  `dk` int(11) DEFAULT '1',
  `zt` int(11) DEFAULT '1' COMMENT '1正常 0封禁',
  `reason` text,
  `email` varchar(50) DEFAULT NULL COMMENT '绑定邮箱',
  `ver` varchar(50) DEFAULT NULL COMMENT '最后登录版本',
  `aid` int(11) DEFAULT NULL COMMENT '代理id',
  `logintime` datetime DEFAULT NULL,
  `addtime` datetime NOT NULL,
  `data` text COMMENT '附加数据',
  `data2` text COMMENT '云端存储数据',
  `data3` text COMMENT '云端存储数据',
  `userqq` varchar(20) DEFAULT NULL,
  `rgmac` varchar(50) DEFAULT NULL,
  `rgip` varchar(50) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `tid` varchar(20) DEFAULT NULL COMMENT '推荐人id',
  `gid` varchar(20) DEFAULT NULL,
  `integral` varchar(50) DEFAULT '0' COMMENT '积分',
  `iscode` int(11) DEFAULT '0' COMMENT '是否单码用户'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_usergroup` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `color` varchar(20) DEFAULT '#2d3032',
  `data` text,
  `addtime` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_variable` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `cloud_key` varchar(255) NOT NULL,
  `cloud_value` text NOT NULL,
  `islogin` int(11) DEFAULT '0',
  `addtime` datetime NOT NULL,
  `callsl` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `ty_variable1` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `cloud_key` varchar(255) NOT NULL,
  `cloud_value` text NOT NULL,
  `addtime` datetime NOT NULL,
  `callsl` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `ty_ver` (
  `id` int(11) NOT NULL,
  `appid` int(11) NOT NULL,
  `current_ver` varchar(100) NOT NULL,
  `new_ver` varchar(100) DEFAULT NULL,
  `type` int(11) NOT NULL DEFAULT '0' COMMENT '0选择更新 1强制更新',
  `update_time` datetime DEFAULT NULL,
  `update_url` text,
  `update_info` text,
  `update_text` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `ty_admin`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_api`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_apilog`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_app`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_applog`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_black`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_card`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_cardlog`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_cardtype`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_core`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_gameaccount`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_gameaccount2`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_goods`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_group`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_heartbeat`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_kdlog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_md5`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_moneylog`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_notice`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_user`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_usergroup`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_variable`
  ADD PRIMARY KEY (`id`) USING BTREE;

ALTER TABLE `ty_variable1`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `ty_ver`
  ADD PRIMARY KEY (`id`) USING BTREE;


ALTER TABLE `ty_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_api`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_apilog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_app`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_applog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_black`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_card`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_cardlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_cardtype`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_core`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_gameaccount`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_gameaccount2`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_goods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_group`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_heartbeat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_kdlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_md5`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_moneylog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_notice`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_usergroup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_variable`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_variable1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ty_ver`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;