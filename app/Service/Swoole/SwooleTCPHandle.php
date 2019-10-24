<?php

namespace App\Service\Swoole;


use Illuminate\Support\Facades\Log;

class SwooleTCPHandle
{

    private $swooleLog;

    public function onStart($server)
    {
//        print_r(get_included_files());
//        print_r(collect($server)->toArray()) ;
//        $this->swooleLog = Log::channel('swoole_log');
        echo 'TCP 启动成功' . "\r\n";
    }

    public function onConnect($server, $fd)
    {
        echo "建立连接通道ID：$fd\r\n";
    }

    public function onReceive($server, $fd, $fromId, $data)
    {
        echo "已成功获取到消息：" . $data . "\r\n";
        //收到指令后处理操作
        $server->send($fd, "Server: " . $data);
    }

    public function onClose($server, $fd)
    {
        //添加警报
        echo "断开连接通道: {$fd}\r\n";
    }

}