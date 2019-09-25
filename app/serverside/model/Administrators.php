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

    /**
     * @param array $data
     * @param string $ip
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 添加管理员用户
     */
    public function adminUserAdd (array $data, string $ip) : array
    {
        if (!isset($data['auth'])) return ['code' => -1, 'mge' => '至少选择一种角色'];
        $dataInfo = [
            'admin_username' => trim($data['username']),
            'admin_password' => md5($data['pass']),
            'admin_lock_password' => md5($data['pass']),
            'admin_email' => trim($data['email']),
            'admin_telephone' => $data['phone'],
            'admin_token' => md5($data['username']),
            'admin_nickname' => $data['username'],
            'admin_head_portrait' => '/static/assets/images/backstage/admin.jpeg',
            'admin_desc' => '我成为管理员了!',
            'admin_reg_ip' => $ip,
            'admin_login_ip' => 0,
            'admin_reg_time' => time(),
            'admin_login_time' => 0
        ];
        $user = $this->validate('Administrators')->save($dataInfo);
        if (!$user) return ['code' => -1, 'mge' => $this->getError()];
        $userModel = new Administrators;
        $userId = $userModel->where('admin_username', $dataInfo['admin_username'])->find()->admin_id;
        $authArr = [];
        foreach ($data['auth'] as $v) {
            $authArr[] = [
                'uid' => $userId,
                'group_id' => intval($v)
            ];
        }
        return ['code' => 0, 'group' => $authArr];
    }
}
