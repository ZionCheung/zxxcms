
/**
  管理员自定义链接表
  zxx_admin_customize_link
 */
DROP TABLE IF EXISTS `zxx_admin_customize_link`;

CREATE TABLE `zxx_admin_customize_link`(
    `customize_link_id` INT UNSIGNED AUTO_INCREMENT COMMENT  '自定义链接ID/主键',
    `customize_link_name` VARCHAR(20) NOT NULL COMMENT '自定义链接名称',
    `customize_link_icon` VARCHAR(50) NOT NULL COMMENT '自定义链接图标',
    `customize_link_time` INT NOT NULL COMMENT '自定义链接添加时间',
    `customize_link_ip` VARCHAR(100) NOT NULL COMMENT '自定义链接添加IP',
    `customize_link_address` VARCHAR(200) NOT NULL COMMENT '自定义链接地址',
    `customize_link_open` TINYINT DEFAULT 0 COMMENT '自定义链接开关',
    `customize_link_sort` INT DEFAULT 20 COMMENT '自定义链接排序',
    `administrators_id` INT UNSIGNED NOT NULL COMMENT '管理员ID',
    PRIMARY KEY (`customize_link_id`)
)ENGINE = InnoDB CHARSET = utf8 COMMENT '管理员自定义链接表';

/**
  添加第一条数据开发者
 */
INSERT INTO zxx_admin_customize_link VALUES (1, 'QQ邮箱', 'fa fa-envelope-o', 1560525827, '127.0.0.1',
                                             'https://mail.qq.com/', 0, 20, 1);
