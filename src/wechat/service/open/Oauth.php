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

namespace think\wechat\service\open;

use think\wechat\Service;
use axguowen\HttpClient;

/**
 * 微信网页授权
 */
class Oauth extends Service
{
    /**
     * Oauth 授权跳转接口
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型(可选值snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOauthRedirect($redirectUri, $state = '', $scope = 'snsapi_base')
    {
        $appid = $this->platform->getConfig('appid');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        $redirectUri = urlencode($redirectUri);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * Oauth 授权二维码接口
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型(可选值snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOauthQrcode($redirectUri, $state = '', $scope = 'snsapi_login')
    {
        $appid = $this->platform->getConfig('appid');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        $redirectUri = urlencode($redirectUri);
        return "https://open.weixin.qq.com/connect/qrconnect?appid={$appid}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * 通过 code 获取 AccessToken 和 openid
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getAccessToken($code)
    {
        $appid = $this->platform->getConfig('appid');
        $secret = $this->platform->getConfig('appsecret');
        $query = [
            'grant_type' => 'authorization_code',
            'appid' => $appid,
            'secret' => $secret,
            'code' => $code,
        ];
        $requestUrl = 'https://api.weixin.qq.com/sns/oauth2/access_token?' . http_build_query($query);
        // 获取请求结果
        $response = HttpClient::get($requestUrl)->body;
        // 返回结果
        return $this->platform->parseResponseData($response);
    }

    /**
     * 刷新AccessToken并续期
     * @access public
     * @param string $refreshToken
     * @return array
     */
    public function refreshAccessToken($refreshToken)
    {
        $appid = $this->platform->getConfig('appid');
        $query = [
            'grant_type' => 'refresh_token',
            'appid' => $appid,
            'refresh_token' => $refreshToken,
        ];
        $requestUrl = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?' . http_build_query($query);
        // 获取请求结果
        $response = HttpClient::get($requestUrl)->body;
        // 返回结果
        return $this->platform->parseResponseData($response);
    }

    /**
     * 检验授权凭证（access_token）是否有效
     * @access public
     * @param string $openid 用户的唯一标识
     * @param string $accessToken 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * @return array
     */
    public function checkAccessToken($openid, $accessToken)
    {
        // 请求地址
        $requestUrl = "https://api.weixin.qq.com/sns/auth?access_token={$accessToken}&openid={$openid}";
        // 获取请求结果
        $response = HttpClient::get($requestUrl)->body;
        // 返回解析
        return $this->platform->parseResponseData($response);
    }

    /**
     * 拉取用户信息(需scope为 snsapi_userinfo)
     * @access public
     * @param string $openid 用户的唯一标识
     * @param string $accessToken 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * @param string $lang 返回国家地区语言版本，zh_CN 简体，zh_TW 繁体，en 英语
     * @return array
     */
    public function getUserInfo($openid, $accessToken, $lang = 'zh_CN')
    {
        // 请求地址
        $requestUrl = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}&lang={$lang}";
        // 获取请求结果
        $response = HttpClient::get($requestUrl)->body;
        // 返回解析
        return $this->platform->parseResponseData($response);
    }

    /**
     * 通过Code获取已授权用户的信息
     * @param string $code code参数
     * @return string
     */
    public function getUserInfoByCode($code)
    {
        // 通过 code 获取 AccessToken 和 openid
        $getAccessTokenResult = $this->getAccessToken($code);
        // 失败
        if(is_null($getAccessTokenResult[0])){
            return $getAccessTokenResult;
        }
        // 获取accesstoken信息
        $accessInfo = $getAccessTokenResult[0];
        // 根据AccessToken获取微信用户信息
        $getUserInfoResult = $this->getUserInfo($accessInfo['access_token'], $accessInfo['openid']);
        // 失败
        if(is_null($getUserInfoResult[0])){
            return $getUserInfoResult;
        }
        // 获取用户信息数据
        $userInfo = $getUserInfoResult[0];
        // 返回
        return [['access_info' => $accessInfo, 'user_info' => $userInfo], null];
    }
}
