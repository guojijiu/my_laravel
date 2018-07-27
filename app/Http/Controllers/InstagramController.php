<?php

namespace App\Http\Controllers;


use InstagramAPI\Instagram;

class InstagramController
{
    public function login()
    {
        $username = '11';
        $password = '22';
        $ig = new Instagram(true, false);
        try {
            $ig->login($username, $password);
        } catch (\Exception $e) {
            echo 'Something went wrong: ' . $e->getMessage() . "\n";
            exit(0);
        }
    }
}