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

use think\Wechat;
use think\wechat\Platform;
use think\wechat\utils\Tools;

/**
 * 企业微信第三方应用
 */
class WorkAppThird extends Platform
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
    ];

    /**
     * 服务的命名空间
     * @var string
     */
    protected $serviceNamespace = '\\think\\wechat\\service\\work\\appthird\\';

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
        $getSuitePlatformResult = $this->getSuitePlatform();
        // 获取第三方应用平台实例失败
        if(is_null($getSuitePlatformResult[0])){
            return $getSuitePlatformResult;
        }
        $suitPlatform = $getSuitePlatformResult[0];
        // 授权方corpid
        $authCorpid = $this->options['auth_corpid'];
        // 授权方企业永久授权码
        $permanentCode = $this->options['permanent_code'];
        // 获取企业凭证
        $getCorpTokenResult = $suitPlatform->service('app_auth')->getCorpToken($authCorpid, $permanentCode);
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
     * 获取第三方应用平台实例
     * @access protected
     * @return array
     */
    protected function getSuitePlatform()
    {
        // 获取平台
        $platform = $this->options['suite_platform'];
        // 如果是服务商第三方应用对象
        if($platform instanceof WorkSuiteThird){
            // 直接返回
            return [$platform, null];
        }
        // 如果是字符串
        if(is_string($platform) && !empty($platform)){
            try{
                return [Wechat::platform($platform), null];
            }catch (\Exception $e){
                return [null, $e];
            }
        }
        // 返回错误
        return [null, new \Exception('所属第三方应用平台配置不合法')];
    }
}