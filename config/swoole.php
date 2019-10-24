<?php
return [
    //是否启用swoole
    'active' => true,

//    'swooleA' => [
//        'host' => '127.0.0.1',
//        'port' => 5501,
//
//        /**
//         * 指定启动的worker进程数
//         * 建议开启的worker进程数为cpu核数的1-4倍
//         */
//        'worker_num' => 2,
//
//        /**
//         * 每个worker进程允许处理的最大任务数
//         * 设置该值后，每个worker进程在处理完max_request个请求后就会自动重启
//         * 设置该值的主要目的是为了防止worker进程处理大量请求后可能引起的内存溢出
//         */
//        'max_request' => 10000,
//
//        /**
//         * 服务器允许维持的最大TCP连接数
//         * 设置此参数后，当服务器已有的连接数达到该值时，新的连接会被拒绝
//         * 该参数的值不能超过操作系统ulimit -n的值
//         * 此值也不宜设置过大，因为swoole_server会一次性申请一大块内存用于存放每一个connection的信息
//         */
//        'max_conn' => 100,
//
//        /**
//         * 设置进程间的通信方式
//         * 1 => 使用unix socket通信
//         * 2 => 使用消息队列通信
//         * 3 => 使用消息队列通信，并设置为争抢模式
//         */
//        'ipc_mode' => 3,
//
//        /**
//         * 指定数据包分发策略
//         * 1 => 轮循模式，收到会轮循分配给每一个worker进程
//         * 2 => 固定模式，根据连接的文件描述符分配worker。这样可以保证同一个连接发来的数据只会被同一个worker处理
//         * 3 => 抢占模式，主进程会根据Worker的忙闲状态选择投递，只会投递给处于闲置状态的Worker
//         */
//        'dispatch_mode' => 2,
//
//        /**
//         * 服务器开启的task进程数
//         * 设置此参数后，服务器会开启异步task功能。此时可以使用task方法投递异步任务
//         * 设置此参数后，必须要给swoole_server设置onTask/onFinish两个回调函数，否则启动服务器会报错
//         */
//        'task_worker_num' => 4,
//
//        /**
//         * 每个task进程允许处理的最大任务数
//         */
//        'task_max_request' => 100,
//
//        /**
//         * 设置task进程与worker进程之间通信的方式
//         * 参考ipc_mode
//         */
//        'task_ipc_mode' => 2,
//
//        /**
//         * 设置程序进入后台作为守护进程运行
//         * 启用守护进程后，标准输入和输出会被重定向到 log_file，如果 log_file未设置，则所有输出会被丢弃
//         */
//        'daemonize' => 0,
//
//        /**
//         * 指定日志文件路径
//         * 在swoole运行期发生的异常信息会记录到这个文件中。默认会打印到屏幕。注意log_file 不会自动切分文件，所以需要定期清理此文件
//         */
//        'log_file' => storage_path() . '/logs/swoole/swooleA_error.log',
//
//        'pid_file' => storage_path() . '/logs/swoole/swooleA.pid',
//
//        /**
//         * 设置心跳检测间隔
//         * 此选项表示每隔多久轮循一次，单位为秒
//         * 每次检测时遍历所有连接，如果某个连接在间隔时间内没有数据发送，则强制关闭连接（会有onClose回调）
//         */
//        'heartbeat_check_interval' => 60,
//
//        /**
//         * 设置某个连接允许的最大闲置时间
//         * 该参数配合heartbeat_check_interval使用
//         * 每次遍历所有连接时，如果某个连接在heartbeat_idle_time时间内没有数据发送，则强制关闭连接。
//         * 默认设置为heartbeat_check_interval * 2
//         */
//        'heartbeat_idle_time' => 600,
//
//        /**
//         * 设置EOF字符串
//         * package_eof最大只允许传入8个字节的字符串
//         */
//        'package_eof' => '/r/n',
//
//        /**
//         * 打开eof检测功能
//         * 与package_eof 配合使用
//         * 此选项将检测客户端连接发来的数据，当数据包结尾是指定的package_eof 字符串时才会将数据包投递至Worker进程
//         * 否则会一直拼接数据包直到缓存溢出或超时才会终止
//         * 一旦出错，该连接会被判定为恶意连接，数据包会被丢弃并强制关闭连接
//         */
//        'open_eof_check' => true,
//
//        /**
//         * 打开包长检测
//         * 包长检测提供了固定包头+包体这种格式协议的解析，
//         * 启用后，可以保证Worker进程onReceive每次都会收到一个完整的数据包
//         */
//        'open_length_check' => true,
//
//        /**
//         * 包头中第几个字节开始存放了长度字段
//         * 配合open_length_check使用，用于指明长度字段的位置。
//         */
//        'package_length_offset' => 5,
//
//        /**
//         * 从第几个字节开始计算长度
//         * 配合open_length_check使用，用于指明包头的长度
//         */
//        'package_body_offset' => 10,
//
//        /**
//         * 指定包长字段的类型
//         * 配合open_length_check使用
//         * 's' => int16_t 机器字节序
//         * 'S' => uint16_t 机器字节序
//         * 'n' => uint16_t 大端字节序
//         * ’N‘ => uint32_t 大端字节序
//         * 'L' => uint32_t 机器字节序
//         * 'l' => int 机器字节序
//         */
//        'package_length_type' => 'N',
//
//        /**
//         * 设置最大数据包尺寸
//         * 该值决定了数据包缓存区的大小
//         * 如果缓存的数据超过了该值，则会引发错误。具体错误处理由开启的协议解析的类型决定
//         */
//        'package_max_length' => 65535,
//
//        /**
//         * 启用CPU亲和性设置
//         * 在多核的硬件平台中，启用此特性会将swoole的reactor线程/worker进程绑定到固定的一个核上
//         * 可以避免进程/线程的运行时在多个核之间互相切换，提高CPU Cache的命中率
//         */
//        'open_cpu_affinity' => true,
//
//        /**
//         * 启用open_tcp_nodelay
//         * 开启后TCP连接发送数据时会无关闭Nagle合并算法，立即发往客户端连接
//         * 在某些场景下，如http服务器，可以提升响应速度
//         */
//        'open_tcp_nodelay' => true,
//
//        /**
//         * 启用tcp_defer_accept特性
//         * 启动后，只有一个TCP连接有数据发送时才会触发accept
//         */
//        'tcp_defer_accept' => true,
//
//        /**
//         * 设置SSL隧道加密
//         * 设置值为一个文件名字符串，指定cert证书和key的路径
//         */
//        'ssl_cert_file' => 'config/ssl.crt',
//        'ssl_key_file' => 'config/ssl.key',
//
//        /**
//         * 打开TCP的KEEP_ALIVE选项
//         * 使用TCP内置的keep_alive属性，用于保证连接不会因为长时闲置而被关闭
//         */
//        'open_tcp_keepalive' => true,
//
//        /**
//         * 指定探测间隔。
//         * 配合open_tcp_keepalive使用，如果某个连接在tcp_keepidle内没有任何数据来往，则进行探测
//         */
//        'tcp_keepidle' => 600,
//
//        /**
//         * 指定探测时的发包间隔,
//         * 配合open_tcp_keepalive使用
//         */
//        'tcp_keepinterval' => 60,
//
//        /**
//         * 指定探测的尝试次数,
//         * 配合open_tcp_keepalive使用，若tcp_keepcount次尝试后仍无响应，则判定连接已关闭。
//         */
//        'tcp_keepcount' => 5,
//
//        /**
//         * 指定Listen队列长度
//         * 此参数将决定最多同时有多少个等待accept的连接。
//         */
//        'backlog' => 128,
//
//        /**
//         * 指定Reactor线程数
//         * 设置主进程内事件处理线程的数量
//         * 默认会启用CPU核数相同的数量
//         * 一般设置为CPU核数的1-4倍，最大不得超过CPU核数*4
//         */
//        'reactor_num' => 8,
//
//        /**
//         * 设置task的数据临时目录
//         * 在swoole_server中，如果投递的数据超过8192字节，将启用临时文件来保存数据。这里的task_tmpdir就是用来设置临时文件保存的位置。
//         * 需要swoole-1.7.7+
//         */
//        'task_tmpdir' => storage_path('/logs/swoole'),
//
//        'timeout' => 1,
//        'retry' => 1,
//
//    ],
    'swooleA' => [
        'name' => env('SWOOLE_WEBSOCKET_NAME','cass_swoole_websocket'),
        'host' => '127.0.0.1',
        'port' => 9503,
        'timeout' => 1,
        'retry' => 1,
        'worker_num' => 1, // 一般设置为服务器CPU数的1-4倍
        'daemonize' => 0,  // 以守护进程执行
        'max_request' => 3000,
        'dispatch_mode' => 2,
//        'task_worker_num' => 1,
        'task_ipc_mode' => 1, // 使用消息队列，争抢模式
        'debug_mode' => 1,
        'log_file' => storage_path() . '/logs/websocket.log',
    ],
];
