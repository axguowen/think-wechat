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

namespace think\wechat\platform;

use think\wechat\Platform;
use think\wechat\utils\HttpClient;
use think\wechat\utils\Tools;

/**
 * 企业微信服务商平台
 */
class WorkProvider extends Platform
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 服务商的corpid
        'corpid' => '',
        // 服务商的secret
        'provider_secret' => '',
        // 接收消息时的校验Token
        'token' => '',
        // 消息加解密密钥
        'encoding_aes_key' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\work\\provider\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'work_provider_access_token_' . $this->options['corpid'];
    }

    /**
     * 在线获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 接口请求地址
        $requestUrl = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_provider_token';
        // 参数
        $data = Tools::arr2json([
            'corpid' => $this->options['corpid'],
            'provider_secret' => $this->options['provider_secret'],
        ]);
        // 请求头
        $header = [
            'Content-Type' => 'application/json',
        ];
        // 获取稳定接口调用凭证请求结果
        $response = HttpClient::post($requestUrl, $data, $header);
        // 获取解析结果
        $parseResponseResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseResult[0])){
            return $parseResponseResult;
        }
        $accessTokenData = $parseResponseResult[0];
        // 返回
        return [[
            'access_token' => $accessTokenData['provider_access_token'],
            'expires_in' => $accessTokenData['expires_in'],
        ], null];
    }
}