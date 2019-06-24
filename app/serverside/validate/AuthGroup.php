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

class AuthGroup extends Validate
{
    // 验证规则
    protected $rule = [
        'title' => 'require|unique:AuthGroup',
        'status' => 'require|between:0, 1',
        'rules' => 'require',
        'group_desc' => 'require'
    ];
    // 错误信息
    protected $message = [
        'title.require' => '名称不能为空!',
        'title.unique' => '名称已经存在!',
        'status.require' => '开关值不能为空!',
        'status.unique' => '开关值只能为0/1!',
        'rules.require' => '规则不能为空',
        'group_desc.require' => '等级不能为空!'
    ];
    // 模块验证
    protected $scene = [];
}
