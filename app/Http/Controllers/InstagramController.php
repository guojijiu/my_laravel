<?php

namespace App\Http\Controllers;

use App\Http\Model\StarDynamic;
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
                ->where('resource_user_id', $account->getId())
                ->get(['id', 'resource_id'])
                ->keyBy('resource_id')
                ->toArray();

            $userCount = count($imgData);

            $number = $userCount >= 100 ? 105 : 100;

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

                if ($item->getType() == 'image') {

                    $imgUrl = $item->getImageHighResolutionUrl();

                    //图片上传到七牛服务器
//                    $this->downloadImg($imgUrl);

                    $resourceData[$resourceId]['img_urls'] = $imgUrl;

                }

                //组图相关
                if ($item->getType() == 'sidecar') {
                    $media = $instagram->getMediaByUrl($item->getLink());

                    foreach ($media->getSidecarMedias() as $sidecarMedia) {

                        $imgUrl = $sidecarMedia->getImageHighResolutionUrl();

                        //图片上传到七牛服务器
//                        $this->downloadImg($imgUrl);

                        $resourceData[$resourceId]['img_urls'][] = $imgUrl;
                    }

                }

            }

            $saveData = array_diff_key($resourceData, $imgData);
return $saveData;
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
     * 下载图片
     *
     * @param $imgUrl
     * @return mixed
     */
    private function downloadImg($imgUrl)
    {
        $suffix = substr(strrchr($imgUrl, '.'), 1);

        $img = file_get_contents($imgUrl);

        $fileName = date('YmdHis') . '.' . $suffix;

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

        $result = $imgObj->uploadImage($filePath);

        unlink($filePath);

        return $result;
    }
}
