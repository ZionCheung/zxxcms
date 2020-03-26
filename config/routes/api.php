<?php
/**
 * User: ZionCheung.
 * Date: 2019-10-09
 * Project: zxxcms
 * Class: api.php
 */
use think\Route;

/****************** api ****************************/
// Route::get/post('路由前缀/路由名/路由变量', '模块/版本.控制器/方法');
// 获取api路由前缀包括版本号,定义路径为config/extra/public.php
$apiRoute = config('public.api_route_prefix');
// api 获取用户信息
Route::get($apiRoute . '/getUserInfo/:id', $apiRoute . '.User/getUserInfo');
