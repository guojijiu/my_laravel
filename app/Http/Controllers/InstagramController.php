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
            $nonPrivateAccountMedias = $instagram->getMedias('kevin');
            echo $nonPrivateAccountMedias[0]->getLink();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
