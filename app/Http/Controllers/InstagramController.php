<?php

namespace App\Http\Controllers;

use App\Service\Instagram\InstagramScraper\Instagram;

class InstagramController
{
    public function login()
    {
        try {
            $instagram = Instagram::withCredentials('MrXinrain', 'a5711947');
            $instagram->login();
//            $account = $instagram->getAccountById(3);
//            echo $account->getUsername();
            $nonPrivateAccountMedias = $instagram->getMedias('ara_go_0211');
            if (empty($nonPrivateAccountMedias)) {
                return true;
            }
            print_r($nonPrivateAccountMedias);exit();
            $result = [];
            foreach ($nonPrivateAccountMedias as $key => $item) {
                $account = $item->getOwner();
                $result[$key]['user_id'] = $account->getId();
                $result[$key]['user_name'] = $account->getUsername();
                $result[$key]['profile_pic'] = $account->getProfilePicUrl();
                $result[$key]['img'] = $item->getImageHighResolutionUrl();
                $result[$key]['created_time'] = $item->getCreatedTime();
            }
            return $result;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
