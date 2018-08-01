<?php

namespace App\Http\Controllers;

use App\Service\Instagram\InstagramScraper\Instagram;

class InstagramController
{
    public function login()
    {
        try {
            $ig = Instagram::withCredentials('MrXinrain', 'a5711947');
            $ig->login();
            $account = $ig->getAccountById(3);
            echo $account->getUsername();

        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
