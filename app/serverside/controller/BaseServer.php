<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/13
 * Project: zxxcms
 * Class: BaseServer.php
 */
namespace app\serverside\controller;

use think\auth\Auth;
use think\Controller;

class BaseServer extends Controller
{
    protected $tipe404 = '页面不存在';

    public function _initialize () {
        $adminSession = session('adminSession');
        if(empty($adminSession['admin_token']) || intval(substr($adminSession['adminSign'], -1, 1)) !== 1) {
            $this ->redirect('serverside/login/loginPage');
        }
        # 获取当前模块
        $mod = $this->request->module();
        # 获取当前控制器
        $controller = $this->request->controller();
        # 获取当前方法
        $action = $this->request->action();
        $auth = new Auth();
        $rule = strtolower($mod.'/'.$controller.'/'.$action);
        # 不需要验证权限的页面
        $notCheck = ['serverside/home/backhomepage', 'serverside/home/backhomeinfo'];
        if (in_array($rule, $notCheck)) return true;
        if (!$auth->check($rule, $adminSession['admin_id'])) {
            $this->error('没有操作权限', 'serverside/home/backhomeinfo','',1);
        }
    }
}
