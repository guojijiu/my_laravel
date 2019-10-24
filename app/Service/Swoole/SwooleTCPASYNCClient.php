<?php

namespace App\Service\Swoole;


class SwooleTCPASYNCClient
{

    private $client;

    private $config;

    public function __construct()
    {
        $this->client = new \swoole_client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_ASYNC);
        $this->config = config('swoole.swooleA');
    }

    public function connect()
    {
        $this->client->on("connect", function ($cli) {
            sleep(5);
            $cli->send("hello world\n");
        });

        //注册数据接收回调
        $this->client->on("receive", function ($cli, $data) {
            echo "Received: " . $data . "\n";
        });

        //注册连接失败回调
        $this->client->on("error", function ($cli) {
            echo "Connect failed\n";
        });

        //注册连接关闭回调
        $this->client->on("close", function ($cli) {
            echo "Connection close\n";
        });

        //发起连接
        $this->client->connect(
            $this->config['host'],
            $this->config['port'],
            0.5
        );
    }

}