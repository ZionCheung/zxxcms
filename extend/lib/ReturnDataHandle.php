<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/22 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> ReturnDataHandle.php ]
 * +----------------------------------------------------------------------
 */

namespace lib;

class ReturnDataHandle
{
    /**
     * @param $obj
     * @return array
     * 将返回值转化成数组
     */
    public static function setReturnArray ($obj) {
        $data = [];
        foreach ($obj as $v) {$data[] = $v ->toArray();}
        return $data;
    }
}
