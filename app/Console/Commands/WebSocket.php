<?php

namespace App\Console\Commands;

use App\Service\SwooleWebSocket;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class WebSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ws {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'swoole socket';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    protected $wsService;

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $arg = $this->argument('action');
        switch ($arg) {
            case 'start':
                $this->info('ws started');
                $this->start();
                break;
            case 'stop':
                $this->info('ws stoped');
                break;
            case 'restart':
                $this->info('ws restarted');
                break;
        }
    }

    public function start()
    {
        $config = config('swoole.swoole_websocket');
        $this->wsService = new \swoole_websocket_server($config['host'], $config['port']);
        $this->wsService->set(
            [
                'worker_num' => $config['worker_num'],
                'daemonize' => $config['daemonize'],
                'log_file' => $config['log_file'],
                'max_request' => $config['max_request'],
                'dispatch_mode' => $config['dispatch_mode'],
                'debug_mode' => $config['debug_mode']
            ]
        );

        $handler = SwooleWebSocket::getInstance();
        $this->wsService->on('open', array($handler, 'onOpen'));
        $this->wsService->on('workerstart', array($handler, 'onWorkStart'));
        //$this->wsService->on('Start',array($handler,'onStart'));
        //$this->wsService->on('Connect',array($handler,'onConnect'));
        $this->wsService->on('message', array($handler, 'onMessage'));
        $this->wsService->on('Receive',array($handler,'onReceive'));
        $this->wsService->on('pipMessage',array($handler,'onPipeMessage'));
        $this->wsService->on('close', array($handler, 'onClose'));

        $this->wsService->start();
    }

    protected function getArguments()
    {
        return array(
            'action', InputArgument::REQUIRED, 'start|stop|restart'
        );
    }

    protected function restart()
    {
        $this->wsService->reload();
    }
}