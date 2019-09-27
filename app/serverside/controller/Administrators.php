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

    # 管理员用户管理页面
    public function adminUserManagePage ($key = '') {
        $admin = \app\serverside\model\Administrators::getAdminAuthGroup($key);
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
        if (!$request ->isAjax()) abort(404,  $this->tipe404);
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
            if (!$result) Log::error('添加管理员激活邮件发送失败');
        }
        return json(['code'=>200, 'mge'=> '添加管理员成功,激活邮件已发送!']);
    }

    # 管理员开启/禁用
    public function adminUserOnOffHandle (Request $request)
    {
        if (!$request ->isAjax()) abort(404,  $this->tipe404);
        $adminId = $request->post('adminId');
        $status = \app\serverside\model\Administrators::setAdminOnOff($adminId);
        if($status['code'] === 0) {
            OperationRecord::operationRecordAdd(4, "管理员(".$status['user'].")的登陆状态");
        } else {
            Log::error('管理员开关异常');
        }
        return json($status);
    }

    #管理员权限分配页面
    public function adminAuthGroupPage ($adminId)
    {
        $authGroup = groupModel::authGroupOpenAll();
        $groupAccess = accessModel::getAdminUserAccess(intval($adminId));
        $userName = \app\serverside\model\Administrators::get(intval($adminId))->admin_username;
        $groupArr['username'] = $userName;
        $groupArr['groupAccess'] = $groupAccess;
        $groupArr['userId'] = $adminId;
        $groupArr['authGroup'] = $authGroup;
        $this->assign('groupArr', $groupArr);
        return $this->fetch('user/userAuthGroupPage');
    }

    # 管理员权限分配
    public function adminAuthGroupHandle (Request $request)
    {
        if (!$request->isAjax()) abort('404', $this->tipe404);
        $data = $request->post();
        $dataInfo = new accessModel();
        $result = $dataInfo->setAdminUserAccessUpdate($data);
        return json($result);
    }

    # 管理员删除
    public function adminDeleteHandle (Request $request)
    {
        if (!$request->isAjax()) abort('404', $this->tipe404);
        $adminId = $request->post('adminId');
        $result = \app\serverside\model\Administrators::setAdminUserDelete(intval($adminId));
        $userName = \app\serverside\model\Administrators::get(intval($adminId))->admin_username;
        if ($result['code'] == 0) OperationRecord::operationRecordAdd(3, "管理员(".$userName.")");
        if (!$result['code'] == -1) Log::error('管理员删除异常');
        return json($result);
    }
}
