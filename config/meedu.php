<?php

return [

    // 配置文件存储路径
    'save' => storage_path('/meedu_config.json'),

    // 会员配置
    'member' => [
        'is_active_default' => \App\User::ACTIVE_NO,
        'is_lock_default' => \App\User::LOCK_NO,

        // 头像
        'default_avatar' => '/images/default_avatar.jpg',

        // Socialite
        'socialite' => [
            // Github登录
            'github' => [
                'app' => 'github',
                'name' => 'Github',
                'icon' => '<i class="fa fa-github" aria-hidden="true"></i>',
                'enabled' => 0,
            ],
            // QQ登录
            'qq' => [
                'app' => 'qq',
                'name' => 'QQ',
                'icon' => '<i class="fa fa-qq" aria-hidden="true"></i>',
                'enabled' => 0,
            ],
        ],
    ],

    // 上传
    'upload' => [
        'image' => [
            'disk' => 'public',
            'path' => 'images',
            'params' => '',
        ],
        'video' => [
            'aliyun' => [
                'region' => 'cn-shanghai',
                'access_key_id' => '',
                'access_key_secret' => '',
            ],
        ],
    ],

    // 管理员配置
    'administrator' => [
        'super_slug' => 'administrator',
    ],

    // 支付网关
    'payment' => [
        'alipay' => [
            'handler' => \App\Meedu\Payment\Alipay\Alipay::class,
            'name' => '支付宝',
            'sign' => 'alipay',
            'default_method' => 'web',
            'pc' => true,
            'enabled' => 0,
        ],
        'wechat' => [
            'handler' => \App\Meedu\Payment\Wechat\Wechat::class,
            'name' => '微信支付',
            'sign' => 'wechat',
            'default_method' => 'scan',
            'pc' => true,
            'enabled' => 1,
        ],
        'eshanghu' => [
            'handler' => \App\Meedu\Payment\Eshanghu\Eshanghu::class,
            'name' => '微信扫码支付',
            'sign' => 'eshanghu',
            'default_method' => 'scan',
            'pc' => true,
            'enabled' => 0,
        ],
    ],

    // SEO
    'seo' => [
        'index' => [
            'title' => '',
            'keywords' => '',
            'description' => '',
        ],
        'course_list' => [
            'title' => '视频列表',
            'keywords' => '视频列表',
            'description' => '视频列表',
        ],
        'role_list' => [
            'title' => 'VIP',
            'keywords' => '',
            'description' => '',
        ],
        'novel_list' => [
            'title' => '文章列表',
            'keywords' => '文章列表',
            'description' => '文章列表',
        ],
    ],

    // 系统配置
    'system' => [
        // 缓存开关
        'cache' => [
            'status' => -1,
            'expire' => 360,
        ],
        // 测试手机号
        'test' => explode(',', env('TEST_MOBILE', '')),
        // 统计代码
        'js' => '',
        // 主题
        'theme' => [
            'use' => 'default',
            'path' => resource_path('views'),
        ],
        'sms' => 'yunpian',
        // 备份开关
        'backup' => 0,
    ],

    // 视频鉴权
    'video' => [
        'auth' => [
            'aliyun' => [
                'private_key' => env('ALIYUN_VIDEO_AUTH_PRIVATE_KEY', ''),
            ],
        ],
    ],

    // advance
    'advance' => [
        'template_index' => env('TEMPLATE_INDEX') ?: 'frontend.index.index',
    ],
];