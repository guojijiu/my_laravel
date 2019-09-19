<?php

/**
 * @var \Illuminate\Routing\Router $router
 */

$router->get('/', function () {
    return view('welcome');
});

$router->get('/test', 'TestController@test');

//发送邮件
$router->get('/test/sendMail', 'TestController@sendMail');

$router->get('/swagger/doc', 'SwaggerController@doc');

//添加查询文件
$router->get('/Es/setDocument', 'ElasticSearchController@setDocument');

//获取查询文件
$router->get('Es/getDocument', 'ElasticSearchController@getDocument');

//搜索文件
$router->get('Es/searchDocument', 'ElasticSearchController@searchDocument');

//删除查询文件
$router->get('Es/deleteDocument', 'ElasticSearchController@deleteDocument');

//删除索引
$router->get('Es/deleteIndex', 'ElasticSearchController@deleteIndex');

//日志测试
$router->get('Log/test', 'LogController@test');

//异常测试
$router->get('/Exception/test', 'ExceptionController@test');

$router->get('/bridge/test', 'BridgeController@test');

//倒ins明星数据接口
$router->get('/ins/handle', 'InstagramController@handle');
//ins保存
$router->get('/ins/save', 'InstagramController@save');
//处理ins图片
$router->get('/ins/deal', 'InstagramController@dealImg');
//获取明星关系excel数据
$router->get('/ins/dealVideoSync', 'InstagramController@dealVideoSync');

//获取图片token
$router->get('/img/getToken', 'ImageController@getQiNiuToken');
//图片上传
$router->get('/img/upload', 'ImageController@uploadImage');
//图片下载
$router->get('/img/download', 'ImageController@download');

//文字翻译
$router->get('/translate', 'TranslateController@translate');

//获取html内容
$router->get('/getHtml', 'GetHtmlValue@test');

//获取ins信息
$router->get('/test/ins/getInfo', 'InsController@save');
//下载url地址
$router->get('/test/ins/download', 'InsController@downloadImg');
//获取明星关系excel数据
$router->get('/excel/star', 'ExcelController@starRelation');
//获取奖项关系excel数据
$router->get('/excel/prize', 'ExcelController@PrizeRelation');

/*
|--------------------------------------------------------------------------
| 导出相关
|--------------------------------------------------------------------------
*/
$router->get('/export/exportTest1', 'ExportController@exportTest1');

/*
|--------------------------------------------------------------------------
| 支付宝相关
|--------------------------------------------------------------------------
*/
$router->get('/alipay/getCode', 'AliPayController@aliPayScan');
$router->get('/alipay/pay', 'AliPayController@pay');
$router->post('/alipay/aliPayNtify', 'AliPayController@aliPayNtify');

/*
|--------------------------------------------------------------------------
| 消息相关
|--------------------------------------------------------------------------
*/
$router->get('/messageNotify/test', 'MessageNotifyController@test');
$router->get('/messageNotify/swooletest', 'MessageNotifyController@swooletest');
$router->get('/messageNotify/swooleView', 'MessageNotifyController@swooleView');
$router->get('/messageNotify/sendMessage', 'MessageNotifyController@swooleView');

/*
|--------------------------------------------------------------------------
| 权限相关
|--------------------------------------------------------------------------
*/

$router->get('/user/create', 'UserController@create');
$router->get('/user/create', 'UserController@create');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
