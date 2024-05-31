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

namespace think\wechat\platform\service\open;

use think\wechat\utils\HttpClient;
use think\wechat\exception\InvalidResponseException;

/**
 * 微信网页授权
 */
class Oauth extends Base
{
    /**
     * Oauth 授权跳转接口
     * @access public
     * @param string $redirectUrl 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型(可选值snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOauthRedirect($redirectUrl, $state = '', $scope = 'snsapi_base')
    {
        $appid = $this->platform->options['appid'];
        $redirect_uri = urlencode($redirectUrl);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirect_uri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @access public
     * @param string $openid 用户的唯一标识
     * @param string $accessToken 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * @return array
     */
    public function checkOauthAccessToken($openid, $accessToken = 'ACCESS_TOKEN')
    {
        // 请求地址
        $url = "https://api.weixin.qq.com/sns/auth?access_token={$accessToken}&openid={$openid}";
        // 如果传入了access_token，则直接使用
        if (!empty($accessToken) && $accessToken != 'ACCESS_TOKEN') {
            // 获取解析结果
            $result = json_decode(HttpClient::get($url), true);
            // 不是数组
            if(!is_array($result)){
                return [null, new InvalidResponseException('Invalid response.')];
            }
            return [$result, null];
        }
        // 使用当前Token
        return $this->platform->callGetApi($url);
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * @access public
     * @param string $openid 用户的唯一标识
     * @param string $accessToken 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return array
     */
    public function getUserInfo($openid, $accessToken = 'ACCESS_TOKEN', $lang = 'zh_CN')
    {
        // 请求地址
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}&lang={$lang}";
        // 如果传入了access_token，则直接使用
        if (!empty($accessToken) && $accessToken != 'ACCESS_TOKEN') {
            // 获取解析结果
            $result = json_decode(HttpClient::get($url), true);
            // 不是数组
            if(!is_array($result)){
                return [null, new InvalidResponseException('Invalid response.')];
            }
            return [$result, null];
        }
        // 使用当前Token
        return $this->platform->callGetApi($url);
    }
}
