<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/10
 * Project: zxxcms
 * Class: Client.php
 */

namespace app\client\controller;

use app\serverside\model\AdminCustomizeLink;
use app\serverside\model\Administrators;
use think\View;

class Client
{
    public function clientIndex () {
        $user = Administrators::getAdminCustomizeLink();
        dump(time());
    }
}
