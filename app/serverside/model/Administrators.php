<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/13
 * Project: zxxcms
 * Class: Administrators.php
 */
namespace app\serverside\model;

use think\Model;

class Administrators extends Model
{
    public function adminCustomizeLink () {
       return $this ->hasMany('CustomizeLink', 'administrators_id', 'admin_id');
    }

    public static function getAdminCustomizeLink () {
        $cLink = self::with('adminCustomizeLink')->where('admin_id', 1)->find();
        return $cLink->toArray();
    }

    /**
     * @param $username
     * @param $password
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取管理员信息 登录
     */
    public static function getUserLoginInfo ($username, $password) {
        $user = self::where('admin_open', 'eq', 1)
            ->where('admin_username', 'eq', $username)
            ->where('admin_password', 'eq', md5($password))
            ->field('admin_delete_time,admin_delete,admin_password,admin_lock_password', true)
            ->find();
        if (empty($user)) return false;
        $response = ['code' => 0, 'userInfo' => $user ->toArray()];
        return $response;
    }
}
