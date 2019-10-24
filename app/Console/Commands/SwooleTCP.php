<?php

namespace App\Console\Commands;

use App\Service\Swoole\SwooleTCPHandle;

class SwooleTCP extends SwooleTCPCommand
{

    protected $signature = 'swooleTCP {action=start}';

    protected $description = 'swooleTCP服务';

    public function __construct()
    {
        parent::__construct();

        $this->swooleHandle = new SwooleTCPHandle();

        $this->swooleConfig = config('swoole.swooleA');

    }
}