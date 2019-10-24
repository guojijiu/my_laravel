<?php

namespace App\Service\Swoole;


class SwooleAClient
{

    private $client;

    private $config;

    public function __construct()
    {
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP);
        $this->config = config('swoole.swooleA');
    }

    public function connect()
    {
        if (!$this->client->connect(
            $this->config['host'],
            $this->config['port'],
            0.5
        )) {
            die('连接失败');
        }
        return $this;
    }

    public function send(string $msg)
    {
        if (!$this->client->send($msg)) {
            die('发送失败');
        }
        return $this;
    }

    public function receive()
    {
        $data = $this->client->recv();
        if (!$data) {
            die('获取失败');
        }
        echo $data;
        return $this;
    }

    public function close()
    {
        $this->client->close();
        return $this;
    }
}