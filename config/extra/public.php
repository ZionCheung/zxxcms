<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/10
 * Project: zxxcms
 * Class: public.php
 * 设置常用配置
 */
return [
    // api接口路由前缀
    'api_route_prefix' => 'api/:version',
    // 操作记录开关 (true/false)
    'operation_record_open' => true,
    // 页面提示语
    'page_tips_content' => [
        'menusAddPage' => '顶级导航链接随便填(不能为空),名称,英文名称,链接(唯一),所有字段不能为空! <a style="color: #009900" href="https://fontawesome.com/v4.7.0/icons/" target="_blank">点击查找图标</a>',
        'menusManagePage' => '查询关键字仅限于顶级分类关键字(如系统数据->本站统计,输入系统数据关键字即可),当有子分类存在时顶级分类无法删除,关闭顶级分类时当前分类将被完全关闭',
        'menusUpdatePage' => '只能修改以下3项,若需要其他修改,请删除后重新创建,<a style="color: #009900" href="https://fontawesome.com/v4.7.0/icons/" target="_blank">点击查找图标</a>',
        'authRuleManagePage' => '关键字查找(标题/标识),规则删除后将不在记录,若出现误删除,需重新添加。',
        'authRuleAddPage' => '顶级规则只是方便实现分级显示,并无其他作用,标识(模块/控制器/方法),标题(方便识别规则作用即可),附加规则(非专业人员请保持为空)',
        'authRuleUpdatePage' => '顶级规则只是方便实现分级显示,并无其他作用,标识(模块/控制器/方法),标题(方便识别规则作用即可),附加规则(非专业人员请保持为空)',
        'authGroupManagePage' => '关键字查找仅限于查找名称,当权限组关闭后,属于权限组的成员将失去该组权限,删除后将不在记录,若出现误删除,需重新添加。'
    ]
];
