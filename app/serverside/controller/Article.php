<?php
/**
 * +----------------------------------------------------------------------
 * | Developer [ ZionCheung ]
 * +----------------------------------------------------------------------
 * | Creation Time  [ 2019/9/29 ]
 * +----------------------------------------------------------------------
 * | Current File Name  [ zxxcms -> Article.php ]
 * +----------------------------------------------------------------------
 */
namespace app\serverside\controller;

class Article extends BaseServer
{
    # 文章管理页面
    public function articleManagePage ()
    {
    }

    # 文章添加页面
    public function articleAddPage ()
    {
        return $this->fetch('article/articleAdd');
    }

    # 文章添加处理
    public function articleAddHandle ()
    {
    }

    # 文章更新页面
    public function articleUpdatePage ()
    {
    }

    # 文章更新处理
    public function articleUpdateHandle ()
    {
    }

    # 文章加入回收站
    public function articleAddRecyle ()
    {
    }

    # 文章显示/隐藏修改
    public function articleOpenRevise ()
    {
    }

    # 文章排序修改
    public function articleSortRevise ()
    {
    }

    # 文章回收站页面
    public function articleRecyclePage ()
    {
    }

    # 文章恢复处理
    public function articleRecoveryHandle ()
    {
    }

    # 文章删除
    public function articleDelete ()
    {
    }
}

