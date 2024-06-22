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
 * 企业微信服务商代开发应用
 */
class WorkAppAgent extends Platform
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 企业ID
        'corpid' => '',
        // 应用的凭证密钥, 即获取到的代开发授权应用的secret
        'corpsecret' => '',
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\work\\appagent\\';

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'work_app_access_token_' . $this->options['corpsecret'];
    }

    /**
     * 强制获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 企业微信corpid
        $corpid = $this->options['corpid'];
        // 企业微信自建应用secret
        $corpsecret = $this->options['corpsecret'];
        // 接口请求地址
        $requestUrl = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$appid}&corpsecret={$corpsecret}";
        
        // 获取接口调用凭证请求结果
        $response = HttpClient::get($requestUrl)->body;
        // 获取解析结果
        $parseResponseResult = $this->parseResponseData($response);
        // 失败
        if(is_null($parseResponseResult[0])){
            return $parseResponseResult;
        }
        $accessTokenData = $parseResponseResult[0];
        // 返回
        return [[
            'access_token' => $accessTokenData['access_token'],
            'expires_in' => $accessTokenData['expires_in'],
        ], null];
    }
}