<?php

namespace App\Http\Controllers;


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
        phpinfo();
        return 'asd';
    }

    /**
     *
     */
    public function test1()
    {
        return 'ok';
    }

}