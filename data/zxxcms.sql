# Host: localhost  (Version: 5.5.53)
# Date: 2019-09-25 18:00:11
# Generator: MySQL-Front 5.3  (Build 4.234)

/*!40101 SET NAMES utf8 */;

#
# Structure for table "zxx_admin_auth_group"
#

DROP TABLE IF EXISTS `zxx_admin_auth_group`;
CREATE TABLE `zxx_admin_auth_group` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID主键',
  `title` char(50) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `rules` varchar(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id',
  `group_desc` varchar(255) NOT NULL DEFAULT '没有添加说明' COMMENT '用户组简介',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='管理员用户组表';

#
# Data for table "zxx_admin_auth_group"
#

INSERT INTO `zxx_admin_auth_group` VALUES (8,'开发者',1,'1,3,4,5,6,7,8,9,10,11,12,13,15,16,19,20,21,22,23,24,25,26,27,28,29,32','拥有至高无上的权力!'),(9,'132',1,'1,3,4,5,6,7,8,9,10','sdf'),(10,'dsfsdf',1,'12,29,32','wewq'),(11,'sdfs',1,'4,5,6,8,10,15,26,32','dsfs');

#
# Structure for table "zxx_admin_auth_group_access"
#

DROP TABLE IF EXISTS `zxx_admin_auth_group_access`;
CREATE TABLE `zxx_admin_auth_group_access` (
  `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
  `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
  UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
  KEY `uid` (`uid`),
  KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='用户组明细表';

#
# Data for table "zxx_admin_auth_group_access"
#

INSERT INTO `zxx_admin_auth_group_access` VALUES (1,8),(27,8),(27,9),(27,10),(27,11),(28,8),(28,9),(28,10),(28,11),(29,8),(29,9),(29,10),(29,11),(30,8);

#
# Structure for table "zxx_admin_auth_rule"
#

DROP TABLE IF EXISTS `zxx_admin_auth_rule`;
CREATE TABLE `zxx_admin_auth_rule` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则ID',
  `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
  `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
  `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启附加规则',
  `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
  `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则附件条件',
  `rank_id` int(11) DEFAULT '0' COMMENT '所属等级,0为顶级分类/对应rule_id',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='权限规则表';

#
# Data for table "zxx_admin_auth_rule"
#

INSERT INTO `zxx_admin_auth_rule` VALUES (1,'serverside/menus/menusManagePage','导航管理页面',1,1,'',0),(3,'serverside/menus/menusAddPage','导航添加页面',1,1,'',1),(4,'serverside/menus/menusUpdatePage','导航更新页面',1,1,'',1),(5,'serverside/menus/menusAddChildPage','导航子菜单页面',1,1,'',1),(6,'serverside/menus/menusUpdateHandle','导航更新操作',1,1,'',1),(7,'serverside/menus/menusOpenHandle','导航开关操作',1,1,'',1),(8,'serverside/menus/menusSortHandle','导航排序操作',1,1,'',1),(9,'serverside/menus/menusDeleteHandle','导航删除操作',1,1,'',1),(10,'serverside/menus/menusAddHandle','导航添加操作',1,1,'',1),(11,'serverside/AuthRule/authRuleManagePage','权限规则管理页面',1,1,'',0),(12,'serverside/AuthRule/authRuleAddPage','权限规则添加页面',1,1,'',11),(13,'serverside/AuthRule/authRuleAddHandle','权限规则添加操作',1,1,'',11),(15,'serverside/AuthRule/authRuleDelete','权限规则删除操作',1,1,'',11),(16,'serverside/AuthRule/authRuleOpen','权限规则开关操作',1,1,'',11),(19,'serverside/AuthRule/authRuleUpdatePage','权限规则修改页面',1,1,'',11),(20,'serverside/AuthRule/authRuleUpdateHandle','权限规则修改操作',1,1,'',11),(21,'serverside/AuthGroup/authGroupManagePage','权限组管理界面',1,1,'',0),(22,'serverside/AuthGroup/authGroupAddPage','权限组添加页面',1,1,'',21),(23,'serverside/AuthGroup/authGroupAddHandle','权限组添加操作',1,1,'',21),(24,'serverside/AuthGroup/authGroupUpdatePage','权限组修改页面',1,1,'',21),(25,'serverside/AuthGroup/authGroupUpdateHandle','权限组修改操作',1,1,'',21),(26,'serverside/AuthGroup/authGroupStatusHandle','权限组开关',1,1,'',21),(27,'serverside/AuthGroup/authGroupDelete','权限组删除',1,1,'',21),(28,'serverside/AuthGroup/authGroupRulesPage','权限查看页面',1,1,'',21),(29,'serverside/Administrators/adminUserManagePage','管理员管理界面',1,1,'',0),(32,'serverside/Administrators/adminUserAddPage','添加管理员页面',1,1,'',29);

#
# Structure for table "zxx_admin_customize_link"
#

DROP TABLE IF EXISTS `zxx_admin_customize_link`;
CREATE TABLE `zxx_admin_customize_link` (
  `customize_link_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '自定义链接ID/主键',
  `customize_link_name` varchar(20) NOT NULL COMMENT '自定义链接名称',
  `customize_link_icon` varchar(50) NOT NULL COMMENT '自定义链接图标',
  `customize_link_time` int(11) NOT NULL COMMENT '自定义链接添加时间',
  `customize_link_ip` varchar(100) NOT NULL COMMENT '自定义链接添加IP',
  `customize_link_address` varchar(200) NOT NULL COMMENT '自定义链接地址',
  `customize_link_open` tinyint(4) DEFAULT '0' COMMENT '自定义链接开关',
  `customize_link_sort` int(11) DEFAULT '20' COMMENT '自定义链接排序',
  `administrators_id` int(11) unsigned NOT NULL DEFAULT '0' COMMENT '管理员ID',
  PRIMARY KEY (`customize_link_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='管理员自定义链接表';

#
# Data for table "zxx_admin_customize_link"
#

INSERT INTO `zxx_admin_customize_link` VALUES (1,'QQ邮箱','fa fa-envelope-o',1560525827,'127.0.0.1','https://mail.qq.com/',0,20,1),(2,'QQ邮箱1','fa fa-envelope-o',1560525827,'127.0.0.1','https://mail.qq.com/',0,20,1),(3,'QQ邮箱2','fa fa-envelope-o',1560525827,'127.0.0.1','https://mail.qq.com/',0,20,1);

#
# Structure for table "zxx_admin_menus"
#

DROP TABLE IF EXISTS `zxx_admin_menus`;
CREATE TABLE `zxx_admin_menus` (
  `menus_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '菜单ID/主键',
  `menus_name` varchar(20) NOT NULL COMMENT '菜单名称',
  `menus_icon` varchar(50) NOT NULL COMMENT '菜单icon',
  `menus_link` varchar(100) NOT NULL DEFAULT '0' COMMENT '菜单链接,模块/控制器/方法',
  `menus_open` tinyint(4) DEFAULT '1' COMMENT '菜单开关',
  `menus_time` int(11) NOT NULL COMMENT '菜单创建时间',
  `menus_rank` int(11) DEFAULT '0' COMMENT '菜单等级:0为顶级',
  `menus_sort` int(11) DEFAULT '100' COMMENT '菜单排序',
  `menus_eng_name` varchar(50) NOT NULL COMMENT '菜单英文名称',
  `menus_delete` tinyint(4) DEFAULT '0' COMMENT '菜单软删除',
  `menus_delete_time` int(11) DEFAULT '0' COMMENT '菜单删除时间',
  PRIMARY KEY (`menus_id`),
  UNIQUE KEY `menus_name` (`menus_name`),
  UNIQUE KEY `menus_link` (`menus_link`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='后台菜单表';

#
# Data for table "zxx_admin_menus"
#

INSERT INTO `zxx_admin_menus` VALUES (1,'菜单管理','fa fa-bars','0',1,1560669591,0,100,'Menu management',0,0),(2,'后台菜单添加','fa fa-plus','serverside/menus/menusAddPage',1,1560669591,1,100,'Back Menu Add',0,0),(3,'后台菜单管理','fa fa-bars','serverside/menus/menusManagePage',1,1561038749,1,100,'Back Menu manage',0,0),(4,'权限管理','fa fa-unlock-alt','76fe9775',1,1561039972,0,100,'Auth Management',0,0),(5,'用户管理','fa fa-user','7a5c0f40',1,1561040102,0,100,'User Management',0,0),(6,'后台规则管理','fa fa-lock','serverside/AuthRule/authRuleManagePage',1,1561121042,4,100,'Back Rule Manage',0,0),(7,'后台权限组管理','fa fa-users','serverside/AuthGroup/authGroupManagePage',1,1561121288,4,100,'Back AuthGroup Manage',0,0),(9,'管理员管理','fa fa-user-secret','serverside/Administrators/adminUserManagePage',1,1561689374,5,100,'Administrators Manage',0,0);

#
# Structure for table "zxx_admin_operation_record"
#

DROP TABLE IF EXISTS `zxx_admin_operation_record`;
CREATE TABLE `zxx_admin_operation_record` (
  `operation_record_id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '操作记录ID/主键',
  `operation_record_time` int(10) unsigned NOT NULL COMMENT '操作时间',
  `operation_record_ip` varchar(100) NOT NULL COMMENT '登录IP',
  `operation_record_desc` varchar(200) NOT NULL COMMENT '操作描述',
  `operation_record_open` tinyint(4) DEFAULT '1' COMMENT '状态: 1开启 0关闭',
  `administrators_id` int(11) NOT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`operation_record_id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8 COMMENT='操作记录表';

#
# Data for table "zxx_admin_operation_record"
#

INSERT INTO `zxx_admin_operation_record` VALUES (1,1561038749,'127.0.0.1','ZionCheung-添加了导航菜单(后台菜单管理)',1,1),(2,1561039972,'127.0.0.1','ZionCheung-添加了导航菜单(权限管理)',1,1),(3,1561040102,'127.0.0.1','ZionCheung-添加了导航菜单(用户管理)',1,1),(4,1561040216,'127.0.0.1','ZionCheung-修改了导航菜单Id:(5)',1,1),(5,1561121715,'127.0.0.1','developer-添加了导航菜单(123123)',1,1),(6,1561121760,'127.0.0.1','developer-删除了导航菜单(123123)',1,1),(7,1561121767,'127.0.0.1','developer-删除了导航菜单(qweqwe)',1,1),(8,1561121768,'127.0.0.1','developer-删除了导航菜单(12312312)',1,1),(9,1561221191,'127.0.0.1','developer-添加了权限规则(导航管理)',1,1),(10,1561221237,'127.0.0.1','developer-添加了权限规则(导航添加页面)',1,1),(11,1561281203,'127.0.0.1','developer-添加了权限规则(3123123)',1,1),(12,1561281208,'127.0.0.1','developer-添加了权限规则(123123123)',1,1),(13,1561281212,'127.0.0.1','developer-添加了权限规则(12312312)',1,1),(14,1561281217,'127.0.0.1','developer-添加了权限规则(312312312)',1,1),(15,1561281389,'127.0.0.1','developer-删除了权限规则ID(5)',1,1),(16,1561281409,'127.0.0.1','developer-添加了权限规则(wqeqwe)',1,1),(17,1561281414,'127.0.0.1','developer-添加了权限规则(asdasd)',1,1),(18,1561281419,'127.0.0.1','developer-添加了权限规则(dasdasd)',1,1),(19,1561281424,'127.0.0.1','developer-删除了权限规则ID(4,8,9,10)',1,1),(20,1561281581,'127.0.0.1','developer-删除了权限规则ID(3)',1,1),(21,1561281739,'127.0.0.1','developer-添加了权限规则(导航管理页面)',1,1),(22,1561281768,'127.0.0.1','developer-添加了权限规则(导航添加页面)',1,1),(23,1561281781,'127.0.0.1','developer-删除了权限规则ID(2)',1,1),(24,1561281795,'127.0.0.1','developer-添加了权限规则(导航添加页面)',1,1),(25,1561281836,'127.0.0.1','developer-添加了权限规则(导航更新页面)',1,1),(26,1561281888,'127.0.0.1','developer-添加了权限规则(导航子菜单页面)',1,1),(27,1561281944,'127.0.0.1','developer-添加了权限规则(导航更新操作)',1,1),(28,1561281976,'127.0.0.1','developer-添加了权限规则(导航开关操作)',1,1),(29,1561281999,'127.0.0.1','developer-添加了权限规则(导航排序操作)',1,1),(30,1561282017,'127.0.0.1','developer-添加了权限规则(导航删除操作)',1,1),(31,1561282039,'127.0.0.1','developer-添加了权限规则(导航添加操作)',1,1),(32,1561282101,'127.0.0.1','developer-添加了权限规则(权限规则管理页面)',1,1),(33,1561282120,'127.0.0.1','developer-添加了权限规则(权限规则添加页面)',1,1),(34,1561282147,'127.0.0.1','developer-添加了权限规则(权限规则添加操作)',1,1),(35,1561282173,'127.0.0.1','developer-添加了权限规则(权限规则删除操作)',1,1),(36,1561282427,'127.0.0.1','developer-删除了权限规则ID(14)',1,1),(37,1561282446,'127.0.0.1','developer-添加了权限规则(权限规则删除操作)',1,1),(38,1561283238,'127.0.0.1','developer-添加了权限规则(权限规则开关操作)',1,1),(39,1561355944,'127.0.0.1','developer-修改了权限规则Id:(1)',1,1),(40,1561355989,'127.0.0.1','developer-修改了权限规则Id:(1)',1,1),(41,1561355998,'127.0.0.1','developer-修改了权限规则Id:(1)',1,1),(42,1561356063,'127.0.0.1','developer-修改了权限规则Id:(1)',1,1),(43,1561356083,'127.0.0.1','developer-修改了权限规则Id:(1)',1,1),(44,1561356110,'127.0.0.1','developer-修改了权限规则Id:(1)',1,1),(45,1561356121,'127.0.0.1','developer-添加了权限规则(23123123)',1,1),(46,1561356128,'127.0.0.1','developer-删除了权限规则ID(17)',1,1),(47,1561356136,'127.0.0.1','developer-添加了权限规则(3123123123)',1,1),(48,1561356144,'127.0.0.1','developer-修改了权限规则Id:(18)',1,1),(49,1561356208,'127.0.0.1','developer-修改了权限规则Id:(18)',1,1),(50,1561356231,'127.0.0.1','developer-修改了权限规则Id:(18)',1,1),(51,1561356234,'127.0.0.1','developer-删除了权限规则ID(18)',1,1),(52,1561361330,'127.0.0.1','developer-添加了权限规则(权限规则修改页面)',1,1),(53,1561361346,'127.0.0.1','developer-添加了权限规则(权限规则修改操作)',1,1),(54,1561362754,'127.0.0.1','developer-修改了权限规则Id:(20)',1,1),(55,1561364995,'127.0.0.1','developer-添加了导航菜单(21312qweqe)',1,1),(56,1561365198,'127.0.0.1','developer-添加了权限组(123123)',1,1),(57,1561365269,'127.0.0.1','developer-添加了权限组(萨达萨达)',1,1),(58,1561621297,'127.0.0.1','developer-添加了权限组(2问问群二)',1,1),(59,1561624091,'127.0.0.1','developer-添加了权限组(驱蚊器二群)',1,1),(60,1561625008,'127.0.0.1','developer-修改了权限组Id:($groupId)',1,1),(61,1561625027,'127.0.0.1','developer-修改了权限组Id:($groupId)',1,1),(62,1561625073,'127.0.0.1','developer-修改了权限组Id:(1)',1,1),(63,1561625081,'127.0.0.1','developer-修改了权限组Id:(1)',1,1),(64,1561625083,'127.0.0.1','developer-修改了权限组Id:(1)',1,1),(65,1561625099,'127.0.0.1','developer-修改了权限组Id:(1)',1,1),(66,1561626126,'127.0.0.1','developer-修改了权限组Id:(1)',1,1),(67,1561627559,'127.0.0.1','developer-添加了权限组(123213)',1,1),(68,1561627565,'127.0.0.1','developer-添加了权限组(王企鹅群we)',1,1),(69,1561627573,'127.0.0.1','developer-添加了权限组(胜多负少)',1,1),(70,1561627699,'127.0.0.1','developer-删除了权限组Id:(3)',1,1),(71,1561627720,'127.0.0.1','developer-添加了权限组(12312312)',1,1),(72,1561627726,'127.0.0.1','developer-添加了权限组(是非得失)',1,1),(73,1561627731,'127.0.0.1','developer-删除了权限组Id:(2,6,7)',1,1),(74,1561627962,'127.0.0.1','developer-添加了权限组(开发者)',1,1),(75,1561629239,'127.0.0.1','developer-添加了权限组(wqd)',1,1),(76,1561687135,'127.0.0.1','developer-添加了权限规则(权限组管理界面)',1,1),(77,1561687207,'127.0.0.1','developer-添加了权限规则(权限组添加页面)',1,1),(78,1561687224,'127.0.0.1','developer-添加了权限规则(权限组添加操作)',1,1),(79,1561687248,'127.0.0.1','developer-添加了权限规则(权限组修改页面)',1,1),(80,1561687264,'127.0.0.1','developer-添加了权限规则(权限组修改操作)',1,1),(81,1561687280,'127.0.0.1','developer-添加了权限规则(权限组开关)',1,1),(82,1561687297,'127.0.0.1','developer-添加了权限规则(权限组删除)',1,1),(83,1561687324,'127.0.0.1','developer-添加了权限规则(权限查看页面)',1,1),(84,1561687336,'127.0.0.1','developer-修改了权限规则Id:(26)',1,1),(85,1561687961,'127.0.0.1','developer-添加了导航菜单(管理员管理)',1,1),(86,1561689325,'127.0.0.1','developer-删除了导航菜单(管理员管理)',1,1),(87,1561689374,'127.0.0.1','developer-添加了导航菜单(管理员管理)',1,1),(88,1569380907,'127.0.0.1','developer-修改了权限组Id:(8)',1,1),(89,1569380915,'127.0.0.1','developer-删除了权限组Id:(9)',1,1),(90,1569385723,'127.0.0.1','developer-添加了权限规则(管理员管理)',1,1),(91,1569385775,'127.0.0.1','developer-修改了权限组Id:(8)',1,1),(92,1569385803,'127.0.0.1','developer-修改了权限规则Id:(29)',1,1),(93,1569385874,'127.0.0.1','developer-添加了权限规则(45435345345)',1,1),(94,1569385888,'127.0.0.1','developer-添加了权限规则(32423534)',1,1),(95,1569385891,'127.0.0.1','developer-删除了权限规则ID(30)',1,1),(96,1569385894,'127.0.0.1','developer-删除了权限规则ID(31)',1,1),(97,1569390959,'127.0.0.1','developer-添加了权限规则(添加管理员页面)',1,1),(98,1569390968,'127.0.0.1','developer-修改了权限组Id:(8)',1,1),(99,1569392615,'127.0.0.1','developer-添加了权限组(132)',1,1),(100,1569393251,'127.0.0.1','developer-添加了权限组(dsfsdf)',1,1),(101,1569393263,'127.0.0.1','developer-添加了权限组(sdfs)',1,1),(102,1569401750,'127.0.0.1','developer-添加了管理员用户(dfsfsdf)',1,1),(103,1569401797,'127.0.0.1','developer-添加了管理员用户(wwwww)',1,1),(104,1569405497,'127.0.0.1','developer-添加了管理员用户(zhangxxun)',1,1);

#
# Structure for table "zxx_administrators"
#

DROP TABLE IF EXISTS `zxx_administrators`;
CREATE TABLE `zxx_administrators` (
  `admin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(50) NOT NULL COMMENT '管理员账号',
  `admin_password` char(32) NOT NULL COMMENT '管理员密码',
  `admin_lock_password` char(32) NOT NULL DEFAULT '' COMMENT '锁屏密码/默认和登录密码一样',
  `admin_email` varchar(100) NOT NULL COMMENT '管理员验证邮箱',
  `admin_telephone` char(11) NOT NULL COMMENT '管理员电话/11位手机号码',
  `admin_token` char(32) NOT NULL COMMENT '管理员令牌',
  `admin_open` tinyint(4) DEFAULT '0' COMMENT '账号开关1:正常,0:限制登陆',
  `admin_nickname` varchar(100) NOT NULL COMMENT '管理员昵称',
  `admin_head_portrait` varchar(100) NOT NULL COMMENT '管理员头像',
  `admin_desc` varchar(200) NOT NULL COMMENT '管理员描述',
  `admin_reg_ip` varchar(50) NOT NULL COMMENT '账号注册IP',
  `admin_login_ip` varchar(50) NOT NULL COMMENT '账号登陆IP',
  `admin_reg_time` int(11) NOT NULL COMMENT '注册时间',
  `admin_login_time` int(11) NOT NULL COMMENT '最后一次登陆时间',
  `admin_delete` tinyint(4) DEFAULT '0' COMMENT '软删除标记1:已删除,0:正常使用',
  `admin_delete_time` int(11) DEFAULT '0' COMMENT '删除时间',
  PRIMARY KEY (`admin_id`),
  UNIQUE KEY `admin_username` (`admin_username`),
  UNIQUE KEY `admin_email` (`admin_email`),
  UNIQUE KEY `admin_telephone` (`admin_telephone`),
  UNIQUE KEY `admin_token` (`admin_token`),
  UNIQUE KEY `admin_nickname` (`admin_nickname`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='管理员用户表';

#
# Data for table "zxx_administrators"
#

INSERT INTO `zxx_administrators` VALUES (1,'developer','5e8edd851d2fdfbd7415232c67367cc3','5e8edd851d2fdfbd7415232c67367cc3','zhangxunxun1314@outlook.com','13650502554','5e8edd851d2fdfbd7415232c67367cc3',1,'ZionCheung','/admin/head/developer.jpg','你好! 我是本站的开发者ZionCheung.','127.0.0.1','127.0.0.1',1560417126,1560417126,0,0),(30,'zhangxxun','3775c147bc7c86a30db52321c21b0f7f','3775c147bc7c86a30db52321c21b0f7f','939129894@qq.com','18084919489','1d72379955f2754d64a9e40df963c7ec',0,'zhangxxun','/static/assets/images/backstage/admin.jpeg','我成为管理员了!','127.0.0.1','0',1569405497,0,0,0);
