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

namespace think\wechat\service\work\contract\app;

use think\wechat\Service;

/**
 * 身份验证服务
 */
class Oauth extends Service
{
    // +=======================
    // | 网页授权登录
    // +=======================
    /**
     * Oauth 授权跳转接口
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param int $agentid 应用agentid
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $scope 授权类类型(可选值snsapi_base|snsapi_userinfo)
     * @return string
     */
    public function getOauthRedirect($redirectUri, $agentid, $state = '', $scope = 'snsapi_base')
    {
        $appid = $this->platform->getConfig('corpid');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        return "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$suiteId}&agentid={$agentid}&redirect_uri={$redirectUri}&response_type=code&scope={$scope}&state={$state}#wechat_redirect";
    }

    /**
     * 获取访问用户身份
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getUserInfo($code)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/auth/getuserinfo?access_token=ACCESS_TOKEN&code={$code}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取家校访问用户身份 
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getSchoolUserInfo($code)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/school/getuserinfo?access_token=ACCESS_TOKEN&code={$code}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 获取访问用户敏感信息
     * @access public
     * @param string $userTicket 成员票据
     * @return array
     */
    public function getUserDetail($userTicket)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/auth/getuserdetail?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['user_ticket' => $userTicket]);
    }

    // +=======================
    // | 企业微信Web登录
    // +=======================
    /**
     * 构造企业微信登录链接
     * @access public
     * @param string $redirectUri 授权回跳地址
     * @param string $state 为重定向后会带上state参数(填写a-zA-Z0-9的参数值，最多128字节)
     * @param string $lang 语言类型, zh中文, en英文
     * @return string
     */
    public function getWebLoginUrl($redirectUri, $state = '', $lang = 'zh')
    {
        $suiteId = $this->platform->getConfig('suite_id');
        // 如果未编码
        if(!preg_match('/^http(s)?%3A%2F%2F/', $redirectUri)){
            $redirectUri = urlencode($redirectUri);
        }
        return "https://login.work.weixin.qq.com/wwlogin/sso/login?login_type=ServiceApp&appid={$suiteId}&redirect_uri={$redirectUri}&state={$state}";
    }

    /**
     * 获取登录用户身份
     * @access public
     * @param string $code 授权Code值
     * @return array
     */
    public function getLoginUserInfo($code)
    {
        return $this->getUserInfo($code);
    }
}
