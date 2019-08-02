<?php
return [
	'swoole_A' => [
		'host' => '127.0.0.1',
		'port' => 9502,
		'timeout' => 1,
		'retry' => 1,
		'worker_num' => 2, // 一般设置为服务器CPU数的1-4倍
		'daemonize' => 1,  // 以守护进程执行
		'max_request' => 10000,
		'dispatch_mode' => 2,
		'task_worker_num' => 8,
		'task_ipc_mode' => 3, // 使用消息队列，争抢模式
		'log_file' => storage_path() . '/logs/swoole.log',
	],

    'swoole_B' => [
        'host' => '127.0.0.1',
        'port' => 9501,
        'timeout' => 1,
        'retry' => 1,
        'worker_num' => 2, // 一般设置为服务器CPU数的1-4倍
        'daemonize' => 1,  // 以守护进程执行
        'max_request' => 1000,
        'dispatch_mode' => 2,
        'task_worker_num' => 8,
        'task_ipc_mode' => 3, // 使用消息队列，争抢模式
        'log_file' => storage_path() . '/logs/swoole.log',
    ],

    'websocket' => [
        'host' => '127.0.0.1',
        'port' => 9503,
        'timeout' => 1,
        'retry' => 1,
        'worker_num' => 2, // 一般设置为服务器CPU数的1-4倍
        'daemonize' => 1,  // 以守护进程执行
        'max_request' => 10000,
        'dispatch_mode' => 2,
        'task_worker_num' => 8,
        'task_ipc_mode' => 3, // 使用消息队列，争抢模式
        'debug_mode' => 1,
        'log_file' => storage_path() . '/logs/websocket.log',
    ],
];
