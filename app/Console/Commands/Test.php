<?php

namespace App\Console\Commands;


use App\Http\Controllers\InstagramController;
use App\Service\Swoole\SwooleTCPASYNCClient;
use App\Service\Swoole\SwooleTCPClient;
use App\Service\Swoole\SwooleWebSocketClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class Test extends Command
{
    protected $signature = 'test {value?}';

    protected $description = 'test 测试';

    public function handle()
    {
        $arguments = $this->argument('value');

//        $client = new SwooleTCPClient();
//        $client = new SwooleTCPASYNCClient();
        $client = new SwooleWebSocketClient();
        $client->start();
    }
}