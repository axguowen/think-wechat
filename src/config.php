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
            // 消息接收服务器Token
            'token' => '',
            // 消息接收服务器加解密密钥
            'encodingaeskey' => '',
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
        ],
        // 企业微信服务商第三方应用(或代开发应用模板)
        'work_suite' => [
            // 驱动类型
            'type' => 'WorkSuite',
            // 第三方应用id或者代开发应用模板id
            'suite_id' => '',
            // 第三方应用secret 或者代开发应用模板secret
            'suite_secret' => '',
            // 企业微信后台推送的ticket
            'suite_ticket' => '',
        ],
        // 企业微信企业内部开发
        'work_internal' => [
            // 驱动类型
            'type' => 'WorkInternal',
            // 企业ID
            'corpid' => '',
            // 自建应用的凭证密钥
            'corpsecret' => '',
        ],
        // 企业微信第三方应用开发
        'work_external' => [
            // 驱动类型
            'type' => 'WorkExternal',
            // 第三方应用凭证, 在获取永久授权码时需要传入
            'suite_access_token' => '',
            // 授权方corpid
            'auth_corpid' => '',
            // 授权方企业永久授权码
            'permanent_code' => '',
        ],
        // 企业微信服务商代开发
        'work_agent' => [
            // 驱动类型
            'type' => 'WorkAgent',
            // 企业ID
            'corpid' => '',
            // 应用的凭证密钥, 即获取到的代开发授权应用的secret
            'corpsecret' => '',
        ],
    ],
];
