<?php

namespace App\Http\Controllers;

/**
 * 返回JSON格式的Swagger定义
 *
 * 这里需要一个主`Swagger`定义：
 * @SWG\Swagger(
 *   @SWG\Info(
 *     title="我的`Swagger`API文档",
 *     version="1.0.0"
 *   )
 * )
 */

class SwaggerController extends Controller
{
    public function doc()
    {
        $swagger = \Swagger\scan(realpath(__DIR__));
        return response()->json($swagger);
    }
}
