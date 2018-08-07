<?php

namespace App\Http\Controllers;

use App\Service\QiNiu;

/**
 * 图片控制器
 *
 * Class ImageController
 * @package App\Http\Controllers\Basic
 */
class ImageController
{

    /**
     * 获取七牛图片服务器token
     *
     * @return mixed
     */
    public function getQiNiuToken()
    {

        $qiNiuParser = new QiNiu();

        $token = $qiNiuParser->getToken();

        return $token;
    }

    /**
     * 图片上传
     *
     * @param $key
     * @param $filePath
     * @return mixed
     */
    public function uploadImage($key, $filePath)
    {
        try {
            $qiNiuParser = new QiNiu();

            $result = $qiNiuParser->save($key, $filePath);

        } catch (\Exception $e) {
            throw new \LogicException($e->getMessage());
        }

        return $result;

    }

    /**
     * 图片下载
     *
     * @return string
     */
    public function download($imgUrl)
    {

        $qiNiuParser = new QiNiu();

        return $qiNiuParser->download($imgUrl);
    }
}