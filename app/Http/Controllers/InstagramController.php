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

            //分页查询
//            $result = $instagram->getPaginateMedias('kyo1122');
//            $medias = $result['medias'];
//            if ($result['hasNextPage'] === true) {
//                $result = $instagram->getPaginateMedias('kyo1122', $result['maxId']);
//                $medias = array_merge($medias, $result['medias']);
//            }
//            return $medias;
            $nonPrivateAccountMedias = $instagram->getMedias('kyo1122');
            if (empty($nonPrivateAccountMedias)) {
                return true;
            }
            $result = [];

            foreach ($nonPrivateAccountMedias as $key => $item) {

                $userId = $item->getOwnerId();
                $result[$key]['type'] = $item->getType();
                $result[$key]['img_src'] = $item->getImageHighResolutionUrl();
                $result[$key]['caption'] = $item->getCaption();
                $result[$key]['created_time'] = $item->getCreatedTime();

                if ($item->getType() == 'sidecar') {
                    $media = $instagram->getMediaByUrl($item->getLink());

                    foreach ($media->getSidecarMedias() as $sidecarMedia) {
                        $result[$key]['sidecar_media'][] = $sidecarMedia->getImageHighResolutionUrl();
                    }
                }

            }

            $account = $instagram->getUsernameById($userId);
            print_r($account);exit();
            foreach ($account as $userInfo) {

                $result[$key]['user_id'] = $userInfo->getId();
                $result[$key]['user_name'] = $userInfo->getUsername();
                $result[$key]['full_name'] = $userInfo->getFullName();
                $result[$key]['pro_file_pic'] = $userInfo->getProfilePicUrl();

            }

            return $result;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }
}
