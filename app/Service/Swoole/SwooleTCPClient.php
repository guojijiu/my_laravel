<?php

namespace App\Service\Swoole;


class SwooleTCPClient
{

    private $client;

    private $config;

    public function __construct()
    {
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP | SWOOLE_KEEP);
        $this->config = config('swoole.swooleA');

    }

    public function start()
    {
        var_dump('swooleTCPClient 启动成功');
    }

    public function connect()
    {
        if (!$this->client->connect(
            $this->config['host'],
            $this->config['port']
        )) {
            die('连接失败');
        }
        var_dump('连接成功1111');

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
        var_dump($data);
        return $this;
    }

    public function close()
    {
        $this->client->close();
        return $this;
    }
}