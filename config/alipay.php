<?php

return [
    'pay' => [
//        'app_id' => '2016093000632024',
//        'notify_url' => 'http://yansongda.cn/notify.php',
//        'return_url' => 'http://yansongda.cn/return.php',
//        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgl8NZjxnOc1pDFpLL/HmSIgeCjrQOaTae999eBQMuRvIjV0x0do4AHL1LU15+ZGxT02g0jIqNqkgjkSDgkO9YorBjXoZhjnZPCtMuSC6qyZ5k/vQAVxqmnN+DG2SYezoQ3swPCW32hjtNf20aIVBXmFWAN3mOzox/9O12/WyW3igfoYq/d5MSxCqosz8usYlVvBL601OeBKmUmZyWbMG2hfdHwt29Nmkv/JgJJVeQ3yq+1F4jthAuhbSr+cZH2ysfNoJnXZrBQrLMGHDTdAWOHD1ixYFtzAPFjg+/IVJaCogt9Awbisv1A9HP1LsMycDNgUdMoC2FCNtiyxzC0G0oQIDAQAB',
//        // 加密方式： **RSA2**
//        'private_key' => 'MIIEpQIBAAKCAQEA2AQUQl68uuqA3urxnuKFTT8nE5R4L64h69FvuPcmR9DgeAfdns7oJ4jHg02mQqOUGlH7Srhv9bHNTgkWkZr7X1zw65SgHMy9+la0pzzJSetJzF5nHFsaMvrhO9DpyxXST05iAv6zqzxBM4g5i8QcmJS/RW5x4+3vNPbKQXLVtJ24zOhZ7qUC9GTvDSDA3G4f7pdFAq2Ww09TGGZ8N/AaDWksLFfZ3S/DSCK26hsbpFUe4EkNijfCBBajfpBOYFSXx3VVEAqbrruZ6sYT4B2OtuAoW2paS1+iysDdx9r+KTkl+x77EdLA04eJEJzAzw33NFk/nh/DPlL9rWsEE9p6+wIDAQABAoIBAC0exQCL+03rl5l4Z5mxZPianVXoqCYFcE5qg7SV4ygTCB/qPK9kNneziUDy4ix/MHtC7oNP/QrL5b9MBKvLPIBR0HzUoZECbxgwLjHUb5MCE3sdqNnyaYmGf69X1s21tCUekThg7TRyNIhIBwUbpIF2aHFfPWjHlTRx7BM5okvEV4vui8/PY3frpPm23uMRP5dhHdXbYRh4nolk+7IryeTva07c75PecWZml+ywQNqUhVkcQHFnQLhIjVqyQO6xlz7MO8BqbLw7gSIyMZAovZpBvmv3PfLN1UvYcINzgu9TCf1ocJJktvDZVZrC6IWPc9Hdkx0vuYxL1ghfsmQBOFECgYEA/Lkh7mgo0QSw4JlOg1ZIxRRCrSzGqqWk91vlyYYmqdhwnUM9qgvY3OjxxcaYOqAHAz0POW7GvOfYWBqeUwImV5A6wGR+pcRcWWK7jpV2lQtpOgrW8smN+1fFGXHFgtbINuSs25p0u+4roMiBy1glHK4qDISCs3uyrgvTXGi+2GkCgYEA2tEaj6/KzznVJAbfChQMNU7TShOhaTq2s3HILA/hyTX5lQ7WLmGjGh7vJS3BkuL0Nn/VBN4WtbbEDUd9Sy90lkVp/x+j4GWbr/VcpFQz7iZhd8+edVOOcLeHMiuOmhHd1/ItHbYkQ4P6HE50QGQnHw7ThueEI0100yI+HkbSK8MCgYEA7ksWPnkCO4wDx9NmX5qlRQcEk8uLi+5ibUa+ldWjcTT/gpmbdFJ1al9PUWAfu++WjSwuxcW5KPgnW3PF45k8VAZQD4bykBVlyna5SQmPZZv73VnJMeZwtRUeaQ6I4QTqhi/6+ZpbBbTeeF13XShA3hku1ty/bMNvSIMoCZNOmDkCgYEAsBVI7IuoBq4hSIaHAVM0p8kw2hGF+GoZD7nmPR7isMpQd5Si4lwLpj9yblatyQf9QcYIo4wcdkoG5jC7ML+VcD+XlofdlfvuFuC5ljt0NpaIJKPcfcmpfCcUEllevbjW7qmhiKFD+VjA8fpoLlDp8mI58ftoKAhylFyf5DlVc4UCgYEA8dyI+MT/EHmGj3NX9tMiCIIT5/HoxCraA+UMWW5jNWmNrZPxXC/MPOgaizg9aJf0zDnkCFFfyZRkPHB2zJMyctHZxmx14qNW2oKCRfKDiORp2Yt5wa+M7V/dW2tTM1MtEFaGwYkIYr4UaxLZ7eqalbfZp+RuqWpWHY1ldojvjC8=',
        'app_id' => '2019052865353570',
        'notify_url' => 'http://local.laravel.com/alipay/aliPayNtify',
        'return_url' => 'http://local.laravel.com/alipay/getResult',
        'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAjMrQngWEqOE6EoTlURG4TGKDr/tcI6iB14FTZ7CQrGjUMGFSpVLdeDgIKDUqY/JZHRLhTEpcoSnMKGOsRsIGaiITzhAj2ASUlezofUxb05ow4vp6XTjIIprVGlWBeEft+l/jbpDT8R49CgIWfUTQEq1cHmRBFWG2p2gDv95XawYAjI0IDCt6jAe4IX1KbXLdy8Of3/EfoMAnGeRzVId1K/l8QwFlPUpoVu8oFbkbOpGdh8/f7rXJfXJkWdJjRgqJWsQ84vp2Rb1NCpejem+4SkU485tXUqiPzDsZpcGqiBrbGJbFuTMYBMX+brPm2hGA8VMRyMX2MwHHJdZeL3Fk8wIDAQAB',
//         加密方式： **RSA2**
        'private_key' => 'MIIEpQIBAAKCAQEA2AQUQl68uuqA3urxnuKFTT8nE5R4L64h69FvuPcmR9DgeAfdns7oJ4jHg02mQqOUGlH7Srhv9bHNTgkWkZr7X1zw65SgHMy9+la0pzzJSetJzF5nHFsaMvrhO9DpyxXST05iAv6zqzxBM4g5i8QcmJS/RW5x4+3vNPbKQXLVtJ24zOhZ7qUC9GTvDSDA3G4f7pdFAq2Ww09TGGZ8N/AaDWksLFfZ3S/DSCK26hsbpFUe4EkNijfCBBajfpBOYFSXx3VVEAqbrruZ6sYT4B2OtuAoW2paS1+iysDdx9r+KTkl+x77EdLA04eJEJzAzw33NFk/nh/DPlL9rWsEE9p6+wIDAQABAoIBAC0exQCL+03rl5l4Z5mxZPianVXoqCYFcE5qg7SV4ygTCB/qPK9kNneziUDy4ix/MHtC7oNP/QrL5b9MBKvLPIBR0HzUoZECbxgwLjHUb5MCE3sdqNnyaYmGf69X1s21tCUekThg7TRyNIhIBwUbpIF2aHFfPWjHlTRx7BM5okvEV4vui8/PY3frpPm23uMRP5dhHdXbYRh4nolk+7IryeTva07c75PecWZml+ywQNqUhVkcQHFnQLhIjVqyQO6xlz7MO8BqbLw7gSIyMZAovZpBvmv3PfLN1UvYcINzgu9TCf1ocJJktvDZVZrC6IWPc9Hdkx0vuYxL1ghfsmQBOFECgYEA/Lkh7mgo0QSw4JlOg1ZIxRRCrSzGqqWk91vlyYYmqdhwnUM9qgvY3OjxxcaYOqAHAz0POW7GvOfYWBqeUwImV5A6wGR+pcRcWWK7jpV2lQtpOgrW8smN+1fFGXHFgtbINuSs25p0u+4roMiBy1glHK4qDISCs3uyrgvTXGi+2GkCgYEA2tEaj6/KzznVJAbfChQMNU7TShOhaTq2s3HILA/hyTX5lQ7WLmGjGh7vJS3BkuL0Nn/VBN4WtbbEDUd9Sy90lkVp/x+j4GWbr/VcpFQz7iZhd8+edVOOcLeHMiuOmhHd1/ItHbYkQ4P6HE50QGQnHw7ThueEI0100yI+HkbSK8MCgYEA7ksWPnkCO4wDx9NmX5qlRQcEk8uLi+5ibUa+ldWjcTT/gpmbdFJ1al9PUWAfu++WjSwuxcW5KPgnW3PF45k8VAZQD4bykBVlyna5SQmPZZv73VnJMeZwtRUeaQ6I4QTqhi/6+ZpbBbTeeF13XShA3hku1ty/bMNvSIMoCZNOmDkCgYEAsBVI7IuoBq4hSIaHAVM0p8kw2hGF+GoZD7nmPR7isMpQd5Si4lwLpj9yblatyQf9QcYIo4wcdkoG5jC7ML+VcD+XlofdlfvuFuC5ljt0NpaIJKPcfcmpfCcUEllevbjW7qmhiKFD+VjA8fpoLlDp8mI58ftoKAhylFyf5DlVc4UCgYEA8dyI+MT/EHmGj3NX9tMiCIIT5/HoxCraA+UMWW5jNWmNrZPxXC/MPOgaizg9aJf0zDnkCFFfyZRkPHB2zJMyctHZxmx14qNW2oKCRfKDiORp2Yt5wa+M7V/dW2tTM1MtEFaGwYkIYr4UaxLZ7eqalbfZp+RuqWpWHY1ldojvjC8=',

        'log' => [ // optional
            'file' => './../storage/logs/alipay.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
//        'mode' => 'dev', // optional,设置此参数，将进入沙箱模式
    ]
];
