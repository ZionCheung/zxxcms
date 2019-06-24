
/**
  后台菜单表
 */
DROP TABLE IF EXISTS `zxx_admin_menus`;

CREATE TABLE `zxx_admin_menus` (
    `menus_id` INT UNSIGNED AUTO_INCREMENT COMMENT '菜单ID/主键',
    `menus_name` VARCHAR(20) UNIQUE NOT NULL COMMENT '菜单名称',
    `menus_icon` VARCHAR(50) NOT NULL COMMENT '菜单icon',
    `menus_link` VARCHAR(100) UNIQUE NOT NULL COMMENT '菜单链接,模块/控制器/方法',
    `menus_open` TINYINT DEFAULT '1' COMMENT '菜单开关',
    `menus_time` INT NOT NULL COMMENT '菜单创建时间',
    `menus_rank` INT DEFAULT '0' COMMENT '菜单等级:0为顶级',
    `menus_sort` INT DEFAULT '100' COMMENT '菜单排序',
    `menus_eng_name` VARCHAR(50) NOT NULL COMMENT '菜单英文名称',
    `menus_delete` TINYINT DEFAULT '0' COMMENT '菜单软删除',
    `menus_delete_time` INT DEFAULT '0' COMMENT '菜单删除时间',
    PRIMARY KEY (`menus_id`)
)ENGINE = InnoDB CHARSET = utf8 COMMENT '后台菜单表';

/**
  添加第一条数据
 */
INSERT INTO zxx_admin_menus VALUES (1, '菜单管理', 'fa fa-bars', '0', 1, 1560669591, 0, 100, 'Menu management', 0, 0),
                                   (2, '后台菜单添加', 'fa fa-plus', 'serverside/menus/menusAddPage', 1, 1560669591, 1, 100, 'Menu management', 0, 0);
