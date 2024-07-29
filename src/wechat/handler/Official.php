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

namespace think\wechat\handler;

use think\wechat\utils\Tools;
use axguowen\HttpClient;

/**
 * 微信公众号平台
 */
class Official extends Base
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 开发者ID
        'appid' => '',
        // 开发者密码
        'appsecret' => '',
        // 是否使用稳定版接口调用凭证
        'use_stable_access_token' => false,
        // 接收消息时的校验Token
        'token' => '',
        // 消息加解密密钥
        'encoding_aes_key' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\official\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'official_access_token_' . $this->options['appid'];
    }

    /**
     * 强制重新获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 如果使用稳定版接口调用凭证
        if($this->options['use_stable_access_token']){
            // 获取请求结果
            $response = $this->forceStableAccessToken();
            // 返回解析结果
            return $this->parseResponseData($response);
        }
        // 获取稳定接口调用凭证请求结果
        $response = $this->forceGeneralAccessToken();
        // 返回解析结果
        return $this->parseResponseData($response);
    }

    /**
     * 强制重新获取普通接口调用凭证
     * @access protected
     * @return string
     */
    protected function forceGeneralAccessToken()
    {
        $appid = $this->options['appid'];
        $secret = $this->options['appsecret'];
        // 接口请求地址
        $requestUrl = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$appid}&secret={$secret}";
        // 获取请求结果
        return HttpClient::get($requestUrl)->body;
    }

    /**
     * 强制重新获取稳定版接口调用凭证
     * @access protected
     * @return string
     */
    protected function forceStableAccessToken()
    {
        // 接口请求地址
        $requestUrl = 'https://api.weixin.qq.com/cgi-bin/stable_token';
        // 参数
        $data = Tools::arr2json([
            'grant_type' => 'client_credential',
            'appid' => $this->options['appid'],
            'secret' => $this->options['appsecret'],
        ]);
        // 请求头
        $header = [
            'Content-Type' => 'application/json; charset=utf-8',
        ];
        // 获取请求结果
        return HttpClient::post($requestUrl, $data, $header)->body;
    }
}