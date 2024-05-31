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
    protected $serviceNamespace = '\\think\\wechat\\platform\\service\\mini\\';

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
     * 在线获取接口调用凭证
     * @access protected
     * @param array $options 配置参数
     * @return array
     */
    protected function getAccessTokenOnline(array $options = [])
    {
        // 如果使用稳定版接口调用凭证
        if($this->options['stable_access_token']){
            // 获取请求结果
            $response = $this->getStableAccessToken();
            // 返回解析结果
            return $this->parseResponseData($response);
        }
        // 获取稳定接口调用凭证请求结果
        $response = $this->getGeneralAccessToken();
        // 返回解析结果
        return $this->parseResponseData($response);
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