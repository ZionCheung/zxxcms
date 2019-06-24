<?php
/**
 * User: ZionCheung.
 * Date: 2019/6/10
 * Project: zxxcms
 * Class: User.php
 */

namespace app\api\controller\v1;

use app\api\validate\IntIDValidator;
use think\response\Json;

class User
{
    public function getUserInfo ($id) {
        (new IntIDValidator())->autoVerification();
        $response = [
            "video_id" => 78,
            "video_name" => "Cruzr机器人",
            "menu_id"=> 20,
            "user_id"=> 3,
            "video_src"=> "/storage/video/user/190508213925zh.mp4",
            "video_cover"=> "/storage/video/user/190508213925.jpg",
            "video_desc"=> "类人型+全自由度双臂+全向自由运动=Cruzr智能机器人，赶快体验吧！咨询电话：13193059365邓先生",
            "is_open"=> 1,
            "video_time"=> 1557323391,
            "video_duration"=> 0,
            "video_clicks"=> 90,
            "video_delete_time"=> 0
        ];
        $response = Json::create($response);
        return $response;
    }
}
