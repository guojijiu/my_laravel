<?php


namespace App\Service\Swoole;


class SwooleWebSocketClient
{

    private $client;

    private $config;

    public function __construct()
    {
//        $this->config = config('swoole.swooleA');
//        $this->client = new \swoole_client(
//            $this->config['host'],
//            $this->config['port']
//        );
    }

    public function start()
    {
        $client = new \Swoole\Client\WebSocket('127.0.0.1', 9503);
        if (!$client->connect()) {
            echo "connect to server failed.\n";
            exit;
        }
        while (true) {
            $client->send("发送消息----");
            $message = $client->recv();
            if ($message === false) {
                break;
            }
            echo "Received from server: {$message}\n";
            sleep(1);
        }
        echo "Closed by server.\n";

        var_dump('swooleTCPClient 启动成功');
    }

    public function connect()
    {
        $this->client->connect();
        return $this;
    }

    public function open()
    {
        $this->client->send('哈哈哈');
        return $this;
    }

    public function message()
    {
        $this->client->send('发送数据：你好。。。');
        return $this;
    }

}