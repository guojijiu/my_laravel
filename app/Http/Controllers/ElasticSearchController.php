<?php

namespace App\Http\Controllers;


use Elasticsearch\ClientBuilder;
use GuzzleHttp\Ring\Client\MockHandler;

class ElasticSearchController
{

    //ES客户端
    protected $client;

    public function __construct()
    {

        $handler = new MockHandler([
            'status' => 200,
            'transfer_stats' => [
                'total_time' => 100
            ],
            'body' => fopen('es.json', 'a+')
        ]);

        $this->client = ClientBuilder::create()
//            ->setHandler($handler)
            ->setHosts(['127.0.0.1:9200'])//配置Es服务所在位置
            ->setRetries(2)//设置重试次数
            ->build();
    }

    public function setDocument()
    {
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id',
            'body' => [
                'testField' => 'abc'
            ],
            'client' => [
                'ignore' => [400, 404],//忽略400和404错误
                'verbose' => true,//获取更多信息
                'timeout' => 10,//设置请求超时时间
                'connect_timeout' => 10,//设置连接超时时间
            ]
        ];

        $response = $this->client->index($params);
        print_r($response);

    }

    public function getDocument()
    {
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];

//        $response = $this->client->get($params);
        $response = $this->client->get($params);

        print_r($response);
    }

    public function searchDocument()
    {
        $params = [
            'index' => 'stars',
            'type' => 'stars',
            'body' => [
                'query' => [
                    'match' => [
                        'testField' => 'abc'
                    ]
                ]
            ]
        ];

        $response = $this->client->search($params);
        print_r($response);
    }

    public function deleteDocument()
    {
        $params = [
            'index' => 'my_index',
            'type' => 'my_type',
            'id' => 'my_id'
        ];

        $response = $this->client->delete($params);
        print_r($response);
    }

    public function deleteIndex()
    {
        $deleteParams = [
            'index' => 'my_index'
        ];
        $response = $this->client->indices()->delete($deleteParams);
        print_r($response);
    }
}