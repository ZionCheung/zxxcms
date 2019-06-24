<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/16 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AuthGroup.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\model;

use think\Model;

class AuthGroup extends Model
{
    protected $table = 'zxx_admin_auth_group';

    /**
     * @param $data
     * @return array|bool
     * 添加权限组
     */
    public function setAuthGroupAdd ($data) {
        if (!is_array($data)) return false;
        $rules = implode(',', $data['id']);
        $dataInfo = [
            'title' => $data['name'],
            'status' => 1,
            'rules' => $rules,
            'group_desc' => $data['desc']
        ];
        $group = $this ->validate('AuthGroup') ->save($dataInfo);
        if ($group) {
            $response = ['code' => 0, 'groupName' => $dataInfo['title']];
        } else {
            $response = ['code' => -1, 'mge' => $this->getError()];
        }
        return $response;
    }
}
