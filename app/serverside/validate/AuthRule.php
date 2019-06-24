<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/22 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AuthRule.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\validate;

use think\Validate;

class AuthRule extends Validate
{
    // 验证规则
    protected $rule = [
        'name' => 'require|unique:AuthRule',
        'title' => 'require|unique:AuthRule',
        'type' => 'require|between:0, 1',
        'status' => 'require|between:0, 1',
        'rank_id' => 'require'
    ];
    // 错误信息
    protected $message = [
        'name.require' => '规则标识不能为空!',
        'name.unique' => '该规则已经存在!',
        'title.require' => '规则标题不能为空!',
        'title.unique' => '该标题已经存在!',
        'type.require' => '附加开关不能为空!',
        'type.between' => '附加开关值只能为0/1!',
        'status.require' => '开关值不能为空!',
        'status.unique' => '开关值只能为0/1!',
        'rank_id.require' => '等级不能为空!',
    ];
    // 模块验证
    protected $scene = [];
}
