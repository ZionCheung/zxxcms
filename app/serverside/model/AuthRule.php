<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/16 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AuthRule.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\model;

use lib\ReturnDataHandle;
use lib\Catehandle;
use think\Model;

class AuthRule extends Model
{
    protected $table = 'zxx_admin_auth_rule';

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取所有打开着的顶级规则
     */
    public static function getAllOpenTrueTopRule () {
        $rule = self::where('status', 'eq', 1)
            ->where('rank_id', 'eq', 0)
            ->field('id,title')
            ->order('id', 'asc')
            ->select();
        return ReturnDataHandle::setReturnArray($rule);
    }

    /**
     * @param $data
     * @return array|bool
     * 规则添加
     */
    public function setAuthRuleAdd ($data) {
        $rule = [
            'name' => trim($data['ruleName']),
            'title' => $data['ruleTitle'],
            'type' => intval($data['ruleType']),
            'status' => intval($data['ruleOpen']),
            'condition' => $data['ruleCondition'],
            'rank_id' => intval($data['ruleRank'])
        ];
        if (empty($rule['name']) || empty($rule['title'])) return false;
        $rules = $this ->validate('AuthRule') ->save($rule);
        if ($rules) { $response = ['code'=>0, 'ruleName'=>$rule['title']];}
        else { $response = ['code' => -1, 'mge' => $this->getError()]; }
        return $response;
    }

    /**
     * @param int $page
     * @param string $keyword
     * @return array
     * @throws \think\exception\DbException
     * 规则获取,关键字,分页
     */
    public static function getAllRulePage ($page = 10, $keyword="") {
        $rule = self::where('name|title', 'like', '%' . $keyword . '%')
            ->field('id,name,title,status')
            ->paginate($page, false, ['query' => request()->param()]);
        $ruleArray = $rule->toArray();
        $ruleArray['page'] = $rule->render();
        return $ruleArray;
    }

    /**
     * @param $ruleId
     * @return array|bool
     * 权限规则删除
     */
    public static function setAuthRuleDelete ($ruleId) {
        $rule = self::destroy($ruleId);
        if ($rule) return $response = ['code' => 0] ;
        return false;
    }

    /**
     * @param $ruleId
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 权限规则开关
     */
    public static function setAuthRuleOpen ($ruleId) {
        $ruleOpen = self::where('id', 'eq', $ruleId)
            ->field('status')
            ->find();
        if (empty($ruleOpen)) return false;
        $open = $ruleOpen->status == 1 ? 0 : 1;
        $rule = self::where('id', $ruleId)
            ->update(['status' => $open]);
        $rule === 1 ? $response['code'] = 0 : $response['code'] = -1;
        $open === 1 ? $response['mge'] = '开启成功' : $response['mge'] = '关闭成功';
        return $response;
    }

    /**
     * @param $ruleId
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 根据Id获取规则信息
     */
    public static function getRuleIdFind ($ruleId) {
        if (intval($ruleId) == 0) return false;
        $rules = self::where('id', 'eq', $ruleId)
            ->field('type,status', true)
            ->find();
        if (empty($rules)) return false;
        return $rules ->toArray();
    }

    /**
     * @param $data
     * @return bool|int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 权限规则更新处理
     */
    public static function setRuleUpdate ($data) {
        if (intval($data['ruleId']) == 0) return false;
        $rule = self::where('id', 'eq', $data['ruleId'])->find();
        if (empty($rule)) return false;
        $dataInfo = [
            'name' => $data['ruleName'],
            'title' => $data['ruleTitle'],
            'condition' => $data['ruleCondition'],
            'rank_id' => $data['ruleRank']
        ];
        $rules = self::where('id', 'eq', $data['ruleId'])
            ->update($dataInfo);
        if ($rules) return 0;
        return false;
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取所有打开的权限规则
     */
    public static function getAllOpenRule () {
       $rules = self::where('status', 'eq', 1)
           ->field('id,title,rank_id')
           ->order('id','asc')
           ->select();
       $ruleArray = ReturnDataHandle::setReturnArray($rules);
       $rule = Catehandle::cateMoreRecomBination($ruleArray, 'id', 'rank_id');
       return $rule;
    }
}
