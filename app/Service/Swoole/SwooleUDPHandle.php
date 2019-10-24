<?php

namespace App\Service\Swoole;


use Illuminate\Support\Facades\Log;

class SwooleUDPHandle
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

    public function onPacket($serv, $data, $clientInfo)
    {
        $serv->sendto($clientInfo['address'], $clientInfo['port'], "Server " . $data);
        var_dump($clientInfo);
    }
}