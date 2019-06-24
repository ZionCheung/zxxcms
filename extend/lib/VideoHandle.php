<?php

namespace lib;

use Illuminate\Support\Facades\Storage;
use FFMpeg;

class VideoHandle
{
    private static $ffmpeg = [
        'ffmpeg.binaries'  => '/usr/bin/ffmpeg', // FFmpeg 执行目录
        'ffprobe.binaries' => '/usr/bin/ffprobe',
//        'timeout' => 30000, // 进程超时时间
//        'ffmpeg.threads' => 12 // ffmpeg使用的线程
    ];

    /**
     * 视频合并
     * @param $folderName 合并内容文件夹名
     * @param $extension 合并后扩展名
     * @param $fileRoute 合并内容路径
     * @return string
     */
    public static function videoSubsectionMerge ($folderName, $extension, $fileRoute, $moveFolderName) {
        $path = storage_path('app/'.$fileRoute.'/').$folderName.'/';
        $files = array_slice(scandir($path),2);
        $binFiles = array_slice($files, 1);
        sort($binFiles, SORT_NUMERIC);
        foreach ($binFiles as $k => $v) {
            $finalFile = file_put_contents($path.$files[0], file_get_contents($path.$v), FILE_APPEND);
        }
        $newVideoName = date('ymdHis').'.'.$extension;
        $a = Storage::move($fileRoute.'/'.$folderName.'/'.$files[0], 'public/video/'.$moveFolderName.'/'.$newVideoName);
        $b = Storage::disk($fileRoute)->deleteDirectory($folderName);
        return '/storage/video/'.$moveFolderName.'/'.$newVideoName;
    }

    /**
     * @param $videoRoute
     * @return string
     * 截取封面图
     */
    public static function videoTransformation ($videoRoute) {
        $route = substr($videoRoute, 8); // 获取路径
        $videoRouter = storage_path().'/app/public'.$route; // 视频路径封装
        $imgRouter =storage_path().'/app/public'.substr($route, 0, strrpos($route, '.')).'.jpg'; // 封面路径封装
        $ffmpeg = FFMpeg\FFMpeg::create(self::$ffmpeg);
        $video = $ffmpeg->open($videoRouter);
        $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(2)) // 封面截取
            ->save($imgRouter);
        return '/storage'.substr($route, 0, strrpos($route, '.')).'.jpg';
    }

    /**
     * @param $videoRoute
     * @return string
     * 视频转码
     */
    public static function videoFormatConversion ($videoRoute)
    {
        $route = substr($videoRoute, 8);
        $videoRouter = storage_path() . '/app/public' . $route;
        $newRoute = storage_path() . '/app/public' . substr($route, 0, strrpos($route, '.')) . 'zh.mp4';
        $ffmpeg = FFMpeg\FFMpeg::create(self::$ffmpeg);
        $video = $ffmpeg->open($videoRouter);
        $video->filters()->resize(new FFMpeg\Coordinate\Dimension(960, 540), FFMpeg\Filters\Video\ResizeFilter::RESIZEMODE_INSET, true)
            ->synchronize();
        $format = new FFMpeg\Format\Video\X264('aac', 'libx264');
        $format->on('progress', function ($video, $format, $percentage) {
            echo "$percentage % 进度";
        });
        $format
            ->setKiloBitrate(1500)
            ->setAudioChannels(2)
            ->setAudioKiloBitrate(157);
        $video->save($format, $newRoute);
        if (file_exists($videoRouter)) {
            unlink($videoRouter);
        }
        return '/storage' . substr($route, 0, strrpos($route, '.')) . 'zh.mp4';
    }

    /**
     * @param $videoRoute
     * @return mixed
     * 获取视频信息/时长
     */
    public static function getVideoTimeTotal ($videoRoute) {
        $route = substr($videoRoute, 8); // 获取路径
        $videoRouter = storage_path().'/app/public'.$route; // 视频路径封装
        $ffmpeg = FFMpeg\FFMpeg::create(self::$ffmpeg);
        $video = $ffmpeg->open($videoRouter);
        $videoInfo = $video->getFormat()->get('duration');
        return $videoInfo;
    }

    /**
     * @param $videoRoute
     * @param $mp3
     * @return string
     * 音视频合成
     */
    public static function setVideoBgm ($videoRoute, $mp3) {
        $route = substr($videoRoute, 8); // 获取路径
        $mp3 = substr($mp3, 8);
        $videoRouter = storage_path().'/app/public'.$route; // 视频路径封装
        $mp3Router = storage_path().'/app/public'.$mp3;
        $newRoute = storage_path() . '/app/public/123h.mp4';
        $ffmpeg = FFMpeg\FFMpeg::create(self::$ffmpeg);
        return $newRoute;
    }
}
