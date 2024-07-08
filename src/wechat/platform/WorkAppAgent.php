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
        // 所属第三方应用平台名称
        'suite_platform' => '',
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
     * 所属第三方应用套件平台实例
     * @var string
     */
    protected $suitePlatform;

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

    /**
     * 获取应用授权信息
     * @access public
     * @return array
     */
    public function getAuthInfo()
    {
        // 获取第三方应用平台实例
        $suitePlatform = $this->getSuitePlatform();
        // 获取第三方应用平台实例失败
        if(is_null($suitePlatform)){
            return [null, new \Exception('所属第三方应用套件平台实例获取失败')];
        }
        // 授权方corpid
        $authCorpid = $this->options['corpid'];
        // 授权方企业永久授权码
        $permanentCode = $this->options['corpsecret'];
        // 返回
        return $suitePlatform->service('app_auth', true)->getAuthInfo($authCorpid, $permanentCode);
    }

    /**
     * 获取第三方应用平台实例
     * @access protected
     * @return array
     */
    protected function getSuitePlatform()
    {
        // 如果当前第三方应用套件平台实例为空且配置了第三方应用套件平台参数
        if(is_null($this->suitePlatform) && !empty($this->options['suite_platform'])){
            // 获取平台配置
            $platform = $this->options['suite_platform'];
            $this->suitePlatform = $platform instanceof WorkSuiteThird ? $platform : Wechat::platform($platform);
        }
        // 返回
        return $this->suitePlatform;
    }
}