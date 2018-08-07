<?php

namespace App\Http\Controllers;

use App\Model\StarDynamic;
use App\Service\Instagram\InstagramScraper\Instagram;

class InstagramController
{
    public function login()
    {

        try {
//            $instagram = Instagram::withCredentials('MrXinrain', 'a5711947');
//            $instagram->login();

            $instagram = new Instagram();

            //根据用户名获取instagram账号基本信息
            $account = $instagram->getAccount('kyo1122');

            //获取当前明星已存数据
            $imgData = StarDynamic::query()
                ->where(['resource_user_id' => $account->getId(), 'resource_from' => 'instagram'])
                ->get(['id', 'resource_id'])
                ->keyBy('resource_id')
                ->toArray();

            $userCount = count($imgData);

            $number = $userCount >= 100 ? 10 : 100;

            //根据用户名获取instagram账号动态信息
            $nonPrivateAccountMedias = $instagram->getMedias('kyo1122', $number);

            if (empty($nonPrivateAccountMedias)) {
                return true;
            }

            $resourceData = [];

            foreach ($nonPrivateAccountMedias as $item) {

                $resourceId = $item->getId();

                //用户信息
                $resourceData[$resourceId]['star_id'] = '11';
                $resourceData[$resourceId]['resource_user_id'] = $account->getId();
//                $resourceData[$key]['user_name'] = $account->getUsername();
//                $resourceData[$key]['full_name'] = $account->getFullName();
//                $resourceData[$key]['pro_file_pic'] = $account->getProfilePicUrl();

                //图片相关

                $resourceData[$resourceId]['resource_id'] = $resourceId;
                $resourceData[$resourceId]['resource_from'] = 'instagram';
                $resourceData[$resourceId]['resource_type'] = $item->getType();
                $resourceData[$resourceId]['caption'] = $item->getCaption();
                $resourceData[$resourceId]['created_at'] = date('Y-m-d H:i:s', $item->getCreatedTime());

                //组图相关
                if ($item->getType() == 'sidecar') {

                    $media = $instagram->getMediaByUrl($item->getLink());

                    $imgUrls = [];
                    foreach ($media->getSidecarMedias() as $sidecarMedia) {

                        $imgUrl = $sidecarMedia->getImageThumbnailUrl();

                        //图片上传到七牛服务器
//                        $fileName = $this->downloadImg($imgUrl);

                        $imgUrls[] = $imgUrl;
                    }

                    $resourceData[$resourceId]['img_urls'] = implode(',', $imgUrls);

                } else {
                    //单图

                    $imgUrl = $item->getImageThumbnailUrl();

                    //图片上传到七牛服务器
//                    $fileName = $this->downloadImg($imgUrl);

                    $resourceData[$resourceId]['img_urls'] = $imgUrl;
                }

            }

            $saveData = array_diff_key($resourceData, $imgData);

            if (empty($saveData)) {
                return 'no data';
            }

            StarDynamic::query()->insert($saveData);

            return 'save ok!';

        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * 处理脚本数据
     */
    public function dealImg()
    {
        StarDynamic::query()
            ->where(['is_dealed' => '2', 'resource_from' => 'instagram'])
            ->chunk(10, function ($starData) {

                if (empty($starData)) {
                    return true;
                }

                foreach ($starData as $starInfo) {

                    if (strpos($starInfo['img_urls'], ',')) {

                        $imgUrls = explode(',', $starInfo['img_urls']);

                        $fileName = [];

                        array_walk($imgUrls, function ($imgUrl) use (&$fileName) {
                            $fileName = $this->downloadImg($imgUrl);
                        });

                    } else {

                        $fileName = $this->downloadImg($starInfo['img_urls']);
                    }

                    $updateFileName = is_array($fileName) ? implode(',', $fileName) : $fileName;

                    $starInfo->update(['is_dealed' => 1, 'img_urls' => $updateFileName]);
                }
            });
    }

    /**
     * 下载图片
     *
     * @param $imgUrl
     * @return mixed
     */
    private function downloadImg($imgUrl)
    {
        $suffix = substr(strrchr($imgUrl, '.'), 1);

        $img = file_get_contents($imgUrl);

        $fileName = date('YmdHis') . rand(1, 99) . '.' . $suffix;

        file_put_contents($fileName, $img);

        return $this->updateImg($fileName);

    }

    /**
     * 上传图片
     *
     * @param $filePath
     * @return mixed
     */
    private function updateImg($filePath)
    {

        $imgObj = new ImageController();

        $key = 'backstage/star/' . md5(basename($filePath) . time() . rand(1, 99));

        $imgObj->uploadImage($key, $filePath);

        unlink($filePath);

        return $key;
    }
}
