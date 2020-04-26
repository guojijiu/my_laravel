<?php

namespace App\Http\Controllers;

use SwooleTW\Http\Websocket\Websocket;

class SocketController
{

    public function test1(Websocket $websocket, $data)
    {
        $websocket->emit('message', ['code' => 112, 'message' => "hello,swoole"]);

        return false;

    }
}