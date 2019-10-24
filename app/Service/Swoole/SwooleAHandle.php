<?php

namespace App\Service\Swoole;


use Illuminate\Support\Facades\Log;

class SwooleAHandle
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

    public function onWorkerStart($server, $workerId)
    {
        echo "worker启动了\n";
        //进程开启时绑定定时器，只有workderId为0才添加定时器，避免重复添加
        if ($workerId == 0) {
            echo "定时开启\n";
        }
    }

    public function onReceive($server, $fd, $fromId, $data)
    {
        //收到指令后处理操作
    }

    public function onTimer($timerId, $params)
    {
        //循环定时任务
        echo "执行开门定时任务开始\n";
    }

    public function onClose($server, $fd)
    {
        //添加警报
        echo "断开连接通道: {$fd}\n";
    }

    public function onTask($server, $task_id, $from_id, $data)
    {
        echo "任务开始\n";
    }

    public function onFinish($server, $task_id, $data)
    {
        echo "任务结束\n";
    }
}