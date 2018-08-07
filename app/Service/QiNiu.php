<?php

namespace App\Service;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

/**
 * 七牛图片服务管理
 *
 * Class QiNiu
 * @package App\Services\Parser
 */
class QiNiu
{

    public function __construct()
    {
        $qiNiuConfig = config('storager.qiniu');

        $accessKey = $qiNiuConfig['auth']['accessKey'];
        $secretKey = $qiNiuConfig['auth']['secretKey'];
        $this->auth = new Auth($accessKey, $secretKey);

        $this->bucket = $qiNiuConfig['bucket'];

    }

    /**
     * 生成token
     *
     * @return string
     */
    public function getToken()
    {

        $token = $this->auth->uploadToken($this->bucket);

        return $token;
    }

    /**
     * 上传图片
     *
     * @param $filePath
     * @return mixed
     * @throws \Exception
     */
    public function save($filePath)
    {

        if (empty($filePath)) {
            throw new \InvalidArgumentException('文件路径不能为空');
        }

        $token = $this->getToken();

        $key = 'backstage/star/' . md5(basename($filePath) . time() . rand(1, 99));

        $uploadMgr = new UploadManager();

        list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);

        if (!$err) {
            $data['ident'] = $ret['key'];
            $data['url'] = $ret['key'];
            return $data;
        } else {
            if ($err instanceof \Qiniu\Http\Error) {
                $err = $err->message();
            }

            throw new \Exception($err, '410');
        }
    }

    /**
     * 图片下载
     *
     * @param $imgUrl
     * @return string
     */
    public function download($imgUrl)
    {

        if (empty($imgUrl)) {
            throw new \InvalidArgumentException('图片地址不能为空');
        }

        return $this->auth->privateDownloadUrl($imgUrl);
    }
}