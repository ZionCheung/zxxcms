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
    /**
     * @param $obj
     * @return array
     * 将返回值转化成数组
     */
    private static function setReturnArray (array $obj) : array
    {
        $data = [];
        foreach ($obj as $v) {$data[] = $v ->toArray();}
        return $data;
    }

    # 管理员自定义链接关联
    public function adminCustomizeLink () {
       return $this ->hasMany('CustomizeLink', 'administrators_id', 'admin_id');
    }

    # 管理员权限组关联
    public function adminAuthGroup ()
    {
        return $this->belongsToMany('AuthGroup','admin_auth_group_access','group_id','uid');
    }

    #管理员自定义连续查询
    public static function getAdminCustomizeLink ()
    {
        $cLink = self::with('adminCustomizeLink')->where('admin_id', 1)->find();
        return $cLink->toArray();
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取管理员信息
     */
    public static function getAdminAuthGroup (string $key) : array
    {
        $authGroup = self::with('adminAuthGroup')
            ->where('admin_delete','eq', 0)
            ->where('admin_username|admin_email|admin_telephone','like', '%'.$key.'%')
            ->field('admin_password,
            admin_lock_password,
            admin_delete,
            admin_delete_time,
            admin_token,', true)
            ->select();
        $adminArr = self::setReturnArray($authGroup);
        foreach ($adminArr as &$v) {
            $v['admin_reg_time'] = date('Y-m-d H:i:s', $v['admin_reg_time']);
            $v['admin_login_time'] = date('Y-m-d H:i:s', $v['admin_login_time']);
            foreach ($v['admin_auth_group'] as $vo) {
                unset($vo['rules']);
                unset($vo['pivot']);
                unset($vo['group_desc']);
                if ($vo['status'] == 1) {
                    $v['auth'][] = $vo; # 判断权限开关组合新数组
                }
                continue;
            }
            unset($v['admin_auth_group']); # 销毁原始数组
        }
        return $adminArr;
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
    public static function getUserLoginInfo ($username, $password, $ip) {
        $user = self::where('admin_open', 'eq', 1)
            ->where('admin_username', 'eq', $username)
            ->field('admin_delete_time,admin_delete,admin_lock_password', true)
            ->find();
        if (empty($user)) return false;
        $userArr = $user->toArray();
        $pass = $userArr['admin_password'];
        if (!password_verify($password, $pass)) return false;
        $data = ['admin_login_ip' => $ip, 'admin_login_time' => time()];
        self::where('admin_username','eq',$username)->update($data);
        $response = ['code' => 0, 'userInfo' => $userArr];
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
            'admin_password' => password_hash($data['pass'], 1),
            'admin_lock_password' => password_hash($data['pass'], 1),
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

    /**
     * @param int $data
     * @return Administrators|null
     * @throws \think\exception\DbException
     * 管理员状态修改
     */
    public static function setAdminOnOff (int $data) : array
    {
        $adminOpen = self::get($data);
        $status = $adminOpen->admin_open == 1 ? 0 : 1;
        $code = self::where('admin_id', $data)->update(['admin_open' => $status]);
        if ($code) return ['code' => 0, 'mge' => '修改成功', 'status'=> $status, 'user' => $adminOpen->admin_username];
        return ['code' => -1, 'mge' => '修改失败,系统出现问题,请稍后再试~~~~~'];
    }

    /**
     * @param int $data
     * @return array
     * 管理员删除 软删除
     */
    public static function setAdminUserDelete (int $data) : array
    {
        $dataInfo = ['admin_delete' => 1, 'admin_delete_time' => time()];
        $result = self::where('admin_id', 'eq', $data)->update($dataInfo);
        if ($result) return ['code' => 0, 'mge' => '删除成功!'];
        return ['code'=> -1, 'mge' => '删除失败,系统出现问题,请稍后再试~~~~~'];
    }

    /**
     * @param string $data 激活账号
     * @return array
     * 激活管理员账号
     */
    public static function adminActivation (string $data) : array
    {
        $dataInfo = self::where('admin_username', 'eq', $data)->update(['admin_open'=> 1]);
        if (!$dataInfo) return ['code' => -1, 'mge'=> '激活失败'];
        return ['code' => 0, 'mge' =>'激活成功'];
    }
}
