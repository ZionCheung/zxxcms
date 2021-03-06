<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/10
 * Project: zxxcms
 * Class: IntIDValidator.php
 */
namespace app\api\validate;

class IntIDValidator extends BaseValidator
{
    protected $rule = [
        'id' => 'require|IDIntegerValidate'
    ];

    protected function IDIntegerValidate ($value, $rule = '', $data = '', $field) {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0) {
            return true;
        } else {
            return $field . '必须为整数';
        }
    }
}
