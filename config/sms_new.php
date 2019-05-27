<?php
return [
    // 默认发送配置
    'default' => [
        'gateways' => [
            'aliyun'
        ],
    ],
    // 可用的网关配置
    'gateways' => [
        'aliyun' => [
            'access_key_id' => env('ALIYUN_ACCESS_KEY_ID'),
            'access_key_secret' => env('ALIYUN_ACCESS_KEY_SECRET'),
            'sign_name' => '先锋音讯',
        ],
    ],
];