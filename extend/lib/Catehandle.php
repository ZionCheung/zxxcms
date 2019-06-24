<?php

namespace lib;

class Catehandle
{
    // 一维数组模式
    public static function cateOneRecomBination ($cate, $cateId, $relaName='cate_belong', $html='', $cateBelong=0, $level=0) {
        $cateInfo = [];
        foreach ($cate as $v) {
            if($v[$relaName] == $cateBelong){
                $v['level'] = $level+1;
                $v['html'] = str_repeat($html,$level);
                $cateInfo[] = $v;
                $cateInfo = array_merge($cateInfo,self::cateOneRecomBination($cate,$relaName,$html,$v[$cateId],$level+1));
            }
        }
        return $cateInfo;
    }
    /**
     * 组合多维数组类型cate
     * $cate [array] 分类数据
     * $relaName [string] 关联键名
     * $childName [string] 子类数组名
     * $cateBelong [intval]
     * return $cateInfo [array]
     */
    public static function cateMoreRecomBination($cate, $cateId, $relaName='cate_belong',$childName='child',$cateBelong=0) {
        $cateInfo = [];
        foreach ($cate as $v) {
            if ($v[$relaName]==$cateBelong){
                $v[$childName] = self::cateMoreRecomBination($cate,$cateId,$relaName,$childName,$v[$cateId]);
                $cateInfo[] = $v;
            }
        }
        return $cateInfo;
    }
    // 通过子级ID 返回所有父级
    public static function cateGetParent ($cate,$childId) {
        $cateInfo = [];
        foreach ($cate as $v) {
            if ($v['id'] == $childId){
                $cateInfo[] = $v;
                $cateInfo = array_merge($cateInfo,self::cateGetParent($cate,$v['id']));
            }
        }
        return $cateInfo;
    }
}
