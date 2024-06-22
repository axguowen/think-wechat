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
use think\wechat\utils\Tools;
use axguowen\HttpClient;

/**
 * 微信小程序平台
 */
class Mini extends Platform
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 小程序ID
        'appid' => '',
        // 小程序密钥
        'appsecret' => '',
        // 是否使用稳定版接口调用凭证
        'stable_access_token' => false,
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\mini\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'mini_access_token_' . $this->options['appid'];
    }

    /**
     * 强制重新获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 如果使用稳定版接口调用凭证
        if($this->options['stable_access_token']){
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
        // 接口请求地址
        $requestUrl = 'https://api.weixin.qq.com/cgi-bin/token';
        // 参数
        $query = [
            'grant_type' => 'client_credential',
            'appid' => $this->options['appid'],
            'secret' => $this->options['appsecret'],
        ];
        // 获取请求结果
        return HttpClient::get($requestUrl, $query)->body;
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