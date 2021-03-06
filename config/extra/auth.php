<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/16 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> auth.php ]
 * +----------------------------------------------------------------------
 */
return [
    'auth_on' => 1, // 权限开关
    'auth_type' => 1, // 认证方式，1为实时认证；2为登录认证。
    'auth_group' => 'admin_auth_group', // 用户组数据表名
    'auth_group_access' => 'admin_auth_group_access', // 用户-用户组关系表
    'auth_rule' => 'admin_auth_rule', // 权限规则表
    'auth_user' => 'administrators', // 用户信息表
    'auth_not_status' => 1, # 不验证权限开关 1:开启, 0: 关闭; 关闭后配置auth_not_check失效
    'auth_not_check' => [
        'serverside/home/backhomepage',
        'serverside/home/backhomeinfo'
    ] # 不需要验证权限的页面
];
