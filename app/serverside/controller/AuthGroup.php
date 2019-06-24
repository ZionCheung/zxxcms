<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/20 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AuthGroup.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\controller;

use app\serverside\model\AuthGroup as groupModel;
use think\Request;

class AuthGroup extends BaseServer
{
    // 权限组管理页面
    public function authGroupManagePage () {
        $authGroup = groupModel::all();
        $this ->assign('group', $authGroup);
        return $this ->fetch('auth_group/authGroupManage');
    }

    // 权限组添加页面
    public function authGroupAddPage () {
        $rules = \app\serverside\model\AuthRule::getAllOpenRule();
        $this ->assign('rules', $rules);
        return $this ->fetch('auth_group/authGroupAdd');
    }

    // 权限组添加操作
    public function authGroupAddHandle (Request $request) {
        if (!$request ->isAjax()) abort(404,  $this->tipe404);
        $data = $request ->post();
        if (!isset($data['id'])) return false;
        $group = new groupModel();
        $groups = $group ->setAuthGroupAdd($data);
        if ($groups['code'] == 0) \app\serverside\model\OperationRecord::operationRecordAdd(2, '权限组('. $groups['groupName'] .')');
        return json($groups);
    }
}
