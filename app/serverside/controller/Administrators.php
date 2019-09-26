<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/28
 * Project: zxxcms
 * Class: Administrators.php
 */
namespace app\serverside\controller;

use app\serverside\model\AuthGroup as groupModel;
use app\serverside\model\AuthGroupAccess as accessModel;
use app\serverside\model\OperationRecord;
use lib\SendMail;
use think\auth\Auth;
use think\Log;
use think\Request;
use think\Session;

class Administrators extends BaseServer
{
    # 权限验证
    private static function judgementAuthority (string $role) : bool
    {
        $id =  Session::get('adminSession.admin_id');
        $auth = new Auth();
        $bool = $auth->check($role, $id);
        return $bool;
    }

    // 管理员用户管理
    public function adminUserManagePage () {
        $admin = \app\serverside\model\Administrators::getAdminAuthGroup();
        $permissions['adminOpen'] = self::judgementAuthority('serverside/Administrators/adminUserOnOffHandle');
        $permissions['adminAuth'] = self::judgementAuthority('serverside/Administrators/adminAuthGroupHandle');
        $permissions['adminDele'] = self::judgementAuthority('serverside/Administrators/adminDeleteHandle');
        $permissions['adminAddPage'] = self::judgementAuthority('serverside/Administrators/adminUserAddPage');
        $this->assign('permissions', $permissions);
        $this->assign('admin',  $admin);
        return $this ->fetch('user/userManagePage');
    }

    # 管理员添加页面
    public function adminUserAddPage () {
        $authGroup = groupModel::authGroupOpenAll();
        $this->assign('authGroup', $authGroup);
        return $this ->fetch('user/userAddPage');
    }

    # 管理员添加处理
    public function adminUserAddHandle (Request $request)
    {
        $data = $request->post();
        $user = new \app\serverside\model\Administrators();
        $userInfo = $user->adminUserAdd($data, $request->ip());
        if ($userInfo['code'] === -1) return json($userInfo);
        if ($userInfo['code'] === 0 ) {
            $auth = new accessModel();
            $auth->adminAuthAccessAdd($userInfo['group']);
            OperationRecord::operationRecordAdd(2, '管理员用户('.$data['username'].')');
            $tomail = $data['email'];
            $name = $data['username'];
            $subject = 'ZXXCMS管理员账号激活邮件';
            $content = '恭喜您,你成功成为一名管理员';
            $mail = new SendMail($tomail,$name, $subject, $content);
            $result = $mail->sendMailAction();
            if (!$result) Log::error('发送邮件失败');
        }
        return json(['code'=>200, 'mge'=> '添加管理员成功,激活邮件已发送!']);
    }

    # 管理员开启/禁用
    public function adminUserOnOffHandle (Request $request)
    {
        if (!$request ->isAjax()) abort(404,  $this->tipe404);
        $adminId = $request->post('adminId');
        $status = \app\serverside\model\Administrators::setAdminOnOff($adminId);
        dump($status);
    }

    # 管理员权限分配
    public function adminAuthGroupHandle (Request $request)
    {
    }

    # 管理员删除
    public function adminDeleteHandle (Request $request)
    {
    }
}
