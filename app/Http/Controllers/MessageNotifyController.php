<?php
/**
 * Created by PhpStorm.
 * User: liuwei
 * Date: 2019/7/12
 * Time: 17:13
 */

namespace App\Http\Controllers;


use App\Model\MessageNotify;
use App\Model\User;
use App\Service\SwooleWebSocket;
use Illuminate\Support\Facades\DB;

class MessageNotifyController extends Controller
{
    /**
     * @throws \Exception
     */
    public function test()
    {

//        User::query()->insert(['name' => '李四', 'address' => '湖北武汉', 'status' => 1]);
//
//        MessageNotify::query()->insert(['name' => '王五', 'sex' => '男', 'age' => 33]);
        try {
            DB::beginTransaction();

            User::query()->where('name', '李四')->update(['status' => 4]);

            MessageNotify::query()->where('name1', '王五')->update(['age' => 34]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new \Exception($e->getMessage());
        }
//        $a = MessageNotify::query()->where('name', '张三')->get(['_id'])->toArray();
//        return $a;
    }

    public function swooletest($param = ['s_id' => 2, 'info' => 'info'])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:9503");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置post数据
        $post_data = $param;
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_exec($ch);
        curl_close($ch);
    }

    public function swooleView()
    {
        return view("websocket.swoole");
    }

    public function sendMessage()
    {
        SwooleWebSocket::getInstance()->onReceive();
    }
}