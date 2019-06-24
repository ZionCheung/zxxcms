<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/16 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> OperationRecord.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\model;

use think\Db;
use think\Model;
use think\Request;

class OperationRecord extends Model
{
    // 表名
    protected $table = 'zxx_admin_operation_record';
    // 以下字段只能被查询获取
    protected $readonly = [
        'operation_record_time',
        'operation_record_ip',
        'operation_record_desc',
        'administrators_id'
    ];

    /**
     * @param int $type
     * @param $record
     * @return bool
     * 添加操作记录
     */
    public static function operationRecordAdd ($type = 0, $record) {
        // 操作记录开关 配置文件public->operation_record_open
        if (config('public.operation_record_open') === true) {
            switch ($type)
            {
                case 0: $desc = '登陆了后台系统'; break;
                case 1: $desc = '退出了后台系统'; break;
                case 2: $desc = '添加了' . $record; break;
                case 3: $desc = '删除了' . $record; break;
                case 4: $desc = '修改了' . $record; break;
            }
            $adminSession = session('adminSession');
            $data = [
                'operation_record_time' => time(),
                'operation_record_ip' => Request::instance()->ip(),
                'operation_record_desc' => $adminSession['admin_username'].'-'. $desc,
                'operation_record_open' => 1,
                'administrators_id' => $adminSession['admin_id']
            ];
            $response = Db::table('zxx_admin_operation_record')->insert($data);
            if ($response) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
