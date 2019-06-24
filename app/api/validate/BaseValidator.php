<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/10
 * Project: zxxcms
 * Class: BaseValidator.php
 */
namespace app\api\validate;

use think\Exception;
use think\Request;
use think\Validate;

class BaseValidator extends Validate
{
    public function autoVerification () {
        $request = Request::instance();
        $params = $request->param();
        $result = $this->check($params);
        if (!$result) {
            $error = $this->getError();
            throw new Exception($error, 100922);
        } else {
            return true;
        }
    }
}
