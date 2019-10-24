<?php

namespace App\Http\Controllers;


use App\Service\Swoole\SwooleAClient;

class SwooleController extends Controller
{
    public function test()
    {
        app(SwooleAClient::class)
            ->connect()
            ->send('你好')
            ->close();
    }

    public function test2()
    {
        app(SwooleAClient::class)
            ->connect()
            ->receive()
            ->close();
    }
}