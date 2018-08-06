<?php

namespace App\Http\Controllers;

use App\Service\Instagram\InstagramScraper\Instagram;

class InstagramController
{
    public function login()
    {
        try {
//            $instagram = Instagram::withCredentials('MrXinrain', 'a5711947');
//            $instagram->login();

            $instagram = new Instagram();

            $account = $instagram->getAccount('kyo1122');
            $imgData = StarDynamic::query()
                ->where('resource_user_id', $account->getId())
                ->get(['id', 'resource_id'])
                ->keyBy('resource_id')
                ->toArray();

            $userCount = count($imgData);

            $number = $userCount >= 100 ? 10 : 100;

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
                $resourceData[$resourceId]['img_urls'] = json_encode($item->getImageHighResolutionUrl());
                $resourceData[$resourceId]['caption'] = $item->getCaption();
                $resourceData[$resourceId]['created_at'] = $item->getCreatedTime();

                //组图相关
                if ($item->getType() == 'sidecar') {
                    $media = $instagram->getMediaByUrl($item->getLink());
                    $imageUrls = [];

                    foreach ($media->getSidecarMedias() as $sidecarMedia) {
                        $imageUrls[] = $sidecarMedia->getImageHighResolutionUrl();
                    }

                    $resourceData[$resourceId]['img_urls'] = json_encode($imageUrls);
                }

            }

            $saveData = array_diff_key($resourceData, $imgData);

            if (empty($saveData)) {
                echo 'no data';
            }

            StarDynamic::query()->insert($saveData);

        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }
}
