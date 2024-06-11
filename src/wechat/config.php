<?php
// +----------------------------------------------------------------------
// | ThinkPHP Wechat [Simple Wechat Development Kit For ThinkPHP]
// +----------------------------------------------------------------------
// | ThinkPHP 微信开发工具包
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: axguowen <axguowen@qq.com>
// +----------------------------------------------------------------------

return [
    // 默认平台
    'default' => 'official',
    // 平台配置
    'platforms' => [
        // 公众号平台
        'official' => [
            // 驱动类型
            'type' => 'Official',
            // 开发者ID
            'appid' => '',
            // 开发者密码
            'appsecret' => '',
            // 是否使用稳定版接口调用凭证
            'stable_access_token' => false,
            // 接收消息时的校验Token
            'token' => '',
            // 消息加解密密钥
            'encoding_aes_key' => '',
        ],
        // 开放平台
        'open' => [
            // 驱动类型
            'type' => 'Open',
            // 应用ID
            'appid' => '',
            // 应用密钥
            'appsecret' => '',
        ],
        // 小程序
        'mini' => [
            // 驱动类型
            'type' => 'Mini',
            // 小程序ID
            'appid' => '',
            // 小程序密钥
            'appsecret' => '',
            // 是否使用稳定版接口调用凭证
            'stable_access_token' => false,
        ],
        // 企业微信服务商
        'work_provider' => [
            // 驱动类型
            'type' => 'WorkProvider',
            // 服务商的corpid
            'corpid' => '',
            // 服务商的secret
            'provider_secret' => '',
            // 接收消息时的校验Token
            'token' => '',
            // 消息加解密密钥
            'encoding_aes_key' => '',
        ],
        // 企业微信服务商第三方应用
        'work_suite_third' => [
            // 驱动类型
            'type' => 'WorkSuiteThird',
            // 第三方应用id
            'suite_id' => '',
            // 第三方应用secret
            'suite_secret' => '',
            // 企业微信后台推送的ticket
            'suite_ticket' => '',
            // 接收消息时的校验Token
            'token' => '',
            // 消息加解密密钥
            'encoding_aes_key' => '',
        ],
        // 企业微信服务商代开发应用模板
        'work_suite_agent' => [
            // 驱动类型
            'type' => 'WorkSuiteAgent',
            // 代开发应用模板id
            'suite_id' => '',
            // 代开发应用模板secret
            'suite_secret' => '',
            // 企业微信后台推送的ticket
            'suite_ticket' => '',
            // 接收消息时的校验Token
            'token' => '',
            // 消息加解密密钥
            'encoding_aes_key' => '',
        ],
        // 企业微信自建应用
        'work_app_self' => [
            // 驱动类型
            'type' => 'WorkAppSelf',
            // 企业ID
            'corpid' => '',
            // 自建应用的凭证密钥
            'corpsecret' => '',
        ],
        // 企业微信第三方应用
        'work_app_third' => [
            // 驱动类型
            'type' => 'WorkAppThird',
            // 所属第三方应用平台名称
            'suite_platform' => 'work_suite_third',
            // 授权方corpid
            'auth_corpid' => '',
            // 授权方企业永久授权码
            'permanent_code' => '',
        ],
        // 企业微信服务商代开发应用
        'work_app_agent' => [
            // 驱动类型
            'type' => 'WorkAppAgent',
            // 企业ID
            'corpid' => '',
            // 应用的凭证密钥, 即获取到的代开发授权应用的secret
            'corpsecret' => '',
        ],
    ],
];
