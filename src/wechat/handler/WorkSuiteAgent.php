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
use think\wechat\utils\ErrcodeWork;
use axguowen\HttpClient;

/**
 * 企业微信服务商代开发应用模板
 */
class WorkSuiteAgent extends Base
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
        // 接收消息时的校验Token
        'token' => '',
        // 消息加解密密钥
        'encoding_aes_key' => '',
        // 是否是调试模式
        'debug_mode' => false,
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\work\\suiteagent\\';

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
     * 强制获取接口调用凭证
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
            'Content-Type' => 'application/json; charset=utf-8',
        ];
        // 获取接口调用凭证请求结果
        $response = HttpClient::post($requestUrl, $data, $header)->body;
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

    /**
     * 输出失败信息
     * @access protected
     * @param array $responseData
     * @return mixed
     */
    protected function buildErrorMessage(array $responseData)
    {
        // 如果是成功或者是调试模式
        if(!is_null($responseData[0]) || $this->options['debug_mode']){
            // 直接返回
            return $responseData;
        }
        // 获取错误代码
        $errorCode = $responseData[1]->getCode();
        // 如果是空
        if(empty($errorCode)){
            // 直接返回
            return $responseData;
        }
        // 如果存在错误信息
        if(isset(ErrcodeWork::$message[$errorCode])){
            // 返回对应错误信息
            return [null, new \Exception('接口错误信息: ' . ErrcodeWork::$message[$errorCode] . ', 错误码: ' . $errorCode, $errorCode)];
        }
        // 返回
        return $responseData;
    }
}