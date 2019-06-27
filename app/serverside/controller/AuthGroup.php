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
use app\serverside\model\AuthRule;
use app\serverside\model\OperationRecord;
use think\Request;

class AuthGroup extends BaseServer
{
    // 权限组管理页面
    public function authGroupManagePage ($key = '') {
        $group = groupModel::getAllAuthGroupPage(10, $key);
        $pageTips = config('public.page_tips_content');
        $this ->assign('pageTips', $pageTips['authGroupManagePage']);
        $this ->assign('group', $group['data']);
        $this ->assign('page', $group['page']);
        return $this ->fetch('auth_group/authGroupManage');
    }

    // 权限组添加页面
    public function authGroupAddPage () {
        $rules = AuthRule::getAllOpenRule();
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
        if ($groups['code'] == 0) OperationRecord::operationRecordAdd(2, '权限组('. $groups['groupName'] .')');
        return json($groups);
    }

    // 权限组修改页面
    public function authGroupUpdatePage ($groupId) {
        $group = groupModel::getGroupIdFind($groupId);
        if (!$group) abort(404, $this->tipe404);
        $rules = AuthRule::getAllOpenRule();
        $checkRules = explode(',', $group['rules']);
        $this ->assign('rules', $rules);
        $this ->assign('checkRules', $checkRules);
        $this ->assign('groupId', $group['id']);
        $this ->assign('groupName', $group['title']);
        $this ->assign('groupDesc', $group['group_desc']);
        return $this ->fetch('auth_group/authGroupUpdate');
    }

    // 权限组修改操作
    public function authGroupUpdateHandle (Request $request) {
        if (!$request ->isAjax()) abort(404, $this ->tipe404);
        $data = $request ->post();
        if (!isset($data['id'])) return false;
        $group = groupModel::setAuthGroupUpdate($data);
        if ($group == 0) OperationRecord::operationRecordAdd(4, '权限组Id:('.$data['groupId'].')');
        return json($group);
    }

    // 权限组开关
    public function authGroupStatusHandle (Request $request) {
        $groupId = $request ->post('groupId');
        $group = groupModel::setAuthGroupStatus($groupId);
        if (!$request ->isAjax() || !$group) abort(404, $this->tipe404);
        return json($group);
    }

    // 权限组删除
    public function authGroupDelete (Request $request) {
        if (!$request ->isAjax()) abort(404, $this->tipe404);
        $groupId = $request ->post();
        $group = groupModel::authGroupDelete($groupId['groupId']);
        if ($group['code'] == 0) OperationRecord::operationRecordAdd(3, '权限组Id:('. $groupId['groupId'] .')');
        return json($group);
    }

    // 权限组所有权限页面
    public function authGroupRulesPage ($groupId) {
        $group = groupModel::getGroupIdFind($groupId);
        if (!$group) abort(404, $this->tipe404);
        $rules = AuthRule::getRuleIdAllInfo($group['rules']);
        $this ->assign('title', $group['title']);
        $this ->assign('rulesCount', $rules['count']);
        $this ->assign('rules', $rules['data']);
        return $this ->fetch('auth_group/authGroupRules');
    }
}
