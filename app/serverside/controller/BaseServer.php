<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/13
 * Project: zxxcms
 * Class: BaseServer.php
 */
namespace app\serverside\controller;

use think\Controller;

class BaseServer extends Controller
{
    protected $tipe404 = '页面不存在';

    public function _initialize () {
        $adminSession = session('adminSession');
        if(empty($adminSession['admin_token']) || intval(substr($adminSession['adminSign'], -1, 1)) !== 1) {
            $this ->redirect('serverside/login/loginPage');
        }
    }
}
