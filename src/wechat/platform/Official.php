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

class Official extends Platform
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
        'stable_access_token' => false,
        // 消息接收服务器Token
        'token' => 'itzjj',
        // 消息接收服务器加解密密钥
        'encodingaeskey' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\platform\\service\\official\\';

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
     * 在线获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenOnline()
    {
        // 获取请求结果
        $response = $this->options['stable_access_token'] ? $this->getStableAccessToken() : $this->getGeneralAccessToken();
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseDataResult[0])){
            return $parseResponseDataResult;
        }
        // 获取响应数据
        $accessTokenData = $parseResponseDataResult[0];
        // 返回请求结果
        return [[
            'access_token' => $accessTokenData['access_token'],
            'expires_in' => $accessTokenData['expires_in'],
        ], null];
    }

    /**
     * 在线获取普通接口调用凭证
     * @access protected
     * @return string
     */
    protected function getGeneralAccessToken()
    {
        // 接口请求地址
        $requestUrl = 'https://api.weixin.qq.com/cgi-bin/token';
        // 参数
        $query = [
            'grant_type' => 'client_credential',
            'appid' => $this->options['appid'],
            'secret' => $this->options['appsecret'],
        ];
        // 获取请求结果
        return HttpClient::get($requestUrl, $query);
    }

    /**
     * 在线获取稳定版接口调用凭证
     * @access protected
     * @return string
     */
    protected function getStableAccessToken()
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
            'Content-Type' => 'application/json',
        ];
        // 获取请求结果
        return HttpClient::post($requestUrl, $data, $header);
    }
}