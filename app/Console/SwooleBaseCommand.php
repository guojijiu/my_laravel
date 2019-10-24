<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SwooleBaseCommand extends Command
{

    public $swooleLog;

    private $swooleSer;

    protected $swooleConfig;

    protected $swooleHandle;

    public function __construct()
    {
        parent::__construct();

        $this->swooleLog = Log::channel('swoole_log');
    }

    public function handle()
    {
        try {

            if (!config('swoole.active')) {
                echo '服务未启用' . "\r\n";
                exit();
            }

            $action = $this->argument('action');

            $this->{$action}();

        } catch (\Throwable $e) {
            $this->swooleLog->error('swoole status error:' . $e->getMessage());
            echo $e->getMessage() . "\r\n";
        }
    }

    public function start()
    {
        $this->swooleSer = new \swoole_server(
            $this->swooleConfig['host'],
            $this->swooleConfig['port'],
            SWOOLE_PROCESS,
            SWOOLE_SOCK_TCP
        );
        $this->swooleSer->set($this->swooleConfig);

        $this->swooleSer->on('Start', [$this->swooleHandle, 'onStart']);
        $this->swooleSer->on('Connect', [$this->swooleHandle, 'onConnect']);
        $this->swooleSer->on('Receive', [$this->swooleHandle, 'onReceive']);
        $this->swooleSer->on('Task', [$this->swooleHandle, 'onTask']);
        $this->swooleSer->on('Finish', [$this->swooleHandle, 'onFinish']);
        $this->swooleSer->on('Close', [$this->swooleHandle, 'onClose']);
        $this->swooleSer->start();
    }

    protected function stop()
    {

    }

    protected function restart()
    {

    }

    protected function status()
    {

    }

    protected function getPid()
    {

    }

    private function getAction()
    {
        echo 'action:start|stop|restart|status|getPid' . "\r\n";
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return mixed|void
     * @throws \Exception
     */
    public function __call($method, $parameters)
    {
        throw new \Exception('不存在的命令：' . $method);
    }
}