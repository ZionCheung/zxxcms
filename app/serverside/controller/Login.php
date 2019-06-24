<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/20
 * Project: zxxcms
 * Class: Login.php
 */
namespace app\serverside\controller;

use app\serverside\model\Administrators;
use think\Controller;
use think\Request;
use think\Session;
use think\View;

class Login extends Controller
{
    // 登陆页面
    public function loginPage () {
        $code = substr('pSJN78AZXS565DXZDWEQ1Wqweasdzxcmih5248769', mt_rand(0, 10), mt_rand(4, 6));
        Session::set('code', $code);
        $view = new View();
        $view ->assign('code', $code);
        return $view ->fetch('login/login');
    }

    // 登陆处理
    public function loginHandle (Request $request) {
        $data = $request ->post();
        $code = Session::pull('code');
        if (strtolower($code) !== strtolower($data['code'])) $this->error('验证码错误');
        $user = Administrators::getUserLoginInfo($data['username'], $data['password']);
        if (!$user) $this ->error('账号/密码错误');
        $user['userInfo']['adminSign'] = $user['userInfo']['admin_token'].'_1';
        Session::set('adminSession', $user['userInfo']);
        $this ->success('登录成功,正在为你跳转主页...', url('serverside/home/backHomePage'), '', 1);
    }
}
