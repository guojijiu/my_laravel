<?php

namespace App\Console\Commands;

use App\Service\Swoole\SwooleAHandle;

class SwooleA extends SwooleBaseCommand
{

    protected $signature = 'swooleA {action=start}';

    protected $description = 'swooleA服务';

    public function __construct()
    {
        parent::__construct();

        $this->swooleHandle = new SwooleAHandle();

        $this->swooleConfig = config('swoole.swooleA');

    }
}