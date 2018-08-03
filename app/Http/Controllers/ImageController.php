<?php

namespace App\Http\Controllers;

use App\Service\QiNiu;
use Illuminate\Http\Request;

/**
 * 图片控制器
 *
 * Class ImageController
 * @package App\Http\Controllers\Basic
 */
class ImageController
{

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

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
     * @return mixed
     */
    public function uploadImage()
    {
        try {
            $qiNiuParser = new QiNiu();

            $filePath = $this->request['file_path'];

            $result = $qiNiuParser->save($filePath);

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
    public function download()
    {
        $filePath = $this->request['file_path'];

        $qiNiuParser = new QiNiu();

        return $qiNiuParser->download($filePath);
    }
}