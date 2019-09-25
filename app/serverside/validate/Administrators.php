<?php
/**
 * User: ZionCheung.
 * Date: 2019-09-25
 * Project: zxxcms
 * Class: Administrators.php
 */
namespace app\serverside\validate;

use think\Validate;

class Administrators extends Validate
{
    protected $rule = [
        'admin_username' => 'require|unique:Administrators',
        'admin_password' => 'require',
        'admin_email' => 'require|unique:Administrators',
        'admin_telephone' => 'require|unique:Administrators'
    ];
    protected $message = [
        'admin_username.reqiore' => '用户名不能为空!',
        'admin_username.unique' => '用户名已存在!',
        'admin_password.require' => '密码不能为空!',
        'admin_email.require' => '邮箱不能为空!',
        'admin_email.unique' => '邮箱已存在!',
        'admin_telephone.require' => '手机号码不能为空!',
        'admin_telephone.unique' => '手机号码已存在!'
    ];
    protected $scene = [];
}
