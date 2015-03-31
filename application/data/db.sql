-- 配置表

-- ----------------------------
--  Table structure for appinfo
-- ----------------------------
DROP TABLE IF EXISTS contest;
CREATE TABLE appinfo (
  appid int(10) unsigned NOT NULL,
  shop_name varchar(100) NOT NULL,
  url varchar(200) NOT NULL,
  query varchar(50) NOT NULL,
  status tinyint(1) not null default 0, -- 0：待审核；1：未通过 2： 已通过；
  facilitator_id int(10) unsigned NOT NULL,
  facilitator_name varchar(100) NOT NULL,
  ctime timestamp NOT NULL default CURRENT_TIMESTAMP,	-- 创建时间
  utime timestamp NOT NULL default 0,	-- 最后修改时间
  handler_name varchar(50) NOT NULL,
  PRIMARY KEY (appid),
  key(shop_name),
  key(query),
  key(status),
  key(facilitator_id),
  key(facilitator_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
--  Table structure for account
-- ----------------------------
DROP TABLE IF EXISTS account;
CREATE TABLE account (
  username varchar(50) NOT NULL,
  password varchar(50) NOT NULL,
  role tinyint(1) not null default 2, -- 2：审核员；5：管理员 8.高级管理员；
  ctime timestamp NOT NULL default CURRENT_TIMESTAMP,	-- 创建时间
  PRIMARY KEY (username),
  key(role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;