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

    /**
     * @param $groupId
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 通过ID获取权限组内容
     */
    public static function getGroupIdFind ($groupId) {
        if (!intval($groupId)) return false;
        $group = self::where('id', 'eq', $groupId)->find();
        if (empty($group)) return false;
        return $group ->toArray();
    }

    /**
     * @param $data
     * @return bool|int
     * 权限组修改
     */
    public static function setAuthGroupUpdate ($data) {
        if (!is_array($data)) return false;
        $rules = implode(',',$data['id']);
        $dataInfo = [
            'title' => $data['name'],
            'rules' => $rules,
            'group_desc' => $data['desc']
        ];
        $group = self::where('id', 'eq', $data['groupId'])
            ->update($dataInfo);
        if ($group) return 0;
        return false;
    }

    /**
     * @param int $page
     * @param string $key
     * @return mixed
     * @throws \think\exception\DbException
     * 获取所有权限组分页/搜索
     */
    public static function getAllAuthGroupPage ($page = 10, $key = "") {
        $group = self::where('title', 'like', '%' . $key . '%')
            ->field('id,title,status,group_desc')
            ->paginate($page, false, ['query' => request()->param()]);
        $groupArray = $group->toArray();
        $groupArray['page'] = $group->render();
        return $groupArray;
    }

    /**
     * @param $groupId
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 权限组开关
     */
    public static function setAuthGroupStatus ($groupId) {
        if (intval($groupId) == 0) return false;
        $group = self::where('id', 'eq', $groupId)->find();
        if (empty($group)) return false;
        $status = $group ->status == 1 ? 0 : 1;
        $data = self::where('id', 'eq', $groupId)->update(['status' => $status]);
        $data === 1 ? $response['code'] = 0 : $response['code'] = -1;
        $status === 1 ? $response['mge'] = '开启成功' : $response['mge'] = '关闭成功';
        return $response;
    }

    /**
     * @param $groupId
     * @return bool|int
     * 权限组删除
     */
    public static function authGroupDelete ($groupId) {
        $group = self::destroy($groupId);
        if ($group) return $response = ['code' => 0];
        return false;
    }
}
