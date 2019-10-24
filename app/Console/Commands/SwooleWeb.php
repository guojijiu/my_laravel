<?php

namespace App\Console\Commands;

use App\Service\Swoole\SwooleWebHandle;

class SwooleWeb extends SwooleWebCommand
{

    protected $signature = 'swooleWeb {action=start}';

    protected $description = 'swooleWeb服务';

    public function __construct()
    {
        parent::__construct();

        $this->swooleHandle = new SwooleWebHandle();

        $this->swooleConfig = config('swoole.swooleA');

    }
}