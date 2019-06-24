<?php

namespace lib;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/11/19
 * Time: 12:16
 */
class InfiniteMenus
{
    /**
     * 无限级分类打包
     * @param $menu 分类数组
     * @param string $relaName 数组关联字段
     * @param string $html 数组等级标识
     * @param int $cateBelong 顶级分类序号
     * @param int $level 分类等级
     * @return array
     */
    public static function menusFineRecomBination($menu,$relaName='cate_belong',$html='--',$cateBelong=0,$level=0){
        $menuInfo = [];
        foreach ($menu as $v) {
            if($v[$relaName] == $cateBelong){
                $v['level'] = $level+1;
                $v['html'] = str_repeat($html,$level);
                $menuInfo[] = $v;
                $menuInfo = array_merge($menuInfo,self::menusFineRecomBination($menu,$relaName,$html,$v['menu_id'],$level+1));
            }
        }
        return $menuInfo;
    }
}
