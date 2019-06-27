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
use think\Controller;

class Client extends Controller
{
    public function clientIndex () {
        $this ->redirect('serverside/home/backHomePage');
    }
}
