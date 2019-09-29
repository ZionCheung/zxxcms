/**
  管理员用户表
  zxx_administrators Table
 */
DROP TABLE IF EXISTS `zxx_administrators`;

CREATE TABLE `zxx_administrators`(
  `admin_id` INT UNSIGNED AUTO_INCREMENT,
  `admin_username` VARCHAR(50)UNIQUE NOT NULL COMMENT '管理员账号',
  `admin_password` VARCHAR (200) NOT NULL COMMENT '管理员密码',
  `admin_lock_password` VARCHAR (200) NOT NULL COMMENT '锁屏密码/默认和登录密码一样'
  `admin_email` VARCHAR(100)UNIQUE NOT NULL COMMENT '管理员验证邮箱',
  `admin_telephone` CHAR(11)UNIQUE NOT NULL COMMENT '管理员电话/11位手机号码',
  `admin_token` CHAR(32) UNIQUE NOT NULL COMMENT '管理员令牌',
  `admin_open` TINYINT DEFAULT 0 COMMENT '账号开关1:正常,0:限制登陆',
  `admin_nickname` VARCHAR(100) UNIQUE NOT NULL COMMENT '管理员昵称',
  `admin_head_portrait` VARCHAR (100) NOT NULL COMMENT '管理员头像',
  `admin_desc` VARCHAR (200) NOT NULL COMMENT '管理员描述',
  `admin_reg_ip` VARCHAR (50) NOT NULL COMMENT '账号注册IP',
  `admin_login_ip` VARCHAR (50) NOT NULL COMMENT '账号登陆IP',
  `admin_reg_time` INT NOT NULL COMMENT '注册时间',
  `admin_login_time` INT NOT NULL COMMENT '最后一次登陆时间',
  `admin_delete` TINYINT DEFAULT 0 COMMENT '软删除标记1:已删除,0:正常使用',
  `admin_delete_time` INT DEFAULT 0 COMMENT '删除时间',
  PRIMARY KEY (`admin_id`)
)ENGINE = InnoDB CHARSET = utf8 COMMENT '管理员用户表';

/**
 添加第一条数据,开发者账号
 username: developer
 password: md5('developer')
 token: md5('developer')
 */
INSERT INTO zxx_administrators VALUES (1,'developer', '5e8edd851d2fdfbd7415232c67367cc3', '5e8edd851d2fdfbd7415232c67367cc3',
'zhangxunxun1314@outlook.com','13650502554', '5e8edd851d2fdfbd7415232c67367cc3', 1, 'ZionCheung', '/admin/head/developer.jpg',
'你好! 我是本站的开发者ZionCheung.', '127.0.0.1', '127.0.0.1', 1560417126, 1560417126, 0, 0);
