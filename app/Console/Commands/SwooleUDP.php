<?php

namespace App\Console\Commands;

use App\Service\Swoole\SwooleUDPHandle;

class SwooleUDP extends SwooleUDPCommand
{

    protected $signature = 'swooleUDP {action=start}';

    protected $description = 'swooleUDP服务';

    public function __construct()
    {
        parent::__construct();

        $this->swooleHandle = new SwooleUDPHandle();

        $this->swooleConfig = config('swoole.swooleA');

    }
}