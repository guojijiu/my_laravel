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
//            $result = $instagram->getPaginateMedias('kyo1122');
//            $medias = $result['medias'];
//            if ($result['hasNextPage'] === true) {
//                $result = $instagram->getPaginateMedias('kyo1122', $result['maxId']);
//                $medias = array_merge($medias, $result['medias']);
//            }
//            return $medias;
            $nonPrivateAccountMedias = $instagram->getMedias('kyo1122');
            print_r($nonPrivateAccountMedias);exit();
            if (empty($nonPrivateAccountMedias)) {
                return true;
            }
            $result = [];
            foreach ($nonPrivateAccountMedias as $key => $item) {
                $account = $item->getOwner();
                $result[$key]['user_id'] = $account->getId();
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

                if($item->getType() == 'video'){
                    $result[$key]['video1'] = $item->getVideoLowBandwidthUrl();
                    $result[$key]['video2'] = $item->getVideoLowResolutionUrl();
                    $result[$key]['video3'] = $item->getVideoStandardResolutionUrl();
                    $result[$key]['video4'] = $item->getVideoViews();
                }

            }
            return $result;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }
}
