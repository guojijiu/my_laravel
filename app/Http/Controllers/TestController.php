<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\Mail;

class TestController
{
    /**
     * @SWG\Get(
     *     path="/test",
     *     tags={"test"},
     *     summary="測試",
     *     @SWG\Parameter(
     *         name="app_type",
     *         in="query",
     *         required=true,
     *         type="string",
     *         format="string",
     *         description="请求参数A",
     *     ),
     *     @SWG\Parameter(
     *         name="version",
     *         in="query",
     *         required=false,
     *         type="integer",
     *         format="integer",
     *         description="请求参数B",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="A list with products"
     *     ),
     *     @SWG\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function test()
    {
        return '测试';
    }

    /**
     *
     */
    public function test1()
    {
        return 'ok';
    }

    /**
     * 测试发送邮件
     */
    public function sendMail()
    {
        $message = 'test：mail';
        $to = 'l644522319@gmail.com';
        $subject = '测试发送邮件';
        Mail::send(
            'emails.test',
            ['content' => $message],
            function ($message) use ($to, $subject) {
                $message->to($to)->subject($subject);
            }
        );
    }

}