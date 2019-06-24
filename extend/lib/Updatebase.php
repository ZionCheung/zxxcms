<?php

namespace lib;

class Updatebase
{
    // 处理base64图片格式
    public static function baseImageHandle($data)
    {
        $baseImg = $data;
        $imgData = [];
        // 正则匹配base64内容得到数组
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $baseImg, $result)) {
            // 获取后缀名
            $imgSuffix = $result[2];
            // 生成图片名
            $imageName = substr(md5(time(true)), 1, 6) . "." . $imgSuffix;
            // 生成文件保存路径
            $imageRoute = '.' . DS . 'static' . DS . 'upload' . DS . 'admin' . DS . 'heads' . DS;
            // 判断文件是否存在
            if (!file_exists($imageRoute)) {
                mkdir($imageRoute, 0777, true);
            }
            // 使用base解码函数得到编码  利用函数去掉不需要的内容$result[1]
            $decode = base64_decode(str_replace($result[1], '', $baseImg));
            // 将编码写成图片
            if (file_put_contents($imageRoute . $imageName, $decode)) {
                $imgData = [
                    'imgName' => $imageName,
                    'imgRoute' => $imageRoute,
                    'errno' => 0,
                ];
            } else {
                $imgData = [
                    'errno' => -1,
                    'errmge' => '图片上传失败!'
                ];
            }
        } else {
            $imgData = [
                'errno' => -1,
                'errmge' => '图片格式错误!'
            ];
        }
        return $imgData;
    }
} 