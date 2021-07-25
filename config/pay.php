<?php

return [
    'alipay' => [
        // 支付宝分配的 APPID
        'app_id' => env('ALI_APP_ID', ''),

        // 支付宝异步通知地址
        'notify_url' => env('ALI_NOTIFY_URL'),

        // 支付成功后同步通知地址
        'return_url' => '',

        // 阿里公共密钥，验证签名时使用
        'ali_public_key' => env('ALI_PUBLIC_CERT', ''),
        // 自己的私钥，签名时使用
        'private_key' => env('ALI_PRIVATE_KEY', ''),

        // 自己的私钥，签名时使用
//        'app_secret_cert' => env('ALI_PRIVATE_KEY', ''),
        //应用公钥
        'app_cert_public_key' => env('APP_PUBLIC_CERT', ''),
        // 支付宝公钥证书 路径
//        'alipay_public_cert_path' => env('ALI_PUBLIC_CERT', ''),
        //根证书
        'alipay_root_cert' => env('ALI_ROOT_CERT', ''),
        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/alipay.log'),
            'level' => 'info',
            'type' => 'daily', // optional, 可选 daily.
            'max_file' => 30,
        ],
        // optional，设置此参数，将进入沙箱模式
//        'mode' => 'dev',
    ],

    'wechat' => [
        // 公众号 APPID
        'app_id' => env('WECHAT_APP_ID', ''),

        // 小程序 APPID
        'miniapp_id' => env('WECHAT_MINIAPP_ID', ''),

        // APP 引用的 appid
        'appid' => env('WECHAT_APPID', ''),

        // 微信支付分配的微信商户号
        'mch_id' => env('WECHAT_MCH_ID', ''),

        // 微信支付异步通知地址
        'notify_url' => env('WECHAT_NOTIFY_URL', ''),

        // 微信支付签名秘钥
        'key' => env('WECHAT_KEY', ''),

        // 客户端证书路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_client' => resource_path('wechat_pay/apiclient_cert.pem'),

        // 客户端秘钥路径，退款、红包等需要用到。请填写绝对路径，linux 请确保权限问题。pem 格式。
        'cert_key' => resource_path('wechat_pay/apiclient_key.pem'),

        // optional，默认 warning；日志路径为：sys_get_temp_dir().'/logs/yansongda.pay.log'
        'log' => [
            'file' => storage_path('logs/wechat.log'),
            //  'level' => 'debug'
            //  'type' => 'single', // optional, 可选 daily.
            //  'max_file' => 30,
        ],

        // optional
        // 'dev' 时为沙箱模式
        // 'hk' 时为东南亚节点
        // 'mode' => 'dev',
    ],
    'ios' => [
        'HealthPlat_1' => 600,
        'HealthPlat_2' => 1200,
        'HealthPlat_3' => 3000,
        'HealthPlat_4' => 6800,
        'HealthPlat_5' => 12800,
        'HealthPlat_6' => 32800,
        'HealthPlat_7' => 64800,
        'HealthPlat_10' => 44800, //会员金额 有上级
        'HealthPlat_11' => 48800, //会员金额 无上级

    ]
];
