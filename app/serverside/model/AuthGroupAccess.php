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

use think\Db;
use think\Exception;
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

    /**
     * @param int $data
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取用户所拥有的权限
     */
    public static function getAdminUserAccess(int $data) : array
    {
        $access = self::where('uid', 'eq', $data)->field('group_id')->select();
        if (empty($access)) return [];
        foreach ($access as $v) {
            $accessData[] = join('', $v->toArray());
        }
        return $accessData;
    }

    /**
     * @param array $data
     * @return array
     * 用户权限修改
     */
    public function setAdminUserAccessUpdate (array $data) : array
    {
        $uid = intval($data['uid']);
        foreach ($data['gid'] as $key => $groupId) {
            $dataInfo[$key] ['uid']= $uid;
            $dataInfo[$key] ['group_id'] = $groupId;
        }
        Db::startTrans();
        try{
            Db::table($this->table)->where('uid', 'eq', $uid)->delete();
            Db::table($this->table)->insertAll($dataInfo);
            Db::commit();
            return ['code' => 0, 'mge' => '修改成功'];
        } catch (Exception $e) {
            Db::rollback();
            return ['code' => -1, 'mge' => $e->getMessage()];
        }
    }
}
