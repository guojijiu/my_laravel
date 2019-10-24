<?php

namespace App\Service\Swoole;


use Illuminate\Support\Facades\Log;

class SwooleWebHandle
{

    private $swooleLog;

    public function onStart($server)
    {
//        print_r(get_included_files());
//        print_r(collect($server)->toArray()) ;
        $this->swooleLog = Log::channel('swoole_log');
        echo '启动成功';
    }

    public function onConnect($server, $fd)
    {
        echo "建立连接通道ID：$fd\n";
    }

    public function onPacket($request, $response)
    {
        var_dump($request->get, $request->post);
        $response->header("Content-Type", "text/html; charset=utf-8");
        $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
    }
}