<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/17
 * Project: zxxcms
 * Class: AdminMenus.phps.php
 */

namespace app\serverside\validate;


use think\Validate;

class AdminMenus extends Validate
{
    protected $rule = [
        'menus_name' => 'require|unique:AdminMenus',
        'menus_icon' => 'require',
        'menus_link' => 'require|unique:AdminMenus',
        'menus_open' => 'require',
        'menus_rank' => 'require',
        'menus_eng_name' => 'require|unique:AdminMenus'
    ];
    protected $message = [
        'menus_name.require' => '导航名称不能为空!',
        'menus_name.unique' => '导航已经存在!',
        'menus_link.require' => '导航链接不能为空!',
        'menus_link.unique' => '导航链接已存在!',
        'menus_open.require' => '导航开关不能为空!',
        'menus_rank.require' => '导航等级不能为空!',
        'menus_eng_name.require' => '导航英文名不能为空!',
        'menus_eng_name.unique' => '导航英文名已存在!',
    ];

    protected $scene = [
    ];
}
