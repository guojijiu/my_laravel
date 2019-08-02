<?php

namespace App\Service;

use App\Console\Commands\WebSocket;
use Illuminate\Support\Facades\Redis;

class SwooleWebSocket
{

    private static $_instance;    //保存类实例的私有静态成员变量

    private $redis;

    public function __construct()
    {

    }

    //定义私有的__clone()方法，确保单例类不能被复制或克隆
    private function __clone()
    {
    }

    //对外提供获取唯一实例的方法
    public static function getInstance()
    {
        //检测类是否被实例化
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new WebSocket();
        }
        return self::$_instance;
    }

    public function onWorkStart($serv, $rq)
    {
        echo "Swoole onWorkStart ";
        $redis = Redis::connection();
        $serv->redis = $redis;
    }

    public function onOpen($serv, $rq)
    {
        echo "Swoole http server is started at http://0.0.0.0:9503\n";
    }

    public function onStart($serv)
    {
        info('swoole start');
    }

    public function onConnect($serv, $fd, $from_id)
    {
        info('swoole connect' . $from_id);
    }

    public function onMessage($serv, $frame)
    {
        $this->handleByAction($serv, $frame);
        info('swoole message' . json_encode($frame));
    }

    public function onReceive($wsService, $fd, $reactor_id, $data)
    {
        $worker_id = 1 - $wsService->worker_id;
        $wsService->sendMessage("hello task process", $worker_id);
        echo "[#" . $worker_id . "]\tClient[$fd]: $data\n";
    }

    /**
     * 根据传来的字符串处理相应的内容
     *
     * @param $server
     * @param $frame
     */
    private function handleByAction($server, $frame)
    {
        $requestData = json_decode($frame->data, true);
        if (!empty($requestData['action'])) {
            $action = $requestData['action'];
            switch ($action) {
                case 'message':
                    $this->getMessageCount($server, $frame);
                    break;
                default:
            }
        } else {
            $server->push($frame->fd, $frame->data);
        }
    }

    //ascii码转换为字符串
    private function decode($M)
    {
        $bytes = explode(',', $M);
        $str = '';
        foreach ($bytes as $ch) {
            $str .= chr($ch);
        }
        return $str;
    }

    /**
     * 字符串转换为ascii码
     *
     * @param $message
     * @return string
     */
    private function encode($message)
    {
        $bytes = array();
        for ($i = 0; $i < strlen($message); $i++) {
            $bytes[] = ord($message[$i]);
        }
        return implode(',', $bytes);
    }

    /**
     * 返回消息总数
     *
     * @param $server
     * @param $frame
     */
    private function getMessageCount($server, $frame)
    {
        $server->push($frame->fd, json_encode(['count' => 1]));
    }

    public function onClose($serv, $fd, $from_id)
    {
        info('swoole close');
    }

    public function onPipeMessage($wsService, $workId, $message)
    {
        $wsService->push($workId, '123');
    }
}