<?php

/**
 * @var \Illuminate\Routing\Router $router
 */

$router->get('/', function () {
    return view('welcome');
});

$router->get('/test', 'TestController@test');

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

$router->get('/bridge/test','BridgeController@test');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
