<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/10
 * Project: zxxcms
 * Class: Home.php */
namespace app\serverside\controller;

use app\serverside\model\Administrators;
use app\serverside\model\AdminMenus;
use lib\Catehandle;
use think\View;

class Home extends BaseServer
{
    /**
     * @return string
     * @throws \think\Exception
     * 主页框架
     */
    public function backHomePage () {
        $menus = AdminMenus::getAllOpenTrueMenus();
        $cate = Catehandle::cateMoreRecomBination($menus, 'menus_id', 'menus_rank');
        $view = new View();
        $view->assign('cate', $cate);
        return $view->fetch('home/index');
    }

    /**
     * @return string
     * @throws \think\Exception
     * 我的桌面
     */
    public function backHomeInfo () {
        $view = new View();
        return $view->fetch('home/welcome');
    }

    /**
     * @return string
     * @throws \think\Exception
     * 图表统计
     */
    public function chartStatistics () {
        $view = new View();
        return $view ->fetch('home/welcome1');
    }
}
