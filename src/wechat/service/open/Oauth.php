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
     * 通过 code 获取 AccessToken 和 openid
     * @access public
     * @param string $code 授权Code值，不传则取GET参数
     * @return array
     */
    public function getOauthAccessToken($code = '')
    {
        $appid = $this->platform->getConfig('appid');
        $secret = $this->platform->getConfig('appsecret');
        $code = $code;
        $url = 'https://api.weixin.qq.com/sns/oauth2/access_token';
        $query = [
            'grant_type' => 'authorization_code',
            'appid' => $appid,
            'secret' => $secret,
            'code' => $code,
        ];
        // 获取请求结果
        $response = HttpClient::get($url, $query)->body;
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 成功
        if(!is_null($parseResponseDataResult[0])){
            // 更新token
            $this->platform->updateAccessToken($parseResponseDataResult[0]);
        }
        // 返回结果
        return $parseResponseDataResult;
    }

    /**
     * 刷新AccessToken并续期
     * @access public
     * @param string $refreshToken
     * @return array
     */
    public function getOauthRefreshToken($refreshToken)
    {
        $appid = $this->platform->getConfig('appid');
        $url = 'https://api.weixin.qq.com/sns/oauth2/refresh_token';
        $query = [
            'grant_type' => 'refresh_token',
            'appid' => $appid,
            'refresh_token' => $refreshToken,
        ];
        // 获取请求结果
        $response = HttpClient::get($url, $query)->body;
        // 获取解析结果
        $parseResponseDataResult = $this->parseResponseData($response);
        // 成功
        if(!is_null($parseResponseDataResult[0])){
            // 更新token
            $this->platform->updateAccessToken($parseResponseDataResult[0]);
        }
        // 返回结果
        return $parseResponseDataResult;
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
        // 如果为空
        if(empty($accessToken)){
            $accessToken = 'ACCESS_TOKEN';
        }
        // 请求地址
        $url = "https://api.weixin.qq.com/sns/auth?access_token={$accessToken}&openid={$openid}";
        // 如果传入了access_token，则直接使用
        if ($accessToken != 'ACCESS_TOKEN') {
            // 获取请求结果
            $response = HttpClient::get($url)->body;
            // 返回解析
            return $this->parseResponseData($response);
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
        // 如果为空
        if(empty($accessToken)){
            $accessToken = 'ACCESS_TOKEN';
        }
        // 请求地址
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$accessToken}&openid={$openid}&lang={$lang}";
        // 如果传入了access_token，则直接使用
        if ($accessToken != 'ACCESS_TOKEN') {
            // 获取请求结果
            $response = HttpClient::get($url)->body;
            // 返回解析
            return $this->parseResponseData($response);
        }
        // 使用当前Token
        return $this->platform->callGetApi($url);
    }
}
