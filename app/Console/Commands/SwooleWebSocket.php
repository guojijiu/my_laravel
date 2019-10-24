<?php

namespace App\Console\Commands;

use App\Service\Swoole\SwooleWebSocketHandle;

class SwooleWebSocket extends SwooleWebSocketCommand
{

    protected $signature = 'swooleWs {action=start}';

    protected $description = 'swooleWebSocket服务';

    public function __construct()
    {
        parent::__construct();

        $this->swooleHandle = new SwooleWebSocketHandle();

        $this->swooleConfig = config('swoole.swooleA');

    }
}