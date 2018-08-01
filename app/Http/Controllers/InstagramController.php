<?php

namespace App\Http\Controllers;

use Vinkla\Instagram\Instagram;

class InstagramController
{
    public function login()
    {
        try {
            $ig = new Instagram('5469307698.1677ed0.ebdbe1794aad4e7aab2c4e378a44c001');
            return $ig->self();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
