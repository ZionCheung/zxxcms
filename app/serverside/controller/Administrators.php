<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/28
 * Project: zxxcms
 * Class: Administrators.php
 */
namespace app\serverside\controller;

class Administrators extends BaseServer
{
    // 管理员用户管理
    public function adminUserManagePage () {
        return $this ->fetch('user/cate');
    }
}
