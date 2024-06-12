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

namespace think\wechat\service\work\appself;

use think\wechat\service\work\contract\app\Oauth as Service;

/**
 * 身份验证服务
 */
class Oauth extends Service
{
    // +=======================
    // | 二次验证
    // +=======================
    /**
     * 获取用户二次验证信息
     * @access public
     * @param string $code 用户进入二次验证页面时，企业微信颁发的code
     * @return string
     */
    public function getTfaInfo($code)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/auth/get_tfa_info?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['code' => $code]);
    }

    /**
     * 登录二次验证
     * @access public
     * @param string $userid 成员UserID
     * @return array
     */
    public function userAuthsucc($userid)
    {
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/authsucc?access_token=ACCESS_TOKEN&userid={$userid}";
        return $this->platform->callGetApi($url);
    }

    /**
     * 使用二次验证
     * @access public
     * @param string $userid 成员UserID
     * @param string $tfaCode 成员UserID
     * @return string
     */
    public function userTfaSucc($userid, $tfaCode)
    {
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/user/tfa_succ?access_token=ACCESS_TOKEN';
        return $this->platform->callPostApi($url, ['userid' => $userid, 'tfa_code' => $tfaCode]);
    }
}