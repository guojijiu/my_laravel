<?php

namespace App\Http\Controllers;


use InstagramAPI\Instagram;

class InstagramController
{
    public function login()
    {
        //允许使用web进行接口调用
        \InstagramAPI\Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
        $username = 'MrXinrain';
        $password = 'a5711947';
        $ig = new Instagram(true, false);
        try {
            $ig->login($username, $password);
        } catch (\Exception $e) {
            throw new \LogicException($e->getMessage());
        }
    }
}
