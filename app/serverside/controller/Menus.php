<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/17
 * Project: zxxcms
 * Class: AdminMenusMenus.php
 */

namespace app\serverside\controller;

use app\serverside\model\AdminMenus;
use app\serverside\model\OperationRecord;
use lib\Catehandle;
use think\Request;
use think\response\Json;
use think\View;

class Menus extends BaseServer
{
    // 导航添加页面
    public function menusAddPage () {
        $menus = AdminMenus::getAppointRankMenus();
        $pageTips = config('public.page_tips_content');
        $view = new View();
        $view->assign('pageTips', $pageTips['menusAddPage']);
        $view->assign('menus', $menus);
        return $view ->fetch('menus/menusAdd');
    }

    // 导航菜单添加处理
    public function menusAddHandle (Request $request) {
        if (!$request ->isAjax()) abort(404, $this->tipe404);
        $menus = $request ->post();
        $menu = new AdminMenus();
        $response = $menu->setMenusAdd($menus);
        if ($response['code'] === 0) OperationRecord::operationRecordAdd(2, '导航菜单('. $response['menusName'] .')');
        return json($response);
    }

    // 导航菜单管理页面
    public function menusManagePage ($keywords = "") {
        $menus = AdminMenus::getAllKeyMenus($keywords);
        $view = new View();
        $pageTips = config('public.page_tips_content');
        if (empty($keywords)) {
            $cate = Catehandle::cateMoreRecomBination($menus, 'menus_id', 'menus_rank');
            $view->assign('menus', $cate);
        } else {
            $view->assign('menus', $menus);
        }
        $view->assign('pageTips', $pageTips['menusManagePage']);
        return $view ->fetch('menus/menusManage');
    }

    // 删除导航
    public function menusDeleteHandle (Request $request) {
        if (!$request ->isAjax()) abort(404, $this->tipe404);
        $menusId = intval($request ->post('menusId'));
        $menus = AdminMenus::setMenusDelete($menusId);
        if ($menus['code'] === 0) {
            OperationRecord::operationRecordAdd(3, '导航菜单('. $menus['menusName'] .')');
        }
        return json($menus);
    }

    // 导航排序
    public function menusSortHandle (Request $request) {
        if (!$request ->isAjax()) abort(404, $this->tipe404);
        $data = $request ->post();
        if (!is_array($data)) return false;
        $menus = AdminMenus::setMenusSort($data);
        return json($menus);
    }

    // 导航开关
    public function menusOpenHandle (Request $request) {
        $data = intval($request ->post('menusId'));
        if (!$request ->isAjax() || $data === 0) abort(404, $this->tipe404);
        $menus = AdminMenus::setMenusOpen($data);
        return json($menus);
    }

    // 编辑导航页面
    public function menusUpdatePage ($menusId) {
        $menus = AdminMenus::getMenusIdFind($menusId);
        if (!$menus) abort(404,$this->tipe404);
        $pageTips = config('public.page_tips_content');
        $view = new View();
        $view ->assign('menus', $menus);
        $view ->assign('pageTips', $pageTips['menusUpdatePage']);
        return $view ->fetch('menus/menusUpdate');
    }

    // 编辑导航处理
    public function menusUpdateHandle (Request $request) {
        if (!$request ->isAjax()) abort(404, $this->tipe404);
        $data = $request ->post();
        $menus = AdminMenus::setUpdateMenus($data['menus']);
        if ($menus === 0) OperationRecord::operationRecordAdd(4, '导航菜单Id:('.$data['menus']['menuId'].')');
        return json($menus);
    }

    // 添加子栏目
    public function menusAddChildPage ($menusId) {
        $menus = AdminMenus::getMenusIdFind($menusId);
        if (!$menus) abort(404,$this->tipe404);
        $view = new View();
        $pageTips = config('public.page_tips_content');
        $view ->assign('menus', $menus);
        $view ->assign('pageTips', $pageTips['menusAddPage']);
        return $view ->fetch('menus/menusAddChild');
    }
}
