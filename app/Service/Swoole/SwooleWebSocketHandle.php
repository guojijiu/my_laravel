<?php

namespace App\Service\Swoole;


use Illuminate\Support\Facades\Log;

class SwooleWebSocketHandle
{

    private $swooleLog;

    public function onStart($server)
    {
//        print_r(get_included_files());
//        print_r(collect($server)->toArray()) ;
//        $this->swooleLog = Log::channel('swoole_log');
        echo '启动成功';
    }

    public function onConnect($server, $fd)
    {
        echo "建立连接通道ID：$fd\n";
    }

    public function onOpen($ws, $request)
    {
//        var_dump($request->fd, $request->get, $request->server);
        $ws->push($request->fd, "hello, welcome\n");
    }

    public function onMessage($ws, $frame)
    {
//        var_dump($frame);
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $ws->send($frame->fd, "server: {$frame->data}");
    }

    public function onClose($ws, $fd)
    {
        echo "client-{$fd} is closed\n";
    }
}
