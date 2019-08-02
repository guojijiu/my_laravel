<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yansongda\Pay\Pay;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class AliPayController extends Controller
{

    private $aliPay;

    public function __construct()
    {
        $this->aliPay = config('alipay.pay');
    }

    public function pay(Request $request)
    {
        $order = [
            'out_trade_no' => time(),
            'total_amount' => '0.01',
            'subject' => 'test subject - 测试',
        ];

        $alipay = Pay::alipay($this->aliPay)->web($order);

        return $alipay;
    }

    public function getResult(Request $request)
    {
        info('33456');
        $data = Pay::alipay($this->aliPay)->verify(); // 是的，验签就这么简单！

        // 订单号：$data->out_trade_no
        // 支付宝交易号：$data->trade_no
        // 订单总金额：$data->total_amount
    }

    // 支付成功后 支付宝服务通知本项目服务器
    // post 请求
    // 这里只是大概写一下逻辑，具体的安全防护 自己再去做限制
    public function aliPayNtify(Request $request, OrderService $orderService)
    {
        info('11234');
        return Pay::alipay($this->aliPay)->success();
        $order = Order::find($request->id);
        // 更新自己项目 订单状态
        if (!empty($order)) $orderService->payOrder($order);
    }


    // 手机网页支付接口
    public function aliPay(Request $request)
    {
        $aliPayOrder = [
            'out_trade_no' => time(),
            'total_amount' => '11', // 支付金额
            'subject' => $request->subject ?? '支付宝手机网页支付' // 备注
        ];

        $config = config('alipay.pay');

        $config['return_url'] = $config['return_url'] . '?id=' . $request->id;

        $config['notify_url'] = $config['notify_url'] . '?id=' . $request->id;

        return Pay::alipay($config)->wap($aliPayOrder);
    }

    // app支付接口
    public function aliPayApp(Request $request)
    {
        $aliPayOrder = [
            'out_trade_no' => time(),
            'total_amount' => '11', // 支付金额
            'subject' => $request->subject ?? '默认' // 备注
        ];

        $config = config('alipay.pay');

        $config['return_url'] = $config['return_url'] . '?id=' . $request->id;

        return Pay::alipay($config)->app($aliPayOrder);
    }

    // 支付宝扫码 支付
    public function aliPayScan(Request $request)
    {
        $aliPayOrder = [
            'out_trade_no' => time(),
            'total_amount' => '11', // 支付金额
            'subject' => $request->subject ?? '扫码支付' // 备注
        ];

        $config = config('alipay.pay');

        $config['return_url'] = $config['return_url'] . '?order_guid=' . $request->order_guid;

        $scan = Pay::alipay($config)->scan($aliPayOrder);

        if (empty($scan->code) || $scan->code !== '10000') return false;

        $url = $scan->code . '?order_guid=' . $request->order_guid;
        // 生成二维码
        return QrCode::encoding('UTF-8')->size(300)->generate($url);

    }

    // 支付宝退款
    public function aliPayRefund(Request $request)
    {
        try {
            $payOrder = [
                'out_trade_no' => time(), // 商家订单号
                'refund_amount' => '11', // 退款金额  不得超过该订单总金额
                'out_request_no' => session_create_id() // 同一笔交易多次退款标识（部分退款标识）
            ];

            $config = config('alipay.pay');

            // 返回状态码 code 10000 成功
            $result = Pay::alipay($config)->refund($payOrder);
            if (empty($result->code) || $result->code !== '10000') throw new \Exception('请求支付宝退款接口失败');
            // 订单改为 已退款状态
            // ~~自己商城的订单状态修改逻辑
        } catch (\Exception $exception) {
            \Log::error($exception->getMessage());
            return false;
        }
    }
}