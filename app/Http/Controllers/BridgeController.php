<?php

namespace App\Http\Controllers;

use App\Pattern\Bridge\Avi;
use App\Pattern\Bridge\Mac;
use App\Pattern\Bridge\Windows;

class BridgeController
{
    public function test()
    {
        $window = new Windows((new Avi()));
        $windowShow = $window->show();


        $mac = new Mac((new Avi()));

        $macShow = $mac->show();

        echo $windowShow ;
        echo "\r\n";

        echo $macShow;
    }
}