<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


use think\Route;
// 获取api路由前缀包括版本号,定义路径为config/extra/public.php
$apiRoute = config('public.api_route_prefix');

/******************* index ******************************/
// index 首页
Route::get('/', 'client/client/clientIndex');

/******************* admin ******************************/

## ---------------------------- Login ----------------------##
// 登陆页面
Route::get('/login', 'serverside/login/loginPage');
// 登陆处理
Route::post('/loginHandle', 'serverside/login/loginHandle');

## ---------------------------- Home ----------------------##
// admin 首页
Route::get('/admin', 'serverside/home/backHomePage');
// admin 首页简介
Route::get('/admin/welcome', 'serverside/home/backHomeInfo');
// 图表统计
Route::get('admin/chars', 'serverside/home/chartStatistics');
## --------------------------------导航中心 ----------------------------##
// 导航菜单添加页面
Route::get('admin/menusaddpage', 'serverside/menus/menusAddPage');
// 导航菜单添加异步处理
Route::post('admin/menusAddHandle', 'serverside/menus/menusAddHandle');
// 导航菜单管理页面
Route::get('admin/menusmanagepage', 'serverside/menus/menusManagePage');
// 导航菜单删除
Route::post('admin/menusDeleteHandle', 'serverside/menus/menusDeleteHandle');
// 导航菜单排序修改
Route::post('admin/menusSortHandle', 'serverside/menus/menusSortHandle');
// 导航菜单开关
Route::post('admin/menusOpenHandle', 'serverside/menus/menusOpenHandle');
// 导航菜单更新页面
Route::get('admin/menusUpdatePage/:menusId', 'serverside/menus/menusUpdatePage');
// 导航菜单更新处理
Route::post('admin/menusUpdateHandle', 'serverside/menus/menusUpdateHandle');
// 导航添加子栏目页面
Route::get('admin/menusAddChildPage/:menusId', 'serverside/menus/menusAddChildPage');

## -------------------------------- 权限规则管理 ---------------------------------##
# 权限规则管理页面
Route::get('admin/authRuleManagePage', 'serverside/AuthRule/authRuleManagePage');
// 权限规则添加页面
Route::get('admin/authRuleAddPage', 'serverside/AuthRule/authRuleAddPage');
// 权限规则添加处理
Route::post('admin/authRuleAddHandle', 'serverside/AuthRule/authRuleAddHandle');
// 权限规则删除
Route::post('admin/authRuleDelete', 'serverside/AuthRule/authRuleDelete');
// 权限规则开关
Route::post('admin/authRuleOpen', 'serverside/AuthRule/authRuleOpen');
// 权限规则修改页面
Route::get('admin/authRuleUpdatePage/:ruleId', 'serverside/AuthRule/authRuleUpdatePage');
// 权限规则修改处理
Route::post('admin/authRuleUpdateHandle', 'serverside/AuthRule/authRuleUpdateHandle');
// 权限组管理页面
Route::get('admin/authGroupManagePage', 'serverside/AuthGroup/authGroupManagePage');
// 权限组添加页面
Route::get('admin/authGroupAddPage', 'serverside/AuthGroup/authGroupAddPage');
// 权限组添加操作
Route::post('admin/authGroupAddHandle', 'serverside/AuthGroup/authGroupAddHandle');
// 权限组修改页面
Route::get('admin/authGroupUpdatePage/:groupId', 'serverside/AuthGroup/authGroupUpdatePage');
// 权限组修改操作
Route::post('admin/authGroupUpdateHandle', 'serverside/AuthGroup/authGroupUpdateHandle');
// 权限组开关
Route::post('admin/authGroupStatusHandle', 'serverside/AuthGroup/authGroupStatusHandle');
// 权限组删除
Route::post('admin/authGroupDelete', 'serverside/AuthGroup/authGroupDelete');
// 权限组拥有权限页面
Route::get('admin/authGroupRulesPage/:groupId','serverside/AuthGroup/authGroupRulesPage');

## ----------------------------管理员管理 ------------------------------##
// 管理员管理页面
Route::get('admin/adminUserManagePage', 'serverside/Administrators/adminUserManagePage');
# 添加管理员页面
Route::get('admin/adminUserAddPage', 'serverside/Administrators/adminUserAddPage');
# 添加管理员操作
Route::post('admin/adminUserAddHandle', 'serverside/Administrators/adminUserAddHandle');
# 管理员禁用/开启
Route::post('admin/adminUserOnOffHandle','serverside/Administrators/adminUserOnOffHandle');
# 管理员权限分配页面
Route::get('admin/adminAuthGroupPage/:adminId','serverside/Administrators/adminAuthGroupPage');
# 管理员权限分配操作
Route::post('admin/adminAuthGroupHandle','serverside/Administrators/adminAuthGroupHandle');
# 管理员删除操作
Route::post('admin/adminDeleteHandle','serverside/Administrators/adminDeleteHandle');
/****************** api ****************************/
// Route::get/post('路由前缀/路由名/路由变量', '模块/版本.控制器/方法');
// api 获取用户信息
Route::get($apiRoute . '/getUserInfo/:id', $apiRoute . '.User/getUserInfo');
