
/**
  后台操作记录表
 */
DROP TABLE IF EXISTS `zxx_admin_operation_record`;

CREATE TABLE `zxx_admin_operation_record` (
    `operation_record_id` INT UNSIGNED AUTO_INCREMENT COMMENT '操作记录ID/主键',
    `operation_record_time` INT UNSIGNED NOT NULL COMMENT '操作时间',
    `operation_record_ip` VARCHAR(100) NOT NULL COMMENT '登录IP',
    `operation_record_desc` VARCHAR(200) NOT NULL COMMENT '操作描述',
    `operation_record_open` TINYINT DEFAULT '1' COMMENT '状态: 1开启 0关闭',
    `administrators_id` INT NOT NULL COMMENT '操作管理员ID',
    PRIMARY KEY (`operation_record_id`)
)ENGINE = InnoDB CHARSET = utf8 COMMENT '操作记录表';
