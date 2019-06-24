<?php

namespace App\Libs\Sms;

class SmsVerification
{
    private $apiId = 'C17652765';
    private $apiKey = '1308a0ce78f0316d8057e2365c59bc6a';
    private $apiUrl = 'http://106.ihuyi.cn/webservice/sms.php?method=Submit';

    //请求数据到短信接口，检查环境是否 开启 curl init。
    private function post($curlPost,$url){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_NOBODY, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    //将 xml数据转换为数组格式。
    private function xml_to_array($xml){
        $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
        if(preg_match_all($reg, $xml, $matches)){
            $count = count($matches[0]);
            for($i = 0; $i < $count; $i++){
                $subxml= $matches[2][$i];
                $key = $matches[1][$i];
                if(preg_match( $reg, $subxml )){
                    $arr[$key] = $this-> xml_to_array( $subxml );
                }else{
                    $arr[$key] = $subxml;
                }
            }
        }
        return $arr;
    }

    // 生成验证码方式
    private function random($length = 6 , $numeric = 0) {
        PHP_VERSION < '4.2.0' && mt_srand((double)microtime() * 1000000);
        if($numeric) {
            $hash = sprintf('%0'.$length.'d', mt_rand(1, pow(10, $length) - 1));
        } else {
            $hash = '';
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789abcdefghjkmnpqrstuvwxyz';
            $max = strlen($chars) - 1;
            for($i = 0; $i < $length; $i++) {
                $hash .= $chars[mt_rand(0, $max)];
            }
        }
        return $hash;
    }

    //发送短信验证码
    public function send_sms($mobile){
        // 短信接口地址
        $target = $this->apiUrl;
        //获取手机号
        $mobile = $mobile;
        // 生成随机验证码
        $mobile_code = $this->random(6,1);
//        $content = "您的验证码是：".$mobile_code."。请不要把验证码泄露给其他人。" ;
        $content = '验证码：'.$mobile_code.'，请您在5分钟内填写。如非本人操作，请忽略本短信。';
//        $content = '验证码为：'.$mobile_code.'，您正在注册成为文旅频道会员，感谢您的支持！';
        $post_data = "account=".$this->apiId ."&password=".$this->apiKey ."&mobile=".$mobile."&content=".rawurlencode($content);
        $gets = $this-> xml_to_array($this->post($post_data, $target));
        if($gets['SubmitResult']['code']==2){
            $response = [
                'mobile' => $mobile,
                'mobile_code' => $mobile_code
            ];
            return $response;
        }
        return false;
    }
}
