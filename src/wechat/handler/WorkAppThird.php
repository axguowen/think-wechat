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

use think\facade\Wechat;
use think\wechat\Platform;
use think\wechat\utils\Tools;
use think\wechat\utils\ErrcodeWork;

/**
 * 企业微信第三方应用
 */
class WorkAppThird extends Base
{
	/**
     * 平台配置参数
     * @var array
     */
    protected $options = [
        // 所属第三方应用平台名称
        'suite_platform' => '',
        // 授权方corpid
        'auth_corpid' => '',
        // 授权方企业永久授权码
        'permanent_code' => '',
        // 是否是调试模式
        'debug_mode' => false,
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\work\\appthird\\';

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
        return 'work_app_access_token_' . $this->options['permanent_code'];
    }

    /**
     * 强制获取接口调用凭证
     * @access protected
     * @return array
     */
    protected function getAccessTokenForce()
    {
        // 获取第三方应用平台实例
        $suitePlatform = $this->getSuitePlatform();
        // 获取第三方应用平台实例失败
        if(is_null($suitePlatform)){
            return [null, new \Exception('所属第三方应用套件平台实例获取失败')];
        }
        // 授权方corpid
        $authCorpid = $this->options['auth_corpid'];
        // 授权方企业永久授权码
        $permanentCode = $this->options['permanent_code'];
        // 获取企业凭证
        $getCorpTokenResult = $suitePlatform->service('app_auth', true)->getCorpToken($authCorpid, $permanentCode);
        // 失败
        if(is_null($getCorpTokenResult[0])){
            return $getCorpTokenResult;
        }
        // 企业凭证数据
        $accessTokenData = $getCorpTokenResult[0];
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
        $authCorpid = $this->options['auth_corpid'];
        // 授权方企业永久授权码
        $permanentCode = $this->options['permanent_code'];
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
            $this->suitePlatform = $platform instanceof Platform ? $platform : Wechat::platform($platform);
        }
        // 返回
        return $this->suitePlatform;
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