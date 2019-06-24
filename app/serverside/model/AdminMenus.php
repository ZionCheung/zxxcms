<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/6/16 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> AdminMenus.php ]
 * +----------------------------------------------------------------------
 */

namespace app\serverside\model;

use think\Model;

class AdminMenus extends Model
{
    /**
     * @var array
     * 只读字段
     */
    protected $readonly = ['menus_link', 'menus_time', 'menus_rank'];

    /**
     * @param $obj
     * @return array
     * 将返回值转化成数组
     */
    private static function setReturnArray ($obj) {
        $data = [];
        foreach ($obj as $v) {$data[] = $v ->toArray();}
        return $data;
    }

    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取所有导航
     */
    public static function getAllOpenTrueMenus () {
        $menus = self::where('menus_open', 1)
            ->order('menus_sort')
            ->field('menus_delete,menus_delete_time',true)
            ->select();
        return self::setReturnArray($menus);
    }

    /**
     * @param int $menuRank -- 等级 默认为顶级
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取指定等级/打开着的导航
     */
    public static function getAppointRankMenus ($menuRank = 0) {
        $menuRank = intval($menuRank);
        $menus = self::where('menus_open', 1)
            ->where('menus_rank', $menuRank)
            ->order('menus_sort')
            ->field('menus_id,menus_name')
            ->select();
        return $menus;
    }

    /**
     * @param $menus
     * @return array
     * 添加导航菜单
     */
    public function setMenusAdd ($menus) {
        $randomLink = substr(md5(substr('abcd12349876poiumh', mt_rand(0, 10), mt_rand(1, 8))),mt_rand(0, 15), mt_rand(5, 8));
        foreach ($menus as $v) {
            $menuLink = intval($v['menuRank']) === 0 ? $randomLink : $v['menuLink'];
            $data = [
                'menus_name' => $v['menuName'],
                'menus_icon' => $v['menuIcon'],
                'menus_link' => $menuLink,
                'menus_open' => intval($v['menuOpen']),
                'menus_time' => time(),
                'menus_rank' => intval($v['menuRank']),
                'menus_sort' => intval(100),
                'menus_eng_name' => $v['menuEngName']
            ];
        }
        $menus = $this->validate('AdminMenus')->save($data);
        if ($menus) {
            $response = ['code' => 0, 'menusName' => $data['menus_name']];
        } else {
            $response = ['code' => -1, 'mge' => $this->getError()];
        }
        return $response;
    }

    /**
     * @param string $keywords
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取所有值/指定key值
     */
    public static function getAllKeyMenus($keywords = "") {
        if (empty($keywords)) {
            $menus = self::field('menus_delete,menus_delete_time', true)
                ->order('menus_sort', 'asc')->select();
            return self::setReturnArray($menus);
        } else {
            $data = self::where('menus_name', 'like', '%'. $keywords .'%')
                ->where('menus_rank','eq', 0)
                ->order('menus_sort', 'asc')
                ->select();
            $menus = self::setReturnArray($data);
            foreach ($menus as &$v) {
                    $dataInfo = self::where('menus_rank', $v['menus_id'])
                    ->field('menus_delete,menus_delete_time', true)
                    ->order('menus_sort','asc')
                    ->select();
                    $v['child'] = self::setReturnArray($dataInfo);
            }
            return $menus;
        }
    }

    /**
     * @param $menusId
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 删除导航菜单
     */
    public static function setMenusDelete ($menusId) {
        if ($menusId === 0) return false;
        $menus = self::where('menus_rank', $menusId)
            ->field('menus_id')
            ->find();
        if (!is_null($menus)) {
            $response = ['code' => -1, 'mge' => '请先删除子菜单'];
        } else {
            $menusName = self::get($menusId) ->menus_name;
            $delete = self::destroy($menusId);
            $response = ['menusName' => $menusName];
            $delete == 1 ? $response['code'] = 0: $response['code'] = -2;
        }
        return $response;
    }

    /**
     * @param $data
     * @return bool
     * 导航排序
     */
    public static function setMenusSort ($data) {
        if (intval($data['menuId']) === 0 || intval($data['menuSort']) === 0) return false;
        $menus = self::where('menus_id', intval($data['menuId']))
            ->update(['menus_sort' => intval($data['menuSort'])]);
        $menus === 1 ? $response['code'] = 0 : $response['code'] = -1;
        return $response;
    }

    /**
     * @param $menusId
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 导航开关
     */
    public static function setMenusOpen ($menusId) {
        $menusOpen = self::where('menus_id', $menusId)
            ->field('menus_open')->find();
        if (empty($menusOpen)) return false;
        $open = $menusOpen->menus_open == 1 ? 0 : 1;
        $menus = self::where('menus_id', $menusId)
            ->update(['menus_open' => $open]);
        $menus === 1 ? $response['code'] = 0 : $response['code'] = -1;
        $open === 1 ? $response['mge'] = '开启成功' : $response['mge'] = '关闭成功';
        return $response;
    }

    /**
     * @param $menusId
     * @return array|bool
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 获取修改信息 通过导航ID
     */
    public static function getMenusIdFind ($menusId) {
        if (intval($menusId) == 0) return false;
        $menus = self::where('menus_id', $menusId)
            ->field('menus_id, menus_name, menus_eng_name, menus_icon')->find();
        if (empty($menus)) return false;
        return $menus->toArray();
    }

    /**
     * @param $data
     * @return bool|int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * 导航修改更新
     */
    public static function setUpdateMenus ($data) {
        if (intval($data['menuId']) == 0) return false;
        $menus = self::where('menus_id', $data['menuId']) ->find();
        if (empty($menus)) return false;
        $dataInfo = [
            'menus_name' => $data['menuName'],
            'menus_icon' => $data['menuIcon'],
            'menus_eng_name' => $data['menuEngName']
        ];
        $menu = self::where('menus_id', $data['menuId'])->update($dataInfo);
        if ($menu) return 0;
        return false;
    }
}
