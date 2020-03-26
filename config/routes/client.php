<?php
/**
 * User: ZionCheung.
 * Date: 2019-10-09
 * Project: zxxcms
 * Class: client.php
 */
use think\Route;

/******************* index ******************************/
// index 首页
Route::get('/', 'client/client/clientIndex');
