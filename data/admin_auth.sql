
/**
zxx_admin_auth_rule，规则表
 */
DROP TABLE IF EXISTS `zxx_admin_auth_rule`;

CREATE TABLE `zxx_admin_auth_rule` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则ID',
    `name` char(80) NOT NULL DEFAULT '' COMMENT '规则唯一标识',
    `title` char(20) NOT NULL DEFAULT '' COMMENT '规则中文名称',
    `type` tinyint(1) NOT NULL DEFAULT '1' COMMENT '开启附加规则',
    `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
    `condition` char(100) NOT NULL DEFAULT '' COMMENT '规则附件条件',  # 规则附件条件,满足附加条件的规则,才认为是有效的规则
    `rank_id` INT DEFAULT '0' COMMENT '所属等级,0为顶级分类/对应rule_id',
    PRIMARY KEY (`id`),
    UNIQUE KEY `name` (`name`)
)ENGINE = InnoDB CHARSET = utf8 COMMENT '管理员权限规则表';

/**
  zxx_admin_auth_group 用户组表
 */
DROP TABLE IF EXISTS `zxx_admin_auth_group`;
CREATE TABLE `zxx_admin_auth_group` (
    `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT '用户组ID主键',
    `title` char(50) NOT NULL DEFAULT '' COMMENT '用户组中文名称',
    `status` tinyint(1) NOT NULL DEFAULT '1' COMMENT '状态：为1正常，为0禁用',
    `rules` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '用户组拥有的规则id',
    `group_desc` VARCHAR(255) NOT NULL DEFAULT '没有添加说明' COMMENT '用户组简介',
    PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT '管理员用户组表';

/**
  zxx_admin_auth_group_access 用户组明细表
 */
DROP TABLE IF EXISTS `zxx_admin_auth_group_access`;
CREATE TABLE `zxx_admin_auth_group_access` (
    `uid` mediumint(8) unsigned NOT NULL COMMENT '用户id',
    `group_id` mediumint(8) unsigned NOT NULL COMMENT '用户组id',
    UNIQUE KEY `uid_group_id` (`uid`,`group_id`),
    KEY `uid` (`uid`),
    KEY `group_id` (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT '用户组明细表';
