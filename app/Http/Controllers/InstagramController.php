<?php

namespace App\Http\Controllers;

use Vinkla\Instagram\Instagram;

class InstagramController
{
    public function login()
    {
        try {
            $instagram = Instagram::withCredentials('MrXinrain', 'a5711947');
            $instagram->login();
            $account = $instagram->getAccountById(3);
            echo $account->getUsername();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
