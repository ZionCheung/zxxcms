<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/16 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AuthGroupAccess.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\model;

use think\Model;

class AuthGroupAccess extends Model
{
    protected $table = 'zxx_admin_auth_group_access';

    /**
     * @param array $data
     * @throws \Exception
     * 新增用户权限
     */
    public function adminAuthAccessAdd (array $data)
    {
        $this->saveAll($data);
    }
}
