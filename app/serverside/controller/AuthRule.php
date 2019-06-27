<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/20 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AuthRule.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\controller;

use think\Request;
use think\View;
use app\serverside\model\AuthRule as ruleModel;
use app\serverside\model\OperationRecord;

class AuthRule extends BaseServer
{
    // 权限规则管理页面
    public function authRuleManagePage ($keyword = "") {
        $rules = ruleModel::getAllRulePage(10, $keyword);
        $view = new View();
        $view ->assign('rules', $rules['data']);
        $view ->assign('page', $rules['page']);
        return $view ->fetch('auth_rule/authRuleManage');
    }

    // 权限规则添加页面
    public function authRuleAddPage () {
        $rule = ruleModel::getAllOpenTrueTopRule();
        $this ->assign('rule', $rule);
        return  $this ->fetch('auth_rule/authRuleAdd');
    }

    // 权限规则添加处理
    public function authRuleAddHandle (Request $request) {
        if (!$request ->isAjax()) abort(404, $this ->tipe404);
        $data = $request ->post();
        $rule = new ruleModel();
        $result = $rule ->setAuthRuleAdd($data['rules']);
        if ($result['code'] === 0) OperationRecord::operationRecordAdd(2, '权限规则('. $result['ruleName'] .')');
        return json($result);
    }

    // 权限规则删除
    public function authRuleDelete (Request $request) {
        if (!$request ->isAjax()) abort(404, $this->tipe404);
        $ruleId = $request ->post();
        $rule = ruleModel::setAuthRuleDelete($ruleId['ruleId']);
        if ($rule['code'] === 0) OperationRecord::operationRecordAdd(3, '权限规则ID('. $ruleId['ruleId'] .')');
        return json($rule);
    }

    // 权限规则开关
    public function authRuleOpen (Request $request) {
        $data = intval($request ->post('ruleId'));
        if (!$request ->isAjax() || $data === 0) abort(404, $this->tipe404);
        $rule = ruleModel::setAuthRuleOpen($data);
        return json($rule);
    }

    // 权限规则修改页面
    public function authRuleUpdatePage ($ruleId) {
        $rule = ruleModel::getRuleIdFind($ruleId);
        if (!$rule) abort(404, $this->tipe404);
        $ruleRank = ruleModel::getAllOpenTrueTopRule();
        $this->assign('ruleRank', $ruleRank);
        $this->assign('rule', $rule);
        return $this->fetch('auth_rule/authRuleUpdate');
    }

    // 权限规则修改处理
    public function authRuleUpdateHandle (Request $request) {
        $data = $request ->post();
        $rule = ruleModel::setRuleUpdate($data['rules']);
        if ($rule === 0) OperationRecord::operationRecordAdd(4, '权限规则Id:('.$data['rules']['ruleId'].')');
        return json($rule);
    }
}
