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
             print_r($nonPrivateAccountMedias);

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
