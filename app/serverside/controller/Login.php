<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/20
 * Project: zxxcms
 * Class: Login.php
 */
namespace app\serverside\controller;

use app\serverside\model\Administrators;
use think\Cache;
use think\Controller;
use think\Log;
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
        $user = Administrators::getUserLoginInfo($data['username'], $data['password'], $request->ip());
        if (!$user) $this ->error('账号/密码错误');
        $user['userInfo']['adminSign'] = $user['userInfo']['admin_token'].'_1';
        Session::set('adminSession', $user['userInfo']);
        \app\serverside\model\OperationRecord::operationRecordAdd(0, '');
        $this ->success('登录成功,正在为你跳转主页...', url('serverside/home/backHomePage'), '', 1);
    }

    # 退出登录
    public function loginOutHandle ()
    {
        Session::clear();
        $this->redirect('serverside/login/loginPage');
    }

    # 管理员激活
    public function adminActivation ($token, $username)
    {
        $actionName = Cache::get($username);
        if (!$actionName) $this->error('激活链接已过期或链接出错,请联系网站管理员!',url('serverside/login/loginPage'));
        if ($token === $actionName) {
            $action = Administrators::adminActivation($username);
            if ($action['code'] == 0) {
                Cache::rm($username);
                $this->success('激活成功,正在跳转到登陆!', url('serverside/login/loginPage'),'',2);
            } else {
                Log::error('激活管理员异常');
                $this->error('激活链接已过期或链接出错,请联系网站管理员!',url('serverside/login/loginPage'));
            }
        }
    }
}
