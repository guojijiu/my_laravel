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
            $nonPrivateAccountMedias = $instagram->getMedias('kyo1122', 100);
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

                foreach ($item->getSidecarMedias() as $sidecarMedia) {
                    $result[$key]['sidecar_media'][] = $sidecarMedia->getImageHighResolutionUrl();
                }
            }
            return $result;
        } catch (\Exception $e) {
            throw new \InvalidArgumentException($e->getMessage());
        }
    }
}
