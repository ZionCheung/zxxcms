/**
  文章表创建
 */

DROP TABLE IF EXISTS `zxx_article`;

CREATE TABLE `zxx_article`(
    `article_id` INT UNSIGNED AUTO_INCREMENT COMMENT '文章ID',
    `article_title` VARCHAR(100) NOT NULL UNIQUE COMMENT '文章标题',
    `article_content` TEXT NOT NULL COMMENT '文章内容',
    `article_author` VARCHAR(50)NOT NULL COMMENT '文章作者',
    `article_cover` VARCHAR(100)NOT NULL COMMENT '文章封面图',
    `article_add_time` INT UNSIGNED NOT NULL COMMENT '添加时间',
    `article_update_time` INT UNSIGNED DEFAULT 0 COMMENT '更新时间',
    `article_collect` INT UNSIGNED DEFAULT 0 COMMENT '收藏量',
    `article_visits` INT UNSIGNED DEFAULT 0 COMMENT '访问量',
    `article_sort` INT UNSIGNED DEFAULT 10000 COMMENT '文章排序',
    `article_open` TINYINT UNSIGNED DEFAULT 0 COMMENT '文章开关',
    `admin_id` INT UNSIGNED NOT NULL COMMENT '添加管理员ID',
    `article_menu_id` INT UNSIGNED NOT NULL COMMENT '文章菜单ID',
    `article_tag_id` VARCHAR(50) NOT NULL COMMENT '文章标签ID',
    `article_recycle` TINYINT UNSIGNED DEFAULT 0 COMMENT '软删除开关',
    `article_recycle_time` INT UNSIGNED NOT NULL COMMENT '软删除时间',
    PRIMARY KEY (`article_id`)
)ENGINE = InnoDB CHARSET = utf8 COMMENT '文章表';
