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

namespace think\wechat\platform\contract;

use think\wechat\Platform;
use think\wechat\utils\HttpClient;
use think\wechat\utils\Tools;

/**
 * 企业微信服务商应用套件基础类
 */
class WorkSuite extends Platform
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 第三方应用id或者代开发应用模板id
        'suite_id' => '',
        // 第三方应用secret 或者代开发应用模板secret
        'suite_secret' => '',
        // 企业微信后台推送的ticket
        'suite_ticket' => '',
    ];

    /**
     * 获取接口调用凭证缓存键名
     * @access protected
     * @return string
     */
    protected function getAccessCacheKey()
    {
        return 'work_suite_access_token_' . $this->options['suite_id'];
    }

    /**
     * 在线获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 接口请求地址
        $requestUrl = 'https://qyapi.weixin.qq.com/cgi-bin/service/get_suite_token';
        // 参数
        $data = Tools::arr2json([
            'suite_id' => $this->options['suite_id'],
            'suite_secret' => $this->options['suite_secret'],
            'suite_ticket' => $this->options['suite_ticket'],
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
            'access_token' => $accessTokenData['suite_access_token'],
            'expires_in' => $accessTokenData['expires_in'],
        ], null];
    }
}